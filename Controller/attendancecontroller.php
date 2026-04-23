<?php
// Controller/attendancecontroller.php
class AttendanceController {
    private $model;

    public function __construct($attendanceModel) {
        $this->model = $attendanceModel;
    }

    /**
     * Endpoint called by the frontend scanner (router.php?module=attendance&action=mark)
     * Expects POST: volunteer_id, event_id
     * Returns JSON.
     */
    public function markAttendance() {
        // Use output buffering to avoid accidental HTML/whitespace in the response
        ob_start();
        header('Content-Type: application/json; charset=utf-8');

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode(['success' => false, 'message' => 'Invalid request method']);
                ob_end_flush();
                exit();
            }

            // ensure session
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            // Log incoming request for debugging
            error_log('Attendance mark called. POST=' . json_encode($_POST) . ' SESSION=' . json_encode([ 'user_id' => $_SESSION['user_id'] ?? null, 'role' => $_SESSION['role'] ?? null ]));

            $raterId = $_SESSION['user_id'] ?? null;
            $role = $_SESSION['role'] ?? null;

            if (!$raterId) {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Not authenticated.']);
                ob_end_clean();
                exit();
            }

            // Allow only authorized roles to mark attendance
            $allowedRoles = ['manager', 'representative', 'admin'];
            if (!in_array($role, $allowedRoles)) {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Unauthorized. Only managers/representatives/admin can mark attendance.']);
                ob_end_clean();
                exit();
            }

            $volunteerId = isset($_POST['volunteer_id']) ? intval($_POST['volunteer_id']) : 0;
            $eventId = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;

            if ($volunteerId <= 0 || $eventId <= 0) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Missing or invalid volunteer_id / event_id']);
                ob_end_clean();
                exit();
            }

            // validate volunteer & event existence
            if (!$this->model->volunteerExists($volunteerId)) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Volunteer not found']);
                ob_end_clean();
                exit();
            }
            if (!$this->model->eventExists($eventId)) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Event not found']);
                ob_end_clean();
                exit();
            }

            // Check volunteer is enrolled with status 'registered'
if (!$this->model->isVolunteerRegistered($volunteerId, $eventId)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Volunteer is not enrolled in this event.']);
    ob_end_clean();
    exit();
}



            // attendance_score — you can adjust scoring logic here (1 = attended)
            $attendanceScore = 5;

            $result = $this->model->upsertAttendance($eventId, $volunteerId, $raterId, $attendanceScore);

            if ($result['success']) {
                // success — return volunteer id for UI
                echo json_encode(['success' => true, 'message' => $result['message'], 'volunteer_id' => $volunteerId]);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => $result['message']]);
            }
            // Clean any buffered output (remove accidental HTML) and send response
            ob_end_flush();
            exit();

        } catch (Exception $ex) {
            // Ensure any stray output is cleared and log the exception
            ob_end_clean();
            error_log('AttendanceController exception: ' . $ex->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Server error']);
            exit();
        }
    }


    
}
