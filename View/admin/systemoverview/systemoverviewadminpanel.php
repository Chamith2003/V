<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/V/View/globalstyles.css">
    <!-- <link rel="stylesheet" href="/V/View/admin/system_overview_admin_panel.css"> -->
    <title>V</title>
    <!-- <1?php include __DIR__ . '/../navbar/navbar.php'; ?> -->
    <link rel="stylesheet" type="text/css" href="/V/View/admin/systemoverview/systemoverviewadminpanel.css">
  <?php include __DIR__ . '/../../navbar/navbar.php'; ?>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>
    <div class="overview-container">
        <div class="overview-header">
            <h1>System Overview</h1>
            <p>Comprehensive analytics and insights of platform's performance and growth</p>
            
            <div class="header-actions">
                <button class="btn" onclick="refreshData()">
                    <span></span> Refresh Data
                </button>
                <button class="btn" onclick="openReportModal()">
                    <span></span> Generate Report
                </button>
            </div>
        </div>

        <div class="container-applicationbackground">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-info">
                            <div class="stat-label">Total Users</div>
                            <div class="stat-value" id="totalUsers">0</div>
                            <div class="stat-change positive">
                                <span id="usersChange">0%</span> vs last month
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-info">
                            <div class="stat-label">Total Events</div>
                            <div class="stat-value" id="totalEvents">0</div>
                            <div class="stat-change positive">
                                <span id="eventsChange">0%</span> vs last month
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-info">
                            <div class="stat-label">Sponsors</div>
                            <div class="stat-value" id="totalSponsors">0</div>
                            <div class="stat-change positive">
                                <span id="sponsorsChange">0%</span> vs last month
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-info">
                            <div class="stat-label">Participants</div>
                            <div class="stat-value" id="totalParticipants">0</div>
                            <div class="stat-change positive">
                                <span id="participantsChange">0%</span> vs last month
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="chart-section">
                <div class="section-header">
                    <h3 class="section-title">
                        Monthly Participation Trends
                    </h3>
                    <div class="filter-group">
                        <button class="filter-btn active" onclick="updateTrendPeriod('6months')">6 Months</button>
                        <button class="filter-btn" onclick="updateTrendPeriod('year')">1 Year</button>
                        <button class="filter-btn" onclick="updateTrendPeriod('all')">All Time</button>
                    </div>
                </div>
                <div class="chart-container chart-container-large">
                    <canvas id="participationChart"></canvas>
                </div>
            </div>

            <div class="chart-grid">
                <div class="chart-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            Most Active Cities
                        </h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="citiesChart"></canvas>
                    </div>
                </div>

                <div class="chart-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            Event Categories
                        </h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="categoriesChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="chart-grid">
                <div class="chart-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            Top Volunteers
                        </h3>
                    </div>
                    <ul class="top-list" id="topVolunteersList">
                    </ul>
                </div>

                <div class="chart-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            Top Sponsors
                        </h3>
                    </div>
                    <ul class="top-list" id="topSponsorsList">
                    </ul>
                </div>
            </div>

            <div class="chart-section">
                <div class="section-header">
                    <h3 class="section-title">
                        System Activity & Growth Over Time
                    </h3>
                </div>
                <div class="chart-container chart-container-large">
                    <canvas id="growthChart"></canvas>
                </div>
            </div>

            <div class="chart-section">
                <div class="section-header">
                    <h3 class="section-title">
                        Recent System Activity
                    </h3>
                </div>
                <div class="activity-feed" id="activityFeed">
                </div>
            </div>
        </div>
    </div>
    <script>
    const systemData = <?php echo json_encode($stats); ?>;
    const monthlyData = <?php echo json_encode($monthlyData); ?>;
    const monthlyDataYear = <?php echo json_encode($monthlyDataYear); ?>;
    const monthlyDataAllTime = <?php echo json_encode($monthlyDataAllTime); ?>;
    const citiesData = <?php echo json_encode($citiesData); ?>;
    const categoriesData = <?php echo json_encode($categoriesData); ?>;
    const topVolunteers = <?php echo json_encode($topVolunteers); ?>;
    const topSponsors = <?php echo json_encode($topSponsors); ?>;
    const growthData = <?php echo json_encode($growthData); ?>;
    const recentActivities = <?php echo json_encode($recentActivities); ?>;
    </script>
    <div id="reportModal" class="report-modal">
        <div class="report-modal-content">
            <div class="report-modal-header">
                <h2>Generate Custom Report</h2>
                <span class="report-close-btn" onclick="closeReportModal()">&times;</span>
            </div>
            <div class="report-modal-body">
                <form id="reportForm" action="/V/router.php?module=admin&action=generatereport" method="POST">
                    
                    <div class="form-group">
                        <label>Report Type</label>
                        <select name="report_type" id="reportTypeSelect" onchange="toggleReportOptions()" required>
                            <option value="">-- Select Report Type --</option>
                            <option value="events">Event Related</option>
                            <option value="volunteers">Volunteer Related</option>
                            <option value="sponsors">Sponsor Related</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Date Range</label>
                        <div class="date-flex">
                            <input type="date" name="from_date" id="reportFromDate" required>
                            <span>to</span>
                            <input type="date" name="to_date" id="reportToDate" required>
                        </div>
                    </div>

                    <div class="form-group report-options" id="options-events" style="display: none;">
                        <label>Event Metrics</label>
                        <div class="checkbox-group">
                            <label><input type="checkbox" name="options[]" value="attendance"> Attendance</label>
                            <label><input type="checkbox" name="options[]" value="tasks"> Tasks</label>
                        </div>
                    </div>

                    <div class="form-group report-options" id="options-volunteers" style="display: none;">
                        <label>Volunteer Metrics</label>
                        <div class="checkbox-group">
                            <label><input type="checkbox" name="options[]" value="hours"> Volunteer Hours</label>
                            <label><input type="checkbox" name="options[]" value="levelpoints"> Level Points Earned</label>
                            <label><input type="checkbox" name="options[]" value="starpoints"> Star Points Earned</label>
                            <label><input type="checkbox" name="options[]" value="new_hires"> Joined Date</label>
                        </div>
                    </div>

                    <div class="form-group report-options" id="options-sponsors" style="display: none;">
                        <label>Sponsor Metrics</label>
                        <div class="checkbox-group">
                            <label><input type="checkbox" name="options[]" value="donations"> Donation Sums</label>
                            <label><input type="checkbox" name="options[]" value="sponsorships"> Number of Sponsorships</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Export Format</label>
                        <select name="export_format" required>
                            <option value="html">HTML / PDF View</option>
                        </select>
                    </div>

                </form>
            </div>
            <div class="report-modal-footer">
                <button type="button" class="btn btn-cancel" onclick="closeReportModal()">Cancel</button>
                <button type="submit" form="reportForm" class="btn btn-generate">Generate Report</button>
            </div>
        </div>
    </div>
    <script src="/V/View/admin/systemoverview/systemoverviewadminpanel.js"></script>
</body>
</html>
