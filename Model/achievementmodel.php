<?php
//talk with the database to make link with the achievement controller

class achievementmodel
{
    private $modelvar;
    public function __construct($conn)
    {
        $this->modelvar = $conn;
    }

    //CREATE
    public function awardbadge($volunteerId, $badgename)
    {
        //award a badge to a volunteer
        $stmt=$this->modelvar->prepare("
        INSERT INTO volunteer_badge(userid,badgeearned,earneddate)
        VALUES (?,?,CURDATE())
        ");
        $stmt->bind_param("is",$volunteerId,$badgename);
        return $stmt->execute();
    }
    

    //READ

    //VOLUNTEER STATS RETRIVAL

    public function getvolunteerbasicstats($volunteerId)
    {
        //get volunteer basic stats like star points and level points

        $stmt=$this->modelvar->prepare("
            SELECT levelpoints,starpoints,noofmembers
            FROM volunteer
            WHERE userid=?
            ");
        $stmt->bind_param("i",$volunteerId);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->fetch_assoc();       


    }
    public function gettotalhoursvolunteered($volunteerId)
    {
        //get total hours volunteered by counting event durations
    
        $stmt=$this->modelvar->prepare("
            SELECT SUM(CAST(vp.duration AS UNSIGNED)) as total_hours
                FROM event_participation ep
                JOIN volunteering_program vp ON ep.event_id = vp.event_id
                WHERE ep.volunteer_id=?
                AND ep.participation_status= 'completed'
                AND vp.duration IS NOT NULL
                AND vp.duration != ''       
        ");//check for null and empty durations to get durations with actual real values
        $stmt->bind_param("i",$volunteerId);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_assoc();
        return $row['total_hours'] ?? 0;//only one key is there in the associative array
    }
    public function getprojectscompleted($volunteerId)
    {
        //get count of completed projects
        $stmt=$this->modelvar->prepare("
        SELECT COUNT(*) as count
        FROM event_participation
        WHERE volunteer_id =?
        AND participation_status ='completed'
        ");
        $stmt->bind_param("i",$volunteerId);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_assoc();//fetches a single row only (due to fetch_assoc) as an associative array which is ["count" => 5]
        return $row['count']??0;//give the count. if count is missing or null, return 0 instead

    }


    //BADGE OPERATIONS

    public function getvolunteerbadges($volunteerId)
    {   //currently not used but is important when showing badge timeline (showing when each badge was earned eg: ['badgeearned' => 'Mangrove Starter', 'earneddate' => '2025-01-15'],['badgeearned' => 'Wave Saver', 'earneddate' => '2025-01-05'] etc.)
        //get all badges earned by a volunteer 
        $stmt=$this->modelvar->prepare("
            SELECT badgeearned,earneddate
            FROM volunteer_badge
            WHERE userid = ?
            ORDER BY earneddate DESC
        ");
        $stmt->bind_param("i",$volunteerId);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);//return an entire table
    }
    public function badgecount($volunteerId, $badgename)
    {
        //check if a volunteer has a specific badge and return the count instead of boolean
        $stmt=$this->modelvar->prepare("
        SELECT COUNT(*) as count
        FROM volunteer_badge
        WHERE userid=? AND badgeearned=?
        ");
        $stmt->bind_param("is",$volunteerId,$badgename);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_assoc();//make an assoc array of format ['count'=>xxx]
        return $row['count'];//return the actual count not a boolean


    }
    public function getvolunteerbadgeswithcounts($volunteerId){
        //gives a grouped summary
        //get badges with counts 
        $stmt=$this->modelvar->prepare("
        SELECT badgeearned, COUNT(*) as badge_count,MIN(earneddate) as first_earned
        FROM volunteer_badge 
        WHERE userid=?
        GROUP BY badgeearned
        ORDER BY first_earned DESC
        ");
        $stmt->bind_param("i",$volunteerId);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);//returns a table of records with columns badgeearned,badge_count,first_earned grouped by badgeearned

    }
    public function geteventcountbycategory($volunteerId, $eventtype)
    {
        //get volunteer's completed event count by category

        $stmt=$this->modelvar->prepare("
        SELECT COUNT(*) as count
        FROM event_participation ep
        JOIN volunteering_program vp ON ep.event_id=vp.event_id
        WHERE ep.volunteer_id=?
        AND vp.event_type=?
        AND ep.participation_status='completed'    
        ");
        $stmt->bind_param("is",$volunteerId,$eventtype);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_assoc();//make an assoc array with ['count'=>xxx]
        return $row['count']??0;

    }
    public function getaverageperformanceincategory($volunteerId, $eventtype)
    {
        //get volunteer's avergae performance in event category
    }
    public function gettopperformersincategory($eventtype, $limit)
    {
        //get top N performers ina  specific event category
        //including the rating calcuation step in here as well
        $stmt=$this->modelvar->prepare("
        SELECT ep.volunteer_id,
        AVG(
        (COALESCE(ar.attendance_score,0)/5 * 0.3) + (0.7 * (COALESCE(pr.avg_peer_rating,0)/5 * COALESCE(tr.avg_task_rating,0)/5))
            ) as avg_performance
        FROM event_participation ep
        JOIN volunteering_program vp ON ep.event_id = vp.event_id 
        LEFT JOIN (
            SELECT event_id, ratee_id, AVG(peer_rating_score) as avg_peer_rating 
            FROM peer_rating 
            GROUP BY event_id, ratee_id
        ) pr ON pr.event_id=ep.event_id AND pr.ratee_id=ep.volunteer_id
        LEFT JOIN(
            SELECT t.event_id, tpr.volunteer_id, AVG(tpr.performance_score) as avg_task_rating
            FROM task_performance_rating tpr 
            JOIN task t ON tpr.task_id = t.task_id
            GROUP BY t.event_id, tpr.volunteer_id
        ) tr ON tr.event_id =ep.event_id AND tr.volunteer_id = ep.volunteer_id
        LEFT JOIN(
            SELECT event_id, volunteer_id, AVG(attendance_score) as attendance_score
            FROM attendance_rating 
            GROUP BY event_id, volunteer_id
        ) ar ON ar.event_id = ep.event_id AND ar.volunteer_id = ep.volunteer_id
            WHERE vp.event_type = ? 
            AND ep.participation_status = 'completed'
            GROUP BY ep.volunteer_id
            HAVING COUNT(DISTINCT ep.event_id) > 0
            ORDER BY avg_performance DESC
            LIMIT ?
        
        

        
        ");
        //Even though the subqueries were per event, after the GROUP BY and AVG in the main query, you get one average performance per volunteer across all events of that type
        //IMPORTANT: the peer rating.task rating, attendance rating subqueries give average PER VOLUNTEER PER EVENT
        //each subquery is per event
        //when doing left join with event_participation : each row in event_participation has the peer, task, attendance scores for that specific event
        //WHERE vp.event_type = ?: filters ep and vp rows to only include events of that type
        //GROUP BY ep.volunteer_id  now we have all events of that type for a single volunteer grouped together
        //next the AVG(...) around the formula then averages across all events of that type for that volunteer
        //Subqueries → per event
        //Main query GROUP BY → per volunteer
        //AVG(...) → averages all the event-level scores for that event type
        //the final avg_performance is not for a single event, it is for all events of the filtered event type

        //gets top volunteers (DESC based on avg_performance)
        //here we are renaming the subquery to a shorter alias eg: LEFT JOIN ( ... ) tr so instead of writing the whole subquery every time, you can now write:tr.event_id
        //COALESCE checks ONLY the values inside its () and picks the first non-NULL eg: COALESCE(NULL,val1,val2,0) returns val1
        //COUNT(DISTINCT ep.event_id) counts how many unique events this volunteer completed and we only keep the volunteers who participated in at least one event(REASON:we cant use WHERE after grouping, so we must use HAVING)
        $stmt->bind_param("si",$eventtype,$limit);//select volunteer_d and avg_performance
        $stmt->execute();
        $result=$stmt->get_result();//get the result and put it inot $result
        $topperformers=[];
        while($row=$result->fetch_assoc()){//automatically go row by row in result and put each into $row for a given count of while loop
            $topperformers[]=$row['volunteer_id'];//makes $topperformers a 1D array of volunteer Ids
        }
        return $topperformers;//the keys are auto incremeneted as indexes from 0,1,2,3,4,5...(starting from 0)


    }


    //LEADERBOARD OPERATIONS

    public function gettopvolunteers($limit = 10)
    {   //here $limit=10 is just the default, so it will use whatever passed so limit will be 50 if we pass 50
        //get top N volunteers BY level points
        $stmt=$this->modelvar->prepare("
        SELECT v.userid, u.name, v.levelpoints
        FROM volunteer v
        JOIN user u ON v.userid = u.userid
        ORDER BY v.levelpoints DESC
        LIMIT ?
        ");
        $stmt->bind_param("i",$limit);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);


    }
    public function getvolunteerrank($volunteerId)
    {
        //get volunteer's rank on leaderboard
        //get the number of volunteers who have levelpoints more than the volunteer of concern
        //duplicate handling needs to be done
        $stmt=$this->modelvar->prepare("
                SELECT COUNT(DISTINCT levelpoints) + 1 as position
                FROM volunteer
                WHERE levelpoints > (
                    SELECT levelpoints
                    FROM volunteer
                    WHERE userid = ? )

        ");
        $stmt->bind_param("i",$volunteerId);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_assoc();//get a single row where assoc index is "position" =>xxx
        return $row['position'] ?? 1;//give the key's value

    }

    public function getvolunteerdetails($volunteerId){
        $stmt=$this->modelvar->prepare("
        SELECT u.name,v.levelpoints as points
        FROM user u
        JOIN volunteer v
        ON u.userid=v.userid
        WHERE u.userid=?
        ");
        $stmt->bind_param("i",$volunteerId);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->fetch_assoc();

    }

    //POINTS CALCULATION COMPONENTS

    public function getaveragepeerrating($volunteerId, $eventId)
    {
        //get volutneer's avergae peer rating for an event
    
        $stmt=$this->modelvar->prepare("
        SELECT AVG(peer_rating_score) as avg_rating
        FROM peer_rating
        WHERE ratee_id=? AND event_id=?        
        ");
        $stmt->bind_param("ii",$volunteerId,$eventId);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_assoc();//make the associative array of 'avg_rating'=>xxx
        return $row['avg_rating'];
    
    
    
    
    }
    public function getaveragetaskrating($volunteerId, $eventId)
    {
        //get volunteer's average task performance rating for an event (no need to average as 1 volunteer can belong to only 1 task)
        $stmt=$this->modelvar->prepare("
        SELECT AVG(tpr.performance_score) as avg_rating
        FROM task_performance_rating tpr
        JOIN task t ON tpr.task_id=t.task_id
        WHERE tpr.volunteer_id=? AND t.event_id=?
        ");
        $stmt->bind_param("ii",$volunteerId,$eventId);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_assoc();//make assoc array with 'avg_rating'=>xxx
        return $row['avg_rating'];




    }
    public function getattendancescore($volunteerId, $eventId)
    {
        //get volunteer's attendance score for an event

        $stmt=$this->modelvar->prepare("
        SELECT AVG(attendance_score) as score
        FROM attendance_rating
        WHERE volunteer_id=? AND event_id=?         
        ");
        $stmt->bind_param("ii",$volunteerId,$eventId);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_assoc();//make assoc array with ['score'=>xxx]
        return $row['score'];





    }
    public function geteventrewards($eventId)
    {
        //get event's allocated rewards
        $stmt=$this->modelvar->prepare("
        SELECT starpoints_reward,levelpoints_reward
        FROM volunteering_program
        WHERE event_id=? AND is_deleted != 1
        ");
        $stmt->bind_param("i",$eventId);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->fetch_assoc();//make an assoc array with keys starpoints_reward,levelpoints_reward

    }
    public function geteventdetails($eventId)
    {
        //get event details

        $stmt = $this->modelvar->prepare("
            SELECT event_id, name, event_type, event_date, state_of_event, duration
            FROM volunteering_program 
            WHERE event_id = ?
        ");
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();//get the result into $result
        return $result->fetch_assoc();//make an assoc array with keys event_id, name, event_type, event_date, state_of_event, duration

    }

    //EVENT PARTICIPATION TRACKING

    public function didattend($volunteerId, $eventId)
    {
        //chcek if the volunteer attended the event

        $stmt=$this->modelvar->prepare("
        SELECT COUNT(*) as count
        FROM attendance_rating
        WHERE volunteer_id = ? AND event_id = ?
        ");
        $stmt->bind_param("ii",$volunteerId,$eventId);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_assoc();//now row is just ['count'=>xxx]
        return $row['count']>0;

    }
    public function getvolunteerswhoparticipated($eventId)
    {
        //get all volunteers who attended an event
        $stmt=$this->modelvar->prepare("
        SELECT DISTINCT volunteer_id
        FROM event_participation
        WHERE event_id = ? AND participation_status IN ('registered','attended','completed')
        ");//didnt take cancelled, completed (there is a gaurd in the next step of controller)
        $stmt->bind_param("i",$eventId);
        $stmt->execute();
        $result=$stmt->get_result();//result is a table usually taken through fetch_all, but here we fill into an array one by one , thefore we use fetch_assoc
        $volunteers=[];
        while($row=$result->fetch_assoc()){//here $row is an assoc array of format ['volunteer_id'=>xxx]
            $volunteers[]=$row['volunteer_id'];//each time fetch_assoc is called the next row in the result set it given(its automatically moving through the rows one at a time)
        }
        return $volunteers;//here now $volunteers is an array of volunteer_id s

    }

    public function havepointsbeenawarded($volunteerId, $eventId)
    {
        //check if points have already been awarded for event

        $stmt=$this->modelvar->prepare("
        SELECT participation_status
        FROM event_participation
        WHERE  volunteer_id=? AND event_id=?  
        ");
        $stmt->bind_param("ii",$volunteerId,$eventId);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_assoc();
        return $row && $row['participation_status']=== 'completed';

    }
    public function iseventcompleted($eventId)
    {
        //check if event is completed
        $stmt=$this->modelvar->prepare("
        SELECT state_of_event
        FROM volunteering_program
        WHERE event_id = ? AND is_deleted != 1
        ");
        $stmt->bind_param("i",$eventId);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_assoc();//make the associtie array
        return $row && $row['state_of_event']==='completed';//return only if completed
    }
    public function iseventcancelled($eventId)
    {
        //check if event is cancelled
        $stmt=$this->modelvar->prepare("
        SELECT state_of_event
        FROM volunteering_program
        WHERE event_id = ? AND is_deleted != 1
        ");
        $stmt->bind_param("i",$eventId);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_assoc();//make the associative array where key value pair is 'state_of_event'=>'registered' OR 'attended' OR 'completed' OR 'cancelled'
        return $row && $row['state_of_event']==='cancelled';//return if event IS cancelled
    }

    public function gettotalvolunteers()
    {
        //get total volunteers in system
    }
    public function gettotallevelpointsdistributed()
    {
        //get total level points distributed
    }
    public function getaveragelevelpoints()
    {
        //get average level points per volunteer
    }

    //UPDATE
    //POINTS AWARDING AND DEDUCTION

    public function awardstarpoints($volunteerId, $points)
    {
        //award star points to volunteer

        $stmt=$this->modelvar->prepare("
        UPDATE volunteer
        SET starpoints=GREATEST(0, starpoints + ?)
        WHERE userid=?
        ");
        $stmt->bind_param("ii",$points,$volunteerId);
        return $stmt->execute();



    }
    public function awardlevelpoints($volunteerId, $points)
    {
        //award level points to volunteer

        $stmt=$this->modelvar->prepare("
        UPDATE volunteer
        SET levelpoints=GREATEST(0, levelpoints + ?)
        WHERE userid=?
        ");
        $stmt->bind_param("ii",$points,$volunteerId);
        return $stmt->execute();



    }

    public function deductattendancepenalty($penalty, $volunteerId){
        // Deduct points from volunteer
        $stmt = $this->modelvar->prepare(
            "UPDATE volunteer 
             SET levelpoints = GREATEST(0, levelpoints - ?)
             WHERE userid = ?"
        );
        $stmt->bind_param("ii", $penalty, $volunteerId);
        $stmt->execute();
    }
    

    public function updateparticipationstatus($volunteerId, $eventId, $status)
    {
        //update event participation status

        $stmt=$this->modelvar->prepare("
        UPDATE event_participation
        SET participation_status=?
        WHERE volunteer_id =? AND event_id = ?
        ");
        $stmt->bind_param("sii",$status,$volunteerId,$eventId);
        return $stmt->execute();


    }

    //BATCH OPERATIONS
    public function bulkawardpoints($awards)
    {
        //bulk award points to multiple volunteers
    }



    public function geteventbasicdetails($eventId) {
    $stmt = $this->modelvar->prepare(
        "SELECT event_id, points_processed 
         FROM volunteering_program 
         WHERE event_id = ? AND is_deleted != 1"
    );
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();//returns format like ['event_id' => 5, 'points_processed' => 1] cuz we used fetch assoc and not fetch all
}//fetch all returns an array of assoc array which u have to navugate thruh foreach loops

public function markpointsprocessed($eventId) {
    $stmt = $this->modelvar->prepare(
        "UPDATE volunteering_program 
         SET points_processed = 1 
         WHERE event_id = ?"
    );
    $stmt->bind_param("i", $eventId);
    return $stmt->execute();
}


    //DELETE
}







?>