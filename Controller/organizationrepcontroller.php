<?php
class organizationrepcontroller
{
    private $orgRepModel;
    private $representativeModel;

    public function __construct($orgRepModel, $representativeModel)
    {
        $this->orgRepModel = $orgRepModel;
        $this->representativeModel = $representativeModel;
    }



    // Show the organization representative selection page
    public function showOrgRepSelectionPage()
    {
        // Check if user is a manager
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
            header("Location: /V/router.php?module=page&action=homepage");
            exit();
        }

        // Get current organization representatives
        $currentOrgReps = $this->orgRepModel->getCurrentOrgRepresentatives();
        $currentOrgRepsCount = count($currentOrgReps);
        $neededCount = 2 - $currentOrgRepsCount;

        // Get all available representatives (those who are not org reps)
        $availableRepresentatives = $this->orgRepModel->getAllRepresentatives();

        // Include the view
        include 'View/manager/organizationrep/selectorganizationrep.php';
    }

    // Handle the selection of organization representatives
    public function selectOrgRepresentatives()
    {
        // Check if user is a manager
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
            header("Location: /V/router.php?module=page&action=homepage");
            exit();
        }

        // Check if form was submitted
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /V/router.php?module=manager&action=selectorgrep");
            exit();
        }

        // Get selected representatives from POST
        $selectedReps = isset($_POST['selected_reps']) ? $_POST['selected_reps'] : [];

        // Check current org reps count and calculate how many can be appointed
        $currentCount = $this->orgRepModel->countCurrentOrgReps();
        $neededCount = 2 - $currentCount;

        if ($neededCount <= 0) {
            $_SESSION['error_message'] = "2 Organization Representatives are already appointed. Cannot appoint more.";
            header("Location: /V/router.php?module=manager&action=selectorgrep");
            exit();
        }

        // Validate that correct number of representatives are selected
        if (count($selectedReps) !== $neededCount) {
            $_SESSION['error_message'] = "Please select exactly " . $neededCount . " representative(s).";
            header("Location: /V/router.php?module=manager&action=selectorgrep");
            exit();
        }

        // Promote selected representatives to organization representatives
        $successCount = 0;
        foreach ($selectedReps as $userId) {
            if ($this->orgRepModel->promoteToOrgRep($userId)) {
                $successCount++;
            }
        }

        // Set success message
        if ($successCount === $neededCount) {
            $_SESSION['success_message'] = "Successfully appointed " . $successCount . " Organization Representative(s) for 12 months.";
        } else {
            $_SESSION['error_message'] = "Some representatives could not be appointed. Please try again.";
        }

        header("Location: /V/router.php?module=manager&action=selectorgrep");
        exit();
    }

    // Get organization representatives data (for AJAX if needed in future)
    public function getOrgRepsData()
    {
        header('Content-Type: application/json');

        $currentOrgReps = $this->orgRepModel->getCurrentOrgRepresentatives();
        $availableReps = $this->orgRepModel->getAllRepresentatives();

        echo json_encode([
            'success' => true,
            'currentOrgReps' => $currentOrgReps,
            'availableReps' => $availableReps,
            'currentCount' => count($currentOrgReps)
        ]);
        exit();
    }


}
?>