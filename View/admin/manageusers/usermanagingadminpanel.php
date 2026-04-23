<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/V/View/globalstyles.css">
    <link rel="stylesheet" href="/V/View/admin/manageusers/usermanagingadminpanel.css">
    <title>V</title>
    <!-- <1?php include __DIR__ . '/../navbar/navbar.php'; ?> -->
         <?php include __DIR__ . '/../../navbar/navbar.php'; ?>

    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-background">
        <div class="header-section">
            <div class="header-content">
                <div>
                    <h1 class="page-title">User Management</h1>
                    <p class="page-subtitle">Manage and monitor all registered users</p>
                </div>
            </div>
            <div class="stats-grid">
                <div class="stat-card total">
                    <div class="stat-number" id="totalUsers">0</div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-card volunteers">
                    <div class="stat-number" id="volunteerCount">0</div>
                    <div class="stat-label">Volunteers</div>
                </div>
                <div class="stat-card representatives">
                    <div class="stat-number" id="representativeCount">0</div>
                    <div class="stat-label">Representatives</div>
                </div>
                <div class="stat-card orgrepresentatives">
                    <div class="stat-number" id="organisationRepCount">0</div>
                    <div class="stat-label">Organisation Representatives</div>
                </div>
                <div class="stat-card sponsors">
                    <div class="stat-number" id="sponsorCount">0</div>
                    <div class="stat-label">Sponsors</div>
                </div>
            </div>
        </div>

        <div class="container-applicationbackground">
        <div class="controls-section">
            <div class="search-filter-wrapper">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search by name or user ID...">
                </div>
                <select id="roleFilter" class="filter-select">
                    <option value="all">All Roles</option>
                    <option value="Volunteer">Volunteers</option>
                    <option value="Representative">Representatives</option>
                    <option value="Organisationrep">Organisation Representatives</option>
                    <option value="Sponsor">Sponsors</option>
                </select>
            </div>
        </div>

        <div class="users-table-section">
            <div class="table-header">
                <h2 class="table-title">Registered Users</h2>
                <span class="results-count" id="resultsCount">0 users</span>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Role</th>
                            <th>Points</th>
                            <th>Created Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <!-- Users will be rendered here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <!-- View Profile Modal -->
    <div class="modal" id="viewModal">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close-modal" onclick="closeModal('viewModal')">&times;</button>
                <h2 id="viewModalTitle">User Profile</h2>
                <p id="viewModalSubtitle"></p>
            </div>
            <div class="modal-body" id="viewModalBody">
                <!-- Profile details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-edit" onclick="openEditModal()"> Edit User</button>
                <button class="btn" style="background: #e0e0e0; color: #333;" onclick="closeModal('viewModal')">Close</button>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close-modal" onclick="closeModal('editModal')">&times;</button>
                <h2>Edit User Information</h2>
                <p>Update user details as needed</p>
            </div>
            <div class="modal-body" id="editModalBody">
                <!-- Edit form will be loaded here -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-edit" onclick="saveUserChanges()"> Save Changes</button>
                <button class="btn" style="background: #e0e0e0; color: #333;" onclick="closeModal('editModal')">Cancel</button>
            </div>
        </div>
    </div>
    <script src="/V/View/admin/manageusers/usermanagingadminpanel.js"></script>
</body>
</html>