<?php
// Model/attendancemodel.php
class AttendanceModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn; // expects mysqli
    }

    public function volunteerExists(int $volunteerId): bool {
        $sql = "SELECT userid FROM volunteer WHERE userid = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $volunteerId);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    public function eventExists(int $eventId): bool {
        $sql = "SELECT event_id FROM volunteering_program WHERE event_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $eventId);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    /**
     * Insert or update an attendance_rating record.
     * Returns array: ['success'=>bool,'message'=>string]
     */
    public function upsertAttendance(int $eventId, int $volunteerId, int $raterId, float $attendanceScore = 5): array {
        try {
            $this->conn->begin_transaction();

            // check if record exists
            $checkSql = "SELECT attendance_rating_id FROM attendance_rating WHERE event_id = ? AND volunteer_id = ? AND rater_id = ? LIMIT 1";
            $stmt = $this->conn->prepare($checkSql);
            $stmt->bind_param('iii', $eventId, $volunteerId, $raterId);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Update existing row
               
                $stmt->fetch();
                $stmt->close();

                $updateSql = "UPDATE attendance_rating SET attendance_score = ?, rating_date = NOW() WHERE attendance_rating_id = ?";
                $u = $this->conn->prepare($updateSql);
                $u->bind_param('di', $attendanceScore, );
                $ok = $u->execute();
                $u->close();

                if (!$ok) {
                    $this->conn->rollback();
                    return ['success' => false, 'message' => 'Failed to update attendance rating.'];
                }
            } else {
                // Insert new row
                $stmt->close();
                $insertSql = "INSERT INTO attendance_rating (event_id, volunteer_id, rater_id, attendance_score, rating_date) VALUES (?, ?, ?, ?, NOW())";
                $i = $this->conn->prepare($insertSql);
                if (!$i) {
                    $this->conn->rollback();
                    return ['success' => false, 'message' => 'Prepare failed: ' . $this->conn->error];
                }
                $i->bind_param('iiid', $eventId, $volunteerId, $raterId, $attendanceScore);
                $ok = $i->execute();
                $i->close();

                if (!$ok) {
                    $this->conn->rollback();
                    return ['success' => false, 'message' => 'Failed to insert attendance rating.'];
                }
            }

            // Also update/insert event_participation to mark attended
            $participationSql = "INSERT INTO event_participation (event_id, volunteer_id, participation_status, registration_date)
                                 VALUES (?, ?, 'attended', NOW())
                                 ON DUPLICATE KEY UPDATE participation_status = 'attended', registration_date = NOW()";
            $p = $this->conn->prepare($participationSql);
            $p->bind_param('ii', $eventId, $volunteerId);
            $ok2 = $p->execute();
            $p->close();

            if (!$ok2) {
                $this->conn->rollback();
                return ['success' => false, 'message' => 'Failed to update event participation.'];
            }

            $this->conn->commit();
            return ['success' => true, 'message' => 'Attendance recorded.'];

        } catch (Exception $ex) {
            if ($this->conn->errno) { /* fallback */ }
            $this->conn->rollback();
            return ['success' => false, 'message' => 'Database error: ' . $ex->getMessage()];
        }
    }

public function isVolunteerRegistered(int $volunteerId, int $eventId): bool {
    $stmt = $this->conn->prepare("
        SELECT COUNT(*) as count
        FROM event_participation
        WHERE volunteer_id = ?
          AND event_id = ?
          AND participation_status = 'registered'
    ");
    $stmt->bind_param("ii", $volunteerId, $eventId);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $row['count'] > 0;
}
    
}
