<?php
class taskratingmodel{
    private $modelvar;
    public function __construct($conn){
        $this->modelvar=$conn;
    }


    public function createtaskrating($taskId, $volunteerId, $raterId, $taskscore,$comment){
        //put the finalized task based ratings into the task_performance_rating table
        $stmt=$this->modelvar->prepare("
            INSERT INTO task_performance_rating(task_id, volunteer_id, rater_id, performance_score,comment)
            VALUES(?,?,?,?,?)                        
            ");
            $stmt->bind_param("iiids",$taskId,$volunteerId,$raterId,$taskscore,$comment);
            return $stmt->execute();
    }

    
    public function geteventdetails($eventId)
    {//get all event details from an event and filter based on what you need(done in controller)
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

    public function gettaskdetails($eventId)
    {//get ALL the tasks and their details from DB
        $stmt=$this->modelvar->prepare("
        SELECT * 
        FROM task 
        WHERE event_id = ?");

        $stmt->bind_param("i",$eventId);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);//here the output format is of several rows(several tasks) of same eventId and in those rows there will be several key value pairs for each column
        //examples for such key value pairs of a single particuliar row (task_id, name, description, status, event_id, max_participants, current_participants, organizer_id, createddate) with their respective values
        //and several such rows are returned. essentially an entire table is returned

    }

    public function getsubmittedtaskratings($eventId,$raterId)
    {//get a list of tasks that are already rated to help calculate the task rating progress (rater=organizer[manager/representative])
        $stmt=$this->modelvar->prepare("
        SELECT tpr.taskratingid,tpr.task_id,tpr.volunteer_id,tpr.performance_score
        FROM task_performance_rating tpr
        INNER JOIN task t ON tpr.task_id = t.task_id
        WHERE t.event_id = ? AND tpr.rater_id = ?
        ");
        $stmt->bind_param("ii",$eventId,$raterId);//here rater is the manager or representative
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);//an entire table is returned
    }

    public function getvolunteersoftask($taskId)
    {//get all the volunteers of a particuliar task
        
         $stmt = $this->modelvar->prepare("
        SELECT v.userid, u.name
        FROM volunteer v
        INNER JOIN user u ON v.userid = u.userid
        INNER JOIN task_assignment ta ON v.userid = ta.volunteer_id
        WHERE ta.task_id = ? 
    ");//here INNER JOIN and normal JOIN are the same thing
    $stmt->bind_param("i", $taskId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
        

    }


}
?>
