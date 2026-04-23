<html>
<head>
    <title>V</title>
    <link rel="stylesheet" type="text/css" href="/V/View/buymerch/inventory.css">
    <?php include __DIR__ . '/../navbar/navbar.php'; ?>
</head>
<body>
    <div class="mainContent">
        <div class="dashboardHeader">
            <h1 class="dashboardTitle">Merchandise Store</h1>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'volunteer'): ?>
            <p class="dashboardSubtitle">Purchase items using star points and online payment gateway</p>
            <?php endif; ?>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'sponsor'): ?>
            <p class="dashboardSubtitle">Purchase items using online payment gateway</p>
            <?php endif; ?>

            <div class="eventInfo">
                <span>Event Merchandise Store</span>
            </div>
        </div>

        <div class="dashboardLayout">
            <!-- Star Points Section -->
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'volunteer'): ?>
            <div class="progressSection">
                <div class="progressHeader">
                    <h2 class="progressTitle">Star Points Balance</h2>
                    <div class="progressStats">
                        <div class="statItem">
                            <div class="statNumber" id="availablePoints"><?php echo $starPoints; ?></div>
                            <div class="statLabel">Available Points</div>
                        </div>
                        
                        <div class="statItem">
                            <div class="statNumber">500</div>
                            <div class="statLabel">Min Required</div>
                        </div>
                    </div>
                    <div class="progressText">Use your earned star points to get discounts on purchases!</div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Inventory Section -->
            <div class="ratingSection">
                <div class="sectionHeader">
                    <h2 class="sectionTitle">Available Items</h2>
                    <div class="remainingCount"><?php echo count($itemsData); ?> Items Available</div>
                </div>

                <?php if (empty($itemsData)): ?>
                    <div class="noItems">
                        <p>No items available at the moment. Please check back later!</p>
                    </div>
                <?php else: ?>
                    <div class="itemsGrid">
                        <?php foreach ($itemsData as $item): ?>
                            <!-- Product Card -->
                            <div class="productCard" data-product-id="<?php echo $item['itemid']; ?>" data-price="<?php echo $item['price_raw']; ?>">
                                <div class="volunteerHeader">
                                <div class="imageContainer">
                                    <?php if (!empty($item['image_path'])): ?>
                                        <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['itemtype']); ?>" class="productImage">
                                    <?php else: ?>
                                        <div class="productEmoji"></div>
                                    <?php endif; ?>
                                </div>
                                <div class="volunteerDetails">
                                    <h3><?php echo htmlspecialchars($item['itemtype']); ?></h3>
                                    <p><?php echo htmlspecialchars($item['description']); ?></p>
                                    <div class="productPrice">LKR <?php echo $item['price']; ?></div>
                                </div>
                            </div>

                            <!-- Size Selection -->
                            <div class="volunteerTasks">
                                <div class="tasksTitle">Select Size:</div>
                                <div class="sizeGrid">
                                    <?php foreach ($item['sizes'] as $size => $stock): ?>
                                        <?php if ($stock > 0): ?>
                                            <button class="sizeButton" data-size="<?php echo $size; ?>" data-stock="<?php echo $stock; ?>">
                                                <div class="sizeLabel"><?php echo $size; ?></div>
                                                <div class="stockLabel"><?php echo $stock; ?> left</div>
                                            </button>
                                        <?php else: ?>
                                            <button class="sizeButton" data-size="<?php echo $size; ?>" data-stock="0" disabled>
                                                <div class="sizeLabel"><?php echo $size; ?></div>
                                                <div class="stockLabel">Out of stock</div>
                                            </button>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Quantity and Payment Options -->
                            <div class="purchaseControls">
                                <div class="quantitySection">
                                    <label class="ratingLabel">Quantity:</label>
                                    <div class="quantityControls">
                                        <button class="quantityBtn decreaseBtn">-</button>
                                        <span class="quantityDisplay">1</span>
                                        <button class="quantityBtn increaseBtn">+</button>
                                    </div>
                                </div>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'volunteer'): ?>
                                <div class="paymentSection">
                                    <label class="ratingLabel">Payment Options:</label>
                                    
                                    <!-- Insufficient Points Warning -->
                                    <div class="insufficientPoints insufficientWarning" style="<?php echo $starPoints < 500 ? '' : 'display: none;'; ?>">
                                        <div class="warningIcon">⚠️</div>
                                        <div class="warningText">You need at least 500 points to use star points redemption</div>
                                    </div>

                                    <!-- Star Points Option -->
                                    <div class="starPointsOption">
                                        <div class="checkboxContainer">
                                            <input type="checkbox" class="useStarPoints starPointsCheckbox" <?php echo $starPoints < 500 ? 'disabled' : ''; ?>>
                                            <label class="checkboxLabel">Use Star Points (Max 20% discount)</label>
                                        </div>
                                        
                                        <div class="starPointsDetails" style="display: none;">
                                            <div class="pointsBreakdown">
                                                <div class="pointsItem">
                                                    <strong>Points per item:</strong> <span class="pointsPerItem">0</span> points
                                                </div>
                                                <div class="pointsItem">
                                                    <strong>Discount per item:</strong> <span class="discountPerItem">LKR 0.00</span>
                                                </div>
                                                <div class="pointsItem">
                                                    <strong>Total points needed:</strong> <span class="totalPointsNeeded">0</span> points
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Price Summary -->
                            <div class="priceSummary">
                                <div class="tasksTitle">Price Summary:</div>
                                <div class="priceBreakdown">
                                    <div class="priceItem">
                                        <span>Subtotal (<span class="summaryQuantity">1</span> × LKR <?php echo $item['price']; ?>):</span>
                                        <span class="subtotal">LKR <?php echo $item['price']; ?></span>
                                    </div>
                                    <div class="priceItem discount discountRow" style="display: none;">
                                        <span>Star Points Discount:</span>
                                        <span class="discountAmount">-LKR 0.00</span>
                                    </div>
                                    <div class="priceItem total">
                                        <span>Online Payment Required:</span>
                                        <span class="finalAmount">LKR <?php echo $item['price']; ?></span>
                                    </div>
                                </div>
                            </div>

                            <button class="submitRating purchaseBtn" disabled>Select Size to Continue</button>
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>         
        </div>
    </div>

    <script>
        // Pass PHP data to JavaScript
        const availablePoints = <?php echo $starPoints; ?>;
        const minPointsRequired = 500;
    </script>
    <script src="/V/View/buymerch/inventory.js"></script>
</body>
</html>