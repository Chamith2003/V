<?php
class usermodel
{
    private $modelvar;
    public function __construct($conn)
    {
        //get the $conn and give that to $modelvar to be used throughout php file
        //the $conn dissappears outside constructor function
        $this->modelvar = $conn;
    }
    public function getemail($email)
    {
        $stmt = ($this->modelvar)->prepare("select * from user where email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return ($stmt->get_result())->fetch_assoc();
        //return the result and then convert it to as associative array
    }

    public function getuserbyid($userId)
    {
        $stmt = $this->modelvar->prepare("SELECT name, email, contactnumber, password, profile_path FROM user WHERE userid = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }


    // Update user role
    public function updateUserRole($userId, $role)
    {
        $stmt = $this->modelvar->prepare("UPDATE user SET role = ? WHERE userid = ?");
        $stmt->bind_param("si", $role, $userId);
        return $stmt->execute();
    }


    public function updatePassword($userid, $newPassword)
    {

        // Hash password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $query = "UPDATE user SET password = ? WHERE userid = ?";
        $stmt = $this->modelvar->prepare($query);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("si", $hashedPassword, $userid);

        if ($stmt->execute()) {
            return $stmt->affected_rows > 0;
        }

        return false;
    }




    public function getuserandvolunteerbyid($userId)
    {
        $stmt = $this->modelvar->prepare("
        SELECT 
            user.userid,
            user.name,
            user.email,
            user.contactnumber,
            user.createddate,
            user.role,
            user.profile_path,
            volunteer.levelpoints,
            volunteer.starpoints,
            volunteer.noofmembers,
            volunteer.dob,
            volunteer.volunteer_experience,
            volunteer.preferred_location_1,
            volunteer.preferred_location_2,
            volunteer.preferred_location_3
        FROM user
        LEFT JOIN volunteer ON user.userid = volunteer.userid
        WHERE user.userid = ?
    ");

        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateUserAndVolunteer(
        $userId,
        $name,
        $email,
        $contactnumber,
        $dob,
        $volunteer_experience,
        $preferred_location_1,
        $preferred_location_2,
        $preferred_location_3
    ) {
        // --- UPDATE USER TABLE ---
        $stmtUser = $this->modelvar->prepare("
        UPDATE user 
        SET name = ?, email = ?, contactnumber = ?
        WHERE userid = ?
    ");

        $stmtUser->bind_param("sssi", $name, $email, $contactnumber, $userId);

        $userUpdated = $stmtUser->execute();


        // --- UPDATE VOLUNTEER TABLE ---
        $stmtVol = $this->modelvar->prepare("
        UPDATE volunteer
        SET dob = ?, volunteer_experience = ?, preferred_location_1 = ?, preferred_location_2 = ?, preferred_location_3 = ?
        WHERE userid = ?
    ");

        $stmtVol->bind_param(
            "sssssi",
            $dob,
            $volunteer_experience,
            $preferred_location_1,
            $preferred_location_2,
            $preferred_location_3,
            $userId
        );

        $volUpdated = $stmtVol->execute();

        // Return TRUE only if both updates succeed
        return ($userUpdated && $volUpdated);
    }

    

    // DELETE ACCOUNT METHOD
    public function deleteUserAccount($userId)
    {
        try {
            // Disable foreign key checks temporarily to allow deletion
            $this->modelvar->query("SET FOREIGN_KEY_CHECKS=0");

            
            // 24. Finally, delete from user table
            $stmt = $this->modelvar->prepare("UPDATE user 
            SET status = 'suspended' 
            WHERE userid = ?");
            $stmt->bind_param("i", $userId);
            $result = $stmt->execute();

            // Re-enable foreign key checks
            $this->modelvar->query("SET FOREIGN_KEY_CHECKS=1");

            return $result;

        } catch (Exception $e) {
            // Re-enable foreign key checks on error
            $this->modelvar->query("SET FOREIGN_KEY_CHECKS=1");
            error_log("Delete account error: " . $e->getMessage());
            return false;
        }
    }


    public function getVolunteerAvailability($userid)
    {
        $stmt = $this->modelvar->prepare(
            "SELECT availability FROM volunteer_availability WHERE userid = ? ORDER BY availability"
        );
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();

        $availabilities = [];
        while ($row = $result->fetch_assoc()) {
            $availabilities[] = $row['availability'];
        }

        $stmt->close();
        return $availabilities;
    }

    public function updateVolunteerAvailability($userid, $availabilityArray)
    {
        // Start transaction
        $this->modelvar->begin_transaction();

        try {
            // Delete old availability
            $stmt = $this->modelvar->prepare("DELETE FROM volunteer_availability WHERE userid = ?");
            $stmt->bind_param("i", $userid);
            $stmt->execute();
            $stmt->close();

            // Insert new availability
            if (!empty($availabilityArray)) {
                $stmt = $this->modelvar->prepare(
                    "INSERT INTO volunteer_availability (userid, availability) VALUES (?, ?)"
                );

                foreach ($availabilityArray as $availability) {
                    $stmt->bind_param("is", $userid, $availability);
                    if (!$stmt->execute()) {
                        throw new Exception("Failed to add availability");
                    }
                }
                $stmt->close();
            }

            $this->modelvar->commit();
            return ['success' => true, 'message' => 'Availability updated successfully'];

        } catch (Exception $e) {
            $this->modelvar->rollback();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    
public function getuserbyidwithsponsor($userId)
{
    $stmt = $this->modelvar->prepare("
        SELECT 
            user.userid,
            user.name,
            user.email,
            user.contactnumber,
            user.createddate,
            user.role,
            user.profile_path,
            sponsor.business_registration_number,
            sponsor.year_established,
            sponsor.official_website_link,
            sponsor.about_company,
            sponsor.organization_type,
            sponsor.contact_person_name,
            sponsor.contact_person_role,
            sponsor.contact_person_email,
            sponsor.contact_person_contact_number,
            sponsor.logo_path
        FROM user
        LEFT JOIN sponsor ON user.userid = sponsor.userid
        WHERE user.userid = ?
    ");

    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}


public function updateSponsorProfile(
    $userId,
    $name,
    $email,
    $contactnumber,
    $business_registration_number,
    $year_established,
    $official_website_link,
    $about_company,
    $organization_type,
    $contact_person_name,
    $contact_person_role,
    $contact_person_email,
    $contact_person_contact_number,
    $logo_path = null
) {
    // Update user table
    $stmtUser = $this->modelvar->prepare("
        UPDATE user 
        SET name = ?, email = ?, contactnumber = ?
        WHERE userid = ?
    ");

    $stmtUser->bind_param("sssi", $name, $email, $contactnumber, $userId);
    $userUpdated = $stmtUser->execute();
    if ($logo_path) {

    // Update sponsor table
    $stmtSponsor = $this->modelvar->prepare("
        UPDATE sponsor
        SET business_registration_number = ?, 
            year_established = ?, 
            official_website_link = ?, 
            about_company = ?, 
            organization_type = ?, 
            contact_person_name = ?, 
            contact_person_role = ?, 
            contact_person_email = ?, 
            contact_person_contact_number = ?,
            logo_path = ?
        WHERE userid = ?
    ");

    $stmtSponsor->bind_param(
        "ssssssssssi",
        $business_registration_number,
        $year_established,
        $official_website_link,
        $about_company,
        $organization_type,
        $contact_person_name,
        $contact_person_role,
        $contact_person_email,
        $contact_person_contact_number,
        $logo_path,
        $userId
    );

    } else {
        $stmtSponsor = $this->modelvar->prepare("
        UPDATE sponsor
        SET business_registration_number = ?, 
            year_established = ?, 
            official_website_link = ?, 
            about_company = ?, 
            organization_type = ?, 
            contact_person_name = ?, 
            contact_person_role = ?, 
            contact_person_email = ?, 
            contact_person_contact_number = ?
        WHERE userid = ?
    ");

    $stmtSponsor->bind_param(
        "ssssssssssi",
        $business_registration_number,
        $year_established,
        $official_website_link,
        $about_company,
        $organization_type,
        $contact_person_name,
        $contact_person_role,
        $contact_person_email,
        $contact_person_contact_number,
        
        $userId
    );

    }
    $sponsorUpdated = $stmtSponsor->execute();

    // Return TRUE only if both updates succeed
    return ($userUpdated && $sponsorUpdated);
}
 

public function updateProfileImagePath($userId, $imagePath)
{
    $stmt = $this->modelvar->prepare("UPDATE user SET profile_path = ? WHERE userid = ?");
    $stmt->bind_param("si", $imagePath, $userId);
    return $stmt->execute();
}


// Get user profile path by user ID
public function getUserProfilePath($userId)
{
    $stmt = $this->modelvar->prepare("SELECT profile_path FROM user WHERE userid = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

}



?>