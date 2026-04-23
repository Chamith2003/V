<html>
<?php
// Get data from controller (this is set in the router)
$tasks = isset($tasksResult['data']) ? $tasksResult['data'] : [];
$volunteers = isset($volunteersResult['data']) ? $volunteersResult['data'] : [];
$eventId = $_GET['event_id'] ?? null;
$eventName = $tasksResult['event_name'] ?? 'Unknown Event';
?>


<?php // Calculate total volunteers enrolled in this event
$totalAttended = count($volunteers); ?>

<head>
    <title>V</title>
    <link rel="stylesheet" type="text/css" href="/V/View/rating/task/managetask.css">
    <link rel="stylesheet" type="text/css" href="/V/View/globalstyles.css">
    <script src="/V/View/rating/task/managetask.js"></script>
    <?php include __DIR__ . '/../../navbar/navbar.php'; ?>


    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>


<body>
    <div class="mainContent">
        <div class="dashboardHeader">
            <h1 class="dashboardTitle">Task Assignment Dashboard</h1>
            <p class="dashboardSubtitle">Manage tasks and assign volunteers for your environmental projects</p>
        </div>
        <!-- Display session messages -->
        <?php
        if (isset($taskcontroller)) {
            $taskcontroller->displaySessionMessage();
        }
        ?>
        <div class="dashboardLayout" data-event-id="<?php echo $eventId; ?>">
            <!-- Event Tasks Section -->
            <div class="tasksSection">
                <div class="sectionHeader">
                    <div style="display: flex; align-items: center;">
                        <a href="/V/router.php?module=activity&action=activity" class="backButton">⇦</a>
                        <h2 class="taskSubtitle"><?php echo htmlspecialchars($eventName); ?></h2>
                    </div>
                    <button class="createTaskBtn" onclick="openTaskModal()">
                        <span>+</span>
                        Create Task
                    </button>
                </div>
                <div id="tasksContainer">
                    <?php if (empty($tasks)): ?>
                        <div class="noTasks">No tasks created yet. Click "Create Task" to get started.</div>
                    <?php else: ?>
                        <?php foreach ($tasks as $task): ?>
                            <?php
                            $assignedCount = count($task['assigned_volunteers']);
                            $needsMore = $task['max_participants'] - $assignedCount;
                            ?>
                            <!-- Collect Trash Task -->
                            <div class="taskCard <?php echo htmlspecialchars($task['status']); ?>">
                                <div class="taskActions">
                                    <button class="taskActionBtn editBtn" onclick="editTask(<?php echo $task['task_id']; ?>)"
                                        title="Edit Task">
                                        <img src="/V/View/resources/edit_blue.png">
                                    </button>
                                    <form method="post" action="/V/router.php?module=task&action=deletetask"
                                        style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this task?')">
                                        <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
                                        <input type="hidden" name="event_id" value="<?php echo $eventId; ?>">
                                        <button type="submit" class="taskActionBtn deleteBtn" title="Delete Task">
                                            <img src="/V/View/resources/delete_blue.png">
                                        </button>
                                    </form>
                                </div>
                                <div class="taskStatus <?php echo htmlspecialchars($task['status']); ?>">
                                    <?php echo htmlspecialchars($task['status']); ?>
                                </div>
                                <h3 class="taskTitle"><?php echo htmlspecialchars($task['name']); ?></h3>
                                <p class="taskDescription"><?php echo htmlspecialchars($task['description']); ?></p>
                                <div class="taskMeta">
                                    <span class="taskRequired">Required: <?php echo $task['max_participants']; ?>
                                        volunteers</span>
                                    <span
                                        class="taskAssigned">Assigned:<?php echo $assignedCount; ?>/<?php echo $task['max_participants']; ?></span>
                                </div>
                                <div class="assignedVolunteers" dataTaskId="<?php echo $task['task_id']; ?>">
                                    <?php if (!empty($task['assigned_volunteers'])): ?>
                                        <?php foreach ($task['assigned_volunteers'] as $volunteer): ?>
                                            <div class="volunteerChip">
                                                <div class="volunteerAvatar">
                                                    <?php
                                                    $names = explode(' ', $volunteer['name']);
                                                    echo strtoupper(substr($names[0], 0, 1));
                                                    if (isset($names[1]))
                                                        echo strtoupper(substr($names[1], 0, 1));
                                                    ?>
                                                </div>
                                                <span><?php echo htmlspecialchars($volunteer['name']); ?>
                                                    (<?php echo htmlspecialchars($volunteer['volunteer_id']); ?>)</span>
                                                <form method="post" action="/V/router.php?module=task&action=removevolunteer"
                                                    style="display:inline;">
                                                    <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
                                                    <input type="hidden" name="volunteer_id"
                                                        value="<?php echo $volunteer['volunteer_id']; ?>">
                                                    <input type="hidden" name="event_id" value="<?php echo $eventId; ?>">
                                                    <button type="submit" class="removeVolunteer">×</button>
                                                </form>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <div class="dropZoneText"> <?php if ($needsMore > 0): ?>
                                            Need <?php echo $needsMore; ?> more volunteers
                                        <?php else: ?>
                                            Task full!
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                            <!-- </div> -->
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Unassigned Volunteers Section -->
            <div class="volunteersSection">
                <div class="sectionHeader">
                    <h2 class="unassignedSubtitle">Unassigned Volunteers</h2>
                </div>

                <div class="volunteersList" id="volunteersList">
                    <?php if (!empty($volunteers)): ?>
                        <?php foreach ($volunteers as $volunteer): ?>
                            <div class="volunteerItem" draggable="true"
                                dataVolunteerId="<?php echo htmlspecialchars($volunteer['volunteer_id']); ?>">
                                <div class="volunteerCheckbox"
                                    onclick="toggleVolunteerSelection('<?php echo htmlspecialchars($volunteer['volunteer_id']); ?>')">
                                </div>
                                <div class="volunteerItemAvatar">
                                    <?php
                                    $names = explode(' ', $volunteer['name']);
                                    echo strtoupper(substr($names[0], 0, 1));
                                    if (isset($names[1]))
                                        echo strtoupper(substr($names[1], 0, 1));
                                    ?>
                                </div>
                                <div class="volunteerInfo">
                                    <div class="volunteerName"><?php echo htmlspecialchars($volunteer['name']); ?></div>
                                    <div class="volunteerId">ID: <?php echo htmlspecialchars($volunteer['volunteer_id']); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>

                        <div class="noVolunteers">No unassigned volunteers available.</div>
                    <?php endif; ?>

                    <button class="assignSelectedBtn" id="assignSelectedBtn" onclick="assignSelectedVolunteers()">
                        Assign Selected (0)
                    </button>
                </div>
            </div>
        </div>
        <div id="taskModal" class="modal">
            <div class="modalContent">
                <div class="modalHeader">
                    <h2 id="modalTitle">Create New Task</h2>
                    <span class="modalClose" onclick="closeTaskModal()">&times;</span>
                </div>
                <form id="taskForm" method="post">
                    <input type="hidden" id="taskId" name="task_id" value="">
                    <input type="hidden" name="event_id" value="<?= $eventId ?>">

                    <div class="formGroup">
                        <label for="taskTitleInput">Task Title *</label>
                        <input type="text" id="taskTitleInput" name="name" required maxlength="255">
                    </div>

                    <div class="formGroup">
                        <label for="taskDescriptionInput">Description *</label>
                        <textarea id="taskDescriptionInput" name="description" required maxlength="1000"
                            rows="4"></textarea>
                    </div>




                    <div class="formGroup">
                        <label for="taskRequiredInput">Required Volunteers *</label>
                        <input type="number" id="taskRequiredInput" name="max_participants" required min="1"
                            placeholder="Max: <?= $totalAttended ?> available">
                    </div>

                    <div class="formGroup">
                        <label for="taskStatusInput">Status</label>
                        <select id="taskStatusInput" name="status" required>
                            <option value="inprogress">In-Progress</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>

                        </select>
                    </div>

                    <div class="formActions">
                        <button type="button" class="cancelBtn" onclick="closeTaskModal()">Cancel</button>
                        <button type="submit" class="submitBtn">Save Task</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Assign Volunteers Modal -->
        <div id="assignModal" class="modal">
            <div class="modalContentassign">
                <div class="modalHeader">
                    <h2>Assign Volunteers to Task</h2>
                    <span class="modalClose" onclick="closeAssignModal()">&times;</span>
                </div>
                <div class="formGroup">
                    <label>Select Task</label>
                    <select id="assignTaskSelect">
                        <?php foreach ($tasks as $task): ?>
                            <option value="<?= $task['task_id'] ?>">
                                <?= htmlspecialchars($task['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="formActions">
                    <button type="button" class="cancelBtn" onclick="closeAssignModal()">Cancel</button>
                    <button type="button" class="submitBtn" onclick="confirmAssign()">Assign</button>
                </div>
            </div>
        </div>
        <!-- Alert Modal -->
        <div id="alertModal" class="modal">
            <div class="modalContentalert">
                <div class="modalHeader">
                    <h2 id="alertModalTitle">Notice</h2>
                    <span class="modalClose" onclick="closeAlertModal()">&times;</span>
                </div>
                <div class="formGroup">
                    <p id="alertModalMessage"></p>
                </div>
                <div class="formActions">
                    <button type="button" class="submitBtn" onclick="closeAlertModal()">OK</button>
                </div>
            </div>
        </div>

        <!-- Message Container -->
        <div id="messageContainer"></div>


</body>

</html>