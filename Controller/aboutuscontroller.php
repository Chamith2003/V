
<?php

class AboutusController {
    private $aboutusModel;

    public function __construct($aboutusModel) {
        $this->aboutusModel = $aboutusModel;
    }

    /**
     * Get featured events with sponsor data for the about us page
     */
    public function getFeaturedEventsData() {
        try {
            $events = $this->aboutusModel->getFeaturedEventsWithSponsors();
            return [
                'success' => true,
                'events' => $events
            ];
        } catch (Exception $e) {
            error_log("Error in getFeaturedEventsData: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to fetch events data'
            ];
        }
    }

    /**
     * Get sponsors for a specific event (AJAX endpoint)
     */
    public function getEventSponsors() {
        header('Content-Type: application/json');
        
        try {
            $eventId = $_GET['event_id'] ?? null;

            if (!$eventId) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Event ID is required'
                ]);
                return;
            }

            $sponsors = $this->aboutusModel->getSponsorsByEventId($eventId);

            echo json_encode([
                'success' => true,
                'sponsors' => $sponsors,
                'event_id' => $eventId
            ]);
        } catch (Exception $e) {
            error_log("Error in getEventSponsors: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Failed to fetch sponsors'
            ]);
        }
    }

    /**
     * Get sponsors by event type (AJAX endpoint)
     */
    public function getSponsorsByType() {
        header('Content-Type: application/json');
        
        try {
            $eventType = $_GET['event_type'] ?? null;

            if (!$eventType) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Event type is required'
                ]);
                return;
            }

            $events = $this->aboutusModel->getSponsorsByEventType($eventType);

            echo json_encode([
                'success' => true,
                'events' => $events,
                'event_type' => $eventType
            ]);
        } catch (Exception $e) {
            error_log("Error in getSponsorsByType: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Failed to fetch sponsors by type'
            ]);
        }
    }

    /**
     * Render the about us page with all data
     */
    public function renderAboutUsPage() {
        try {
            $eventsData = $this->getFeaturedEventsData();
            return $eventsData['events'] ?? [];
        } catch (Exception $e) {
            error_log("Error in renderAboutUsPage: " . $e->getMessage());
            return [];
        }
    }
}
?>