<?php
class calendarcontroller
{
    private $calendarctrlvar;

    public function __construct($calendarmodel){
        $this->calendarctrlvar = $calendarmodel;
    }
    
    public function rendercalendar(){
        //render the calendar UI
         if (!isset($_SESSION['user_id'])) {
            header("Location: /V/router.php?module=user&action=login");
            exit();
        }
        $userId = $_SESSION['user_id'];
        $role = $_SESSION['role'];

        // get upcoming events for sidebar

        $upcomingevents = $this->getupcomingevents($userId, $role);
        $returnedannualevents=$this->getannualevents($userId);

        // load calendar view

         include 'View/calendar/calendar.php';

    }

     //AJAX endpoints
    public function getcalendarevents(){


        header('Content-Type: application/json');

         if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            exit();
        }

        $userId = $_SESSION['user_id'];
        $role = $_SESSION['role'];
        
        // get month and year from request
        $month = $_GET['month'] ?? date('n');
        $year = $_GET['year'] ?? date('Y');

         // Calculate date range (first and last day of month)
        $startdate = date('Y-m-d', strtotime("$year-$month-01"));
        $lastday = date('t', strtotime($startdate));//find the number of days in that month looking at start date (can be any date)
        //date (t) returns the number of days in that month
        $enddate = date('Y-m-d', strtotime("$year-$month-$lastday"));

        // get events based on role (renders all where filter=all by default upon loading calendar for first time.->doesnt apply filters the first time it loads. must press on filters to apply them)
        $events = $this->calendarctrlvar->geteventsbydaterange($userId, $role, $startdate, $enddate);

         // format events for calendar
         $formattedevents = [];
        foreach ($events as $event) {
            $datekey = $event['event_date'];

             if (!isset($formattedevents[$datekey])) {
                $formattedevents[$datekey] = [];//create an array if specific datekey doesnt exist
            }
            $formattedevents[$datekey][] = [//add the event to that day's list with its details where the first event is at index 0 (0 indexed events in the day)
                'id' => $event['event_id'],
                'title' => $event['name'],
                'type' => $event['event_type'],
                'time' => $event['time'] ?? null,
                'status' => $event['calendarstatus'] ?? 'all',//differenciate between sponsored and enrolled and other filters
                'color' => $this->calendarctrlvar->geteventtypecolor($event['event_type'])
            ];
        }
        //echo only sends it to the js fetcher
        echo json_encode([
            'success' => true,
            'events' => $formattedevents
        ]);
        exit();

    }
    
    
    public function geteventdetails(){

         header('Content-Type: application/json');

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            exit();
        }

         $eventId = $_GET['eventId'] ?? null;
         if (!$eventId) {
            echo json_encode(['success' => false, 'message' => 'Event ID required']);
            exit();
        }

        $event = $this->calendarctrlvar->geteventdetails($eventId);
        if (!$event) {
            echo json_encode(['success' => false, 'message' => 'Event not found']);
            exit();
        }

        //check if the user can leave this event
        $userId = $_SESSION['user_id'];
        $role = $_SESSION['role'];

        if ($role === 'volunteer'|| $role === 'representative'|| $role === 'organisationrep') {
            $canleave = $this->calendarctrlvar->canleaveevent($userId, $eventId);
            $event['canleave'] = $canleave['canleave'];
            $event['cantleavereason'] = $canleave['reason'] ?? null;//when they cannot leave as daysuntilevent<2
            $event['daysuntil'] = $canleave['daysuntilevent'] ?? null;//append this info also to events assoc array
        }

        echo json_encode([
            'success' => true,
            'event' => $event
        ]);
        exit();
    }
    
    public function handleleaveevent(){
        //handle event leave/withdrawal

        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['volunteer','representative','organisationrep'])) {
            echo json_encode(['success' => false, 'message' => 'Not authorized']);
            exit();
        }
         if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit();
        }

        $volunteerId = $_SESSION['user_id'];
        $eventId = $_POST['eventId'] ?? null;//obtained from the 'eventId' key of the AJAX form

         if (!$eventId) {
            echo json_encode(['success' => false, 'message' => 'Event ID required']);
            exit();
        }

         // check behavior before allowing leave
         $behaviorcheck = $this->calendarctrlvar->checkvolunteerbehavior($volunteerId);//returns flagged,leavecount,message
        if ($behaviorcheck['flagged']) {
            // log the behavior but still allow leave (with warning)
            $result = $this->calendarctrlvar->leaveevent($volunteerId, $eventId);
            //behaviour check returns flagged,leavecount,message(if leavcount>10)
            if ($result['success']) {
                $result['warning'] = $behaviorcheck['message'];//message is "High frequency of leave counts detected"
                $result['warningdetails'] = "You have left {$behaviorcheck['leavecount']} events in the past 90 days.";
            }
            //message comes from the model if high leavecount therefroe WARNING IS SET only if there is high leave count
            echo json_encode($result);
            //exit();
            return;//as we have to do notification handling in the router
        }
             // normal leave process
        $result = $this->calendarctrlvar->leaveevent($volunteerId, $eventId);
        echo json_encode($result);//return data from leaveevent function
        //exit();
        return;
        

    }







    




    public function filtereventsbytype(){
        //filter events by type handled via AJAX
        header('Content-Type: application/json');
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            exit();
        }
        $userId = $_SESSION['user_id'];
        $role = $_SESSION['role'];
        $eventtype = $_GET['eventtype'] ?? 'all';
        $status = $_GET['status'] ?? 'all'; // enrolled, all, unsponsored,etc(basically the radio buttons)

        $month = $_GET['month'] ?? date('n');
        $year = $_GET['year'] ?? date('Y');

        $startdate = date('Y-m-d', strtotime("$year-$month-01"));
        $lastday = date('t', strtotime($startdate));//gets the last day of the month
        $enddate = date('Y-m-d', strtotime("$year-$month-$lastday"));//adjusts it to the last date of the month

        $events = $this->calendarctrlvar->geteventsbydaterange($userId, $role, $startdate, $enddate);

        // apply filters
        if ($eventtype !== 'all') {
            $events = array_filter($events, function($event) use ($eventtype) {
                return strtolower(string: $event['event_type']) === strtolower($eventtype);//filter and give those of given event type
            });
        }

        if ($status !== 'all') {
            $events = array_filter($events, function($event) use ($status) {
                return ($event['calendarstatus'] ?? 'all') === $status;//must match teh given status from JS
            });//here function takes 1 parameter event and its designed to be called once per element. if it returns true, the element stays in the array
        }

        

         // format for calendar
        $formattedevents = [];
        foreach ($events as $event) {
            $datekey = $event['event_date'];
            
            if (!isset($formattedevents[$datekey])) {
                $formattedevents[$datekey] = [];
            }
             $formattedevents[$datekey][] = [
                'id' => $event['event_id'],
                'title' => $event['name'],
                'type' => $event['event_type'],
                'time' => $event['time'] ?? null,
                'status' => $event['calendarstatus'] ?? 'all',
                'color' => $this->calendarctrlvar->geteventtypecolor($event['event_type'])
            ];
        }
         echo json_encode([
            'success' => true,
            'events' => $formattedevents
        ]);
        exit();





    }

    //private helper functions
    private function getupcomingevents($userId, $role, $limit = 5){
        //get upcoming events for sidebar display

        $today = date('Y-m-d');
        $futuredate = date('Y-m-d', strtotime('+30 days'));
        $events = $this->calendarctrlvar->geteventsbydaterange($userId, $role, $today, $futuredate);

 // sort by date and limit
 //sorts by ascending date (earliest dates first)
        usort($events, function($a, $b) {//usort iterates over $events internally and automatically passes two elements at a time into the callback (function($a, $b){...}) as $a and $b
            return strtotime($a['event_date']) - strtotime($b['event_date']);//callback is a function you pass as a parameter and it will return a value(negative,zero,postitive) to help sort the array
        });//inplace sort(sorts the $events array itself)

        return array_slice($events, 0, $limit);
    
    }
    


    private function getannualevents($userId){

        $today = date('Y-m-d');
        $yearend = date('Y-12-31');
        $registeredannual=$this->calendarctrlvar->getregisteredannualevents($userId,$today,$yearend);
        $unregisteredannual=$this->calendarctrlvar->getunregisteredannualevents($userId,$today,$yearend);
        return[
            'registeredannual'=>$registeredannual,
            'unregisteredannual'=>$unregisteredannual
        ];

            }




}

    
      

?>