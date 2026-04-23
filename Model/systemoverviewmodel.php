<?php
class systemoverviewmodel {
    private $db;

    public function __construct($conn) {
        date_default_timezone_set('Asia/Kolkata');
        $this->db = $conn;
    }

    // Get basic system statistics
    public function getSystemStats() {
        $stats = [
            'totalUsers' => 0,
            'totalEvents' => 0,
            'totalSponsors' => 0,
            'totalParticipants' => 0,
            'usersChange' => 0,
            'eventsChange' => 0,
            'sponsorsChange' => 0,
            'participantsChange' => 0
        ];

        // Total users
        $result = $this->db->query("SELECT COUNT(*) as count FROM user");
        $stats['totalUsers'] = $result->fetch_assoc()['count'];

        // Total events
        $result = $this->db->query("SELECT COUNT(*) as count FROM volunteering_program WHERE isauthorized = 1 AND state_of_event = 'completed'");
        $stats['totalEvents'] = $result->fetch_assoc()['count'];

        // Total sponsors
        $result = $this->db->query("SELECT COUNT(*) as count FROM sponsor");
        $stats['totalSponsors'] = $result->fetch_assoc()['count'];

        // Total participants (unique volunteers who participated)
        $result = $this->db->query("SELECT COUNT(*) as count FROM event_participation WHERE participation_status IN ('attended', 'completed')");
        $stats['totalParticipants'] = $result->fetch_assoc()['count'];

        // Calculate percentage changes (last month vs this month)
        // Users change
        $result = $this->db->query("
            SELECT 
                (SELECT COUNT(*) FROM user WHERE MONTH(createddate) = MONTH(CURRENT_DATE) AND YEAR(createddate) = YEAR(CURRENT_DATE)) as current_month,
                (SELECT COUNT(*) FROM user WHERE MONTH(createddate) = MONTH(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH)) AND YEAR(createddate) = YEAR(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))) as last_month
        ");
        $row = $result->fetch_assoc();
        if ($row['last_month'] > 0) {
            $stats['usersChange'] = round((($row['current_month'] - $row['last_month']) / $row['last_month']) * 100, 1);
        }

        // Events change
        $result = $this->db->query("
            SELECT 
                (SELECT COUNT(*) FROM volunteering_program WHERE isauthorized = 1 AND state_of_event = 'completed' AND MONTH(event_date) = MONTH(CURRENT_DATE) AND YEAR(event_date) = YEAR(CURRENT_DATE)) as current_month,
                (SELECT COUNT(*) FROM volunteering_program WHERE isauthorized = 1 AND state_of_event = 'completed' AND MONTH(event_date) = MONTH(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH)) AND YEAR(event_date) = YEAR(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))) as last_month
        ");
        $row = $result->fetch_assoc();
        if ($row['last_month'] > 0) {
            $stats['eventsChange'] = round((($row['current_month'] - $row['last_month']) / $row['last_month']) * 100, 1);
        }

        // Sponsors change
        $result = $this->db->query("
            SELECT 
                (SELECT COUNT(*) FROM user WHERE role='sponsor' AND MONTH(createddate) = MONTH(CURRENT_DATE) AND YEAR(createddate) = YEAR(CURRENT_DATE)) as current_month,
                (SELECT COUNT(*) FROM user WHERE role='sponsor' AND MONTH(createddate) = MONTH(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH)) AND YEAR(createddate) = YEAR(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))) as last_month
        ");
        $row = $result->fetch_assoc();
        if ($row['last_month'] > 0) {
            $stats['sponsorsChange'] = round((($row['current_month'] - $row['last_month']) / $row['last_month']) * 100, 1);
        }

        // Participants change
        $result = $this->db->query("
            SELECT 
                (SELECT COUNT(*) FROM event_participation WHERE participation_status IN ('attended', 'completed') AND MONTH(registration_date) = MONTH(CURRENT_DATE) AND YEAR(registration_date) = YEAR(CURRENT_DATE)) as current_month,
                (SELECT COUNT(*) FROM event_participation WHERE participation_status IN ('attended', 'completed') AND MONTH(registration_date) = MONTH(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH)) AND YEAR(registration_date) = YEAR(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))) as last_month
        ");
        $row = $result->fetch_assoc();
        if ($row['last_month'] > 0) {
            $stats['participantsChange'] = round((($row['current_month'] - $row['last_month']) / $row['last_month']) * 100, 1);
        }

        return $stats;
    }

    // Get monthly participation trends (configurable period)
    private function getMonthlyTrendsForPeriod($monthsCount) {
        $monthlyData = [
            'labels' => [],
            'events' => [],
            'participants' => [],
            'newUsers' => []
        ];

        $months = [];
        for ($i = $monthsCount - 1; $i >= 0; $i--) {
            $date = date('Y-m-01', strtotime("-$i months"));
            $monthKey = date('Y-m', strtotime($date));
            $monthLabel = date('M Y', strtotime($date));
            
            $months[$monthKey] = [
                'label' => $monthLabel,
                'events' => 0,
                'participants' => 0,
                'newUsers' => 0
            ];
        }

        // Get events data
        $sql = "
            SELECT 
                DATE_FORMAT(event_date, '%Y-%m') AS month_key,
                COUNT(*) AS events
            FROM volunteering_program
            WHERE isauthorized = 1 
                AND state_of_event = 'completed'
                AND event_date >= DATE_SUB(CURRENT_DATE, INTERVAL $monthsCount MONTH)
            GROUP BY DATE_FORMAT(event_date, '%Y-%m')
        ";
        
        $result = $this->db->query($sql);
        while ($row = $result->fetch_assoc()) {
            if (isset($months[$row['month_key']])) {
                $months[$row['month_key']]['events'] = (int)$row['events'];
            }
        }

        // Get participants data
        $sql = "
            SELECT 
                DATE_FORMAT(registration_date, '%Y-%m') AS month_key,
                COUNT(*) AS participants
            FROM event_participation
            WHERE participation_status IN ('attended', 'completed')
                AND registration_date >= DATE_SUB(CURRENT_DATE, INTERVAL $monthsCount MONTH)
            GROUP BY DATE_FORMAT(registration_date, '%Y-%m')
        ";

        $result = $this->db->query($sql);
        while ($row = $result->fetch_assoc()) {
            if (isset($months[$row['month_key']])) {
                $months[$row['month_key']]['participants'] = (int)$row['participants'];
            }
        }

        // Get new users per month
        $sql = "
            SELECT 
                DATE_FORMAT(createddate, '%Y-%m') as month_key,
                COUNT(*) as users
            FROM user
            WHERE createddate >= DATE_SUB(CURRENT_DATE, INTERVAL $monthsCount MONTH)
            GROUP BY DATE_FORMAT(createddate, '%Y-%m')
        ";
        
        $result = $this->db->query($sql);
        while ($row = $result->fetch_assoc()) {
            if (isset($months[$row['month_key']])) {
                $months[$row['month_key']]['newUsers'] = (int)$row['users'];
            }
        }

        // Build final arrays in correct order
        foreach ($months as $monthData) {
            $monthlyData['labels'][] = $monthData['label'];
            $monthlyData['events'][] = $monthData['events'];
            $monthlyData['participants'][] = $monthData['participants'];
            $monthlyData['newUsers'][] = $monthData['newUsers'];
        }

        return $monthlyData;
    }

    // Get monthly participation trends (last 6 months)
    public function getMonthlyTrends() {
        return $this->getMonthlyTrendsForPeriod(6);
    }

    // Get monthly trends for 1 year
    public function getMonthlyTrendsYear() {
        return $this->getMonthlyTrendsForPeriod(12);
    }

    // Get all time monthly trends
    public function getMonthlyTrendsAllTime() {
        $monthlyData = [
            'labels' => [],
            'events' => [],
            'participants' => [],
            'newUsers' => []
        ];

        // Get the earliest date in the database
        $sql = "SELECT MIN(createddate) as min_user_date FROM user";
        $result = $this->db->query($sql);
        $minUserDate = $result->fetch_assoc()['min_user_date'];
        
        $sql = "SELECT MIN(event_date) as min_event_date FROM volunteering_program WHERE isauthorized = 1 AND state_of_event = 'completed'";
        $result = $this->db->query($sql);
        $minEventDate = $result->fetch_assoc()['min_event_date'];
        
        // Use the earlier of the two dates
        $startDate = min($minUserDate, $minEventDate);
        if (!$startDate) {
            return $this->getMonthlyTrendsForPeriod(12); // Fallback to 1 year if no data
        }
        
        $startMonth = date('Y-m-01', strtotime($startDate));
        $currentMonth = date('Y-m-01');
        
        $months = [];
        $current = strtotime($startMonth);
        $end = strtotime($currentMonth);
        
        while ($current <= $end) {
            $monthKey = date('Y-m', $current);
            $monthLabel = date('M Y', $current);
            
            $months[$monthKey] = [
                'label' => $monthLabel,
                'events' => 0,
                'participants' => 0,
                'newUsers' => 0
            ];
            
            $current = strtotime('+1 month', $current);
        }

        // Get events data
        $sql = "
            SELECT 
                DATE_FORMAT(event_date, '%Y-%m') AS month_key,
                COUNT(*) AS events
            FROM volunteering_program
            WHERE isauthorized = 1 
                AND state_of_event = 'completed'
            GROUP BY DATE_FORMAT(event_date, '%Y-%m')
        ";
        
        $result = $this->db->query($sql);
        while ($row = $result->fetch_assoc()) {
            if (isset($months[$row['month_key']])) {
                $months[$row['month_key']]['events'] = (int)$row['events'];
            }
        }

        // Get participants data
        $sql = "
            SELECT 
                DATE_FORMAT(registration_date, '%Y-%m') AS month_key,
                COUNT(*) AS participants
            FROM event_participation
            WHERE participation_status IN ('attended', 'completed')
            GROUP BY DATE_FORMAT(registration_date, '%Y-%m')
        ";

        $result = $this->db->query($sql);
        while ($row = $result->fetch_assoc()) {
            if (isset($months[$row['month_key']])) {
                $months[$row['month_key']]['participants'] = (int)$row['participants'];
            }
        }

        // Get new users per month
        $sql = "
            SELECT 
                DATE_FORMAT(createddate, '%Y-%m') as month_key,
                COUNT(*) as users
            FROM user
            GROUP BY DATE_FORMAT(createddate, '%Y-%m')
        ";
        
        $result = $this->db->query($sql);
        while ($row = $result->fetch_assoc()) {
            if (isset($months[$row['month_key']])) {
                $months[$row['month_key']]['newUsers'] = (int)$row['users'];
            }
        }

        // Build final arrays in correct order
        foreach ($months as $monthData) {
            $monthlyData['labels'][] = $monthData['label'];
            $monthlyData['events'][] = $monthData['events'];
            $monthlyData['participants'][] = $monthData['participants'];
            $monthlyData['newUsers'][] = $monthData['newUsers'];
        }

        return $monthlyData;
    }

    // Get most active cities
    public function getMostActiveCities() {
        $sql = "
            SELECT 
                location as name,
                COUNT(*) as count
            FROM volunteering_program
            WHERE isauthorized = 1 AND state_of_event = 'completed' AND location IS NOT NULL AND location != ''
            GROUP BY location
            ORDER BY count DESC
            LIMIT 8
        ";
        
        $result = $this->db->query($sql);
        $cities = [];
        
        while ($row = $result->fetch_assoc()) {
            $cities[] = [
                'name' => $row['name'],
                'count' => (int)$row['count']
            ];
        }
        
        return $cities;
    }

    // Get event categories distribution
    public function getEventCategories() {
        $colors = ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#14b8a6', '#f97316'];
        
        $sql = "
            SELECT 
                event_type as name,
                COUNT(*) as count
            FROM volunteering_program
            WHERE isauthorized = 1 AND state_of_event = 'completed' AND event_type IS NOT NULL
            GROUP BY event_type
            ORDER BY count DESC
            LIMIT 8
        ";
        
        $result = $this->db->query($sql);
        $categories = [];
        $colorIndex = 0;
        
        while ($row = $result->fetch_assoc()) {
            $categories[] = [
                'name' => $row['name'],
                'count' => (int)$row['count'],
                'color' => $colors[$colorIndex % count($colors)]
            ];
            $colorIndex++;
        }
        
        return $categories;
    }

    // Get top volunteers
    public function getTopVolunteers() {
        $sql = "
            SELECT 
                u.name,
                COUNT(DISTINCT vp.event_id) as events,
                COALESCE(SUM(vp.duration), 0) as hours,
                v.levelpoints
            FROM volunteer v
            JOIN user u ON v.userid = u.userid
            LEFT JOIN event_participation ep ON v.userid = ep.volunteer_id AND ep.participation_status IN ('attended', 'completed')
            LEFT JOIN volunteering_program vp ON ep.event_id = vp.event_id AND vp.isauthorized = 1 AND vp.state_of_event = 'completed'
            GROUP BY v.userid, u.name, v.levelpoints
            ORDER BY events DESC, hours DESC
            LIMIT 5
        ";
        
        $result = $this->db->query($sql);
        $volunteers = [];
        $rank = 0;
        $prev_events = -1;
        $prev_hours = -1;
        
        while ($row = $result->fetch_assoc()) {
            // Only increase rank if events or hours are different from the previous volunteer
            if ($row['events'] != $prev_events || $row['hours'] != $prev_hours) {
                $rank++;
                $prev_events = $row['events'];
                $prev_hours = $row['hours'];
            }
            
            // Assign badge based on rank
            if ($rank == 1) {
                $badge = 'Gold';
            } elseif ($rank == 2) {
                $badge = 'Silver';
            } elseif ($rank == 3) {
                $badge = 'Bronze';
            } else {
                $badge = 'Participant';
            }
            
            $volunteers[] = [
                'rank' => $rank,
                'name' => $row['name'],
                'events' => (int)$row['events'],
                'hours' => (int)$row['hours'],
                'badge' => $badge
            ];
        }
        
        return $volunteers;
    }

    // Get top sponsors
    public function getTopSponsors() {
        $sql = "
            SELECT 
                u.name,
                COALESCE(SUM(d.receivedamount), 0) as total_donated,
                COUNT(DISTINCT d.donationid) as donation_count
            FROM sponsor s
            JOIN user u ON s.userid = u.userid
            LEFT JOIN donation d ON s.userid = d.sponsorid AND d.status = 'complete'
            GROUP BY s.userid, u.name
            ORDER BY total_donated DESC, donation_count DESC
            LIMIT 5
        ";
        
        $result = $this->db->query($sql);
        $sponsors = [];
        $rank = 0;
        $prev_donated = -1;
        $prev_count = -1;
        
        while ($row = $result->fetch_assoc()) {
            if ($row['total_donated'] != $prev_donated || $row['donation_count'] != $prev_count) {
                $rank++;
                $prev_donated = $row['total_donated'];
                $prev_count = $row['donation_count'];
            }
            
            $sponsors[] = [
                'rank' => $rank,
                'name' => $row['name'],
                'events' => (int)$row['total_donated'],
                'donation_count' => (int)$row['donation_count']
            ];
        }
        
        return $sponsors;
    }

    // Get system growth over time (last 10 months)
    public function getSystemGrowth() {
        $growthData = [
            'labels' => [],
            'users' => [],
            'events' => [],
            'sponsors' => []
        ];

        // Get last 10 months
        for ($i = 9; $i >= 0; $i--) {
            $date = date('Y-m-01', strtotime("-$i months"));
            $month = date('M', strtotime($date));
            $growthData['labels'][] = $month;

            // Cumulative users up to this month
            $sql = "SELECT COUNT(*) as count FROM user WHERE createddate <= LAST_DAY('$date')";
            $result = $this->db->query($sql);
            $growthData['users'][] = (int)$result->fetch_assoc()['count'];

            // Cumulative events up to this month
            $sql = "SELECT COUNT(*) as count FROM volunteering_program WHERE isauthorized = 1 AND state_of_event = 'completed' AND event_date <= LAST_DAY('$date')";
            $result = $this->db->query($sql);
            $growthData['events'][] = (int)$result->fetch_assoc()['count'];

            // Cumulative sponsors up to this month
            $sql = "SELECT COUNT(*) as count FROM user WHERE role='sponsor' AND createddate <= LAST_DAY('$date')";
            $result = $this->db->query($sql);
            $growthData['sponsors'][] = (int)$result->fetch_assoc()['count'];
        }

        return $growthData;
    }

    // Get recent system activities
    public function getRecentActivities() {
        $activities = [];

        // Recent user registrations
        $sql = "
            SELECT name, role, createddate, createddate as timestamp
            FROM user 
            ORDER BY createddate DESC 
        ";
        $result = $this->db->query($sql);
        while ($row = $result->fetch_assoc()) {
            $icon = '👤';
            $title = 'New User Registration';
            $description = $row['name'] . ' joined as a ' . $row['role'];
            $time = $this->getTimeAgo($row['createddate']);
            
            $activities[] = [
                'icon' => $icon,
                'title' => $title,
                'description' => $description,
                'time' => $time,
                'type' => 'user',
                'timestamp' => strtotime($row['timestamp'])
            ];
        }

        // Recent events created
        $sql = "
            SELECT vp.name, vp.location, vp.event_date, vp.createddate
            FROM volunteering_program vp 
            WHERE vp.isauthorized = 1
            ORDER BY vp.createddate DESC
        ";
        $result = $this->db->query($sql);
        while ($row = $result->fetch_assoc()) {
            $location = !empty($row['location']) ? $row['location'] : 'Location TBA';
            $activities[] = [
                'icon' => '📅',
                'title' => 'Event Created',
                'description' => $row['name'] . ' in ' . $location . ' scheduled for ' . date('M d', strtotime($row['event_date'])),
                'time' => $this->getTimeAgo($row['createddate']),
                'type' => 'event',
                'timestamp' => strtotime($row['createddate'])
            ];
        }

        // Recent completed events (using createddate as proxy for completion time since no completion timestamp exists)
        $sql = "
            SELECT name, location, event_date, createddate
            FROM volunteering_program
            WHERE isauthorized = 1 AND state_of_event = 'completed'
            ORDER BY event_date DESC
        ";
        $result = $this->db->query($sql);
        while ($row = $result->fetch_assoc()) {
            $activities[] = [
                'icon' => '✅',
                'title' => 'Event Completed',
                'description' => $row['name'] . ' completed successfully',
                'time' => $this->getTimeAgo($row['event_date']),
                'type' => 'success',
                'timestamp' => strtotime($row['event_date'])
            ];
        }

        // Sort by most recent timestamp (descending)
        usort($activities, function($a, $b) {
            return $b['timestamp'] - $a['timestamp'];
        });

        // Remove timestamp field before returning (only used for sorting)
        foreach ($activities as &$activity) {
            unset($activity['timestamp']);
        }

        return $activities;
    }

    // Helper function to calculate time ago
    private function getTimeAgo($datetime) {
        $timestamp = strtotime($datetime);
        
        // Validate timestamp
        if ($timestamp === false || $timestamp === null) {
            return 'Recently';
        }
        
        $diff = time() - $timestamp;
        
        // Handle future dates or invalid negative differences
        if ($diff < 0) {
            return 'Just now';
        }
        
        // Handle different time ranges
        if ($diff < 5) {
            return 'Just now';
        } elseif ($diff < 60) {
            return $diff . ' seconds ago';
        } elseif ($diff < 3600) {
            $mins = floor($diff / 60);
            return $mins . ' minute' . ($mins > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
        } elseif ($diff < 2592000) {
            $days = floor($diff / 86400);
            return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
        } else {
            return date('M d, Y', $timestamp);
        }
    }

    public function getReportData($type, $startDate, $endDate, $options) {
        $data = [];
        $startDate = $this->db->real_escape_string($startDate);
        $endDate = $this->db->real_escape_string($endDate);

        if ($type === 'events') {
            $selects = ["vp.name as Event_Name", "vp.event_date as Event_Date", "vp.location as Location"];
            
            if (in_array('attendance', $options)) {
                $selects[] = "COALESCE((SELECT COUNT(*) FROM event_participation ep WHERE ep.event_id = vp.event_id AND ep.participation_status IN ('attended', 'completed')), 0) as Attendance";
            }
            if (in_array('tasks', $options)) {
                $selects[] = "COALESCE((SELECT COUNT(*) FROM task t WHERE t.event_id = vp.event_id), 0) AS Tasks_Count";
            }

            $selectStr = implode(", ", $selects);
            $sql = "SELECT {$selectStr} FROM volunteering_program vp WHERE state_of_event = 'completed' AND vp.event_date >= '{$startDate}' AND vp.event_date <= '{$endDate}' ORDER BY vp.event_date DESC";
            
            $result = $this->db->query($sql);
            if ($result) {
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }

        } elseif ($type === 'volunteers') {
            $selects = ["u.name as Volunteer_Name", "DATE(u.createddate) as Join_Date"];
            $joins = "";
            
            if (in_array('levelpoints', $options) || in_array('starpoints', $options)) {
                $joins .= " LEFT JOIN volunteer v ON u.userid = v.userid";
            }
            if (in_array('hours', $options)) {
                $selects[] = "COALESCE((SELECT SUM(vp.duration) FROM event_participation ep JOIN volunteering_program vp ON ep.event_id = vp.event_id WHERE ep.volunteer_id = u.userid AND ep.participation_status IN ('attended', 'completed')), 0) as Total_Hours";
            }
            if (in_array('levelpoints', $options)) {
                $selects[] = "COALESCE(v.levelpoints, 0) as Level_Points_Earned";
            }
            if (in_array('starpoints', $options)){
                $selects[] = "COALESCE(v.starpoints, 0) as Star_Points_Earned";
            }

            $selectStr = implode(", ", $selects);
            $sql = "SELECT {$selectStr} FROM user u {$joins} WHERE u.role = 'volunteer' AND u.createddate >= '{$startDate} 00:00:00' AND u.createddate <= '{$endDate} 23:59:59' ORDER BY u.createddate DESC";
            
            $result = $this->db->query($sql);
            if ($result) {
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }

        } elseif ($type === 'sponsors') {
            $selects = ["u.name as Sponsor_Name", "DATE(u.createddate) as Join_Date"];
            
            if (in_array('donations', $options)) {
                $selects[] = "COALESCE((SELECT SUM(receivedamount) FROM donation d WHERE d.sponsorid = u.userid AND d.status = 'completed'), 0) as Total_Donations";
            }
            if (in_array('sponsorships', $options)) {
                $selects[] = "COALESCE((SELECT COUNT(*) FROM donation d WHERE d.sponsorid = u.userid AND d.status = 'completed'), 0) as Number_Of_Sponsorships";
            }

            $selectStr = implode(", ", $selects);
            $sql = "SELECT {$selectStr} FROM user u WHERE u.role = 'sponsor' AND u.createddate >= '{$startDate} 00:00:00' AND u.createddate <= '{$endDate} 23:59:59' ORDER BY u.createddate DESC";
            
            $result = $this->db->query($sql);
            if ($result) {
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
        }

        return $data;
    }
}
?>