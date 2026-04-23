
<?php
// Display error if exists
$error = $_SESSION['error'] ?? '';
if ($error) {
    echo "<script>alert('{$error}');</script>";
    unset($_SESSION['error']);
}

// Get saved data if any
$savedData = $_SESSION['registration_step1'] ?? [];
$role = $_SESSION['registration_role'] ?? 'volunteer';
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
      

         
        <?php if ($role == 'volunteer'): ?>  
      <div class="steps">
        <div class="circle active">1</div>
        <div class="line"></div>
        <div class="circle">2</div>
        <div class="line"></div>
        <div class="circle">3</div>
        <div class="line"></div>
        <div class="circle">4</div>
      </div>
      <?php endif; ?>
    </div>

    <!-- Form Card -->
    <div class="form-card">
      <div class="form-header">
        <h3>Personal Information</h3>
        <span class="step-text">Step 1 of 4</span>
      </div>
      <p class="sub-text">Tell us about yourself</p>

      <!-- <form> -->
         <form method="POST" action="/V/router.php?module=registration&action=registration_step1">
        <div class="form-row">
          <div class="form-group">
            <label>First Name *</label>
            <!-- <input type="text" placeholder="Enter your first name"> -->
          <input type="text" name="first_name" placeholder="Enter your first name" 
                   value="<?php echo htmlspecialchars($savedData['first_name'] ?? ''); ?>" required>
          </div>
          <div class="form-group">
            <label>Last Name *</label>
            <!-- <input type="text" placeholder="Enter your last name"> -->
            <input type="text" name="last_name" placeholder="Enter your last name" 
                   value="<?php echo htmlspecialchars($savedData['last_name'] ?? ''); ?>" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Email Address *</label>
            <!-- <input type="email" placeholder="your.email@example.com"> -->
            <input type="email" name="email" placeholder="your.email@example.com" 
                   value="<?php echo htmlspecialchars($savedData['email'] ?? ''); ?>" required>
          </div>
          <div class="form-group">
            <label>Phone Number</label>
            <!-- <input type="tel" placeholder="+94 XX XXXX XXXX"> -->
              <input type="tel" name="phone" placeholder="+94 XX XXXX XXXX" 
                   value="<?php echo htmlspecialchars($savedData['phone'] ?? ''); ?>" maxlength="10">
          </div>
        </div>
        <?php if (isset($_SESSION['registration_role']) && $_SESSION['registration_role'] == 'volunteer'): ?>

        <div class="form-row">
          <div class="form-group">
            <label>Date of Birth</label>
            <!-- <input type="date"> -->
              <input type="date" name="dob" 
                   value="<?php echo htmlspecialchars($savedData['dob'] ?? ''); ?>" required>
          </div>
          <div class="form-group">
            <label>Gender</label>
            <div class="gender-options">
              <!-- <label><input type="radio" name="gender"> Male</label>
              <label><input type="radio" name="gender"> Female</label> -->
              <label>
                <input type="radio" name="gender" value="Male" 
                       <?php echo (($savedData['gender'] ?? '') == 'Male') ? 'checked' : ''; ?>> Male
              </label>
              <label>
                <input type="radio" name="gender" value="Female" 
                       <?php echo (($savedData['gender'] ?? '') == 'Female') ? 'checked' : ''; ?>> Female
              </label>
            </div>
          </div>
        </div>

        <div class="alert-box">
          <strong>⚠ Age Requirement</strong>
          <p>You must be 18 years or older to volunteer with us.</p>
        </div>
           <?php endif; ?>

        <div class="form-footer">
          <!-- <button type="button" class="btn-next" onclick="window.location.href='/V/View/registration/reg2.php'">Next Step →</button> -->
          <button type="submit" class="btn-next">Next Step →</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
