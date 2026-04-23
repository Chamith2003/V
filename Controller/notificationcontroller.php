<?php

class notificationcontroller{
    private $notifctrlvar;

    public function __construct($notifmodel){
        $this->notifctrlvar=$notifmodel;
    }

    
      
     // Get unread notification count (for AJAX polling)
     
    public function getUnreadCount() {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        //send the scheduled notifications
        $this->notifctrlvar->sendScheduledNotifications();
        
        $userId = $_SESSION['user_id'];
        $count = $this->notifctrlvar->getUnreadCount($userId);
        
        echo json_encode([
            'success' => true,
            'count' => $count,
            'hasNotifications' => $count > 0
        ]);
    }

    
    // Get all unread notifications (for the notifications page)
     
    public function getNotifications() {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }
        
        $userId = $_SESSION['user_id'];
        $notifications = $this->notifctrlvar->getUnreadNotifications($userId);
        
        // Format notifications with icons and time ago
        foreach ($notifications as &$notif) {//change inplace of the notifications array therefore use &
            $notif['icon'] = $this->notifctrlvar->getNotificationIcon($notif['category']);
            $notif['timeAgo'] = $this->notifctrlvar->timeAgo($notif['display_date']);
        }
        
        echo json_encode([
            'success' => true,
            'notifications' => $notifications
        ]);
    }

    
    // Mark a single notification as read
    
    public function markAsRead() {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }
        
        $notificationId = $_POST['notification_id']  ?? null;
        
        if (!$notificationId) {
            echo json_encode(['success' => false, 'message' => 'Notification ID required']);
            return;
        }
        
        $userId = $_SESSION['user_id'];
        $result = $this->notifctrlvar->markAsRead($notificationId, $userId);
        
        if ($result) {
            // Get updated count
            $count = $this->notifctrlvar->getUnreadCount($userId);
            
            echo json_encode([
                'success' => true,
                'message' => 'Notification marked as read',
                'remainingCount' => $count
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to mark as read']);
        }
    }

    
    // Mark all notifications as read
     
    public function markAllAsRead() {//closes all notifications sets is_closed=1 for all
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }
        
        $userId = $_SESSION['user_id'];
        $result = $this->notifctrlvar->markAllAsRead($userId);
        
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'All notifications marked as read'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to mark all as read']);
        }
    }

    
    // Create a new notification (for internal use)
     
    public function createNotification($data) {
        return $this->notifctrlvar->createNotification($data);
    }

    public function closeNotification() {
    header('Content-Type: application/json');
    
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Not authenticated']);
        return;
    }
    
    $notificationId = $_POST['notification_id'] ?? null;
    
    if (!$notificationId) {
        echo json_encode(['success' => false, 'message' => 'Notification ID required']);
        return;
    }
    
    $userId = $_SESSION['user_id'];
    $result = $this->notifctrlvar->closeNotification($notificationId, $userId);
    
    if ($result) {
        $count = $this->notifctrlvar->getUnreadCount($userId);
        
        echo json_encode([
            'success' => true,
            'message' => 'Notification closed',
            'remainingCount' => $count
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to close notification']);
    }
}




//Nadin Notifications

public function leaveeventnotification(){
    //DO NOT include another JSON response as we sent the main response in the calelendarcontroller
    if (!isset($_SESSION['user_id']) || !isset($_POST['eventId'])) {
        return; // Silent fail
    }        
    $volunteerId = $_SESSION['user_id'];
    $eventId = $_POST['eventId'];//obtained from the 'eventId' key of the AJAX form

         
    return $this->notifctrlvar->leaveeventnotification($volunteerId,$eventId);

}







//Videesha Notifications









//Chamith Notifications










//Thivinya Notifications















































}
?>