<html>
<?php
//get results from routervariable and load them here to easy variable names
//an empty array [] is considered a set value
$eventdetails = isset($peerresult['event']) ? $peerresult['event'] : [];//load into eventdetails variable (of peer.php page) by getting router's $peerresult(is of format given in router's page) variable's event KEY's stuff
$peerdetails = isset($peerresult['peers']) ? $peerresult['peers'] : []; //$peerresult is of format like 'success'=>true,'event'=>$eventdetails,'peers'=>$peers,'progress'=>$progress
$progressdetails = isset($peerresult['progress']) ? $peerresult['progress'] : [];
//eventdetials is of format  of the entire event table
//peerdetails is of format success,data,count,total_assignments,completed_count,completion_percentage (get all peers a user must rate for a given event+returns only the pending (not yet rated) assignments)
//progressdetails is of format  total,completed,pending,percentage,is_complete (progress for a user)
//path to refer is router->$peerresult->renderpeerrating->eventdetails,peer,progress->check return types of geteventretails,getpeerstorate,getratingstatus
$haspeers=isset($peerdetails['data']);
$iscomplete=$progressdetails['is_complete'];
?>

<head>

    <title>V</title>
    <link rel="stylesheet" type="text/css" href="/V/View/rating/peer/peer.css">
    <?php include __DIR__ . '/../../navbar/navbar.php'; ?>



    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<body>


    <div class="mainContent">
        <div class="dashboardHeader">
            <h1 class="dashboardTitle">Peer Rating Dashboard</h1>
            <p class="dashboardSubtitle">Rate your fellow volunteers' performance and contribution</p>
            <div class="eventInfo">
                <span><?php echo htmlspecialchars($eventdetails['event_type']); ?></span>
                <!-- echo; only → prints raw, unsafe -->
                <!-- echo; + htmlspecialchars() → prints safely -->
                ✺
                <span><?php echo htmlspecialchars($eventdetails['name']); ?></span>
            </div>
        </div>

        <div class="dashboardLayout">
            <!-- Progress Section -->
            <div class="progressSection" <?php echo (!$haspeers? ' style= "display:none;" ': '' ); ?>>
                <div class="progressHeader">
                    <h2 class="progressTitle">Your Rating Progress</h2>
                    <div class="progressStats">
                        <div class="statItem">
                            <div class="statNumber" id="completedCount">
                                <?php echo htmlspecialchars($progressdetails['completed']); ?></div>
                            <div class="statLabel">Completed</div>
                        </div>
                        <div class="statItem">
                            <div class="statNumber" id="totalCount">
                                <?php echo htmlspecialchars($progressdetails['total']); ?></div>
                            <div class="statLabel">Total Assigned</div>
                        </div>
                        <div class="statItem">
                            <div class="statNumber" id="progressPercent">
                                <?php echo htmlspecialchars($progressdetails['percentage']); ?>%
                            </div>
                            <div class="statLabel">Progress</div>
                        </div>
                    </div>
                    <div class="progressBar">
                        <div class="progressFill" id="progressFill" style="width: 0%"></div>
                    </div>
                    <div class="progressText">Your feedback helps build a better volunteer community.</div>
                </div>
            </div>
    
            <!-- Rating Section -->
            <div class="ratingSection" <?php echo (( $iscomplete)? ' style= "display:none;" ': '' ); ?>> <!--no rating assigned is taken as completed as 0-0=0 here either has to be 0-->
                <div class="sectionHeader">
                    <h2 class="sectionHeading">Rate Your Peers</h2>
                    <div class="remainingCount" id="remainingCount">
                        <?php echo htmlspecialchars($progressdetails['pending']); ?> remaining
                    </div>
                </div>

                <div class="volunteerGrid" id="volunteerGrid">

                    <?php
                    //check if we have peer data
                    if (!empty($peerdetails['data'])) {//!empty($peerdetails['data']) returns true when data exists
                        foreach ($peerdetails['data'] as $peer) {//get $peerdetails['$data'] part as $peer
                            //generate initials from the name
                            $nameparts = explode(' ', $peer['ratee_name']);//splits the full name into words eg: "Nadin Bandara" into ['Nadin','Bandara'] 
                            $initials = '';//starting empty string
                            foreach ($nameparts as $part) {//loop thruh each word ->take the first letter ->make it uppercase
                                $initials .= strtoupper(substr($part, 0, 1));//get substring and then turn to uppercase and finally append it to intials string
                            }
                            $initials = substr($initials, 0, 2);//take first 2 letters only(keep only the first 2 letters if name has more words)
                            ?>
                            <!-- //<1?php echo ;?> -->
                            <!-- $peer fomrat is as assignment_id,ratee_id,ratee_name,status -->
<!-- must use data-xxx (a data attribute=custom storage slot inside the HTML element that the JS can read) -->
                            <div class="volunteerRatingCard" data-volunteer="<?php echo htmlspecialchars($peer['ratee_id']); ?>"
                                data-assignment="<?php echo htmlspecialchars($peer['assignment_id']); ?>" >
                                <div class="volunteerHeader">
                                    <div class="volunteerAvatar"><?php echo htmlspecialchars($initials); ?></div>
                                    <div class="volunteerDetails">
                                        <h3><?php echo htmlspecialchars($peer['ratee_name']); ?></h3>
                                        <p>Volunteer ID:
                                            V<?php echo htmlspecialchars(str_pad($peer['ratee_id'], 3, '0', STR_PAD_LEFT)); ?></p>
                                    </div>
                                </div>

                                <!-- <div class="volunteerTasks">
                                    <div class="tasksTitle">
                                        </div>
                                    <div class="tasksList">
                                        
                                    </div>
                                </div> -->

                                <div class="ratingControls">
                                    <label class="ratingLabel">Rate Performance:</label>
                                    <div class="starRating" data-rating="0">
                                        <!-- we hvnt used data-value in JS code btw -->
                                        <span class="star" data-value="1">★</span>
                                        <span class="star" data-value="2">★</span>
                                        <span class="star" data-value="3">★</span>
                                        <span class="star" data-value="4">★</span>
                                        <span class="star" data-value="5">★</span>
                                    </div>
                                    <div class="ratingText"></div>

                                    <div class="commentSection">
                                        <label class="commentLabel">Additional Comments:</label>
                                        <textarea class="commentInput"
                                            placeholder="Share your thoughts about their contribution and teamwork..."></textarea>
                                    </div>
                                </div>

                                <button class="submitRating" disabled>Submit Rating</button>
                            </div>
                        <?php
                        }
                    } else { 
                        echo '<div style="text-align: center; color: white; padding: 40px;">';
                        echo '<p style="font-size: 1.2rem;">No peer rating assignments available.</p>';
                        echo '</div>';
                    }

                    ?>

                </div>
                <br>
                <div class="backbuttoncontainer">
                                                <a href="/V/router.php?module=activity&action=activity"><div class="backbutton">Return to Activity Page</div></a>

                </div>
            </div>

            <!-- Completion Section -->
             <!-- make the completion section visible once completed only and peerassignment-less will never be complete so only those with assignments will reach here -->
            <div class="completionSection" id="completionSection" <?php echo (($iscomplete) ? 'style= "display:block;" ' : ''); ?>>
                <h2 class="completionTitle">All Ratings Completed!</h2>
                <p class="completionMessage">
                    Thank you for providing valuable feedback. Your ratings help improve our volunteer community and
                    ensure better coordination for future events.
                </p>
                <div class="backbuttoncontainer">
                                                <a href="/V/router.php?module=activity&action=activity"><div class="backbutton">Return to Activity Page</div></a>

                </div>
            </div>

            <!-- <div class="noPeersSection" id="noPeersSection" <1?php echo(!isset($peerdetails['data'])? 'style= "display:block;" ' : ''); ?>>
                <h2 class="noPeersTitle">No Available Peers to Rate</h2>
                <p class="noPeersMessage">No peers to rate right now</p>
            </div> -->
        </div>
    </div>
    <script src="/V/View/rating/peer/peer.js"></script>
</body>

</html>