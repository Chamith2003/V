document.addEventListener('DOMContentLoaded', function() {
    console.log('Submitted application page loaded');
});

function deleteApplication() {
    if (confirm('Are you sure you want to delete this application?\n\nThis will:\n• Remove your application from the system\n• Reset your representative status\n\nThis action CANNOT be undone!')) {
        window.location.href = '/V/router.php?module=volunteer&action=deleteApplication';
    }
}

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
    notification.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
    
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
        notification.style.animation = 'slideOutRight 0.4s';
        setTimeout(() => notification.remove(), 400);
    }, 3500);
}