<?php
class RegistrationModel {
    public $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Check if email already exists
    public function emailExists($email) {
        $stmt = $this->conn->prepare("SELECT userid FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    // Create user in user table
    public function createUser($name, $email, $hashedpassword, $contactnumber, $role) {
        
        $stmt = $this->conn->prepare(
            "INSERT INTO user (name, email, password, contactnumber, role) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssss", $name, $email, $hashedpassword, $contactnumber, $role);
        
        if ($stmt->execute()) {
            $userid = $stmt->insert_id;
            $stmt->close();
            return $userid;
        }
        
        $stmt->close();
        return false;
    }

    // Create volunteer profile
    public function createVolunteerProfile($userid, $dob, $volunteerExperience, $preferredLocation1, $preferredLocation2, $preferredLocation3) {
        $stmt = $this->conn->prepare(
            "INSERT INTO volunteer (userid, dob, volunteer_experience, preferred_location_1, preferred_location_2, preferred_location_3) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("isssss", $userid, $dob, $volunteerExperience, $preferredLocation1, $preferredLocation2, $preferredLocation3);
        
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // Create sponsor profile (basic entry)
    public function createSponsorProfile($userid,  $link, $description, $organization_type) {
        $stmt = $this->conn->prepare("INSERT INTO sponsor (userid, official_website_link, about_company, organization_type) 
             VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $userid, $link, $description, $organization_type);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // Update sponsor logo path
    public function updateSponsorLogoPath($userid, $logoPath) {
        $stmt = $this->conn->prepare("UPDATE sponsor SET logo_path = ? WHERE userid = ?");
        $stmt->bind_param("si", $logoPath, $userid);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
    // Add volunteer availability (multiple entries)
    public function addVolunteerAvailability($userid, $availabilityArray) {
        if (empty($availabilityArray)) {
            return true; // No availability to add
        }

        $stmt = $this->conn->prepare("INSERT INTO volunteer_availability (userid, availability) VALUES (?, ?)");
        
        foreach ($availabilityArray as $availability) {
            $stmt->bind_param("is", $userid, $availability);
            if (!$stmt->execute()) {
                $stmt->close();
                return false;
            }
        }
        
        $stmt->close();
        return true;
    }

    // Add volunteer skills (multiple entries)
    public function addVolunteerSkills($userid, $skillsArray) {
        if (empty($skillsArray)) {
            return true; // No skills to add
        }

        $stmt = $this->conn->prepare("INSERT INTO volunteer_skill (userid, skill) VALUES (?, ?)");
        
        foreach ($skillsArray as $skill) {
            $skill = trim($skill);
            if (!empty($skill)) {
                $stmt->bind_param("is", $userid, $skill);
                if (!$stmt->execute()) {
                    $stmt->close();
                    return false;
                }
            }
        }
        
        $stmt->close();
        return true;
    }

    // Get user by email (for login after registration)
    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT userid, name, email, role FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }
}
?>