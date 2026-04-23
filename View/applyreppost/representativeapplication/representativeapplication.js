// Helper function for notifications
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.padding = '15px 25px';
    notification.style.borderRadius = '8px';
    notification.style.zIndex = '10000';
    notification.style.fontWeight = '600';
    
    if (type === 'success') {
        notification.style.background = 'linear-gradient(135deg, #27ae60, #229954)';
        notification.style.color = 'white';
    } else if (type === 'error') {
        notification.style.background = 'linear-gradient(135deg, #e74c3c, #c0392b)';
        notification.style.color = 'white';
    } else if (type === 'info') {
        notification.style.background = 'linear-gradient(135deg, #3498db, #2980b9)';
        notification.style.color = 'white';
    }
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

function deleteApplicationFromEdit() {
    if (confirm('Are you sure you want to delete this application?\n\nThis will:\n• Remove your application from the system\n• Reset your representative status\n\nThis action CANNOT be undone!')) {
        window.location.href = '/V/router.php?module=volunteer&action=deleteApplication';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('applicationForm').addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
        }
    });

    document.getElementById('cancelBtn').addEventListener('click', function() {
        resetForm();
    });

    document.getElementById('reasonForApplication').addEventListener('input', function() {
        clearError('reasonForApplication');
    });

    document.getElementById('experience').addEventListener('input', function() {
        clearError('experience');
    });

    document.getElementById('termsAccepted').addEventListener('change', function() {
        clearError('termsAccepted');
    });
});

function collectFormData() {
    formData.reasonForApplication = document.getElementById('reasonForApplication').value;
    formData.professionalLinks = document.getElementById('professionalLinks').value;
    formData.experience = document.getElementById('experience').value;
    formData.termsAccepted = document.getElementById('termsAccepted').checked;
}

function validateForm() {
    let isValid = true;
    const errors = {};

    collectFormData();

    if (!formData.reasonForApplication.trim()) {
        errors.reasonForApplication = "Reason for application is required";
        isValid = false;
    }

    if (formData.experience < '5' ) {
        errors.experience = "To become a representative your years of experience must greater than or equal 5 years";
        isValid = false;
    }

    if (!formData.termsAccepted) {
        errors.termsAccepted = "You must accept the terms and conditions";
        isValid = false;
    }

    displayErrors(errors);

    return isValid;
}

function displayErrors(errors) {
    const errorElements = document.querySelectorAll('.error-message');
    errorElements.forEach(el => el.textContent = '');
    
    const inputElements = document.querySelectorAll('.input, .textarea');
    inputElements.forEach(el => el.classList.remove('error'));

    Object.keys(errors).forEach(field => {
        const errorElement = document.getElementById(field + 'Error');
        const inputElement = document.getElementById(field);
        
        if (errorElement) {
            errorElement.textContent = errors[field];
        }
        
        if (inputElement) {
            inputElement.classList.add('error');
        }
    });
}

function clearError(field) {
    const errorElement = document.getElementById(field + 'Error');
    const inputElement = document.getElementById(field);
    
    if (errorElement) {
        errorElement.textContent = '';
    }
    
    if (inputElement) {
        inputElement.classList.remove('error');
    }
}