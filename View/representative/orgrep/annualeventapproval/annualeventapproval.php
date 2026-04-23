<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annual Event Approvals</title>
    <link rel="stylesheet" type="text/css" href="/V/View/globalstyles.css">
    <link rel="stylesheet" type="text/css"
        href="/V/View/representative/orgrep/annualeventapproval/annualeventapproval.css">
    <?php include __DIR__ . '/../../../navbar/navbar.php'; ?>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container-background">
        <div class="header">
            <h1 class="header-title">Annual Event Approvals</h1>
            <p class="header-subtitle">Review annual events requiring your approval</p>
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
                    <button class="filter-btn" data-status="approved">Approved</button>
                    <button class="filter-btn" data-status="rejected">Rejected</button>
                    <select id="eventTypeFilter" class="filter-btn"
                        style="padding: 10px; border-radius: 8px; border: 2px solid #e0e0e0;">
                        <option value="all">All Event Types</option>
                        <option value="City Cleanup">City Cleanup</option>
                        <option value="Mangrove Restoration">Mangrove Restoration</option>
                        <option value="Coral Restoration">Coral Restoration</option>
                        <option value="Mountain Cleanup">Mountain Cleanup</option>
                        <option value="Tree Planting">Tree Planting</option>
                        <option value="Beach Cleanup">Beach Cleanup</option>
                    </select>
                </div>
            </div>

            <div class="stats">
                <div class="stat-card total">
                    <h3>Total Applications</h3>
                    <div class="number" id="totalCount">0</div>
                </div>
                <div class="stat-card pending">
                    <h3>Pending Review</h3>
                    <div class="number" id="pendingCount">0</div>
                </div>
                <div class="stat-card approved">
                    <h3>Approved</h3>
                    <div class="number" id="approvedCount">0</div>
                </div>
                <div class="stat-card rejected">
                    <h3>Rejected</h3>
                    <div class="number" id="rejectedCount">0</div>
                </div>
            </div>
        </div>
        <div class="applications-list" id="applicationsList">
            <?php if (empty($events)): ?>
                <div class="no-events">
                    <p>No pending annual events requiring your approval.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="modal" id="applicationModal">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close-modal" onclick="closeModal()">&times;</button>
                <h2 id="modalTitle">Event Details</h2>
                <p id="modalSubtitle"></p>
                <div class="modal-cost" id="modalCost"></div>
            </div>
            <div class="modal-body" id="modalBody">
            </div>
            <div class="modal-footer" id="modalFooter">
            </div>
        </div>
    </div>
    </div>

    <script>
        const eventsData = <?php echo json_encode($events ?? []); ?>;
    </script>
    <script src="/V/View/representative/orgrep/annualeventapproval/annualeventapproval.js"></script>

    <?php if (isset($_SESSION['message'])): ?>
        <script>
            alert("<?php echo $_SESSION['message']; ?>");
            <?php unset($_SESSION['message']); ?>
        </script>
    <?php endif; ?>
</body>

</html>