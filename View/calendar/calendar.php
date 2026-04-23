<?php
$upcomingevents = $upcomingevents ?? [];
$registeredannualevents=$returnedannualevents['registeredannual'] ??[];
$unregisteredannualevents=$returnedannualevents['unregisteredannual']??[];
?>
<html>
<!-- what happens is the js calls the fetch events which calls the geteventlistbydateish function and in that rolewise a merged array is returned. later fitler based on the radio buttons and role -->
<head>
    <title>V</title>
    <link rel="stylesheet" type="text/css" href="/V/View/calendar/calendar.css">
    <link rel="stylesheet" type="text/css" href="/V/View/globalstyles.css">
    <?php include __DIR__ . '/../navbar/navbar.php'; ?>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>


<body>


    <div class="calendarBox">
         <!-- <img src="/V/View/resources/homepagebg.png" >  -->
        <div class="calendarContainer">
            <div class="calendarNavigation">
                
                <div class="monthYear" id="monthYear"></div> 
                <!-- fill in the montha and year as a heading -->
                
            </div>
            <!-- Filter Section (visible for volunteers) -->
            <?php if ($_SESSION['role'] === 'volunteer'): ?>
            <div class="calendarFilters">
                <label>
                    <input type="radio" name="statusFilter" value="all" checked onchange="applyFilters()"> All Events
                </label> <!--default-->
                <label>
                    <input type="radio" name="statusFilter" value="standardenrolled" onchange="applyFilters()"> Standard Enrolled
                </label> <!-- apply filters if a change occurred -->
                <label>
                    <input type="radio" name="statusFilter" value="allannual" onchange="applyFilters()"> Annual Events
                </label>
                
                <select id="eventTypeFilter" onchange="applyFilters()">
                    <option value="all">All Types</option>
                    <option value="mangrove restoration">Mangrove Restoration</option>
                    <option value="coral restoration">Coral Restoration</option>
                    <option value="tree planting">Tree Planting</option>
                    <option value="city cleanup">City Cleanup</option>
                    <option value="mountain cleanup">Mountain Cleanup</option>
                    <option value="beach cleanup">Beach Cleanup</option>
                    <option value="awareness campaign">Awareness Campaign</option>
                </select>
                <button class="calNavButton" onclick="previousMonth()"> Previous Month</button>
                <button class="calNavButton" onclick="nextMonth()">Next Month</button>
            </div>
            <?php endif; ?>

            <?php if ($_SESSION['role'] === 'representative'|| $_SESSION['role']==='organisationrep'): ?>
                <div class="calendarFilters">
                    <label>
                    <input type="radio" name="statusFilter" value="all" checked onchange="applyFilters()"> All Events
                </label>
                <label>
                    <input type="radio" name="statusFilter" value="reporganizedbutnotattended" onchange="applyFilters()"> Organized
                </label> <!--default also organized ones are not attending-->
                <label>
                    <input type="radio" name="statusFilter" value="repnotorganizedbutattended" onchange="applyFilters()"> Non-Organized & Attend
                </label> <!-- apply filters if a change occurred -->
                <label>
                    <input type="radio" name="statusFilter" value="allannual" onchange="applyFilters()"> Annual Events
                </label>
                
                
                <select id="eventTypeFilter" onchange="applyFilters()">
                    <option value="all">All Types</option>
                    <option value="mangrove restoration">Mangrove Restoration</option>
                    <option value="coral restoration">Coral Restoration</option>
                    <option value="tree planting">Tree Planting</option>
                    <option value="city cleanup">City Cleanup</option>
                    <option value="mountain cleanup">Mountain Cleanup</option>
                    <option value="beach cleanup">Beach Cleanup</option>
                    <option value="awareness campaign">Awareness Campaign</option>
                    
                </select>
                <button class="calNavButton" onclick="previousMonth()"> Previous Month</button>
                <button class="calNavButton" onclick="nextMonth()">Next Month</button>
            </div>
            <?php endif; ?> 

             <?php if ($_SESSION['role'] === 'manager'): ?>
                <div class="calendarFilters">
                    <label>
                    <input type="radio" name="statusFilter" value="all" checked onchange="applyFilters()"> All Events
                </label>
                <label>
                    <input type="radio" name="statusFilter" value="allannual" onchange="applyFilters()"> Annual Events
                </label> <!--default-->
                <label>
                    <input type="radio" name="statusFilter" value="managerorganizedstandard" onchange="applyFilters()"> My Standard Events
                </label> <!-- apply filters if a change occurred -->
                
                
                
                <select id="eventTypeFilter" onchange="applyFilters()">
                    <option value="all">All Types</option>
                    <option value="mangrove restoration">Mangrove Restoration</option>
                    <option value="coral restoration">Coral Restoration</option>
                    <option value="tree planting">Tree Planting</option>
                    <option value="city cleanup">City Cleanup</option>
                    <option value="mountain cleanup">Mountain Cleanup</option>
                    <option value="beach cleanup">Beach Cleanup</option>
                    <option value="awareness campaign">Awareness Campaign</option>
                    
                </select>
                <button class="calNavButton" onclick="previousMonth()"> Previous Month</button>
                <button class="calNavButton" onclick="nextMonth()">Next Month</button>
            </div>
            <?php endif; ?> 
             <?php if ($_SESSION['role'] === 'admin'): ?>
                <div class="calendarFilters">
                    <label>
                    <input type="radio" name="statusFilter" value="all" checked onchange="applyFilters()"> All Events
                </label>
                <label>
                    <input type="radio" name="statusFilter" value="allannual" onchange="applyFilters()"> Annual Events
                </label> <!--default-->
                <label>
                    <input type="radio" name="statusFilter" value="allstandard" onchange="applyFilters()"> Standard Events
                </label> <!-- apply filters if a change occurred -->
                
                
                
                <select id="eventTypeFilter" onchange="applyFilters()">
                    <option value="all">All Types</option>
                    <option value="mangrove restoration">Mangrove Restoration</option>
                    <option value="coral restoration">Coral Restoration</option>
                    <option value="tree planting">Tree Planting</option>
                    <option value="city cleanup">City Cleanup</option>
                    <option value="mountain cleanup">Mountain Cleanup</option>
                    <option value="beach cleanup">Beach Cleanup</option>
                    <option value="awareness campaign">Awareness Campaign</option>
                    
                </select>
                <button class="calNavButton" onclick="previousMonth()"> Previous Month</button>
                <button class="calNavButton" onclick="nextMonth()">Next Month</button>
            </div>

            <?php endif; ?>
             <?php if ($_SESSION['role'] === 'sponsor'): ?>
                <div class="calendarFilters">
                    <label>
                    <input type="radio" name="statusFilter" value="all" checked onchange="applyFilters()"> All Events
                </label>
                <label>
                    <input type="radio" name="statusFilter" value="unsponsored" onchange="applyFilters()"> Available Sponsorships
                </label> <!--default-->
                <label>
                    <input type="radio" name="statusFilter" value="sponsored" onchange="applyFilters()"> My Sponsorships
                </label> <!-- apply filters if a change occurred -->
                
                
                
                <select id="eventTypeFilter" onchange="applyFilters()">
                    <option value="all">All Types</option>
                    <option value="mangrove restoration">Mangrove Restoration</option>
                    <option value="coral restoration">Coral Restoration</option>
                    <option value="tree planting">Tree Planting</option>
                    <option value="city cleanup">City Cleanup</option>
                    <option value="mountain cleanup">Mountain Cleanup</option>
                    <option value="beach cleanup">Beach Cleanup</option>
                    <option value="awareness campaign">Awareness Campaign</option>
                    
                </select>
                <button class="calNavButton" onclick="previousMonth()"> Previous Month</button>
                <button class="calNavButton" onclick="nextMonth()">Next Month</button>
            </div>
            <?php endif; ?>


            <!-- calendar header -->
            <div class="calendarHeader">
                <div class="calendarHeaderCard">Mon</div>
                <div class="calendarHeaderCard">Tue</div>
                <div class="calendarHeaderCard">Wed</div>
                <div class="calendarHeaderCard">Thu</div>
                <div class="calendarHeaderCard">Fri</div>
                <div class="calendarHeaderCard">Sat</div>
                <div class="calendarHeaderCard">Sun</div>
            </div>

            <div class="calendarGrid" id="calendarGrid">
                <!-- populated by js -->
            </div>
        </div>

            <!-- sidebar -->
        <div class="calendarSidebar">

            

            <!-- Upcoming Events -->
            <div class="sidebarElement">
                <div class="subTexts">📅 Upcoming Events</div>
                <div id="upcomingEvents">
                    <?php if (!empty($upcomingevents)): ?>
                        <?php foreach ($upcomingevents as $event): ?>
                            <?php if (isset($event['calendarstatus']) ): ?>           
                            <div class="upcomingEventItem" onclick="showEventDetails(<?php echo $event['event_id']; ?>)">
                                <?php echo date('M d', strtotime($event['event_date'])); ?> - 
                                <?php echo htmlspecialchars($event['name']); ?>
                                </div>
                                <?php endif; ?>
                            
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div>No upcoming events</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="sidebarElement">
                <div class="subTexts">📅 Annual Events of  <?php echo date('Y'); ?></div>
                <div id="annualEvents">
<?php if (!empty($registeredannualevents)||!empty($unregisteredannualevents)): ?>

    <?php if(!empty($registeredannualevents)):?>
    <div >Registered Annual Events</div>
    <?php foreach ($registeredannualevents as $registeredannualevent): ?>
        <div class="registeredannualEventItem" onclick="showEventDetails(<?php echo $registeredannualevent['event_id']; ?>)">
             <?php echo date('M d', strtotime($registeredannualevent['event_date'])); ?> - 
                                <?php echo htmlspecialchars($registeredannualevent['name']); ?>                                
        </div>
    <?php endforeach; ?>
    <br>
    <?php endif; ?>
    <?php if(!empty($unregisteredannualevents)):?>
<div>Unregistered Annual Events</div>
    <?php foreach ($unregisteredannualevents as $unregisteredannualevent): ?>
        <div class="unregisteredannualEventItem" onclick="showEventDetails(<?php echo $unregisteredannualevent['event_id']; ?>)">
             <?php echo date('M d', strtotime($unregisteredannualevent['event_date'])); ?> - 
                                <?php echo htmlspecialchars($unregisteredannualevent['name']); ?>                                
        </div>
    <?php endforeach; ?>
        <?php endif;?>

<?php else: ?>
        <div>No Annual Events Available</div>
<?php endif; ?>
                     

                </div>

            </div>

<!-- announcemnetns -->



            
        </div>
    </div>

     




    
   
       <!-- Event Details Modal -->
    <div id="calendarOverlay" class="calendarOverlay" style="display: none;">
        <div class="calendarModal" id="calendarModal">
            <!-- Populated by JavaScript starting from this ID -->                
            </div>
        </div>
    </div>

    <!-- Pass PHP variables to JavaScript -->
    <script>
        const userRole = '<?php echo $_SESSION['role']; ?>';
        const userId = <?php echo $_SESSION['user_id']; ?>;
    </script>
    <script src="/V/View/common/commonleave.js"></script>
    <script src="/V/View/calendar/calendar.js"></script>
</body>

</html>