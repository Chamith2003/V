<?php
class peerratingmodel
{//used dependancy injection (DI)
    private $modelvar;//only accessible inside this class + made pvt to avoid accidental breaking of database connection
    public function __construct($conn)//accepts one parameter which is the database connection + made public to instantiate from outside
    {   //get the $conn and give that to $modelvar to be used throughout php file
        //the $conn dissappears outside constructor function
        $this->modelvar = $conn;//here there is no $ in modelvar as if we use $, php will try to find something that takes the value of what is inside variable $modelvar
        //now modelvar holds the database connection
    }

    public function gettasksofevent($eventId)
    {//get all tasks in the given event
        $stmt = $this->modelvar->prepare("
        SELECT task_id, name as task_name
        FROM task
        WHERE event_id=?
        ");
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getvolunteersintasks($taskIds)
    {//get all the volunteers from a list of taskIds
        if (empty($taskIds)) {
            //return empty if no task Ids
            return [];
        }
        //create dynamic placeholders(?) eg:  $taskIds=[3,7,10] then $placeholders= (?,?,?)
        //create an array full of ? symbols having same length as $taskIds  
        //i.e. array_fill() creates N '?' items and implode() turns them into ?,?,?
        //here start index has no significance it is there only if an associative array is needed eg: array_fill(5,3,7);=[5=>'?',6=>'?',7=>'?']
        $placeholders = implode(',', array_fill(0, count($taskIds), '?'));
        $stmt = $this->modelvar->prepare("
            SELECT DISTINCT ta.volunteer_id, u.name, ta.task_id
            FROM task_assignment ta
            JOIN user u on ta.volunteer_id = u.userid
            WHERE ta.task_id IN ($placeholders)
            ORDER BY u.name ASC
            ");//select rows where task_id matches any one of the given values
        $types = str_repeat('i', count($taskIds)); //eg: iii [repeat i "count" times]
        $stmt->bind_param($types, ...$taskIds);//the ... means to expand the array inserting , inbetween
        //eg: $stmt->bind_param(iii,3,7,10) where these numbers will be binded to the '?' marks
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);

        //return format is like
        // [
        //[0] => ['volunteer_id'=>5, 'name'=>'Nadin', 'task_id'=>1]
        //[1] => ['volunteer_id'=>8, 'name'=>'Videesha', 'task_id'=>1]
        //[2] => ['volunteer_id'=>3, 'name'=>'Thivinya', 'task_id'=>2]
        //[3] => ['volunteer_id'=>7, 'name'=>'Chamith', 'task_id'=>3]
        //]
    }

    public function createassignments($rater, $ratees, $eventId)
    {//insert assignments
        if (empty($rater) || empty($ratees)) {
            return false;
        }

        $values = [];
        $types = '';
        $params = [];

        foreach ($ratees as $ratee) {
            
            //check if this specific assignment already exists
            if(!$this->assignmentexists($rater['volunteer_id'],$ratee['volunteer_id'],$eventId)){
            //only add if it doesnt exist
            //each row has 3 values which are event_id, rater_id, ratee_id            
            $values[] = '(?,?,?)';
            $types .= 'iii';
            $params[] = $eventId;
            $params[] = $rater['volunteer_id'];
            $params[] = $ratee['volunteer_id'];
        }
    }//make a continous string of eventId,rater,ratee,eventId,rater1,rateee1,eventId,rater1,ratee2,eventId,rater1,ratee3... 

    if(empty($values)){
        //if all assignments already exist return true as its not an error
        return true;
    }


        $sql = "INSERT INTO peer_rating_assignment
        (event_id,rater_id,ratee_id)
        VALUES " . implode(',', $values);//link all elements of array inserting commas inbetween
        $stmt = $this->modelvar->prepare($sql);
        $stmt->bind_param($types, ...$params);//the ... means to expand the array inserting , inbetween eg:$stmt->bind_param($types, ...$params); turns to $stmt->bind_param($types, 10, 22, 35,...); given that $params = [10, 22, 35,...] like eventId,rater1,ratee1,eventId,rater2,...
        return $stmt->execute();
    }

    public function geteventdetails($eventId)
    {//get all event details of an event and filter based on what you need(done in controller)
        $stmt=$this->modelvar->prepare("
        SELECT * 
        FROM volunteering_program
        WHERE event_id = ?
        ");
        $stmt->bind_param("i",$eventId);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->fetch_assoc();//need only 1 event so no need to fetch all
    }

    public function getassignmentsforrater($raterId,$eventId)
    {//get all assignments for a rater in an event (volunteer list ratable by the rater)

    $stmt=$this->modelvar->prepare("

        SELECT
        pra.assignment_id,pra.ratee_id,u.name as ratee_name,pra.status
        FROM peer_rating_assignment pra 
        JOIN user u ON pra.ratee_id=u.userid
        WHERE pra.rater_id=? AND pra.event_id=?
        ORDER BY  u.name ASC
        ");
        $stmt->bind_param("ii",$raterId,$eventId);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);

    }

    public function getratingsbyrater($raterId,$eventId)
    {//get all ratings submitted by a user(rater) for an EVENT
        $stmt=$this->modelvar->prepare("
        SELECT peer_ratingid,ratee_id,peer_rating_score,time_stamp
        FROM peer_rating
        WHERE rater_id=? AND event_id=?
        ");
        $stmt->bind_param("ii",$raterId,$eventId);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);

    }


    public function getassignmentbyid($assignmentId)
    {//get the single assignment details when Id is given as an input

        $stmt=$this->modelvar->prepare("
        SELECT event_id,rater_id,ratee_id
        FROM peer_rating_assignment
        WHERE assignment_id=?
        ");
        $stmt->bind_param("i",$assignmentId);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->fetch_assoc();

    }



    
    public function hasalreadyrated($raterId,$rateeId,$eventId)
    {//check if user has already rated this person + checks whether a specific rater has already rated a specific volunteer for the same event
        //How many rows exist where rater = X, ratee = Y, event = Z? ==> if 1 or more exist then they already rated
 
        $stmt=$this->modelvar->prepare("
        SELECT COUNT(*) as count
        FROM peer_rating
        WHERE rater_id=? AND ratee_id=? AND event_id=?
        ");
        $stmt->bind_param("iii",$raterId,$rateeId,$eventId);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_assoc();
        return $row['count']>0;//If count is more than 0, return TRUE. Otherwise, return FALSE i.e. If count = 0  then 0 > 0 is false and If count = 1  then 1 > 0 is true 



    }
    

    
    public function createpeerrating($raterId,$rateeId,$eventId,$rating,$comment)
    {//put finalized rating to peer_rating table
        $stmt=$this->modelvar->prepare("
        INSERT INTO peer_rating (rater_id,ratee_id,event_id,peer_rating_score,comment)
        VALUES (?,?,?,?,?)
        ");
        $stmt->bind_param("iiids",$raterId,$rateeId,$eventId,$rating,$comment);
        return $stmt->execute();

    }


    public function updateassignmentstatus($assignmentId,$status)
    {//update assignment to "completed" once it is done
        $stmt=$this->modelvar->prepare("
        UPDATE peer_rating_assignment
        SET status = ?
        WHERE assignment_id = ?
        ");
        $stmt->bind_param("si",$status,$assignmentId);
        return $stmt->execute();

    }


    public function assignmentexists($raterId,$rateeId,$eventId)
    {//check if assignment already exists here COUNT is a standard MYSQL function
        $stmt=$this->modelvar->prepare("
        SELECT COUNT(*) as count
        FROM peer_rating_assignment
        WHERE rater_id=? AND ratee_id=? AND event_id=?
        ");
        $stmt->bind_param("iii",$raterId,$rateeId,$eventId);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_assoc();//$row is an associative array with a single element
        return $row['count']>0;//returns true or false
    }




}



