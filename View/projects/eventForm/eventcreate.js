// Close modal
        document.querySelector('.close-btn').addEventListener('click', function() {
            document.querySelector('.modal-overlay').style.display = 'none';
        });

        // Highlight input focus
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.borderColor = '#81c4d4';
            });
            
            input.addEventListener('blur', function() {
                this.style.borderColor = '#ced4da';
            });
        });


function openMapPopup() {
    window.open(
        '/V/View/map/addlocation/addlocation.php',
        'MapPopup',
        'width=800,height=600,resizable=yes,scrollbars=yes'
    );
}

// Function to receive data from popup
function receiveLocation(gmapLink) {
    document.getElementById('gmap_link').value = gmapLink;
}



// Budget Items Management
let itemCount = 1;

function addBudgetItem() {
    const container = document.getElementById('budget-items-container');
    const newItem = document.createElement('div');
    newItem.className = 'budget-item';
    newItem.innerHTML = `
        <input type="text" name="budget_items[]" placeholder="Item name..." required>
        <input type="number" name="budget_unit_prices[]" placeholder="Unit price..." min="0" step="0.01" required class="item-unit-price">
        <input type="number" name="budget_amounts[]" placeholder="Quantity..." min="1" required class="item-amount">
        <input type="number" name="budget_prices[]" placeholder="Total..." min="0" step="0.01" readonly class="item-price">
        <button type="button" class="btn-remove-item" onclick="removeBudgetItem(this)">×</button>
    `;
    container.appendChild(newItem);
    
    // Add event listener to new price input
    // const priceInput = newItem.querySelector('.item-price');
    // priceInput.addEventListener('input', calculateTotal);
    // Add event listeners to unit price and amount inputs
    const unitPriceInput = newItem.querySelector('.item-unit-price');
    const amountInput = newItem.querySelector('.item-amount');
    
    unitPriceInput.addEventListener('input', () => calculateItemTotal(newItem));
    amountInput.addEventListener('input', () => calculateItemTotal(newItem));
    
    itemCount++;
}

function removeBudgetItem(button) {
    if (document.querySelectorAll('.budget-item').length > 1) {
        button.parentElement.remove();
        calculateTotal();
    } else {
        alert('At least one budget item is required');
    }
}
function calculateItemTotal(itemElement) {
    const unitPrice = parseFloat(itemElement.querySelector('.item-unit-price').value) || 0;
    const amount = parseFloat(itemElement.querySelector('.item-amount').value) || 0;
    const totalInput = itemElement.querySelector('.item-price');
    
    const itemTotal = unitPrice * amount;
    totalInput.value = itemTotal.toFixed(2);
    
    calculateTotal();
}


function calculateTotal() {
    const priceInputs = document.querySelectorAll('.item-price');
    let total = 0;
    
    priceInputs.forEach(input => {
        const value = parseFloat(input.value) || 0;
        total += value;
    });
    
    document.getElementById('budget-total-amount').textContent = total.toFixed(2);
    document.getElementById('allocated_budget').value = total.toFixed(2);
}

// // Initialize event listeners when DOM is loaded
// document.addEventListener('DOMContentLoaded', function() {
//     // Add event listener to initial price input
//     const initialPriceInput = document.querySelector('.item-price');
//     if (initialPriceInput) {
//         initialPriceInput.addEventListener('input', calculateTotal);
//     }
    
//     // Set initial total
//     calculateTotal();
// });
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to all initial budget items
    const budgetItems = document.querySelectorAll('.budget-item');
    budgetItems.forEach(item => {
        const unitPriceInput = item.querySelector('.item-unit-price');
        const amountInput = item.querySelector('.item-amount');
        
        if (unitPriceInput && amountInput) {
            unitPriceInput.addEventListener('input', () => calculateItemTotal(item));
            amountInput.addEventListener('input', () => calculateItemTotal(item));
        }
    });
    
    // Set initial total
    calculateTotal();
});