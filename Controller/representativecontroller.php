<?php
class representativecontroller
{
    private $userModel;
    private $volunteerModel;
    private $representativeModel;

    public function __construct($userModel, $volunteerModel, $representativeModel)
    {
        $this->userModel = $userModel;
        $this->volunteerModel = $volunteerModel;
        $this->representativeModel = $representativeModel;
    }

    public function loadApplicationForm()
    {
        $userId = $_SESSION['user_id'];
        $userData = $this->userModel->getuserbyid($userId);
        $locationData = $this->volunteerModel->getvolunteerlocations($userId);

        
        if (!$locationData || !is_array($locationData)) {
            $locationData = [];
        }
        $locationData['preferred_location_1'] = $locationData['preferred_location_1'] ?? 'Not Set';
        $locationData['preferred_location_2'] = $locationData['preferred_location_2'] ?? 'Not Set';

        
        $isEditMode = isset($_GET['mode']) && $_GET['mode'] === 'edit';

        $existingApplication = null;

        if ($isEditMode) {
            $existingApplication = $this->representativeModel->checkExistingApplication($userId);

            
            if ($existingApplication) {
                $_SESSION['status'] = $existingApplication['status'];
            } else {
                
                $_SESSION['toast_message'] = "No existing application found.";
                $_SESSION['toast_type'] = "error";
                header("Location: router.php?module=volunteer&action=berepresentative");
                exit();
            }
        } else {
            
            $existingApplication = $this->representativeModel->checkExistingApplication($userId);
            if ($existingApplication) {
                $_SESSION['toast_message'] = "You already have an application. Redirecting to view page.";
                $_SESSION['toast_type'] = "info";
                header("Location: router.php?module=volunteer&action=submittedapplication");
                exit();
            }
        }

        include 'View/applyreppost/representativeapplication/representativeapplication.php';
    }

    public function checkExistingApplication()
    {
        $userId = $_SESSION['user_id'];
        $userData = $this->userModel->getuserbyid($userId);
        $locationData = $this->volunteerModel->getvolunteerlocations($userId);

        
        if (!$locationData || !is_array($locationData)) {
            $locationData = [];
        }
        $locationData['preferred_location_1'] = $locationData['preferred_location_1'] ?? 'Not Set';
        $locationData['preferred_location_2'] = $locationData['preferred_location_2'] ?? 'Not Set';

        $exists = $this->representativeModel->checkExistingApplication($userId);

        
        if ($exists) {
            $_SESSION['status'] = $exists['status'];
        } else {
            
            $_SESSION['toast_message'] = "No application found. Please submit an application first.";
            $_SESSION['toast_type'] = "info";
            header("Location: router.php?module=volunteer&action=berepresentative");
            exit();
        }

        include 'View/applyreppost/submittedapplication/submittedapplication.php';
    }

    public function submitApplication()
    {
        $userId = $_SESSION['user_id'];

        
        $existingApplication = $this->representativeModel->checkExistingApplication($userId);
        if ($existingApplication) {
            $_SESSION['toast_message'] = "You already have an application. Please edit or delete it first.";
            $_SESSION['toast_type'] = "error";
            header("Location: router.php?module=volunteer&action=submittedapplication");
            exit();
        }

        
        if (!isset($_POST['termsAccepted']) || $_POST['termsAccepted'] !== 'on') {
            $_SESSION['toast_message'] = "You must accept the terms and conditions!";
            $_SESSION['toast_type'] = "error";
            header("Location: router.php?module=volunteer&action=berepresentative");
            exit();
        }

        $data = [
            'requester_volunteer_id' => $userId,
            'description' => trim($_POST['reason']),
            'linkedin' => trim($_POST['professionallinks']),
            'experience' => trim($_POST['experience']),
            'status' => 'pending',
            'type' => 'applytoberep'
        ];


        if (empty($data['description'])) {
            $_SESSION['toast_message'] = "Please provide a reason for your application!";
            $_SESSION['toast_type'] = "error";
            header("Location: router.php?module=volunteer&action=berepresentative");
            exit();
        }

        $inserted = $this->representativeModel->insertApplication($data);

        if ($inserted) {
            
            $_SESSION['status'] = 'pending';

            
            $_SESSION['toast_message'] = "Application submitted successfully!";
            $_SESSION['toast_type'] = "success";

            
            header("Location: router.php?module=page&action=homepage");
            exit();
        } else {
            $_SESSION['toast_message'] = "Failed to submit application. Please try again.";
            $_SESSION['toast_type'] = "error";
            header("Location: router.php?module=volunteer&action=berepresentative");
            exit();
        }
    }

    public function updateApplication()
    {
        $userId = $_SESSION['user_id'];

        
        if (!isset($_POST['termsAccepted']) || $_POST['termsAccepted'] !== 'on') {
            $_SESSION['toast_message'] = "You must accept the terms and conditions!";
            $_SESSION['toast_type'] = "error";
            header("Location: router.php?module=volunteer&action=berepresentative&mode=edit");
            exit();
        }

        
        $existingApplication = $this->representativeModel->checkExistingApplication($userId);

        if (!$existingApplication) {
            $_SESSION['toast_message'] = "No existing application found to update.";
            $_SESSION['toast_type'] = "error";
            header("Location: router.php?module=page&action=homepage");
            exit();
        }

        $data = [
            'description' => trim($_POST['reason']),
            'linkedin' => trim($_POST['professionallinks']),
            'experience' => trim($_POST['experience']),
            'status' => 'pending' 
        ];

        
        if (empty($data['description'])) {
            $_SESSION['toast_message'] = "Please provide a reason for your application!";
            $_SESSION['toast_type'] = "error";
            header("Location: router.php?module=volunteer&action=berepresentative&mode=edit");
            exit();
        }

        $updated = $this->representativeModel->updateApplication($userId, $data);

        if ($updated) {
            
            $_SESSION['status'] = 'pending';

            
            $_SESSION['toast_message'] = "Application updated successfully!";
            $_SESSION['toast_type'] = "success";

            
            header("Location: router.php?module=volunteer&action=submittedapplication");
            exit();
        } else {
            $_SESSION['toast_message'] = "Failed to update application. Please try again.";
            $_SESSION['toast_type'] = "error";
            header("Location: router.php?module=volunteer&action=berepresentative&mode=edit");
            exit();
        }
    }

    public function deleteApplication()
    {
        $userId = $_SESSION['user_id'];

        
        $existingApplication = $this->representativeModel->checkExistingApplication($userId);

        if (!$existingApplication) {
            $_SESSION['toast_message'] = "No application found to delete.";
            $_SESSION['toast_type'] = "error";
            header("Location: router.php?module=page&action=homepage");
            exit();
        }

        
        $deleted = $this->representativeModel->deleteApplication($userId);

        if ($deleted) {

            unset($_SESSION['status']);

            
            $_SESSION['toast_message'] = "Application deleted successfully!";
            $_SESSION['toast_type'] = "success";

            
            header("Location: router.php?module=page&action=homepage");
            exit();
        } else {
            $_SESSION['toast_message'] = "Failed to delete application. Please try again.";
            $_SESSION['toast_type'] = "error";
            header("Location: router.php?module=volunteer&action=submittedapplication");
            exit();
        }
    }
    
    public function manageRepresentatives()
    {
        
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
            $_SESSION['toast_message'] = "Access Denied.";
            $_SESSION['toast_type'] = "error";
            header("Location: router.php?module=page&action=homepage");
            exit();
        }

        $representatives = $this->representativeModel->getActiveRepresentatives();
        $pendingApplicationsCount = $this->representativeModel->getTotalPendingApplications();
        include 'View/manager/managerepresentatives/managerepresentatives.php';
    }


}
?>