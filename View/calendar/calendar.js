
/* fetch the current data and stuff */
let currentDate = new Date();// the viewing date
let selectedDate = null;
let events = {};//global object storing all events + will be populated from the backend
    //eg: '2025-08-28': ['Beach Cleanup - Galle','Forest Restoration - Sigiriya'],//here the date becomes the array key
    //returned from formattedevents in the controller
let currentEvent=null;

let currentFilters = {
    status: 'all',
    eventType: 'all'
};    

//initialize the calendar on page load
document.addEventListener('DOMContentLoaded', function() {
    init();
});

/* initialize the calendar 
here all indexing starts from 0*/

function init() {
    updateCalendar();    
}
  
 


async function updateCalendar() {//indicated JS to NOT block and wait for a particuliar task
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth()+1;//JS months are zero indexed
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'];//again a zero indexed array
    document.getElementById('monthYear').textContent = `${monthNames[month - 1]} ${year}`;//counter balance the +1 in the JS months section above
    //by .textContent we can change the month and year dynamically and get the correct month from the array list  and get the value of year

    try{
        //fetch events for this month
        const response= await fetch(`/V/router.php?module=calendar&action=getevents&month=${month}&year=${year}`);
        const data = await response.json();
        if(data.success){//success return was true then do the following
            events=data.events;
            rendercalendargrid();
        }
        else{//data was returned failed, however it returned
            console.error('Failed to load events',data.message);
            showmessage('Failed to load calendar events');
        }
    }
    catch(error){//didnt return at all therefore a network error
        console.error('Error fetching events:',error);
        showmessage('Network error while loading calendar');
    }
}

function rendercalendargrid(){
    const year=currentDate.getFullYear();
    const month=currentDate.getMonth();//returns a zero-based month
    const grid = document.getElementById('calendarGrid');
    grid.innerHTML = '';//fetch the calendarGrid and clear all html inside it


    // Get first day of month and number of days + calculate calendar boundaries
    const firstDate = new Date(year, month, 1);//0 indexed jan
    const lastDate = new Date(year, month + 1, 0);//get the day 0 of next month(1 indexed feb) which is the last date of the previous month
    const daysInMonth = lastDate.getDate();//that will be the number of days if the month of concern
    let startDay = (firstDate.getDay() + 6) % 7;//for the starting date of the month get the get the day number. for monday it returns 1 so make monday =0
    //here day is monday,tuesday,wednesday... here sunday is 0 indexed and therefore onday is 1 indexed as index values go from 0 (Sunday) to 6 (Saturday)                                           

    //get day 0 of current month + previous month's trailing days
    const prevMonth = new Date(year, month, 0);//last date of prev month
    //start loop from one day before the chosen day and go back till monday indexed 0
    for (let i = startDay - 1; i >= 0; i--) {
        const day = prevMonth.getDate() - i;//create days till monday from start day of current month filling cards(fill first cards of prev month till monday)
        const card = createCalendarCard(day, true ,year,month-1);
        grid.appendChild(card);//adds card to grid as a child
    }
    // Add current month's days
    for (let day = 1; day <= daysInMonth; day++) {
        const card = createCalendarCard(day, false,year,month);
        grid.appendChild(card);
    }
    const nxtMonth = new Date(year, month+1, 1);
    const nextMonthStartingDay = (nxtMonth.getDay()+6)%7;
if (nextMonthStartingDay !== 0) {// Monday=0, Sunday=6
    // Add next month's leading days(works as intended)
        for(let i=1; i<= (7-nextMonthStartingDay); i++){
            const card = createCalendarCard(i, true ,year,month+1);
            grid.appendChild(card);
        }
    }
    

}


// Create a calendar card for a day(for a specific day)
function createCalendarCard(day, isOtherMonth,year,month) {
    const card = document.createElement('div');
    card.className = 'calendarCard';//give base class
    //card.className = 'calendarCard';        // Sets: class="calendarCard"  
    //card.classList.add('otherMonth');      // Adds: class="calendarCard otherMonth" = they help manipulate the css classes

    if (isOtherMonth) {
        card.classList.add('otherMonth');
    }

    const displayMonth=month+1;//because of 0 index ness
    const dateStr= `${year}-${String(displayMonth).padStart(2, '0')}-${String(day).padStart(2, '0')}`;//create formatted dates like 2025-01-10 instead of 2025-1-10

    // Check if the curretnDtae(viweingdate) is today
    const today = new Date();
    if (!isOtherMonth &&
        year === today.getFullYear() &&
        month === today.getMonth() &&
        day === today.getDate()) {
        card.classList.add('today');
    }

    // Add day number
    card.innerHTML = `&nbsp;${day}`;
//js date string is made so that teh database and js have same keys synced
    if (events[dateStr] && events[dateStr].length>0){//returns the number of elements in an array after checking if key exists
       
        //add the event indicator dots
        const eventContainer=document.createElement('div');
        eventContainer.className = 'eventDotContainer';
        events[dateStr].forEach((event,index)=>{
            if(index<3){//go until index=2 i.e. 0,1,2
                //show a maximum of 3 dots as the array indexesgo from 0 to 2
                const dot= document.createElement('div');
                dot.className='eventDot';
                dot.style.backgroundColor=event.color;

                
                eventContainer.appendChild(dot);}
            });
            card.appendChild(eventContainer);
            

                //add event list
        const eventList=document.createElement('div');
        eventList.className='eventList';

                events[dateStr].forEach((event,index)=>{
                    if(index<2){
                        //show a maximum of two event names
                        const eventItem=document.createElement('div');
                        eventItem.className='eventItem';
                        eventItem.textContent=event.title;//as event returns id,title,type,time,status(enrolled/annual),color
                        eventItem.style.borderLeftColor=event.color;
                    
                    
                    eventList.appendChild(eventItem);
                }
                });
                
 if (events[dateStr].length > 2) {//if there are 2 events, length = 2
            const moreItem = document.createElement('div');
            moreItem.className = 'eventItem moreEvents';
            moreItem.textContent = `+${events[dateStr].length - 2} more`;
            eventList.appendChild(moreItem);
        }
        
        card.appendChild(eventList);//append the event list to the card
    }

    // Add click handler here the arrow function captures and remembers the variables from its surrounding scope (card and dateStr) even after createCalendarCard() finishes executing
    //so that is why dateStr can be passed later when a click event occurs
    card.addEventListener('click', () => selectDate(card, dateStr));//calls selectDate function onclick
    return card;
    }


    

//date clicking 
// Handle date selection
function selectDate(card, dateStr) {
    // Remove previous selection
    const prevSelected = document.querySelector('.calendarCard.selected');
    if (prevSelected) {
        prevSelected.classList.remove('selected');
    }

    // Add selection to clicked card (unless it's other month)
    if (!card.classList.contains('otherMonth')) {
        card.classList.add('selected');
        selectedDate = dateStr;//make the global selectedDate variabel to be datestr


         // Show events for this date in the modal
        if (events[dateStr] && events[dateStr].length > 0) {
            showDayEventsModal(dateStr);
        }
    }
}





function showDayEventsModal(dateStr) {
    //show modal with events for a specific day
    const dayEvents = events[dateStr];
    if (!dayEvents || dayEvents.length === 0) return;

    let modalHtml = `
    <div class="calendarModalHeader">
        <h2>Events on ${formatDate(dateStr)}</h2>
        <span class="closeBtn" onclick="closeEventModal()">&times;</span>
    </div>
    <div class="calendarModalBody">
        <div class="dayEventsList">
    `;

    dayEvents.forEach(event => {
        
        //${event.id} is only used inside a template string (a string wrapped in backticks `, not quotes when we have to access the value inside the id and print it
        
        modalHtml += `
            <div class="dayEventItem" onclick="showEventDetails(${event.id})" style="border-left: 4px solid ${event.color}">
                <div class="eventItemTitle">${event.title}</div>
                <div class="eventItemType">${event.type}</div>
                ${event.time ? `<div class="eventItemTime"> <img src="/V/View/calendar/imgs/time.png">${event.time}</div>` : ''}
            </div>
        `;
    });

    modalHtml += `</div></div>`;

    document.getElementById('calendarModal').innerHTML = modalHtml;
    document.getElementById('calendarOverlay').style.display = 'flex';
}

async function showEventDetails(eventId) {
    //show detailed event information
    try {
        const response = await fetch(`/V/router.php?module=calendar&action=geteventdetails&eventId=${eventId}`);
        const data = await response.json();

        if (!data.success) {//controller's return keys
            showmessage(data.message);
            return;
        }

        const event = data.event;//only available locally
        currentEvent=event;//store in global varibale
        
        let modalHtml = `
        <div class="calendarModalHeader">
        <h2>${event.name}</h2>
        <span class="closeBtn" onclick="closeEventModal()">&times;</span>
        </div>
        <div class="calendarModalBody">
        
            
            <div class="eventDetailsList">
                <div class="eventDetailItem">
                    <strong>Type:</strong> ${event.event_type}
                </div>
                <div class="eventDetailItem">
                    <strong>Date:</strong> ${formatDate(event.event_date)}
                </div>
                ${event.time ? `
                <div class="eventDetailItem">
                    <strong>Time:</strong> ${event.time}
                </div>
                ` : ''}
                <div class="eventDetailItem">
                    <strong>Location:</strong> ${event.location}
                </div>
                <div class="eventDetailItem">
                    <strong>Organizer:</strong> ${event.organizername}
                </div>
                ${event.starpoints_reward ? `
                <div class="eventDetailItem">
                    <strong>Star Points:</strong>  ${event.starpoints_reward}
                </div>
                ` : ''}
                ${event.levelpoints_reward ? `
                <div class="eventDetailItem">
                    <strong>Level Points:</strong>  ${event.levelpoints_reward}
                </div>
                ` : ''}
                <div class="eventDetailItem">
                    <strong>Participants:</strong> ${event.current_participants}/${event.max_participants}
                </div>
                ${event.description ? `
                <div class="eventDetailItem fullWidth">
                    <strong>Description:</strong><br>
                    ${event.description}
                </div>
                ` : ''}
            </div>
        
        `;

        // add leave button for volunteers (if eligible)+ check the return type variables of event like canleave,cantleavereason,daysuntil
        if ((userRole === 'volunteer'||userRole ==='representative' ||userRole ==='organisationrep' ) && event.canleave) {
            const daysuntilevent=currentEvent.daysuntil;
            const levelPenalty = (daysuntilevent<3||daysuntilevent>30) ? 0 : Math.round(currentEvent.levelpoints_reward*(30-daysuntilevent)*0.01);//cant leave below 3 days anyway and above 30 days there is no penalty
            modalHtml += `
                <div class="leaveEventSection">
                    <p class="warningText">Event starts in ${event.daysuntil} days and leaving now will result in:</p>
                    <ul>
                        <li>Loss of ${levelPenalty} level point(s)</li>
                    </ul>
                    
                    <button class="leaveEventBtn" onclick="confirmLeaveEvent(${eventId})">
                        Leave Event
                    </button>
                </div>
            </div>
            `;
        } else if ((userRole === 'volunteer'||userRole ==='representative' ||userRole ==='organisationrep' ) && !event.canleave) {
            modalHtml += `
                <div class="infoSection">
                    <p>${event.cantleavereason || 'You cannot leave this event'}</p>
                </div>
                </div>
            `;
        }
        


        document.getElementById('calendarModal').innerHTML = modalHtml;
        document.getElementById('calendarOverlay').style.display = 'flex';

    } catch (error) {
        console.error('Error fetching event details:', error);
        showmessage('Failed to load event details');
    }
}

//add a confirm leave modal later

function confirmLeaveEvent(eventId) {
    const daysuntilevent=currentEvent.daysuntil;
    const levelPenalty = (daysuntilevent<3||daysuntilevent>30) ? 0 : Math.round(currentEvent.levelpoints_reward*(30-daysuntilevent)*0.01);//cant leave below 3 days anyway and above 30 days there is no penalty
    const penaltyMessage= daysuntilevent>30 ?`<div class="infoSection"><p>No Penalty - Event is more than 30 days away</p></div>
                                                <button class="returnleaveBtn" onclick="closeEventModal()">Cancel</button> 
                                                <button class="confirmleaveEventBtn" onclick="leaveEvent(${eventId})">
                                                    Confirm Leave
                                                </button>  `
                            :daysuntilevent<3?`<div class="infoSection"><p>Cannot leave event less than 2 days before start date</p></div>`
                            :`  <div class="leaveEventSection">
                                    <p class="warningText">Are you sure you want to leave this event?</p>
                                    <p> This action cannot be undone and you will lose:</p>
                                    <ul><li>${levelPenalty} level points</li></ul>
                                    <button class="returnleaveBtn" onclick="closeEventModal()">Cancel</button> 
                                    <button class="confirmleaveEventBtn" onclick="leaveEvent(${eventId})">
                                        Confirm Leave
                                    </button>
                                </div> `;
    //confirm and leave event
     let modalHtml = `
        <div class="calendarModalHeader">
        <h2>${currentEvent.name}</h2>
        <span class="closeBtn" onclick="closeEventModal()">&times;</span>
        </div>
        <div class="calendarModalBody">
        ${penaltyMessage}
        </div>
        `;
        document.getElementById('calendarModal').innerHTML = modalHtml;
        document.getElementById('calendarOverlay').style.display = 'flex';
        
    
}


function showmessage(message){
      let modalHtml = `
        <div class="calendarModalHeader">
        <h2>Notification</h2>
        <span class="closeBtn" onclick="closeEventModal()">&times;</span>
        </div>
        <div class="calendarModalBody">
        <p>${message}</p>
        <button class="messageokbtn" onclick="closeEventModal()">OK</button>
        
        </div>
        `;
        document.getElementById('calendarModal').innerHTML = modalHtml;
        document.getElementById('calendarOverlay').style.display = 'flex';
}





async function applyFilters() {//async allows the function to pause at await statements without blocking the rest of your code
    //Apply filters to calendar
     

    //fetch currently applied filters from UI 
    const statusFilter = document.querySelector('input[name="statusFilter"]:checked').value;//get value of currently set radio button with name statusFilter
    const typeFilter = document.getElementById('eventTypeFilter').value;

    currentFilters.status = statusFilter;
    currentFilters.eventType = typeFilter;

    const year = currentDate.getFullYear();
    const month = currentDate.getMonth() + 1;//JS 0 indexed months
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'];//again a zero indexed array
    document.getElementById('monthYear').textContent = `${monthNames[month - 1]} ${year}`;//counter balance the +1 in the JS months section above
    //by .textContent we can change the month and year dynamically and get the correct month from the array list  and get the value of year


    try {
        const response = await fetch(
            `/V/router.php?module=calendar&action=filterevents&month=${month}&year=${year}&status=${statusFilter}&eventtype=${typeFilter}`
        );
        const data = await response.json();

        if (data.success) {
            events = data.events;
            rendercalendargrid();//filtered events would disappear if update calendar was called
        }
    } catch (error) {
        console.error('Error applying filters:', error);
        showmessage('Failed to apply filters');
    }

}









// Navigation functions to redraw calendars
function previousMonth() {
    currentDate.setMonth(currentDate.getMonth() - 1);
    //updateCalendar(); this is faulty and doesnt apply the filters well
    //rendercalendargrid(); this will not change the month names and stuff
    
    applyFilters();//also calls geteventsbydaterange + adds filters to them so no change+ renderscalendar
    
    
}

function nextMonth() {
    currentDate.setMonth(currentDate.getMonth() + 1);//moves currentDate forward by one month
    //updateCalendar();
    //rendercalendargrid();
    applyFilters();
    
}
function closeEventModal() {
    //close event modal
    document.getElementById('calendarOverlay').style.display = 'none';
}
//utility functions
function formatDate(dateStr) {
    const date = new Date(dateStr);
    return date.toLocaleDateString('en-US', { //format is Mon, Jan 15, 2025
        weekday: 'short', 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
    });
}

window.onclick = function(click) {//triggers whenever any click happens anywhere on the page + click is the event object automatically passed by the browser
    //whenever any click happens on the window,the handler function runs and the browser automatically passes the event object to the handler
    // close modal when clicking outside
    const overlay = document.getElementById('calendarOverlay');
    if (click.target == overlay) {//the overlay is behind the modal so u have to specifically click on the overlay
        closeEventModal();
    }
}

