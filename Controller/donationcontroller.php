<?php

class donationcontroller 
{
    private $donationmodel;
    private $merchant_secret = 'MjE0MTg4NzM5MjI3MTM3MzAwMDkxMzAyODgxMzg3MjQ3MzM0NzMwMg=='; // PayHere merchant secret

    public function __construct($donationmodel) {
        $this->donationmodel = $donationmodel;
    }


    //gets user details from database to autofill the name,email and contact number
    public function getUserDetailsForDonation($userid, $usertype) 
    {
        try 
        {
            return $this->donationmodel->getUserDetails($userid, $usertype);
        } 
        catch (Exception $e) 
        {
            error_log("Error fetching user details: " . $e->getMessage());
            return null;
        }
    }

    //prepare payhere payment data 
    public function preparePayHerePayment($formData)
    {
        $merchant_id = $formData['merchant_id'];
        $order_id = $formData['order_id'];
        $amount = number_format($formData['amount'], 2, '.', '');
        $currency = "LKR";

        $hashedSecret = strtoupper(md5($this->merchant_secret));
        $hash = strtoupper(
            md5(
                $merchant_id . 
                $order_id . 
                $amount . 
                $currency . 
                $hashedSecret
            )  
        );

        $base_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
        
        $paymentData = [
            'merchant_id' => $merchant_id,
            'order_id' => $order_id,
            'amount' => $amount,
            'currency' => $currency,
            'hash' => $hash,
            'items' => 'Donation',
            'first_name' => $formData['first_name'],
            'last_name' => 'Donor',
            'email' => $formData['email'],
            'phone' => $formData['phone'],
            'address' => $formData['address'],
            'city' => $formData['city'],
            'country' => $formData['country'] ?? 'Sri Lanka',
            'return_url' => $base_url . '/V/router.php?module=donation&action=successfuldonation&order_id=' . $order_id,
            'cancel_url' => $base_url . '/V/router.php?module=donation&action=senddonation',
            'notify_url' => $base_url . '/V/router.php?module=donation&action=payherenotify',
            'custom_1' => $formData['custom_1'] ?? null,
            'custom_2' => $formData['custom_2'] ?? null
        ];
        
        return $paymentData;
    }

    public function handleDonationPayment($payhere_data)
    {
        // Verify hash before processing
        $merchant_id = $payhere_data['merchant_id'];
        $order_id = $payhere_data['order_id'];
        $amount = $payhere_data['payhere_amount'];
        $currency = $payhere_data['payhere_currency'];
        $status_code = $payhere_data['status_code'];
        $md5sig = $payhere_data['md5sig'];

        $merchant_secret = 'MjE0MTg4NzM5MjI3MTM3MzAwMDkxMzAyODgxMzg3MjQ3MzM0NzMwMg==';
        
        $local_md5sig = strtoupper(
            md5(
                $merchant_id . 
                $order_id . 
                $amount . 
                $currency .
                $status_code .
                strtoupper(md5($merchant_secret))
            )
        );

        // Verify hash and payment status
        if ($local_md5sig === $md5sig && $status_code == 2) {
            try {
                // Payment successful - update transaction_id
                $transaction_id = $payhere_data['payment_id'];
                
                $result = $this->donationmodel->updateDonationTransactionId($order_id, $transaction_id);
                
                if ($result) {
                    return ['success' => true, 'message' => 'Donation updated successfully'];
                }
                return ['success' => false, 'message' => 'Failed to update donation'];
            } catch (Exception $e) {
                return ['success' => false, 'message' => 'Exception: ' . $e->getMessage()];
            }
        }

        return ['success' => false, 'message' => 'Payment verification failed'];
    }

    private function sanitizeUserId($value) 
    {
        if (empty($value) || $value === 'null' || $value === '') 
        {
            return null;
        }
        return intval($value);
    }

    //get donation details for success page to load
    public function getDonationDetails($order_id)
    {
        $donationData = [
            'transaction_id' => 'N/A',
            'transaction_date' => date('F j, Y \a\t h:i A'),
            'amount' => '0.00',
        ];

        if(!$order_id)
            {
                return $donationData;
            }
        try 
        {
            $donation = $this->donationmodel->getDonationByOrderId($order_id);

            if($donation)
            {
                $donationData['transaction_id'] = $donation['transaction_id'] ?? $order_id;
                $donationData['transaction_date'] = $donation['transaction_date']
                ? date('F j, Y \a\t h:i A', strtotime($donation['transaction_date'])) 
                : date('F j, Y \a\t h:i A');
                $donationData['amount'] = number_format($donation['receivedamount'],2);
            }
        }
        catch(Exception $e)
        {
            error_log("Error fetching donation details: ".$e->getMessage());

        }
        return $donationData;
    }

    public function savePendingDonation($data)
    {
        try
        {
            $donationData = [
                'order_id' => $data['order_id'],
                'receivedamount' => $data['receivedamount'],
                'sponsorid' => $data['sponsorid'],
                'volunteer_id' => $data['volunteer_id'],
                'status' => 'pending',
                'event_id' => NULL
            ];

            error_log("Saving pending donation: " . json_encode($donationData));
            $result = $this->donationmodel->createDonation($donationData);
            error_log("Donation creation result: " . ($result ? $result : 'false'));
            
            return $result;

        }
        catch(Exception $e)
        {
            error_log("Error saving donation: ".$e->getMessage());
            return false;

        }
    }

    public function markDonationAsCompleted($order_id, $transaction_id = null)
    {
        try 
        {
            if ($transaction_id) {
                return $this->donationmodel->updateDonationTransactionId($order_id, $transaction_id);
            }
            return true;

        }
        catch(Exception $e)
        {
            error_log("Error updating donation transaction_id: " . $e->getMessage());
            return false;

        }
    }

    public function initiatePayment()
    {
        // Get user details
        $userid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $usertype = isset($_SESSION['role']) ? $_SESSION['role'] : null;

        $sponsorid = ($usertype === 'sponsor') ? $userid : null;
        $volunteer_id = ($usertype === 'volunteer') ? $userid : null;

        $userName = '';
        $userEmail = '';
        $userPhone = '';
        $userAddress = '';
        $userCity = '';
        $userCountry = 'Sri Lanka';

        if ($userid && $usertype) {
            $userDetails = $this->getUserDetailsForDonation($userid, $usertype);
            
            if ($userDetails) {
                $userName = htmlspecialchars($userDetails['name']);
                $userEmail = htmlspecialchars($userDetails['email']);
                $userPhone = htmlspecialchars($userDetails['contactnumber']);
            }
        }

        // Get donation data from POST
        $amount = $_POST['amount'] ?? 0;
        $address = $_POST['address'] ?? '';
        $city = $_POST['city'] ?? '';
        $country = $_POST['country'] ?? 'Sri Lanka';

        // Validate data
        if ($amount <= 0) {
            header('Location: /V/router.php?module=donation&action=senddonation');
            exit();
        }

        // Generate unique order ID
        $order_id = 'DON-' . time() . '-' . rand(1000, 9999);

        // Save pending donation
        $pendingDonationData = [
            'order_id' => $order_id,
            'receivedamount' => floatval($amount),
            'sponsorid' => $sponsorid,
            'volunteer_id' => $volunteer_id
        ];
        $this->savePendingDonation($pendingDonationData);

        // PayHere Configuration
        $merchant_id = '1232952';
        $merchant_secret = 'MjE0MTg4NzM5MjI3MTM3MzAwMDkxMzAyODgxMzg3MjQ3MzM0NzMwMg==';

        $formatted_amount = number_format($amount, 2, '.', '');

        // Generate hash for security
        $hash = strtoupper(
            md5(
                $merchant_id . 
                $order_id . 
                $formatted_amount . 
                'LKR' . 
                strtoupper(md5($merchant_secret))
            )
        );

        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

        // Prepare payment data
        $paymentData = [
            'merchant_id' => $merchant_id,
            'return_url' => $scheme . '://' . $_SERVER['HTTP_HOST'] . '/V/router.php?module=donation&action=successfuldonation&order_id=' . $order_id,
            'cancel_url' => $scheme . '://' . $_SERVER['HTTP_HOST'] . '/V/router.php?module=donation&action=senddonation',
            'notify_url' => 'https://6677-2402-d000-8114-1046-4486-2c3-d678-7b38.ngrok-free.app/V/router.php?module=donation&action=payherenotify',
            'order_id' => $order_id,
            'items' => 'Donation',
            'currency' => 'LKR',
            'amount' => number_format($amount, 2, '.', ''),
    
            'first_name' => $userName,
            'last_name' => 'Donor',
            'email' => $userEmail,
            'phone' => $userPhone,
            'address' => $address,
            'city' => $city,
            'country' => $country,
    
            'hash' => $hash,
    
            // Custom fields to pass data to notify URL
            'custom_1' => $sponsorid,
            'custom_2' => $volunteer_id,
        ];
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Processing...</title>
        </head>
        <body>
            <form method="post" id="payhere_form" action="https://sandbox.payhere.lk/pay/checkout">
                <input type="hidden" name="merchant_id" value="<?php echo $paymentData['merchant_id']; ?>">
                <input type="hidden" name="return_url" value="<?php echo $paymentData['return_url']; ?>">
                <input type="hidden" name="cancel_url" value="<?php echo $paymentData['cancel_url']; ?>">
                <input type="hidden" name="notify_url" value="<?php echo $paymentData['notify_url']; ?>">
                <input type="hidden" name="order_id" value="<?php echo $paymentData['order_id']; ?>">
                <input type="hidden" name="items" value="<?php echo $paymentData['items']; ?>">
                <input type="hidden" name="currency" value="<?php echo $paymentData['currency']; ?>">
                <input type="hidden" name="amount" value="<?php echo $paymentData['amount']; ?>">
                <input type="hidden" name="first_name" value="<?php echo $paymentData['first_name']; ?>">
                <input type="hidden" name="last_name" value="<?php echo $paymentData['last_name']; ?>">
                <input type="hidden" name="email" value="<?php echo $paymentData['email']; ?>">
                <input type="hidden" name="phone" value="<?php echo $paymentData['phone']; ?>">
                <input type="hidden" name="address" value="<?php echo $paymentData['address']; ?>">
                <input type="hidden" name="city" value="<?php echo $paymentData['city']; ?>">
                <input type="hidden" name="country" value="<?php echo $paymentData['country']; ?>">
                <input type="hidden" name="hash" value="<?php echo $paymentData['hash']; ?>">
                <input type="hidden" name="custom_1" value="<?php echo $paymentData['custom_1']; ?>">
                <input type="hidden" name="custom_2" value="<?php echo $paymentData['custom_2']; ?>">
            </form>
            <script>document.getElementById('payhere_form').submit();</script>
        </body>
        </html>
        <?php
        exit();
    }

    public function initiateSponsorshipPayment()
    {
        // Get user details
        $userid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $usertype = isset($_SESSION['role']) ? $_SESSION['role'] : null;

        $sponsorid = ($usertype === 'sponsor') ? $userid : null;
        
        $userName = '';
        $userEmail = '';
        $userPhone = '';
        $userAddress = '';
        $userCity = '';
        $userCountry = 'Sri Lanka';

        if ($userid && $usertype) {
            $userDetails = $this->getUserDetailsForDonation($userid, $usertype);
            
            if ($userDetails) {
                $userName = htmlspecialchars($userDetails['name']);
                $userEmail = htmlspecialchars($userDetails['email']);
                $userPhone = htmlspecialchars($userDetails['contactnumber']);
            }
        }

        // Get sponsorship data from POST
        $amount = $_POST['amount'] ?? 0;
        $address = $_POST['address'] ?? '';
        $city = $_POST['city'] ?? '';
        $country = $_POST['country'] ?? 'Sri Lanka';
        $event_id = $_POST['event_id'] ?? null;

        // Validate data
        if ($amount <= 0 || empty($event_id)) {
            header('Location: /V/router.php?module=sponsorship&action=sendsponsorship');
            exit();
        }

        // Generate unique order ID
        $order_id = 'SPONSOR-' . time() . '-' . rand(1000, 9999);

        // Save pending sponsorship commitment
        $pendingCommitment = [
            'sponsor_id' => $sponsorid,
            'event_id' => $event_id,
            'order_id' => $order_id,
            'commitment_amount' => floatval($amount),
            'status' => 'not accepted'
        ];
        $pendingDonation=[
                'order_id' => $order_id,
                'receivedamount' => floatval($amount),
                'sponsorid' =>$sponsorid ,
                'status' => 'pending',
                'event_id' => $event_id
        ];
        $this->donationmodel->createSponsorshipCommitment($pendingCommitment);
        $this->donationmodel->createDonation( $pendingDonation);

        // PayHere Configuration
        $merchant_id = '1232952';
        $merchant_secret = 'MjE0MTg4NzM5MjI3MTM3MzAwMDkxMzAyODgxMzg3MjQ3MzM0NzMwMg==';

        $formatted_amount = number_format($amount, 2, '.', '');

        // Generate hash for security
        $hash = strtoupper(
            md5(
                $merchant_id . 
                $order_id . 
                $formatted_amount . 
                'LKR' . 
                strtoupper(md5($merchant_secret))
            )
        );

        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

        // Prepare payment data
        $paymentData = [
            'merchant_id' => $merchant_id,
            'return_url' => $scheme . '://' . $_SERVER['HTTP_HOST'] . '/V/router.php?module=sponsorship&action=sponsorsuccess&order_id=' . $order_id,
            'cancel_url' => $scheme . '://' . $_SERVER['HTTP_HOST'] . '/V/router.php?module=sponsorship&action=sendsponsorship',
            'notify_url' => 'https://6677-2402-d000-8114-1046-4486-2c3-d678-7b38.ngrok-free.app/V/router.php?module=sponsorship&action=payherenotify',
            'order_id' => $order_id,
            'items' => 'Sponsorship - Event #' . $event_id,
            'currency' => 'LKR',
            'amount' => number_format($amount, 2, '.', ''),
    
            'first_name' => $userName,
            'last_name' => 'Sponsor',
            'email' => $userEmail,
            'phone' => $userPhone,
            'address' => $address,
            'city' => $city,
            'country' => $country,
    
            'hash' => $hash,
    
            // Custom fields to pass data to notify URL
            'custom_1' => $sponsorid,
            'custom_2' => $event_id,
        ];
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Processing...</title>
        </head>
        <body>
            <form method="post" id="payhere_form" action="https://sandbox.payhere.lk/pay/checkout">
                <input type="hidden" name="merchant_id" value="<?php echo $paymentData['merchant_id']; ?>">
                <input type="hidden" name="return_url" value="<?php echo $paymentData['return_url']; ?>">
                <input type="hidden" name="cancel_url" value="<?php echo $paymentData['cancel_url']; ?>">
                <input type="hidden" name="notify_url" value="<?php echo $paymentData['notify_url']; ?>">
                <input type="hidden" name="order_id" value="<?php echo $paymentData['order_id']; ?>">
                <input type="hidden" name="items" value="<?php echo $paymentData['items']; ?>">
                <input type="hidden" name="currency" value="<?php echo $paymentData['currency']; ?>">
                <input type="hidden" name="amount" value="<?php echo $paymentData['amount']; ?>">
                <input type="hidden" name="first_name" value="<?php echo $paymentData['first_name']; ?>">
                <input type="hidden" name="last_name" value="<?php echo $paymentData['last_name']; ?>">
                <input type="hidden" name="email" value="<?php echo $paymentData['email']; ?>">
                <input type="hidden" name="phone" value="<?php echo $paymentData['phone']; ?>">
                <input type="hidden" name="address" value="<?php echo $paymentData['address']; ?>">
                <input type="hidden" name="city" value="<?php echo $paymentData['city']; ?>">
                <input type="hidden" name="country" value="<?php echo $paymentData['country']; ?>">
                <input type="hidden" name="hash" value="<?php echo $paymentData['hash']; ?>">
                <input type="hidden" name="custom_1" value="<?php echo $paymentData['custom_1']; ?>">
                <input type="hidden" name="custom_2" value="<?php echo $paymentData['custom_2']; ?>">
            </form>
            <script>document.getElementById('payhere_form').submit();</script>
        </body>
        </html>
        <?php
        exit();
    }

    public function handleSponsorshipPayment($payhere_data)
    {
        // PayHere data
        $merchant_id = $payhere_data['merchant_id'];
        $order_id = $payhere_data['order_id'];
        $payment_id = $payhere_data['payment_id'];
        $status_code = $payhere_data['status_code'];
        $md5sig = $payhere_data['md5sig'];
        $amount = $payhere_data['payhere_amount'];
        $currency = $payhere_data['payhere_currency'];
        $sponsor_id = $payhere_data['custom_1'];
        $event_id = $payhere_data['custom_2'];

        // Verify hash for security
        $merchant_secret = 'MjE0MTg4NzM5MjI3MTM3MzAwMDkxMzAyODgxMzg3MjQ3MzM0NzMwMg==';
        $local_md5sig = strtoupper(
            md5(
                $merchant_id . 
                $order_id . 
                $amount . 
                $currency . 
                $status_code .
                strtoupper(md5($merchant_secret))
            )
        );
        

        // Check if payment is successful and hash is valid
        if ($local_md5sig === $md5sig && $status_code == 2) {
            try {
                // Update existing sponsorship commitment
                $this->donationmodel->updateSponsorshipTransactionId($order_id, $payment_id);
                $this->donationmodel->updateDonationTransactionId($order_id, $payment_id);
                
                // Return 200 OK to PayHere
                return true;
            } catch (Exception $e) {
                error_log("Error handling sponsorship payment: " . $e->getMessage());
                return false;
            }
        }

        return false;
    }

    public function getSponsorshipDetails($order_id)
    {
        $sponsorshipData = [
            'transaction_id' => 'N/A',
            'transaction_date' => date('F j, Y \a\t h:i A'),
            'amount' => '0.00',
            'event_id' => 'N/A'
        ];

        if (!$order_id) return $sponsorshipData;

        try {
            $sponsorship = $this->donationmodel->getSponsorshipByOrderId($order_id);
            if ($sponsorship) {
                $sponsorshipData['transaction_id'] = $sponsorship['transaction_id'] ?? $order_id;
                $sponsorshipData['transaction_date'] = $sponsorship['commitment_date']
                    ? date('F j, Y \a\t h:i A', strtotime($sponsorship['commitment_date'])) 
                    : date('F j, Y \a\t h:i A');
                $sponsorshipData['amount'] = number_format($sponsorship['commitment_amount'], 2);
                $sponsorshipData['event_id'] = $sponsorship['event_id'];
            }
        } catch (Exception $e) {
            error_log("Error fetching sponsorship details: " . $e->getMessage());
        }
        return $sponsorshipData;
    }
}
