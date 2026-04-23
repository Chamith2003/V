<?php
class taskcontroller
{
    private $ctrlvar;

    public function __construct($model)
    {
        $this->ctrlvar = $model;
    }

    // Check if user is logged in
    private function checkAuth()
    {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        return true;
    }

    public function createTask($data)
    {
        try {
            // Check authentication added level eventhough u can only see only if you are logged in as manager
            if (!$this->checkAuth()) {
                return ['success' => false, 'message' => 'You must be logged in to create tasks'];
            }

            // Validate input data
            if (empty($data['name']) || empty($data['description'])) {
                return ['success' => false, 'message' => 'Title and description are required'];
            }

            if (!isset($data['max_participants']) || $data['max_participants'] < 1) {
                return ['success' => false, 'message' => 'Required volunteers must be at least 1'];
            }

            if (!in_array($data['status'], ['inprogress', 'pending', 'completed', 'cancelled'])) {
                return ['success' => false, 'message' => 'Invalid status'];
            }

//unused anyway so its dead code here
//             $stmt = $this->ctrlvar->getConnection()->prepare("
//     SELECT event_id FROM volunteering_program 
//     WHERE organizer_id = ? AND state_of_event IN ('planned', 'active')
//     ORDER BY event_date DESC 
//     LIMIT 1
// ");
//             $stmt->bind_param("i", $_SESSION['user_id']);
//             $stmt->execute();
//             $result = $stmt->get_result();
//             $event = $result->fetch_assoc();

            $taskData = [
                'name' => trim($data['name']),
                'description' => trim($data['description']),
                'status' => $data['status'],
                // 'event_id' => $event ? $event['event_id'] : null,
                'event_id' => (int) $data['event_id'],
                'max_participants' => (int) $data['max_participants'],
                'organizer_id' => $_SESSION['user_id']
            ];

            $result = $this->ctrlvar->createTask($taskData);

            if ($result) {
                return ['success' => true, 'message' => 'Task created successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to create task'];
            }
        } catch (Exception $e) {
            error_log("Error creating task: " . $e->getMessage());//record the error in the error log and ouptut a user understandable error message
            return ['success' => false, 'message' => 'An error occurred while creating the task'];
        }
    }

    public function updateTask($taskId, $data)
    {
        try {
            // Check authentication
            if (!$this->checkAuth()) {
                return ['success' => false, 'message' => 'You must be logged in to update tasks'];
            }

            // Validate task exists and user has permission
            $existingTask = $this->ctrlvar->getTaskById($taskId);
            if (!$existingTask) {
                return ['success' => false, 'message' => 'Task not found'];
            }

            // Check if user has permission to edit (task creator or admin)
            if ($existingTask['organizer_id'] != $_SESSION['user_id'] && $_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'representative') {
                return ['success' => false, 'message' => 'Unauthorized to edit this task'];
            }

            // Validate input data
            if (empty($data['name']) || empty($data['description'])) {
                return ['success' => false, 'message' => 'Title and description are required'];
            }

            if (!isset($data['max_participants']) || $data['max_participants'] < 1) {
                return ['success' => false, 'message' => 'Required volunteers must be at least 1'];
            }

            if (!in_array($data['status'], ['pending', 'inprogress', 'completed', 'cancelled'])) {
                return ['success' => false, 'message' => 'Invalid status'];
            }

            // Clean input data
            $taskData = [
                'name' => trim($data['name']),
                'description' => trim($data['description']),
                'event_id' => $data['event_id'] ?? null, // Add null fallback
                'max_participants' => (int) $data['max_participants'],
                'status' => $data['status'],
                'organizer_id' => $_SESSION['user_id']
            ];

            $result = $this->ctrlvar->updateTask($taskId, $taskData);

            if ($result) {
                return ['success' => true, 'message' => 'Task updated successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to update task'];
            }
        } catch (Exception $e) {
            error_log("Error updating task: " . $e->getMessage());
            return ['success' => false, 'message' => 'An error occurred while updating the task'];
        }
    }

    public function deleteTask($taskId)
    {
        try {
            // Check authentication
            if (!$this->checkAuth()) {
                return ['success' => false, 'message' => 'You must be logged in to delete tasks'];
            }

            // Validate task exists and user has permission
            $existingTask = $this->ctrlvar->getTaskById($taskId);
            if (!$existingTask) {
                return ['success' => false, 'message' => 'Task not found'];
            }

            // Check if user has permission to delete (task creator or admin)
            if ($existingTask['organizer_id'] != $_SESSION['user_id'] && $_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'representative') {
                return ['success' => false, 'message' => 'Unauthorized to delete this task'];
            }

            $result = $this->ctrlvar->deleteTask($taskId);

            if ($result) {
                return ['success' => true, 'message' => 'Task deleted successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to delete task'];
            }
        } catch (Exception $e) {
            error_log("Error deleting task: " . $e->getMessage());
            return ['success' => false, 'message' => 'An error occurred while deleting the task'];
        }
    }

    public function getAllTasks($eventId)
    {
        try {

            $tasks = $this->ctrlvar->fetchTasksByEvent($eventId);
            // Get event name
            $eventName = $this->ctrlvar->getEventName($eventId);

            //Get assigned volunteers for each task
            foreach ($tasks as &$task) {
                $task['assigned_volunteers'] = $this->ctrlvar->getTaskVolunteers($task['task_id']);

            }
            unset($task); // Break the reference(safety measure to prevent the referencing to $tasks)
            return ['success' => true, 'data' => $tasks, 'event_name' => $eventName];
            // return ['success' => true, 'data' => $tasks];
        } catch (Exception $e) {
            error_log("Error getting tasks: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to load tasks', 'data' => []];
        }
    }


    public function assignVolunteer($taskId, $volunteerId)
    {
        try {
            // Check authentication
            if (!$this->checkAuth()) {
                return ['success' => false, 'message' => 'You must be logged in to assign volunteers'];
            }

            // Validate task exists
            $task = $this->ctrlvar->getTaskById($taskId);
            if (!$task) {
                return ['success' => false, 'message' => 'Task not found'];
            }

            // Check if task is active
            if (in_array($task['status'], ['completed', 'cancelled'])) {
                return ['success' => false, 'message' => 'Cannot assign volunteers to completed or cancelled tasks'];
            }

            // Check if task already has maximum volunteers
            $assignedVolunteers = $this->ctrlvar->getTaskVolunteers($taskId);
            if (count($assignedVolunteers) >= $task['max_participants']) {
                return ['success' => false, 'message' => 'Task already has the maximum number of volunteers'];
            }

            // Check if volunteer exists
            $volunteer = $this->ctrlvar->getVolunteerById($volunteerId);
            if (!$volunteer) {
                return ['success' => false, 'message' => 'Volunteer not found'];
            }

            // Check if volunteer is already assigned to this task
            $isAlreadyAssigned = $this->ctrlvar->isVolunteerAssignedToTask($taskId, $volunteerId);
            if ($isAlreadyAssigned) {
                return ['success' => false, 'message' => 'Volunteer is already assigned to this task'];
            }

            $result = $this->ctrlvar->assignVolunteerToTask($taskId, $volunteerId);

            if ($result) {
                return ['success' => true, 'message' => 'Volunteer assigned successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to assign volunteer'];
            }
        } catch (Exception $e) {
            error_log("Error assigning volunteer: " . $e->getMessage());
            return ['success' => false, 'message' => 'An error occurred while assigning volunteer'];
        }
    }

    public function removeVolunteer($taskId, $volunteerId)
    {
        try {
            // Check authentication
            if (!$this->checkAuth()) {
                return ['success' => false, 'message' => 'You must be logged in to remove volunteers'];
            }

            // Validate task exists
            $task = $this->ctrlvar->getTaskById($taskId);
            if (!$task) {
                return ['success' => false, 'message' => 'Task not found'];
            }

            // Check if volunteer is assigned to this task
            $isAssigned = $this->ctrlvar->isVolunteerAssignedToTask($taskId, $volunteerId);
            if (!$isAssigned) {
                return ['success' => false, 'message' => 'Volunteer is not assigned to this task'];
            }

            $result = $this->ctrlvar->removeVolunteerFromTask($taskId, $volunteerId);

            if ($result) {
                return ['success' => true, 'message' => 'Volunteer removed successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to remove volunteer'];
            }
        } catch (Exception $e) {
            error_log("Error removing volunteer: " . $e->getMessage());
            return ['success' => false, 'message' => 'An error occurred while removing volunteer'];
        }
    }

    public function getUnassignedVolunteers($eventId)
    {
        try {
            $volunteers = $this->ctrlvar->fetchUnassignedVolunteersByEvent($eventId);
            return ['success' => true, 'data' => $volunteers];
        } catch (Exception $e) {
            error_log("Error getting unassigned volunteers: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to load volunteers', 'data' => []];
        }
    }


    // public function getTaskVolunteers($taskId)
    // {
    //     try {
    //         $volunteers = $this->ctrlvar->getTaskVolunteers($taskId);
    //         return ['success' => true, 'data' => $volunteers];
    //     } catch (Exception $e) {
    //         error_log("Error getting task volunteers: " . $e->getMessage());
    //         return ['success' => false, 'message' => 'Failed to load task volunteers', 'data' => []];
    //     }
    // }


    // Helper method to display session messages
    public function displaySessionMessage()
    {
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            $messageType = $_SESSION['message_type'] ?? 'info';

            echo "<div class='message message-{$messageType}' style='margin: 10px 0; padding: 10px; border-radius: 5px;font-family: Roboto; ";

            if ($messageType == 'success') {
                echo "background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;";
            } elseif ($messageType == 'error') {
                echo "background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;";
            } else {
                echo "background-color: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb;";
            }

            echo "'>{$message}</div>";

            // Clear the message after displaying
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
    }
}
?>