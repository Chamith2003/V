<?php

class AboutusModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Get all featured events with their sponsor information
     * Featured events are: Coral Restoration, Beach Cleanup, City Cleanup, Mountain Cleanup, Mangrove Restoration, Tree Planting
     */
    public function getFeaturedEventsWithSponsors()
    {
        try {
            $query = "
                SELECT DISTINCT
                    vp.event_id,
                    vp.name AS event_name,
                    vp.event_type,
                    vp.description,
                    vp.location,
                    s.userid AS sponsor_id,
                    u.name AS sponsor_name,
                    s.logo_path,
                    s.official_website_link 
                FROM volunteering_program vp
                LEFT JOIN donation d ON vp.event_id = d.event_id
                LEFT JOIN sponsor s ON d.sponsorid = s.userid
                LEFT JOIN user u ON s.userid = u.userid
                WHERE vp.state_of_event IN ('active', 'planned')
                AND (d.receivedamount >= 25000) AND d.status='complete'
                ORDER BY vp.event_id, s.userid
            ";

            $result = $this->conn->query($query);

            if (!$result) {
                throw new Exception("Database query failed: " . $this->conn->error);
            }

            $events = [];
            while ($row = $result->fetch_assoc()) {
                $eventId = $row['event_id'];

                // Initialize event if not already in array
                if (!isset($events[$eventId])) {
                    $events[$eventId] = [
                        'event_id' => $row['event_id'],
                        'event_name' => $row['event_name'],
                        'event_type' => $row['event_type'],
                        'location' => $row['location'],
                        'sponsors' => []
                    ];
                }

                // Add sponsor if exists and not duplicate
                if ($row['sponsor_id'] && $row['logo_path']) {
                    $sponsorExists = false;
                    foreach ($events[$eventId]['sponsors'] as $sponsor) {
                        if ($sponsor['sponsor_id'] == $row['sponsor_id']) {
                            $sponsorExists = true;
                            break;
                        }
                    }

                    if (!$sponsorExists) {
                        $events[$eventId]['sponsors'][] = [
                            'sponsor_id' => $row['sponsor_id'],
                            'sponsor_name' => $row['sponsor_name'],
                            'logo_path' => $row['logo_path'],
                            'official_website_link' => $row['official_website_link']
                        ];
                    }
                }
            }

            return array_values($events);
        } catch (Exception $e) {
            error_log("Error in getFeaturedEventsWithSponsors: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get sponsors for a specific event by event_id
     */
    public function getSponsorsByEventId($eventId)
    {
        try {
            $query = "
                SELECT DISTINCT
                    s.userid AS sponsor_id,
                    u.name AS sponsor_name,
                    s.logo_path,
                    s.official_website_link
                FROM donation d
                LEFT JOIN sponsor s ON d.sponsorid = s.userid
                LEFT JOIN user u ON s.userid = u.userid
                WHERE d.event_id = ? 
                AND s.logo_path IS NOT NULL
                AND d.receivedamount >= 25000 AND d.status='complete'
                GROUP BY s.userid
            ";

            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }

            $stmt->bind_param("i", $eventId);
            $stmt->execute();
            $result = $stmt->get_result();

            $sponsors = [];
            while ($row = $result->fetch_assoc()) {
                $sponsors[] = [
                    'sponsor_id' => $row['sponsor_id'],
                    'sponsor_name' => $row['sponsor_name'],
                    'logo_path' => $row['logo_path'],
                    'official_website_link' => $row['official_website_link']
                ];
            }

            $stmt->close();
            return $sponsors;
        } catch (Exception $e) {
            error_log("Error in getSponsorsByEventId: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get sponsors grouped by event type
     */
    public function getSponsorsByEventType($eventType)
    {
        try {
            $query = "
                SELECT DISTINCT
                    vp.event_id,
                    vp.event_type,
                    s.userid AS sponsor_id,
                    u.name AS sponsor_name,
                    s.logo_path,
                    s.official_website_link
                FROM volunteering_program vp
                LEFT JOIN donation d ON vp.event_id = d.event_id
                LEFT JOIN sponsor s ON d.sponsorid = s.userid
                LEFT JOIN user u ON s.userid = u.userid
                WHERE vp.event_type = ? AND s.logo_path IS NOT NULL
                AND d.receivedamount >= 25000 AND d.status='complete'
                AND vp.state_of_event IN ('active', 'planned')
                GROUP BY vp.event_id, s.userid
                ORDER BY vp.event_id
            ";

            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }

            $stmt->bind_param("s", $eventType);
            $stmt->execute();
            $result = $stmt->get_result();

            $events = [];
            while ($row = $result->fetch_assoc()) {
                $eventId = $row['event_id'];

                if (!isset($events[$eventId])) {
                    $events[$eventId] = [
                        'event_id' => $eventId,
                        'event_type' => $row['event_type'],
                        'sponsors' => []
                    ];
                }

                if ($row['sponsor_id']) {
                    $events[$eventId]['sponsors'][] = [
                        'sponsor_id' => $row['sponsor_id'],
                        'sponsor_name' => $row['sponsor_name'],
                        'logo_path' => $row['logo_path'],
                        'official_website_link' => $row['official_website_link']
                    ];
                }
            }

            $stmt->close();
            return array_values($events);
        } catch (Exception $e) {
            error_log("Error in getSponsorsByEventType: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get all unique sponsors across all featured events
     */
    public function getAllFeaturedSponsors()
    {
        try {
            $query = "
                SELECT DISTINCT
                    s.userid AS sponsor_id,
                    u.name AS sponsor_name,
                    s.logo_path,
                    s.official_website_link
                FROM donation d
                LEFT JOIN sponsor s ON d.sponsorid = s.userid
                LEFT JOIN user u ON s.userid = u.userid
                LEFT JOIN volunteering_program vp ON d.event_id = vp.event_id
                WHERE s.logo_path IS NOT NULL
                AND d.receivedamount >= 25000 AND d.status='complete'
                AND vp.state_of_event IN ('active', 'planned')
                ORDER BY u.name
            ";

            $result = $this->conn->query($query);

            if (!$result) {
                throw new Exception("Database query failed: " . $this->conn->error);
            }

            $sponsors = [];
            while ($row = $result->fetch_assoc()) {
                $sponsors[] = [
                    'sponsor_id' => $row['sponsor_id'],
                    'sponsor_name' => $row['sponsor_name'],
                    'logo_path' => $row['logo_path'],
                    'official_website_link' => $row['official_website_link']
                ];
            }

            return $sponsors;
        } catch (Exception $e) {
            error_log("Error in getAllFeaturedSponsors: " . $e->getMessage());
            return [];
        }
    }
}
?>