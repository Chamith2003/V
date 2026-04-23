let users = [];
let currentFilter = 'all';
let searchTerm = '';
let currentEditingUser = null;

async function init() {
    await fetchUsers();
    await fetchStats();
    attachEventListeners();
}

function attachEventListeners() {
    document.getElementById('roleFilter').addEventListener('change', function() {
        currentFilter = this.value;
        renderUsers();
    });

    document.getElementById('searchInput').addEventListener('input', function() {
        searchTerm = this.value.toLowerCase();
        renderUsers();
    });
}

async function fetchUsers() {
    try {
        const response = await fetch('/V/router.php?module=admin&action=getusersdata');
        const data = await response.json();
        
        if (data.success) {
            users = data.users.map(user => ({
                id: user.userid,
                userId: 'USR-' + new Date(user.createddate).getFullYear() + '-' + String(user.userid).padStart(3, '0'),
                userName: user.name,
                userEmail: user.email,
                userContact: user.contactnumber,
                createdDate: new Date(user.createddate).toISOString().split('T')[0],
                role: user.role.charAt(0).toUpperCase() + user.role.slice(1),
                levelPoints: parseInt(user.levelpoints) || 0,
                starPoints: parseInt(user.starpoints) || 0,
                status: user.status || 'active',
                _rawData: user
            }));
            renderUsers();
        } else {
            showNotification('Failed to load users', 'error');
        }
    } catch (error) {
        console.error('Error fetching users:', error);
        showNotification('Error loading users', 'error');
    }
}

async function fetchStats() {
    try {
        const response = await fetch('/V/router.php?module=admin&action=getstats');
        const data = await response.json();
        
        if (data.success) {
            updateStatsFromData(data.stats);
        }
    } catch (error) {
        console.error('Error fetching stats:', error);
        updateStats();
    }
}

function updateStatsFromData(stats) {
    document.getElementById('totalUsers').textContent = stats.total;
    document.getElementById('volunteerCount').textContent = stats.volunteers;
    document.getElementById('representativeCount').textContent = stats.representatives;
    document.getElementById('organisationRepCount').textContent = stats.organisationreps;
    document.getElementById('sponsorCount').textContent = stats.sponsors;
}

function filterUsers() {
    return users.filter(user => {
        const matchesRole = currentFilter === 'all' || user.role === currentFilter;
        const matchesSearch = searchTerm === '' || 
            user.userName.toLowerCase().includes(searchTerm) ||
            user.userId.toLowerCase().includes(searchTerm);
        
        return matchesRole && matchesSearch;
    });
}

function getInitials(name) {
    return name.split(' ').map(n => n[0]).join('').toUpperCase();
}

function renderUsers() {
    const filteredUsers = filterUsers();
    const tbody = document.getElementById('usersTableBody');
    document.getElementById('resultsCount').textContent = `${filteredUsers.length} user${filteredUsers.length !== 1 ? 's' : ''}`;

    if (filteredUsers.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8">
                    <div class="no-results">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <h3>No users found</h3>
                        <p>Try adjusting your search or filters</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = filteredUsers.map(user => `
        <tr>
            <td>
                <div class="user-info">
                    <div class="user-avatar">${getInitials(user.userName)}</div>
                    <div class="user-details">
                        <div class="user-name">${user.userName}</div>
                        <div class="user-id">${user.userId}</div>
                    </div>
                </div>
            </td>
            <td>${user.userEmail}</td>
            <td>${user.userContact}</td>
            <td><span class="role-badge role-${user.role.toLowerCase()}">${user.role}</span></td>
            <td>
                <div class="points-display">
                    <div class="points-item points-level"> ${user.levelPoints} LP</div>
                    <div class="points-item points-star"> ${user.starPoints} SP</div>
                </div>
            </td>
            <td>${user.createdDate}</td>
            <td><span class="status-badge status-${user.status}">${user.status.toUpperCase()}</span></td>
            <td>
                <div class="action-buttons">
                    <button class="btn btn-view" onclick="viewUser(${user.id})">View</button>
                    <button class="btn btn-edit" onclick="editUser(${user.id})">Edit</button>
                    ${user.status === 'active' ? 
                        `<button class="btn btn-suspend" onclick="suspendUser(${user.id})">Suspend</button>` :
                        `<button class="btn btn-activate" onclick="activateUser(${user.id})">Activate</button>`
                    }
                    <!-- <button class="btn btn-delete" onclick="deleteUser(${user.id})">Delete</button> -->
                </div>
            </td>
        </tr>
    `).join('');
}

function updateStats() {
    document.getElementById('totalUsers').textContent = users.length;
    document.getElementById('volunteerCount').textContent = users.filter(u => u.role === 'Volunteer').length;
    document.getElementById('representativeCount').textContent = users.filter(u => u.role === 'Representative').length;
    document.getElementById('organisationRepCount').textContent = users.filter(u => u.role === 'Organisationrep').length;
    document.getElementById('sponsorCount').textContent = users.filter(u => u.role === 'Sponsor').length;
}

async function viewUser(id) {
    try {
        const response = await fetch(`/V/router.php?module=admin&action=getuserdetails&id=${id}`);
        const data = await response.json();
        
        if (!data.success) {
            showNotification('Failed to load user details', 'error');
            return;
        }

        const rawUser = data.user;
        const user = {
            id: rawUser.userid,
            userId: 'USR-' + new Date(rawUser.createddate).getFullYear() + '-' + String(rawUser.userid).padStart(3, '0'),
            userName: rawUser.name,
            userEmail: rawUser.email,
            userContact: rawUser.contactnumber,
            createdDate: new Date(rawUser.createddate).toISOString().split('T')[0],
            role: rawUser.role.charAt(0).toUpperCase() + rawUser.role.slice(1),
            levelPoints: parseInt(rawUser.levelpoints) || 0,
            starPoints: parseInt(rawUser.starpoints) || 0,
            status: rawUser.status || 'active',
            _rawData: rawUser
        };

        currentEditingUser = user;

        document.getElementById('viewModalTitle').textContent = user.userName;
        document.getElementById('viewModalSubtitle').textContent = `${user.userId} • ${user.role}`;

        let modalContent = `
            <div class="modal-section">
                <h3>Personal Information</h3>
                <div class="modal-grid">
                    <div class="modal-field">
                        <label>User ID</label>
                        <div class="value">${user.userId}</div>
                    </div>
                    <div class="modal-field">
                        <label>Full Name</label>
                        <div class="value">${user.userName}</div>
                    </div>
                    <div class="modal-field">
                        <label>Email Address</label>
                        <div class="value">${user.userEmail}</div>
                    </div>
                    <div class="modal-field">
                        <label>Contact Number</label>
                        <div class="value">${user.userContact}</div>
                    </div>
                </div>
            </div>

            <div class="modal-section">
                <h3>Account Details</h3>
                <div class="modal-grid">
                    <div class="modal-field">
                        <label>Role</label>
                        <div class="value"><span class="role-badge role-${user.role.toLowerCase()}">${user.role}</span></div>
                    </div>
                    <div class="modal-field">
                        <label>Account Status</label>
                        <div class="value"><span class="status-badge status-${user.status}">${user.status.toUpperCase()}</span></div>
                    </div>
                    <div class="modal-field">
                        <label>Created Date</label>
                        <div class="value">${user.createdDate}</div>
                    </div>
                </div>
            </div>
        `;

        
        if (rawUser.role === 'volunteer') {
            modalContent += `
                <div class="modal-section">
                    <h3>Points & Achievements</h3>
                    <div class="modal-grid">
                        <div class="modal-field">
                            <label>Level Points</label>
                            <div class="value points-level"> ${user.levelPoints} LP</div>
                        </div>
                        <div class="modal-field">
                            <label>Star Points</label>
                            <div class="value points-star"> ${user.starPoints} SP</div>
                        </div>
                    </div>
                </div>
            `;
        }

        
        if (rawUser.role === 'volunteer') {
            if (rawUser.dob || rawUser.volunteer_experience || rawUser.noofmembers) {
                modalContent += `
                    <div class="modal-section">
                        <h3>Volunteer Information</h3>
                        <div class="modal-grid">
                            ${rawUser.dob ? `
                                <div class="modal-field">
                                    <label>Date of Birth</label>
                                    <div class="value">${rawUser.dob}</div>
                                </div>
                            ` : ''}
                            ${rawUser.noofmembers ? `
                                <div class="modal-field">
                                    <label>Group Members</label>
                                    <div class="value">${rawUser.noofmembers}</div>
                                </div>
                            ` : ''}
                            ${rawUser.volunteer_experience ? `
                                <div class="modal-field" style="grid-column: 1 / -1;">
                                    <label>Experience</label>
                                    <div class="value">${rawUser.volunteer_experience}</div>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                `;
            }

            if (rawUser.skills && rawUser.skills.length > 0) {
                modalContent += `
                    <div class="modal-section">
                        <h3>Skills</h3>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            ${rawUser.skills.map(skill => `<span class="role-badge role-volunteer">${skill}</span>`).join('')}
                        </div>
                    </div>
                `;
            }
        }

        document.getElementById('viewModalBody').innerHTML = modalContent;
        document.getElementById('viewModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    } catch (error) {
        console.error('Error:', error);
        showNotification('Error loading user details', 'error');
    }
}

async function editUser(id) {
    try {
        const response = await fetch(`/V/router.php?module=admin&action=getuserdetails&id=${id}`);
        const data = await response.json();
        
        if (!data.success) {
            showNotification('Failed to load user details', 'error');
            return;
        }

        const rawUser = data.user;
        const user = {
            id: rawUser.userid,
            userId: 'USR-' + new Date(rawUser.createddate).getFullYear() + '-' + String(rawUser.userid).padStart(3, '0'),
            userName: rawUser.name,
            userEmail: rawUser.email,
            userContact: rawUser.contactnumber,
            createdDate: new Date(rawUser.createddate).toISOString().split('T')[0],
            role: rawUser.role.charAt(0).toUpperCase() + rawUser.role.slice(1),
            levelPoints: parseInt(rawUser.levelpoints) || 0,
            starPoints: parseInt(rawUser.starpoints) || 0,
            status: rawUser.status || 'active',
            _rawData: rawUser
        };

        currentEditingUser = user;

        document.getElementById('editModalBody').innerHTML = `
            <div class="modal-section">
                <h3>Personal Information</h3>
                <div class="modal-grid">
                    <div class="modal-field">
                        <label>User ID</label>
                        <input type="text" id="editUserId" value="${user.userId}" readonly style="background: #f0f0f0;">
                    </div>
                    <div class="modal-field">
                        <label>Full Name</label>
                        <input type="text" id="editUserName" value="${user.userName}">
                    </div>
                    <div class="modal-field">
                        <label>Email Address</label>
                        <input type="email" id="editUserEmail" value="${user.userEmail}">
                    </div>
                    <div class="modal-field">
                        <label>Contact Number</label>
                        <input type="text" id="editUserContact" value="${user.userContact}">
                    </div>
                </div>
            </div>
        `;

        

        document.getElementById('editModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    } catch (error) {
        console.error('Error:', error);
        showNotification('Error loading user details', 'error');
    }
}

function openEditModal() {
    if (currentEditingUser) {
        closeModal('viewModal');
        editUser(currentEditingUser.id);
    }
}

async function saveUserChanges() {
    if (!currentEditingUser) return;

    const formData = new FormData();
    formData.append('userid', currentEditingUser.id);
    formData.append('name', document.getElementById('editUserName').value);
    formData.append('email', document.getElementById('editUserEmail').value);
    formData.append('contactnumber', document.getElementById('editUserContact').value);
    formData.append('role', document.getElementById('editUserRole').value.toLowerCase());

    try {
        const response = await fetch('/V/router.php?module=admin&action=updateuser', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            await fetchUsers();
            updateStats();
            closeModal('editModal');
            showNotification(` User "${document.getElementById('editUserName').value}" updated successfully!`, 'success');
        } else {
            showNotification(data.message || 'Failed to update user', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Error updating user', 'error');
    }
}

async function suspendUser(id) {
    if (!confirm('Are you sure you want to suspend this user?')) return;

    const user = users.find(u => u.id === id);
    
    try {
        const formData = new FormData();
        formData.append('userid', id);
        formData.append('status', 'suspended');

        const response = await fetch('/V/router.php?module=admin&action=toggleuserstatus', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            await fetchUsers();
            showNotification(` User "${user.userName}" has been suspended`, 'warning');
        } else {
            showNotification(data.message || 'Failed to suspend user', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Error suspending user', 'error');
    }
}

async function activateUser(id) {
    const user = users.find(u => u.id === id);
    
    try {
        const formData = new FormData();
        formData.append('userid', id);
        formData.append('status', 'active');

        const response = await fetch('/V/router.php?module=admin&action=toggleuserstatus', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            await fetchUsers();
            showNotification(` User "${user.userName}" has been activated`, 'success');
        } else {
            showNotification(data.message || 'Failed to activate user', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Error activating user', 'error');
    }
}



function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
    document.body.style.overflow = '';
    if (modalId === 'editModal') {
        currentEditingUser = null;
    }
}


document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});

init();