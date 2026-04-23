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

    </div>

    <!-- Form Card -->
    <div class="form-card1">
      <div class="form-header1">
        <h3>Choose Your Role</h3>

      </div>
      <p class="sub-text">Are you a Volunteer or a Sponsor? </p>

      <form method="POST" action="/V/router.php?module=registration&action=registration_role">
        <div class="form-row">
          <div class="form-group">
            <button type="submit" name="role" value="volunteer" class="btn-next">
              Register as a Volunteer
            </button>
            <!-- <button type="button" class="btn-next" onclick="window.location.href='/V/View/registration/reg1.php'">Register as a Volunteer</button> -->
          </div>
          <div class="form-group">
            <button type="submit" name="role" value="sponsor" class="btn-next">
              Register as a Sponsor
            </button>
            <!-- <button type="button" class="btn-next" onclick="window.location.href='/V/View/registration/reg1.php'">Register as a Sponsor</button> -->
          </div>
        </div>
      </form>

    </div>
  </div>
</body>

</html>