<?php
// Get data from controller
$items = isset($itemsResult['data']) ? $itemsResult['data'] : [];

// Calculate statistics
$totalItems = count($items);
$totalStock = 0;
$lowStockItems = 0;
$totalValue = 0;

foreach ($items as $item) {
    $itemTotalStock = 0;
    foreach ($item['sizes'] as $stock) {
        $itemTotalStock += $stock;
    }
    $totalStock += $itemTotalStock;
    $totalValue += $item['price'] * $itemTotalStock;
    
    // Check if any size has low stock (1-10)
    foreach ($item['sizes'] as $stock) {
        if ($stock > 0 && $stock <= 10) {
            $lowStockItems++;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V</title>
    <link rel="stylesheet" type="text/css" href="/V/View/item/inventorymanage.css">
    <?php include __DIR__ . '/../navbar/navbar.php'; ?>
</head>
<body>
    <div class="mainContent">
        <div class="dashboardHeader">
            <h1 class="dashboardTitle">Inventory Management</h1>
            <p class="dashboardSubtitle">Manage store items, stock levels, and pricing</p>
            <div class="eventInfo">
                <span>📦</span>
                <span>Manager Dashboard</span>
            </div>
        </div>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] ?>">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>

        <div class="dashboardLayout">
            <!-- Statistics Section -->
            <div class="progressSection">
                <div class="progressHeader">
                    <h2 class="progressTitle">Inventory Statistics</h2>
                    <div class="progressStats">
                        <div class="statItem">
                            <div class="statNumber"><?= $totalItems ?></div>
                            <div class="statLabel">Total Items</div>
                        </div>
                        <div class="statItem">
                            <div class="statNumber"><?= $totalStock ?></div>
                            <div class="statLabel">Total Stock</div>
                        </div>
                        <!--<div class="statItem">
                            <div class="statNumber"><?= $lowStockItems ?></div>
                            <div class="statLabel">Low Stock Items</div>
                        </div>-->
                        <div class="statItem">
                            <div class="statNumber">LKR <?= number_format($totalValue, 2) ?></div>
                            <div class="statLabel">Total Value</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Controls -->
            <div class="ratingSection">
                <div class="sectionHeader">
                    <h2 class="sectionTitle">Manage Inventory</h2>
                    <div class="managementControls">
                        <button class="addItemBtn" id="addItemBtn">
                            <span>➕</span>
                            <span>Add New Item</span>
                        </button>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="searchSection">
                    <div class="searchContainer">
                        <input type="text" id="searchInput" class="searchInput" placeholder="Search items by name or description...">
                        <div class="searchIcon">🔍</div>
                    </div>
                </div>

                <!-- Items Grid -->
                <div class="itemsGrid" id="itemsGrid">
                    <?php foreach ($items as $item): ?>
                        <div class="productCard" data-item-id="<?= $item['itemid'] ?>">
                            
                            <div class="productHeader">
                                <div class="imageContainer">
                                    <?php if (!empty($item['image_path'])): ?>
                                        <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['itemtype']) ?>" class="productImage">
                                    <?php else: ?>
                                        <div class="productEmoji">👕</div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="productDetails">
                                    <h3><?= htmlspecialchars($item['itemtype']) ?></h3>
                                    <p><?= htmlspecialchars($item['description']) ?></p>
                                    <div class="productPrice">LKR <?= number_format($item['price'], 2) ?></div>
                                </div>
                            </div>

                            <div class="stockStatus">
                                <h4>Stock Status</h4>
                                <div class="sizeGrid">
                                    <?php foreach ($item['sizes'] as $size => $stock): ?>
                                        <?php
                                        $className = 'stockBox';
                                        if ($stock == 0) $className .= ' out-of-stock';
                                        elseif ($stock <= 10) $className .= ' low-stock';
                                        ?>
                                        <div class="<?= $className ?>">
                                            <span class="sizeLabel"><?= $size ?></span>
                                            <span class="stockLabel"><?= $stock ?> left</span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="productActions">
                                <button class="editBtn" onclick="editItem(<?= $item['itemid'] ?>)">✏️ Edit</button>
                                <form method="POST" action="/V/router.php?module=inventory&action=deleteitem" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                    <input type="hidden" name="id" value="<?= $item['itemid'] ?>">
                                    <button type="submit" class="deleteBtn">🗑️ Delete</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Empty State -->
                <?php if (empty($items)): ?>
                    <div class="emptyState">
                        <div class="emptyIcon">📦</div>
                        <h3>No items found</h3>
                        <p>Start by adding your first inventory item</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Add/Edit Item Modal -->
    <div class="paymentModal" id="itemModal" style="display: none;">
        <div class="paymentContent">
            <div class="sectionHeader">
                <h2 class="sectionTitle" id="modalTitle">📝 Add New Item</h2>
                <button class="closeBtn" id="closeModal">✕</button>
            </div>

            <form id="itemForm" method="POST" enctype="multipart/form-data" class="itemForm">
                <input type="hidden" id="itemId" name="id">
                <input type="hidden" id="formAction" name="action" value="createitem">
                
                <div class="formSection">
                    <div class="formGroup">
                        <label class="formLabel">Item Name</label>
                        <input type="text" id="itemName" name="name" class="formInput" placeholder="e.g., Event T-Shirt 2024" required>
                    </div>

                    <div class="formGroup">
                        <label class="formLabel">Description</label>
                        <input type="text" id="itemDescription" name="description" class="formInput" placeholder="e.g., Premium quality event t-shirt" required>
                    </div>

                    <div class="formGroup">
                        <label class="formLabel">Price (LKR)</label>
                        <input type="number" id="itemPrice" name="price" class="formInput" step="0.01" min="0" placeholder="2500.00" required>
                    </div>

                    
                    <!--<div class="formGroup">
                        <label class="formLabel">Item Icon</label>
                        <div class="emojiPicker" id="emojiPicker">
                            <div class="emojiOption selected" data-emoji="👕">👕</div>
                            <div class="emojiOption" data-emoji="👔">👔</div>
                            <div class="emojiOption" data-emoji="👒">👒</div>
                        
                        </div>
                    -->
                    <div class="formGroup">
                        <label class="formLabel">Item Image</label>
                        <input type="file" id="itemImage" name="item_image" class="formInput" accept="image/jpeg,image/png,image/webp">
                        <input type="hidden" id="existingImage" name="existing_image" value="">
                        <div id="imagePreview" style="margin-top:10px; display:none;">
                        <img id="previewImg" src="" style="width:120px;height:120px;object-fit:cover;border-radius:12px;border:2px solid rgba(255,255,255,0.2);">
                        </div>
                    </div>

                    <div class="formGroup">
                        <label class="formLabel">Stock Quantities by Size</label>
                        <div class="sizesInput">
                            <?php
                            $sizes = ['XS','S','M','L','XL','XXL'];
                            foreach ($sizes as $size) {
                                echo "<div class='sizeInputGroup'>
                                        <label class='sizeLabel'>$size</label>
                                        <input type='number' id='stock$size' name='sizes[$size]' class='sizeInput' min='0' value='0'>
                                      </div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="paymentActions">
                    <button type="button" class="backBtn" id="cancelBtn">Cancel</button>
                    <button type="submit" class="completeBtn" id="saveBtn">Save Item</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Pass PHP items data to JavaScript
        const itemsData = <?= json_encode($items) ?>;
    </script>
    <script src="/V/View/item/inventorymanage.js"></script>
</body>
</html>