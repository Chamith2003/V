<html>

<head>
    <link rel="stylesheet" href="/V/View/admin/systemsettings/systemsettingsadminpanel.css">
    <title>V</title>
    <?php include __DIR__ . '/../../navbar/navbar.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<body>
    <div class="adminSettingsContainer">
        <div class="adminSettingsHeader">
            <h1>System Settings</h1>
            <p>Manage and configure platform's site settings</p>
        </div>

        <div class="lowerContainer">
            <div class="lowerInnerContainer">


                <!-- Site Content Tab -->
                <div id="innercontent" class="innerContent active">


                    <div class="settingsSection">
                        <h3 class="sectionTitle">Manage Homepage Highlights
                        </h3>
                        <div class="sectionHeader">
                            <p><i class="fa-solid fa-pen-to-square"></i> Manage featured items on your homepage</p>
                            <button class="addHighlightButton" onclick="openAddHighlightModal()">
                                <span><img src="/V/View/resources/plus.png"></span> Add New Highlight
                            </button>
                        </div>
                        <div class="highlightsList" id="highlightsList">
                            <!-- Highlights will be rendered here dynamically -->
                        </div>
                    </div>

                    <!-- Add/Edit Highlight Modal -->
                    <div id="highlightOverlay" class="modalOverlay">
                        <div class="modal">
                            <div class="modalHeader">

                                <h3 class="modalTitle" id="highlightModalTitle">Add New Highlight</h3>
                                <span class="closeButton" onclick="closeHighlightModal()">&times;</span>
                            </div>
                            <div class="modalBody">
                                <form id="highlightForm">
                                    <input type="hidden" id="highlightId">

                                    <div class="formGroup">
                                        <label class="formLabel">Title</label>
                                        <input type="text" class="formInput" id="highlightTitle" required>
                                    </div>

                                    <div class="formGroup">
                                        <label class="formLabel">Description</label>
                                        <textarea class="formTextarea" id="highlightDesc"></textarea>
                                    </div>

                                    <div class="formGroup">
                                        <label class="formLabel">Image</label>
                                        <input type="file" class="formInput" id="highlightMedia" accept="image/*">
                                    </div>
                                    <div class="formGroup">
                                        <label class="formLabel">Display Order</label>
                                        <input type="number" class="formInput" id="highlightOrder" value="1" max="6"
                                            min="1">
                                    </div>

                                    <div class="formGroup">
                                        <label class="formLabel">Status</label>
                                        <select class="formSelect" id="highlightStatus">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>

                                    <div class="buttonGroup">
                                        <button type="submit" class="submitButton ">
                                            Save Highlight
                                        </button>
                                        <button type="button" class="cancelButton" onclick="closeHighlightModal()">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div id="innercontent" class="innerContent active">
                    <div class="settingsSection"> -->
                        <!-- <h3 class="sectionTitle">Contact Us Information

                            <div class="buttonGroup">
                                <button class="saveButton" onclick="">
                                    Edit Details
                                </button>

                            </div>


                        </h3> -->

                        <!-- <div class="formGroup">
                            <label class="formLabel">Footer Text</label>
                            <textarea class="formTextarea" id="footerAbout"
                                placeholder="Enter footer about text"></textarea>
                        </div> -->

                        <!-- <div class="formGroup">
                            <label class="formLabel">Contact Email</label>
                            <input type="email" class="formInput" id="contactEmail" placeholder="contact@example.com">
                        </div> -->
                        <!-- <div class="formGroup">
                            <label class="formLabel">Contact Phone</label>
                            <input type="tel" class="formInput" id="contactPhone" placeholder="+1 234 567 8900">
                        </div> -->

                        <!-- <div class="formGroup">
                            <label class="formLabel">Address</label>
                            <input type="text" class="formInput" id="address" placeholder="Enter physical address">
                        </div> -->
                    <!-- </div>
                </div> -->

                

            </div>







        </div>
    </div>
    </div>





    <script src="/V/View/admin/systemsettings/systemsettingsadminpanel.js"></script>
</body>

</html>