
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
                //<button class="btn btn-secondary" onclick="viewDetails('${requestId}')">👁 View Details</button>
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
    