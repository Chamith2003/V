<?php
$isLoggedIn = isset($_SESSION['user_id']); // used user_id  session variable in usercontroller
$role = $_SESSION['role'] ?? '0';
$name = $_SESSION['name'] ?? '0';


?>
<html>

<head>
    <title>V</title>
    <!-- <link rel="stylesheet" type="text/css" href="/V/View/globalstyles.css"> -->
    <link rel="stylesheet" type="text/css" href="/V/View/navbar/navbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="/V/View/navbar/navbar.js"></script>
</head>

<body>
    <nav class="navBar">
        <div class="navLeft">
            <div class="logo">
                <img src="/V/View/resources/nav-logo.png">
            </div>
            <div class="navTabSet">
                <!-- browser can resolve absolute paths eventhought php cant -->
                <a class="navTab" href="/V/router.php?module=page&action=homepage">Home</a>
                <a class="navTab" href="/V/router.php?module=projects&action=projects">Projects</a>
                <a class="navTab" href="/V/router.php?module=page&action=calendar">Calendar</a>
                <a class="navTab" href="/V/router.php?module=page&action=vmap">Map</a>
                <a class="navTab" href="/V/router.php?module=page&action=aboutus">About Us</a>
                <!-- <a class="navTab">About Us</a> -->
            </div>
        </div>
        <div class="loginButtons">
            <?php if ($isLoggedIn): ?>
                <div class="notifiBellContainer">
                    <a href="/V/router.php?module=user&action=profile#notif" class="notifBell" id="notificationBell">
                        <img src="/V/View/resources/notif.png" alt="notifications" />
                        <span class="notifDot" id="notificationDot"></span>

                    </a>
                </div>

                <div class="userMenu">
                    <div class="nameStuff" onclick="sidebar()" id="nameStuff">
                    <div class="userIcon"  id="profilepic">
                        <img src="<?= htmlspecialchars($_SESSION['profile_path'] ?? '/V/uploads/profile_image/profile.jpg') ?>"
                            class="profile-picture" id="profilePhotoDisplay" alt="Profile Picture">
                        <!-- <img src="/V/View/resources/user.png" alt="User"> -->
                    </div>
                    <div class="sidebarUserInfo">
    <span class="sidebarUserName--navbar">
        <span class="marqueeText"><?php echo htmlspecialchars($name); ?></span>
    </span>
    <span class="sidebarUserRole"><?php echo htmlspecialchars($role); ?></span>
</div>
                </div>
                    <!-- <div class="userDropdown">
                        <a href="/V/router.php?module=user&action=profile">Profile</a>
                        <a href="/V/router.php?module=user&action=logout">Logout</a>
                    </div> -->

                    <div class="sidebar" id="sidebar">
                        <div class="sidebarHeader">
                            <div class="sidebarUserIcon">
                                <img src="<?= htmlspecialchars($_SESSION['profile_path'] ?? '/V/uploads/profile_image/profile.jpg') ?>"
                                    class="profile-picture" id="profilePhotoDisplay" alt="Profile Picture">
                                <!-- <img src="/V/View/resources/user.png" alt="User"> -->
                            </div>
                            <div class="sidebarUserInfo">
    <span class="sidebarUserName--sidebar">
        <span class="marqueeText"><?php echo htmlspecialchars($name); ?></span>
    </span>
    <span class="sidebarUserRole"><?php echo htmlspecialchars($role); ?></span>
</div>
                            <div class="sidebarClose" onclick="sidebar()">&times;</div> <!-- display the x sign -->
                        </div>
                        <div class="sidebarContent">
                            <a href="/V/router.php?module=user&action=profile">Profile</a>

                            <?php if ($role === 'admin'): ?>
                                <div class="sidebarSection">
                                    <h3>Admin Panel</h3>
                                    <a href="/V/router.php?module=admin&action=systemoverview">System Overview</a>
                                    <!-- <a href="/V/router.php?module=&action=">Admin Task</a> -->
                                    <a href="/V/router.php?module=admin&action=systemsettings">System Settings</a>
                                    <a href="/V/router.php?module=admin&action=manageusers">Manage Users</a>
                                </div>
                            <?php endif; ?>
                            <?php if ($role === 'volunteer'): ?>
                                <div class="sidebarSection">
                                    <h3>Volunteer Panel</h3>
                                    <!-- <a href="/V/router.php?module=&action=manage-users">-->
                                    <a href="/V/router.php?module=projects&action=projects">Join an Event</a>
                                    <a href="/V/router.php?module=activity&action=activity">Activity</a>
                                    <a href="/V/router.php?module=donation&action=senddonation">Make a Donation</a>
                                    <a href="/V/router.php?module=merch&action=buymerch">Buy Merchanidise</a>

                                    <?php
                                    global $showRepButton;
                                    ?>
                                    <?php if ($showRepButton): ?>
                                        <a href="/V/router.php?module=volunteer&action=berepresentative">Become a Representative</a>
                                    <?php endif; ?>


                                    <!-- <a href="/V/router.php?module=&action=reports"></a> -->
                                </div>
                            <?php endif; ?>
                            <?php if ($role === 'manager'): ?>
                                <div class="sidebarSection">
                                    <h3>Manager Panel</h3>
                                    <a href="/V/router.php?module=projects&action=createevent">Create Event</a>
                                    <a href="/V/router.php?module=activity&action=activity">Activity</a>
                                    <a href="/V/router.php?module=projects&action=projectapprovals">Project Approvals</a>
                                    <a href="/V/router.php?module=projects&action=annualeventstatus">Annual Event Status</a>
                                    <a href="/V/router.php?module=manager&action=approvereppost">Representative Approvals</a>
                                    <a href="/V/router.php?module=manager&action=managereps">Manage Representatives</a>
                                    <a href="/V/router.php?module=manager&action=selectorgrep">Organization Representatives</a>

                                    <!-- <a href="/V/router.php?module=manager&action=requestsponsorships">Request Sponsorships</a> -->
                                    <!-- <a href="/V/router.php?module=manager&action=approvesponsorships">Approve Sponsorships</a> -->
                                    <!-- <a href="/V/router.php?module=manager&action=managerapproveeventbudgets">Annual Budget
                                        Allocation</a> -->

                                    <a href="/V/router.php?module=inventory&action=inventorymanagement">Manage Inventory</a>
                                    <a href="/V/router.php?module=admin&action=systemoverview">System Overview</a>

                                </div>
                            <?php endif; ?>

                            <?php if ($role === 'sponsor'): ?>
                                <div class="sidebarSection">
                                    <h3>Sponsor Panel</h3>
                                    <a
                                        href="/V/router.php?module=projects&action=events&search=&location=&event_type=&date=&is_annual=1#events-section">Sponsor
                                        an Event</a>
                                    <a href="/V/router.php?module=merch&action=buymerch">Buy Merchanidise</a>
                                    <a href="/V/router.php?module=donation&action=senddonation">Make a Donation</a>
                                    <!-- <a href="/V/router.php?module=sponsor&action=sponsorshipactivity">View Activity</a> -->
                                    <!-- <a href="/V/router.php?module=manager&action=incomingsponreq">View Sponsorship Requests</a> -->



                                    <!-- <a href="/V/router.php?module=&action=reports">Reports</a> -->
                                </div>
                            <?php endif; ?>
                            <?php if ($role === 'representative'): ?>
                                <div class="sidebarSection">
                                    <h3>Representative Panel</h3>
                                    <a href="/V/router.php?module=projects&action=createevent">Create Event</a>
                                    <a href="/V/router.php?module=activity&action=activity">Activity</a>
                                    <!-- <a href="/V/router.php?module=&action=">Donation Approvals</a> -->
                                    <!-- discontined as rep must bring money from home to to tehir own events -->
                                    <!-- <a href="/V/router.php?module=representative&action=budgetrequest">Request an Event Budget</a> -->
                                    <?php if ($name === 'SeniorRepresentative' || $name === 'JuniorRepresentative'): ?>
                                        <a href="/V/router.php?module=representative&action=repapproveeventbudgets">Approve Event
                                            Budgets</a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($role === 'organisationrep'): ?>
                                <div class="sidebarSection">
                                    <h3>Org. Representative Panel</h3>
                                    <a href="/V/router.php?module=projects&action=createevent">Create Event</a>
                                    <a href="/V/router.php?module=activity&action=activity">Activity</a>
                                    <a href="/V/router.php?module=projects&action=annualeventapproval">Annual Event
                                        Approvals</a>
                                </div>
                            <?php endif; ?>
                            <a href="/V/router.php?module=user&action=logout" class="logoutBtn">Logout</a>
                        </div>

                    </div>
                </div>

            </div>
        <?php else: ?>
            <!-- trigger the login function of router.php -->
            <a href="/V/router.php?module=user&action=login" class="signInBtn">Sign In</a>
            <a href="/V/router.php?module=registration&action=register" class="registerBtn">Register</a>
        <?php endif; ?>
        </div>
    </nav>

</body>

</html>