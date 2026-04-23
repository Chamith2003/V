<?php
class usercontroller
{

    private $ctrlvar;
    private $representativeModel;
    private $organizationRepModel;

    public function __construct($model, $representativeModel = null, $organizationRepModel = null)
    {
        $this->ctrlvar = $model;
        $this->representativeModel = $representativeModel;
        $this->organizationRepModel = $organizationRepModel;
        //store the passed model in $ctrlvar for use in the rest of the file
    }
    public function trimname($fullname)
    {
        $namearray = explode(' ', trim($fullname));//trim is a standard php funciton that removes the spaces at start and ened of fullname
        return $namearray[0];//explode splits it at the spaces
    }
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //process login only if form is submitted as POST
            $email = $_POST['email'];
            $password = $_POST['password'];
            //get form input to our code

            $user = $this->ctrlvar->getemail($email);
            //store returning user from usermodel's getemail function
            if ($user && password_verify($password, $user['password'])) {
                //check plain-text password with hashed password in the datasbe

                if (isset($user['status']) && $user['status'] === 'suspended') {
                    $_SESSION['login_error'] = "This account not found. Please contact support.";
                    header("Location: /V/router.php?module=user&action=login");
                    exit();
                }

                // Check for term expiration and downgrade if necessary
                if ($user['role'] === 'representative' && $this->representativeModel) {
                    if ($this->representativeModel->isTermExpired($user['userid'])) {
                        if ($this->representativeModel->downgradeToVolunteer($user['userid'])) {
                            $user['role'] = 'volunteer'; // Update local user variable
                        }
                    }
                } elseif ($user['role'] === 'organisationrep' && $this->organizationRepModel) {
                    if ($this->organizationRepModel->isTermExpired($user['userid'])) {
                        if ($this->organizationRepModel->downgradeToVolunteer($user['userid'])) {
                            $user['role'] = 'volunteer'; // Update local user variable
                        }
                    }
                }

                $_SESSION['user_id'] = $user['userid'];
                //store the userid form database in the session variable to keep user logged in all pages
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                // Store profile_path in session for navbar access 
                $_SESSION['name'] = $this->trimname($user['name']);//use this because we are in the same class
                //intercept normal browser flow and redirect
                // header("Location: " . $_SERVER['HTTP_REFERER']);
                // exit;
                //bounce back to where they came from


                //store profile_path in session for navbar access
                if (isset($user['profile_path']) && !empty($user['profile_path'])) {
                    $_SESSION['profile_path'] = $user['profile_path'];
                } else {
                    // Set default profile picture if none exists
                    $_SESSION['profile_path'] = '/V/View/userdash/settings/img/profile.jpg';
                }

                header("Location: /V/router.php?module=page&action=homepage");
                exit();
                // echo "Login Successful for ".$user['email'];
            } else {
                // echo "Invalid Credentials";
                $_SESSION['login_error'] = "Invalid email or password";
                header("Location: /V/router.php?module=user&action=login");
                exit();
            }


        } else {
            include 'view/login/login.php';
        }
    }


    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        header("Location: /V/router.php?module=page&action=homepage");
        exit();
        // echo "Logged out";
    }
    public function profile($achievementdata)
    {
        // User must be logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: /V/router.php?module=user&action=login");
            exit();
        }

        $userId = $_SESSION['user_id'];

        $userRole = $_SESSION['role'] ?? null;

        // Fetch profile data from model
        // $data = $this->ctrlvar->getuserandvolunteerbyid($userId);
        if ($userRole === 'sponsor') {
            $data = $this->ctrlvar->getuserbyidwithsponsor($userId);
        } else {
            $data = $this->ctrlvar->getuserandvolunteerbyid($userId);
        }

        $availabilities = [];
        if ($data && $data['role'] === 'volunteer' || $data['role'] === 'representative' || $data['role'] === 'organisationrep') {
            $availabilities = $this->ctrlvar->getVolunteerAvailability($userId);
        }


        if (!$data) {
            echo "Profile not found";
            exit();
        }

        // Sync profile_path with session from database
        if (isset($data['profile_path']) && !empty($data['profile_path'])) {
            $_SESSION['profile_path'] = $data['profile_path'];
        } else {
            $_SESSION['profile_path'] = '/V/View/userdash/settings/img/profile.jpg';
        }

        // Pass $data to your view
        $user = $data;

        include 'View/userdash/settings/settings.php';//can access $achivementdata no need to reassign
    }

    public function profileEdit()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /V/router.php?module=user&action=login");
            exit();
        }

        $userId = $_SESSION['user_id'];

        $data = $this->ctrlvar->getuserandvolunteerbyid($userId);



        include './View/userdash/settings/settings.php';
    }
    public function profileUpdate()
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /V/router.php?module=user&action=profile");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $userRole = $_SESSION['role'] ?? null;

        // Read form values
        $name = $_POST['name'];
        $email = $_POST['email'];
        $contactnumber = $_POST['contactnumber'];

        if ($userRole === 'sponsor') {
            // Sponsor-specific fields
            $business_registration_number = $_POST['business_registration_number'] ?? null;
            $year_established = $_POST['year_established'] ?? null;
            $official_website_link = $_POST['official_website_link'] ?? null;
            $about_company = $_POST['about_company'] ?? null;
            $organization_type = $_POST['organization_type'] ?? null;
            $contact_person_name = $_POST['contact_person_name'] ?? null;
            $contact_person_role = $_POST['contact_person_role'] ?? null;
            $contact_person_email = $_POST['contact_person_email'] ?? null;
            $contact_person_contact_number = $_POST['contact_person_contact_number'] ?? null;


            $result = $this->ctrlvar->updateSponsorProfile(
                $userId,
                $name,
                $email,
                $contactnumber,
                $business_registration_number,
                $year_established,
                $official_website_link,
                $about_company,
                $organization_type,
                $contact_person_name,
                $contact_person_role,
                $contact_person_email,
                $contact_person_contact_number,

            );

            if ($result) {
                $this->jsonResponse(['success' => true, 'message' => 'Business information updated successfully'], 200);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'Update failed'], 500);
            }

        } else {

            // Volunteer-only fields (optional)
            $dob = $_POST['dob'] ?? null;
            $volunteer_experience = $_POST['volunteer_experience'] ?? null;
            $preferred_location_1 = $_POST['preferred_location_1'] ?? null;
            $preferred_location_2 = $_POST['preferred_location_2'] ?? null;
            $preferred_location_3 = $_POST['preferred_location_3'] ?? null;

            // Update in DB
            $result = $this->ctrlvar->updateUserAndVolunteer(
                $userId,
                $name,
                $email,
                $contactnumber,
                $dob,
                $volunteer_experience,
                $preferred_location_1,
                $preferred_location_2,
                $preferred_location_3
            );

            // if ($result) {
            //     header("Location: /V/router.php?module=user&action=profile&success=1");
            //     exit();
            // } else {
            //     echo "Update failed!";
            // }
            if ($result) {
                // Also update availability if volunteer
                if (isset($_SESSION['role']) && $_SESSION['role'] === 'volunteer') {
                    $availability = [];
                    $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                    $times = ['Morning', 'Afternoon', 'Evening'];

                    foreach ($days as $day) {
                        foreach ($times as $time) {
                            $key = $day . '_' . $time;
                            if (isset($_POST[$key]) && $_POST[$key] == 'on') {
                                $availability[] = $day . '-' . $time;
                            }
                        }
                    }

                    $this->ctrlvar->updateVolunteerAvailability($userId, $availability);
                }

                // Return JSON for AJAX
                $this->jsonResponse(['success' => true, 'message' => 'Profile updated successfully'], 200);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'Update failed'], 500);
            }
        }
    }
    public function updatepassword()
    {

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            if (!isset($_SESSION['user_id'])) {
                $this->jsonResponse(['success' => false, 'message' => 'User not logged in.'], 401);
                return;
            }

            $userid = $_SESSION['user_id'];
            $currentPassword = $_POST['currentPassword'] ?? "";
            $newPassword = $_POST['newPassword'] ?? "";
            $confirmPassword = $_POST['confirmNewPassword'] ?? "";

            // Get user's current password from DB
            $user = $this->ctrlvar->getuserbyid($userid);
            if (!$user) {
                $this->jsonResponse(['success' => false, 'message' => 'User not found!'], 404);
                return;
            }

            // Verify current password
            if (!password_verify($currentPassword, $user['password'] ?? '')) {
                $this->jsonResponse(['success' => false, 'message' => 'Current password is incorrect!'], 400);
                return;
            }

            // validation: passwords match
            if ($newPassword !== $confirmPassword) {
                $this->jsonResponse(['success' => false, 'message' => 'New passwords do not match!'], 400);
                return;
            }

            // validation: password length
            if (strlen($newPassword) < 8) {
                $this->jsonResponse(['success' => false, 'message' => 'Password must be at least 8 characters.'], 400);
                return;
            }

            // Update password via model
            $result = $this->ctrlvar->updatePassword($userid, $newPassword);

            if ($result) {
                $this->jsonResponse(['success' => true, 'message' => 'Password updated successfully!'], 200);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'Error updating password!'], 500);
            }
        }
    }

    private function jsonResponse($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }


    // DELETE ACCOUNT METHOD
    public function deleteAccount()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request method'], 400);
            return;
        }

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $this->jsonResponse(['success' => false, 'message' => 'User not logged in'], 401);
            return;
        }

        $userId = $_SESSION['user_id'];

        // Call model to delete user account
        $result = $this->ctrlvar->deleteUserAccount($userId);

        if ($result) {
            // Destroy session after successful deletion
            $_SESSION = [];
            session_destroy();
            $this->jsonResponse(['success' => true, 'message' => 'Account deleted successfully'], 200);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to delete account. Please try again.'], 500);
        }
    }


    public function updateAvailability()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $userid = $_SESSION['user_id'];

        // Get availability data from POST
        $availability = [];
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $times = ['Morning', 'Afternoon', 'Evening'];

        foreach ($days as $day) {
            foreach ($times as $time) {
                $key = $day . '_' . $time;
                if (isset($_POST[$key]) && $_POST[$key] == 'on') {
                    $availability[] = $day . '-' . $time;
                }
            }
        }

        $result = $this->ctrlvar->updateVolunteerAvailability($userid, $availability);
        echo json_encode($result);
    }

    // UPLOAD PROFILE IMAGE METHOD
    public function uploadProfileImage()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request method'], 400);
            return;
        }

        if (!isset($_SESSION['user_id'])) {
            $this->jsonResponse(['success' => false, 'message' => 'Not authenticated'], 401);
            return;
        }

        if (!isset($_FILES['profileImage']) || $_FILES['profileImage']['error'] !== UPLOAD_ERR_OK) {
            $this->jsonResponse(['success' => false, 'message' => 'No file uploaded or upload error'], 400);
            return;
        }

        $userId = $_SESSION['user_id'];
        $file = $_FILES['profileImage'];

        // Validate file
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedMimes)) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid file type. Only JPEG, PNG, GIF, and WebP allowed'], 400);
            return;
        }

        // Check file size (max 5MB)
        $maxSize = 5 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            $this->jsonResponse(['success' => false, 'message' => 'File size exceeds 5MB limit'], 400);
            return;
        }

        // Create upload directory if it doesn't exist
        $uploadDir = __DIR__ . '/../uploads/profile_image/';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                $this->jsonResponse(['success' => false, 'message' => 'Failed to create upload directory'], 500);
                return;
            }
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'profile_' . $userId . '_' . time() . '.' . strtolower($extension);
        $filePath = $uploadDir . $filename;
        $dbPath = '/V/uploads/profile_image/' . $filename;

        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to save file'], 500);
            return;
        }

        // Delete old profile image if it exists
        $userRole = $_SESSION['role'] ?? null;
        if ($userRole === 'sponsor') {
            $userData = $this->ctrlvar->getuserbyidwithsponsor($userId);
        } else {
            $userData = $this->ctrlvar->getuserandvolunteerbyid($userId);
        }

        if ($userData && isset($userData['profile_path']) && $userData['profile_path']) {
            $oldImagePath = __DIR__ . '/../' . ltrim($userData['profile_path'], '/');
            if (file_exists($oldImagePath) && strpos($oldImagePath, 'profile_image') !== false) {
                unlink($oldImagePath);
            }
        }

        $_SESSION['profile_path'] = $dbPath;
        // Update database
        $result = $this->ctrlvar->updateProfileImagePath($userId, $dbPath);

        if ($result) {
            $_SESSION['profile_path'] = $dbPath;
            $this->jsonResponse(['success' => true, 'message' => 'Profile image uploaded successfully', 'imageUrl' => $dbPath], 200);
        } else {
            // Delete the file if database update fails
            unlink($filePath);
            $this->jsonResponse(['success' => false, 'message' => 'Failed to update profile image in database'], 500);
        }
    }




}

?>