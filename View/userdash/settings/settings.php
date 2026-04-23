<?php
$role = $_SESSION['role'] ?? '0';

$achievementdata = $achievementdata ?? null;


// Get availability data (already fetched in controller)
$savedAvailability = $availabilities ?? [];

// Organize availability by time slot for better display
$availabilityByTime = [
    'Morning' => [],
    'Afternoon' => [],
    'Evening' => []
];

foreach ($savedAvailability as $slot) {
    list($day, $time) = explode('-', $slot);
    $availabilityByTime[$time][] = $day;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V</title>
    <link rel="stylesheet" type="text/css" href="/V/View/userdash/settings/settings.css">
    <?php include __DIR__ . '/../../navbar/navbar.php'; ?>

    <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>



</head>

<body>
    <div class="container">
        <h1 class="page-title">Account Settings</h1>
        <p class="page-subtitle">Manage your profile and preferences</p>

        <div class="main-content-wrapper">
            <!-- menu Navigation -->
            <div class="menu">
                <?php if ($role === 'representative' || $role === 'manager' || $role === 'volunteer' || $role === 'admin'|| $role == 'organisationrep'): ?>
                    <a href="#" class="menu-item active" data-content-id="personal-info">
                        <img src="/V/View/userdash/settings/img/user.png" alt="user" />

                        <span>Personal Info</span>
                    </a>
                <?php endif; ?>
                <?php if ($role === 'sponsor'): ?>
                    <a href="#" class="menu-item active" data-content-id="sponsor-info">
                        <img src="/V/View/userdash/settings/img/user.png" alt="sponsor" />
                        <span>Business Info</span>
                    </a>
                <?php endif; ?>

                <?php if ($role != 'admin' && $role != 'manager' && $role != 'sponsor'): ?>
                    <a href="#" class="menu-item" data-content-id="qrcode">
                        <img src="/V/View/userdash/settings/img/qrcode.png" alt="qrcode" />

                        <span>QR code</span>
                    </a>
                <?php endif; ?>




                <!-- <a href="#" class="menu-item" >
                    <img src="/V/View/userdash/settings/img/scanner.png" alt="scanner" />

                    <span>QR code scanner</span>
                </a> -->

                <!-- <span><a href="/V/router.php?module=activity&action=activity">QR code scanner</a></span> -->



                <?php if ($role != 'admin' && $role != 'manager' && $role != 'sponsor'): ?>
                    <a href="#" class="menu-item" data-content-id="achievements">

                        <img src="/V/View/userdash/settings/img/achievement.png" alt="achievement" />
                        <span>Achievements</span>
                    </a>


                <?php endif; ?>

                <a href="#" class="menu-item" data-content-id="notif">
                    <img src="/V/View/userdash/settings/img/bell.png" alt="notifications" />
                    <span>Notifications</span>
                </a>



                <a href="#" class="menu-item" data-content-id="security">
                    <img src="/V/View/userdash/settings/img/lock.png" alt="security" />
                    <span>Security</span>
                </a>

                <!-- <a href="#" class="menu-item" data-content-id="notifications">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0l-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z"/>
                    </svg>
                    <span>Notifications</span>
                </a>
                <a href="#" class="menu-item" data-content-id="privacy">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12z"/>
                    </svg>
                    <span>Privacy</span>
                </a> -->
            </div>

            <!-- Main Content Panel -->
            <div class="main-panel">
                <?php if ($role == 'volunteer' || $role == 'representative' || $role == 'manager'|| $role == 'admin'|| $role == 'organisationrep'): ?>
                    <!-- Personal Info Section -->
                    <div id="personal-info" class="content-section active">
                        <div class="panel-header">
                            <div class="panel-header-top">
                                <h2>Personal Information</h2>
                                <button class="edit-profile-btn" id="editProfileBtn">Edit Profile</button>
                            </div>
                            <p>Update your personal details and profile information</p>
                        </div>

                        <form action="/V/router.php?module=user&action=profileUpdate" method="POST">
                            <div class="profile-details">
                                <div class="profile-summary">

                                    <!-- <img src="<?= htmlspecialchars($user['profile_path'] ?? '/V/View/userdash/settings/img/profile.jpg') ?>" class="profile-picture"   id="profilePhotoDisplay" alt="Profile Picture"> -->
                                    <div class="profile-picture-wrapper" style="position: relative; display: inline-block;">
                                        <img src="<?= htmlspecialchars($user['profile_path'] ?? '/V/View/userdash/settings/img/profile.jpg') ?>"
                                            class="profile-picture" id="profilePhotoDisplay" alt="Profile Picture">

                                        <!-- Upload Button (Plus Mark) - Hidden by default -->
                                        <div class="upload-logo-btn" id="uploadLogoBtn" style="display: none;">
                                            +
                                        </div>
                                        <input type="file" class="file-input" id="logoFileInput" accept="image/*"
                                            style="display: none;">
                                    </div>
                                    <!-- <img src="/V/View/userdash/settings/img/profile1.png" class="profile-picture"> -->
                                    <div class="profile-text">
                                        <h3><?= htmlspecialchars($user['name']) ?></h3>
                                        <p><?= htmlspecialchars($user['role']) ?>
                                            U_00<?= htmlspecialchars($user['userid']) ?></p>
                                        <p>Member since <?= htmlspecialchars($user['createddate']) ?></p>
                                    </div>
                                </div>

                                <div class="form-grid">
                                    <div class="form-field">
                                        <label for="Name">Name</label>
                                        <input type="text" id="Name" name="name"
                                            value="<?= htmlspecialchars($user['name']) ?>" readonly>
                                    </div>

                                    <div class="form-field">
                                        <label for="email">Email Address</label>
                                        <input type="email" id="email" name="email"
                                            value="<?= htmlspecialchars($user['email']) ?>" readonly>
                                    </div>
                                    <div class="form-field">
                                        <label for="phone">Phone Number</label>
                                        <input type="tel" id="phone" name="contactnumber"
                                            value="<?= htmlspecialchars($user['contactnumber']) ?>" readonly>
                                    </div>
                                    <?php if ($role != 'admin' && $role != 'manager' && $role != 'sponsor'): ?>
                                        <div class="form-field">
                                            <label for="DOB">Date of Birth</label>
                                            <input type="date" id="DOB" name="dob" value="<?= htmlspecialchars($user['dob']) ?>"
                                                readonly>
                                        </div>

                                        <div class="locations-wrapper">
                                            <div class="form-field">
                                                <label for="location">Location 1</label>
                                                <input type="text" id="location" name="preferred_location_1"
                                                    value="<?= htmlspecialchars($user['preferred_location_1']) ?>" readonly>
                                            </div>
                                            <div class="form-field">
                                                <label for="location">Location 2</label>
                                                <input type="text" id="location" name="preferred_location_2"
                                                    value="<?= htmlspecialchars($user['preferred_location_2']) ?>" readonly>
                                            </div>

                                            <div class="form-field">
                                                <label for="location">Location 3</label>
                                                <input type="text" id="location" name="preferred_location_3"
                                                    value="<?= htmlspecialchars($user['preferred_location_3']) ?>" readonly>
                                            </div>

                                        </div>

                                        <div class="form-field availability-field">
                                            <label>Your Availability</label>

                                            <div class="availability-display" id="availabilityDisplay">
                                                <?php if (!empty($savedAvailability)): ?>
                                                    <div class="availability-view-mode">
                                                        <?php foreach ($availabilityByTime as $time => $days): ?>
                                                            <?php if (!empty($days)): ?>
                                                                <div class="availability-time-slot">
                                                                    <h4 class="availability-time-label">
                                                                        <?php echo $time; ?>
                                                                        <span class="availability-time-range">
                                                                            <?php
                                                                            if ($time === 'Morning')
                                                                                echo '(8:00 AM - 12:00 PM)';
                                                                            elseif ($time === 'Afternoon')
                                                                                echo '(12:00 PM - 4:00 PM)';
                                                                            else
                                                                                echo '(4:00 PM - 8:00 PM)';
                                                                            ?>
                                                                        </span>
                                                                    </h4>
                                                                    <div class="availability-days">
                                                                        <?php foreach ($days as $day): ?>
                                                                            <span class="availability-badge"><?php echo $day; ?></span>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="availability-empty">
                                                        <p>No availability set yet</p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Hidden Edit Mode (shown when editing profile) -->
                                            <div class="availability-edit-mode" id="availabilityEditMode"
                                                style="display: none;">
                                                <div class="availability-warning"
                                                    style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 12px 15px; margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px;">
                                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ff9800"
                                                        stroke-width="2">
                                                        <path
                                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                                                    </svg>
                                                    <div>
                                                        <strong style="color: #856404;">Important:</strong>
                                                        <p style="margin: 5px 0 0 0; color: #856404; font-size: 0.95rem;">
                                                            When you update your availability, you commit to participating in
                                                            all
                                                            events scheduled during those time slots that you have already
                                                            joined.
                                                            Please ensure you can meet these commitments.
                                                        </p>
                                                    </div>
                                                </div>
                                                <table class="availability-table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Mon</th>
                                                            <th>Tue</th>
                                                            <th>Wed</th>
                                                            <th>Thu</th>
                                                            <th>Fri</th>
                                                            <th>Sat</th>
                                                            <th>Sun</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                                                        $times = ['Morning', 'Afternoon', 'Evening'];

                                                        foreach ($times as $time):
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $time; ?><br>
                                                                    <small style="color:#555;">
                                                                        <?php
                                                                        if ($time === 'Morning')
                                                                            echo '8:00 AM - 12:00 PM';
                                                                        if ($time === 'Afternoon')
                                                                            echo '12:00 PM - 4:00 PM';
                                                                        if ($time === 'Evening')
                                                                            echo '4:00 PM - 8:00 PM';
                                                                        ?>
                                                                    </small>
                                                                </td>
                                                                <?php foreach ($days as $day):
                                                                    $key = $day . '-' . $time;
                                                                    $checked = in_array($key, $savedAvailability) ? 'checked' : '';
                                                                    ?>
                                                                    <td>
                                                                        <input type="checkbox" name="<?php echo $day . '_' . $time; ?>"
                                                                            <?php echo $checked; ?> />
                                                                    </td>
                                                                <?php endforeach; ?>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="form-field bio-field">
                                            <label for="bio">Volunteer Experience</label>
                                            <textarea id="bio" rows="4" name="volunteer_experience"
                                                readonly><?= htmlspecialchars($user['volunteer_experience'] ?? '') ?></textarea>
                                            <span class="char-count"
                                                id="bio-char-count"><?= strlen($user['volunteer_experience'] ?? '') ?>/500
                                                characters</span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-actions" id="formActions">
                                        <button type="submit" class="btn btn-save" onclick="saveEventChanges()"
                                            id="saveProfileBtn">Save Changes</button>
                                        <button type="reset" class="btn btn-cancel" id="cancelProfileBtn">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                <?php endif; ?>

                <?php if ($role == 'sponsor'): ?>
                    <!-- sponsor Info Section -->
                    <div id="sponsor-info" class="content-section active">
                        <div class="panel-header">
                            <div class="panel-header-top">
                                <h2>Business Information</h2>
                                <button class="edit-profile-btn" id="editProfileBtn">Edit Information</button>
                            </div>
                            <p>Update your business and contact details</p>
                        </div>

                        <form action="/V/router.php?module=user&action=profileUpdate" method="POST"
                            enctype="multipart/form-data">
                            <div class="profile-details">
                                <div class="profile-summary">

                                    <div class="profile-picture-wrapper" style="position: relative; display: inline-block;">
                                        <img src="<?= htmlspecialchars($user['profile_path'] ?? '/V/View/userdash/settings/img/profile1.png') ?>"
                                            class="profile-picture" id="profilePhotoDisplay" alt="Profile Picture">

                                        <!-- Upload Button (Plus Mark) - Hidden by default -->
                                        <div class="upload-logo-btn" id="uploadLogoBtn" style="display: none;">
                                            +
                                        </div>
                                        <input type="file" class="file-input" id="logoFileInput" accept="image/*"
                                            style="display: none;">
                                    </div>

                                    <!-- <img src="<?= htmlspecialchars($user['profile_path'] ?? '/V/View/userdash/settings/img/profile1.png') ?>"
                                        class="profile-picture" id="profilePhotoDisplay" alt="Profile Picture"> -->
                                    <!-- <img src="/V/View/userdash/settings/img/profile1.png" class="profile-picture"> -->
                                    <div class="profile-text">
                                        <h3><?= htmlspecialchars($user['name']) ?></h3>
                                        <p><?= htmlspecialchars($user['role']) ?>
                                            U_00<?= htmlspecialchars($user['userid']) ?></p>
                                        <p>Member since <?= htmlspecialchars($user['createddate']) ?></p>
                                    </div>
                                </div>
                                <input type="hidden" id="logoPath" name="logo_path"
                                    value="<?= htmlspecialchars($user['logo_path'] ?? '') ?>">
                                <div class="form-grid">
                                    <!-- Contact Information Section -->
                                    <h3 class="h3style">
                                        Contact Information</h3>

                                    <div class="form-field">
                                        <label for="name">Full Name</label>
                                        <input type="text" id="name" name="name"
                                            value="<?= htmlspecialchars($user['name']) ?>" readonly>
                                    </div>

                                    <div class="form-field">
                                        <label for="email">Email Address</label>
                                        <input type="email" id="email" name="email"
                                            value="<?= htmlspecialchars($user['email']) ?>" readonly>
                                    </div>

                                    <div class="form-field">
                                        <label for="phone">Phone Number</label>
                                        <input type="tel" id="phone" name="contactnumber"
                                            value="<?= htmlspecialchars($user['contactnumber']) ?>" readonly>
                                    </div>

                                    <!-- Business Contact Person Section -->
                                    <h3 class="h3style">
                                        Business Contact Person</h3>

                                    <div class="form-field">
                                        <label for="contact_person_name">Contact Person Name</label>
                                        <input type="text" id="contact_person_name" name="contact_person_name"
                                            value="<?= htmlspecialchars($user['contact_person_name'] ?? '') ?>" readonly>
                                    </div>

                                    <div class="form-field">
                                        <label for="contact_person_role">Contact Person Role</label>
                                        <input type="text" id="contact_person_role" name="contact_person_role"
                                            value="<?= htmlspecialchars($user['contact_person_role'] ?? '') ?>" readonly>
                                    </div>

                                    <div class="form-field">
                                        <label for="contact_person_email">Contact Person Email</label>
                                        <input type="email" id="contact_person_email" name="contact_person_email"
                                            value="<?= htmlspecialchars($user['contact_person_email'] ?? '') ?>" readonly>
                                    </div>

                                    <div class="form-field">
                                        <label for="contact_person_contact_number">Contact Person Phone</label>
                                        <input type="tel" id="contact_person_contact_number"
                                            name="contact_person_contact_number"
                                            value="<?= htmlspecialchars($user['contact_person_contact_number'] ?? '') ?>"
                                            readonly>
                                    </div>

                                    <!-- Business Details Section -->
                                    <h3 class="h3style">
                                        Business Details</h3>

                                    <div class="form-field">
                                        <label for="business_registration_number">Business Registration Number</label>
                                        <input type="text" id="business_registration_number"
                                            name="business_registration_number"
                                            value="<?= htmlspecialchars($user['business_registration_number'] ?? '') ?>"
                                            readonly>
                                    </div>

                                    <!-- <div class="form-field">
                                        <label for="year_established">Year Established</label>
                                        <input type="number" id="year_established" name="year_established" min="1900"
                                            max="<?= date('Y') ?>"
                                            value="<?= htmlspecialchars($user['year_established'] ?? '') ?>" readonly>
                                    </div> -->

                                    <div class="form-field">
                                        <label for="organization_type">Organization Type</label>
                                        <input type="text" id="organization_type" name="organization_type"
                                            value="<?= htmlspecialchars($user['organization_type'] ?? '') ?>" readonly>
                                    </div>

                                    <div class="form-field">
                                        <label for="official_website_link">Official Website Link</label>
                                        <input type="url" id="official_website_link" name="official_website_link"
                                            value="<?= htmlspecialchars($user['official_website_link'] ?? '') ?>" readonly>
                                    </div>


                                    <div class="form-field bio-field">
                                        <label for="bio">About Company</label>
                                        <textarea id="bio" rows="4" name="about_company"
                                            readonly><?= htmlspecialchars($user['about_company'] ?? '') ?></textarea>
                                        <span class="char-count"
                                            id="bio-char-count"><?= strlen($user['about_company'] ?? '') ?>/500
                                            characters</span>
                                    </div>
                                    <div class="form-actions" id="formActions">
                                        <button type="submit" class="btn btn-save" onclick="saveEventChanges()"
                                            id="saveProfileBtn">Save Changes</button>
                                        <button type="reset" class="btn btn-cancel" id="cancelProfileBtn">Cancel</button>
                                    </div>

                                    <!-- <div class="form-actions" id="formSponsorActions" style="grid-column: 1 / -1;">
                                        <button type="submit" class="btn btn-save" id="saveProfileBtn">Save Changes</button>
                                        <button type="reset" class="btn btn-cancel" id="cancelSponsorBtn">Cancel</button>
                                    </div> -->
                                </div>
                            </div>
                        </form>
                    </div>

                <?php endif; ?>


                <!-- QR Code Section -->
                <div id="qrcode" class="content-section">
                    <div class="panel-header">
                        <h2>QR Code</h2>
                        <p>Mark your attendance by scanning this QR code at events</p>
                    </div>
                    <div class="qr-code-wrapper">
                        <div class="qrcode"> </div>
                        <div class="user-id-container">
                            <label for="userId">User ID: <?= htmlspecialchars($user['userid']) ?> </label>
                            <!-- <input type="text" id="userId" name="userId" placeholder="e.g., U123456"> -->
                        </div>
                        <button id="downloadButton" class="download-btn">
                            Download QR Code
                        </button>
                    </div>



                </div>



                <!-- Achievements Section -->

                <?php if ($role != 'admin' && $role != 'manager' && $role != 'sponsor'): ?>
                    <!--USES OTHER METHOD IF PHP IFs-->
                    <div id="achievements" class="content-section">



                        <div class="panel-header">
                            <div class="panel-header-top">
                            <h2>Achievements</h2>
                            
                            <div class="nameTagAchievements">Name : <?= htmlspecialchars($user['name']) ?></div>
                            
                        </div>
                        <p>View your achievements and leaderboard rank</p>
                        </div>
                        <div class="achievements-main-grid">
                            <div class="achievements-stats">
                                <div class="achievements-starpoint-section">
                                    <p style="text-align: center; color: #666;">Loading...</p>
                                    <!-- Star Points -->
                                </div>
                                <div class="achievements-badges-section ">
                                    <p style="text-align: center; color: #666;">Loading...</p>
                                </div>
                            </div>
                            <div class="achievements-leaderboard">
                                <p style="text-align: center; color: #666;">Loading...</p>
                                <!-- This is the leaderboard section -->
                            </div>
                        </div>

                    </div>
                <?php endif; ?>


                <div id="notif" class="content-section">
                    <div class="panel-header">
                        <div class="panel-header-top">
                            <h2>Notifications</h2>
                            <button class="mark-all-read" onclick="markAllAsRead()">Mark all as read</button>
                        </div>
                        <p>View your messages and other important updates</p>

                    </div>

                    <div class="notifications-container">


                        <div class="notifications-list" id="notificationsList">
                            <!-- Notifications will be inserted here -->
                        </div>

                        <div class="empty-state" id="emptyState" style="display: none;">
                            <div class="empty-state-icon"><img src="/V/View/userdash/settings/img/postbox.png"
                                    alt="messages" /></div>
                            <p>No notifications yet</p>
                        </div>
                    </div>


                </div>





                <!-- Security Section -->
                <div id="security" class="content-section">
                    <div class="panel-header">
                        <h2>Security Settings</h2>
                        <p>Manage your account security and login preferences</p>
                    </div>

                    <div class="setting-item">
                        <div class="setting-info">
                            <h3>Password</h3>
                            <p>Change your password by adding a new one</p>

                        </div>
                        <button class="btn btn-change" id="changePasswordBtn">Change Password</button>
                    </div>

                    <div class="setting-item">
                        <div class="setting-info">
                            <h3>Delete Account</h3>
                            <p>Permanently delete your account and all data</p>
                        </div>
                        <button class="btn btn-delete" id="deleteAccountBtn">
                            <img src="/V/View/userdash/settings/img/delete.png" alt="delete" />Delete
                        </button>
                    </div>

                    <!-- Account Deleted Message -->
                    <div id="accountDeletedSuccessMessage" class="success-message">
                        Account successfully deleted!
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Password Modal -->
        <div class="modal-overlay" id="changePasswordModal">
            <div class="modal-card">
                <div class="modal-header">
                    <h3>Change Password</h3>
                    <button class="modal-close-btn">&times;</button>
                </div>

                <!-- Messages -->
                <div id="passwordUpdateSuccessMessage" class="alert success-banner"
                    style="margin-bottom:16px; padding:12px 18px; border-radius:8px; background:#e6ffed; color:#155724; border:1px solid #c3f0d6; display:none; font-weight:500;">
                </div>
                <div id="passwordUpdateErrorMessage" class="alert error-banner"
                    style="margin-bottom:16px; padding:12px 18px; border-radius:8px; background:#fdecea; color:#721c24; border:1px solid #f5c6cb; display:none; font-weight:500;">
                </div>

                <form id="changePasswordForm">::
                    <div class="form-field">
                        <label for="currentPassword">Current Password</label>
                        <input type="password" name="currentPassword" id="currentPassword"
                            placeholder="Enter current password" required>
                    </div>
                    <div class="form-field">
                        <label for="newPassword">New Password</label>
                        <input type="password" name="newPassword" id="newPassword" placeholder="Enter new password"
                            required>
                    </div>
                    <div class="form-field">
                        <label for="confirmNewPassword">Confirm New Password</label>
                        <input type="password" name="confirmNewPassword" id="confirmNewPassword"
                            placeholder="Confirm new password" required>
                    </div>
                    <div class="password-criteria">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display: inline;">
                            <path d="M11 7h2v2h-2zm0 4h2v6h-2z" />
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" />
                        </svg>
                        Password must be at least 8 characters with uppercase, lowercase, and numbers
                    </div>
                    <div class="form-actions2">
                        <button type="submit" class="btn btn-save" id="updatePasswordBtn">Update Password</button>
                        <button type="button" class="btn btn-cancel" id="cancelPasswordBtn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- New Delete Account Modal -->
        <div class="modal-overlay" id="deleteAccountModal">
            <div class="modal-card delete-modal">
                <div class="icon-wrapper">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                    </svg>
                </div>
                <h3>Delete Account</h3>
                <p>This action cannot be undone. All your data will be permanently deleted.</p>

                <div class="deleted-items">
                    <h4>What will be deleted:</h4>
                    <ul>
                        <li>Your profile and personal information</li>
                        <li>All project contributions and ratings</li>
                        <li>Event registrations and history</li>
                        <li>Messages and communications</li>
                    </ul>
                </div>

                <div class="form-actions2">
                    <button class="btn btn-cancel" id="cancelDeleteBtn">Cancel</button>
                    <button class="btn btn-delete" id="confirmDeleteBtn">Delete Account</button>
                </div>
            </div>
        </div>
        <script>
            // Generate QR code using User ID
            document.addEventListener("DOMContentLoaded", function () {
                const userId = "<?= htmlspecialchars($user['userid']) ?>"; // PHP -> JS





                // Select QR code container
                const qrContainer = document.querySelector(".qrcode");

                // Clear previous QR (optional)
                qrContainer.innerHTML = "";

                // Generate QR code
                new QRCode(qrContainer, {
                    text: userId,
                    width: 200,
                    height: 200,
                    correctLevel: QRCode.CorrectLevel.H
                });
            });


        </script>

        <script src="/V/View/userdash/settings/settings.js"></script>

        <?php if ($role != 'admin' && $role != 'manager' && $role != 'sponsor'): ?>
            <script src="/V/View/userdash/settings/achievement.js"></script>
        <?php endif; ?>

</body>

</html>