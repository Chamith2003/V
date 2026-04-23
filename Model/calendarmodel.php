<?php
//here we use calendarstatus  value to filterthe radio buttons
class calendarmodel
{
    private $modelvar;



    public function __construct($conn)
    {//get the $conn and give that to $modelvar to be used throughout php file
        //the $conn dissappears outside constructor function
        $this->modelvar = $conn;
    }

    //here an additional filtering logic is applied where events are filtered by a date range 
    //if $startDate and $endDate are provided → it adds "AND event_date BETWEEN ? AND ? "
    //if they’re not provided then the query returns all relevant events

    //get events(enrolled events) for volunteer's calendar

    public function getvolunteerstandardevents($volunteerId, $startdate = null, $enddate = null)
    {//get all events a volunteer has enrolled in filtering based on input date range
        $sql = "SELECT 
        vp.event_id,vp.name,vp.description,vp.event_type,vp.event_date,
        vp.time,vp.location,vp.starpoints_reward,vp.levelpoints_reward,
        vp.max_participants,vp.current_participants,vp.state_of_event,
        u.name as organizername,ep.participation_status,ep.registration_date,'standardenrolled' as calendarstatus,
        DATEDIFF(vp.event_date, CURDATE()) as daysuntilevent
        FROM volunteering_program vp
        JOIN event_participation ep ON vp.event_id = ep.event_id
        JOIN user u ON vp.organizer_id = u.userid
        WHERE ep.volunteer_id = ?
        AND ep.participation_status IN ('registered','attended','completed')
        AND vp.isauthorized = 1 AND vp.is_annual !=1
        AND vp.state_of_event != 'cancelled'
        AND vp.is_deleted != 1
        ";

        if ($startdate && $enddate) {//concatenate the following if startdate and enddate are given
            $sql .= " AND vp.event_date BETWEEN ? AND ?";
        }

        $sql .= " ORDER BY vp.event_date ASC, vp.time ASC";

        $stmt = $this->modelvar->prepare($sql);

        if ($startdate && $enddate) {
            $stmt->bind_param("iss", $volunteerId, $startdate, $enddate);// i=int, s=string
        } else {
            $stmt->bind_param("i", $volunteerId);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);

    }

    

    //event retrival of a particulair sponsor + shows only events they've accepted to sponsor
    public function getsponsoredevents($sponsorId, $startdate = null, $enddate = null)
    {
        $sql = "SELECT 
                    vp.event_id,vp.name,vp.description,vp.event_type,
                    vp.event_date,vp.time,vp.location,vp.scale,
                    u.name as organizername,'sponsored' as calendarstatus,
                    SUM(sec.commitment_amount) as commitmentamount,MAX(sec.commitment_date) as commitmentdate,
                    sec.status as commitmentstatus
                FROM sponsor_event_commitment sec
                JOIN volunteering_program vp ON sec.event_id = vp.event_id
                JOIN user u ON vp.organizer_id = u.userid
                WHERE sec.sponsor_id = ?
                AND sec.status = 'accepted'
                AND vp.is_annual = 1
                AND vp.isauthorized = 1
                AND vp.state_of_event != 'cancelled'
                AND vp.is_deleted != 1";

        if ($startdate && $enddate) {
            $sql .= " AND vp.event_date BETWEEN ? AND ?";
        }
        $sql .= " GROUP BY vp.event_id";

        $sql .= " ORDER BY vp.event_date ASC";

        $stmt = $this->modelvar->prepare($sql);

        if ($startdate && $enddate) {
            $stmt->bind_param("iss", $sponsorId, $startdate, $enddate);
        } else {
            $stmt->bind_param("i", $sponsorId);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);



    }
    public function getallunsponsoredannualevents($sponsorId, $startdate = null, $enddate = null){
        $sql = "SELECT 
                    vp.event_id,vp.name,vp.description,vp.event_type,
                    vp.event_date,vp.time,vp.location,vp.scale,
                    vp.max_participants, vp.current_participants,
                    u.name as organizername,'unsponsored' as calendarstatus
                FROM volunteering_program vp
                JOIN user u ON vp.organizer_id = u.userid
                WHERE vp.is_annual = 1
                AND vp.isauthorized = 1
                AND vp.state_of_event != 'cancelled'
                AND vp.is_deleted != 1
                AND vp.event_id NOT IN(
                    SELECT event_id 
                    FROM sponsor_event_commitment
                    WHERE sponsor_id = ?
                    AND status = 'accepted')
                ";//returns NOT IN(14,14,14) which is ok

        if ($startdate && $enddate) {
            $sql .= " AND vp.event_date BETWEEN ? AND ?";
        }

        $sql .= " ORDER BY vp.event_date ASC";

        $stmt = $this->modelvar->prepare($sql);

        if ($startdate && $enddate) {
            $stmt->bind_param("iss", $sponsorId, $startdate, $enddate);
        } else {
            $stmt->bind_param("i", $sponsorId);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);

    }

    public function getregisteredannualevents($volunteerId, $startdate = null, $enddate = null){
        //get all registered annual events a volunteer,rep etc.(anyone who has the filter/sidebar)filtering based on input date range
        $sql = "SELECT 
        vp.event_id,vp.name,vp.description,vp.event_type,vp.event_date,
        vp.time,vp.location,vp.starpoints_reward,vp.levelpoints_reward,
        vp.max_participants,vp.current_participants,vp.state_of_event,
        u.name as organizername,ep.participation_status,ep.registration_date,'registeredannual' as calendarstatus,
        DATEDIFF(vp.event_date, CURDATE()) as daysuntilevent
        FROM volunteering_program vp
        JOIN event_participation ep ON vp.event_id = ep.event_id
        JOIN user u ON vp.organizer_id = u.userid
        WHERE ep.volunteer_id = ?
        AND ep.participation_status = 'registered'
        AND vp.isauthorized = 1 AND vp.is_annual = 1
        AND vp.state_of_event != 'cancelled'
        AND vp.is_deleted != 1
        ";

        if ($startdate && $enddate) {//concatenate the following if startdate and enddate are given
            $sql .= " AND vp.event_date BETWEEN ? AND ?";
        }

        $sql .= " ORDER BY vp.event_date ASC, vp.time ASC";

        $stmt = $this->modelvar->prepare($sql);

        if ($startdate && $enddate) {
            $stmt->bind_param("iss", $volunteerId, $startdate, $enddate);// i=int, s=string
        } else {
            $stmt->bind_param("i", $volunteerId);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);

    }
    public function getunregisteredannualevents($volunteerId, $startdate = null, $enddate = null){
        //get all un-registered annual events a volunteer,rep etc.(anyone who has the filter/sidebar) filtering based on input date range
        //here the never ever registered events and registered but later cancelled events(no active participation) are shown as unregistered annual events
        $sql = "SELECT 
        vp.event_id,vp.name,vp.description,vp.event_type,vp.event_date,
        vp.time,vp.location,vp.starpoints_reward,vp.levelpoints_reward,
        vp.max_participants,vp.current_participants,vp.state_of_event,
        u.name as organizername,'unregisteredannual' as calendarstatus,
        DATEDIFF(vp.event_date, CURDATE()) as daysuntilevent
        FROM volunteering_program vp
        JOIN user u ON vp.organizer_id = u.userid
        WHERE vp.is_annual = 1        
        AND vp.isauthorized = 1 
        AND vp.state_of_event != 'cancelled'
        AND vp.is_deleted != 1
        AND vp.event_id NOT IN (
            SELECT event_id 
            FROM event_participation 
            WHERE volunteer_id = ? AND participation_status IN ('registered', 'attended', 'completed')
        )
        ";

        if ($startdate && $enddate) {//concatenate the following if startdate and enddate are given
            $sql .= " AND vp.event_date BETWEEN ? AND ?";
        }

        $sql .= " ORDER BY vp.event_date ASC, vp.time ASC";

        $stmt = $this->modelvar->prepare($sql);

        if ($startdate && $enddate) {
            $stmt->bind_param("iss", $volunteerId, $startdate, $enddate);// i=int, s=string
        } else {
            $stmt->bind_param("i", $volunteerId);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);

    }

    public function getreporganizedbutnotattended($repId, $startdate = null, $enddate = null){
        $sql = "SELECT 
        vp.event_id,vp.name,vp.description,vp.event_type,vp.event_date,
        vp.time,vp.location,vp.starpoints_reward,vp.levelpoints_reward,
        vp.max_participants,vp.current_participants,vp.state_of_event,
        u.name as organizername,'reporganizedbutnotattended' as calendarstatus,
        DATEDIFF(vp.event_date, CURDATE()) as daysuntilevent
        FROM volunteering_program vp
        JOIN user u ON vp.organizer_id = u.userid
        WHERE organizer_id=?
        AND vp.isauthorized = 1 AND vp.is_annual != 1
        AND vp.state_of_event != 'cancelled'
        AND vp.is_deleted != 1
        ";

        if ($startdate && $enddate) {//concatenate the following if startdate and enddate are given
            $sql .= " AND vp.event_date BETWEEN ? AND ?";
        }

        $sql .= " ORDER BY vp.event_date ASC, vp.time ASC";

        $stmt = $this->modelvar->prepare($sql);

        if ($startdate && $enddate) {
            $stmt->bind_param("iss", $repId, $startdate, $enddate);// i=int, s=string
        } else {
            $stmt->bind_param("i", $repId);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);



    }
    public function getrepnotorganizedbutattended($repId, $startdate = null, $enddate = null){
         $sql = "SELECT 
        vp.event_id,vp.name,vp.description,vp.event_type,vp.event_date,
        vp.time,vp.location,vp.starpoints_reward,vp.levelpoints_reward,
        vp.max_participants,vp.current_participants,vp.state_of_event,
        u.name as organizername,ep.participation_status,ep.registration_date,'repnotorganizedbutattended' as calendarstatus,
        DATEDIFF(vp.event_date, CURDATE()) as daysuntilevent
        FROM volunteering_program vp
        JOIN event_participation ep ON vp.event_id = ep.event_id
        JOIN user u ON vp.organizer_id = u.userid
        WHERE ep.volunteer_id = ?
        AND organizer_id != ?
        AND ep.participation_status IN ('registered','attended','completed')
        AND vp.isauthorized = 1 AND vp.is_annual != 1
        AND vp.state_of_event != 'cancelled'
        AND vp.is_deleted != 1
        ";

        if ($startdate && $enddate) {//concatenate the following if startdate and enddate are given
            $sql .= " AND vp.event_date BETWEEN ? AND ?";
        }

        $sql .= " ORDER BY vp.event_date ASC, vp.time ASC";

        $stmt = $this->modelvar->prepare($sql);

        if ($startdate && $enddate) {
            $stmt->bind_param("iiss", $repId, $repId, $startdate, $enddate);// i=int, s=string
        } else {
            $stmt->bind_param("ii", $repId ,$repId);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);



    }
    
    public function getmanagerstandardorganizednotenrolled( $managerId,$startdate = null, $enddate = null){
        $sql = "SELECT 
        vp.event_id,vp.name,vp.description,vp.event_type,vp.event_date,
        vp.time,vp.location,vp.starpoints_reward,vp.levelpoints_reward,
        vp.max_participants,vp.current_participants,vp.state_of_event,
        u.name as organizername,'managerorganizedstandard' as calendarstatus,
        DATEDIFF(vp.event_date, CURDATE()) as daysuntilevent
        FROM volunteering_program vp
        JOIN user u ON vp.organizer_id = u.userid
        WHERE vp.is_annual != 1        
        AND vp.isauthorized = 1
        AND organizer_id=? 
        AND vp.state_of_event != 'cancelled'
        AND vp.is_deleted != 1
        AND vp.event_id NOT IN (
            SELECT event_id 
            FROM event_participation 
            WHERE volunteer_id = ?
        )
        ";

        if ($startdate && $enddate) {//concatenate the following if startdate and enddate are given
            $sql .= " AND vp.event_date BETWEEN ? AND ?";
        }

        $sql .= " ORDER BY vp.event_date ASC, vp.time ASC";

        $stmt = $this->modelvar->prepare($sql);

        if ($startdate && $enddate) {
            $stmt->bind_param("iiss", $managerId, $managerId, $startdate, $enddate);// i=int, s=string
        } else {
            $stmt->bind_param("ii", $managerId, $managerId);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);


    }

    public function getallstandard($startdate = null, $enddate = null){
        
        //get events for manager/admin/representative/volunteer calendar + shows only activated annual events

        $sql = "SELECT 
                event_id,name,description,event_type,
                event_date,time,location,
                scale,max_participants,current_participants,organizer_id ,'allstandard' as calendarstatus
                FROM volunteering_program 
                WHERE is_annual != 1 AND isauthorized = 1 AND state_of_event != 'cancelled' AND is_deleted != 1";

        if ($startdate && $enddate) {
            $sql .= " AND event_date BETWEEN ? AND ?";
        }

        $sql .= " ORDER BY event_date ASC";

        $stmt = $this->modelvar->prepare($sql);

        if ($startdate && $enddate) {
            $stmt->bind_param("ss", $startdate, $enddate);
            $stmt->execute();
        } else {
            $stmt->execute();
        }

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);



    }

    public function getallactivatedannualevents($startdate = null, $enddate = null)
    {
        //get events for manager/admin/representative/volunteer calendar + shows only activated annual events

        $sql = "SELECT 
                event_id,name,description,event_type,
                event_date,time,location,
                scale,max_participants,current_participants,organizer_id,'allannual' as calendarstatus 
                FROM volunteering_program 
                WHERE is_annual = 1 AND isauthorized = 1 AND state_of_event != 'cancelled' AND is_deleted != 1";

        if ($startdate && $enddate) {
            $sql .= " AND event_date BETWEEN ? AND ?";
        }

        $sql .= " ORDER BY event_date ASC";

        $stmt = $this->modelvar->prepare($sql);

        if ($startdate && $enddate) {
            $stmt->bind_param("ss", $startdate, $enddate);
            $stmt->execute();
        } else {
            $stmt->execute();
        }

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);



    }
    public function geteventsbydaterange($userId, $role, $startdate, $enddate)
    {//get events by date range for calendar grid
        switch ($role) {
            case 'volunteer':
                // Get both enrolled and all annual events
                $enrolledstandard = $this->getvolunteerstandardevents($userId, $startdate, $enddate);
                $allannual= $this->getallactivatedannualevents($startdate, $enddate);
                //$registeredannual=$this->getregisteredannualevents($userId, $startdate, $enddate);
                //$unregisteredannual=$this->getunregisteredannualevents($userId, $startdate, $enddate);

                

                return array_merge($enrolledstandard,$allannual);

            case 'representative':
                $allannual= $this->getallactivatedannualevents($startdate, $enddate);
                $reporganized=$this->getreporganizedbutnotattended($userId, $startdate, $enddate);
                $repattended= $this->getrepnotorganizedbutattended($userId, $startdate, $enddate);
                //$registeredannual=$this->getregisteredannualevents($userId, $startdate, $enddate);
                //$unregisteredannual=$this->getunregisteredannualevents($userId, $startdate, $enddate); 
                
                return array_merge($allannual, $reporganized,$repattended);  

             case 'sponsor':
                $accepted= $this->getsponsoredevents($userId, $startdate, $enddate);
                $notyetaccepted= $this->getallunsponsoredannualevents($userId, $startdate, $enddate);
                 return array_merge($accepted, $notyetaccepted);

            case 'manager':
                $organizedstandard=$this->getmanagerstandardorganizednotenrolled($userId, $startdate, $enddate);
                $allannual= $this->getallactivatedannualevents($startdate, $enddate);
                return array_merge($organizedstandard, $allannual);

            case 'admin':
                $allstandard=$this->getallstandard($startdate, $enddate);
                $allannual=$this->getallactivatedannualevents($startdate, $enddate);
                return array_merge($allstandard, $allannual);

            case 'organisationrep': 
                $allannual= $this->getallactivatedannualevents($startdate, $enddate);
                $orgreporganized=$this->getreporganizedbutnotattended($userId, $startdate, $enddate);
                $orgrepattended= $this->getrepnotorganizedbutattended($userId, $startdate, $enddate);
                //$registeredannual=$this->getregisteredannualevents($userId, $startdate, $enddate);
                //$unregisteredannual=$this->getunregisteredannualevents($userId, $startdate, $enddate); 
                
                return array_merge($allannual, $orgreporganized,$orgrepattended);   

            default:
                return [];
        }

    }
    public function geteventdetails($eventId)
    {
        //get event details for the pop-up modal(detialed view)
        $sql = "SELECT 
                vp.event_id,vp.name,vp.description,vp.event_type,
                vp.event_date,vp.time,vp.location,vp.scale,
                vp.max_participants,vp.current_participants,vp.starpoints_reward,
                vp.levelpoints_reward,vp.state_of_event,vp.is_annual,
                u.name as organizername,u.email as organizeremail
                FROM volunteering_program vp JOIN user u ON vp.organizer_id = u.userid WHERE vp.event_id = ? AND vp.is_deleted != 1";

        $stmt = $this->modelvar->prepare($sql);
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();

    }

    //event actions
    public function canleaveevent($volunteerId, $eventId)
    {
        //check if volunteer can leave event (must be >2 days before)
        $sql = "SELECT 
                vp.event_date,
                DATEDIFF(vp.event_date, CURDATE()) as daysuntilevent,
                ep.participation_status
                FROM volunteering_program vp
                JOIN event_participation ep ON vp.event_id = ep.event_id
                WHERE ep.volunteer_id = ? AND ep.event_id = ? AND ep.participation_status = 'registered' AND vp.is_deleted != 1";

        $stmt = $this->modelvar->prepare($sql);
        $stmt->bind_param("ii", $volunteerId, $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if (!$data) {
            return ['canleave' => false,
                    'reason' => 'Cannot leave event as the event has already passed or event has not been enrolled into.'
                    ];
        }

        if ($data['daysuntilevent'] < 3) {
            return [
                'canleave' => false,
                'reason' => 'Cannot leave event less than 3 days before start date',
                'daysuntilevent' => $data['daysuntilevent']
            ];
        }

        return ['canleave' => true,
                 'daysuntilevent' => $data['daysuntilevent']
                ];
    }

    public function calculatepenalty($levelpointreward,$daysuntilevent){
       if ($daysuntilevent > 30) {
        return 0;
    }
    return $levelpointreward*(30 - $daysuntilevent)*0.01;
    }//max penalty is 27%


    public function leaveevent($volunteerId, $eventId)
    {
        
    // Leave an event (volunteer withdraws)
    try {
        $this->modelvar->begin_transaction();

        // Check if can leave
        $canleave = $this->canleaveevent($volunteerId, $eventId);
        if (!$canleave['canleave']) {
            throw new Exception($canleave['reason']);
        }

        // Get volunteer stats BEFORE penalty
        $stmt = $this->modelvar->prepare(
            "SELECT levelpoints FROM volunteer WHERE userid = ?"
        );
        $stmt->bind_param("i", $volunteerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $beforeData = $result->fetch_assoc();
        $levelpointsBefore = $beforeData['levelpoints'];

        // Get event rewards to calculate penalty
        $stmt = $this->modelvar->prepare(
            "SELECT starpoints_reward, levelpoints_reward 
             FROM volunteering_program 
             WHERE event_id = ?"
        );
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        $rewards = $result->fetch_assoc();

        $penalty=$this->calculatepenalty($rewards['levelpoints_reward'],$canleave['daysuntilevent']);

        // Calculate penalties
        $starloss=0;
        $levelloss = (int) round($penalty);

        // Deduct points from volunteer
        $stmt = $this->modelvar->prepare(
            "UPDATE volunteer 
             SET starpoints = GREATEST(0, starpoints - ?),
             levelpoints = GREATEST(0, levelpoints - ?)
             WHERE userid = ?"
        );
        $stmt->bind_param("iii", $starloss, $levelloss, $volunteerId);
        $stmt->execute();

        // Get volunteer stats AFTER penalty
        $stmt = $this->modelvar->prepare(
            "SELECT levelpoints FROM volunteer WHERE userid = ?"
        );
        $stmt->bind_param("i", $volunteerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $afterData = $result->fetch_assoc();
        $levelpointsAfter = $afterData['levelpoints'];

        // Calculate level changes
        $levelbefore = $this->calculatelevel($levelpointsBefore);
        $levelafter = $this->calculatelevel($levelpointsAfter);
        
        $leveldowninfo = null;
        if ($levelafter < $levelbefore) {
            $leveldowninfo = [
                'old_level' => $levelbefore,
                'new_level' => $levelafter,
                'levels_lost' => $levelbefore - $levelafter
            ];
        }

        // Record in the leave history
        $stmt = $this->modelvar->prepare(
            "INSERT INTO volunteer_leave_history
            (volunteer_id, event_id, days_before_event, level_points_lost, star_points_lost, reason)
            VALUES (?, ?, ?, ?, ?, ?)"
        );
        $reason = 'Voluntary withdrawal';
        $stmt->bind_param(
            "iiiiis",
            $volunteerId,
            $eventId,
            $canleave['daysuntilevent'],
            $levelloss,
            $starloss,
            $reason
        );
        $stmt->execute();

        // Update participation status
        $stmt = $this->modelvar->prepare(
            "UPDATE event_participation 
             SET participation_status = 'cancelled'
             WHERE volunteer_id = ? AND event_id = ?"
        );
        $stmt->bind_param("ii", $volunteerId, $eventId);
        $stmt->execute();

        // Decrease current participants count
        $stmt = $this->modelvar->prepare(
            "UPDATE volunteering_program 
             SET current_participants = GREATEST(0, current_participants - 1)
             WHERE event_id = ?"
        );
        $stmt->bind_param("i", $eventId);
        $stmt->execute();

        $this->modelvar->commit();

        // Build message based on level change
        $message = 'Successfully withdrew from event';
        if ($leveldowninfo) {
            $message = "You have left the event. {$levelloss} level points and {$starloss} star points deducted. You dropped from level {$levelbefore} to level {$levelafter}!";
        } else {
            $message = "You have left the event. {$levelloss} level points and {$starloss} star points deducted.";
        }

        return [
            'success' => true,
            'message' => $message,
            'pointslost' => [
                'star' => $starloss,
                'level' => $levelloss
            ],
            'level_before' => $levelbefore,
            'level_after' => $levelafter,
            'level_down' => $leveldowninfo,
            'daysuntilevent' => $canleave['daysuntilevent']
        ];

    } catch (Exception $e) {
        $this->modelvar->rollback();
        return ['success' => false, 'message' => $e->getMessage()];
    }
    }

    

    //behavior tracking
    public function getvolunteerleavecount($volunteerId, $days = 90)
    {
        //get volunteer leave history (to flag behavior)

        $stmt = $this->modelvar->prepare(
            "SELECT COUNT(*) as leavecount
             FROM volunteer_leave_history
             WHERE volunteer_id = ? AND leave_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)"
        );//get the leave count from 90 days ago(including 90th day) up until today
        $stmt->bind_param("ii", $volunteerId, $days);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['leavecount'];
    }
    public function checkvolunteerbehavior($volunteerId)
    {
        //check if volunteer behavior should be flagged
        $leavecount = $this->getvolunteerleavecount($volunteerId, 90);

        // Flag if left more than 10 events in 90 days
        if ($leavecount > 10) {
            return [
                'flagged' => true,
                'leavecount' => $leavecount,
                'message' => 'High frequency of event withdrawals detected'
            ];
        }

        return ['flagged' => false, 'leavecount' => $leavecount];
    }

    public function geteventtypecolor($eventtype)
    {//get color code for event type

        $colors = [
            'mangrove restoration' => '#3CB371',     // MediumSeaGreen
            'coral restoration' => '#48D1CC',     // MediumTurquoise
            'tree planting' => '#2E8B57',     // SeaGreen
            'city cleanup' => '#6C757D',     // Cool Gray
            'mountain cleanup' => '#A0522D',     // Sienna
            'beach cleanup' => '#FFE066',     // Soft Yellow
            'awareness campaign' => '#FF6B6B'      // Coral Red
        ];
        //convert to lowercase for consistent array access
        return $colors[strtolower($eventtype)] ?? '#3498DB';
    }



    private function calculatelevel($levelpoints) {
    // Calculate volunteer's current level from level points
    $levelthresholds = [
        1 => 0,
        2 => 15,
        3 => 50,
        4 => 120,
        5 => 250,
        6 => 450,
        7 => 750,
        8 => 1150,
        9 => 1700,
        10 => 2400,
        11 => 3300,
        12 => 4500,
        13 => 6000,
        14 => 8000,
        15 => 10500
    ];
    
    $currentlevel = 1;
    foreach ($levelthresholds as $level => $threshold) {
        if ($levelpoints >= $threshold) {
            $currentlevel = $level;
        } else {
            break;
        }
    }
    return $currentlevel;
}




}
?>