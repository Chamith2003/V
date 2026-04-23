<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/V/View/globalstyles.css">
    <link rel="stylesheet" type="text/css" href="/V/View/applyreppost/submittedapplication/submittedapplication.css">
    <title>V</title>
    <?php include __DIR__ . '/../../navbar/navbar.php'; ?>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="error-notification" id="errorNotification">
            <?= htmlspecialchars($_SESSION['error_message']) ?>
        </div>
        <script>
            window.addEventListener('DOMContentLoaded', function() {
                const notification = document.getElementById('errorNotification');
                notification.style.display = 'block';
                setTimeout(function() {
                    notification.style.display = 'none';
                }, 5000);
            });
        </script>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <div class="container-background">
        <div class="header">
            <div class="header-card">
                <h1 class="header-title">
                    <span>📋</span>
                    Submitted Application
                </h1>
                <p class="header-subtitle">Review your submitted application details</p>
                <span class="status-badge <?php echo htmlspecialchars($exists['status']); ?>" id="applicationStatus">
                    <?php 
                        if ($exists['status'] === 'pending') {
                            echo 'Pending Review';
                        } elseif ($exists['status'] === 'approved') {
                            echo 'Approved';
                        } elseif ($exists['status'] === 'rejected') {
                            echo 'Rejected';
                        } else {
                            echo 'Pending';
                        }
                    ?>
                </span>
            </div>
        </div>

        <div class="container-applicationbackground view-mode">
            <div id="alertContainer"></div>

            <div id="applicationView">
                
                <div class="card-application">
                    <div class="card-header">
                        <h2 class="card-title">
                            <img src="/V/View/applyreppost/representativeapplication/resources/user-icon.svg" 
                                 width="20" height="20" alt="User Icon">
                            Personal Information
                        </h2>
                        <p class="card-description">Your personal details from your profile</p>
                    </div>
                    <div class="card-content">
                        <div class="profile-section">
                            <div class="profile-container">
                                <div class="profile-picture" id="profilePicture">
                                    <img src="/V/View/applyreppost/representativeapplication/resources/avatar-placeholder.png" 
                                         alt="Profile Picture">
                                </div>
                            </div>
                            <div class="profile-info">
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label class="label" for="fullName">Full Name</label>
                                        <input style="width: 50%;" type="text" id="name" class="input" 
                                               value="<?php echo htmlspecialchars($userData['name']); ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label class="label" for="email">Email Address</label>
                                        <input type="email" id="email" class="input" 
                                               value="<?php echo htmlspecialchars($userData['email']); ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="label" for="phone">Phone Number</label>
                                        <input type="tel" id="contactnumber" class="input" 
                                               value="<?php echo htmlspecialchars($userData['contactnumber']); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card-application">
                    <div class="card-header">
                        <h2 class="card-title">
                            <img src="/V/View/applyreppost/representativeapplication/resources/location-icon.svg" 
                                 width="20" height="20" alt="Location Icon">
                            Representative Locations
                        </h2>
                        <p class="card-description">Locations you can represent (from your profile)</p>
                    </div>
                    <div class="card-content">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="label" for="location1">Primary Location</label>
                                <input type="text" id="location1" name="location1" class="input" 
                                       value="<?php echo htmlspecialchars($locationData['preferred_location_1']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label class="label" for="location2">Secondary Location</label>
                                <input type="text" id="location2" name="location2" class="input" 
                                       value="<?php echo htmlspecialchars($locationData['preferred_location_2']); ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card-application">
                    <div class="card-header">
                        <h2 class="card-title">
                            <img src="/V/View/applyreppost/representativeapplication/resources/document-icon.svg" 
                                 width="20" height="20" alt="Document Icon">
                            Application Details
                        </h2>
                        <p class="card-description">Your motivation and experience (editable)</p>
                    </div>
                    <div class="card-content">
                        <div class="form-group">
                            <label class="label" for="reasonForApplication">Reason for Application</label>
                            <textarea id="reasonForApplication" name="reason" class="textarea" rows="4" 
                                      readonly><?php echo htmlspecialchars($exists['description']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="label" for="professionalLinks">Professional Links</label>
                            <input type="url" id="professionalLinks" name="professionallinks" class="input" 
                                   readonly value="<?php echo htmlspecialchars($exists['linkedin']); ?>">
                        </div>

                        <div class="form-group">
                            <label class="label" for="experience">Years of Experience</label>
                            <input type="number" id="experience" name="experience" class="input" 
                                   readonly value="<?php echo htmlspecialchars($exists['experience']); ?>">
                        </div>
                    </div>
                </div>

                
                <div class="button-group">
                    <a href="/V/router.php?module=page&action=homepage" class="btn btn-outline">
                        Return to Home
                    </a>
                    <button type="button" class="btn btn-danger" onclick="deleteApplication()">
                        🗑️ Delete Application
                    </button>
                    <a href="/V/router.php?module=volunteer&action=berepresentative&mode=edit" class="btn btn-primary">
                        ✏️ Edit Application
                    </a>
                </div>
            </div>

            
            <div class="footer-help">
                <p>Contact us at v4volunteering0000@gmail.com</p>
            </div>
        </div>
    </div>

    <script src="/V/View/applyreppost/submittedapplication/submittedapplication.js"></script>
</body>
</html>