<?php
//get user session data(set by router.php)
$userid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$usertype = isset($_SESSION['role']) ? $_SESSION['role'] : null;

//determine if the user is sponsor or volunteer based on user type
$sponsorid = ($usertype === 'sponsor') ? $userid : null;
$volunteer_id = ($usertype === 'volunteer') ? $userid : null;

$userName = '';
$userEmail = '';
$userPhone = '';

if ($userid && $usertype) {
    $userDetails = $donationcontroller->getUserDetailsForDonation($userid, $usertype);
    
    if ($userDetails) {
        $userName = htmlspecialchars($userDetails['name']);
        $userEmail = htmlspecialchars($userDetails['email']);
        $userPhone = htmlspecialchars($userDetails['contactnumber']);
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>V</title>
        <link rel="stylesheet" type="text/css" href="/V/View/donations/makedonation.css">
    <?php include __DIR__ . '/../navbar/navbar.php'; ?>

</head>
<body>
    <div class="mainContent">
        <div class="header">
            <h1>Make a Donation</h1>
        </div>

        <div class="payment-gateway-container">
            <div class="payment-gateway-card">
                <!-- Form Header -->
                <div class="gateway-header">
                    <h2>Donation Information</h2>
                </div>
                
                <!-- Donation Form -->
                <form method="POST" action="/V/router.php?module=donation&action=initiatepayment" id="donationForm">
            
                <!-- Hidden fields for payment processing -->
                    <input type="hidden" name="merchant_id" value="1232952">
                    <input type="hidden" name="amount" id="amount_hidden" value="">
                    
                    <!-- Custom fields to pass user data -->
                    <input type="hidden" name="custom_1" value="<?php echo $sponsorid; ?>">
                    <input type="hidden" name="custom_2" value="<?php echo $volunteer_id; ?>">


                    <div class="payment-form-grid">
                        <!-- left Column - Donor information newly added-->
                        <div class="form-column">
                            <h3>Donor Information</h3>
                            <div class="form-group">
                                <label for="first_name">Name<span class="required">*</span></label>
                                <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Name" value="<?php echo $userName; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email<span class="required">*</span></label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?php echo $userEmail; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number<span class="required">*</span></label>
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone" value="<?php echo $userPhone; ?>" required maxlength="10">
                            </div>
                            <div class="form-group">
                                <label for="address">Address<span class="required">*</span></label>
                                <input type="text" id="address" name="address" class="form-control" placeholder="Address" required>
                            </div>
                            <div class="form-group">
                                <label for="city">City<span class="required">*</span></label>
                                <input type="text" id="city" name="city" class="form-control" placeholder="City" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="country">Country<span class="required">*</span></label>
                                <input type="text" id="country" name="country" class="form-control" value="Sri Lanka" required>
                            </div>
                            
                            <!--newly added codes-->
                        </div>

                        <!-- right Column - Payment details -->
                        <div class="form-column">
                            <h3>Payment Information</h3>
                            <div class="form-group">
                                <label for="donation_amount">Amount <span class="required">*</span> </label>
                                <div class="amount-options">
                                    <div class="preset-amounts">
                                        <button type="button" class="amount-btn" data-amount="100">LKR.100</button>
                                        <button type="button" class="amount-btn" data-amount="500">LKR.500</button>
                                        <button type="button" class="amount-btn" data-amount="1000">LKR.1000</button>
                                        <button type="button" class="amount-btn" data-amount="5000">LKR.5000</button>
                                        <button type="button" class="amount-btn" data-amount="10000">LKR.10,000</button>
                                        <button type="button" class="amount-btn" data-amount="other">Other</button>
                                    </div>
                                    <div class="currency-input">
                                        <input type="number" id="donation_amount" name="amount" class="form-control" placeholder="Enter custom amount" min="1" step="0.01" required>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Available Payment Methods</label>
                                <div class="payment-methods">
                                    <div class="payment-method-card" data-method="mastercard">
                                        <img src="/V/View/resources/mastercard.png" alt="Mastercard">
                                    </div>
                                    <div class="payment-method-card" data-method="visa">
                                        <img src="/V/View/resources/visa.png" alt="Visa">
                                    </div>
                                    <!--<div class="payment-method-card" data-method="amex">
                                        <img src="/V/View/resources/americanexpress.svg" alt="American Express">
                                    </div>
                                    <div class="payment-method-card" data-method="genie">
                                        <img src="/V/View/resources/genie.png" alt="Genie">
                                    </div>
                                    <div class="payment-method-card" data-method="frimi">
                                        <img src="/V/View/resources/frimi.png" alt="Frimi">
                                    </div>
                                    <div class="payment-method-card" data-method="ipay">
                                        <img src="/V/View/resources/ipay.png" alt="iPay">
                                    </div>
                                    <div class="payment-method-card" data-method="qplus">
                                        <img src="/V/View/resources/qplus.jfif" alt="Q+">
                                    </div>
                                    <div class="payment-method-card" data-method="vishwa">
                                        <img src="/V/View/resources/vishwa.png" alt="Vishwa">                                        
                                    </div>
                                    -->
                                </div>
                            </div>
                            <!-- Continue to Payment Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-process-payment">
                                    Process Payment
                                </button>
                            </div>    
                        </div>           
                    </div>
                </form>
            </div>
        </div>
    </div>

      <script src="/V/View/donations/makedonation.js"></script> 
</body>
</html>