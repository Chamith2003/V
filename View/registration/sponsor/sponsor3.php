<?php
// Display error if exists
$error = $_SESSION['error'] ?? '';
if ($error) {
    echo "<script>alert('{$error}');</script>";
    unset($_SESSION['error']);
}

// Get saved data if any
$savedData = $_SESSION['s_registration_step3'] ?? [];
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
                    <div class="circle">1</div>
                    <div class="line"></div>
                    <div class="circle ">2</div>
                    <div class="line"></div>
                    <div class="circle active">3</div>
                    <div class="line"></div>
                    <div class="circle">4</div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Form Card -->
        <div class="form-card">
            <div class="form-header">
                <h3>Sponsor Information</h3>
                <span class="step-text">Step 3 of 4</span>
            </div>
            <p class="sub-text">Tell us Contact Person Details</p>

            <!-- <form> -->
            <form method="POST" action="/V/router.php?module=registration&action=s_registration_step3">
                <div class="form-row">
                    <div class="form-group">
                        <label>Contact Person Full Name *</label>
                        <input type="text" name="cpersonname" placeholder="Enter Contact Person Full Name"
                            value="<?php echo htmlspecialchars($savedData['cpersonname'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Designation / Role *</label>
                        <input type="text" name="role" placeholder="Enter role"
                            value="<?php echo htmlspecialchars($savedData['role'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>His/Her Email Address *</label>
                        <input type="email" name="cpersonemail" placeholder="example@gmail.com"
                            value="<?php echo htmlspecialchars($savedData['cpersonemail'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>His/Her Phone Number</label>
                        <!-- <input type="tel" placeholder="+94 XX XXXX XXXX"> -->
                        <input type="tel" name="cpersonphone" placeholder="+94 XX XXXX XXXX"
                            value="<?php echo htmlspecialchars($savedData['cpersonphone'] ?? ''); ?>" maxlength="10">
                    </div>
                </div>


                <div class="form-footer">
                    <button type="button" class="btn-previous"
                        onclick="window.location.href='/V/router.php?module=registration&action=s_registration_step2'">
                        ← Previous
                    </button>
                    <button type="submit" class="btn-next">Next Step →</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>