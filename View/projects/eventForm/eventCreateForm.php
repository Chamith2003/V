<?php
$role = $_SESSION['role'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V</title>

    <!-- <link rel="stylesheet" href="View/projects/eventForm/eventcreate.css"> -->
    <link rel="stylesheet" type="text/css" href="/V/View/projects/eventForm/eventcreate.css">


</head>

<body>
    <div class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <img src="/V/View/projects/E_images/logo.png" alt="Beach Cleanup" />

                <div class="header-content">
                    <h2>Create New Event</h2>
                    <p>Organize an environmental impact event for the community</p>
                </div>
                <!-- <button class="close-btn" >×</button> -->
                <button class="close-btn"
                    onclick="window.location.href='/V/router.php?module=projects&action=projects'">×</button>
            </div>

            <div class="form-content">
                <h3 class="section-title">Event Information</h3>

                <!-- Updated Form Action -->
                <form action="../../../V/router.php?module=projects&action=createevent" method="POST"
                    enctype="multipart/form-data">

                    <input type="hidden" name="gmap_link" id="gmap_link">

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Event Name <span class="required">*</span></label>
                            <input type="text" name="name" placeholder="Enter event name..." required>
                        </div>

                        <div class="form-group date-input">
                            <label>Date <span class="required">*</span></label>
                            <input type="date" name="event_date" required>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Event Type <span class="required">*</span></label>
                            <select name="event_type" required>
                                <option value="" selected disabled>Select</option>
                                <option value="Beach Cleanup">Beach Cleanup</option>
                                <option value="Coral Restoration">Coral Restoration</option>
                                <option value="Mountain Cleanup">Mountain Cleanup</option>
                                <option value="City Cleanup">City Cleanup</option>
                                <option value="Tree Planting">Tree Planting</option>
                                <option value="Mangrove Restoration">Mangrove Restoration</option>
                            </select>
                        </div>

                        <div class="form-group time-input">
                            <label>Time <span class="required">*</span></label>
                            <input type="time" name="time" required>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Duration <span class="required">*</span></label>
                            <input type="text" name="duration" placeholder="e.g., 4 hours, 6 hours, Full day" required>
                        </div>

                        <div class="form-group">
                            <label>Maximum Participants <span class="required">*</span></label>
                            <input type="number" name="max_participants"
                                placeholder="Enter maximum number of participants" min="1" required>
                        </div>

                        <div class="form-group">
                            <label>Star point Allocation <span class="required">*</span></label>
                            <input type="number" name="starpoints_reward" placeholder="Enter the number of star points"
                                min="0" required>
                        </div>

                        <div class="form-group">
                            <label>Level point Allocation <span class="required">*</span></label>
                            <input type="number" name="levelpoints_reward"
                                placeholder="Enter the number of level points" min="0" required>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Event Location <span class="required">*</span></label>
                            <div class="input-button-group">
                                <input type="text" name="location" placeholder="Enter specific location address..."
                                    required>

                                <!-- <button type="button" id="map-location-btn" class="btn btn-map"><img src="/V/View/projects/eventForm/location.png" alt="location" />Map</button> -->
                                <button type="button" id="map-location-btn" class="btn btn-map"
                                    onclick="openMapPopup()"> <img src="/V/View/projects/eventForm/location.png"
                                        alt="location" />Map</button>


                            </div>
                        </div>

                        <div class="form-group">
                            <label>Event scale <span class="required">*</span></label>
                            <select name="scale" required>
                                <option value="" selected disabled>Select</option>
                                <option value="small">Small</option>
                                <option value="medium">Medium</option>
                                <option value="large">Large</option>
                            </select>
                        </div>

                        <!-- <div class="form-group">
                            <label>Event Location in map <span class="required">*</span></label>
                            <input type="text" name="location" placeholder="Enter specific location address..."
                                required>
                        </div> -->


                        <div class="form-group full-width">
                            <label>Item list <span class="required">*</span></label>
                            <div class="budget-section">
                                <div id="budget-items-container" class="budget-items-container">
                                    <div class="budget-item">
                                        <input type="text" name="budget_items[]" placeholder="Item name..." required>
                                        <input type="number" name="budget_unit_prices[]" placeholder="Unit price..."
                                            min="0" step="0.01" required class="item-unit-price">
                                        <input type="number" name="budget_amounts[]" placeholder="Quantity..." min="1"
                                            required class="item-amount">
                                        <input type="number" name="budget_prices[]" placeholder="Total..." min="0"
                                            step="0.01" readonly class="item-price">
                                        <button type="button" class="btn-remove-item"
                                            onclick="removeBudgetItem(this)">×</button>
                                    </div>
                                </div>
                                <button type="button" class="btn-add-item" onclick="addBudgetItem()">+ Add Item</button>

                                <div class="budget-total" style="display: none;">
                                    <span>Total Budget:</span>
                                    <span class="budget-total-amount" id="budget-total-amount">0.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Allocated Total Budget <span class="required">*</span></label>

                            <input type="number" name="allocated_budget" id="allocated_budget"
                                placeholder="Enter the amount of budget" readonly min="100" required>
                        </div>


                        <?php if ($role === 'manager'): ?>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="is_authorized" value="1" checked hidden>

                                </label>

                                <label>
                                    <div class="checkbox">
                                        <input type="checkbox" name="is_annual" value="1">This is an annual event
                                    </div>

                                </label>


                            </div>

                        <?php endif; ?>






                    </div>
                    <!-- <divn class="form-group"> -->
                    <!-- <label>Event Photo -->
                    <!-- <span class="required">*</span> -->
                    <!-- </label> -->
                    <!-- <div class="upload-area"> -->
                    <!-- <input type="file" name="photo" accept="image/*"> -->

                    <!-- <div class="upload-icon">🖼️</div>


                        <div class="upload-text">Click to upload photo</div>
                        <div class="upload-subtitle">JPG, PNG up to 5MB</div> -->
                    <!-- </div> -->
                    <!-- </div> -->

                    <div class="form-group">
                        <label>Short Description <span class="required">*</span></label>
                        <textarea name="description" rows="4" placeholder="Enter event description..."
                            required></textarea>
                    </div>

                    <div class="modal-footer">
                        <!-- <button type="reset" class="btn btn-cancel">Save as draft</button> -->
                        <button type="reset" class="btn btn-cancel">Cancel</button>
                        <button type="submit" class="btn btn-confirm">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="/V/View/projects/eventForm/eventcreate.js"></script>
</body>

</html>