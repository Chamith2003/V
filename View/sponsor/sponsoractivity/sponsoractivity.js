let events = [
{
    id: 1,
    eventId: "EVT-2025-001",
    eventName: "City Cleanup Drive",
    eventDescription: "A community-driven initiative aimed at promoting sustainable gardening practices and enhancing green spaces in urban areas. The project will involve workshops, planting events, and educational programs for local residents.",
    eventType: "City Cleanup",
    eventDate: "2025-11-15",
    location: "Viharamahadevi park, Colombo",
    participantCount: 300,
    eventCost: 25000,
    organizer: "Green Earth Foundation",
    requested: false
},
{
    id: 2,
    eventId: "EVT-2025-002",
    eventName: "Beach Cleanup Drive",
    eventDescription: "A coastal cleanup campaign organized to remove plastic waste and raise awareness about marine pollution. Volunteers will clean the beach and sort collected waste for recycling.",
    eventType: "Beach Cleanup",
    eventDate: "2025-11-10",
    location: "Mount Lavinia Beach, Colombo",
    participantCount: 150,
    eventCost: 50000,
    organizer: "Blue Ocean Youth Club",
    requested: true
},
{
    id: 3,
    eventId: "EVT-2025-003",
    eventName: "Mangrove Restoration Event",
    eventDescription: "A collaborative event to restore our precious mangroves campaign to support the our coastline in need. Volunteers will help coordinate planting and manage logistics.",
    eventType: "Mangrove Restoration",
    eventDate: "2025-11-15",
    location: "Green Lagoon, Puttalam",
    participantCount: 200,
    eventCost: 35000,
    organizer: "Roots for Roots Foundation",
    requested: false
},
{
    id: 4,
    eventId: "EVT-2025-004",
    eventName: "Urban Tree Planting Campaign",
    eventDescription: "Large-scale reforestation project planting 5,000 trees across urban and suburban areas to combat climate change and improve air quality. Your sponsorship provides saplings, planting tools, soil amendments, and professional guidance to ensure maximum survival rate and environmental impact.",
    eventType: "Tree Planting",
    eventDate: "2025-12-01",
    location: "Portland Metro Area",
    participantCount: 500,
    eventCost: 8000,
    organizer: "Green Earth Project",
    requested: false
},
{
    id: 5,
    eventId: "EVT-2025-005",
    eventName: "Coral Restoration Event",
    eventDescription: "Restoring our precious coral reefs conservation.",
    eventType: "Coral Restoration",
    eventDate: "2025-12-03",
    location: "Hambantota District",
    participantCount: 150,
    eventCost: 40000,
    organizer: "Clean Water Initiative",
    requested: false
},
{
    id: 6,
    eventId: "EVT-2025-006",
    eventName: "Youth Awareness Workshop",
    eventDescription: "A one-day training program to teach rural youth about basic environmental issues.",
    eventType: "Awareness Program",
    eventDate: "2025-11-30",
    location: "Anuradhapura Public Library",
    participantCount: 90,
    eventCost: 30000,
    organizer: "Be4Change Sri Lanka",
    requested: true
},
{
    id: 7,
    eventId: "EVT-2025-007",
    eventName: "Village Clean-Up Campaign",
    eventDescription: "A full-day clean-up and waste management awareness event to improve sanitation and hygiene in rural communities.",
    eventType: "City Cleanup",
    eventDate: "2025-12-18",
    location: "Matale Town",
    participantCount: 120,
    eventCost: 25000,
    organizer: "Youth for Change Organization",
    requested: false
}
];

let featuredEvents = [
{
    id: 9,
    eventName: "Annual Beach Cleanup Drive",
    eventType: "Beach Cleanup",
    eventDate: "2025-11-01",
    location: "Multiple Locations",
    eventCost: 10000
},
{
    id: 10,
    eventName: "Annual City Cleanup",
    eventType: "City Cleanup",
    eventDate: "2025-10-28",
    location: "City Schools District",
    eventCost: 2200
},
{
    id: 11,
    eventName: "World Tree Planting Event",
    eventType: "Tree Planting",
    eventDate: "2025-11-18",
    location: "Urban Community Center",
    eventCost: 3200
}
];

let currentEventType = 'all';
let currentDateFilter = 'all';
let searchTerm = '';

function init() {
renderEvents();
renderFeaturedEvents();
updateSponsorshipStats();
attachEventListeners();
}

function attachEventListeners() {
document.getElementById('eventTypeFilter').addEventListener('change', function() {
    currentEventType = this.value;
    renderEvents();
});

document.getElementById('searchInput').addEventListener('input', function() {
    searchTerm = this.value.toLowerCase();
    renderEvents();
});
}

function filterEvents() {
return events.filter(event => {
    const matchesType = currentEventType === 'all' || event.eventType === currentEventType;
    const matchesSearch = searchTerm === '' || 
        event.eventName.toLowerCase().includes(searchTerm) ||
        event.location.toLowerCase().includes(searchTerm) ||
        event.organizer.toLowerCase().includes(searchTerm) ||
        event.eventId.toLowerCase().includes(searchTerm);
    
    return matchesType && matchesSearch;
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

function renderEvents() {
const filteredEvents = filterEvents();
const listContainer = document.getElementById('eventsList');
document.getElementById('resultsCount').textContent = `${filteredEvents.length} opportunit${filteredEvents.length !== 1 ? 'ies' : 'y'}`;

if (filteredEvents.length === 0) {
    listContainer.innerHTML = `
        <div class="no-results">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <h3>No opportunities found</h3>
            <p>Try adjusting your filters or search criteria</p>
        </div>
    `;
    return;
}

listContainer.innerHTML = filteredEvents.map(event => `
    <div class="event-card">
        <div class="event-header">
            <div class="event-title-section">
                <div class="event-id">${event.eventId}</div>
                <span class="event-type-badge type-${event.eventType.toLowerCase().replace(/ /g, '-')}">${event.eventType}</span>
                <h3 class="event-name">${event.eventName}</h3>
                <div class="event-organizer"> ${event.organizer}</div>
            </div>
            <div class="event-cost-section">
                <div class="cost-label">Sponsorship Request</div>
                <div class="event-cost">${formatCurrency(event.eventCost)}</div>
            </div>
        </div>

        <div class="event-description">
            ${event.eventDescription}
        </div>

        <div class="event-details">
            <div class="detail-item">
                <div class="detail-content">
                    <span class="detail-label">Event Date</span>
                    <span class="detail-value">${event.eventDate}</span>
                </div>
            </div>
            <div class="detail-item">
                <div class="detail-content">
                    <span class="detail-label">Location</span>
                    <span class="detail-value">${event.location}</span>
                </div>
            </div>
            <div class="detail-item">
                <div class="detail-content">
                    <span class="detail-label">Participants</span>
                    <span class="detail-value">${event.participantCount} volunteers</span>
                </div>
            </div>
        </div>

        <div class="event-footer">
            ${event.requested ? 
                `<button class="btn btn-requested">✓ Request Sent</button>` :
                `<button class="btn btn-sponsor" onclick="requestSponsorship(${event.id})"> Request Sponsorship</button>`
            }
        </div>
    </div>
`).join('');
}

function renderFeaturedEvents() {
const container = document.getElementById('featuredEvents');
container.innerHTML = featuredEvents.map(event => `
    <div class="featured-event">
        <span class="event-type-badge type-${event.eventType.toLowerCase().replace(/ /g, '-')}">${event.eventType}</span>
        <div class="featured-event-name">${event.eventName}</div>
        <div class="featured-event-meta">
            <div> ${event.eventDate}</div>
            <div> ${event.location}</div>
        </div>
        <div class="featured-cost">${formatCurrency(event.eventCost)}</div>
    </div>
`).join('');
}

function updateSponsorshipStats() {
const requestedCount = events.filter(e => e.requested).length;
const totalInvested = events.filter(e => e.requested).reduce((sum, e) => sum + e.eventCost, 0);

document.getElementById('requestedCount').textContent = requestedCount;
document.getElementById('totalInvested').textContent = formatCurrency(totalInvested);
}

function requestSponsorship(id) {
const event = events.find(e => e.id === id);
if (event && !event.requested) {
    event.requested = true;
    renderEvents();
    updateSponsorshipStats();
    showNotification(` Sponsorship request sent for "${event.eventName}"! The organizer will review your request shortly.`, 'success');
}
}

function showNotification(message, type) {
const notification = document.createElement('div');
const bgColors = {
    success: 'linear-gradient(135deg, #1e3c72 0%, #2a5298 100%)',
    error: 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)',
    info: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'
};

notification.style.cssText = `
    position: fixed;
    top: 90px;
    right: 20px;
    background: ${bgColors[type]};
    color: white;
    padding: 20px 30px;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    z-index: 1000;
    font-weight: 600;
    font-size: 15px;
    animation: slideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    max-width: 400px;
    line-height: 1.5;
`;
notification.textContent = message;

document.body.appendChild(notification);

setTimeout(() => {
    notification.style.animation = 'slideOut 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
    setTimeout(() => notification.remove(), 400);
}, 4000);
}

init();