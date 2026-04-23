<!DOCTYPE html>
<html>
<head>
    <title>V</title>
    <!-- <link rel="stylesheet" type="text/css" href="budget-approve.css"> -->
    <link rel="stylesheet" type="text/css" href="/V/View/manager/budgetapprove/budgetapprove.css">
         <?php include __DIR__ . '/../navbar/navbar.php'; ?>
</head>
<body>
    <!-- <1?php include '../navbar/navbar.php'; ?> -->
    <div class="mainContent">
        <div class="header">
            <!-- <div class="header-icon">💰</div> -->
            <h1>Annual Event Budget Allocation</h1>
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

    <script>
        // Sample data for demonstration
        let currentPage = 1;

        // Tab functionality
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all tabs
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                // Filter requests based on tab
                const filter = new URL(this.href).searchParams.get('filter') || 'all';
                filterRequests(filter);
            });
        });

        function filterRequests(filter) {
            const requestCards = document.querySelectorAll('.request-card');
            
            requestCards.forEach(card => {
                const statusBadge = card.querySelector('.status-badge');
                let shouldShow = true;
                
                if (filter === 'pending' && !statusBadge.textContent.toLowerCase().includes('pending')) {
                    shouldShow = false;
                } else if (filter === 'approved' && !statusBadge.textContent.toLowerCase().includes('approved')) {
                    shouldShow = false;
                } else if (filter === 'rejected' && !statusBadge.textContent.toLowerCase().includes('rejected')) {
                    shouldShow = false;
                }
                
                if (shouldShow) {
                    card.style.display = 'block';
                    card.style.animation = 'slideInUp 0.5s ease forwards';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function approveBudget(requestId) {
            if (confirm(`Are you sure you want to approve budget request ${requestId}?`)) {
                console.log(`Approving budget request: ${requestId}`);
                
                // Update UI immediately for demo
                const card = document.querySelector(`[onclick*="${requestId}"]`).closest('.request-card');
                const statusBadge = card.querySelector('.status-badge');
                statusBadge.textContent = 'Approved';
                statusBadge.className = 'status-badge status-approved';
                card.dataset.status = 'approved';
                
                // Update action buttons
                // <button class="btn btn-secondary" onclick="viewDetails('${requestId}')">👁 View Details</button>
                const buttonGroup = card.querySelector('.button-group');
                buttonGroup.innerHTML = `
                    
                    <button class="btn btn-secondary" onclick="revokeApproval('${requestId}')" style="background: #f39c12; color: white;">↩ Revoke</button>
                `;

                showSuccessMessage('Budget request approved successfully!');
            }
        }

        function rejectBudget(requestId) {
            const reason = prompt('Please provide a reason for rejection:');
            if (reason) {
                console.log(`Rejecting budget request: ${requestId}, Reason: ${reason}`);
                
                // Update UI immediately for demo
                const card = document.querySelector(`[onclick*="${requestId}"]`).closest('.request-card');
                const statusBadge = card.querySelector('.status-badge');
                statusBadge.textContent = 'Rejected';
                statusBadge.className = 'status-badge status-rejected';
                card.dataset.status = 'rejected';
                
                // Update action buttons
                // <button class="btn btn-secondary" onclick="viewDetails('${requestId}')">👁 View Details</button>
                const buttonGroup = card.querySelector('.button-group');
                buttonGroup.innerHTML = `
                    
                    <button class="btn btn-primary" onclick="reconsiderRequest('${requestId}')" style="background: #f39c12;">🔄 Reconsider</button>
                `;

                showSuccessMessage('Budget request rejected successfully!');
            }
        }

        function viewDetails(requestId) {
            // In real implementation, this would redirect to a detailed view page
            alert(`Viewing detailed information for budget request ${requestId}\n\nThis would typically redirect to a detailed view with:\n- Full budget breakdown\n- Event details\n- Requester information\n- Supporting documents\n- Approval history`);
        }

        function revokeApproval(requestId) {
            if (confirm(`Are you sure you want to revoke approval for budget request ${requestId}?`)) {
                console.log(`Revoking approval for: ${requestId}`);
                
                // Update UI immediately for demo
                const card = document.querySelector(`[onclick*="${requestId}"]`).closest('.request-card');
                const statusBadge = card.querySelector('.status-badge');
                statusBadge.textContent = 'Pending';
                statusBadge.className = 'status-badge status-pending';
                card.dataset.status = 'pending';
                
                // Update action buttons
                // <button class="btn btn-secondary" onclick="viewDetails('${requestId}')">👁 View Details</button>
                const buttonGroup = card.querySelector('.button-group');
                buttonGroup.innerHTML = `
                    <button class="btn btn-primary" onclick="approveBudget('${requestId}')">✓ Approve</button>
                    <button class="btn btn-secondary" onclick="rejectBudget('${requestId}')" style="background: #e74c3c; color: white;">✗ Reject</button>
                    
                `;

                showSuccessMessage('Approval revoked successfully!');
            }
        }

        function reconsiderRequest(requestId) {
            if (confirm(`Are you sure you want to reconsider budget request ${requestId}?`)) {
                console.log(`Reconsidering request: ${requestId}`);
                
                // Update UI immediately for demo
                const card = document.querySelector(`[onclick*="${requestId}"]`).closest('.request-card');
                const statusBadge = card.querySelector('.status-badge');
                statusBadge.textContent = 'Pending';
                statusBadge.className = 'status-badge status-pending';
                card.dataset.status = 'pending';
                
                // Update action buttons
                // <button class="btn btn-secondary" onclick="viewDetails('${requestId}')">👁 View Details</button>
                const buttonGroup = card.querySelector('.button-group');
                buttonGroup.innerHTML = `
                    <button class="btn btn-primary" onclick="approveBudget('${requestId}')">✓ Approve</button>
                    <button class="btn btn-secondary" onclick="rejectBudget('${requestId}')" style="background: #e74c3c; color: white;">✗ Reject</button>
                    
                `;

                showSuccessMessage('Request moved to pending for reconsideration!');
            }
        }

        function showSuccessMessage(message) {
            // Create temporary success message
            const successDiv = document.createElement('div');
            successDiv.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #27ae60;
                color: white;
                padding: 15px 25px;
                border-radius: 8px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
                z-index: 1000;
                animation: slideInRight 0.3s ease;
            `;
            successDiv.textContent = message;
            document.body.appendChild(successDiv);

            // Remove after 3 seconds
            setTimeout(() => {
                successDiv.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => successDiv.remove(), 300);
            }, 3000);
        }

        function changePage(page) {
            // Pagination functionality - would be implemented with actual data
            console.log(`Changing to page: ${page}`);
            
            // Update active page button
            document.querySelectorAll('.page-btn').forEach(btn => btn.classList.remove('active'));
            if (typeof page === 'number') {
                const pageBtn = document.querySelector(`.page-btn:nth-child(${page + 2})`);
                if (pageBtn) pageBtn.classList.add('active');
            }
        }

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
            @keyframes slideInUp {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>