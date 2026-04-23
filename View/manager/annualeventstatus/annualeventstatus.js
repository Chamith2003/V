let applications = [];

if (typeof eventsData !== 'undefined' && eventsData.length > 0) {
    applications = eventsData.map(event => {
        let status = 'pending';
        let statusText = 'Pending';

        let approvalCount = parseInt(event.approval_count || 0);
        let rejectionCount = parseInt(event.rejection_count || 0);
        let approvalDetails = event.approval_details || '';

        if (event.isauthorized == 1) {
            status = 'approved';
            statusText = 'Authorized';
        } else if (event.isauthorized === '0' || event.isauthorized === 0) {
            status = 'rejected';
            statusText = 'Rejected';
            if (approvalDetails) {
                statusText += ` (${approvalDetails})`;
            }
        } else {
            if ((rejectionCount >= 1 && approvalCount >= 1) || rejectionCount >= 2) {
                status = 'rejected';
                statusText = `Rejected (${approvalDetails})`;
            } else if (rejectionCount > 0 || approvalCount > 0) {
                status = 'pending';
                if (approvalDetails) {
                    statusText = `Pending - ${approvalDetails}`;
                } else {
                    statusText = `Pending (${approvalCount}/2 Approvals)`;
                }
            } else {
                status = 'pending';
                statusText = 'Pending (0/2 Approvals)';
            }
        }

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
            applicationDate: event.createddate || 'N/A',
            duration: event.duration || 'N/A',
            starpoints: event.starpoints_reward || 0,
            levelpoints: event.levelpoints_reward || 0,
            time: event.time || 'N/A',
            gmapLink: event.gmap_link,
            status: status,
            statusText: statusText
        };
    });
}

let searchTerm = '';
let currentFilter = 'all';

function init() {
    renderApplications();
    updateStats();
    attachEventListeners();
}

function attachEventListeners() {
    document.getElementById('searchInput').addEventListener('input', function () {
        searchTerm = this.value.toLowerCase();
        renderApplications();
    });

    document.querySelectorAll('.filter-btn[data-status]').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.filter-btn[data-status]').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.status;
            renderApplications();
        });
    });

    const eventTypeSelect = document.getElementById('eventTypeFilter');
    if (eventTypeSelect) {
        eventTypeSelect.addEventListener('change', function () {
            renderApplications();
        });
    }
}

function filterApplications() {
    return applications.filter(app => {
        const matchesSearch = searchTerm === '' ||
            app.eventName.toLowerCase().includes(searchTerm) ||
            app.organizer.toLowerCase().includes(searchTerm) ||
            app.location.toLowerCase().includes(searchTerm) ||
            app.eventId.toLowerCase().includes(searchTerm);

        const matchesStatus = currentFilter === 'all' || app.status === currentFilter;

        const eventTypeFilter = document.getElementById('eventTypeFilter') ? document.getElementById('eventTypeFilter').value : 'all';
        const matchesType = eventTypeFilter === 'all' || app.eventType === eventTypeFilter;

        return matchesSearch && matchesStatus && matchesType;
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
            <div class="no-results" style="text-align:center; padding: 2rem; color: #999;">
                <h3>No applications found matching your criteria.</h3>
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
                    <span class="status-badge status-${app.status}">${app.statusText}</span>
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
                    <h4>Event Date</h4>
                    <p> ${app.eventDate}</p>
                </div>
            </div>

            <div class="app-actions">
                <button class="btn btn-view" onclick="viewApplication(${app.id})">
                    View Full Details
                </button>
                <!-- Manager side specific actions if any, for now just view -->
            </div>
        </div>
    `).join('');

    updateStats();
}

function updateStats() {
    const total = applications.length;
    const pending = applications.filter(a => a.status === 'pending').length;
    const approved = applications.filter(a => a.status === 'approved').length;
    const rejected = applications.filter(a => a.status === 'rejected').length;

    document.getElementById('totalCount').textContent = total;
    if (document.getElementById('pendingCount')) document.getElementById('pendingCount').textContent = pending;
    if (document.getElementById('approvedCount')) document.getElementById('approvedCount').textContent = approved;
    if (document.getElementById('rejectedCount')) document.getElementById('rejectedCount').textContent = rejected;
}

function viewApplication(id) {
    const app = applications.find(a => a.id === id);
    if (!app) return;

    document.getElementById('modalTitle').textContent = app.eventName;
    document.getElementById('modalSubtitle').textContent = `Organized by ${app.organizer}`;
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
                    ${app.gmapLink ? `<a href="${app.gmapLink}" target="_blank" class="btn btn-map">View on Google Maps</a>` : ''}
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
                    <span>${app.duration}</span>
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
                    <span>${app.starpoints}</span>
                </div>
                <div class="modal-field">
                    <label>Level Points:</label>
                    <span>${app.levelpoints}</span>
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
                    <span>${app.applicationDate}</span>
                </div>
            </div>
        </div>

        <div class="modal-section">
            <h3>Current Status</h3>
            <div class="value">
                <span class="status-badge status-${app.status}">
                    ${app.statusText}
                </span>
            </div>
        </div>
    `;

    const modalFooter = document.getElementById('modalFooter');
    modalFooter.innerHTML = `
        <button class="btn btn-secondary" onclick="closeModal()">Close</button>
    `;

    document.getElementById('applicationModal').classList.add('active');
}

function closeModal() {
    document.getElementById('applicationModal').classList.remove('active');
}

document.getElementById('applicationModal').addEventListener('click', function (e) {
    if (e.target === this) {
        closeModal();
    }
});

init();
