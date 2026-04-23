// Global variables
let volunteerPoints = 0;
const minRequiredPoints = 500;
const discountPercent = 0.2; // 20% max discount
const rupeesPerPoint = 10; // 1 point = LKR 10

// Store for each product card's state
const productStates = new Map();

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    loadVolunteerPoints();
    initializeAllProducts();
});

/**
 * Load volunteer's star points from server
 */
async function loadVolunteerPoints() {
    try {
        const response = await fetch('/V/router.php?module=merch&action=getpoints', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            volunteerPoints = data.points;
            document.getElementById('availablePoints').textContent = volunteerPoints;
            updateAllPointsDisplays();
        } else {
            console.error('Failed to load points:', data.message);
        }
    } catch (error) {
        console.error('Error loading points:', error);
    }
}

/**
 * Initialize all product cards
 */
function initializeAllProducts() {
    const productCards = document.querySelectorAll('.productCard');
    
    productCards.forEach(card => {
        const itemid = card.dataset.productId;
        const price = parseFloat(card.dataset.price);
        
        // Initialize state for this product
        productStates.set(itemid, {
            selectedSize: '',
            quantity: 1,
            maxStock: 0,
            useStarPoints: false,
            price: price
        });
        
        // Bind events for this card
        bindProductEvents(card, itemid);
    });
}

/**
 * Bind events for a specific product card
 */
function bindProductEvents(card, itemid) {
    const state = productStates.get(itemid);
    
    // Size selection
    const sizeButtons = card.querySelectorAll('.sizeButton:not([disabled])');
    sizeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const size = this.dataset.size;
            const stock = parseInt(this.dataset.stock);
            
            if (stock > 0) {
                state.selectedSize = size;
                state.maxStock = stock;
                updateSizeSelection(card, size);
                updatePurchaseButton(card, state);
                updatePriceSummary(card, state);
            }
        });
    });

    // Quantity controls
    const decreaseBtn = card.querySelector('.decreaseBtn');
    const increaseBtn = card.querySelector('.increaseBtn');
    
    decreaseBtn.addEventListener('click', () => {
        if (state.quantity > 1) {
            state.quantity--;
            updateQuantityDisplay(card, state);
            updatePriceSummary(card, state);
        }
    });

    increaseBtn.addEventListener('click', () => {
        if (state.selectedSize) {
            if (state.quantity < state.maxStock) {
                state.quantity++;
                updateQuantityDisplay(card, state);
                updatePriceSummary(card, state);
            } else {
                alert(`Only ${state.maxStock} items available in stock`);
            }
        }
    });

    // Star points checkbox
    const starPointsCheckbox = card.querySelector('.useStarPoints');
    if (starPointsCheckbox && !starPointsCheckbox.disabled) {
        starPointsCheckbox.addEventListener('change', function() {
            state.useStarPoints = this.checked;
            toggleStarPointsDetails(card, state);
            updatePriceSummary(card, state);
        });
    }

    // Purchase button
    const purchaseBtn = card.querySelector('.purchaseBtn');
    purchaseBtn.addEventListener('click', () => {
        if (state.selectedSize) {
            showPaymentModal(card, itemid, state);
        }
    });
}

/**
 * Update all points displays for all cards
 */
function updateAllPointsDisplays() {
    const canUsePoints = volunteerPoints >= minRequiredPoints;
    
    document.querySelectorAll('.productCard').forEach(card => {
        const insufficientWarning = card.querySelector('.insufficientWarning');
        const starPointsOption = card.querySelector('.starPointsOption');
        const starPointsCheckbox = card.querySelector('.useStarPoints');

        if (!canUsePoints) {
            if (insufficientWarning) insufficientWarning.style.display = 'flex';
            if (starPointsOption) starPointsOption.style.display = 'none';
            if (starPointsCheckbox) {
                starPointsCheckbox.checked = false;
                starPointsCheckbox.disabled = true;
            }
        } else {
            if (insufficientWarning) insufficientWarning.style.display = 'none';
            if (starPointsOption) starPointsOption.style.display = 'block';
            if (starPointsCheckbox) {
                starPointsCheckbox.disabled = false;
            }
        }
    });
}

/**
 * Update size selection for a card
 */
function updateSizeSelection(card, selectedSize) {
    const sizeButtons = card.querySelectorAll('.sizeButton');
    sizeButtons.forEach(button => {
        button.classList.remove('selected');
        if (button.dataset.size === selectedSize) {
            button.classList.add('selected');
        }
    });
}

/**
 * Update quantity display for a card
 */
function updateQuantityDisplay(card, state) {
    const quantityDisplay = card.querySelector('.quantityDisplay');
    quantityDisplay.textContent = state.quantity;
}

/**
 * Toggle star points details for a card
 */
function toggleStarPointsDetails(card, state) {
    const starPointsDetails = card.querySelector('.starPointsDetails');
    starPointsDetails.style.display = state.useStarPoints ? 'block' : 'none';
}

/**
 * Update price summary for a card
 */
function updatePriceSummary(card, state) {
    const subtotal = state.price * state.quantity;
    
    // Calculate max discount (20% of subtotal)
    const maxDiscount = subtotal * discountPercent;
    
    // Calculate discount from available points (1 point = LKR 10)
    const possibleDiscount = volunteerPoints * rupeesPerPoint;
    
    // Calculate star points discount (always calculate, even if not using points)
    let actualDiscount = 0;
    let pointsNeeded = 0;
    
    if (state.useStarPoints && volunteerPoints >= minRequiredPoints) {
        const maxPossibleDiscount = Math.min(maxDiscount, possibleDiscount);
        pointsNeeded = Math.floor(maxPossibleDiscount / rupeesPerPoint);
        pointsNeeded = Math.min(pointsNeeded, volunteerPoints);
        actualDiscount = pointsNeeded * rupeesPerPoint;
    }
    
    const finalAmount = subtotal - actualDiscount;

    // Update star points details
    if (state.useStarPoints) {
        const discountPerItem = actualDiscount / state.quantity;
        const pointsPerItem = pointsNeeded / state.quantity;
        
        card.querySelector('.pointsPerItem').textContent = Math.round(pointsPerItem);
        card.querySelector('.discountPerItem').textContent = `LKR ${discountPerItem.toFixed(2)}`;
        card.querySelector('.totalPointsNeeded').textContent = Math.round(pointsNeeded);
    }

    // Update price summary
    card.querySelector('.summaryQuantity').textContent = state.quantity;
    card.querySelector('.subtotal').textContent = `LKR ${subtotal.toFixed(2)}`;
    
    const discountRow = card.querySelector('.discountRow');
    if (state.useStarPoints && actualDiscount > 0) {
        discountRow.style.display = 'flex';
        card.querySelector('.discountAmount').textContent = `-LKR ${actualDiscount.toFixed(2)}`;
    } else {
        discountRow.style.display = 'none';
    }
    
    card.querySelector('.finalAmount').textContent = `LKR ${finalAmount.toFixed(2)}`;
}

/**
 * Update purchase button state
 */
function updatePurchaseButton(card, state) {
    const purchaseBtn = card.querySelector('.purchaseBtn');
    if (state.selectedSize) {
        purchaseBtn.disabled = false;
        purchaseBtn.textContent = 'Proceed to Payment';
    } else {
        purchaseBtn.disabled = true;
        purchaseBtn.textContent = 'Select Size to Continue';
    }
}

/**
 * Calculate purchase details for a product
 */
function calculatePurchaseDetails(state) {
    const subtotal = state.price * state.quantity;
    const maxDiscount = subtotal * discountPercent;
    const possibleDiscount = volunteerPoints * rupeesPerPoint;
    
    let actualDiscount = 0;
    let pointsUsed = 0;
    
    if (state.useStarPoints && volunteerPoints >= minRequiredPoints) {
        const maxPossibleDiscount = Math.min(maxDiscount, possibleDiscount);
        pointsUsed = Math.floor(maxPossibleDiscount / rupeesPerPoint);
        pointsUsed = Math.min(pointsUsed, volunteerPoints);
        actualDiscount = pointsUsed * rupeesPerPoint;
    }
    
    const finalAmount = subtotal - actualDiscount;
    
    return {
        subtotal,
        discount: actualDiscount,
        pointsUsed,
        finalAmount
    };
}

/* Show payment modal for a product */
function showPaymentModal(card, itemid, state) {
    const details = calculatePurchaseDetails(state);
 
    // Get item name from the card
    const itemName = card.querySelector('.volunteerDetails h3').textContent;

    // Create form and submit to PayHere process
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/V/router.php?module=merch&action=initiatepayment';
    
    // Add form fields
    const fields = {
        'item_id': itemid,
        'itemtype': itemName,
        'size': state.selectedSize,
        'quantity_taken': state.quantity,
        'use_points': state.useStarPoints ? 'true' : 'false',
        'points_to_redeem': Math.round(details.pointsUsed),
        'subtotal': details.subtotal.toFixed(2),
        'discount': details.discount.toFixed(2),
        'final_amount': details.finalAmount.toFixed(2)
    };
    
    // Create hidden inputs for each field
    for (const [key, value] of Object.entries(fields)) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    }
    
    // Add form to body and submit
    document.body.appendChild(form);
    form.submit();
    
}





