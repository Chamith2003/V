
<?php
// Display error if exists
$error = $_SESSION['error'] ?? '';
if ($error) {
    echo "<script>alert('{$error}');</script>";
    unset($_SESSION['error']);
}
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
        <div class="circle">1</div>
        <div class="line"></div>
        <div class="circle active">2</div>
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
        <span class="step-text">Step 2 of 4</span>
      </div>
      <!-- <p class="sub-text">Password verification </p> -->
       <p class="sub-text">Create a secure password</p>

      <!-- <form> -->
        <form method="POST" action="/V/router.php?module=registration&action=registration_step2">
        <div class="form-row">
          <div class="form-group">
            <!-- <label>Password </label> -->
              <label>Password *</label>

             <input type="password" name="password" placeholder="Enter your password" 
                   minlength="8" required>
            <small>Minimum 8 characters</small>
          
          </div>
          <div class="form-group">
            <label>Confirm password</label>
            <!-- <input type="password" placeholder="Enter your confirm password"> -->
          <input type="password" name="confirm_password" placeholder="Confirm your password" 
                   minlength="8" required>
          
          </div>
        </div>

        <div class="form-footer">
           
          <button type="button" class="btn-previous" 
                  onclick="window.location.href='/V/router.php?module=registration&action=registration_step1'">
            ← Previous
          </button>
          <button type="submit" class="btn-next">Next Step →</button>
        
        </div>
      </form>
    </div>
  </div>
</body>
</html>
