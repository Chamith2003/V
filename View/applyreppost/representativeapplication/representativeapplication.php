<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/V/View/globalstyles.css">
    <link rel="stylesheet" type="text/css" href="/V/View/applyreppost/representativeapplication/representativeapplication.css">
    <title>V</title>
    <?php include __DIR__ . '/../../navbar/navbar.php'; ?>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-background">
        <div class="header">
            <div class="header-card">
                <h1 class="header-title">
                    <?php echo $isEditMode ? 'Edit Application' : 'Representative Application Form'; ?>
                </h1>
                <p class="header-subtitle">
                    <?php echo $isEditMode ? 'Update your application details below' : 'Please fill in the details below to complete your application'; ?>
                </p>
            </div>
        </div>

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

        <div class="container-applicationbackground">
            <form id="applicationForm" method="POST" enctype="multipart/form-data" 
                  action="router.php?module=volunteer&action=<?php echo $isEditMode ? 'updateApplication' : 'submitApplication'; ?>">

                <div class="card-application">
                    <div class="card-header">
                        <h2 class="card-title">
                            <img src="/V/View/applyreppost/representativeapplication/resources/user-icon.svg" 
                                 width="20" height="20" alt="User Icon">
                            Personal Information
                        </h2>
                        <p class="card-description">Your personal details</p>
                    </div>
                    <div class="card-content">
                        
                        <div class="profile-section">
                            <div class="profile-container">
                                <div class="profile-picture" id="profilePicture">
                                    <img src="/V/View/applyreppost/representativeapplication/resources/avatar-placeholder.png" 
                                         width="80" height="80" alt="User Icon">
                                </div>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="label" for="fullName">Full Name</label>
                                <input type="text" id="name" class="input" 
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

                
                <div class="card-application">
                    <div class="card-header">
                        <h2 class="card-title">
                            <img src="/V/View/applyreppost/representativeapplication/resources/location-icon.svg" 
                                 width="20" height="20" alt="Location Icon">
                            Representative Locations
                        </h2>
                        <p class="card-description">Locations you can represent</p>
                    </div>
                    <div class="card-content">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="label" for="location1">Primary Location</label>
                                <input type="text" id="location1" class="input" 
                                       value="<?php echo htmlspecialchars($locationData['preferred_location_1']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label class="label" for="location2">Secondary Location</label>
                                <input type="text" id="location2" class="input" 
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
                        <p class="card-description">Tell us about your motivation and experience</p>
                    </div>
                    <div class="card-content">
                        <div class="form-group">
                            <label class="label" for="reasonForApplication">Reason for Application *</label>
                            <textarea id="reasonForApplication" name="reason" class="textarea" rows="4" 
                                      placeholder="Please describe why you want to become a representative..."><?php 
                                if ($isEditMode && $existingApplication) {
                                    echo htmlspecialchars($existingApplication['description']);
                                }
                            ?></textarea>
                            <div class="error-message" id="reasonForApplicationError"></div>
                        </div>

                        <div class="form-group">
                            <label class="label" for="professionalLinks">Professional Links (Optional)</label>
                            <input type="url" id="professionalLinks" name="professionallinks" class="input" 
                                   placeholder="LinkedIn, portfolio, or other professional links"
                                   value="<?php echo $isEditMode && $existingApplication ? htmlspecialchars($existingApplication['linkedin']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label class="label" for="experience">Years of Experience</label>
                            <input type="number" id="experience" name="experience" class="input" 
                                   placeholder="Enter your experience in years"
                                   value="<?php echo $isEditMode && $existingApplication ? htmlspecialchars($existingApplication['experience']) : ''; ?>">
                            <div class="error-message" id="experienceError"></div>
                        </div>

                    </div>
                </div>

                
                <div class="card-application">
                    <div class="card-content">
                        <div class="checkbox-container">
                            <input type="checkbox" id="termsAccepted" name="termsAccepted" 
                                   class="checkbox" <?php echo $isEditMode ? 'checked' : ''; ?>>
                            <div>
                                <label for="termsAccepted" class="checkbox-label">
                                    I accept the terms and conditions *
                                </label>
                                <div class="checkbox-description">
                                    By checking this box, you agree to our 
                                    <a href="#">terms of service</a> and 
                                    <a href="#">privacy policy</a>. 
                                    You also consent to being contacted regarding your application.
                                </div>
                                <div class="error-message" id="termsAcceptedError"></div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="button-group">
                    <button type="button" class="btn btn-outline" id="cancelBtn">Cancel</button>
                    
                    <?php if ($isEditMode): ?>
                        <button type="button" class="btn btn-secondary" onclick="deleteApplicationFromEdit()">
                            🗑️ Delete Application
                        </button>
                    <?php endif; ?>
                    
                    <button type="submit" class="btn btn-primary">
                        <img src="/V/View/applyreppost/representativeapplication/resources/submit-icon.svg" 
                             width="20" height="20" alt="Submit Icon">
                        <?php echo $isEditMode ? 'Update Application' : 'Submit Application'; ?>
                    </button>
                </div>
            </form>

            
            <div class="footer-help">
                <p>Contact us at v4volunteering0000@gmail.com</p>
            </div>
        </div>
    </div>

    <script>
        let formData = {
            termsAccepted: <?php echo $isEditMode ? 'true' : 'false'; ?>
        };

        function resetForm() {
            <?php if ($isEditMode): ?>
                if (confirm('Cancel editing?\n\nAny changes you made will NOT be saved.\n\nDo you want to return to view mode?')) {
                    window.location.href = '/V/router.php?module=volunteer&action=submittedapplication';
                }
            <?php else: ?>
                if (confirm('Cancel application?\n\nAll information you entered will be LOST.\n\nDo you want to return to homepage?')) {
                    window.location.href = '/V/router.php?module=page&action=homepage';
                }
            <?php endif; ?>
        }
    </script>
    <script src="/V/View/applyreppost/representativeapplication/representativeapplication.js"></script>
</body>
</html>