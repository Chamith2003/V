<?php

class activitymodel{
    private $modelvar;
    private $openedEvents = []; 
    

     public function __construct($conn){
        //get the $conn and give that to $modelvar to be used throughout php file
        //the $conn dissappears outside constructor function
        $this->modelvar=$conn;
    }

    public function fetchevents(){

 $currentDate = date('Y-m-d');
    
    //update event states -mark past events as completed
    $updatePast = ($this->modelvar)->prepare(
        "UPDATE volunteering_program 
         SET state_of_event = 'completed' 
         WHERE event_date < ? AND state_of_event != 'completed' AND state_of_event != 'cancelled' AND is_deleted != 1"
    );
    $updatePast->bind_param("s", $currentDate);
    $updatePast->execute();
    //make todays events as active
    $updateToday = ($this->modelvar)->prepare(
        "UPDATE volunteering_program 
         SET state_of_event = 'active' 
         WHERE event_date = ? AND state_of_event = 'planned' AND is_deleted != 1"
    );
    $updateToday->bind_param("s", $currentDate);
    $updateToday->execute();


     // set the peer rating window for newly completed events
        $openPeerWindow = ($this->modelvar)->prepare(
            "UPDATE volunteering_program 
             SET peer_rating_open_until = DATE_ADD(event_date, INTERVAL 7 DAY)
             WHERE state_of_event = 'completed' AND peer_rating_open_until IS NULL AND is_deleted != 1"
        );
        $openPeerWindow->execute();


        // get the events that have their rating window open
        $openEvents = ($this->modelvar)->prepare(
            "SELECT event_id FROM volunteering_program
            WHERE state_of_event = 'completed' AND peer_rating_open_until IS NOT NULL AND peer_rating_open_until >= NOW() AND is_deleted != 1"
        );
        $openEvents->execute();
        //store it as an assoc array in openedEvents in the format of [['event_id'=>1], ['event_id'=>2]]
        $this->openedEvents = $openEvents->get_result()->fetch_all(MYSQLI_ASSOC);

//select the list of all events that need to be rendered (bring all events and later sort)

        $stmt=($this->modelvar)->prepare("select * from volunteering_program WHERE state_of_event != 'cancelled' AND isauthorized = 1 AND is_deleted != 1");
        $stmt->execute();
        //  return ($stmt->get_result())->fetch_assoc();
        // //return the result and then convert it to as associative array( only 1 row it seems)
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);//returns an array of associative arrays
    // fetch_all() gets ALL rows as an associative array
    }

    public function getopenedevents() {
        return $this->openedEvents ?? [];
    }



    public function fetchorganizedevents($organizerId){
        $stmt=($this->modelvar)->prepare("SELECT * FROM volunteering_program WHERE organizer_id = ? AND state_of_event != 'cancelled' AND is_deleted != 1");
        $stmt->bind_param("i",$organizerId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);

    }

    public function fetchannualevents(){
        $stmt=($this->modelvar)->prepare("SELECT * FROM volunteering_program WHERE is_annual = 1 AND state_of_event != 'cancelled' AND isauthorized = 1 AND is_deleted != 1");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);

    }

    public function fetchenrolledevents($volunteerId){
        $stmt=($this->modelvar)->prepare("
        SELECT vp.*,tta.task_id, tta.name as taskname
        FROM volunteering_program vp
        JOIN event_participation ep
        ON vp.event_id=ep.event_id
        LEFT JOIN (
            SELECT t.task_id,t.name,t.event_id, ta.volunteer_id
            FROM task t
            JOIN task_assignment ta
            ON t.task_id=ta.task_id) as tta
        ON tta.event_id=ep.event_id AND tta.volunteer_id=ep.volunteer_id    
        WHERE ep.volunteer_id=?
        AND ep.participation_status IN ('registered', 'attended', 'completed')
        AND vp.state_of_event != 'cancelled'
        AND vp.is_deleted != 1
        ORDER BY vp.event_date    
        "
        );
        $stmt->bind_param("i",$volunteerId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);

    }


    
    public function isuserenrolled($userId, $eventId) {
    $stmt = ($this->modelvar)->prepare("
        SELECT COUNT(*) as count
        FROM event_participation
        WHERE volunteer_id = ? AND event_id = ?
    ");
    $stmt->bind_param("ii", $userId, $eventId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();//returns assoc array like ['count'=>1]
    return $row['count'] > 0;//returns a true or false
}



}













?>



        
        
       
        
        