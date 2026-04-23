<?php
class notificationmodel{
    private $modelvar;

    public function __construct($conn){
        $this->modelvar=$conn;
    }

    //nadin notifications
    
    //videesha notifications
    //chamith notifications
    //thivinya notifications




    
    //  Get all unread notifications for a user actually all unclosed notifications despite being read or not (giving unread priority)
     
    public function getUnreadNotifications($userId) {
    $sql = "SELECT notification_id, type, category, title, message, link, 
                   db_object_id,db_object_type, priority, created_date,scheduled_date, COALESCE(scheduled_date, created_date) AS display_date, is_read
            FROM notification 
            WHERE receiver_id = ? AND is_sent = 1 AND is_closed = 0
            ORDER BY is_read ASC, priority DESC, display_date DESC";
    
    $stmt = $this->modelvar->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
}

public function closeNotification($notificationId, $userId) {
    $sql = "UPDATE notification 
            SET is_closed = 1, is_read = 1, read_date = NOW() 
            WHERE notification_id = ? AND receiver_id = ?";
    
    $stmt = $this->modelvar->prepare($sql);
    $stmt->bind_param("ii", $notificationId, $userId);
    
    return $stmt->execute();
}
    
    // Get count of unread notifications
     
    public function getUnreadCount($userId) {
        $sql = "SELECT COUNT(*) as count 
                FROM notification 
                WHERE receiver_id = ? AND is_read = 0 AND is_sent = 1";
        
        $stmt = $this->modelvar->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return (int)$row['count'];
    }

    
     // Mark a notification as read
     
    public function markAsRead($notificationId, $userId) {
        $sql = "UPDATE notification 
                SET is_read = 1, read_date = NOW() 
                WHERE notification_id = ? AND receiver_id = ?";
        
        $stmt = $this->modelvar->prepare($sql);
        $stmt->bind_param("ii", $notificationId, $userId);
        
        return $stmt->execute();
    }

    
    //Mark all notifications as read for a user ie close all
     
    public function markAllAsRead($userId) {
    $sql = "UPDATE notification 
            SET is_read = 1, is_closed = 1, read_date = CASE WHEN is_read = 0 THEN NOW() ELSE read_date END 
            WHERE receiver_id = ? AND is_closed = 0";//not force closed as of now
    
    $stmt = $this->modelvar->prepare($sql);
    $stmt->bind_param("i", $userId);
    
    return $stmt->execute();
}

    
    // Create a new notification
     
    public function createNotification($data) {
        $sql = "INSERT INTO notification 
                (receiver_id, type, category, title, message, link, 
                 db_object_id, db_object_type, priority, is_sent,scheduled_date,expiry_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->modelvar->prepare($sql);
        $stmt->bind_param(
            "isssssississ",
            $data['receiver_id'],
            $data['type'],
            $data['category'],
            $data['title'],
            $data['message'],
            $data['link'],
            $data['db_object_id'],
            $data['db_object_type'],
            $data['priority'],
            $data['is_sent'],
            $data['scheduled_date'],
            $data['expiry_date']
        );
        
        return $stmt->execute();
    }

    
    // Get notification icon based on category
     
    public function getNotificationIcon($category) {
        $icons = [
            'calendar' => '<img src="/V/View/userdash/settings/img/notif_icon_02.png" class="notification-icon">',
            'task' => '<img src="/V/View/userdash/settings/img/notif_icon_03.png" class="notification-icon">',
            'event' => '<img src="/V/View/userdash/settings/img/notif_icon_01.png" class="notification-icon">',
            'representative' => '<img src="/V/View/userdash/settings/img/notif_icon_04.png" class="notification-icon">',
            'sponsorship' => '<img src="/V/View/userdash/settings/img/notif_icon_10.png" class="notification-icon">',
            'donation' => '<img src="/V/View/userdash/settings/img/notif_icon_09.png" class="notification-icon">',
            'leaderboard' => '<img src="/V/View/userdash/settings/img/notif_icon_08.png" class="notification-icon">',
            'admin' => '<img src="/V/View/userdash/settings/img/notif_icon_07.png" class="notification-icon">',
            'system' => '<img src="/V/View/userdash/settings/img/notif_icon_06.png" class="notification-icon">',
            'merch' => '<img src="/V/View/userdash/settings/img/notif_icon_05.png" class="notification-icon">'
        ];
        
        return $icons[$category] ?? '🔔';
    }

    
    // Format time ago for notifications
     
    public function timeAgo($datetime) {//get the notification created_date
        $timestamp = strtotime($datetime);
        $diff = time() - $timestamp;
        
        if ($diff < 60) {
            return 'Just now';
        } elseif ($diff < 3600) {//less than 1 hour
            $mins = floor($diff / 60);
            return $mins . ' minute' . ($mins > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 86400) {//less than 1 day
            $hours = floor($diff / 3600);
            return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 604800) {//less than 7 days
            $days = floor($diff / 86400);
            return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
        } else {
            return date('M j, Y', $timestamp);//here j is the day of the month like 3rd, 4th etc.
        }
    }





    public function sendScheduledNotifications(){
        $sql="UPDATE notification
        SET is_sent = 1
        WHERE is_sent = 0 
        AND scheduled_date IS NOT NULL 
        AND scheduled_date <= NOW()";
        $stmt = $this->modelvar->prepare($sql);
        return $stmt->execute();
    }





//Nadin Notifications


public function leaveeventnotification($volunteerId, $eventId){

 $data = [

        'receiver_id' => $volunteerId,
        'type' => 'event_withdrawal',
        'category' => 'calendar',
        'title' => 'Withdrew from Event',
        'message' => "You withdrew from event ID: $eventId.",
        'link' => "/V/router.php?module=page&action=calendar",
        'db_object_id' => $eventId,
        'db_object_type' => 'event',
        'priority' => 'normal',
        'is_sent'=> 0,
        'scheduled_date' => date('Y-m-d H:i:s', strtotime('+2 minutes')),
        'expiry_date' => NULL
        ];

    return $this->createNotification($data);


}






//Videesha Notifications









//Chamith Notifications










//Thivinya Notifications




































}
?>
