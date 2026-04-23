<?php

class taskratingcontroller
{
    private $ctrlvar;

    public function __construct($model)
    {
        $this->ctrlvar = $model;
    }

    public function rendertaskrating()
    {
        //get details to render the UI
        $eventId = $_GET['event_id'] ?? null;
        $currentuserId = $_SESSION['user_id'] ?? null;
        if (!$eventId || !$currentuserId) {
            echo 'Error!';
        }
        try {
            $eventdetails = $this->ctrlvar->geteventdetails($eventId);
            $tasksofevent = $this->ctrlvar->gettaskdetails($eventId);//returns an entire table (of task table) with all the ids and stuff essentially where each row has (task_id, name, description, status, event_id, max_participants, current_participants, organizer_id, createddate)
            $progress = $this->gettaskratingstatus($eventId, $currentuserId);
            //return the following (key-value pairs) [specific format] onto taskrateresult variable in router which is then accessed in teh php page included after that variable (i.e. ratetask.php)
            return [
                'success' => true,
                'event' => $eventdetails,
                'tasks' => $tasksofevent,//bind the results to easily addressable key value pairs (key pairs)
                'progress' => $progress
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function submittaskrating()
    {//allow organizers to rate the tasks and record that in the DB
        //handles submission of task based ratings thruh AJAX (client side JS fetch() sends a POST request here with taskrating info)
        header('Content-Type:application/json');//tells the browser that the server is sending JSON data not HTML
        //so fetch().then(response => response.json()) on the JS side will work
        try {
            $taskId = $_POST['task_id'] ?? null;
            $rating = $_POST['rating'] ?? null;
            $comment = $_POST['comment'] ?? null;
            $raterId = $_SESSION['user_id'] ?? null;
            //Gets values sent via JS FormData + ?? null ensures a default null if the key isnΓÇÖt present
            //validate inputs
            if (!$taskId || !$rating || !$raterId) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Missing required data'
                ]);
                return;//checks that all necessary data is present + If not, sends JSON back with success=false
            }
            //validate rating range (1-5)
            if ($rating < 1 || $rating > 5) {//JSON is lightweight data format used for sending data between frontend Γåö backend
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid rating value'
                ]);
                return;
            }
            //get all volunteers who worked in THIS task (forms are  sent relevant to each task card)
            $volunteers = $this->ctrlvar->getvolunteersoftask($taskId);
            if (empty($volunteers)) {
                echo json_encode([//json_encode() = PHP function that converts a PHP array into JSON(JSON format is {"success":true,"message":"Rating saved"})
                    'success' => false,
                    'message' => 'No volunteers found for this task'
                ]);
                return;
            }
            //insert the SAME rating for ALL volunteers in this task

            foreach ($volunteers as $volunteer) {
                $this->ctrlvar->createtaskrating($taskId, $volunteer['userid'], $raterId, $rating, $comment);
            }
            echo json_encode([
                'success' => true,
                'message' => 'Rating submitted successfully'
            ]);
        }//JS fetch() then gets this JSON and updates the UI
        catch (Exception $e) {//catches any unexpected error and sends it back as JSON
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }


    }

    public function gettaskratingstatus($eventId, $currentuserId)
    {
        //get total amount of tasks with that eventID and then find how much is already submitted as of now        
        //get rating status of tasks(completed/pending) by comparing tasks in task table and tasks in task_performancee_rating
        try {
            $alltasks = $this->ctrlvar->gettaskdetails($eventId);//get all tasks of considered eventId
            $total = count($alltasks);
            $submitted = $this->ctrlvar->getsubmittedtaskratings($eventId, $currentuserId);
            //gets a list of all ratings eg: 5 ratings for a single task therefore need to filter unique tasks
            $ratedtaskIds = array_unique(array_column($submitted, 'task_id'));
            $completed = count($ratedtaskIds);
            $pending = $total - $completed;
            return [
                'total' => $total,
                'completed' => $completed,
                'pending' => $pending,
                'percentage' => $total > 0 ? round(($completed / $total) * 100, 1) : 0,
                'is_complete' => $total> 0 ? $pending === 0 : false 
                //treating events that do not have task ratings as incomplete events
            ];
        } catch (Exception $e) {
            return [
                'total' => 0,
                'completed' => 0,
                'pending' => 0,
                'percentage' => 0,
                'is_complete' => false,
                'error' => $e->getMessage()
            ];

        }
    }

}
?>
