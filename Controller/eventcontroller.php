<?php
class eventcontroller
{
    private $model;
    private $calendarmodel;

    public function __construct($eventmodel,$calendarmodel=null)
    {
        $this->model = $eventmodel;
        $this->calendarmodel = $calendarmodel;
    }

    public function createEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // collect form data
            $data = [
                'name' => $_POST['name'] ?? '',
                // 'event_date' => date ('Y-m-d H:i:s', strtotime($_POST['event_date']))?? '', //there is an error
                'event_date' => date('Y-m-d', strtotime($_POST['event_date'])) ?? '',
                'event_type' => $_POST['event_type'] ?? '',
                'time' => $_POST['time'] ?? '', // optional (not in DB yet=>added to DB now)
                'duration' => $_POST['duration'] ?? '',
                'max_participants' => $_POST['max_participants'] ?? 0,
                'starpoints_reward' => $_POST['starpoints_reward'] ?? 0,
                'levelpoints_reward' => $_POST['levelpoints_reward'] ?? 0,
                'location' => $_POST['location'] ?? '',
                'gmap_link' => $_POST['gmap_link'] ?? '',
                'scale' => $_POST['scale'] ?? '',
                'allocated_budget' => $_POST['allocated_budget'] ?? 0,
                'description' => $_POST['description'] ?? '',
                'is_annual' => isset($_POST['is_annual']) ? 1 : 0,
                'is_authorized' => (isset($_SESSION['role']) && $_SESSION['role'] === 'manager' && !isset($_POST['is_annual'])) ? 1 : NULL,
                'organizer_id' => $_SESSION['user_id'] ?? 1  // current logged in user
            ];

            // Get budget items
            $budgetItems = $_POST['budget_items'] ?? [];
            $budgetPrices = $_POST['budget_prices'] ?? [];

            // Call model to insert event
            $eventId  = $this->model->createEvent($data);

            if ($eventId ) {
                // Insert budget items
                if (!empty($budgetItems) && !empty($budgetPrices)) {
                    $this->model->insertBudgetItems($eventId , $budgetItems, $budgetPrices);
                }
                

                header("Location: /V/router.php?module=projects&action=createeventsuccess");
                exit();
            } else {
                echo " Failed to create event.";
            }
        } else {
            include 'View/projects/eventform/eventCreateForm.php'; // your form page http://localhost/V/View/projects/eventform/eventcreateForm.php

        }

    }

    // public function listEvents() {
    //     $events = $this->model->getAllEvents();
    //     include 'View/projects/event.php'; // pass $events to view
    // }
    public function listEvents()
    {

        $filters = [
            'search' => $_GET['search'] ?? '',
            'location' => $_GET['location'] ?? '',
            'event_type' => $_GET['event_type'] ?? '',
            'date' => $_GET['date'] ?? '',
            'is_authorized' => $_GET['is_authorized'] ?? '',
            'is_annual' => $_GET['is_annual'] ?? ''

        ];


        $events = $this->model->getAllEvents($filters);
        $eventmodel = $this->model; 

        $locations = $this->model->getUniqueLocations();
        include 'View/projects/event.php';
    }





    public function deleteEvent($id)
    {
        if ($id) {
            $success = $this->model->deleteEvent($id);
            if ($success) {
                header("Location: /V/router.php?module=projects&action=events");
                exit();
            } else {
                echo " Failed to delete event.";
            }
        } else {
            echo "Invalid Event ID.";
        }
    }




    public function updateEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'event_id' => $_POST['event_id'] ?? null,
                'name' => $_POST['name'] ?? '',
                'event_date' => !empty($_POST['event_date']) ? date('Y-m-d', strtotime($_POST['event_date'])) : null,
                'time' => $_POST['time'] ?? '07:00:00',
                'event_type' => $_POST['event_type'] ?? '',
                'max_participants' => $_POST['max_participants'] ?? 0,
                'starpoints_reward' => $_POST['starpoints_reward'] ?? 0,
                'location' => $_POST['location'] ?? '',
                'description' => $_POST['description'] ?? ''
            ];

            if ($data['event_id']) {
                $success = $this->model->updateEvent($data);
                if ($success) {
                    header("Location: /V/router.php?module=projects&action=events");
                    exit();
                } else {
                    echo "Failed to update event.";
                }
            } else {
                echo "Invalid Event ID.";
            }
        } else {
            echo "Invalid request method.";
        }
    }



    public function joinEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $eventId = $_POST['event_id'] ?? null;
            $volunteerId = $_SESSION['user_id'] ?? null;
            $userRole = $_SESSION['role'] ?? '';
            $joinType = $_POST['joinType'] ?? 'individual';
            $numParticipants = ($joinType === 'group') ? ($_POST['participants'] ?? 1) : 1;

            if (($userRole !== 'volunteer')&&($userRole !== 'representative')&&($userRole !== 'organisationrep')) {
                echo " Only volunteers can join events.";
                return;
            }

            $event = $this->model->getEventById($eventId);
            if ($event && $event['organizer_id'] == $volunteerId) {
                echo "Organizers cannot join their own events.";
                return;
            }

            if ($eventId && $volunteerId) {
                $success = $this->model->joinEvent($eventId, $volunteerId, $numParticipants);
                if ($success) {
                    header("Location: /V/router.php?module=projects&action=projects");
                    exit();
                } else {
                    echo " Failed to join event or already joined.";
                }
            }
        }
    }

    //withdraw function

    public function withdrawEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $eventId = $_POST['event_id'] ?? null;
            $volunteerId = $_SESSION['user_id'] ?? null;
            $role = $_SESSION['role']??'';

            if (!in_array($role, ['volunteer', 'representative', 'organisationrep'])) {
            header("Location: /V/router.php?module=projects&action=projects");
            exit();//boths actions=events and action=projects do the same thing in router
            }

            if ($eventId && $volunteerId) {
                //call calendar's module instead
                $result = $this->calendarmodel->leaveevent($volunteerId, $eventId);
                if ($result['success']) {
                    header("Location: /V/router.php?module=projects&action=projects");
                    exit();
                } else {

                    $_SESSION['message'] = $result['message'];
                    $_SESSION['message_type'] = 'error';
                    header("Location: /V/router.php?module=projects&action=projects");
                    exit();


                }
            }
        }
    }

    public function showEventMap()
    {
        // Check if user is logged in
        if (isset($_SESSION['user_id'])) {
            // Logged-in user: show all authorized events and their registered events
            $userId = $_SESSION['user_id'];
            $locations = $this->model->getAuthorizedUpcomingEvents(); // All authorized events
            $registeredLocations = $this->model->getUserRegisteredUpcomingEvents($userId); // User's registered events
        } else {
            // Not logged in: show all authorized upcoming events
            $locations = $this->model->getAuthorizedUpcomingEvents();
            $registeredLocations = [];
        }

        // Get filter options
        $filterOptions = $this->model->getFilterOptions();

        include 'View/map/eventmap.php';
    }

    // View all events for approval (manager)
    public function viewAllEventsForApproval()
    {
        // Get all events with organizer information
        $events = $this->model->getAllEventsWithOrganizer();

        // Pass to view
        include 'View/projectsapprovals/eventapprovalpanel.php';
    }

    // Approve event
    public function approveEvent()
    {
        if (!isset($_GET['id'])) {
            header("Location: router.php?module=projects&action=projectapprovals");
            exit();
        }

        $eventId = $_GET['id'];

        // Get event details to verify it exists
        $event = $this->model->getEventByIdWithOrganizer($eventId);

        if (!$event) {
            header("Location: router.php?module=projects&action=projectapprovals");
            exit();
        }

        // Update isauthorized to 1 (approved)
        $this->model->updateEventAuthorization($eventId, 1);

        // Redirect back to approvals page
        header("Location: router.php?module=projects&action=projectapprovals");
        exit();
    }

    // Reject event
    public function rejectEvent()
    {
        if (!isset($_GET['id'])) {
            header("Location: router.php?module=projects&action=projectapprovals");
            exit();
        }

        $eventId = $_GET['id'];

        // Get event details to verify it exists
        $event = $this->model->getEventByIdWithOrganizer($eventId);

        if (!$event) {
            header("Location: router.php?module=projects&action=projectapprovals");
            exit();
        }

        // Update isauthorized to 0 (rejected)
        $this->model->updateEventAuthorization($eventId, 0);

        // Redirect back to approvals page
        header("Location: router.php?module=projects&action=projectapprovals");
        exit();
    }







    // Annual Event Approval Views & Actions

    // Show Annual Event Approval Page for Org Rep
    public function showAnnualEventApprovalPage()
    {
        $repId = $_SESSION['user_id'];
        // Fetch ALL events (pending + history) so the tabs work
        $events = $this->model->getAllAnnualEventsForRep($repId);
        // Ensure path matches where we will create the file
        include 'View/representative/orgrep/annualeventapproval/annualeventapproval.php';
    }

    // Show Annual Event Status Page for Manager
    public function showAnnualEventStatusPage()
    {
        $events = $this->model->getAllAnnualEventsWithStatus();
        // Ensure path matches where we will create the file
        include 'View/manager/annualeventstatus/annualeventstatus.php';
    }

    // Handle Annual Event Approval Action
    public function handleAnnualEventApproval()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventId = $_POST['event_id'];
            $status = $_POST['status']; // 'approved' or 'rejected'
            $approverId = $_SESSION['user_id'];

            if ($this->model->addAnnualEventApproval($eventId, $approverId, $status)) {
                // Check if we reached 2 approvals
                $count = $this->model->getAnnualEventApprovalsCount($eventId);
                if ($count >= 2) {
                    $this->model->updateEventAuthorization($eventId, 1);
                }

                // Check if we reched 1 or more rejections
                $rejectionCount = $this->model->getAnnualEventRejectionsCount($eventId);
                if ($rejectionCount >= 1) {
                    $this->model->updateEventAuthorization($eventId, 0);
                }
            }

            header("Location: router.php?module=projects&action=annualeventapproval");
            exit();
        }
    }


    public function getAnnualEvents() 
    {
        return $this->model->getAnnualEvents();
    }

}












?>