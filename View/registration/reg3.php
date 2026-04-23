<?php
// Get saved availability data
$savedAvailability = $_SESSION['registration_step3']['availability'] ?? [];
$role = $_SESSION['registration_role'] ?? 'volunteer';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>V</title>
  <!-- <link rel="stylesheet" href="registration.css" /> -->
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
          <div class="circle">2</div>
          <!-- <div class="line"></div>
        <div class="circle active">3</div> -->
          <!-- <div class="line"></div>
        <div class="circle">4</div> -->
        </div>

      <?php endif; ?>
      <!-- <div class="steps">
        <div class="circle active">1</div>
        <div class="line active"></div>
        <div class="circle active">2</div>
        <div class="line active"></div>
        <div class="circle active">3</div>
        <div class="line"></div>
        <div class="circle">4</div>
      </div> -->
      <?php if ($role == 'volunteer'): ?>
        <div class="steps">
          <div class="circle">1</div>
          <div class="line"></div>
          <div class="circle">2</div>
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
        <h3>Availability</h3>
        <span class="step-text">Step 3 of 4</span>
      </div>
      <p class="sub-text">Let us know when you're available to volunteer</p>

      <!-- <form> -->
      <form method="POST" action="/V/router.php?module=registration&action=registration_step3">
        <div class="form-row-t">

          <label>Available Dates & Times</label>
          <div class='table'>
            <!-- <table class="availability-table">
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
                <tr>
                  <td>Morning</td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                </tr>
                <tr>
                  <td>Afternoon</td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                </tr>
                <tr>
                  <td>Evening</td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                  <td><input type="checkbox" /></td>
                </tr>
              </tbody>
            </table> -->

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
                    <td><?php echo $time; ?>
                      <br>
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
                        <input type="checkbox" name="<?php echo $day . '_' . $time; ?>" <?php echo $checked; ?> />
                      </td>
                    <?php endforeach; ?>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>



          </div>
        </div>
        <div class="form-footer">
          <!-- <button type="button" class="btn-previous"onclick="window.location.href='/V/View/registration/reg2.php'">← Previous</button>
          <button type="button" class="btn-next" onclick="window.location.href='/V/View/registration/reg4.php'">Next Step →</button> -->
          <button type="button" class="btn-previous"
            onclick="window.location.href='/V/router.php?module=registration&action=registration_step2'">
            ← Previous
          </button>
          <button type="submit" class="btn-next">Next Step →</button>

        </div>
      </form>
    </div>
  </div>
</body>

</html>