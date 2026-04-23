<html>

<?php
//get stuff from the $taskrateresult which was in the router and break the key value pairs(returned from the rendertaskrating function in controller) of that variable for ease of use in this .php file
$eventdetails = isset($taskrateresult['event']) ? $taskrateresult['event'] : [];//output is event_id, name, description, event_type, isauthorized, state_of_event, is_annual, starpoints_reward, levelpoints_reward, event_date, time, location, scale, max_participants, current_participants, organizer_id, createddate, duration
$tasksofevent = isset($taskrateresult['tasks']) ? $taskrateresult['tasks'] : [];//this is a big TABLE that is returned (several rows) where each row has (task_id, name, description, status, event_id, max_participants, current_participants, organizer_id, createddate)
$progressdetails = isset($taskrateresult['progress']) ? $taskrateresult['progress'] : [];    //total,completed,pending,percentage,is_complete
?>

<head>

    <title>V</title>
    <link rel="stylesheet" type="text/css" href="/V/View/rating/task/ratetask.css">
    <?php include __DIR__ . '/../../navbar/navbar.php'; ?>



    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<body>


    <div class="mainContent">
        <div class="dashboardHeader">
            <h1 class="dashboardTitle">Task Rating Dashboard</h1>
            <p class="dashboardSubtitle">Rate the success of the distributed tasks</p>
            <div class="eventInfo">
                <span><?php echo htmlspecialchars($eventdetails['event_type']); ?></span>
                ✺
                <span><?php echo htmlspecialchars($eventdetails['name']); ?></span>
            </div>
        </div>

        <div class="dashboardLayout">
            <!-- Progress Section -->
            <div class="progressSection" <?php echo (empty($tasksofevent) ? ' style= "display:none;" ': '' ); ?>>
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
                            <div class="statLabel">Total Tasks Created</div>
                        </div>
                        <div class="statItem">
                            <div class="statNumber" id="progressPercent">
                                <?php echo htmlspecialchars($progressdetails['percentage']); ?>%</div>
                            <div class="statLabel">Progress</div>
                        </div>
                    </div>
                    <div class="progressBar">
                        <div class="progressFill" id="progressFill" style="width: 0%"></div>
                    </div>
                    <div class="progressText">Evaluate tasks to monitor progress and recognize effort.</div>
                </div>
            </div>

            <!-- Rating Section -->
            <div class="ratingSection" <?php echo ($progressdetails['is_complete'] ? ' style= "display:none;" ' : ''); ?>>
                <div class="sectionHeader">
                    <h2 class="sectionHeading">Rate the Performance of Distributed Tasks</h2>
                    <div class="remainingCount" id="remainingCount">
                        <?php echo htmlspecialchars($progressdetails['pending']); ?> remaining</div>
                </div>

                <div class="taskGrid" id="taskGrid">


                    <?php
                    //check if we have task data
                    if (!empty($tasksofevent)) {//a table is returned(collection of rows)
                        foreach ($tasksofevent as $task) {

                            ?>
                            <!-- //<1?php echo ;?> -->
                            <!-- $task format is task_id, name, description, status, event_id, max_participants, current_participants, organizer_id, createddate -->
                            <!-- must use data-xxx (a data attribute=custom storage slot inside the HTML element that the JS can read) -->
                            <div class="taskRatingCard" data-task="<?php echo htmlspecialchars($task['task_id']); ?>">
                                <div class="taskHeader">
                                    <div class="taskDetails">
                                        <h3><?php echo htmlspecialchars($task['name']); ?></h3>
                                        <p>Task ID:
                                            T<?php echo htmlspecialchars(str_pad($task['task_id'], 3, '0', STR_PAD_LEFT)); ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="taskDescription">
                                    <div class="taskDescriptionHeader">Tasks Description:

                                        <div class="taskDescriptionData">
                                            <?php echo htmlspecialchars($task['description']); ?>
                                        </div>
                                    </div>
                                </div>

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
                                            placeholder="Share your observations on the quality and completion of each task..."></textarea>
                                    </div>
                                </div>

                                <button class="submitRating" disabled>Submit Rating</button>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<div style="text-align: center; color: white; padding: 40px;">';
                        echo '<p style="font-size: 1.2rem;">No tasks created to evaluate performance.</p>';
                        echo '</div>';
                    }                    

                    ?>

                </div>
                <br>
                <div class="backbuttoncontainer">
                                                <a href="/V/router.php?module=activity&action=activity"><div class="backbutton">Return to Activity Page</div></a>

                </div>


                <!-- Volunteer Rating Card 5 -->
                <!-- <div class="taskRatingCard" data-volunteer="V011">
                        <div class="taskHeader">
                            
                            <div class="taskDetails">
                                <h3>Sorting Collected Trash</h3>
                                <p>Task ID: T011</p>
                            </div>
                        </div>
                        
                        <div class="taskDescription">
                            <div class="taskDescriptionHeader">Tasks Description:</div>
                            <div class="taskDescriptionData">
                                • Sorting Collected Trash<br>
                            </div>
                        </div>

                        <div class="ratingControls">
                            <label class="ratingLabel">Rate Performance:</label>
                            <div class="starRating" data-rating="0">
                                <span class="star" data-value="1">★</span>
                                <span class="star" data-value="2">★</span>
                                <span class="star" data-value="3">★</span>
                                <span class="star" data-value="4">★</span>
                                <span class="star" data-value="5">★</span>
                            </div>
                            <div class="ratingText"></div>
                            
                             <div class="commentSection">
                                <label class="commentLabel">Additional Comments (Optional):</label>
                                <textarea class="commentInput" placeholder="Share your thoughts on the quality of teamwork and task execution..."></textarea>
                            </div> 
                        </div>

                        <button class="submitRating" disabled>Submit Rating</button>
                    </div> 
            </div>-->
        </div>

        <!-- Completion Section -->
        <div class="completionSection" id="completionSection" <?php echo ($progressdetails['is_complete'] ? 'style= "display:block;" ' : ''); ?>>
            <!-- <div class="completionIcon">🎉</div> -->
            <h2 class="completionTitle">All Ratings Completed!</h2>
            <p class="completionMessage">
                Thank you for providing valuable feedback. Your ratings help improve our volunteer community and ensure
                better coordination for future events.
            </p>
            <div class="backbuttoncontainer">
                            <a href="/V/router.php?module=activity&action=activity"><div class="backbutton">Return to Activity Page</div></a>

            </div>
            <!-- <button class="viewResultsBtn">View My Rating Results</button> -->
        </div>
    </div>
    </div>
    <script src="/V/View/rating/task/ratetask.js"></script>
</body>

</html>