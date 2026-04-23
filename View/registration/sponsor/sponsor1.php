<?php
// Display error if exists
$error = $_SESSION['error'] ?? '';
if ($error) {
    echo "<script>alert('{$error}');</script>";
    unset($_SESSION['error']);
}

// Get saved data if any
$savedData = $_SESSION['s_registration_step1'] ?? [];
$role = $_SESSION['registration_role'] ?? 'sponsor';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V</title>
    <!-- <link rel="stylesheet" href="registration.css"> -->
    <link rel="stylesheet" type="text/css" href="/V/View/registration/registration.css">
</head>

<body>
    <div class="container">
        <!-- Progress Steps -->
        <div class="progress">
            <h2>Join Our Community</h2>
            <p>Create your environmental volunteer account</p>


            <?php if ($role == 'sponsor'): ?>
                <div class="steps">
                    <div class="circle active">1</div>
                    <div class="line"></div>
                    <div class="circle">2</div>
                    <div class="line"></div>
                    <div class="circle">3</div>
                    
                </div>
            <?php endif; ?>
        </div>

        <!-- Form Card -->
        <div class="form-card">
            <div class="form-header">
                <h3>Sponsor Information</h3>
                <span class="step-text">Step 1 of 3</span>
            </div>
            <p class="sub-text">Tell us about Organization / Sponsor Basic Details</p>

            <!-- <form> -->
            <form method="POST" action="/V/router.php?module=registration&action=s_registration_step1">
                <div class="form-row">
                    <div class="form-group">
                        <label>Organization / Company Name *</label>
                        <!-- <input type="text" placeholder="Enter your first name"> -->
                        <input type="text" name="name" placeholder="Enter your Organization / Company Name"
                            value="<?php echo htmlspecialchars($savedData['name'] ?? ''); ?>" required>
                    </div>
                    <!-- <div class="form-group">
                        <label>Business Registration Number *</label>
                         <input type="text" name="regnumber" placeholder="Business Registration Number"
                            value="<?php echo htmlspecialchars($savedData['regnumber'] ?? ''); ?>" required>
                    </div> -->
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Organization / Company Email Address *</label>
                        <input type="email" name="email" placeholder="your.email@example.com"
                            value="<?php echo htmlspecialchars($savedData['email'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Official contact Number *</label>

                        <input type="tel" name="phone" placeholder="+94 XX XXXX XXXX"
                            value="<?php echo htmlspecialchars($savedData['phone'] ?? ''); ?>" maxlength="10" required>
                    </div>
                </div>


                <div class="form-row">
                    <!-- <div class="form-group">
                        <label>Year Established</label>
                        
                        <input type="number" min="1800" max="2026" name="year"
                            value="<?php echo htmlspecialchars($savedData['year'] ?? ''); ?>">
                    </div> -->
                    <div class="form-group">
                        <label>Official Website (Website link)</label>
                        
                        <input type="url" name="link" placeholder="https://www.example.com"
                            value="<?php echo htmlspecialchars($savedData['link'] ?? ''); ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="organization_description">About the Organization / Company</label>
                        <textarea id="organization_description" name="description" rows="4"
                            placeholder="Write a brief description about your company or organization..."
                            maxlength="500"><?php echo htmlspecialchars($savedData['description'] ?? ''); ?></textarea>


                    </div>
                    <div class="form-group">
                        <label for="organization_type">Organization Type</label>
                        <select name="organization_type" id="organization_type" required>
                            <!-- <option value="" selected disabled >Select Type</option>
                            <option value="company">Company</option>
                            <option value="ngo">NGO</option>
                            <option value="foundation">Foundation</option>
                            <option value="foundation">Community</option>
                            <option value="SocialClub">Social Club</option> -->


                            <option value="" selected disabled <?php echo empty($savedData['organization_type']) ? 'selected' : ''; ?>>Select Type</option>
                            <option value="company" <?php echo (isset($savedData['organization_type']) && $savedData['organization_type'] === 'company') ? 'selected' : ''; ?>>Company</option>
                            <option value="ngo" <?php echo (isset($savedData['organization_type']) && $savedData['organization_type'] === 'ngo') ? 'selected' : ''; ?>>NGO</option>
                            <option value="foundation" <?php echo (isset($savedData['organization_type']) && $savedData['organization_type'] === 'foundation') ? 'selected' : ''; ?>>Foundation</option>
                            <option value="community" <?php echo (isset($savedData['organization_type']) && $savedData['organization_type'] === 'community') ? 'selected' : ''; ?>>Community</option>
                            <option value="SocialClub" <?php echo (isset($savedData['organization_type']) && $savedData['organization_type'] === 'SocialClub') ? 'selected' : ''; ?>>Social Club</option>
                            <option value="SocialClub" <?php echo (isset($savedData['organization_type']) && $savedData['organization_type'] === 'other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                </div>




                <div class="form-footer">
                    <!-- <button type="button" class="btn-next" onclick="window.location.href='/V/View/registration/reg2.php'">Next Step →</button> -->
                    <button type="submit" class="btn-next">Next Step →</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>