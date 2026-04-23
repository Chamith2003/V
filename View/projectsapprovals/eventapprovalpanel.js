let applications = [];

if (typeof eventsData !== 'undefined' && eventsData.length > 0) {
    applications = eventsData.map(event => {
        return {
            id: parseInt(event.event_id), 
            eventId: `EVT-${event.event_id}`,
            eventName: event.name,
            eventType: event.event_type,
            eventDescription: event.description || 'No description provided',
            eventDate: event.event_date,
            location: event.location,
            scale: event.scale || 'medium',
            participantCount: event.max_participants,
            eventCost: event.allocated_budget || 0,  
            organizer: event.organizer_name,
            applicationDate: event.createddate,
            duration: event.duration || 'N/A',
            starpoints: event.starpoints_reward || 0,  
            levelpoints: event.levelpoints_reward || 0, 
            time: event.time || 'N/A',
            gmapLink: event.gmap_link,
            status: event.isauthorized === null ? 'pending' : 
                    (event.isauthorized == 1 ? 'approved' : 'rejected')
        };
    });
}

let currentFilter = 'all';
let currentEventType = 'all';
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

    document.getElementById('eventTypeFilter').addEventListener('change', function() {
        currentEventType = this.value;
        if (currentEventType !== 'all') {
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
        const matchesEventType = currentEventType === 'all' || app.eventType === currentEventType;
        const matchesSearch = searchTerm === '' || 
            app.eventName.toLowerCase().includes(searchTerm) ||
            app.organizer.toLowerCase().includes(searchTerm) ||
            app.location.toLowerCase().includes(searchTerm) ||
            app.eventId.toLowerCase().includes(searchTerm);
        
        return matchesStatus && matchesEventType && matchesSearch;
    });
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('en-LK', {
        style: 'currency',
        currency: 'LKR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount);
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
        updateStats();
        return;
    }

    listContainer.innerHTML = filteredApps.map(app => `
        <div class="application-card">
            <div class="app-header">
                <div class="app-info">
                    <div class="event-id">${app.eventId}</div>
                    <h3>${app.eventName}</h3>
                    <div class="app-meta">
                        <span> ${app.eventDate}</span>
                        <span> ${app.location}</span>
                        <span> ${app.participantCount} volunteers</span>
                        <span class="event-type-badge type-${app.eventType.toLowerCase().replace(/ /g, '-')}">${app.eventType}</span>
                        <span class="scale-indicator scale-${app.scale.toLowerCase()}"> ${app.scale} Scale</span>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 10px; align-items: flex-end;">
                    <div class="cost-badge"> ${formatCurrency(app.eventCost)}</div>
                    <span class="status-badge status-${app.status}">${app.status}</span>
                </div>
            </div>

            <div class="description-preview">
                <p>${app.eventDescription.substring(0, 200)}...</p>
            </div>

            <div class="app-details">
                <div class="detail-group">
                    <h4>Organizer</h4>
                    <p> ${app.organizer}</p>
                </div>
                <div class="detail-group">
                    <h4>Application Date</h4>
                    <p> ${app.applicationDate}</p>
                </div>
                <div class="detail-group">
                    <h4>Expected Volunteers</h4>
                    <p> ${app.participantCount} volunteers needed</p>
                </div>
            </div>

            <div class="app-actions">
                <button class="btn btn-view" onclick="viewApplication(${app.id})">
                    View Full Details
                </button>
                ${app.status === 'pending' ? `
                    <button class="btn btn-approve" onclick="updateStatus(${app.id}, 'approved')">
                        ✓ Approve Event
                    </button>
                    <button class="btn btn-reject" onclick="updateStatus(${app.id}, 'rejected')">
                        ✕ Reject Event
                    </button>
                ` : ''}
            </div>
        </div>
    `).join('');

    updateStats();
}

function updateStats() {
    const filteredApps = filterApplications();
    
    const totalCount = filteredApps.length;
    const pendingCount = filteredApps.filter(app => app.status === 'pending').length;
    const approvedCount = filteredApps.filter(app => app.status === 'approved').length;
    const rejectedCount = filteredApps.filter(app => app.status === 'rejected').length;
    
    document.getElementById('totalCount').textContent = totalCount;
    document.getElementById('pendingCount').textContent = pendingCount;
    document.getElementById('approvedCount').textContent = approvedCount;
    document.getElementById('rejectedCount').textContent = rejectedCount;
    
}

function updateStatus(id, newStatus) {
    if (newStatus === 'approved') {
        if (confirm('Are you sure you want to APPROVE this event?\n\nThe event will be authorized and visible to volunteers.')) {
            window.location.href = `/V/router.php?module=projects&action=approveEvent&id=${id}`;
        }
    } else if (newStatus === 'rejected') {
        if (confirm('Are you sure you want to REJECT this event?\n\nThis action will mark the event as unauthorized.')) {
            window.location.href = `/V/router.php?module=projects&action=rejectEvent&id=${id}`;
        }
    }
}

function viewApplication(id) {
    const app = applications.find(a => a.id === id);
    if (!app) return;

    document.getElementById('modalTitle').textContent = app.eventName;
    document.getElementById('modalSubtitle').textContent = `Organized by ${app.organizer} • Applied on ${new Date(app.applicationDate).toLocaleDateString()}`;
    document.getElementById('modalCost').textContent = `Estimated Cost: ${formatCurrency(app.eventCost)}`;

    const modalBody = document.getElementById('modalBody');
    modalBody.innerHTML = `
        <div class="modal-section">
            <h3>Event Information</h3>
            <div class="modal-grid">
                <div class="modal-field">
                    <label>Event ID:</label>
                    <span>${app.eventId}</span>
                </div>
                <div class="modal-field">
                    <label>Event Type:</label>
                    <span>${app.eventType}</span>
                </div>
                <div class="modal-field">
                    <label>Event Date:</label>
                    <span>${new Date(app.eventDate).toLocaleDateString()}</span>
                </div>
                <div class="modal-field">
                    <label>Location:</label>
                    <span>${app.location}</span>
                    ${app.gmapLink ? `<a href="${app.gmapLink}" target="_blank" class="btn btn-map" style="margin-top: 8px; display: inline-block; padding: 6px 12px; background: #4F958A; color: white; text-decoration: none; border-radius: 20px; font-size: 13px;">View on Google Maps</a>` : ''}
                </div>
                <div class="modal-field">
                    <label>Scale:</label>
                    <span>${app.scale}</span>
                </div>
                <div class="modal-field">
                    <label>Max Participants:</label>
                    <span>${app.participantCount}</span>
                </div>
                <div class="modal-field">
                    <label>Duration(hours):</label>
                    <span>${app.duration || 'N/A'}</span>
                </div>
            </div>
        </div>

        <div class="modal-section">
            <h3>Description</h3>
            <p>${app.eventDescription}</p>
        </div>

        <div class="modal-section">
            <h3>Rewards</h3>
            <div class="modal-grid">
                <div class="modal-field">
                    <label>Star Points:</label>
                    <span>${app.starpoints || 0}</span>
                </div>
                <div class="modal-field">
                    <label>Level Points:</label>
                    <span>${app.levelpoints || 0}</span>
                </div>
            </div>
        </div>

        <div class="modal-section">
            <h3>Organizer Information</h3>
            <div class="modal-grid">
                <div class="modal-field">
                    <label>Name:</label>
                    <span>${app.organizer}</span>
                </div>
                <div class="modal-field">
                    <label>Application Date:</label>
                    <span>${new Date(app.applicationDate).toLocaleDateString()}</span>
                </div>
            </div>
        </div>

        <div class="modal-section">
            <h3>Current Status</h3>
            <div class="value">
                <span class="status-badge status-${app.status}">
                    ${app.status.charAt(0).toUpperCase() + app.status.slice(1)}
                </span>
            </div>
        </div>
    `;

    const modalFooter = document.getElementById('modalFooter');
    
    if (app.status === 'pending') {
        modalFooter.innerHTML = `
            <button class="btn btn-secondary" onclick="closeModal()">Close</button>
            <button class="btn btn-reject" onclick="updateStatus(${app.id}, 'rejected')">Reject Event</button>
            <button class="btn btn-approve" onclick="updateStatus(${app.id}, 'approved')">Approve Event</button>
        `;
    } else {
        modalFooter.innerHTML = `
            <button class="btn btn-secondary" onclick="closeModal()">Close</button>
        `;
    }

    document.getElementById('applicationModal').classList.add('active');
}

function closeModal() {
    document.getElementById('applicationModal').classList.remove('active');
}

document.getElementById('applicationModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

init();

window.testModal = function() {
    if (applications.length > 0) {
        console.log('Testing with first application:', applications[0]);
        viewApplication(applications[0].id);
    } else {
        console.error('No applications found');
    }
};