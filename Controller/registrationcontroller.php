<?php
class RegistrationController
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    // Handle role selection (Step 0)
    public function handleRoleSelection()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $role = $_POST['role'];
            $_SESSION['registration_role'] = $role;

            if ($role === 'sponsor') {
                header("Location: /V/router.php?module=registration&action=s_registration_step1");
            } else { // volunteer (default)
                header("Location: /V/router.php?module=registration&action=registration_step1");
            }

            // header("Location: /V/router.php?module=registration&action=registration_step1");
            exit();
        }
    }

    // Store Step 1 data (Personal Information)
    public function handleStep1()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validate required fields
            if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email'])) {
                $_SESSION['error'] = "Please fill in all required fields";
                header("Location: /V/router.php?module=registration&action=registration_step1");
                exit();
            }

            // Validate email
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email format";
                header("Location: /V/router.php?module=registration&action=registration_step1");
                exit();
            }

            // Check if email already exists
            if ($this->model->emailExists($_POST['email'])) {
                $_SESSION['error'] = "Email already registered";
                header("Location: /V/router.php?module=registration&action=registration_step1");
                exit();
            }

            // Validate age (18+) if volunteer
            if (isset($_SESSION['registration_role']) && $_SESSION['registration_role'] == 'volunteer') {
                if (!empty($_POST['dob'])) {
                    $dob = new DateTime($_POST['dob']);
                    $today = new DateTime();
                    $age = $today->diff($dob)->y;

                    if ($age < 18) {
                        $_SESSION['error'] = "You must be 18 years or older to volunteer";
                        header("Location: /V/router.php?module=registration&action=registration_step1");
                        exit();
                    }
                }
            }

            // Store data in session
            $_SESSION['registration_step1'] = [
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone'] ?? ''),
                'dob' => $_POST['dob'] ?? '',
                'gender' => $_POST['gender'] ?? ''
            ];

            header("Location: /V/router.php?module=registration&action=registration_step2");
            exit();
        }
    }
    // Store Step 1 data (Sponsor Information)
    public function s_handleStep1()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validate required fields
            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone'])) {
                $_SESSION['error'] = "Please fill in all required fields";
                header("Location: /V/router.php?module=registration&action=s_registration_step1");
                exit();
            }

            // Validate email
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email format";
                header("Location: /V/router.php?module=registration&action=s_registration_step1");
                exit();
            }

            // Check if email already exists
            if ($this->model->emailExists($_POST['email'])) {
                $_SESSION['error'] = "Email already registered";
                header("Location: /V/router.php?module=registration&action=s_registration_step1");
                exit();
            }


            // Store data in session
            $_SESSION['s_registration_step1'] = [
                'name' => trim($_POST['name']),
                
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                
                'link' => trim($_POST['link'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'organization_type' => trim($_POST['organization_type'] ?? ''),
            ];

            header("Location: /V/router.php?module=registration&action=s_registration_step2");
            exit();
        }
    }
    // Store Step 2 data (Password)
    public function handleStep2()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validate password
            if (empty($password)) {
                $_SESSION['error'] = "Password is required";
                header("Location: /V/router.php?module=registration&action=registration_step2");
                exit();
            }

            if (strlen($password) < 8) {
                $_SESSION['error'] = "Password must be at least 8 characters";
                header("Location: /V/router.php?module=registration&action=registration_step2");
                exit();
            }

            if ($password !== $confirmPassword) {
                $_SESSION['error'] = "Passwords do not match";
                header("Location: /V/router.php?module=registration&action=registration_step2");
                exit();
            }

            // Store password in session
            $_SESSION['registration_step2'] = [
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];

            // If sponsor, skip to step 4 (final)
            // if (isset($_SESSION['registration_role']) && $_SESSION['registration_role'] == 'sponsor') {
            //     header("Location: /V/router.php?module=registration&action=registration_complete");
            //     exit();
            // }

            // If volunteer, continue to step 3
            header("Location: /V/router.php?module=registration&action=registration_step3");
            exit();
        }
    }


    public function s_handleStep2()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validate password
            if (empty($password)) {
                $_SESSION['error'] = "Password is required";
                header("Location: /V/router.php?module=registration&action=s_registration_step2");
                exit();
            }

            if (strlen($password) < 8) {
                $_SESSION['error'] = "Password must be at least 8 characters";
                header("Location: /V/router.php?module=registration&action=s_registration_step2");
                exit();
            }

            if ($password !== $confirmPassword) {
                $_SESSION['error'] = "Passwords do not match";
                header("Location: /V/router.php?module=registration&action=s_registration_step2");
                exit();
            }

            // Store password in session
            $_SESSION['s_registration_step2'] = [
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];

            // // If sponsor, skip to step 4 (final)
            // if (isset($_SESSION['registration_role']) && $_SESSION['registration_role'] == 'sponsor') {
            //     header("Location: /V/router.php?module=registration&action=s_registration_complete");
            //     exit();
            // }

            // If volunteer, continue to step 3
            header("Location: /V/router.php?module=registration&action=s_registration_step3");
            exit();
        }
    }

    // Store Step 3 data (Availability - Volunteers only)
    public function handleStep3()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

            $_SESSION['registration_step3'] = [
                'availability' => $availability
            ];

            header("Location: /V/router.php?module=registration&action=registration_step4");
            exit();
        }
    }

    // public function s_handleStep3()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    //         if (empty($_POST['cpersonname']) || empty($_POST['role']) || empty($_POST['cpersonemail'])) {
    //             $_SESSION['error'] = "Please fill in all required fields";
    //             header("Location: /V/router.php?module=registration&action=s_registration_step3");
    //             exit();
    //         }

    //         if (!filter_var($_POST['cpersonemail'], FILTER_VALIDATE_EMAIL)) {
    //             $_SESSION['error'] = "Invalid contact person email format";
    //             header("Location: /V/router.php?module=registration&action=s_registration_step3");
    //             exit();
    //         }

    //         $_SESSION['s_registration_step3'] = [
    //             'cpersonname' => trim($_POST['cpersonname']),
    //             'role' => trim($_POST['role']),
    //             'cpersonemail' => trim($_POST['cpersonemail']),
    //             'cpersonphone' => trim($_POST['cpersonphone'] ?? '')

    //         ];

    //         header("Location: /V/router.php?module=registration&action=s_registration_step4");
    //         exit();
    //     }
    // }


    // Handle Step 4 and Complete Registration
    public function handleStep4()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get all data from session
            $role = $_SESSION['registration_role'] ?? 'volunteer';
            $step1 = $_SESSION['registration_step1'] ?? [];
            $step2 = $_SESSION['registration_step2'] ?? [];
            $step3 = $_SESSION['registration_step3'] ?? [];

            // Validate we have all required data
            if (empty($step1) || empty($step2)) {
                $_SESSION['error'] = "Registration data incomplete. Please start over.";
                header("Location: /V/router.php?module=registration&action=register");
                exit();
            }

            // Create full name
            $fullName = $step1['first_name'] . ' ' . $step1['last_name'];

            // Start transaction
            $this->model->conn->begin_transaction();

            try {
                // Create user
                $userid = $this->model->createUser(
                    $fullName,
                    $step1['email'],
                    $step2['password'],
                    $step1['phone'],
                    $role
                );

                if (!$userid) {
                    throw new Exception("Failed to create user account");
                }

                // If volunteer, create volunteer profile and additional data
                if ($role == 'volunteer') {
                    $volunteerExperience = trim($_POST['volunteer_experience'] ?? '');
                    $preferredLocation1 = $_POST['preferred_location_1'] ?? '';
                    $preferredLocation2 = $_POST['preferred_location_2'] ?? '';
                    $preferredLocation3 = $_POST['preferred_location_3'] ?? '';

                    // Create volunteer profile
                    if (
                        !$this->model->createVolunteerProfile(
                            $userid,
                            $step1['dob'],
                            $volunteerExperience,
                            $preferredLocation1,
                            $preferredLocation2,
                            $preferredLocation3
                        )
                    ) {
                        throw new Exception("Failed to create volunteer profile");
                    }

                    // Add availability
                    if (!empty($step3['availability'])) {
                        if (!$this->model->addVolunteerAvailability($userid, $step3['availability'])) {
                            throw new Exception("Failed to add availability");
                        }
                    }

                    // Add skills
                    $skills = [];
                    if (!empty($_POST['special_skills'])) {
                        $skills = array_map('trim', explode(',', $_POST['special_skills']));
                    }
                    if (!empty($skills)) {
                        if (!$this->model->addVolunteerSkills($userid, $skills)) {
                            throw new Exception("Failed to add skills");
                        }
                    }
                }

                // If sponsor, create sponsor profile
                // if ($role == 'sponsor') {
                //     if (!$this->model->createSponsorProfile($userid)) {
                //         throw new Exception("Failed to create sponsor profile");
                //     }
                // }

                // Commit transaction
                $this->model->conn->commit();

                // Auto-login: Set session variables
                $_SESSION['user_id'] = $userid;
                $_SESSION['name'] = $fullName;
                $_SESSION['email'] = $step1['email'];
                $_SESSION['role'] = $role;
                $_SESSION['logged_in'] = true;

                // Clear registration data
                unset($_SESSION['registration_role']);
                unset($_SESSION['registration_step1']);
                unset($_SESSION['registration_step2']);
                unset($_SESSION['registration_step3']);

                // Redirect to success page
                header("Location: /V/router.php?module=registration&action=registration_success");
                exit();

            } catch (Exception $e) {
                // Rollback on error
                $this->model->conn->rollback();
                $_SESSION['error'] = $e->getMessage();
                header("Location: /V/router.php?module=registration&action=registration_step4");
                exit();
            }
        }
    }
    // Handle Step 4 and Complete Registration (Sponsor with Logo)
    public function s_handleStep3()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $role = $_SESSION['registration_role'] ?? 'sponsor';
            $step1 = $_SESSION['s_registration_step1'] ?? [];
            $step2 = $_SESSION['s_registration_step2'] ?? [];
            // $step3 = $_SESSION['s_registration_step3'] ?? [];

            if (empty($step1) || empty($step2) ) {
                $_SESSION['error'] = "Registration data incomplete. Please start over.";
                header("Location: /V/router.php?module=registration&action=register");
                exit();
            }



            $this->model->conn->begin_transaction();

            try {
                // Create user
                $userid = $this->model->createUser(
                    $step1['name'],
                    $step1['email'],
                    $step2['password'],
                    $step1['phone'],
                    $role
                );

                if (!$userid) {
                    throw new Exception("Failed to create user account");
                }

                // Create sponsor profile
                if (
                    !$this->model->createSponsorProfile(
                        $userid,
                        $step1['link'],
                        $step1['description'],
                        $step1['organization_type']
                    )
                ) {
                    throw new Exception("Failed to create sponsor profile");
                }


                // Handle logo upload
                if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/V/uploads/sponsor_logos/';

                    // Create directory if it doesn't exist
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    $fileExtension = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
                    $allowedExtensions = ['png', 'jpg', 'jpeg', 'svg'];

                    if (!in_array($fileExtension, $allowedExtensions)) {
                        throw new Exception("Invalid file type. Only PNG, JPG, JPEG, and SVG are allowed.");
                    }

                    // Check file size (2MB max)
                    if ($_FILES['logo']['size'] > 2 * 1024 * 1024) {
                        throw new Exception("File size exceeds 2MB limit.");
                    }

                    // Generate unique filename
                    $newFileName = 'sponsor_' . $userid . '_' . time() . '.' . $fileExtension;
                    $uploadPath = $uploadDir . $newFileName;

                    // Move uploaded file
                    if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadPath)) {
                        // Store relative path in database
                        $logoPath = '/V/uploads/sponsor_logos/' . $newFileName;

                        if (!$this->model->updateSponsorLogoPath($userid, $logoPath)) {
                            throw new Exception("Failed to update logo path in database");
                        }
                    }
                }


                $this->model->conn->commit();

                $_SESSION['user_id'] = $userid;
                $_SESSION['name'] = $step1['name'];
                $_SESSION['email'] = $step1['email'];
                $_SESSION['role'] = $role;
                $_SESSION['logged_in'] = true;

                unset($_SESSION['registration_role']);
                unset($_SESSION['s_registration_step1']);
                unset($_SESSION['s_registration_step2']);
                // unset($_SESSION['s_registration_step3']);


                header("Location: /V/router.php?module=registration&action=registration_success");
                exit();

            } catch (Exception $e) {
                $this->model->conn->rollback();
                $_SESSION['error'] = $e->getMessage();
                header("Location: /V/router.php?module=registration&action=s_registration_step3");
                exit();
            }
        }
    }






    // Clear registration session data
    public function clearRegistrationData()
    {
        unset($_SESSION['registration_role']);
        unset($_SESSION['registration_step1']);
        unset($_SESSION['registration_step2']);
        unset($_SESSION['registration_step3']);
        unset($_SESSION['s_registration_step1']);
        unset($_SESSION['s_registration_step2']);
        unset($_SESSION['s_registration_step3']);
        unset($_SESSION['error']);
    }
}
?>