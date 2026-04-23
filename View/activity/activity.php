<html>
<?php
// Get data from controller (this is set in the router) we put this file into the router underneath the eventResult stuff so this codde has access to that evenResult
$events = isset($eventResult['data']) ? $eventResult['data'] : [];
//easy reference
$ongoingEvents = [];
$pastEvents = [];
$futureEvents = [];
$currentDate = date('Y-m-d');
//autoincremented
foreach ($events as $event) {
    // $eventDate = date('Y-m-d', strtotime($event['event_date']));
    $eventDate = $event['event_date'];
    $eventState = $event['state_of_event'];
    $organizerId=$event['organizer_id'];

    if ($eventState === 'completed' || $eventDate < $currentDate) {
        // Either marked completed OR date has passed
        $pastEvents[] = $event;
    } elseif ($eventState === 'active' || $eventDate == $currentDate) {
        // Either marked active OR happening today
        $ongoingEvents[] = $event;
    } else {
        // Future events (not started and date is ahead)
        $futureEvents[] = $event;
    }





    // if ($event['state_of_event'] === 'completed') {
    //     $pastEvents[] = $event;
    // } elseif ($event['state_of_event'] === 'active') {
    //     $ongoingEvents[] = $event;
    // } else {
    //     $futureEvents[] = $event;
    // }
}
?>

<head>
    <title>V</title>
    <?php include __DIR__ . '/../navbar/navbar.php'; ?>
    <!-- <link rel="stylesheet" type="text/css" href="/V/View/globalstyles.css"> -->
    <link rel="stylesheet" type="text/css" href="/V/View/activity/activity.css">


    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div id="userrole" data-role="<?= htmlspecialchars($role) ?>"></div>
        <div class="pageHeader">
            <h1 class="pageTitle">Activity Management</h1>
            <p class="pageSubtitle">Track and manage your volunteer activities and events</p>
        </div>
        <div class="filters">

            <!-- Session Message -->
            <?php if (isset($_SESSION['message'])): ?>
                <div style="padding: 8px 16px; border-radius: 20px; font-size: 0.85rem; font-weight: 500;
                    background: <?= $_SESSION['message_type'] === 'success' ? 'rgba(255, 255, 255)' : 'rgba(255, 255, 255)' ?>;
                    color: <?= $_SESSION['message_type'] === 'success' ? '#10b981' : '#ef4444' ?>;
                    border: 1px solid <?= $_SESSION['message_type'] === 'success' ? 'rgba(16, 185, 129, 0.3)' : 'rgba(239, 68, 68, 0.3)' ?>;">
                    <?= htmlspecialchars($_SESSION['message']) ?>
                </div>
                <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
            <?php endif; ?>

            <div class="filter-chips">
                <?php
                // Determine current filter from POST or default
                $currentFilter = $_POST['filter'] ?? (
                    $role === 'volunteer' ? 'enrolled' :
                    ($role === 'manager' ? 'annual' :
                        ($role === 'representative' ? 'standard' :
                            ($role === 'organisationrep' ? 'annual' :'all')))
                );//here standard means organized standard events
                ?>

                <div class="date-filter-chip">
                    <input type="date" id="start_date"> &nbsp; ◊ &nbsp;
                    <input type="date" id="end_date"> &nbsp;
                    <div class="date-filter-submit" id="dateFilterSubmitBtn" onclick="applyDateandProcessedFilter()">
                        <button type="submit">➜</button>
                    </div>
                    <div class="date-filter-reset" id="dateFilterResetBtn">
                        <button type="reset">↺</button>
                    </div>
                </div>

                <?php if ($role === 'volunteer' || $role === 'representative' || $role === 'organisationrep' ): ?>
                    <div class="filter-chip <?= $currentFilter === 'enrolled' ? 'active' : '' ?>" data-filter="enrolled"> Enrolled </div>
                <?php endif; ?>

                <?php if ($role === 'manager' || $role === 'representative' || $role === 'organisationrep'): ?>
                    <div class="filter-chip <?= $currentFilter === 'standard' ? 'active' : '' ?>" data-filter="standard"> My Standard Projects </div>
                <?php endif; ?>

                <div class="filter-chip <?= $currentFilter === 'annual' ? 'active' : '' ?>" data-filter="annual"> Annual </div>

                <!-- Filter: managers and reps only -->
                <?php if ($role === 'manager' || $role === 'representative' || $role === 'organisationrep'): ?>
                    <div>
                        <select id="past-filter" class="past-filter-select" onchange="processedFilter()">
                            <option value="all">All Events</option>
                            <option value="unprocessed">Unprocessed</option>
                            <option value="processed">Processed</option>
                        </select>
                    </div>
                <?php endif; ?>

            </div>

        </div>
        <div class="tabsContainer">
            <div class="tabs">
                <div class="tab active" data-tab="ongoing">Ongoing Projects</div>
                <div class="tab" data-tab="past">Past Projects</div>
                <div class="tab" data-tab="future">Future Projects</div>
            </div>
        </div>

        <!-- Ongoing Activities Tab -->
        <div class="tabContent active" id="ongoing">
            <div class="activitiesGrid">
                <?php if (empty($ongoingEvents)): ?>
                    <p style="text-align: center;">No Ongoing Projects at the Moment</p>
                <?php endif; ?>
                <?php foreach ($ongoingEvents as $event): ?>
                    <div class="activityCard ongoing" data-eventDate="<?= htmlspecialchars($event['event_date']) ?>">
                        <div class="activityHeader">
                            <div>
                                <div class="activityTitle"><?= htmlspecialchars($event['name']) ?></div>
                                <span class="activityStatus statusOngoing">Active</span>
                            </div>
                        </div>
                        <div class="activityDetails">
                            <div class="activityMeta">
                                <div class="metaItem">
                                    <span>📅</span>
                                    <span><?= htmlspecialchars($event['event_date']) ?></span>
                                </div>
                                <div class="metaItem">
                                    <span>📍</span>
                                    <span><?= htmlspecialchars($event['location']) ?></span>
                                </div>
                                <div class="metaItem">
                                    <span class="participantsCount">
                                        <span>👥</span>
                                        <span><?= $event['current_participants'] ?>/<?= $event['max_participants'] ?>
                                            volunteers</span>
                                    </span>
                                </div>
                            </div>
                            <p class="activityDescription">
                                <?= htmlspecialchars($event['description']) ?>
                                <!-- Join our ongoing beach cleanup initiative to remove plastic waste and debris from Negombo
                            coastline. Help preserve marine ecosystems and raise environmental awareness. -->
                            </p>
                            <?php if(isset($event['taskname'])):?>
                                <div class="volunteerTasks">
                                    <div class="tasksTitle">

                                        Your allocated task is: <?= htmlspecialchars($event['taskname']) ?>
                                    </div>

                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="activityActions">
                            <!-- <a href="#view" class="btn btnPrimary">View Details</a> -->




                            <div class="ratingLinks">
                                <?php if (isset($_SESSION['user_id']) && $organizerId === $_SESSION['user_id'] ): ?>
                                    <a href="/V/router.php?module=task&action=managetasks&event_id=<?= $event['event_id'] ?>"
                                        class="btn btnRating">Manage Tasks</a>
                                <?php endif; ?>



                                <?php if (isset($_SESSION['user_id']) && $organizerId === $_SESSION['user_id'] ): ?>
                                    <a href="/V/router.php?module=rating&action=ratetasks&event_id=<?= $event['event_id'] ?>"
                                        class="btn btnRating">Rate Tasks</a>
                                <?php endif; ?>

                                <?php if (isset($_SESSION['user_id']) && $organizerId === $_SESSION['user_id'] ): ?>
                                    <button class="btn-scan-qr" data-event-id="<?= $event['event_id'] ?>">Mark Attendance</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
                <div id="scanner-overlay">
                    <div class="scanner-content">
                        <h2>Scan QR Code</h2>

                        <!-- The Scanner Render Area -->
                        <div id="reader"></div>
                        <div class="divider">--- OR ---</div>

                        <div class="user-id-section">
                            <p class="section-title">Enter User ID</p>
                            <input type="text" id="userID" name="userID" placeholder=" eg:- 103 " class="user-id-input">
                            <button class="submit-id-button">Submit ID</button>
                        </div>

                        <!-- Result Area -->
                        <div id="qr-result">
                            <strong>✔ Attendance marked</strong> User ID:<span id="outputData"></span>
                        </div>


                        <!-- Stop Button to close the overlay -->
                        <button id="btn-stop-scan">Close Scanner</button>

                    </div>
                </div>

            </div>
        </div>

        <!-- Past Activities Tab -->
        <div class="tabContent" id="past">
            <div class="activitiesGrid" id="past-grid">
                <?php if (empty($pastEvents)): ?>
                    <p style="text-align: center;">No Past Projects Available</p>
                <?php endif; ?>
                <?php foreach ($pastEvents as $event): ?>
                    <div class="activityCard past" data-processed="<?= $event['points_processed'] ? '1' : '0' ?>"
                        data-eventDate="<?= htmlspecialchars($event['event_date']) ?>">
                        <div class="activityHeader">
                            <div>
                                <div class="activityTitle"><?= htmlspecialchars($event['name']) ?></div>
                                <span class="activityStatus statusPast">Completed</span>
                            </div>
                        </div>
                        <div class="activityDetails">
                            <div class="activityMeta">
                                <div class="metaItem">
                                    <span>📅</span>
                                    <span><?= htmlspecialchars($event['event_date']) ?></span>
                                </div>
                                <div class="metaItem">
                                    <span>📍</span>
                                    <span><?= htmlspecialchars($event['location']) ?></span>
                                </div>
                                <div class="metaItem">
                                    <span class="participantsCount">
                                        <span>👥</span>
                                        <span><?= $event['current_participants'] ?>/<?= $event['max_participants'] ?>
                                            volunteers</span>
                                    </span>
                                </div>
                            </div>
                            <p class="activityDescription">
                                <?= htmlspecialchars($event['description']) ?>
                                <!-- Successfully restored 2 hectares of mangrove ecosystem, planted 500+ mangrove seedlings, and
                            educated local communities about coastal conservation. -->
                            </p>
                        </div>
                        <div class="activityActions">


                            <div class="ratingLinks">




                                <!-- <button class="btn-scan-qr" data-event-id="<?= $event['event_id'] ?>">Share Feedback & Photos</button> -->
                                <button class="btn-feedback-photos" id="demo-btn" data-event-id="<?= $event['event_id'] ?>"
                                    data-event-name="<?= htmlspecialchars($event['name']) ?>">Share Feedback &
                                    Photos</button>

                                <!-- Rate Peers: volunteers + reps + orgreps, only within open window -->
                                <?php if (($role === 'volunteer' || $role === 'representative' || $role === 'organisationrep') && ($event['organizer_id'] != $_SESSION['user_id'])): ?>
                                    <?php if (!empty($event['peer_rating_open_until']) &&    strtotime($event['peer_rating_open_until']) > time()): ?>
                                        <?php if ($event['peers_rated']): ?>
                                            <span class="btn btnRating" style="opacity:0.5; cursor:not-allowed;">
                                                Peers Already Rated
                                            </span>
                                        <?php else: ?>                                                                                
                                        <a href="/V/router.php?module=rating&action=peer&event_id=<?= $event['event_id'] ?>"
                                            class="btn btnRating">
                                            Rate Peers
                                            <small style="font-weight:normal; margin-left:4px;">
                                                (closes <?= date('M d', strtotime($event['peer_rating_open_until'])) ?>)
                                            </small>
                                        </a>
                                        <?php endif; ?>
                                    <?php elseif (!empty($event['peer_rating_open_until'])): ?>
                                        <span class="btn btnRating" style="opacity:0.5; cursor:not-allowed;">
                                            Rating Window Closed
                                        </span>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <!-- Rate Tasks + Process: organizer only -->
                                <?php if (isset($_SESSION['user_id']) && $event['organizer_id'] === $_SESSION['user_id']): ?>

                                    <!-- Rate Tasks: within open window only -->
                                    <?php if (!empty($event['peer_rating_open_until']) &&    strtotime($event['peer_rating_open_until']) > time()): ?>
                                        <?php if ($event['tasks_rated']): ?>
                                            <span class="btn btnRating" style="opacity:0.5; cursor:not-allowed;">
                                                Tasks Already Rated 
                                            </span>
                                        <?php else: ?>
                                        <a href="/V/router.php?module=rating&action=ratetasks&event_id=<?= $event['event_id'] ?>"
                                            class="btn btnRating">
                                            Rate Tasks
                                            <small style="font-weight:normal; margin-left:4px;">
                                                (closes <?= date('M d', strtotime($event['peer_rating_open_until'])) ?>)
                                            </small>
                                        </a>
                                        <?php endif; ?>
                                    <?php elseif (!empty($event['peer_rating_open_until'])): ?>
                                        <span class="btn btnRating" style="opacity:0.5; cursor:not-allowed;">
                                            Task Rating Closed
                                        </span>
                                    <?php endif; ?>

                                    <?php
                                    $sevendaysafterevent = date('Y-m-d', strtotime($event['event_date'] . '+7 days'));
                                    $canprocess=$currentDate>=$sevendaysafterevent;
                                    ?>    

                                    <!-- Process Event -->
                                    <?php if ($event['points_processed']): ?>
                                        <span class="btn btnRating" style="opacity:0.5; cursor:not-allowed;">
                                            Points Already Awarded
                                        </span>
                                    <?php elseif($canprocess): ?>

                                        <form method="POST" action="/V/router.php?module=achievement&action=processevent">
                                            <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">
                                            <button type="submit" class="btn btnRating">
                                                Process Event & Award Points
                                            </button>
                                        </form>
                                    <?php else: ?>
                                          <span class="btn btnRating" style="opacity:0.5; cursor:not-allowed;">
                                            Process after <?= $sevendaysafterevent ?>
                                        </span> 
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>


                            <!-- Feedback Overlay Modal -->

                            <!-- <a href="#report" class="btn btnSecondary">View Report</a>
                        <a href="#photos" class="btn btnOutline">Photo Gallery</a>
                        <a href="#feedback" class="btn btnOutline">Feedback</a> -->
                        </div>
                    </div>


                <?php endforeach; ?>

                <div id="feedback-overlay">
                    <div class="feedback-modal">
                        <!-- Header -->
                        <div class="feedback-header">
                            <h2>📸 Share Your Feedback & Photos</h2>
                            <button class="close-btn" id="close-feedback-btn">&times;</button>
                        </div>

                        <!-- Body -->
                        <div class="feedback-body">


                            <form id="feedback-form">

                                <!-- Event ID (Hidden) -->
                                <input type="hidden" id="event-id" name="event_id" value="">

                                <!-- Event Name (Read-only) -->
                                <div class="form-group">
                                    <label for="event-name">Event Name</label>
                                    <input type="text" id="event-name" name="event_name" placeholder="Event name"
                                        value="" readonly style="background: #f9fafb; cursor: not-allowed;">
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Your Email *</label>
                                    <input type="email" id="email" name="email" placeholder="your.email@example.com"
                                        required>
                                </div>

                                <!-- Feedback Text -->
                                <div class="form-group">
                                    <label for="feedback">Your Feedback *</label>
                                    <textarea id="feedback" name="feedback"
                                        placeholder="Share your experience, learnings, and highlights from this event..."
                                        required></textarea>
                                </div>

                                <!-- Rating -->
                                <div class="rating-group">
                                    <label class="rating-label">How would you rate this event?</label>
                                    <div class="star-rating" id="star-rating">
                                        <button class="star-btn" data-rating="1" type="button">★</button>
                                        <button class="star-btn" data-rating="2" type="button">★</button>
                                        <button class="star-btn" data-rating="3" type="button">★</button>
                                        <button class="star-btn" data-rating="4" type="button">★</button>
                                        <button class="star-btn" data-rating="5" type="button">★</button>
                                    </div>
                                </div>

                                <!-- File Upload -->
                                <div class="file-upload-group">
                                    <label class="file-upload-label">📷 Add Photos (Optional)</label>
                                    <div class="file-upload-area" id="file-upload-area">
                                        <div class="upload-icon">📁</div>
                                        <div class="upload-text">Drag & drop your photos here</div>
                                        <div class="upload-hint">or click to browse (Max 5MB per file, JPG/PNG)
                                        </div>
                                    </div>
                                    <input type="file" id="file-input" multiple accept="image/jpeg,image/png,image/jpg">

                                    <!-- File List -->
                                    <ul class="file-list" id="file-list"></ul>

                                    <!-- Image Preview -->
                                    <div class="file-preview" id="file-preview"></div>
                                </div>
                            </form>
                        </div>
                        <div class="success-message" id="success-msg">
                            ✓ Your feedback has been sent successfully!
                        </div>
                        <!-- Footer -->
                        <div class="feedback-footer">
                            <button class="btn btn-cancel" id="cancel-btn">Cancel</button>
                            <button class="btn btn-submit" id="submit-btn">Send Feedback</button>
                        </div>
                    </div>
                </div>




            </div>
        </div>
        <!-- Future Activities Tab -->
        <div class="tabContent" id="future">
            <div class="activitiesGrid">
                <?php if (empty($futureEvents)): ?>
                    <p style="text-align: center;">No Future Projects Available</p>
                <?php endif; ?>
                <?php foreach ($futureEvents as $event): ?>
                    <div class="activityCard future" data-eventDate="<?= htmlspecialchars($event['event_date']) ?>">
                        <div class="activityHeader">
                            <div>
                                <div class="activityTitle"><?= htmlspecialchars($event['name']) ?></div>
                                <span class="activityStatus statusFuture">Upcoming</span>
                            </div>
                        </div>
                        <div class="activityDetails">
                            <div class="activityMeta">
                                <div class="metaItem">
                                    <span>📅</span>
                                    <span><?= htmlspecialchars($event['event_date']) ?></span>
                                </div>
                                <div class="metaItem">
                                    <span>📍</span>
                                    <span><?= htmlspecialchars($event['location']) ?></span>
                                </div>
                                <div class="metaItem">
                                    <span class="participantsCount">
                                        <span>👥</span>
                                        <span><?= $event['current_participants'] ?>/<?= $event['max_participants'] ?>
                                            volunteers</span>
                                    </span>
                                </div>
                            </div>
                            <p class="activityDescription">
                                <?= htmlspecialchars($event['description']) ?>
                                <!-- Participate in coral restoration activities including coral fragment collection, nursery
                            maintenance, and underwater cleanup. Scuba certification preferred. -->
                            </p>
                        </div>
                        <div class="activityActions">
                            <div class="ratingLinks">
                                <!-- <button class="btnEnroll">View Event</button> -->
                                <?php if ($role === 'volunteer' || $role === 'representative' || $role === 'organisationrep' ): ?>
                                    <?php if ($event['is_enrolled'] ?? false): ?>
                                        <button class="btnEnroll" disabled style="opacity:0.5; cursor:not-allowed;">
                                            Already Enrolled
                                        </button>
                                    <?php else: ?>
                                        <button class="btnEnroll"
                                            onclick="window.location.href='/V/router.php?module=projects&action=events#event-<?= $event['event_id'] ?>'">
                                            Enroll
                                        </button>
                                    <?php endif; ?>
                                <?php endif;?>


                                <?php if (isset($_SESSION['user_id']) && $organizerId === $_SESSION['user_id'] ): ?>
                                    <a href="/V/router.php?module=task&action=managetasks&event_id=<?= $event['event_id'] ?>"
                                        class="btn btnRating">Manage Tasks</a>
                                <?php endif; ?>


                            </div>
                        </div>

                        <!-- <div class="activityActions">
                        <a href="#register" class="btn btnPrimary">Register</a> -->
                        <!-- <a href="#details" class="btn btnOutline">Learn More</a>  -->
                        <!-- </div> -->
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>

    <script src="/V/View/activity/activity.js"></script>

</body>

</html>