<?php
class usermanagementcontroller {
    private $model;

    public function __construct($usermanagementmodel) {
        $this->model = $usermanagementmodel;
    }

    public function viewAllUsers() {
        // Simply load the view - data will be fetched via AJAX
        include 'View/admin/manageusers/usermanagingadminpanel.php';
    }

    public function getUsersData() {
        header('Content-Type: application/json');
        
        $searchTerm = $_GET['search'] ?? '';
        $roleFilter = $_GET['role'] ?? 'all';

        if (!empty($searchTerm) || $roleFilter !== 'all') {
            $users = $this->model->searchUsers($searchTerm, $roleFilter);
        } else {
            $users = $this->model->getAllUsers();
        }

        // Format dates and add user ID prefix
        foreach ($users as &$user) {
            $user['userId'] = 'USR-' . date('Y', strtotime($user['createddate'])) . '-' . str_pad($user['userid'], 3, '0', STR_PAD_LEFT);
            $user['userName'] = $user['name'];
            $user['userEmail'] = $user['email'];
            $user['userContact'] = $user['contactnumber'];
            $user['createdDate'] = date('Y-m-d', strtotime($user['createddate']));
        }

        echo json_encode([
            'success' => true,
            'users' => $users
        ]);
    }

    public function getUserDetails() {
        header('Content-Type: application/json');
        
        $userId = $_GET['id'] ?? null;
        
        if (!$userId) {
            echo json_encode(['success' => false, 'message' => 'User ID required']);
            return;
        }

        $user = $this->model->getUserById($userId);
        
        if (!$user) {
            echo json_encode(['success' => false, 'message' => 'User not found']);
            return;
        }

        // Get additional data for volunteers
        if ($user['role'] === 'volunteer') {
            $user['skills'] = $this->model->getUserSkills($userId);
            $user['availability'] = $this->model->getUserAvailability($userId);
            $user['disabilities'] = $this->model->getUserDisabilities($userId);
            $user['badges'] = $this->model->getUserBadges($userId);
        }

        echo json_encode([
            'success' => true,
            'user' => $user
        ]);
    }

    public function getStats() {
        header('Content-Type: application/json');
        
        $stats = $this->model->getUserStats();
        
        echo json_encode([
            'success' => true,
            'stats' => $stats
        ]);
    }

    public function updateUserData() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $userId = $_POST['userid'] ?? null;
        
        if (!$userId) {
            echo json_encode(['success' => false, 'message' => 'User ID required']);
            return;
        }

        $data = [
            'name' => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'contactnumber' => $_POST['contactnumber'] ?? '',
            'role' => $_POST['role'] ?? ''
        ];

        // Add role-specific data
        if ($data['role'] === 'volunteer') {
            $data['dob'] = $_POST['dob'] ?? null;
            $data['noofmembers'] = $_POST['noofmembers'] ?? 1;
            $data['volunteer_experience'] = $_POST['volunteer_experience'] ?? '';
            $data['preferred_location_1'] = $_POST['preferred_location_1'] ?? '';
            $data['preferred_location_2'] = $_POST['preferred_location_2'] ?? '';
            $data['preferred_location_3'] = $_POST['preferred_location_3'] ?? '';
            
            // Handle skills as array
            if (isset($_POST['skills']) && is_array($_POST['skills'])) {
                $data['skills'] = $_POST['skills'];
            }
            
            // Handle availability as array
            if (isset($_POST['availability']) && is_array($_POST['availability'])) {
                $data['availability'] = $_POST['availability'];
            }
        }

        if ($data['role'] === 'representative') {
            $data['duration'] = $_POST['duration'] ?? 12;
        }

        $result = $this->model->updateUser($userId, $data);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'User updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update user']);
        }
    }

    public function toggleUserStatus() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $userId = $_POST['userid'] ?? null;
        $status = $_POST['status'] ?? null;
        
        if (!$userId || !$status) {
            echo json_encode(['success' => false, 'message' => 'User ID and status required']);
            return;
        }

        if (!in_array($status, ['active', 'suspended'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid status']);
            return;
        }

        $result = $this->model->updateUserStatus($userId, $status);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'User status updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update user status']);
        }
    }

    public function deleteUserAction() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $userId = $_POST['userid'] ?? null;
        
        if (!$userId) {
            echo json_encode(['success' => false, 'message' => 'User ID required']);
            return;
        }

        // Prevent deletion of admin users
        $user = $this->model->getUserById($userId);
        if ($user['role'] === 'admin') {
            echo json_encode(['success' => false, 'message' => 'Cannot delete admin users']);
            return;
        }

        $result = $this->model->deleteUser($userId);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
        }
    }
}
?>