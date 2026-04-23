<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/V/View/globalstyles.css">
    <!-- <link rel="stylesheet" href="/V/View/sponsorship_request_approval_panel/sponsorship_request_approval_panel.css"> -->
     <link rel="stylesheet" type="text/css" href="/V/View/sponsor/incomingreq/reviewincomingreqspon.css">
    <title>V</title>
    <!-- <1?php include __DIR__ . '/../navbar/navbar.php'; ?> -->
                         <?php include __DIR__ . '/../../navbar/navbar.php'; ?>

    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-background">
        <div class="header">
            <h1 class="header-title">Sponsoring Requests Approval Panel</h1>
            <p class="header-subtitle">Review and manage sponsorship requests from organizers and managers</p>
        </div>

        <div class="container-applicationbackground">
            <div class="controls">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search by event name, organizer, or location...">
                    <span class="search-icon"></span>
                </div>
                
                <div class="filter-group">
                    <button class="filter-btn active" data-status="all">All</button>
                    <button class="filter-btn" data-status="pending">Pending</button>
                    <button class="filter-btn" data-status="accepted">Accepted</button>
                    <button class="filter-btn" data-status="rejected">Rejected</button>
                    
                    <select id="eventTypeFilter" class="filter-btn">
                        <option value="all">All Event Types</option>
                        <option value="City Cleanup">City Cleanup</option>
                        <option value="Mountain Cleanup">Mountain Cleanup</option>
                        <option value="Beach Cleanup">Beach Cleanup</option>
                        <option value="Mangrove Restoration">Mangrove Restoration</option>
                        <option value="Tree Planting">Tree Planting</option>
                        <option value="Coral Restoration">Coral Restoration</option>
                    </select>

                    <select id="amountFilter" class="filter-btn">
                        <option value="all">All Amounts</option>
                        <option value="0-50000">LKR0 - LKR50,000</option>
                        <option value="50000-100000">LKR50,000 - LKR100,000</option>
                        <option value="100000-150000">LKR100,000 - LKR150,000</option>
                        <option value="150000-9999999">LKR150,000+</option>
                    </select>
                </div>
            </div>

            <div class="stats">
                <div class="stat-card total">
                    <h3>Total Requests</h3>
                    <div class="number" id="totalCount">0</div>
                    <div class="subtitle" id="totalAmount">$0</div>
                </div>
                <div class="stat-card pending">
                    <h3>Pending Review</h3>
                    <div class="number" id="pendingCount">0</div>
                    <div class="subtitle" id="pendingAmount">$0</div>
                </div>
                <div class="stat-card accepted">
                    <h3>Accepted</h3>
                    <div class="number" id="acceptedCount">0</div>
                    <div class="subtitle" id="acceptedAmount">$0</div>
                </div>
                <div class="stat-card rejected">
                    <h3>Rejected</h3>
                    <div class="number" id="rejectedCount">0</div>
                    <div class="subtitle" id="rejectedAmount">$0</div>
                </div>
            </div>
</div>
            <div class="requests-list" id="requestsList">
                <!-- Requests will be rendered here -->
            </div>
        <!-- </div> -->

        <div class="modal" id="requestModal">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close-modal" onclick="closeModal()">&times;</button>
                    <h2 id="modalTitle">Event Details</h2>
                    <p id="modalSubtitle"></p>
                    <div class="modal-amount" id="modalAmount"></div>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- Details will be loaded here -->
                </div>
                <div class="modal-footer" id="modalFooter">
                    <!-- Actions will be loaded here -->
                </div>
            </div>
        </div>
    </div>
    <script src="/V/View/sponsor/incomingreq/reviewincomingreqspon.js"></script>
</body>
</html>