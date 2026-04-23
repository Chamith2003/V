//Implement Bio counter if not already implemented
//     // Bio character counter
//     const bioField = document.getElementById('bio');
//     const charCount = document.querySelector('.char-count');
    
//     if (bioField && charCount) {
//         const updateCharCount = () => {
//             const length = bioField.value.length;
//             charCount.textContent = `${length}/500 characters`;
//         };
        
//         bioField.addEventListener('input', updateCharCount);
//         updateCharCount(); // Initial count
//     }
// });


document.addEventListener('DOMContentLoaded', () => {
    const menuItems = document.querySelectorAll('.menu-item');
    const contentSections = document.querySelectorAll('.content-section');
    const changePasswordBtn = document.getElementById('changePasswordBtn');
    const deleteAccountBtn = document.getElementById('deleteAccountBtn'); // New button
    const changePasswordModal = document.getElementById('changePasswordModal');
    const deleteAccountModal = document.getElementById('deleteAccountModal'); // New modal
    const cancelPasswordBtn = document.getElementById('cancelPasswordBtn');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn'); // New cancel button
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn'); // New confirm button
    const modalCloseBtn = document.querySelector('.modal-close-btn');
    const updatePasswordBtn = document.getElementById('updatePasswordBtn');
    const successMessage = document.getElementById('passwordUpdateSuccessMessage');

    // Personal Info Edit Elements
    const editProfileBtn = document.getElementById('editProfileBtn');
    const formActions = document.getElementById('formActions');
    const saveProfileBtn = document.getElementById('saveProfileBtn');
    const cancelProfileBtn = document.getElementById('cancelProfileBtn');
    const formFields = document.querySelectorAll('.form-grid input, #bio');

const availDisplay = document.getElementById('availabilityDisplay');
    const availEdit = document.getElementById('availabilityEditMode');

    // New message element
    const accountDeletedSuccessMessage = document.getElementById('accountDeletedSuccessMessage');

    menuItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();

            // Remove active class from all menu items
            menuItems.forEach(i => i.classList.remove('active'));

            // Add active class to the clicked item
            item.classList.add('active');

            // Hide all content sections
            contentSections.forEach(section => section.classList.remove('active'));

            // Show the corresponding content section
            const contentId = item.getAttribute('data-content-id');
            const targetSection = document.getElementById(contentId);
            if (targetSection) {
                targetSection.classList.add('active');
            }
        });
    });

    // Show the change password modal
    changePasswordBtn.addEventListener('click', () => {
        changePasswordModal.classList.add('active');
    });

    // Show the delete account modal
    deleteAccountBtn.addEventListener('click', () => {
        deleteAccountModal.classList.add('active');
    });

    // Hide the change password modal
    const hideChangePasswordModal = () => {
        changePasswordModal.classList.remove('active');
        // Hide success message and clear fields on close
        successMessage.style.display = 'none';
        document.getElementById('currentPassword').value = '';
        document.getElementById('newPassword').value = '';
        document.getElementById('confirmNewPassword').value = '';
    };

    // Hide the delete account modal
    const hideDeleteAccountModal = () => {
        deleteAccountModal.classList.remove('active');
    };

    cancelPasswordBtn.addEventListener('click', hideChangePasswordModal);
    modalCloseBtn.addEventListener('click', hideChangePasswordModal);

    // Hide change password modal if user clicks outside the modal
    changePasswordModal.addEventListener('click', (e) => {
        if (e.target.id === 'changePasswordModal') {
            hideChangePasswordModal();
        }
    });

    // Hide delete account modal on cancel
    cancelDeleteBtn.addEventListener('click', hideDeleteAccountModal);

    // Handle account deletion on confirm
    // confirmDeleteBtn.addEventListener('click', () => {
    //     // In a real app, you would add an API call to delete the account here.

    //     // 1. Hide the delete confirmation modal
    //     hideDeleteAccountModal();

    //     // 2. Show the success message
    //     accountDeletedSuccessMessage.style.display = 'block';

    //     // 3. Automatically hide the message and disable delete button after 3 seconds
    //     setTimeout(() => {
    //         accountDeletedSuccessMessage.style.display = 'none';
    //         deleteAccountBtn.disabled = true;
    //         deleteAccountBtn.innerText = 'Deleted';
    //         deleteAccountBtn.style.cursor = 'not-allowed';
    //     }, 3000);
    // });
    // Handle account deletion on confirm
confirmDeleteBtn.addEventListener('click', async () => {
    confirmDeleteBtn.disabled = true;
    confirmDeleteBtn.innerText = 'Deleting...';

    try {
        const response = await fetch('/V/router.php?module=user&action=deleteaccount', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            hideDeleteAccountModal();
            accountDeletedSuccessMessage.style.display = 'block';
            
            // Redirect to homepage after 2 seconds
            setTimeout(() => {
                window.location.href = '/V/router.php?module=page&action=homepage';
            }, 2000);
        } else {
            confirmDeleteBtn.disabled = false;
            confirmDeleteBtn.innerText = 'Delete Account';
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        confirmDeleteBtn.disabled = false;
        confirmDeleteBtn.innerText = 'Delete Account';
        alert('Network error. Please try again.');
    }
});

    // Hide delete account modal if user clicks outside the modal
    deleteAccountModal.addEventListener('click', (e) => {
        if (e.target.id === 'deleteAccountModal') {
            hideDeleteAccountModal();
        }
    });


    // Handle password update logic with AJAX
    updatePasswordBtn.addEventListener('click', async (e) => {
        e.preventDefault();
        
        const form = document.getElementById('changePasswordForm');
        const currentPassword = document.getElementById('currentPassword').value;
        const newPassword = document.getElementById('newPassword').value;
        const confirmNewPassword = document.getElementById('confirmNewPassword').value;
        const successMsg = document.getElementById('passwordUpdateSuccessMessage');
        const errorMsg = document.getElementById('passwordUpdateErrorMessage');
        
        // Hide previous messages
        successMsg.style.display = 'none';
        errorMsg.style.display = 'none';
        
        // Client-side validation
        if (!currentPassword || !newPassword || !confirmNewPassword) {
            errorMsg.textContent = '✗ All fields are required';
            errorMsg.style.display = 'block';
            return;
        }
        
        if (newPassword !== confirmNewPassword) {
            errorMsg.textContent = '✗ New passwords do not match!';
            errorMsg.style.display = 'block';
            return;
        }
        
        if (newPassword.length < 8) {
            errorMsg.textContent = '✗ Password must be at least 8 characters';
            errorMsg.style.display = 'block';
            return;
        }
        
        // Submit form via AJAX
        try {
            const formData = new FormData(form);
            const response = await fetch('/V/router.php?module=user&action=updatepassword', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });
            
            // Read response as text first (PHP might return HTML on error)
            const responseText = await response.text();
            
            // Try to parse as JSON
            let responseData;
            try {
                responseData = JSON.parse(responseText);
            } catch (e) {
                

                // If not JSON, treat as error
                errorMsg.textContent = '✗ An error occurred. Please try again.';
                errorMsg.style.display = 'block';
                console.error('Response:', responseText);
                return;
            }
            
            if (responseData.success) {
                successMsg.textContent = '✓ ' + responseData.message;
                successMsg.style.display = 'block';
                
                // Clear form fields
                document.getElementById('currentPassword').value = '';
                document.getElementById('newPassword').value = '';
                document.getElementById('confirmNewPassword').value = '';
                
                // Close modal after 2 seconds
                setTimeout(() => {
                    hideChangePasswordModal();
                }, 2000);
            } else {
                errorMsg.textContent = '✗ ' + responseData.message;
                errorMsg.style.display = 'block';
            }
        } catch (error) {
            console.error('Error:', error);
            errorMsg.textContent = '✗ Network error. Please try again.';
            errorMsg.style.display = 'block';
        }
    });

    // Edit Profile logic
    const toggleEditMode = (isEditing) => {
        formFields.forEach(field => {
            if (isEditing) {
                field.removeAttribute('readonly');
                field.style.cursor = 'auto';
            } else {
                field.setAttribute('readonly', true);
                field.style.cursor = 'not-allowed';
            }
        });

        if (isEditing) {
            editProfileBtn.style.display = 'none';
            formActions.classList.add('active');

            if (availDisplay) availDisplay.style.display = 'none';
            if (availEdit) availEdit.style.display = 'block';
        } else {
            editProfileBtn.style.display = 'block';
            formActions.classList.remove('active');

            if (availDisplay) availDisplay.style.display = 'block';
            if (availEdit) availEdit.style.display = 'none';
        }
    };

    editProfileBtn.addEventListener('click', () => toggleEditMode(true));
    // NEW CODE - Proper form submission
saveProfileBtn.addEventListener('click', async (e) => {
    e.preventDefault();
    
    const form = document.querySelector('form');
    const formData = new FormData(form);
    
    // Collect availability data
    const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    const times = ['Morning', 'Afternoon', 'Evening'];
    
    let availabilityChanged = false;
    days.forEach(day => {
        times.forEach(time => {
            const checkbox = document.querySelector(`input[name="${day}_${time}"]`);
            if (checkbox && checkbox.checked) {
                formData.append(`${day}_${time}`, 'on');
                availabilityChanged = true;
            }
        });
    });
    
    try {
        const response = await fetch('/V/router.php?module=user&action=profileUpdate', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        });
        
        const responseText = await response.text();
        let data;
        
        try {
            data = JSON.parse(responseText);
        } catch (e) {
            // If not JSON, redirect worked
            if (response.ok) {
                toggleEditMode(false);
                
                // Show success message if availability was changed
                if (availabilityChanged) {
                    showAvailabilitySuccessMessage();
                }
                
                location.reload();
                return;
            }
            throw new Error('Invalid response from server');
        }
        
        if (data.success) {
            toggleEditMode(false);
            
            // Show success message if availability was changed
            if (availabilityChanged) {
                showAvailabilitySuccessMessage();
                // Delay reload to show notification
                setTimeout(() => {
                    location.reload();
                }, 2000);
            } else {
                location.reload();
            }
        } else {
            alert('Error: ' + (data.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while updating profile: ' + error.message);
    }
});

function showAvailabilitySuccessMessage() {
    const message = document.createElement('div');
    message.className = 'availability-update-notification';
    message.innerHTML = `
        <div style="background: #d4edda; border: 2px solid #28a745; border-radius: 8px; padding: 16px 20px; display: flex; align-items: flex-start; gap: 12px; position: fixed; top: 30px; right: 30px; z-index: 99999; max-width: 420px; box-shadow: 0 6px 20px rgba(0,0,0,0.2); font-family: Arial, sans-serif;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="2.5" style="flex-shrink: 0; margin-top: 2px;">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            <div style="color: #155724; flex: 1;">
                <strong style="font-size: 1.05rem; display: block; margin-bottom: 5px;">✓ Availability Updated!</strong>
                <p style="margin: 0; font-size: 0.95rem; line-height: 1.4;">
                    Your availability has been updated successfully. Remember to attend all pre-joined events during these times.
                </p>
            </div>
        </div>
    `;
    
    document.body.appendChild(message);
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        message.style.opacity = '0';
        message.style.transition = 'opacity 0.3s ease';
        setTimeout(() => message.remove(), 300);
    }, 4000);
}
    cancelProfileBtn.addEventListener('click', () => toggleEditMode(false));



});

//moved to achievement.js
// //leaderbooard data sample

// const leaderboardData = [
//     { rank: 1, name: "Taniya Jayaweera", points: 3924 },
//     { rank: 2, name: "Videesha Navodi", points: 3756 },
//     { rank: 3, name: "Chamith Nimsara", points: 3234 },
//     { rank: 4, name: "Thivinya Abeyrathne", points: 2956 },
//     { rank: 5, name: "Nadin Bandara", points: 2847, isCurrentUser: true },
//     { rank: 6, name: "Amaya Gunathilake", points: 2634 }
// ];

// // Render leaderboard
// const leaderboardContainer = document.querySelector('.achievements-leaderboard');
// const currentUser = leaderboardData.find(u => u.isCurrentUser);

// leaderboardContainer.innerHTML = `
//     <div class="leaderboard">
//         <h2 class="leaderboard-title">🏆 Leaderboard</h2>
//          <div class="leaderboard-separator"></div>
//         <div class="user-rank-display">
//             <div class="user-rank-number">#${currentUser.rank}</div>
//             <div>Your Current Rank</div>
//         </div>
//         <ul class="leaderboard-list">
//             ${leaderboardData.map(u => `
//                 <li class="leaderboard-item ${u.isCurrentUser ? 'current-user' : ''}">
//                     <span class="rank">#${u.rank}</span>
//                     <div class="user-info">${u.name}${u.isCurrentUser ? ' (You)' : ''}</div>
//                     <span class="points">${u.points.toLocaleString()} pts</span>
//                 </li>
//             `).join('')}
//         </ul>
//          <div class="leaderboard-separator"></div>
    
//         <div class="level-progress">
//         <svg class="level-progress-circle" viewBox="0 0 120 120">
//         <circle cx="60" cy="60" r="50" class="progress-bg"></circle>
//         <circle cx="60" cy="60" r="50" class="progress-fill" style="stroke-dasharray: ${2 * Math.PI * 50}; stroke-dashoffset: ${2 * Math.PI * 50 - ((currentUser.points / 3000) * (2 * Math.PI * 50))};"></circle>
//         <text x="60" y="70" class="progress-level">12</text>
//          </svg>
//      <div class="level-progress-text">
//         <div><strong>${(3000 - currentUser.points).toLocaleString()} XP</strong></div>
//         <div style="color: #999; font-size: 1rem;">to Level 13</div>
//     </div>
// </div>
//     </div>
// `;

// //star points data sample
// const starPointsData = {
//     starPoints: 2847,
//     level: 12,
//     projectsCompleted: 24,
//     hoursVolunteered: 156
// };

// const starPointsContainer = document.querySelector('.achievements-starpoint-section');

// starPointsContainer.innerHTML = `
//     <h2 class="star-points-title">⭐ Star Points</h2>
//     <div class="star-points-stats-grid">
//         <div class="star-points-stat-item">
//             <div class="star-points-stat-value">${starPointsData.starPoints.toLocaleString()}</div>
//             <div class="star-points-stat-label">Star Points</div>
//         </div>
//         <div class="star-points-stat-item">
//             <div class="star-points-stat-value">Level ${starPointsData.level}</div>
//             <div class="star-points-stat-label">Current Level</div>
//         </div>
//         <div class="star-points-stat-item">
//             <div class="star-points-stat-value">${starPointsData.projectsCompleted}</div>
//             <div class="star-points-stat-label">Projects Completed</div>
//         </div>
//         <div class="star-points-stat-item">
//             <div class="star-points-stat-value">${starPointsData.hoursVolunteered}</div>
//             <div class="star-points-stat-label">Hours Volunteered</div>
//         </div>
//     </div>
// `;

// //Badge Data
// const badgesData = [
//     { emoji: "🐚", name: "Wave Saver" },
//     { emoji: "🪸", name: "Coral Guardian" },
//     { emoji: "🌱", name: "Mangrove Starter" },
//     { emoji: "🌳", name: "Forest Builder" },
//     { emoji: "🏙️", name: "Metropolitan Savior" },
//     { emoji: "🏔️", name: "Peak Protector" },
//     // { emoji: "🧠", name: "Eco Educator" }
// ];

// // Render badges
// const badgesContainer = document.querySelector('.achievements-badges-section');


// badgesContainer.innerHTML = `
//     <h2 class="badges-title">🏅 Badges Earned</h2>
//     <div class="badges-grid">
//         ${badgesData.map(badge => `
//             <div class="badge-item">
//                 <div class="badge-emoji">${badge.emoji}</div>
//                 <div class="badge-name">${badge.name}</div>
//             </div>
//         `).join('')}
//     </div>
// `;


const toggleEditMode = (isEditing) => {
    formFields.forEach(field => {
        if (isEditing) {
            field.removeAttribute('readonly');
            field.style.cursor = 'auto';
        } else {
            field.setAttribute('readonly', true);
            field.style.cursor = 'not-allowed';
        }
    });

    // Toggle availability display/edit mode
    const availDisplay = document.getElementById('availabilityDisplay');
    const availEdit = document.getElementById('availabilityEditMode');
    
    if (isEditing) {
        editProfileBtn.style.display = 'none';
        formActions.classList.add('active');
        
        // Show edit mode, hide display mode
        if (availDisplay) availDisplay.style.display = 'none';
        if (availEdit) availEdit.style.display = 'block';
    } else {
        editProfileBtn.style.display = 'block';
        formActions.classList.remove('active');
        
        // Show display mode, hide edit mode
        if (availDisplay) availDisplay.style.display = 'block';
        if (availEdit) availEdit.style.display = 'none';
    }
};

// Add availability update to save button
saveProfileBtn.addEventListener('click', async () => {
    const formData = new FormData(document.querySelector('form'));
    
    // Add availability data
    const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    const times = ['Morning', 'Afternoon', 'Evening'];
    
    days.forEach(day => {
        times.forEach(time => {
            const checkbox = document.querySelector(`input[name="${day}_${time}"]`);
            if (checkbox && checkbox.checked) {
                formData.append(`${day}_${time}`, 'on');
            }
        });
    });
    
    // Send to server
    try {
        const response = await fetch('/V/router.php?module=user&action=profileUpdate', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        });
        
        const data = await response.json();
        
        if (data.success) {
            // alert('Profile updated successfully!');
            toggleEditMode(false);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        // alert('An error occurred while updating profile');
    }
});


document.getElementById("downloadButton").addEventListener("click", function () {
    const qrContainer = document.querySelector(".qrcode");

    // Check for canvas (most QR generators use canvas)
    const canvas = qrContainer.querySelector("canvas");

    // Check for image (some generate <img>)
    const img = qrContainer.querySelector("img");

    let qrDataURL = null;

    if (canvas) {
        qrDataURL = canvas.toDataURL("image/png");
    } else if (img) {
        qrDataURL = img.src;
    } else {
        alert("QR code not found!");
        return;
    }

    // Download
    const a = document.createElement("a");
    a.href = qrDataURL;
    a.download = "qr-code.png";
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
});



  



// character count 
document.addEventListener('DOMContentLoaded', function() {
    const bioTextarea = document.getElementById('bio');
    const charCount = document.getElementById('bio-char-count');
    
    // Initialize with current character count
    updateCharCount();
    
    // Add event listener for input changes
    bioTextarea.addEventListener('input', updateCharCount);
    
    function updateCharCount() {
        const currentLength = bioTextarea.value.length;
        const maxLength = bioTextarea.getAttribute('maxlength') || 500;
        charCount.textContent = `${currentLength}/${maxLength} characters`;
        
        // Optional: Add visual feedback when approaching limit
        if (currentLength > maxLength * 0.9) {
            charCount.style.color = '#e74c3c'; // Red when near limit
        } else {
            charCount.style.color = ''; // Reset to default
        }
    }
});





// Helper function to escape HTML
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;//for safety purposes to turn code to harmless text
}

//Redundantly done
// document.addEventListener('DOMContentLoaded', () => {
//   if (location.hash === '#notif') {
//     document.querySelector('[data-content-id="notif"]')?.click();
//     loadNotifications();
//   }
// });

// Load notifications when the notifications section becomes active
function loadNotifications() {
    fetch('/V/router.php?module=notification&action=getnotifications', {
         method: 'POST',
         credentials: 'same-origin'
    })
     .then(response => response.json())
    .then(data => {
        if (data.success) {
            renderNotifications(data.notifications);//data's 'notifications' assoc-id
        } else {
            console.error('Failed to load notifications:', data.message);
        }
    })
    .catch(error => {
        console.error('Error loading notifications:', error);
    });
}

// Render notifications in the UI
function renderNotifications(notifications) {
    const container = document.getElementById('notificationsList');
    const emptyState = document.getElementById('emptyState');

    if (!notifications || notifications.length === 0) {
        container.innerHTML = '';
        emptyState.style.display = 'block';
        return;
    }

    emptyState.style.display = 'none';
    
             container.innerHTML = notifications.map(notif => `
                 <div class="notification-item ${notif.is_read==0 ? 'unread':''}" 
                      data-id="${notif.notification_id}" 
                      onclick="toggleNotification(${notif.notification_id})">
                     <div class="notification-header">
                         <span class="notification-icon">${notif.icon}</span>
                         <div class="notification-content">
                             <h4 class="notification-title">${escapeHtml(notif.title)}</h4>
                             <p class="notification-preview">${escapeHtml(notif.message.substring(0, 80))}${notif.message.length > 80 ? '...' : ''}</p>
                             <span class="notification-time">${notif.timeAgo}</span>
                         </div>
                         <span class="notification-close" onclick="closeNotification(${notif.notification_id}, event)" title="Close Notification">&times;</span>
                     </div>
                     <div class="notification-details" id="details-${notif.notification_id}">
                         <p class="notification-full-message">${escapeHtml(notif.message)}</p>
                         ${notif.link ? `<button class="notification-action" onclick="window.location.href='${notif.link}';event.stopPropagation();">View Details</button>` : ''}
                     </div>
                 </div>
             `).join('');
}
//here map does operations for each array item
//event.stopPropagation() is used here to prevent the click from bubbling up to parent elements like marking the notification as read or opening it


// Toggle notification expansion (marks as read when opened)
function toggleNotification(notificationId) {
    const details = document.getElementById(`details-${notificationId}`);
    const item = document.querySelector(`[data-id="${notificationId}"]`);
    
    // Toggle active state
    const wasActive = item.classList.contains('active');
    
    // Close all other notifications
    document.querySelectorAll('.notification-item').forEach(n => {
        n.classList.remove('active');//remove active from each item
        const d = n.querySelector('.notification-details');
        if (d) d.classList.remove('active');//remove details active as well for each of those items
    });
    
    // Toggle current notification
    if (!wasActive) {
        item.classList.add('active');
        details.classList.add('active');
        
        // Mark as read (but don't remove) when opened
        if (item.classList.contains('unread')) {//if it's unread then clicking should update DB
            markAsReadSilently(notificationId);
            item.classList.remove('unread'); // Remove blue background
        }
    }
}


// Mark as read in database without removing from UI
async function markAsReadSilently(notificationId) {
    try {
        const formData = new FormData();
        formData.append('notification_id', notificationId);
        
        await fetch('/V/router.php?module=notification&action=markasread', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        });
        
        // Trigger navbar to update bell dot count thruh navbar included js
        if (typeof checkForNotifications === 'function') {//to avoid getting an error if its undefined
            checkForNotifications();
        }
        
    } catch (error) {
        console.error('Error marking as read:', error);
    }
}


// Close notification (remove from UI permanently)
async function closeNotification(notificationId, event) {
    event.stopPropagation(); // Don't trigger toggleNotification (stop from here without causing anomalies)
    
    try {
        const formData = new FormData();
        formData.append('notification_id', notificationId);
        
        const response = await fetch('/V/router.php?module=notification&action=closenotification', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Remove from UI with animation
            const notifElement = document.querySelector(`[data-id="${notificationId}"]`);
            if (notifElement) {//if that id'd element is there remove it in style
                notifElement.style.opacity = '0';
                notifElement.style.transform = 'translateX(20px)';
                notifElement.style.transition = 'all 0.3s ease';
                
                setTimeout(() => {
                    notifElement.remove();
                    
                    // Check if empty
                    const remainingNotifs = document.querySelectorAll('.notification-item');
                    if (remainingNotifs.length === 0) {//number of elements==0
                        document.getElementById('emptyState').style.display = 'block';
                    }
                }, 300);
            }
            
            // Update bell dot
            if (data.remainingCount === 0) {
                const dot = document.getElementById('notificationDot');
                if (dot) dot.classList.remove('active');
            }
            
            // Notify other tabs
            if ('BroadcastChannel' in window) {
                const channel = new BroadcastChannel('notification_updates');
                channel.postMessage({
                    type: 'notification_read',//use this to recheck
                    notificationId: notificationId,
                    remainingCount: data.remainingCount
                });
            }
        }
    } catch (error) {
        console.error('Error closing notification:', error);
    }
}


// Mark all as read and close all ie close-all
async function markAllAsRead() {
    try {
        const response = await fetch('/V/router.php?module=notification&action=markallasread', {
            method: 'POST',
            credentials: 'same-origin'
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Remove ALL notifications from UI (close all)
            const container = document.getElementById('notificationsList');
            const notifications = container.querySelectorAll('.notification-item');
            
            notifications.forEach((notif, index) => {
                setTimeout(() => {
                    notif.style.opacity = '0';
                    notif.style.transform = 'translateX(20px)';
                    notif.style.transition = 'all 0.3s ease';
                    
                    setTimeout(() => {
                        notif.remove();
                        
                        if (index === notifications.length - 1) {//last index ie last notification
                            document.getElementById('emptyState').style.display = 'block';
                        }
                    }, 300);
                }, index * 50);
            });
            
            // Update bell
            const dot = document.getElementById('notificationDot');
            if (dot) dot.classList.remove('active');
            
            // Notify other tabs
            if ('BroadcastChannel' in window) {
                const channel = new BroadcastChannel('notification_updates');
                channel.postMessage({
                    type: 'notification_read',
                    remainingCount: 0
                });
            }
        }
    } catch (error) {
        console.error('Error marking all as read:', error);
    }
}



// Initialize notifications when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // Load notifications if directly navigating to notifications tab
    const notifSection = document.getElementById('notif');
    if (notifSection && notifSection.classList.contains('active')) {//the notif tab is selected from the main panel
        loadNotifications();
    }
    
    // Listen for tab changes to load notifications when user clicks the menu
    const menuItems = document.querySelectorAll('.menu-item');
    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            const contentId = item.getAttribute('data-content-id');
            if (contentId === 'notif') {//selected the notification from the main side panel
                // Delay loading to allow animation to complete
                setTimeout(loadNotifications, 100);
            }
        });
    });
    
    // Check URL hash for direct navigation to notifications
    if (window.location.hash === '#notif') {
        menuItems.forEach(item => {
            if (item.getAttribute('data-content-id') === 'notif') {
                item.click();//to click the notif tab if an incoming URL has #notif
            }
        });
    }
});


// Listen for hash changes AND notification bell clicks
window.addEventListener('hashchange', function() {
    if (window.location.hash === '#notif') {//window.location refers to the current URL of the page and hash refers to the part after the #
        const notifMenuItem = document.querySelector('[data-content-id="notif"]');
        if (notifMenuItem) {
            notifMenuItem.click();
        }
    }
});

// Force navigation to notifications even if hash doesn't change
document.getElementById('notificationBell')?.addEventListener('click', function(e) {
    const notifMenuItem = document.querySelector('[data-content-id="notif"]');
    if (notifMenuItem) {
        notifMenuItem.click();
    }
});





























// ============================================
// PROFILE PICTURE UPLOAD FUNCTIONALITY
// ============================================

const uploadLogoBtn = document.getElementById('uploadLogoBtn');
const logoFileInput = document.getElementById('logoFileInput');
const profilePhotoDisplay = document.getElementById('profilePhotoDisplay');
const editProfileBtn = document.getElementById('editProfileBtn');
const cancelProfileBtn = document.getElementById('cancelProfileBtn');

// Show file picker when upload button is clicked
if (uploadLogoBtn) {
    uploadLogoBtn.addEventListener('click', (e) => {
        e.preventDefault();
        logoFileInput.click();
    });
}

// Handle file selection and upload
if (logoFileInput) {
    logoFileInput.addEventListener('change', async (e) => {
        const file = e.target.files[0];
        
        if (!file) return;
        
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            showProfilePictureError('Please select a valid image file (JPEG, PNG, GIF, or WebP)');
            return;
        }
        
        // Validate file size (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            showProfilePictureError('File size must be less than 5MB');
            return;
        }
        
        // Show loading indicator
        showProfilePictureLoading();
        if (uploadLogoBtn) {
            uploadLogoBtn.style.opacity = '0.5';
            uploadLogoBtn.disabled = true;
        }
        
        // Create FormData for file upload
        const formData = new FormData();
        formData.append('profileImage', file);
        
        try {
            // Upload to server
            const response = await fetch('/V/router.php?module=user&action=uploadProfileImage', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Update preview image
                if (profilePhotoDisplay) {
                    profilePhotoDisplay.src = data.imageUrl;
                    profilePhotoDisplay.style.border = '2px solid #28a745';
                }
                
                // Show success notification
                showProfilePictureSuccess();
                
            } else {
                showProfilePictureError('Error uploading picture: ' + data.message);
            }
            
        } catch (error) {
            console.error('Upload error:', error);
            showProfilePictureError('An error occurred while uploading the picture');
            
        } finally {
            // Hide loading indicator
            hideProfilePictureLoading();
            if (uploadLogoBtn) {
                uploadLogoBtn.style.opacity = '1';
                uploadLogoBtn.disabled = false;
            }
            // Reset input
            logoFileInput.value = '';
        }
    });
}

// Show success notification
function showProfilePictureSuccess() {
    const notification = document.createElement('div');
    notification.innerHTML = `
        <div style="background: #d4edda; border: 2px solid #28a745; border-radius: 8px; padding: 16px 20px; display: flex; align-items: flex-start; gap: 12px; position: fixed; top: 30px; right: 30px; z-index: 99999; max-width: 420px; box-shadow: 0 6px 20px rgba(0,0,0,0.2); font-family: Arial, sans-serif;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="2.5" style="flex-shrink: 0; margin-top: 2px;">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            <div style="color: #155724; flex: 1;">
                <strong style="font-size: 1.05rem; display: block; margin-bottom: 5px;">✓ Profile Picture Updated!</strong>
                <p style="margin: 0; font-size: 0.95rem;">Your photo has been updated successfully.</p>
            </div>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 4000);
}

// Show error notification
function showProfilePictureError(message) {
    const notification = document.createElement('div');
    notification.innerHTML = `
        <div style="background: #f8d7da; border: 2px solid #f5c6cb; border-radius: 8px; padding: 16px 20px; display: flex; align-items: flex-start; gap: 12px; position: fixed; top: 30px; right: 30px; z-index: 99999; max-width: 420px; box-shadow: 0 6px 20px rgba(0,0,0,0.2); font-family: Arial, sans-serif;">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#721c24" stroke-width="2.5" style="flex-shrink: 0;">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
        <div style="color: #721c24; flex: 1;">
            <strong style="font-size: 1.05rem; display: block; margin-bottom: 5px;">✕ Upload Failed</strong>
            <p style="margin: 0; font-size: 0.95rem;">${message}</p>
        </div>
    </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

// Show loading indicator
function showProfilePictureLoading() {
    const loader = document.createElement('div');
    loader.id = 'profilePictureLoader';
    loader.innerHTML = `
        <div style="position: fixed; top: 30px; right: 30px; z-index: 99999; background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 6px 20px rgba(0,0,0,0.2);">
            <div style="width: 40px; height: 40px; border: 4px solid #e0e0e0; border-top: 4px solid #172941; border-radius: 50%; animation: spin 0.8s linear infinite;"></div>
            <p style="margin-top: 10px; color: #172941; font-weight: 500; font-size: 14px;">Uploading...</p>
        </div>
    `;
    document.body.appendChild(loader);
}

// Hide loading indicator
function hideProfilePictureLoading() {
    const loader = document.getElementById('profilePictureLoader');
    if (loader) {
        loader.style.opacity = '0';
        loader.style.transition = 'opacity 0.3s ease';
        setTimeout(() => loader.remove(), 300);
    }
}

// Show/hide upload button based on edit mode
if (editProfileBtn) {
    editProfileBtn.addEventListener('click', (e) => {
        setTimeout(() => {
            if (uploadLogoBtn) {
                uploadLogoBtn.style.display = 'flex';
            }
        }, 0);
    });
}

if (cancelProfileBtn) {
    cancelProfileBtn.addEventListener('click', (e) => {
        setTimeout(() => {
            if (uploadLogoBtn) {
                uploadLogoBtn.style.display = 'none';
            }
        }, 0);
    });
}