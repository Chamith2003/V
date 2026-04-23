let applications = [];

if (typeof applicationsData !== 'undefined' && applicationsData.length > 0) {
    applications = applicationsData.map(item => {
        const app = item.application || {};
        const user = item.user || {};
        const locations = item.locations || {};
        
        return {
            id: app.request_id || 0,
            profilePic: "/V/View/manager/approvereppost/resources/avatar-placeholder.png",
            fullName: user.name || 'Unknown',
            email: user.email || 'No email',
            contactNumber: user.contactnumber || 'No phone',
            levelPoints: locations.levelpoints || 0,
            starPoints: locations.starpoints || 0,
            primaryLocation: locations.preferred_location_1 || 'Not specified',
            secondaryLocation: locations.preferred_location_2 || 'Not specified',
            reason: app.description || 'No reason provided',
            professionalLinks: app.linkedin || 'Not provided',
            status: app.status || 'pending',
            appliedDate: app.date ? new Date(app.date).toISOString().split('T')[0] : 'Unknown'
        };
    });
}

let currentFilter = 'all';
let currentLocation = 'all';
let searchTerm = '';

function init() {
    renderApplications();
    updateStats();
    attachEventListeners();
}

function attachEventListeners() {
    document.querySelectorAll('.filter-btn[data-status]').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn[data-status]').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.status;
            renderApplications();
        });
    });

    document.getElementById('locationFilter').addEventListener('change', function() {
        currentLocation = this.value;
        if (currentLocation !== 'all') {
            this.classList.add('active');
        } else {
            this.classList.remove('active');
        }
        renderApplications();
    });

    document.getElementById('searchInput').addEventListener('input', function() {
        searchTerm = this.value.toLowerCase();
        renderApplications();
    });
}

function filterApplications() {
    return applications.filter(app => {
        const matchesStatus = currentFilter === 'all' || app.status === currentFilter;
        const matchesLocation = currentLocation === 'all' || 
            app.primaryLocation === currentLocation || 
            app.secondaryLocation === currentLocation;
        const matchesSearch = searchTerm === '' || 
            app.fullName.toLowerCase().includes(searchTerm) ||
            app.email.toLowerCase().includes(searchTerm) ||
            app.primaryLocation.toLowerCase().includes(searchTerm) ||
            app.secondaryLocation.toLowerCase().includes(searchTerm);
        
        return matchesStatus && matchesLocation && matchesSearch;
    });
}

function renderApplications() {
    const filteredApps = filterApplications();
    const listContainer = document.getElementById('applicationsList');

    if (filteredApps.length === 0) {
        listContainer.innerHTML = `
            <div class="no-results">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3>No applications found</h3>
                <p>Try adjusting your filters or search criteria</p>
            </div>
        `;
        return;
    }

    listContainer.innerHTML = filteredApps.map(app => `
        <div class="application-card">
            <div class="app-header">
                <img src="${app.profilePic}" alt="${app.fullName}" class="modal-profile-pic">
                <div class="app-info">
                    <h3>${app.fullName}</h3>
                    <div class="app-meta">
                        <span> ${app.email}</span>
                        <span> ${app.contactNumber}</span>
                        <span> Applied: ${app.appliedDate}</span>
                        <span> Level Points: ${app.levelPoints}</span>
                        <span> Star Points: ${app.starPoints}</span>
                    </div>
                </div>
                <span class="status-badge status-${app.status}">${app.status}</span>
            </div>

            <div class="app-details">
                <div class="detail-group">
                    <h4>Primary Location</h4>
                    <p> ${app.primaryLocation}</p>
                </div>
                <div class="detail-group">
                    <h4>Secondary Location</h4>
                    <p> ${app.secondaryLocation}</p>
                </div>
                <div class="detail-group">
                    <h4>Reason for Application</h4>
                    <p>${app.reason.substring(0, 100)}...</p>
                </div>
            </div>

            <div class="app-actions">
                <button class="btn btn-view" onclick="viewApplication(${app.id})">
                        View Full Details
                </button>
                ${app.status === 'pending' ? `
                    <button class="btn btn-approve" onclick="approveApplication(${app.id})">
                        ✓ Approve
                    </button>
                    <button class="btn btn-reject" onclick="rejectApplication(${app.id})">
                        ✕ Reject
                    </button>
                ` : ''}
            </div>
        </div>
    `).join('');
}

function updateStats() {
    document.getElementById('totalCount').textContent = applications.length;
    document.getElementById('pendingCount').textContent = applications.filter(a => a.status === 'pending').length;
    document.getElementById('approvedCount').textContent = applications.filter(a => a.status === 'approved').length;
    document.getElementById('rejectedCount').textContent = applications.filter(a => a.status === 'rejected').length;
}

function viewApplication(id) {
    const app = applications.find(a => a.id === id);
    if (!app) return;

    document.getElementById('modalTitle').textContent = app.fullName;
    document.getElementById('modalSubtitle').textContent = `Application ID: ${app.id} • Applied: ${app.appliedDate}`;

    document.getElementById('modalBody').innerHTML = `
        <div class="modal-section">
            <h3>Personal Information</h3>
            <div class="modal-grid">
                <img src="${app.profilePic}" alt="${app.fullName}" class="modal-profile-pic">
                <div class="modal-field">
                    <label>Full Name</label>
                    <div class="value">${app.fullName}</div>
                </div>
                <div class="modal-field">
                    <label>Email Address</label>
                    <div class="value">${app.email}</div>
                </div>
                <div class="modal-field">
                    <label>Contact Number</label>
                    <div class="value">${app.contactNumber}</div>
                </div>
                <div class="modal-field">
                    <label>Level Points</label>
                    <div class="value">${app.levelPoints}</div>
                </div>
                <div class="modal-field">
                    <label>Star Points</label>
                    <div class="value">${app.starPoints}</div>
                </div>
                <div class="modal-field">
                    <label>Current Status</label>
                    <div class="value"><span class="status-badge status-${app.status}">${app.status}</span></div>
                </div>
            </div>
        </div>

        <div class="modal-section">
            <h3>Location Information</h3>
            <div class="modal-grid">
                <div class="modal-field">
                    <label>Primary Location</label>
                    <div class="value"> ${app.primaryLocation}</div>
                </div>
                <div class="modal-field">
                    <label>Secondary Location</label>
                    <div class="value"> ${app.secondaryLocation}</div>
                </div>
            </div>
        </div>

        <div class="modal-section">
            <h3>Application Details</h3>
            <div class="modal-field">
                <label>Reason for Application</label>
                <div class="value">${app.reason}</div>
            </div>
            <div class="modal-field">
                <label>Professional Links</label>
                <div class="value">
                    ${app.professionalLinks !== 'Not provided' ? 
                        `<a href="https://${app.professionalLinks}" target="_blank" class="link-button">🔗 ${app.professionalLinks}</a>` :
                        'Not provided'
                    }
                </div>
            </div>
        </div>
    `;

    document.getElementById('modalFooter').innerHTML = `
        ${app.status === 'pending' ? `
            <button class="btn btn-approve" onclick="approveApplication(${app.id})">
                ✓ Approve Application
            </button>
            <button class="btn btn-reject" onclick="rejectApplication(${app.id})">
                ✕ Reject Application
            </button>
        ` : ''}
        <button class="btn btn-secondary" onclick="closeModal()">Close</button>
    `;

    document.getElementById('applicationModal').classList.add('active');
}

function closeModal() {
    document.getElementById('applicationModal').classList.remove('active');
}

function approveApplication(id) {
    if (confirm('Are you sure you want to APPROVE this application?\n\nThe user will be granted representative role.')) {
        window.location.href = `/V/router.php?module=manager&action=approveApplication&id=${id}`;
    }
}

function rejectApplication(id) {
    if (confirm('Are you sure you want to REJECT this application?\n\nThis action will mark the application as rejected.')) {
        window.location.href = `/V/router.php?module=manager&action=rejectApplication&id=${id}`;
    }
}

function updateStatus(id, newStatus) {
    if (newStatus === 'approved') {
        approveApplication(id);
    } else if (newStatus === 'rejected') {
        rejectApplication(id);
    }
}

document.getElementById('applicationModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

init();