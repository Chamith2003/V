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
      <!-- <div class="steps">
        <div class="circle active">1</div>
        <div class="line active"></div>
        <div class="circle active">2</div>
        <div class="line active"></div>
        <div class="circle active">3</div>
        <div class="line active"></div>
        <div class="circle active">4</div>
      </div> -->
      <?php if ($role == 'volunteer'): ?>
        <div class="steps">
          <div class="circle">1</div>
          <div class="line"></div>
          <div class="circle">2</div>
          <div class="line"></div>
          <div class="circle">3</div>
          <div class="line"></div>
          <div class="circle active">4</div>
        </div>
      <?php endif; ?>
    </div>

    <!-- Form Card -->
    <div class="form-card">
      <div class="form-header">
        <h3><?php echo $role == 'volunteer' ? 'Skills and Interests' : 'Final Details'; ?></h3>
        <!-- <h3>Skills and Interests</h3> -->
        <span class="step-text">Step 4 of 4</span>
      </div>
      <!-- <p class="sub-text">What are you good at?</p> -->

      <p class="sub-text"><?php echo $role == 'volunteer' ? 'What are you good at?' : 'Complete your registration'; ?>
      </p>

      <form method="POST" action="/V/router.php?module=registration&action=registration_step4" id="registrationForm">


        <div class="form-content">
          <?php if ($role == 'volunteer'): ?>
            <div class="form-group">
              <label>Volunteer Experience</label>
              <textarea name="volunteer_experience"
                placeholder="Tell us about any previous volunteer work you have done."></textarea>
              <!-- <textarea placeholder="Tell us about any previous volunteer work you have done."></textarea> -->
            </div>

            <!-- Step 4: Preferred Locations & Final Confirmation -->
            <!-- <div class="form-page hidden" id="page-4">
              <div class="form-header">
                <h3>Final Details</h3>
                <span class="step-text">Step 4 of 4</span>
              </div>
              <p class="sub-text">Just a few more things before you're done!</p>
              <div class="form-content">
                <div class="form-group">
                  <label>Preferred Locations</label>
                  <div class="locations-container">
                    <div class="form-group">
                      <label>1st Choice</label>
                      <select>
                        <option value="">Select</option>
                        <option value="location1">Location A</option>
                        <option value="location2">Location B</option>
                        <option value="location3">Location C</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>2nd Choice</label>
                      <select>
                        <option value="">Select</option>
                        <option value="location1">Location A</option>
                        <option value="location2">Location B</option>
                        <option value="location3">Location C</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>3rd Choice</label>
                      <select>
                        <option value="">Select</option>
                        <option value="location1">Location A</option>
                        <option value="location2">Location B</option>
                        <option value="location3">Location C</option>
                      </select>
                    </div>
                  </div>
                </div>
              <1?php endif; ?> -->


            <div class="form-group">
              <label>Preferred Locations</label>
              <div class="locations-container">
                <div class="form-group">
                  <label>1st Choice</label>
                  <select name="preferred_location_1" id="location1" required>
                    <option value=""disabled selected>Select</option>
                    <option value="Colombo">Colombo</option>
                    <option value="Gampaha">Gampaha</option>
                    <option value="Kalutara">Kalutara</option>

                    <option value="Kandy">Kandy</option>
                    <option value="Matale">Matale</option>
                    <option value="Nuwara Eliya">Nuwara Eliya</option>

                    <option value="Galle">Galle</option>
                    <option value="Matara">Matara</option>
                    <option value="Hambantota">Hambantota</option>

                    <option value="Jaffna">Jaffna</option>
                    <option value="Kilinochchi">Kilinochchi</option>
                    <option value="Mannar">Mannar</option>
                    <option value="Mullaitivu">Mullaitivu</option>
                    <option value="Vavuniya">Vavuniya</option>

                    <option value="Trincomalee">Trincomalee</option>
                    <option value="Batticaloa">Batticaloa</option>
                    <option value="Ampara">Ampara</option>

                    <option value="Anuradhapura">Anuradhapura</option>
                    <option value="Polonnaruwa">Polonnaruwa</option>

                    <option value="Kurunegala">Kurunegala</option>
                    <option value="Puttalam">Puttalam</option>

                    <option value="Ratnapura">Ratnapura</option>
                    <option value="Kegalle">Kegalle</option>

                    <option value="Badulla">Badulla</option>
                    <option value="Monaragala">Monaragala</option>

                  </select>
                </div>
                <div class="form-group">
                  <label>2nd Choice</label>
                  <select name="preferred_location_2" id="location2" required>
                    <option value=""disabled selected>Select</option>
                    <option value="Colombo">Colombo</option>
                    <option value="Gampaha">Gampaha</option>
                    <option value="Kalutara">Kalutara</option>

                    <option value="Kandy">Kandy</option>
                    <option value="Matale">Matale</option>
                    <option value="Nuwara Eliya">Nuwara Eliya</option>

                    <option value="Galle">Galle</option>
                    <option value="Matara">Matara</option>
                    <option value="Hambantota">Hambantota</option>

                    <option value="Jaffna">Jaffna</option>
                    <option value="Kilinochchi">Kilinochchi</option>
                    <option value="Mannar">Mannar</option>
                    <option value="Mullaitivu">Mullaitivu</option>
                    <option value="Vavuniya">Vavuniya</option>

                    <option value="Trincomalee">Trincomalee</option>
                    <option value="Batticaloa">Batticaloa</option>
                    <option value="Ampara">Ampara</option>

                    <option value="Anuradhapura">Anuradhapura</option>
                    <option value="Polonnaruwa">Polonnaruwa</option>

                    <option value="Kurunegala">Kurunegala</option>
                    <option value="Puttalam">Puttalam</option>

                    <option value="Ratnapura">Ratnapura</option>
                    <option value="Kegalle">Kegalle</option>

                    <option value="Badulla">Badulla</option>
                    <option value="Monaragala">Monaragala</option>

                  </select>
                </div>
                <div class="form-group">
                  <label>3rd Choice</label>
                  <select name="preferred_location_3" id="location3" required>
                   <option value=""disabled selected>Select</option>
                    <option value="Colombo">Colombo</option>
                    <option value="Gampaha">Gampaha</option>
                    <option value="Kalutara">Kalutara</option>

                    <option value="Kandy">Kandy</option>
                    <option value="Matale">Matale</option>
                    <option value="Nuwara Eliya">Nuwara Eliya</option>

                    <option value="Galle">Galle</option>
                    <option value="Matara">Matara</option>
                    <option value="Hambantota">Hambantota</option>

                    <option value="Jaffna">Jaffna</option>
                    <option value="Kilinochchi">Kilinochchi</option>
                    <option value="Mannar">Mannar</option>
                    <option value="Mullaitivu">Mullaitivu</option>
                    <option value="Vavuniya">Vavuniya</option>

                    <option value="Trincomalee">Trincomalee</option>
                    <option value="Batticaloa">Batticaloa</option>
                    <option value="Ampara">Ampara</option>

                    <option value="Anuradhapura">Anuradhapura</option>
                    <option value="Polonnaruwa">Polonnaruwa</option>

                    <option value="Kurunegala">Kurunegala</option>
                    <option value="Puttalam">Puttalam</option>

                    <option value="Ratnapura">Ratnapura</option>
                    <option value="Kegalle">Kegalle</option>

                    <option value="Badulla">Badulla</option>
                    <option value="Monaragala">Monaragala</option>

                  </select>
                </div>
              </div>
            </div>
          <?php endif; ?>




          <label class="terms-checkbox">
            <!-- <input type="checkbox"> -->
            <input type="checkbox" required>

            I confirm the information provided is accurate.
          </label>
        </div>
        <!-- </div> -->

        <div class="form-footer">
          <?php if ($role == 'volunteer'): ?>
            <button type="button" class="btn-previous"
              onclick="window.location.href='/V/router.php?module=registration&action=registration_step3'">
              ← Previous
            </button>
          <?php else: ?>
            <button type="button" class="btn-previous"
              onclick="window.location.href='/V/router.php?module=registration&action=registration_step2'">
              ← Previous
            </button>
          <?php endif; ?>
          <button type="submit" class="btn-next">Create Your Account</button>



          <!-- <button type="button" class="btn-next"
              onclick="window.location.href='/V/View/registration/successmsg.php'">Create your account</button> -->
        </div>
      </form>
    </div>
  </div>
  <!-- </div> -->
   <script src="View/registration/registration.js"></script>
</body>

</html>