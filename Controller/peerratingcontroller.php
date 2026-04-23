<?php
class peerratingcontroller
{


    private $peerctrlvar;
    //create a pvt peerctrl variable accessible within this controller file
    private $eventctrlvar;
    private $taskctrlvar;

    public function __construct($peermodel, $eventmodel, $taskmodel)
    {//construct the class peerratingcontroller dependant on the peermodel and eventmodel
        $this->peerctrlvar = $peermodel;
        $this->eventctrlvar = $eventmodel;//will not use unless essential as it refers to another component(error prone)
        $this->taskctrlvar = $taskmodel;
        //$this->peerctrlvar, $this->eventctrlvar, and $this->taskctrlvar are references to the model objects passed in
        //only models are meant to be shared
    }

    public function generatepeerratingassignments($eventId)
    {//generate all peer rating assignments for an event
        //called when the rating period opens after event completes   
        try {
            $tasklist = $this->peerctrlvar->gettasksofevent($eventId);//returns an assoc array of task_id=>task_name(task_id, name as task_name)

            if (empty($tasklist)) {
                return [];
            }
            //extract taskIds
            $taskIds = array_column($tasklist, 'task_id');//converts an array of associative arrays into a single array of a certain key type eg:task_id
            //eg:tasklist is something like  ['task_id' => 1, 'task_name' => 'T1'], ['task_id' => 2, 'task_name' => 'T2'] then taskIds will be [1,2]


            $volunteersoftasks = $this->peerctrlvar->getvolunteersintasks($taskIds);
            //format is like
            // [
            //[0] => ['volunteer_id'=>5, 'name'=>'Nadin', 'task_id'=>1]
            //[1] => ['volunteer_id'=>8, 'name'=>'Videesha', 'task_id'=>1]
            //[2] => ['volunteer_id'=>3, 'name'=>'Thivinya', 'task_id'=>2]
            //[3] => ['volunteer_id'=>7, 'name'=>'Chamith', 'task_id'=>3]
            //]
            $volunteersgroupedbytask = [];
            foreach ($volunteersoftasks as $volunteer) {

                $taskId = $volunteer['task_id'];
                if (!isset($volunteersgroupedbytask[$taskId])) {
                    $volunteersgroupedbytask[$taskId] = [];
                }
                $volunteersgroupedbytask[$taskId][] = [
                    'volunteer_id' => $volunteer['volunteer_id'],
                    'name' => $volunteer['name']
                ];//now the volunteers are grouped by taskIds where the taskId acts like the key of assoc array
            }
            foreach ($volunteersgroupedbytask as $taskId => $volunteers) {//split into taskId and its constitutent list of volunteers
                if (count($volunteers) > 5) {
                    $result=$this->generateroundrobin($taskId, $volunteers, $eventId);
                    if(!$result['success']){
                        error_log("Failed to generate assignments for task {$taskId}: {$result['message']}");
                    }
                
                } else {
                    continue;
                }

            }

            return [
            'success' => true,
            'message' => 'Peer rating assignments generated successfully'
        ];


        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error generating assignments:' . $e->getMessage()
            ];
        }



    }

    public function generateroundrobin($taskId, $volunteers, $eventId)
    {
        //each person will only rate 3 others infront
        //now assign rater and ratee roles

        $numvols = count($volunteers);//get number of volunteers
        $totalassignments=0;


        //rotate circularly
        for ($i = 0; $i < $numvols; $i++) {
            $rater = $volunteers[$i];
            //pick the three volunteers infornt
            $ratees = [];
            for ($j = 1; $j <= 3; $j++) {
                $rateeindex = ($i + $j) % $numvols;
                $ratees[] = $volunteers[$rateeindex];
            }
            $success=$this->peerctrlvar->createassignments($rater, $ratees, $eventId);
            
            if($success){
                
            $totalassignments+=count($ratees);

            }

            

        }
        if($totalassignments==0){
            return [

                'success'=>false,
                'message'=>'Failed to create assignments'
            ];
        }

        return [
            'success'=>true,
            'message'=>'Peer rating assignments generated successfully',
            'total_assignments'=>$totalassignments,
            'volunteers_count'=>$numvols
        ];


        

        

    }

    //Render Peer Rating UI

    public function renderpeerrating(){
        $eventId=$_GET['event_id']??null;
        $currentuserId=$_SESSION['user_id']??null;

        if(!$eventId || !$currentuserId){
            return ['success' => false, 'message' => 'Missing event or user'];
            // header("Location: /V/router.php?module=error&action=error1");
        }

        try{
            $eventdetails=$this->peerctrlvar->geteventdetails($eventId);
            
           //check if rating window exists using returned single assoc array
        if (empty($eventdetails['peer_rating_open_until'])) {
            return [
                'success' => false,
                'expired' => false,
                'message' => 'Peer rating has not opened for this event yet'
            ];
        }

        //check if rating window has expired
        if (strtotime($eventdetails['peer_rating_open_until']) < time()) {
            return [
                'success' => false,
                'expired' => true,
                'message' => 'The peer rating window has closed for this event'
            ];
        } 
                        
            $peers=$this->getpeerstorate($currentuserId,$eventId);
            $progress=$this->getratingstatus($currentuserId,$eventId);
            // if(empty($peers)){
            //     return[
            //         'success'=>false,
            //         'peers'=>null//peers is never empty its just that the data is only emtpy it has other parameters
            //     ];
            // }
        
        //make a final associative array
            return[
                'success'=>true,
                'event'=>$eventdetails,
                'peers'=>$peers,
                'progress'=>$progress,
                'window_closes' => $eventdetails['peer_rating_open_until']//not used dead data anyway

            ];
             

        }
        catch(Exception $e){//Exception is a built-in class
            return [
                'success'=>false,
                'message'=>$e->getMessage()
            ];
        }


    }

    public function getpeerstorate($currentuserId,$eventId)
    {//get all people a user should rate i.e. get all peers a user must rate for a given event
     //returns only the pending (not yet rated) assignments
     try{
        //get all assignments for this rater
        $assignments=$this->peerctrlvar->getassignmentsforrater($currentuserId,$eventId);//refer peerratingmodel
        if(empty($assignments)){
            return[
                'success'=>true,
                'data'=>null,//an empty array [] is considered a set value.
                'message'=>'No peer ratings assigned'
            ];
        }
        //get ratings already submitted
        $submittedratings=$this->peerctrlvar->getratingsbyrater($currentuserId,$eventId);
        //$submitted ratings format is (peer_ratingid,ratee_id,peer_rating_score,time_stamp)
        //create set of rated peer Ids for quick lookup
        $ratedpeerIds=array_column($submittedratings,'ratee_id');

        //filter pending assignments where pendingpeers has peers(ratees) not yet rated
        $pendingpeers=array_filter($assignments,function($assignment) use ($ratedpeerIds){//a closure function importing $ratedpeerIds from outside to use inside
            //also $assignments is the full list and each item is passed into the closure as $assignment
            return !in_array($assignment['ratee_id'],$ratedpeerIds);//keep this assignment only if this ratee_id NOT in the list of already-rated peers
        });

        //format response
        $pendingpeers=array_values($pendingpeers);//reindex array + make it neat

        return[
            'success'=>true,
            'data'=>$pendingpeers,//the $pendingpeers array keeps the same structure as $assignments, because array_filter() doesn’t change the items, it only removes some
            'count'=>count($pendingpeers),
            'total_assignments'=>count($assignments),
            'completed_count'=>count($submittedratings),
            'completion_percentage'=>count($assignments)>0 ? round((count($submittedratings)/count($assignments))*100,1) :0
        ];




     } catch(Exception $e){
        return [
            'success'=>false,
            'message'=>'Error retrieving peers to rate'. $e->getMessage()
        ];
     }
          
    }







    
    public function getratingstatus($currentuserId,$eventId)
    {   //get rating status for user (completed/pending)
        //get rating status/progress for a user
        try{


            $assignments=$this->peerctrlvar->getassignmentsforrater($currentuserId,$eventId);//get all assignments for a rater in an event
            $submitted=$this->peerctrlvar->getratingsbyrater($currentuserId,$eventId);//get all ratings submitted by a user
            $total=count($assignments);
            $completed=count($submitted);
            $pending=$total-$completed;
            return[
                'total'=>$total,
                'completed'=>$completed,
                'pending'=>$pending,
                'percentage'=>$total>0 ? round(($completed/$total)*100,1):0,
                'is_complete'=>$total> 0 ? $pending === 0 : false   //a task or individual with 0  tasks or assignments , is_complete will never be true, 
                                                                    //so , so iscomplete being true automatically signals that tasks or  peers exist and rating them is done so by that we can hide stuff

            ];

        }catch(Exception $e){
            return[
                'total'=>0,
                'completed'=>0,
                'pending'=>0,
                'percentage'=>0,
                'is_complete'=>false,
                'error'=>$e->getMessage()
            ];

        }
       
    
    }

    public function submitpeerrating()
    {//allow raters to rate the peers and record that in the DB
        //handles submission of peer rating thruh AJAX (client side JS fetch() sends a POST request here with rating info)
        header ('Content-Type:application/json');//tells the browser that the server is sending JSON data not HTML
        //JSON response header(tells browser that all RESPONSES from this method are JSON not HTML)
        //so fetch().then(response => response.json()) on the JS side will work
        try{
            $assignmentId=$_POST['assignment_id']??null;
            $rateeId=$_POST['ratee_id']??null;
            $rating=$_POST['rating']??null;
            $comment=$_POST['comment']??null;
            $raterId=$_SESSION['user_id']??null;
            //Gets values sent via JS FormData + ?? null ensures a default null if the key isn’t present
            //validate inputs
            if(!$raterId||!$assignmentId||!$rateeId||!$rating){
                echo json_encode([
                    'success'=>false,
                    'message'=>'Missing required data'
                ]);
                return;//checks that all necessary data is present + If not, sends JSON back with success=false
            }
            //validate rating range (1-5)[is between 1 and 5 only]
            if($rating<1||$rating>5){//JSON is lightweight data format used for sending data between frontend ↔ backend
                echo json_encode([
                    'success'=>false,
                    'message'=>'Invalid rating value'
                ]);
                return;
            }
            //get event_id from assignment + check if assignment exists
            $assignment=$this->peerctrlvar->getassignmentbyid($assignmentId);//get assignment with considered assignmentId from model
            if(!$assignment){
                echo json_encode([//json_encode() = PHP function that converts a PHP array into JSON(JSON format is {"success":true,"message":"Rating saved"})
                    'success'=>false,
                    'message'=>'Assignment not found'
                ]);
                return;
            }
            //if assignment is there
            $eventId=$assignment['event_id'];
            //check if already rated + checks if the user(rater) already rated this volunteer for this event + if yes, returns success=false
            $exists=$this->peerctrlvar->hasalreadyrated($raterId,$rateeId,$eventId);
            if($exists){
                echo json_encode([
                    'success'=>false,
                    'message'=>'You have already rated this volunteer'
                ]);
                return;
            }
            //create rating if all validation is checked and saves the rating and optional comment in the database
            $result=$this->peerctrlvar->createpeerrating($raterId,$rateeId,$eventId,$rating,$comment);
            if($result){
                //update assignment status
                $this->peerctrlvar->updateassignmentstatus($assignmentId,'completed');//marks the assignment as completed after successful rating
                echo json_encode([
                    'success'=>true,
                    'message'=>'Rating submitted successfully'
                ]);

            }else{
                echo json_encode([
                    'success'=>false,
                    'message'=>'Failed to save rating'


                ]);
            }//JS fetch() then gets this JSON and updates the UI

        }catch(Exception $e){//catches any unexpected error and sends it back as JSON
            echo json_encode([
                'success'=>false,
                'message'=>'Error: ' .$e->getMessage() 
            ]);
        }

    }















}

?>