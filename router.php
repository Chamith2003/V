<?php

session_start();
require_once 'config.php';
require_once 'Model/usermodel.php';
require_once 'Controller/usercontroller.php';
//adding task related inclusions
require_once 'Model/taskmodel.php';
require_once 'Controller/taskcontroller.php';
//adding activity related inclusions
require_once 'Model/activitymodel.php';
require_once 'Controller/activitycontroller.php';
//adding registration related inclusions 
require_once 'Model/registrationmodel.php';
require_once 'Controller/registrationcontroller.php';
//adding project related stuff
require_once 'Model/eventmodel.php';
require_once 'Controller/eventcontroller.php';
//adding item related stuff
require_once 'Model/itemmodel.php';
require_once 'Controller/itemcontroller.php';
//adding the apply for representative post related stuff
require_once 'Model/volunteermodel.php';
require_once 'Controller/volunteercontroller.php';
require_once 'Model/representativemodel.php';
require_once 'Controller/representativecontroller.php';
//adding the request related stuff
require_once 'Model/requestmodel.php';
require_once 'Controller/requestcontroller.php';
//adding the peerrating related stuff
require_once 'Model/peerratingmodel.php';
require_once 'Controller/peerratingcontroller.php';
//adding the taskrating related stuff
require_once 'Model/taskratingmodel.php';
require_once 'Controller/taskratingcontroller.php';
//adding the achievement related stuff
require_once 'Model/achievementmodel.php';
require_once 'Controller/achievementcontroller.php';
//adding donation related stuff
require_once 'Model/donationmodel.php';
require_once 'Controller/donationcontroller.php';
//adding item purchase related stuff
require_once 'Model/inventorymodel.php';
require_once 'Controller/inventorycontroller.php';
//adding the attendance related stuff
require_once 'Model/attendancemodel.php';
require_once 'Controller/attendancecontroller.php';
//contact us related stuff
require_once 'Model/emailmodel.php';
require_once 'Controller/emailcontroller.php';
require_once 'Model/contactmodel.php';
require_once 'Controller/contactcontroller.php';
require_once 'Controller/feedbackcontroller.php';
//user mngment related stuff
require_once 'Model/usermanagementmodel.php';
require_once 'Controller/usermanagementcontroller.php';
//adding the calendar related stuff
require_once 'Model/calendarmodel.php';
require_once 'Controller/calendarcontroller.php';
//adding the notification related stuff
require_once 'Model/notificationmodel.php';
require_once 'Controller/notificationcontroller.php';
//system overview related stuff
require_once 'Model/systemoverviewmodel.php';
require_once 'Controller/systemoverviewcontroller.php';
//organizationrep related stuff
require_once 'Model/organizationrepmodel.php';
require_once 'Controller/organizationrepcontroller.php';
//about us page related
require_once 'Model/aboutusmodel.php';
require_once 'Controller/aboutuscontroller.php';
//merchandising items
require_once 'Model/merchmodel.php';
require_once 'Controller/merchcontroller.php';
//homepage highlights stuff
require_once 'Model/homepagemodel.php';
require_once 'Controller/homepagecontroller.php';
//admin systemsettings page
require_once 'Model/systemsettingsmodel.php';
require_once 'Controller/systemsettingscontroller.php';


$usermodel = new usermodel($conn);
$volunteermodel = new volunteermodel($conn);
$representativemodel = new representativemodel($conn);
$organizationrepmodel = new organizationrepmodel($conn);

//pass $usermodel object to controller
$usercontroller = new usercontroller($usermodel, $representativemodel, $organizationrepmodel);
// Adding task-related objects
$taskmodel = new taskmodel($conn);
$taskcontroller = new taskcontroller($taskmodel);
//activity related stuff
$activitymodel = new activitymodel($conn);
$activitycontroller = new activitycontroller($activitymodel);
//registration related stuff
$registrationmodel = new RegistrationModel($conn);
$registrationcontroller = new RegistrationController($registrationmodel);
//calendar related stuff
$calendarmodel = new calendarmodel($conn);
$calendarcontroller = new calendarcontroller($calendarmodel);
//projects related stuff
$eventmodel = new eventmodel($conn);
$eventcontroller = new eventcontroller($eventmodel,$calendarmodel);
//item stuff
$itemmodel = new ItemModel($conn);
$itemcontroller = new ItemController($itemmodel);
//volunteer stuff

$volunteercontroller = new volunteercontroller($volunteermodel);
$representativecontroller = new representativecontroller($usermodel, $volunteermodel, $representativemodel);

$showRepButton = false;
$repModelNavbar = $representativemodel;
$volModelNavbar = $volunteermodel;

$totalReps = $repModelNavbar->getTotalRepresentatives();
$totalPending = $repModelNavbar->getTotalPendingApplications();

$effectiveTotal = $totalReps + $totalPending;

if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'volunteer') {
    $myPoints = $volModelNavbar->getlevelpoints($_SESSION['user_id']);

    $INITIAL_LIMIT = 5;
    $HARD_LIMIT = 50;
    $BASE_POINTS = 100;
    $POINTS_INC = 10;

    $existingApp = $repModelNavbar->checkExistingApplication($_SESSION['user_id']);

    if ($existingApp) {
        $showRepButton = true;
    } else {
        if ($effectiveTotal < $INITIAL_LIMIT) {
            $showRepButton = true;
        } elseif ($effectiveTotal < $HARD_LIMIT) {
            $neededPoints = $BASE_POINTS + (($effectiveTotal - $INITIAL_LIMIT) * $POINTS_INC);

            if ($myPoints >= $neededPoints) {
                $showRepButton = true;
            }
        } else {
            $showRepButton = false;
        }
    }
}

//peerrating stuff
$peerratingmodel = new peerratingmodel($conn);
//create a peerrating model that is using the DB connection conn
$peerratingcontroller = new peerratingcontroller($peerratingmodel, $eventmodel, $taskmodel);
//create a peerrating controller that has access to both peerratingmodel and eventmodel
//taskrating stuff
$taskratingmodel = new taskratingmodel($conn);
$taskratingcontroller = new taskratingcontroller($taskratingmodel);
//attendance rating stuff
$attendanceModel = new AttendanceModel($conn);
$attendanceController = new AttendanceController($attendanceModel);
//achievement stuff
$achievementmodel = new achievementmodel($conn);
$achievementcontroller = new achievementcontroller($achievementmodel);
//request related stuff
$requestmodel = new requestmodel($conn);
$requestcontroller = new requestcontroller($requestmodel, $usermodel, $volunteermodel, $representativemodel);
//donation stuff
$donationmodel = new donationmodel($conn);
$donationcontroller = new donationcontroller($donationmodel);
//item purchasestuff
$inventorymodel = new InventoryModel($conn);
$inventorycontroller = new InventoryController($conn);
//merchandising stuff
$merchmodel = new merchmodel($conn);
$merchcontroller = new merchcontroller($merchmodel, $donationcontroller);
//email stuff
$pwModel = new emailmodel($conn);
$pwCtrl = new emailcontroller($pwModel);
//user mngment stuff
$usermanagementmodel = new usermanagementmodel($conn);
$usermanagementcontroller = new usermanagementcontroller($usermanagementmodel);
//notification related stuff
$notificationmodel = new notificationmodel($conn);
$notificationcontroller = new notificationcontroller($notificationmodel);
//contact us stuff
$contactmodel = new ContactModel();
$contactcontroller = new ContactController($contactmodel);
//system overview related stuff
$systemoverviewmodel = new systemoverviewmodel($conn);
$systemoverviewcontroller = new systemoverviewcontroller($systemoverviewmodel);

//organizationrep stuff

$organizationrepcontroller = new organizationrepcontroller($organizationrepmodel, $representativemodel);
//contact us
$feedbackcontroller = new FeedbackController();
//about us page related
$aboutusmodel = new AboutusModel($conn);
$aboutuscontroller = new AboutusController($aboutusmodel);
//homepage highlights stuff
$homepagemodel = new homepagemodel($conn);
$homepagecontroller = new homepagecontroller($homepagemodel);
//system setting stuff
$systemsettingsmodel = new systemsettingsmodel($conn);
$systemsettingscontroller = new systemsettingscontroller($systemsettingsmodel);

//routing
$module = $_GET['module'] ?? 'page';
$action = $_GET['action'] ?? 'homepage';//default is set to landing page
//read action parameter form URL and if it is not set use homepage default
$userrole = $_SESSION['role'] ?? null;///finished here??null;


function checkpermissionofuser($module, $action, $userrole, $conn)
{
    //Default to DENY, explicitly ALLOW what's needed. 
    $stmt = $conn->prepare("
    SELECT allowed_roles 
        FROM route_permissions 
        WHERE module = ? AND action = ?
        ");
    $stmt->bind_param("ss", $module, $action);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return false; //false for security i.e. if route is not there deny access
    }

    $row = $result->fetch_assoc();
    $allowedroles = $row['allowed_roles'];

    // Check if it's public
    if ($allowedroles === 'public') {
        return true;
    }

    // Check if user's role is in allowed roles
    $rolesarray = explode(',', $allowedroles);
    return in_array($userrole, $rolesarray);//returns true if $userrole is found in $rolesarray
}

if (!checkpermissionofuser($module, $action, $userrole, $conn)) {
    $_SESSION['error_type'] = $userRole ? 'INSUFFICIENT_PERMISSIONS' : 'NOT_LOGGED_IN';
    $_SESSION['error_message'] = 'Access denied';
    $_SESSION['attempted_path'] = "$module/$action";
    header("Location: /V/View/errorpage/error.php");
    exit();
}

function setsessionvar($result)
{
    if ($result['success']) {
        $_SESSION['message'] = $result['message'];
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = $result['message'];
        $_SESSION['message_type'] = 'error';
    }
}


switch ($module) {
    case 'page':
        switch ($action) {
            case 'homepage':
                $highlights = $homepagecontroller->fetchhighlights();
                include 'View/homepage/homepage.php';
                break;
            case 'calendar':
                $calendarcontroller->rendercalendar();
                break;
            case 'aboutus':
                $eventsWithSponsors = $aboutuscontroller->renderAboutUsPage();
                include 'View/aboutus/aboutus.php';
                break;
            case 'vmap':
                $eventcontroller->showEventMap();
                break;
            default:
                echo "Page not found";
        }
        break;

    case 'calendar':
        switch ($action) {
            case 'getevents':
                $calendarcontroller->getcalendarevents();
                break;
            case 'geteventdetails':
                $calendarcontroller->geteventdetails();
                break;
            case 'leaveevent':
                $calendarcontroller->handleleaveevent();
                $notificationcontroller->leaveeventnotification();
                break;
            case 'filterevents':
                $calendarcontroller->filtereventsbytype();
                break;
        }
        break;


    case 'attendance':
        switch ($action) {
            case 'mark':
                $attendanceController->markAttendance();
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
        }
        break;

    case 'user':
        switch ($action) {
            case 'login':
                $usercontroller->login();
                break;
            case 'logout':
                $usercontroller->logout();
                break;
            case 'profile':
                //get achievement data if the user is a volunteer or representative
                $role = $_SESSION['role'] ?? null;
                $achievementdata = null;
                if ($role === 'volunteer' || $role === 'representative' || $role === 'organisationrep') {
                    $achievementdata = $achievementcontroller->renderachievements();
                }//$achievementdata format is like star_points,level,level_points,points_to_next_level,projects_completed,hours_volunteered,badges,leaderboard
                $usercontroller->profile($achievementdata);
                break;
            case 'profileEdit':
                $usercontroller->profileEdit();
                break;
            case 'profileUpdate':
                $usercontroller->profileUpdate();
                break;
            case 'forgotpw':
                include 'View/userdash/resetpw/resetpw.php';
                break;
            case 'resetpw':
                include "View/userdash/resetpw/resetpw2.php";
                break;
            case 'updatepassword':
                $usercontroller->updatepassword();
                break;
            case 'deleteaccount':
                $usercontroller->deleteAccount();
                break;
            case 'uploadProfileImage':
                $usercontroller->uploadProfileImage();
                break;
            default:
                echo "Action not found";
        }
        break;
    case 'contact':
        switch ($action) {
            case 'send':
                $contactcontroller->sendContactMessage();
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
                break;
        }
        break;
    case 'feedback':
        switch ($action) {
            case 'sendemail':
                $feedbackcontroller->sendFeedbackEmail();
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
        }
        break;
    case 'pwreset':
        switch ($action) {
            case 'show': // show the initial reset page
                include 'View/userdash/resetpw/resetpw.php';
                break;
            case 'sendcode':
                // Accept POST JSON
                $pwCtrl->sendCode();
                break;
            case 'verifycode':
                $pwCtrl->verifyCode();
                break;
            case 'updatepassword':
                $pwCtrl->updatePassword();
                break;
            case 'showchange':
                // show the change password view (resetpw2.php)
                include 'View/userdash/resetpw/resetpw2.php';
                break;
            default:
                echo "pwreset action not found";
        }
        break;

    case 'registration':
        switch ($action) {
            //registration related stuff
            case 'register':
                // Clear any previous registration data
                $registrationcontroller->clearRegistrationData();
                include 'View/registration/role.php';
                break;
            case 'registration_role':
                $registrationcontroller->handleRoleSelection();
                break;
            case 'registration_step1':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $registrationcontroller->handleStep1();
                } else {
                    // Check if role is selected
                    if (!isset($_SESSION['registration_role'])) {
                        header("Location: /V/router.php?module=registration&action=register");
                        exit();
                    }
                    include 'View/registration/reg1.php';
                }
                break;
            case 's_registration_step1':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $registrationcontroller->s_handleStep1();
                } else {
                    // Check if role is selected
                    if (!isset($_SESSION['registration_role'])) {
                        header("Location: /V/router.php?module=registration&action=register");
                        exit();
                    }
                    include 'View/registration/sponsor/sponsor1.php';
                }
                break;
            case 'registration_step2':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $registrationcontroller->handleStep2();
                } else {
                    // Check if step 1 is completed
                    if (!isset($_SESSION['registration_step1'])) {
                        header("Location: /V/router.php?module=registration&action=registration_step1");
                        exit();
                    }
                    include 'View/registration/reg2.php';
                }
                break;
            case 's_registration_step2':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $registrationcontroller->s_handleStep2();
                } else {
                    // Check if step 1 is completed
                    if (!isset($_SESSION['s_registration_step1'])) {
                        header("Location: /V/router.php?module=registration&action=s_registration_step1");
                        exit();
                    }
                    include 'View/registration/sponsor/sponsor2.php';
                }
                break;

            case 'registration_step3':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $registrationcontroller->handleStep3();
                } else {
                    // Check if step 2 is completed
                    if (!isset($_SESSION['registration_step2'])) {
                        header("Location: /V/router.php?module=registration&action=registration_step2");
                        exit();
                    }
                    include 'View/registration/reg3.php';
                }
                break;

            // case 's_registration_step3':
            //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //         $registrationcontroller->s_handleStep3();
            //     } else {
                   
            //         if (!isset($_SESSION['s_registration_step2'])) {
            //             header("Location: /V/router.php?module=registration&action=s_registration_step2");
            //             exit();
            //         }
            //         include 'View/registration/sponsor/sponsor3.php';
            //     }
            //     break;
            case 'registration_step4':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $registrationcontroller->handleStep4();
                } else {
                    // Check if step 3 is completed (for volunteers)
                    $role = $_SESSION['registration_role'] ?? 'volunteer';
                    if ($role == 'volunteer' && !isset($_SESSION['registration_step3'])) {
                        header("Location: /V/router.php?module=registration&action=registration_step3");
                        exit();
                    }
                    include 'View/registration/reg4.php';
                }
                break;

            case 's_registration_step3':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $registrationcontroller->s_handleStep3();
                } else {
                    // Check if step 3 is completed (for volunteers)
                    $role = $_SESSION['registration_role'] ?? 'sponsor';
                    if ($role == 'sponsor' && !isset($_SESSION['s_registration_step2'])) {
                        header("Location: /V/router.php?module=registration&action=s_registration_step2");
                        exit();
                    }
                    include 'View/registration/sponsor/sponsor4.php';
                }
                break;
            case 'registration_complete':
                // For sponsors who skip step 3
                $registrationcontroller->handleStep4();
                break;
            case 's_registration_complete':
                // For sponsors who skip step 3
                $registrationcontroller->s_handleStep3();
                break;
            case 'registration_success':
                include 'View/registration/successmsg.php';
                break;

            //end of registartion related stuff
        }
        break;


    case 'projects':
        switch ($action) {
            case 'projects':
                //  include 'View/projects/event.php'; already in listevents
                $eventcontroller->listEvents();
                break;
            case 'projectapprovals':
                $eventcontroller->viewAllEventsForApproval();
                break;
            case 'approveEvent':
                $eventcontroller->approveEvent();
                break;
            case 'rejectEvent':
                $eventcontroller->rejectEvent();
                break;
            //start of project related stuff
            case 'createevent':
                $eventcontroller->createEvent();
                break;
            case 'events':
                $eventcontroller->listEvents();
                break;
            case 'deleteevent':
                $id = $_GET['id'] ?? null;
                $eventcontroller->deleteEvent($id);
                break;
            case 'updateevent':
                $eventcontroller->updateEvent();
                break;
            case 'createeventsuccess':
                include 'View/projects/eventForm/createeventsuccess/createeventsuccess.php';
                break;
            case 'joinevent':
                $eventcontroller->joinEvent();
                break;
            case 'withdrawevent':
                $eventcontroller->withdrawEvent();
                break;
            // Annual Event Approval Routes
            case 'annualeventapproval':
                $eventcontroller->showAnnualEventApprovalPage();
                break;
            case 'annualeventstatus':
                $eventcontroller->showAnnualEventStatusPage();
                break;
            case 'handleAnnualEventApproval':
                $eventcontroller->handleAnnualEventApproval();
                break;
            //end of project related stuff
        }
        break;

    case 'activity':
        switch ($action) {
            case 'activity':
                //load all events from database
                //set the default based on the role
                $role = $_SESSION['role'] ?? 'volunteer';
                $filtertype = 'all';
                if (!isset($_POST['filter'])) {
                    //managers and reps see standard events by default and volutneers see enrolled events by default
                    if ($role === 'volunteer') {
                        $filtertype = 'enrolled';
                    } elseif ($role === 'manager' || $role === 'organisationrep') {
                        $filtertype = 'annual';
                    } elseif ($role === 'representative') {
                        $filtertype = 'standard';
                    }
                } else {

                    $filtertype = $_POST['filter'];
                }

                $userId = $_SESSION['user_id'] ?? null;

                $eventResult = $activitycontroller->displayevents($filtertype, $userId);
                
                 if (!empty($eventResult['opened_events'])) {
                    foreach ($eventResult['opened_events'] as $newEvent) {//openedEvents stores in the format of [['event_id'=>1], ['event_id'=>2]] so pass only the id in next line
                    $peerratingcontroller->generatepeerratingassignments($newEvent['event_id']);//generate peer rating assignments only for the open events(unless they have already generated peer rating assignments)
                    }
                }        
                // attach rating status flags to each event here $eventResult['data']==$events in activitycontroller  means total (events) returned
foreach ($eventResult['data'] as &$event) {
    $taskprogress = $taskratingcontroller->gettaskratingstatus($event['event_id'], $userId);
    $event['tasks_rated'] = $taskprogress['is_complete'];//to be set tasks being created is mandatory, if no tasks are there then it will never be completed (no tasks -> defineatly false)
    
    $peerprogress = $peerratingcontroller->getratingstatus($userId, $event['event_id']);
    $event['peers_rated'] = $peerprogress['is_complete'];//is_complete will be set true, only if  peer assignments exist and all ratings of them is done
}
unset($event); // always unset reference after loop   

                include 'View/activity/activity.php';
                break;
            case 'openpeer'://this section is dead code and it has been automated to be done automatically upon event closure
                $eventId = $_GET['event_id'] ?? null;
                if (!$eventId) {
                    $_SESSION['message'] = 'No event selected';
                    $_SESSION['message_type'] = 'error';
                } else {
                    $openpeerwindow = $peerratingcontroller->generatepeerratingassignments($eventId);
                    $_SESSION['message'] = $openpeerwindow['message'];
                    $_SESSION['message_type'] = $openpeerwindow['success'] ? 'success' : 'error';
                }
                // this is dead code: $progressdetails = isset($peerresult['progress']) ? $peerresult['progress'] : [];
                header("Location: /V/router.php?module=activity&action=activity");
                exit();
        }
        break;

    case 'task':
        switch ($action) {
            case 'managetasks':
                //load all the taska nd volunteer dtaa from the databbase and then show the page
                $eventId = $_GET['event_id'] ?? null;
                if (!$eventId) {
                    $_SESSION['message'] = 'No event selected';
                    $_SESSION['message_type'] = 'error';
                    header("Location: /V/router.php?module=activity&action=activity");
                    exit();
                }
                $tasksResult = $taskcontroller->getAllTasks($eventId);
                $volunteersResult = $taskcontroller->getUnassignedVolunteers($eventId);
                //  duplicate uz there is one at the top
                //  $eventId = $_POST['event_id'] ?? $_GET['event_id'];
                //url is unchanged so no need event_id adding chnages
                include 'View/rating/task/managetask.php';
                break;
            case 'createtask':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    //hanlde task creation
                    $result = $taskcontroller->createTask($_POST);
                    setsessionvar($result);
                    $eventId = $_POST['event_id'] ?? $_GET['event_id'];
                    //check both post and get sources for eventid and also needs to redirect to correct eventid
                    header("Location: /V/router.php?module=task&action=managetasks&event_id={$eventId}");
                    exit();
                }
                break;
            case 'edittask'://resposnds to router request router.php?module=task&action=edittask
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Handle task update
                    $taskId = $_POST['task_id'];//grab taskID from form submission tell which task we are editing to the system 
                    $result = $taskcontroller->updateTask($taskId, $_POST);//call update task with relevant taskID that needs to be updated, her $POST represents the new data
                    //goes to controller like updatetask($id,$data)
                    //there the task ID is the identifier that helps us understand which row to update whereas the $_POST has the data field that were updated tehir data values
                    setsessionvar($result);
                    $eventId = $_POST['event_id'] ?? $_GET['event_id'];
                    header("Location: /V/router.php?module=task&action=managetasks&event_id={$eventId}");//send back to managetasjs page to see the updated list
                    exit();//stop executing this script
                }
                break;
            case 'deletetask':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Handle task deletion
                    $taskId = $_POST['task_id'];
                    $result = $taskcontroller->deleteTask($taskId);
                    setsessionvar($result);
                    $eventId = $_POST['event_id'] ?? $_GET['event_id'];
                    header("Location: /V/router.php?module=task&action=managetasks&event_id={$eventId}");
                    exit();
                }
                break;
            case 'assignvolunteer':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Handle volunteer assignment
                    $taskId = $_POST['task_id'];
                    $volunteerId = $_POST['volunteer_id'];
                    $result = $taskcontroller->assignVolunteer($taskId, $volunteerId);
                    setsessionvar($result);
                    $eventId = $_POST['event_id'] ?? $_GET['event_id'];
                    header("Location: /V/router.php?module=task&action=managetasks&event_id={$eventId}");
                    exit();
                }
                break;
            case 'removevolunteer':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Handle volunteer removal
                    $taskId = $_POST['task_id'];
                    $volunteerId = $_POST['volunteer_id'];
                    $result = $taskcontroller->removeVolunteer($taskId, $volunteerId);
                    setsessionvar($result);
                    $eventId = $_POST['event_id'] ?? $_GET['event_id'];
                    header("Location: /V/router.php?module=task&action=managetasks&event_id={$eventId}");
                    exit();
                }
                break;
            case 'assignmultiplevolunteers':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Handle multiple volunteer assignments
                    $taskId = $_POST['task_id'];
                    $volunteerIds = $_POST['volunteer_ids'] ?? [];
                    $successCount = 0;
                    $errorCount = 0;
                    $errors = [];
                    foreach ($volunteerIds as $volunteerId) {
                        $result = $taskcontroller->assignVolunteer($taskId, $volunteerId);
                        if ($result['success']) {
                            $successCount++;
                        } else {
                            $errorCount++;
                            $errors[] = $result['message'];
                        }
                    }
                    if ($successCount > 0) {
                        $_SESSION['message'] = "Successfully assigned {$successCount} volunteer(s)";
                        if ($errorCount > 0) {
                            $_SESSION['message'] .= ". {$errorCount} assignment(s) failed.";
                        }
                        $_SESSION['message_type'] = 'success';
                    } else {
                        $_SESSION['message'] = "Failed to assign volunteers: " . implode(', ', array_unique($errors));
                        $_SESSION['message_type'] = 'error';
                    }
                    $eventId = $_POST['event_id'] ?? $_GET['event_id'];
                    header("Location: /V/router.php?module=task&action=managetasks&event_id={$eventId}");
                    exit();
                }
                break;
        }
        break;
    case 'inventory':
        switch ($action) {
            case 'inventorymanagement':
                // Load items and display the inventory management page
                $itemsResult = $itemcontroller->displayItems();
                include 'View/item/inventorymanage.php';
                break;
            case 'createitem':
                $itemcontroller->createItem();
                break;
            case 'updateitem':
                $itemcontroller->updateItem();
                break;
            case 'deleteitem':
                $itemcontroller->deleteItem();
                break;
        }
        break;
    case 'volunteer':
        switch ($action) {
            // case 'representativeapplication':
            case 'berepresentative':
                $representativecontroller->loadApplicationForm();
                break;
            case 'submitApplication':
                $representativecontroller->submitApplication();
                break;
            case 'updateApplication':
                $representativecontroller->updateApplication();
                break;
            case 'deleteApplication':
                $representativecontroller->deleteApplication();
                break;
            case 'submittedapplication':
                $representativecontroller->checkExistingApplication();
                break;
        }
        break;
    case 'representative':
        switch ($action) {
            case 'repapproveeventbudgets':
                include 'View/representative/orgrep/orgrepbudgetapprove/orgrepbudgetapprove.php';
                break;
            //end of representative stuff

        }
        break;
    case 'sponsor':
        switch ($action) {
            //start of sponsor stuff
            case 'requesttosponsor':
                
                include 'View/sponsor/sponsorship.php';
                break;
            case 'sponsorshipactivity':
                include 'View/sponsor/sponsoractivity/sponsoractivity.php';
                break;
            //end of sponsor stuff
        }
        break;


    case 'manager':
        switch ($action) {

            //start of manager stuff
            case 'managerapproveeventbudgets':
                include 'View/manager/budgetapprove/budgetapprove.php';
                break;
            case 'requestsponsorships':
                include 'View/manager/requestsponsor/requestsponsor.php';
                break;
            case 'incomingsponreq':
                include 'View/sponsor/incomingreq/reviewincomingreqspon.php';
                break;
            case 'approvereppost':
                $requestcontroller->viewAllRepApplications();
                break;
            case 'approveApplication':
                $requestcontroller->approveApplication();
                break;
            case 'rejectApplication':
                $requestcontroller->rejectApplication();
                break;
            case 'selectorgrep':
                $organizationrepcontroller->showOrgRepSelectionPage();
                break;
            case 'appointorgreps':
                $organizationrepcontroller->selectOrgRepresentatives();
                break;




            case 'managereps':
                $representativecontroller->manageRepresentatives();
                break;




            

            //end of manager stuff

        }
        break;

    case 'admin':
        switch ($action) {
            //start of system for admin
            case 'systemoverview':
                $systemoverviewcontroller->showSystemOverview();
                break;


            case 'generatereport':
                $systemoverviewcontroller->generateReport();
                break;


            case 'systemsettings':
                include 'View/admin/systemsettings/systemsettingsadminpanel.php';
                break;
            case 'manageusers':
                $usermanagementcontroller->viewAllUsers();
                break;
            case 'getusersdata':
                $usermanagementcontroller->getUsersData();
                break;
            case 'getuserdetails':
                $usermanagementcontroller->getUserDetails();
                break;
            case 'getstats':
                $usermanagementcontroller->getStats();
                break;
            case 'updateuser':
                $usermanagementcontroller->updateUserData();
                break;
            case 'toggleuserstatus':
                $usermanagementcontroller->toggleUserStatus();
                break;
            case 'deleteuser':
                $usermanagementcontroller->deleteUserAction();
                break;
            case 'getallhighlights':
                $systemsettingscontroller->getallhighlights();
                break;
            case 'gethighlightdetails':
                $systemsettingscontroller->gethighlightdetails();
                break;
            case 'updatehighlight':
                $systemsettingscontroller->updatehighlight();
                break;
            case 'createhighlight':
                $systemsettingscontroller->createhighlight();
                break;
            case 'deactivatehighlight':
                $systemsettingscontroller->deactivatehighlight();
                break;
            case 'activatehighlight':
                $systemsettingscontroller->activatehighlight();
                break;
            //edn of system  for admin

        }
        break;

    case 'donation':
        switch ($action) {
            case 'senddonation':
                include 'View/donations/makedonation.php';
                break;
            case 'initiatepayment':
                $donationcontroller->initiatePayment();
                break;
            case 'successfuldonation':
                $order_id = $_GET['order_id'] ?? null;

                if (!$order_id) {
                    $_SESSION['message'] = 'Invalid transaction';
                    $_SESSION['message_type'] = 'error';
                    header("Location: /V/router.php?module=page&action=homepage");
                    exit();
                }

                //get donation details from controller 
                $donationData = $donationcontroller->getDonationDetails($order_id);
                include 'View/donations/successfuldonation.php';
                break;

            case 'payherenotify':
                // PayHere notification handler
                // Collect all PayHere POST data
                $payhere_data = [
                    'merchant_id' => $_POST['merchant_id'] ?? '',
                    'order_id' => $_POST['order_id'] ?? '',
                    'payment_id' => $_POST['payment_id'] ?? '',
                    'payhere_amount' => $_POST['payhere_amount'] ?? 0,
                    'payhere_currency' => $_POST['payhere_currency'] ?? 'LKR',
                    'status_code' => $_POST['status_code'] ?? -2,
                    'md5sig' => $_POST['md5sig'] ?? ''
                ];
                // Handle payment notification through controller
                $result = $donationcontroller->handleDonationPayment($payhere_data);
                // Return 200 OK to PayHere (required)
                http_response_code(200);
                echo "OK";
                exit(); // Important: stop execution after responding to PayHere

        }
        break;

    case 'sponsorship':
        switch ($action) {
            case 'sendsponsorship':
                $eventId = $_GET['event_id'] ?? null;
                $sponsorEvent = $eventId ? $eventmodel->getEventById($eventId) : null;
                include 'View/sponsor/sponsorship.php';
                break;
            case 'initiatepayment':
                $donationcontroller->initiateSponsorshipPayment();
                break;
            case 'sponsorsuccess':
                $order_id = $_GET['order_id'] ?? null;
                if (!$order_id) {
                    $_SESSION['message'] = 'Invalid transaction';
                    $_SESSION['message_type'] = 'error';
                    header("Location: /V/router.php?module=page&action=homepage");
                    exit();
                }
                $donationData = $donationcontroller->getSponsorshipDetails($order_id);
                include 'View/sponsor/sponsorsuccess.php';
                break;
            case 'payherenotify':
                // PayHere notification handler for sponsorship
                $payhere_data = [
                    'merchant_id' => $_POST['merchant_id'] ?? '',
                    'order_id' => $_POST['order_id'] ?? '',
                    'payment_id' => $_POST['payment_id'] ?? '',
                    'payhere_amount' => $_POST['payhere_amount'] ?? 0,
                    'payhere_currency' => $_POST['payhere_currency'] ?? 'LKR',
                    'status_code' => $_POST['status_code'] ?? '',
                    'md5sig' => $_POST['md5sig'] ?? '',
                    'custom_1' => $_POST['custom_1'] ?? null,
                    'custom_2' => $_POST['custom_2'] ?? null
                ];
                $donationcontroller->handleSponsorshipPayment($payhere_data);
                header('HTTP/1.0 200 OK');
                exit;
                break;
        }


    case 'merch':

        switch ($action) {
            case 'buymerch':
                // Only volunteers can access this page
                if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'volunteer' && $_SESSION['role'] !== 'sponsor')) {
                    $_SESSION['message'] = 'Access denied. Only volunteers and sponsors can access the merchandise store.';
                    $_SESSION['message_type'] = 'error';
                    header("Location: /V/router.php?module=page&action=homepage");
                    exit();
                }
                $inventorycontroller->index();
                break;

            case 'initiatepayment':
                $merchcontroller->initiatePayment();
                break;
            case 'payherenotify':
                $payhere_data = [
                    'merchant_id' => $_POST['merchant_id'] ?? '',
                    'order_id' => $_POST['order_id'] ?? '',
                    'payment_id' => $_POST['payment_id'] ?? '',
                    'payhere_amount' => $_POST['payhere_amount'] ?? 0,
                    'payhere_currency' => $_POST['payhere_currency'] ?? 'LKR',
                    'status_code' => $_POST['status_code'] ?? '',
                    'md5sig' => $_POST['md5sig'] ?? ''
                ];
                $merchcontroller->handlePayHereNotify($payhere_data);
                break;
            case 'successfulpurchase':
                $order_id = $_GET['order_id'] ?? '';
                if (!$order_id) {
                    $_SESSION['message'] = 'Invalid transaction';
                    $_SESSION['message_type'] = 'error';
                    header("Location: /V/router.php?module=merch&action=buymerch");
                    exit();
                }
                $usertype = $_SESSION['role'] ?? null;
                $purchaseData = $merchcontroller->getPurchaseData($_SESSION['user_id'], $usertype, $order_id);
                include 'View/buymerch/successfulpurchase.php';
                break;
            case 'getitems':
                $inventorycontroller->getItems();
                break;
            case 'getpoints':
                $inventorycontroller->getVolunteerPoints();
                break;
            case 'history':
                $inventorycontroller->getPurchaseHistory();
                break;
        }
        break;

    case 'rating':
        switch ($action) {
            case 'peer':
                $peerresult = $peerratingcontroller->renderpeerrating();//returns the format like 'success'=>true,'event'=>$eventdetails,'peers'=>$peers,'progress'=>$progress 
                include 'View/rating/peer/peer.php';
                break;
            case 'ratetasks':
                $taskrateresult = $taskratingcontroller->rendertaskrating();
                include 'View/rating/task/ratetask.php';
                break;
            case 'submitpeerrating':
                // Handle AJAX rating submission
                $peerratingcontroller->submitpeerrating();//this will return a JSON response back to JavaScript
                break;
            case 'submittaskrating':
                $taskratingcontroller->submittaskrating();
                break;
        }
        break;

    case 'achievement':
        switch ($action) {
            case 'getdata':
                //get achievement data for an AJAX request
                //returns JSON with volunteer stats,badges,leaderboard (basically the renderachievements which can be called without refreshing page)
                $achievementcontroller->getachievementdata();//returns result where the format is like success,data and inside data we have star_points,level,level_points,points_to_next_level,projects_completed,hours_volunteered,badges,leaderboard
                break;
            case 'processevent':
                //process event completion and award points
                //called by manager/representative after the event is completed
                //POST:event_id
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $eventId = $_POST['event_id'] ?? null;

                    if (!$eventId) {
                        $_SESSION['message'] = 'No event ID provided';
                        $_SESSION['message_type'] = 'error';
                        header("Location:" . ($_SERVER['HTTP_REFERER'] ?? '/V/router.php?module=activity&action=activity'));
                        //redirects the user back to page they came from using HTTP_REFERER, HTTP_REFERER is the URL of the page that sent the POST request.
                        //If HTTP_REFERER is not set (we dont know where they came from), it defaults to /V/router.php?module=activity&action=activity
                        exit();
                    }
                    //process the event and award points
                    $result = $achievementcontroller->processeventcompletion($eventId);//returns assoc array with keys 'success','volunteers_processed','results','level_ups','new_badges'

                    if ($result['success']) {
                        $message = "Points awarded to {$result['volunteers_processed']} volunteer(s)";
                        //level up volunteers if any and get that message
                        if (!empty($result['level_ups'])) {//if levelups occured
                            $levelupcount = count($result['level_ups']);
                            $message .= ".{$levelupcount} volunteer(s) leveled up!";
                        }
                        //badges given
                        if (!empty($result['new_badges'])) {//if new badges were given out 
                            $badgecount = 0;
                            foreach ($result['new_badges'] as $badges) {
                                $badgecount += count($badges);//had to go extra mile cuz its an assoc array with volunteerId keys(indexes)
                            }
                            $message .= "{$badgecount} new badge(s) earned!";
                        }
                        $_SESSION['message'] = $message;
                        $_SESSION['message_type'] = 'success';

                    } else {
                        $_SESSION['message'] = $result['message'];//message is in the exception block
                        $_SESSION['message_type'] = 'error';
                    }
                    //redirect to activity page
                    header("Location: /V/router.php?module=activity&action=activity");
                    exit();
                }
                break;
            default:
                echo json_encode([
                    'success' => false,
                    'message' => 'Action not found'
                ]);
        }
        break;

    case 'notification':
        switch ($action) {
            case 'getunreadcount':
                $notificationcontroller->getUnreadCount();
                break;
            case 'getnotifications':
                $notificationcontroller->getNotifications();
                break;
            case 'markasread':
                $notificationcontroller->markAsRead();
                break;
            case 'markallasread':
                $notificationcontroller->markAllAsRead();
                break;
            case 'closenotification':
                $notificationcontroller->closeNotification();
                break;
        }
        break;

    default:
        echo "Controller not found";
        break;


}
?>