<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/V/View/globalstyles.css">
    <link rel="stylesheet" href="/V/View/sponsor/sponsoractivity/sponsoractivity.css">
    <title>V</title>
    <!-- <1?php include __DIR__ . '/../navbar/navbar.php'; ?> -->
          <?php include __DIR__ . '/../../navbar/navbar.php'; ?>

    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-background">
        <div class="hero">
            <div class="hero-content">
                <div>
                    <h2>Sponsorship Activity</h2>
                    <p>Support meaningful causes and make a lasting impact in your community. Partner with organizations creating positive change through volunteering events.</p>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="hero-stat-number">LKR 25,000</span>
                        <span class="hero-stat-label">Total Funding Raised</span>
                    </div>
                    <div class="hero-stat">
                        <span class="hero-stat-number">156</span>
                        <span class="hero-stat-label">Active Opportunities</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-applicationbackground">
            <div class="search-filter-section">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search events by name, organizer, or location...">
                </div>
                
                <div class="quick-filters">
                    <select id="eventTypeFilter" class="filter-select">
                        <option value="all">All Event Types</option>
                        <option value="Beach Cleanup"> Beach Cleanup</option>
                        <option value="City Cleanup"> City Cleanup</option>
                        <option value="Mangrove Restoration"> Mangrove Restoration</option>
                        <option value="Tree Planting"> Tree Planting</option>
                         <option value="Coral Restoration"> Coral Restoration</option>
                          <option value="Mountain Cleanup"> Mountain Cleanup</option>
                    </select>
                </div>
            </div>

            <div class="content-wrapper">
                <div class="events-section">
                    <div class="section-header">
                        <h2 class="section-title">Available Opportunities</h2>
                        <span class="results-count" id="resultsCount">0 opportunities</span>
                    </div>
                    <div id="eventsList">
                        <!-- Events will be rendered here -->
                    </div>
                </div>

                <div class="sponsor-sidebar">
                    <div class="sidebar-card">
                        <h3 class="sidebar-title"> Featured Opportunities</h3>
                        <div id="featuredEvents">
                            <!-- Featured events will be rendered here -->
                        </div>
                    </div>

                    <div class="sidebar-card">
                        <h3 class="sidebar-title"> Sponsorship Impact</h3>
                        <div class="stats-grid">
                            <div class="stat-box">
                                <span class="stat-number" id="requestedCount">0</span>
                                <span class="stat-label">Sponsored</span>
                            </div>
                            <div class="stat-box">
                                <span class="stat-number" id="totalInvested">$0</span>
                                <span class="stat-label">Total Investment</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/V/View/sponsor/sponsoractivity/sponsoractivity.js"></script>
</body>
</html>
                