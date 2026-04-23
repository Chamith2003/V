<?php
class donationmodel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }


    //gets user name,contact number and email for donation page to autofill from database
    public function getUserDetails($userid, $usertype) {
        if ($usertype === 'sponsor') {
            $stmt = $this->conn->prepare("SELECT name, email, contactnumber FROM user WHERE userid = ?");
        } elseif ($usertype === 'volunteer') {
            $stmt = $this->conn->prepare("SELECT name, email, contactnumber FROM user WHERE userid = ?");
        } else {
            return null;
        }
    
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $userDetails = null;
        if ($row = $result->fetch_assoc()) {
            $userDetails = $row;
        }
    
        $stmt->close();
        return $userDetails;
    }
   
    //save donations details
    public function createDonation($data)
    {
        // Handle NULL values for optional fields
        $sponsorid = $data['sponsorid'] ?? null;
        $volunteer_id = $data['volunteer_id'] ?? null;
        $order_id = $data['order_id'] ?? '';
        $receivedamount = floatval($data['receivedamount']);
        $eventId = $data['event_id'];
        $status=$data['status'] ?? null;//status is pending when first creating
        
        $stmt = $this->conn->prepare("
        INSERT INTO donation
        (receivedamount, sponsorid, volunteer_id, order_id, transaction_date,event_id,transaction_id,status)
        VALUES (?, ?, ?, ?, NOW(),?, NULL,?)
        ");

        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            error_log("Query: INSERT INTO donation (receivedamount, sponsorid, volunteer_id, order_id, transaction_date,event_id, transaction_id,status)");
            return false;
        }

        // Bind parameters: d=double, i=int, i=int, s=string
        if (!$stmt->bind_param("diisis", $receivedamount, $sponsorid, $volunteer_id, $order_id,$eventId,$status)) {
            error_log("Bind failed: " . $stmt->error);
            $stmt->close();
            return false;
        }

        if($stmt->execute())
        {
            $donationid = $stmt->insert_id;
            error_log("Donation created successfully with ID: $donationid, order_id: $order_id");
            $stmt->close();
            return $donationid;
        }
        else
        {
            error_log("Execute failed: " . $stmt->error);
            error_log("Data: " . json_encode($data));
            $stmt->close();
            return false;
        }

    }

    //get donation details by order_id to display on the successful page 
    public function getDonationByOrderId($order_id)
    {
        $stmt = $this->conn->prepare("
        SELECT transaction_id, receivedamount,transaction_date
        FROM donation
        WHERE order_id = ?
        ");

        $stmt->bind_param("s",$order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $donation = null;
        if($row = $result->fetch_assoc())
        {
            $donation = $row;
        }

        $stmt->close();
        return $donation;

    }

    public function updateDonationTransactionId($order_id, $transaction_id)
    {
        $stmt = $this->conn->prepare("
        UPDATE donation 
        SET transaction_id = ? ,status='complete'
        WHERE order_id = ?
        ");
        
        if (!$stmt) {
            return false;
        }
        
        if (!$stmt->bind_param("ss", $transaction_id, $order_id)) {
            $stmt->close();
            return false;
        }
        
        $result = $stmt->execute();
        $stmt->close();
        return $result;

    }

    public function createSponsorshipCommitment($data)
    {
        $stmt = $this->conn->prepare("
        INSERT INTO sponsor_event_commitment
        (sponsor_id, event_id, order_id, commitment_amount, commitment_date, status)
        VALUES (?, ?, ?, ?, NOW(), ?)
        ");

        $stmt->bind_param(
            "iisds",
            $data['sponsor_id'],
            $data['event_id'],
            $data['order_id'],
            $data['commitment_amount'],
            $data['status']
        );

        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function updateSponsorshipTransactionId($order_id, $transaction_id)
    {
        $stmt = $this->conn->prepare("
        UPDATE sponsor_event_commitment 
        SET transaction_id = ?, status = 'accepted'
        WHERE order_id = ?
        ");

        if (!$stmt) return false;

        $stmt->bind_param("ss", $transaction_id, $order_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getSponsorshipByOrderId($order_id)
    {
        $stmt = $this->conn->prepare("
        SELECT * FROM sponsor_event_commitment 
        WHERE order_id = ?
        ");

        $stmt->bind_param("s", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }
} 
?>