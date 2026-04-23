<!DOCTYPE html>
<html>
<head>
    <title>V</title>
    <!-- <link rel="stylesheet" type="text/css" href="budget-approve.css"> -->
    <link rel="stylesheet" type="text/css" href="/V/View/representative/orgrep/orgrepbudgetapprove/orgrepbudgetapprove.css">
  <?php include __DIR__ . '/../../../navbar/navbar.php'; ?>
</head>
<body>
    <!-- <1?php include '../navbar/navbar.php'; ?> -->
    <div class="mainContent">
        <div class="header">
            <!-- <div class="header-icon">💰</div> -->
            <h1>Budget Allocation Approval</h1>
            <p>Review and approve budget requests requiring your authorization</p>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs-container">
            <nav class="filter-tabs">
                <a href="?filter=all" class="tab active">All Requests</a>
                <a href="?filter=pending" class="tab">Pending</a>
                <a href="?filter=approved" class="tab">Approved</a>
                <a href="?filter=rejected" class="tab">Rejected</a>
            </nav>
        </div>

        <!-- Requests List -->
        <div class="requests-container">
            <div id="requestsList">
                <!-- Sample Request 1 - Pending -->
                <div class="request-card" data-status="pending" data-event="treeplanting" data-amount="5000">
                    <div class="request-header">
                        <div class="request-info">
                            <h3>Hashini Gayathri</h3>
                            <div class="request-meta">
                                Submitted: January 15, 2024 • hashini.gayathri@email.com
                            </div>
                        </div>
                        <span class="status-badge status-pending">Pending</span>
                    </div>
                    
                    <div class="request-details">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Event Type</div>
                                <div class="detail-value">Tree Planting</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Requested Budget</div>
                                <div class="detail-value amount-highlight">LKR 5,000.00</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Request ID</div>
                                <div class="detail-value">#BR-001234</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Priority</div>
                                <div class="detail-value">Medium</div>
                            </div>
                        </div>
                    </div>

                    <div class="button-group">
                        <button class="btn btn-primary" onclick="approveBudget('BR-001234')">
                            ✓ Approve
                        </button>
                        <button class="btn btn-secondary" onclick="rejectBudget('BR-001234')" style="background: #e74c3c; color: white;">
                            ✗ Reject
                        </button>
                        <!-- <button class="btn btn-secondary" onclick="viewDetails('BR-001234')">
                            👁 View Details
                        </button> -->
                    </div>
                </div>

                <!-- Sample Request 2 - Pending -->
                <div class="request-card" data-status="pending" data-event="coralrestoration" data-amount="25000">
                    <div class="request-header">
                        <div class="request-info">
                            <h3>Newandi Samithna</h3>
                            <div class="request-meta">
                                Submitted: January 14, 2024 • newandi.samithna@gmail.com
                            </div>
                        </div>
                        <span class="status-badge status-pending">Pending</span>
                    </div>
                    
                    <div class="request-details">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Event Type</div>
                                <div class="detail-value">Coral Restoration</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Requested Budget</div>
                                <div class="detail-value amount-highlight">LKR 25,000.00</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Request ID</div>
                                <div class="detail-value">#BR-001235</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Priority</div>
                                <div class="detail-value">High</div>
                            </div>
                        </div>
                    </div>

                    <div class="button-group">
                        <button class="btn btn-primary" onclick="approveBudget('BR-001235')">
                            ✓ Approve
                        </button>
                        <button class="btn btn-secondary" onclick="rejectBudget('BR-001235')" style="background: #e74c3c; color: white;">
                            ✗ Reject
                        </button>
                        <!-- <button class="btn btn-secondary" onclick="viewDetails('BR-001235')">
                            👁 View Details
                        </button> -->
                    </div>
                </div>

                <!-- Sample Request 3 - Approved -->
                <div class="request-card" data-status="approved" data-event="beachcleanup" data-amount="1500">
                    <div class="request-header">
                        <div class="request-info">
                            <h3>Leo Club of UOC</h3>
                            <div class="request-meta">
                                Submitted: January 12, 2024 • leo.uoc@email.com
                            </div>
                        </div>
                        <span class="status-badge status-approved">Approved</span>
                    </div>
                    
                    <div class="request-details">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Event Type</div>
                                <div class="detail-value">Beach Cleanup</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Requested Budget</div>
                                <div class="detail-value amount-highlight">LKR 1,500.00</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Request ID</div>
                                <div class="detail-value">#BR-001236</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Approval Date</div>
                                <div class="detail-value">January 16, 2024</div>
                            </div>
                        </div>
                    </div>

                    <div class="button-group">
                        <button class="btn btn-secondary" onclick="revokeApproval('BR-001236')" style="background: #f39c12; color: white;">
                            ↩ Revoke
                        </button>
                        <!-- <button class="btn btn-secondary" onclick="viewDetails('BR-001236')">
                            👁 View Details
                        </button> -->
                    </div>
                </div>

                <!-- Sample Request 4 - Rejected -->
                <div class="request-card" data-status="rejected" data-event="cleanup" data-amount="800">
                    <div class="request-header">
                        <div class="request-info">
                            <h3>Environmental Society</h3>
                            <div class="request-meta">
                                Submitted: January 10, 2024 • env.society@email.com 
                            </div>
                        </div>
                        <span class="status-badge status-rejected">Rejected</span>
                    </div>
                    
                    <div class="request-details">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Event Type</div>
                                <div class="detail-value">Community Cleanup</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Requested Budget</div>
                                <div class="detail-value amount-highlight">LKR 800.00</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Request ID</div>
                                <div class="detail-value">#BR-001237</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Rejection Reason</div>
                                <div class="detail-value">Budget exceeded monthly limit</div>
                            </div>
                        </div>
                    </div>

                    <div class="button-group">
                        <button class="btn btn-primary" onclick="reconsiderRequest('BR-001237')" style="background: #f39c12;">
                            🔄 Reconsider
                        </button>
                        <!-- <button class="btn btn-secondary" onclick="viewDetails('BR-001237')">
                            👁 View Details
                        </button> -->
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <!-- <div class="pagination">
                <button class="page-btn" onclick="changePage(1)">‹‹</button>
                <button class="page-btn" onclick="changePage('prev')">‹</button>
                <button class="page-btn active">1</button>
                <button class="page-btn" onclick="changePage(2)">2</button>
                <button class="page-btn" onclick="changePage(3)">3</button>
                <button class="page-btn" onclick="changePage('next')">›</button>
                <button class="page-btn" onclick="changePage('last')">››</button>
            </div> -->
        </div>
    </div>

       <script src="/V/View/representative/orgrep/orgrepbudgetapprove/orgrepbudgetapprove.js"></script> 

</body>
</html>