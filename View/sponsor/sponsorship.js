// Handle payment method selection (Visual feedback only)
document.querySelectorAll('.payment-method-card').forEach(card => {
    card.addEventListener('click', function () {
        // Remove active class from all payment method cards
        document.querySelectorAll('.payment-method-card').forEach(c => c.classList.remove('active'));

        // Add active class to the clicked one
        this.classList.add('active');
    });
});

// Animation on page load
document.addEventListener('DOMContentLoaded', function () {
    const donationCard = document.querySelector('.payment-gateway-card');
    if (donationCard) {
        donationCard.style.opacity = '0';
        donationCard.style.transform = 'translateY(30px)';

        setTimeout(() => {
            donationCard.style.transition = 'all 0.6s ease';
            donationCard.style.opacity = '1';
            donationCard.style.transform = 'translateY(0)';
        }, 200);
    }
});

// Handle preset amount buttons
document.querySelectorAll('.amount-btn').forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault();

        // Remove active class from all buttons
        document.querySelectorAll('.amount-btn').forEach(btn => btn.classList.remove('active'));

        // Add active class to clicked button
        this.classList.add('active');

        const amount = this.dataset.amount;
        const amountInput = document.getElementById('donation_amount');

        if (amount === 'other') {
            // Clear the input and focus for manual entry
            amountInput.value = '';
            amountInput.placeholder = 'Enter your amount';
            amountInput.focus();
        } else {
            // Set the preset amount
            amountInput.value = amount;
            amountInput.placeholder = 'Enter custom amount';
        }
    });
});

// Clear preset selection when typing custom amount
const donationAmountInput = document.getElementById('donation_amount');
if (donationAmountInput) {
    donationAmountInput.addEventListener('input', function () {
        if (this.value) {
            // Remove active class from all preset buttons when user types
            document.querySelectorAll('.amount-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // If user clears the input, reset placeholder
            if (this.value === '') {
                this.placeholder = 'Enter custom amount';
            }
        }
    });
}

// Form validation and submission for PayHere
const donationForm = document.getElementById('donationForm');
if (donationForm) {
    donationForm.addEventListener('submit', function (e) {
        e.preventDefault();

        if (!validateDonationForm()) {
            return false;
        }

        // IMPORTANT: Update hidden amount field for PayHere
        const amount = document.getElementById('donation_amount').value;
        const hiddenAmount = document.getElementById('amount_hidden');
        if (hiddenAmount) {
            hiddenAmount.value = amount;
        }

        // Show loading state
        const submitBtn = this.querySelector('.btn-process-payment');
        if (submitBtn) {
            submitBtn.innerHTML = '⏳ Redirecting to Payment Gateway...';
            submitBtn.disabled = true;
        }

        // Submit form to controller for PayHere processing
        this.submit();
    });
}

// Validation function
function validateDonationForm() {

    const eventId = document.getElementById('event_id');
    if (eventId && !eventId.value) {
        alert('Please select an annual event');
        return false;
    }


    // Validate donor name
    const firstName = document.getElementById('first_name');
    if (firstName && !firstName.value.trim()) {
        alert('Please enter your name');
        firstName.focus();
        return false;
    }

    // Validate email
    const email = document.getElementById('email');
    if (email) {
        const emailValue = email.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailValue) {
            alert('Please enter your email address');
            email.focus();
            return false;
        }
        if (!emailRegex.test(emailValue)) {
            alert('Please enter a valid email address');
            email.focus();
            return false;
        }
    }

    // Validate phone
    const phone = document.getElementById('phone');
    if (phone) {
        const phoneValue = phone.value.trim();
        if (!phoneValue) {
            alert('Please enter your phone number');
            phone.focus();
            return false;
        }
        if (phoneValue.length < 10) {
            alert('Please enter a valid 10-digit phone number');
            phone.focus();
            return false;
        }
    }

    // Validate address
    const address = document.getElementById('address');
    if (address && !address.value.trim()) {
        alert('Please enter your address');
        address.focus();
        return false;
    }

    // Validate city
    const city = document.getElementById('city');
    if (city && !city.value.trim()) {
        alert('Please enter your city');
        city.focus();
        return false;
    }

    // Validate donation amount
    const donationAmount = document.getElementById('donation_amount');
    if (donationAmount) {
        const amount = parseFloat(donationAmount.value);
        if (!amount || amount < 1) {
            alert('Please enter a valid donation amount (minimum LKR 1)');
            donationAmount.focus();
            return false;
        }
        if (amount > 1000000) {
            alert('Maximum donation amount is LKR 1,000,000. For larger donations, please contact us directly.');
            donationAmount.focus();
            return false;
        }
    }

    return true;
}

// Format phone number (Sri Lankan format)
const phoneInput = document.getElementById('phone');
if (phoneInput) {
    phoneInput.addEventListener('input', function (e) {
        // Allow only numbers
        let value = e.target.value.replace(/\D/g, '');

        // Limit to 10 digits
        if (value.length > 10) {
            value = value.substr(0, 10);
        }

        e.target.value = value;
    });
}

// Only allow numbers and decimal point in amount field
if (donationAmountInput) {
    donationAmountInput.addEventListener('keypress', function (e) {
        const char = String.fromCharCode(e.which);
        if (!/[\d.]/.test(char)) {
            e.preventDefault();
        }

        // Prevent multiple decimal points
        if (char === '.' && this.value.includes('.')) {
            e.preventDefault();
        }
    });
}

// Add subtle hover effects to form inputs
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('focus', function () {
        this.style.transform = 'scale(1.02)';
        this.style.transition = 'transform 0.2s ease';
    });

    input.addEventListener('blur', function () {
        this.style.transform = 'scale(1)';
    });
});

// Add animation to amount buttons
document.querySelectorAll('.amount-btn').forEach(button => {
    button.addEventListener('mouseenter', function () {
        this.style.transform = 'translateY(-2px)';
    });

    button.addEventListener('mouseleave', function () {
        this.style.transform = 'translateY(0)';
    });
});