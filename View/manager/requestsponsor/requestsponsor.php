<!DOCTYPE html>
<html>
<head>
    <title>V</title>
    <!-- <link rel="stylesheet" type="text/css" href="request-sponsor.css"> -->
    <link rel="stylesheet" type="text/css" href="/V/View/manager/requestsponsor/requestsponsor.css">
         <?php include __DIR__ . '/../../navbar/navbar.php'; ?>
</head>    
<body>
    
    <div class="mainContent">
        <div class="header">
            <!-- <div class="header-icon">🤝</div> -->
            <h1>Request a Sponsor</h1>
            <p>Requesting a sponsor to sponsor an event</p>
        </div>
        
        <div class="form-container">
            <div class="form-content">
                <form id="donationForm" method="POST" action="/V/View/manager/reqsponsuccess/reqsponsuccess.php">
                    <div class="form-grid">
                        <div class="form-section">
                            <h2>Sponsor Information</h2>

                            <div class="form-group">
                                <label for="fullName">Full Name<span class="required">*</span></label>
                                <input type="text" id="fullName" name="fullName" class="form-control" placeholder="Enter sponsor full name" required>
                                <div class="error-message">Please enter sponsor full name</div>
                            </div>

                            
                            <div class="form-group">
                                <label for="email">Email Address<span class="required">*</span></label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="sponsor.email@example.com" required>
                                <div class="error-message">Please enter a valid email address</div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h2>Event Information</h2>
                        
                            <div class="form-group">
                                <label for="eventtype">Annual Event Name<span class="required">*</span></label>
                                <select id="eventtype" name="eventtype" class="form-control" required>
                                    <option value="">Select event name</option>
                                    <option value="beachcleanup">Beach Cleanup</option>
                                    <option value="citycleanup">City Cleanup</option>
                                    <option value="mountaincleanup">Mountain Cleanup</option>
                                    <option value="treeplanting">Tree Planting</option>
                                    <option value="coralrestoration">Coral Restoration</option>
                                    <option value="mangroverestoration">Mangrove Restoration</option>
                                </select>
                                <div class="error-message">Please select an event type</div>
                            </div>

                            <div class="form-group">
                                <label for="amount">Amount<span class="required">*</span></label>
                                <div class="currency-input">
                                    <input type="number" id="amount" name="amount" class="form-control" placeholder="0.00" min="1" step="0.1" required>
                                </div>
                                <div class="error-message">Please enter the amount for sponsorship</div>
                            </div>                          
                        </div>
                    </div>
                    
                    <div class="button-group">
                        <!-- <button type="button" class="btn btn-secondary" id="saveAsDraft">
                            Save Draft 
                        </button> -->
                        <button type="reset" class="btn btn-secondary" id="discardRequest">
                            Discard 
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitRequest">
                            Submit 
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Cancel button functionality
        document.getElementById('saveAsDraft').addEventListener('click', function() {
            if (confirm('Are you sure you want to cancel this request?')) {
                window.location.href = 'donation.php';
            }
        });
    </script>
</body>
</html>