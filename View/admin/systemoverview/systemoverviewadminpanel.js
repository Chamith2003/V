let participationChart, citiesChart, categoriesChart, growthChart;

window.onload = function() {
    updateStatistics();
    initializeCharts();
    renderTopVolunteers();
    renderTopSponsors();
    renderActivityFeed();
};

function updateStatistics() {
    document.getElementById('totalUsers').textContent = systemData.totalUsers.toLocaleString();
    document.getElementById('totalEvents').textContent = systemData.totalEvents.toLocaleString();
    document.getElementById('totalSponsors').textContent = systemData.totalSponsors.toLocaleString();
    document.getElementById('totalParticipants').textContent = systemData.totalParticipants.toLocaleString();
    
    updateChangeIndicator('usersChange', systemData.usersChange);
    updateChangeIndicator('eventsChange', systemData.eventsChange);
    updateChangeIndicator('sponsorsChange', systemData.sponsorsChange);
    updateChangeIndicator('participantsChange', systemData.participantsChange);

    // Animate numbers
    animateValue('totalUsers', 0, systemData.totalUsers, 1500);
    animateValue('totalEvents', 0, systemData.totalEvents, 1500);
    animateValue('totalSponsors', 0, systemData.totalSponsors, 1500);
    animateValue('totalParticipants', 0, systemData.totalParticipants, 1500);
}

function updateChangeIndicator(elementId, value) {
    const element = document.getElementById(elementId);
    const absValue = Math.abs(value);
    
    if (value > 0) {
        element.innerHTML = '↑ ' + absValue + '%';
        element.style.color = '#10b981';
    } else if (value < 0) {
        element.innerHTML = '↓ ' + absValue + '%';
        element.style.color = '#ef4444';
    } else {
        element.innerHTML = '0%';
        element.style.color = '#6b7280';
    }
}

function animateValue(id, start, end, duration) {
    const element = document.getElementById(id);
    const range = end - start;
    const increment = range / (duration / 16);
    let current = start;

    const timer = setInterval(() => {
        current += increment;
        if (current >= end) {
            element.textContent = end.toLocaleString();
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current).toLocaleString();
        }
    }, 16);
}

function initializeCharts() {
    const participationCtx = document.getElementById('participationChart').getContext('2d');
    participationChart = new Chart(participationCtx, {
        type: 'line',
        data: {
            labels: monthlyData.labels,
            datasets: [
                {
                    label: 'Events',
                    data: monthlyData.events,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3
                },
                {
                    label: 'Participants',
                    data: monthlyData.participants,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3
                },
                {
                    label: 'New Users',
                    data: monthlyData.newUsers,
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        padding: 20,
                        font: { size: 13, weight: '600' }
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: { size: 14, weight: '700' },
                    bodyFont: { size: 13 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: { font: { size: 12 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 12 } }
                }
            }
        }
    });

    const citiesCtx = document.getElementById('citiesChart').getContext('2d');
    citiesChart = new Chart(citiesCtx, {
        type: 'bar',
        data: {
            labels: citiesData.map(c => c.name),
            datasets: [{
                label: 'Active Events',
                data: citiesData.map(c => c.count),
                backgroundColor: 'rgba(23, 41, 65, 0.8)',
                borderColor: '#172941',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: { size: 14, weight: '700' },
                    bodyFont: { size: 13 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: { font: { size: 12 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });

    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    categoriesChart = new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
            labels: categoriesData.map(c => c.name),
            datasets: [{
                data: categoriesData.map(c => c.count),
                backgroundColor: categoriesData.map(c => c.color),
                borderWidth: 3,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        padding: 15,
                        font: { size: 12, weight: '600' },
                        generateLabels: function(chart) {
                            const data = chart.data;
                            return data.labels.map((label, i) => ({
                                text: `${label} (${data.datasets[0].data[i]})`,
                                fillStyle: data.datasets[0].backgroundColor[i],
                                hidden: false,
                                index: i
                            }));
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: { size: 14, weight: '700' },
                    bodyFont: { size: 13 }
                }
            }
        }
    });

    const growthCtx = document.getElementById('growthChart').getContext('2d');
    growthChart = new Chart(growthCtx, {
        type: 'line',
        data: {
            labels: growthData.labels,
            datasets: [
                {
                    label: 'Total Users',
                    data: growthData.users,
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: '#667eea'
                },
                {
                    label: 'Total Events',
                    data: growthData.events,
                    borderColor: '#f093fb',
                    backgroundColor: 'rgba(240, 147, 251, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: '#f093fb'
                },
                {
                    label: 'Sponsors',
                    data: growthData.sponsors,
                    borderColor: '#4facfe',
                    backgroundColor: 'rgba(79, 172, 254, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: '#4facfe'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        padding: 20,
                        font: { size: 13, weight: '600' }
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: { size: 14, weight: '700' },
                    bodyFont: { size: 13 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: { font: { size: 12 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 12 } }
                }
            }
        }
    });
}

function renderTopVolunteers() {
    const container = document.getElementById('topVolunteersList');
    if (topVolunteers.length === 0) {
        container.innerHTML = '<li style="padding: 20px; text-align: center; color: #999;">No volunteer data available</li>';
        return;
    }
    
    const maxEvents = Math.max(...topVolunteers.map(v => v.events), 1);

    container.innerHTML = topVolunteers.map((volunteer, index) => {
        const percentage = (volunteer.events / maxEvents) * 100;
        return `
            <li class="top-item">
                <div class="top-item-rank">${volunteer.rank}</div>
                <div class="top-item-info">
                    <div class="top-item-name">${volunteer.name}</div>
                    <div class="top-item-meta">${volunteer.events} events • ${volunteer.hours} hours • ${volunteer.badge} Badge</div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: ${percentage}%"></div>
                    </div>
                </div>
                <div class="top-item-value">${volunteer.events}</div>
            </li>
        `;
    }).join('');
}

function renderTopSponsors() {
    const container = document.getElementById('topSponsorsList');
    if (topSponsors.length === 0) {
        container.innerHTML = '<li style="padding: 20px; text-align: center; color: #999;">No sponsor data available</li>';
        return;
    }
    
    const maxEvents = Math.max(...topSponsors.map(o => o.events), 1);

    container.innerHTML = topSponsors.map((sponsor, index) => {
        const percentage = (sponsor.events / maxEvents) * 100;
        return `
            <li class="top-item">
                <div class="top-item-rank">${sponsor.rank}</div>
                <div class="top-item-info">
                    <div class="top-item-name">${sponsor.name}</div>
                    <div class="top-item-meta">Rs ${sponsor.events.toLocaleString()} donated • ${sponsor.donation_count} donations</div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: ${percentage}%"></div>
                    </div>
                </div>
                <div class="top-item-value">Rs ${sponsor.events.toLocaleString()}</div>
            </li>
        `;
    }).join('');
}

function renderActivityFeed() {
    const container = document.getElementById('activityFeed');
    if (recentActivities.length === 0) {
        container.innerHTML = '<div style="padding: 20px; text-align: center; color: #999;">No recent activities</div>';
        return;
    }
    
    container.innerHTML = recentActivities.map(activity => `
        <div class="activity-item">
            <div class="activity-icon">${activity.icon}</div>
            <div class="activity-content">
                <div class="activity-title">${activity.title}</div>
                <div class="activity-description">${activity.description}</div>
                <div class="activity-time">${activity.time}</div>
            </div>
        </div>
    `).join('');
}

function updateTrendPeriod(period) {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');

    let selectedData;
    if (period === '6months') {
        selectedData = monthlyData;
    } else if (period === 'year') {
        selectedData = monthlyDataYear;
    } else if (period === 'all') {
        selectedData = monthlyDataAllTime;
    }

    participationChart.data.labels = selectedData.labels;
    participationChart.data.datasets[0].data = selectedData.events;
    participationChart.data.datasets[1].data = selectedData.participants;
    participationChart.data.datasets[2].data = selectedData.newUsers;
    
    participationChart.update();
}

function refreshData() {
    window.location.reload();
}

function openReportModal() {
    document.getElementById('reportModal').style.display = 'block';
    
    const today = new Date();
    const lastMonth = new Date();
    lastMonth.setMonth(today.getMonth() - 1);

    document.getElementById('reportToDate').value = today.toISOString().split('T')[0];
    document.getElementById('reportFromDate').value = lastMonth.toISOString().split('T')[0];
}

function closeReportModal() {
    document.getElementById('reportModal').style.display = 'none';
}

function toggleReportOptions() {
    const type = document.getElementById('reportTypeSelect').value;
    
    document.querySelectorAll('.report-options').forEach(el => {
        el.style.display = 'none';
    });
    
    if (type) {
        document.getElementById('options-' + type).style.display = 'block';
    }
}

window.onclick = function(event) {
    const modal = document.getElementById('reportModal');
    if (event.target == modal) {
        closeReportModal();
    }
}