
function sidebar() {
    const nameStuff = document.getElementById('nameStuff');
    const sidebar = document.getElementById('sidebar');
    nameStuff.classList.toggle('hidden');//add the hiddden class
    sidebar.classList.toggle('active'); //adds active class to  div element if it isnt there adn removes if it is there
    
}

document.addEventListener('click', function(e) {
    const sidebarEl = document.getElementById('sidebar');
    const nameStuff = document.getElementById('nameStuff');
    
    if (sidebarEl.classList.contains('active') && 
        !sidebarEl.contains(e.target) && //exclude the sidebar area
        !nameStuff.contains(e.target)) {//exclude initial nameStuff that triggered event
        sidebarEl.classList.remove('active');
        nameStuff.classList.remove('hidden');
    }
});

//notification system

let notificationCheckInterval;
// let isPageVisible = true;//used for loading notifs only when tab is in use

// Check if user is logged in by checking if notification bell exists

function isUserLoggedIn() {
    return document.getElementById('notificationBell') !== null;
}


//start polling


function startNotificationPolling() {

    if (!isUserLoggedIn()) return;


// Check immediately
    checkForNotifications();

// Then check every 5 seconds
    notificationCheckInterval = setInterval(checkForNotifications, 5000);
//here notificationCheckInterval is an ID tag the browser gives to that specific interval
}

// Stop notification polling
function stopNotificationPolling() {
    if (notificationCheckInterval) {
        clearInterval(notificationCheckInterval);
    }
}



// Poll for new notifications

async function checkForNotifications() {

    if (!isUserLoggedIn()) return;

try{
    const response = await fetch('/V/router.php?module=notification&action=getunreadcount', {
        method:'POST',//just tells the server you’re making a POST request,it doesnt mean that the function itself needs any arguments
        credentials: 'same-origin'
        });
    const data = await response.json();//data returns boolean value and count

    if (data.success) {
            updateNotificationBell(data.hasNotifications);    

 // Broadcast to other tabs to sync between multiple tabs open in the same window
            if ('BroadcastChannel' in window) {//Does this browser support BroadcastChannel?
                const channel = new BroadcastChannel('notification_updates');
                channel.postMessage({//sends a message to everyone else connected to that room
                    type: 'count_update',// message label
                    hasNotifications: data.hasNotifications,
                    count: data.count
                });
            }
        }
}
    catch (error) {
        console.error('Error checking notifications:', error);
    }

}


// Update the notification bell dot
function updateNotificationBell(hasNotifications) {
    const dot = document.getElementById('notificationDot');
    if (dot) {
        if (hasNotifications) {
            dot.classList.add('active');
        } else {
            dot.classList.remove('active');
        }
    }
}

// Listen for updates from other tabs
if ('BroadcastChannel' in window) {//Does this browser support BroadcastChannel?
    const channel = new BroadcastChannel('notification_updates');//(creates or joins) a named channel
    channel.onmessage = (event) => {//onmessage means another tab write to the channel
        if (event.data.type === 'count_update') {
            updateNotificationBell(event.data.hasNotifications);//other tab already did the fetch and broadcasted the result so no need to do checkForNotifications();
        } else if (event.data.type === 'notification_read') {
            // Refresh notification count if someone read a notification in another tab (set in notification.js page) cant just update as its a reading event
            checkForNotifications();
        }
    };
}

// // Handle page visibility changes (pause polling when tab is not active in the browser)
// document.addEventListener('visibilitychange', function() {
//     if (document.hidden) {//check the state using document.hidden
//         isPageVisible = false;
//         stopNotificationPolling();
//     } else {
//         isPageVisible = true;
//         startNotificationPolling();
//     }
// });

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    if (isUserLoggedIn()) {
        startNotificationPolling();
    }
});

// Clean up on page unload
window.addEventListener('beforeunload', function() {
    stopNotificationPolling();
});
