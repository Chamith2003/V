// Sample data
let requests = [
    {
        id: 1,
        eventId: "EVT-2025-001",
        eventName: "City Cleanup Drive",
        eventDescription: "A community-driven initiative aimed at promoting sustainable gardening practices and enhancing green spaces in urban areas. The project will involve workshops, planting events, and educational programs for local residents.",
        eventType: "City Cleanup",
        eventDate: "2025-11-15",
        location: "Viharamahadevi park, Colombo",
        scale: "Large",
        participantCount: 300,
        requestAmount: 25000,
        organizer: "Green Earth Foundation",
        status: "pending",
        requestDate: "2025-10-10"
    },
    {
        id: 2,
        eventId: "EVT-2025-002",
        eventName: "Beach Cleanup Initiative",
        eventDescription: "A coastal cleanup campaign organized to remove plastic waste and raise awareness about marine pollution. Volunteers will clean the beach and sort collected waste for recycling.",
        eventType: "Beach Cleanup",
        eventDate: "2025-11-10",
        location: "Mount Lavinia Beach, Colombo",
        scale: "Medium",
        participantCount: 150,
        requestAmount: 50000,
        organizer: "Blue Ocean Youth Club",
        status: "accepted",
        requestDate: "2025-10-13"
    },
    {
        id: 3,
        eventId: "EVT-2025-003",
        eventName: "Mangrove Restoration Event",
        eventDescription: "A collaborative event to restore our precious mangroves campaign to support the our coastline in need. Volunteers will help coordinate planting and manage logistics.",
        eventType: "Mangrove Restoration",
        eventDate: "2025-11-15",
        location: "Green Lagoon, Puttalam",
        scale: "Large",
        participantCount: 200,
        requestAmount: 35000,
        organizer: "Roots for Roots Foundation",
        status: "accepted",
        requestDate: "2025-10-20"
    },
    {
        id: 4,
        eventId: "EVT-2025-004",
        eventName: "Tree Planting in Schools",
        eventDescription: "An initiative to plant 500 trees across local schools in the Galle District to promote environmental education among students.",
        eventType: "Tree Planting",
        eventDate: "2025-11-20",
        location: "Galle District Schools",
        scale: "Large",
        participantCount: 250,
        requestAmount: 60000,
        organizer: "Eco Youth Sri Lanka",
        status: "pending",
        requestDate: "2025-10-26"
    },
    {
        id: 5,
        eventId: "EVT-2025-005",
        eventName: "Coral Restoration Event",
        eventDescription: "Restoring our precious coral reefs conservation.",
        eventType: "Coral Restoration",
        eventDate: "2025-12-03",
        location: "Hambantota District",
        scale: "Large",
        participantCount: 150,
        requestAmount: 40000,
        organizer: "Clean Water Initiative",
        status: "pending",
        requestDate: "2025-11-01"
    },
    {
        id: 6,
        eventId: "EVT-2025-006",
        eventName: "Youth Awareness Workshop",
        eventDescription: "A one-day training program to teach rural youth about basic environmental issues.",
        eventType: "Awareness Program",
        eventDate: "2025-11-30",
        location: "Anuradhapura Public Library",
        scale: "Medium",
        participantCount: 90,
        requestAmount: 30000,
        organizer: "Be4Change Sri Lanka",
        status: "pending",
        requestDate: "2025-11-06"
    },
    {
        id: 7,
        eventId: "EVT-2025-007",
        eventName: "Village Clean-Up Campaign",
        eventDescription: "A full-day clean-up and waste management awareness event to improve sanitation and hygiene in rural communities.",
        eventType: "City Cleanup",
        eventDate: "2025-12-18",
        location: "Matale Town",
        scale: "Medium",
        participantCount: 120,
        requestAmount: 25000,
        organizer: "Youth for Change Organization",
        status: "pending",
        requestDate: "2025-11-15"
    }
];

let currentFilter = 'all';
let currentEventType = 'all';
let currentAmountRange = 'all';
let searchTerm = '';

function init() {
    renderRequests();
    updateStats();
    attachEventListeners();
}

function attachEventListeners() {
    // Status filter buttons
    document.querySelectorAll('.filter-btn[data-status]').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn[data-status]').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.status;
            renderRequests();
        });
    });

    // Event type filter
    document.getElementById('eventTypeFilter').addEventListener('change', function() {
        currentEventType = this.value;
        if (currentEventType !== 'all') {
            this.classList.add('active');
        } else {
            this.classList.remove('active');
        }
        renderRequests();
    });

    // Amount filter
    document.getElementById('amountFilter').addEventListener('change', function() {
        currentAmountRange = this.value;
        if (currentAmountRange !== 'all') {
            this.classList.add('active');
        } else {
            this.classList.remove('active');
        }
        renderRequests();
    });

    // Search
    document.getElementById('searchInput').addEventListener('input', function() {
        searchTerm = this.value.toLowerCase();
        renderRequests();
    });
}

function filterRequests() {
    return requests.filter(req => {
        const matchesStatus = currentFilter === 'all' || req.status === currentFilter;
        const matchesEventType = currentEventType === 'all' || req.eventType === currentEventType;
        
        let matchesAmount = true;
        if (currentAmountRange !== 'all') {
            const [min, max] = currentAmountRange.split('-').map(Number);
            matchesAmount = req.requestAmount >= min && req.requestAmount <= max;
        }
        
        const matchesSearch = searchTerm === '' || 
            req.eventName.toLowerCase().includes(searchTerm) ||
            req.organizer.toLowerCase().includes(searchTerm) ||
            req.location.toLowerCase().includes(searchTerm) ||
            req.eventId.toLowerCase().includes(searchTerm);
        
        return matchesStatus && matchesEventType && matchesAmount && matchesSearch;
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

function renderRequests() {
    const filteredReqs = filterRequests();
    const listContainer = document.getElementById('requestsList');

    if (filteredReqs.length === 0) {
        listContainer.innerHTML = `
            <div class="no-results">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3>No sponsorship requests found</h3>
                <p>Try adjusting your filters or search criteria</p>
            </div>
        `;
        return;
    }

    listContainer.innerHTML = filteredReqs.map(req => `
        <div class="request-card">
            <div class="request-header">
                <div class="request-info">
                    <div class="event-id">${req.eventId}</div>
                    <h3>${req.eventName}</h3>
                    <div class="request-meta">
                        <span> ${req.eventDate}</span>
                        <span> ${req.location}</span>
                        <span> ${req.participantCount.toLocaleString()} participants</span>
                        <span class="event-type-badge">${req.eventType}</span>
                        <span class="scale-indicator scale-${req.scale.toLowerCase()}"> ${req.scale} Scale</span>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 10px; align-items: flex-end;">
                    <div class="amount-badge"> ${formatCurrency(req.requestAmount)}</div>
                    <span class="status-badge status-${req.status}">${req.status}</span>
                </div>
            </div>

            <div class="description-preview">
                <p>${req.eventDescription.substring(0, 200)}...</p>
            </div>

            <div class="request-details">
                <div class="detail-group">
                    <h4>Organizer</h4>
                    <p> ${req.organizer}</p>
                </div>
                <div class="detail-group">
                    <h4>Request Date</h4>
                    <p> ${req.requestDate}</p>
                </div>
                <div class="detail-group">
                    <h4>Event Scale</h4>
                    <p>${req.scale} scale event with ${req.participantCount.toLocaleString()} expected attendees</p>
                </div>
            </div>

            <div class="request-actions">
                <button class="btn btn-view" onclick="viewRequest(${req.id})">
                        View Full Details
                </button>
                ${req.status === 'pending' ? `
                    <button class="btn btn-accept" onclick="updateStatus(${req.id}, 'accepted')">
                        ✓ Accept Request
                    </button>
                    <button class="btn btn-reject" onclick="updateStatus(${req.id}, 'rejected')">
                        ✕ Reject Request
                    </button>
                ` : ''}
            </div>
        </div>
    `).join('');
}

function updateStats() {
    const totalAmount = requests.reduce((sum, r) => sum + r.requestAmount, 0);
    const pendingAmount = requests.filter(r => r.status === 'pending').reduce((sum, r) => sum + r.requestAmount, 0);
    const acceptedAmount = requests.filter(r => r.status === 'accepted').reduce((sum, r) => sum + r.requestAmount, 0);
    const rejectedAmount = requests.filter(r => r.status === 'rejected').reduce((sum, r) => sum + r.requestAmount, 0);

    document.getElementById('totalCount').textContent = requests.length;
    document.getElementById('totalAmount').textContent = formatCurrency(totalAmount);
    
    document.getElementById('pendingCount').textContent = requests.filter(r => r.status === 'pending').length;
    document.getElementById('pendingAmount').textContent = formatCurrency(pendingAmount);
    
    document.getElementById('acceptedCount').textContent = requests.filter(r => r.status === 'accepted').length;
    document.getElementById('acceptedAmount').textContent = formatCurrency(acceptedAmount);
    
    document.getElementById('rejectedCount').textContent = requests.filter(r => r.status === 'rejected').length;
    document.getElementById('rejectedAmount').textContent = formatCurrency(rejectedAmount);
}

function viewRequest(id) {
    const req = requests.find(r => r.id === id);
    if (!req) return;

    document.getElementById('modalTitle').textContent = req.eventName;
    document.getElementById('modalSubtitle').textContent = `${req.eventId} • Requested on ${req.requestDate}`;
    document.getElementById('modalAmount').innerHTML = ` ${formatCurrency(req.requestAmount)} <span class="status-badge status-${req.status}">${req.status}</span>`;

    document.getElementById('modalBody').innerHTML = `
        <div class="modal-section">
            <h3>Event Information</h3>
            <div class="modal-grid">
                <div class="modal-field">
                    <label>Event ID</label>
                    <div class="value">${req.eventId}</div>
                </div>
                <div class="modal-field">
                    <label>Event Type</label>
                    <div class="value"><span class="event-type-badge type-${req.eventType.toLowerCase()}">${req.eventType}</span></div>
                </div>
                <div class="modal-field">
                    <label>Event Date</label>
                    <div class="value"> ${req.eventDate}</div>
                </div>
                <div class="modal-field">
                    <label>Location</label>
                    <div class="value"> ${req.location}</div>
                </div>
                <div class="modal-field">
                    <label>Event Scale</label>
                    <div class="value"><span class="scale-indicator scale-${req.scale.toLowerCase()}"> ${req.scale} Scale</span></div>
                </div>
                <div class="modal-field">
                    <label>Expected Participants</label>
                    <div class="value"> ${req.participantCount.toLocaleString()} attendees</div>
                </div>
            </div>
        </div>

        <div class="modal-section">
            <h3>Event Description</h3>
            <div class="modal-description">
                <p>${req.eventDescription}</p>
            </div>
        </div>

        <div class="modal-section">
            <h3>Organizer Information</h3>
            <div class="modal-grid">
                <div class="modal-field">
                    <label>Organizer Name</label>
                    <div class="value"> ${req.organizer}</div>
                </div>
                <div class="modal-field">
                    <label>Request Date</label>
                    <div class="value"> ${req.requestDate}</div>
                </div>
            </div>
        </div>

        <div class="modal-section">
            <h3>Sponsorship Details</h3>
            <div class="modal-grid">
                <div class="modal-field">
                    <label>Requested Amount</label>
                    <div class="value" style="font-size: 24px; font-weight: 700; color: #10b981;"> ${formatCurrency(req.requestAmount)}</div>
                </div>
                <div class="modal-field">
                    <label>Current Status</label>
                    <div class="value"><span class="status-badge status-${req.status}">${req.status}</span></div>
                </div>
            </div>
        </div>
    `;

    document.getElementById('modalFooter').innerHTML = `
        ${req.status === 'pending' ? `
            <button class="btn btn-accept" onclick="updateStatus(${req.id}, 'accepted'); closeModal();">
                ✓ Accept Request
            </button>
            <button class="btn btn-reject" onclick="updateStatus(${req.id}, 'rejected'); closeModal();">
                ✕ Reject Request
            </button>
        ` : ''}
        <button class="btn btn-secondary" onclick="closeModal()">Close</button>
    `;

    document.getElementById('requestModal').classList.add('active');
}

function closeModal() {
    document.getElementById('requestModal').classList.remove('active');
}

function updateStatus(id, newStatus) {
    const req = requests.find(r => r.id === id);
    if (req) {
        req.status = newStatus;
        renderRequests();
        updateStats();
        alert(`Sponsorship request ${newStatus === 'accepted' ? 'accepted' : 'rejected'} successfully!`);
    }
}

// Close modal when clicking outside
document.getElementById('requestModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Initialize on page load
init();