<?php
class requestcontroller
{
    private $requestModel;
    private $userModel;
    private $volunteerModel;
    private $representativeModel;

    public function __construct($requestModel, $userModel, $volunteerModel, $representativeModel)
    {
        $this->requestModel = $requestModel;
        $this->userModel = $userModel;
        $this->volunteerModel = $volunteerModel;
        $this->representativeModel = $representativeModel;
    }

    public function getAllRepApplications()
    {
        return $this->requestModel->getAllRepApplications();
    }

    public function getAllRepApplicantsDetails()
    {
        $applications = $this->getAllRepApplications();
        $applicantDetails = [];

        foreach ($applications as $application) {
            $userId = $application['requester_volunteer_id'];
            $userData = $this->userModel->getuserbyid($userId);
            $locationData = $this->volunteerModel->getvolunteerlocations($userId);
            $applicantDetails[] = [
                'application' => $application,
                'user' => $userData,
                'locations' => $locationData
            ];
        }

        return $applicantDetails;
    }

    public function viewAllRepApplications()
    {
        $applicantDetails = $this->getAllRepApplicantsDetails();
        include 'View/manager/approvereppost/applicationapprovalpanel.php';
    }

    // Approve representative application
    public function approveApplication()
    {
        if (!isset($_GET['id'])) {
            header("Location: router.php?module=manager&action=approvereppost");
            exit();
        }

        $requestId = $_GET['id'];

        // Get manager ID from session
        $managerId = $_SESSION['user_id'];

        // Get request details
        $request = $this->requestModel->getRequestById($requestId);

        if (!$request) {
            header("Location: router.php?module=manager&action=approvereppost");
            exit();
        }

        $userId = $request['requester_volunteer_id'];

        // Check if user is already a representative
        $alreadyRep = $this->representativeModel->checkIfRepresentative($userId);

        // If not a rep OR is an inactive rep, insert/update
        if (!$alreadyRep || $alreadyRep['is_active'] == 0) {
            // Insert into representative table with 12 months duration and current date
            $this->representativeModel->insertRepresentative($userId, 12);
        }

        // Update request status AND manager ID
        $this->requestModel->updateRequestStatusWithManager($requestId, 'approved', $managerId);

        // Update user role to representative
        $this->userModel->updateUserRole($userId, 'representative');

        // Redirect back to applications page
        header("Location: router.php?module=manager&action=approvereppost");
        exit();
    }

    // Reject representative application
    public function rejectApplication()
    {
        if (!isset($_GET['id'])) {
            header("Location: router.php?module=manager&action=approvereppost");
            exit();
        }

        $requestId = $_GET['id'];

        // Get manager ID from session
        $managerId = $_SESSION['user_id'];

        // Update request status AND manager ID
        $this->requestModel->updateRequestStatusWithManager($requestId, 'rejected', $managerId);

        // Redirect back to applications page
        header("Location: router.php?module=manager&action=approvereppost");
        exit();
    }
}
?>