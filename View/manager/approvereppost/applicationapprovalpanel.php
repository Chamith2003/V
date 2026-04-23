<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/V/View/globalstyles.css">
    <!-- <link rel="stylesheet" href="/V/View/manager/approvereppost/applicationapprovalpanel.css"> -->
     <link rel="stylesheet" type="text/css" href="/V/View/manager/approvereppost/applicationapprovalpanel.css">
  <?php include __DIR__ . '/../../navbar/navbar.php'; ?>
    <title>V</title>
    <!-- <1?php include __DIR__ . '/../navbar/navbar.php'; ?> -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-background">
        <div class="header">
            <h1 class="header-title">Representative Applications Manager</h1>
            <p class="header-subtitle">Review and manage representative role applications</p>
        </div>

        <div class="container-applicationbackground">
            <div class="controls">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search by name, email, or location...">
                </div>
                
                <div class="filter-group">
                    <button class="filter-btn active" data-status="all">All</button>
                    <button class="filter-btn" data-status="pending">Pending</button>
                    <button class="filter-btn" data-status="approved">Approved</button>
                    <button class="filter-btn" data-status="rejected">Rejected</button>
                    
                    <select id="locationFilter" class="filter-btn">
                        <option value="all">All Locations</option>
                        <option value="Ampara">Ampara</option>
                        <option value="Anuradhapura">Anuradhapura</option>
                        <option value="Badulla">Badulla</option>
                        <option value="Batticaloa">Batticaloa</option>
                        <option value="Colombo">Colombo</option>
                        <option value="Galle">Galle</option>
                        <option value="Gampaha">Gampaha</option>
                        <option value="Hambantota">Hambantota</option>
                        <option value="Jaffna">Jaffna</option>
                        <option value="Kalutara">Kalutara</option>
                        <option value="Kandy">Kandy</option>
                        <option value="Kegalle">Kegalle</option>
                        <option value="Kilinochchi">Kilinochchi</option>
                        <option value="Kurunegala">Kurunegala</option>
                        <option value="Mannar">Mannar</option>
                        <option value="Matale">Matale</option>
                        <option value="Matara">Matara</option>
                        <option value="Monaragala">Monaragala</option>
                        <option value="Mullaitivu">Mullaitivu</option>
                        <option value="Nuwara Eliya">Nuwara Eliya</option>
                        <option value="Polonnaruwa">Polonnaruwa</option>
                        <option value="Puttalam">Puttalam</option>
                        <option value="Ratnapura">Ratnapura</option>
                        <option value="Trincomalee">Trincomalee</option>
                        <option value="Vavuniya">Vavuniya</option>
                    </select>
                </div>
            </div>

            <div class="stats">
                <div class="stat-card total">
                    <h3>Total Applications</h3>
                    <div class="number" id="totalCount">0</div>
                </div>
                <div class="stat-card pending">
                    <h3>Pending Review</h3>
                    <div class="number" id="pendingCount">0</div>
                </div>
                <div class="stat-card approved">
                    <h3>Approved</h3>
                    <div class="number" id="approvedCount">0</div>
                </div>
                <div class="stat-card rejected">
                    <h3>Rejected</h3>
                    <div class="number" id="rejectedCount">0</div>
                </div>
            </div>
</div>
            <div class="applications-list" id="applicationsList">
            </div>

        <div class="modal" id="applicationModal">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close-modal" onclick="closeModal()">&times;</button>
                    <h2 id="modalTitle">Application Details</h2>
                    <p id="modalSubtitle"></p>
                </div>
                <div class="modal-body" id="modalBody">
                </div>
                <div class="modal-footer" id="modalFooter">
                </div>
            </div>
        </div>
    </div>
<script>
const applicationsData = <?php echo json_encode($applicantDetails ?? []); ?>;
console.log('Applications data:', applicationsData);
</script>
<script src="/V/View/manager/approvereppost/applicationapprovalpanel.js"></script>
</body>
</html>