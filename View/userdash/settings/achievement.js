let achievementPollingInterval = null;//variable to store the polling interval ID
let lastKnownLevelPoints = null;//the user's last known level points
let lastKnownLevel = null;//the user's last known level (used to detect level ups)

// Initialize achievement functionality (runs when the page loads)
function initializeAchievements() {
    // Load initial achievement data (used to fetch initial data)
    loadAchievementData();

    // Setup tab switching behavior (used to reload data when the ahievement tab is clicked)
    setupAchievementTabSwitching();

    // Setup polling for auto-updates (every 30 seconds) (used to auto refresh every 30 seconds the tab is active)
    setupAchievementPolling();
}

async function loadAchievementData() {
    const achievementsSection = document.getElementById('achievements');//get the big achievement section (right hand side stuff) thruh the id

    if (!achievementsSection) {
        console.log('Achievements section not found - user may not be a volunteer');
        return;
    }

    // Show loading state
    showLoadingState();

    try{
    // Fetch data from server
    const response = await fetch('/V/router.php?module=achievement&action=getdata')//send an HTTP request to the router->controller and the controller responds with JSON from json_encode($result) in AJAX handler
    const output = await response.json();//done to convert encoded json text back to json onject
    if (output.success) {
        // Check for level up
        checkForLevelUp(output.data);//pass the data object(entire lot) if success=true. to access stuff inside the data we can do $result.data.star_points or result.data.level etc.

        // Update tracking variables
        lastKnownLevelPoints = output.data.level_points;
        lastKnownLevel = output.data.level;

        // Render all achievement data
        renderAchievements(output.data);
    }
    else {
        showError(output.message || 'Failed to load achievement data');
    }}
    catch(error){
        console.error('Error loading achivement data:',error);
        showError('Failed to load achievement data.');
    }


}

function showLoadingState() {
    const starPointsSection = document.querySelector('.achievements-starpoint-section');//get the individual containers within the achievement page (boxed regions with star points,level points, leaderboard)
    const badgesSection = document.querySelector('.achievements-badges-section');
    const leaderboardSection = document.querySelector('.achievements-leaderboard');

    if (starPointsSection) starPointsSection.innerHTML = '<p style="text-align: center; color: #666;">Loading...</p>';
    //if (starPointsSection)->checks if the element exists (not NULL) then starPointsSection.innerHTML = '...'->replace everything inside this element with the given HTML (loading ... message)
    if (badgesSection) badgesSection.innerHTML = '<p style="text-align: center; color: #666;">Loading...</p>';
    if (leaderboardSection) leaderboardSection.innerHTML = '<p style="text-align: center; color: #666;">Loading...</p>';
}


function showError(message) {
    const panelHeader = document.querySelector('#achievements .panel-header');
    if (panelHeader) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'level-up-notification';//reusing the notificaiton sytle for consistency
        errorDiv.innerHTML = `
        <div style="background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
                        color: white; padding: 0.75rem 1.5rem; border-radius: 9999px;
                        display: inline-flex; align-items: center; gap: 0.5rem;
                        font-size: 0.875rem; font-weight: 600; animation: fadeIn 0.5s ease;">
                ${message}
            </div>
        `;

        panelHeader.appendChild(errorDiv);//append notification to the side of it
        setTimeout(() => errorDiv.remove(), 5000);

    }
}


function checkForLevelUp(data) {
    if (lastKnownLevel !== null && data.level > lastKnownLevel) {//if the level in the newly fetched data is > last known then update level
        showLevelUpNotification(lastKnownLevel, data.level);
    }
}

function showLevelUpNotification(oldLevel, newLevel) {
    const notification = document.createElement('div');//create a new notification to show level up
    notification.className = 'level-up-notification';
    notification.innerHTML = `
        <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); 
                    color: white; padding: 0.75rem 1.5rem; border-radius: 9999px; 
                    display: inline-flex; align-items: center; gap: 0.5rem;
                    font-size: 0.875rem; font-weight: 600; animation: fadeIn 0.5s ease;">
            You've advanced from Level ${oldLevel} to Level ${newLevel}!
        </div>
    `;

    const panelHeader = document.querySelector('#achievements .panel-header');//fetch element with id=achievements and has panel header class
    if (panelHeader) {
        panelHeader.appendChild(notification);//append notification to the side of it
        setTimeout(() => notification.remove(), 5000);
    }
}






function renderAchievements(data) {
    renderStarPoints(data);
    renderBadges(data.badges);
    renderLeaderboard(data.leaderboard, data);//pass only relevant stuff of the returned data object (here data is the result without success=>true)
}

function renderStarPoints(data) {
    const starPointsContainer = document.querySelector('.achievements-starpoint-section');

    if (!starPointsContainer) return;//return if its not there cuz its poitnless then

    starPointsContainer.innerHTML = `
        <h2 class="star-points-title">⭐ Star Points</h2>
        <div class="star-points-stats-grid">
            <div class="star-points-stat-item">
                <div class="star-points-stat-value">${data.star_points.toLocaleString()}</div>
                <div class="star-points-stat-label">Star Points</div>
            </div>
            <div class="star-points-stat-item">
                <div class="star-points-stat-value">Level ${data.level}</div>
                <div class="star-points-stat-label">Current Level</div>
            </div>
            <div class="star-points-stat-item">
                <div class="star-points-stat-value">${data.projects_completed}</div>
                <div class="star-points-stat-label">Projects Completed</div>
            </div>
            <div class="star-points-stat-item">
                <div class="star-points-stat-value">${data.hours_volunteered}</div>
                <div class="star-points-stat-label">Hours Volunteered</div>
            </div>
        </div>
    `;
}//fill in the UI from the data object returned where the stuff present are like star_points,level,level_points,points_to_next_level,projects_completed,hours_volunteered,badges,leaderboard

function renderBadges(badges) {
    const badgesContainer = document.querySelector('.achievements-badges-section');

    if (!badgesContainer) return;//return if a badges section doesnt exist

    const badgeImages = {
        'Wave Saver': '/V/View/userdash/settings/img/beachcleanup.png',
        'Coral Guardian': '/V/View/userdash/settings/img/coralrestoration.png',
        'Mangrove Starter': '/V/View/userdash/settings/img/mangroverestoration.png',
        'Forest Builder': '/V/View/userdash/settings/img/treeplanting.png',
        'Urban Protector': '/V/View/userdash/settings/img/citycleanup.png',
        'Mountain Sentinel': '/V/View/userdash/settings/img/mountatincleanup.png'
    };

    if (badges.length === 0) {//amount of items in the badges array
        badgesContainer.innerHTML = `
            <h2 class="badges-title">🏅 Badges Earned</h2>
            <p style="text-align: center; color: #666; padding: 2rem;">
                No badges earned yet. Keep volunteering to earn badges!
            </p>
        `;
        return;
    }
    //here.map is a smart loop that creates a piece of HTML using that badge, for each badge in the badges array
    badgesContainer.innerHTML = `
        <h2 class="badges-title">🏅 Badges Earned</h2>
        <div class="badges-grid">
            ${badges.map(badge => `
                <div class="badge-item">
                <div class="badge-emoji">
                        <img src="${badgeImages[badge.name]}" 
                             alt="${badge.name}" 
                             style="width: 60px; height: 60px; object-fit: contain;" />
                    </div>
                    <div class="badge-name">${badge.name}</div>
                    ${badge.count > 1 ? `<div style="font-size: 0.75rem; color: #666;">x${badge.count}</div>` : ''}                   
                </div>
            `).join('')}
        </div>
    `;
}


function renderLeaderboard(leaderboardData, data) {

    //returns assoc array of format 'current_rank'=>$currentrank,'user'=>$fetcheduserdetails
    //here fetcheduserdetails has keys of format name,points
    const leaderboardContainer = document.querySelector('.achievements-leaderboard');

    if (!leaderboardContainer) return;//if there is no leaderboard container return

    const currentRank = leaderboardData.current_rank;
    const user = leaderboardData.user;//unpack stuff it will have points and name if user

    // Find current user's points for progress calculation
    const currentPoints = user ? user.points : 0;//get the current user's points

    // Calculate progress percentage (eg: need a total of xxx points for next level)
    const totalForNextLevel = currentPoints + data.points_to_next_level;
    const progressPercentage = Math.min(100, (currentPoints / totalForNextLevel) * 100);//cap at 100 percent
    const circumference = 2 * Math.PI * 50;//50 is the radius
    const strokeDashoffset = circumference*( 1 - (progressPercentage / 100) );//how much of the circle must be empty
    //fill into the UI and add formatting in leaderboard
    leaderboardContainer.innerHTML = `
        <div class="leaderboard">
            <h2 class="leaderboard-title">🏆 Leaderboard</h2>
            <div class="leaderboard-separator"></div>
            <div class="user-rank-display">
                <div class="user-rank-number">#${currentRank}</div>
                <div>Your Current Rank</div>
            </div>
            <div class="leaderboard-separator"></div>
            <div class="level-progress">
                <svg class="level-progress-circle" viewBox="0 0 120 120">
                    <circle cx="60" cy="60" r="50" class="progress-bg"></circle>
                    <circle cx="60" cy="60" r="50" class="progress-fill" 
                            style="stroke-dasharray: ${circumference}; stroke-dashoffset: ${strokeDashoffset};"></circle>
                    <text x="60" y="70" class="progress-level">${data.level}</text>
                </svg>
                <div class="level-progress-text">
                    <div><strong>${(data.points_to_next_level).toLocaleString()} XP</strong></div>
                    <div style="color: #999; font-size: 1rem;">to next milestone</div>
                </div>
            </div>
        </div>
    `;
}   


//here viewbox means the darwing area and stroke-dasharray => total circumference of the circle and stroke-dashoffset => how much of the circle is hidden(empty)
//smaller offset => more of the circle is filled

function setupAchievementTabSwitching() {
    const achievementsMenuItem = document.querySelector('[data-content-id="achievements"]');//refer custom attribute in the tabs section it will have (data-content-id="achievements")

    if (achievementsMenuItem) {
        achievementsMenuItem.addEventListener('click', () => {
            // Reload achievement data when switching to achievements tab (when achievements tab is clicked load the achievement data)
            loadAchievementData();
        });
    }
}

function setupAchievementPolling() {
    // Clear any existing interval
    if (achievementPollingInterval) {
        clearInterval(achievementPollingInterval);
    }//stops an already running polling interval to avoid multiple overlapping polls
    //checks if there’s already a polling interval running (achievementPollingInterval)
    //if yes, clearInterval stops it to avoid multiple overlapping polls


    // Poll every 30 seconds when achievements tab is active
    achievementPollingInterval = setInterval(() => {
        const achievementsSection = document.getElementById('achievements');//get achievement section
        if (achievementsSection && achievementsSection.classList.contains('active')) {
            loadAchievementData();//only load achievements if achievementSection is exisitinf and the user is viewing it(active means the user is viewing so do polling only when user is viweing)
        }
    }, 30000);
}
//setInterval() runs the callback every 30,000 ms (30 seconds)
//

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    initializeAchievements();//run it once the page has loaded ensure all DOM elements exist before trying to access them
});

// Cleanup on page unload
window.addEventListener('beforeunload', () => {//beforeunload is a window event that fires just before the page is about to be unloaded eg: user navigates to another page,refreshes the page,closes the tab
    if (achievementPollingInterval) {
        clearInterval(achievementPollingInterval);
    }//Stops the polling when the user leaves the page to prevent memory leaks or intervals running in the background
});


