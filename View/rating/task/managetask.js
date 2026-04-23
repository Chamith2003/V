
let selectedVolunteers = new Set();
let editingTaskId = null;
let draggedVolunteerID = null;
let selectedTaskForAssignment = null;

// Modal Functions
function openTaskModal(taskId = null) {
    const modal = document.getElementById('taskModal');
    const modalTitle = document.getElementById('modalTitle');
    const form = document.getElementById('taskForm');

    editingTaskId = taskId;

    if (taskId) {
        modalTitle.textContent = 'Edit Task';
        form.action = '/V/router.php?module=task&action=edittask';
        document.getElementById('taskId').value = taskId;

        // Load task data for editing (you'll need to implement this)
        // Load task data for editing
        loadTaskDataForEdit(taskId);
        // For now, we'll just change the form action
    } else {
        modalTitle.textContent = 'Create New Task';
        form.action = '/V/router.php?module=task&action=createtask';
        form.reset();
        document.getElementById('taskId').value = '';
    }

    modal.style.display = 'block';
}


function loadTaskDataForEdit(taskId) {
    // Find the task card
    const taskCards = document.querySelectorAll('.taskCard');
    let taskData = null;

    taskCards.forEach(card => {
        const assignedArea = card.querySelector('.assignedVolunteers');

        if (assignedArea && assignedArea.getAttribute('dataTaskId') == taskId) {
            const statusText = card.querySelector('.taskStatus').textContent.trim().toLowerCase();
            taskData = {
                title: card.querySelector('.taskTitle').textContent.trim(),
                description: card.querySelector('.taskDescription').textContent.trim(),
                status: statusText,
                // .replace(/\s+/g, ''),
                maxParticipants: card.querySelector('.taskRequired').textContent.match(/\d+/)[0]
            };
        }
    });

    if (taskData) {
        document.getElementById('taskTitleInput').value = taskData.title;
        document.getElementById('taskDescriptionInput').value = taskData.description;
        document.getElementById('taskStatusInput').value = taskData.status;
        document.getElementById('taskRequiredInput').value = taskData.maxParticipants;
    } else {
        console.error('Could not find task data for task ID:', taskId);
    }
}

function closeTaskModal() {
    const modal = document.getElementById('taskModal');
    modal.style.display = 'none';
    editingTaskId = null;
}

function editTask(taskId) {
    openTaskModal(taskId);
}

// Volunteer Selection (for UI feedback only)
function toggleVolunteerSelection(volunteerId) {
    if (selectedVolunteers.has(volunteerId)) {
        selectedVolunteers.delete(volunteerId);
    } else {
        selectedVolunteers.add(volunteerId);
    }
    updateVolunteerUI();
    updateAssignSelectedButton();
}

function updateVolunteerUI() {
    document.querySelectorAll('.volunteerItem').forEach(item => {
        const volunteerId = item.getAttribute('datavolunteerid');
        const checkbox = item.querySelector('.volunteerCheckbox');

        if (selectedVolunteers.has(volunteerId)) {
            checkbox.classList.add('checked');
            item.classList.add('selected');
        } else {
            checkbox.classList.remove('checked');
            item.classList.remove('selected');
        }
    });
}

function updateAssignSelectedButton() {
    const button = document.getElementById('assignSelectedBtn');
    const count = selectedVolunteers.size;
    button.textContent = `Assign Selected (${count})`;
    button.disabled = count === 0;
}


//start
function assignSelectedVolunteers() {
    if (selectedVolunteers.size === 0) {
        showAlert('Please select volunteers to assign');
        return;
    }
    document.getElementById('assignModal').style.display = 'block';
}
function closeAssignModal() {
    document.getElementById('assignModal').style.display = 'none';
}

function confirmAssign() {
    const taskId = document.getElementById('assignTaskSelect').value;
    if (!taskId) {
        showAlert('Please select a task');
        return;
    }
    assignVolunteersToTask(taskId, Array.from(selectedVolunteers));
    closeAssignModal();
}


function showAlert(message, title = 'Notice') {
    document.getElementById('alertModalTitle').innerText = title;
    document.getElementById('alertModalMessage').innerText = message;
    document.getElementById('alertModal').style.display = 'block';
}

function closeAlertModal() {
    document.getElementById('alertModal').style.display = 'none';
}


function assignVolunteersToTask(taskId, volunteerIds) {
    // Create a form to submit all assignments
    const form = document.createElement('form');
    form.method = 'post';
    form.action = '/V/router.php?module=task&action=assignmultiplevolunteers';

    const taskInput = document.createElement('input');
    taskInput.type = 'hidden';
    taskInput.name = 'task_id';
    taskInput.value = taskId;
    form.appendChild(taskInput);
    //eventID stuff
    const eventId = document.querySelector('.dashboardLayout').getAttribute('data-event-id');
    const eventIdInput = document.createElement('input');
    eventIdInput.type = 'hidden';
    eventIdInput.name = 'event_id';
    eventIdInput.value = eventId;
    form.appendChild(eventIdInput);

    // Add each volunteer ID
    volunteerIds.forEach((volunteerId, index) => {
        const volunteerInput = document.createElement('input');
        volunteerInput.type = 'hidden';
        volunteerInput.name = `volunteer_ids[${index}]`;
        volunteerInput.value = volunteerId;
        form.appendChild(volunteerInput);
    });

    document.body.appendChild(form);
    form.submit();
}




//     //end
// }

// Close modal when clicking outside
window.addEventListener('click', function (event) {
    const modal = document.getElementById('taskModal');
    if (event.target === modal) {
        closeTaskModal();
    }
});
//drag and drop implementation
// Basic drag and drop visual feedback (optional enhancement)
document.addEventListener('DOMContentLoaded', function () {
    const volunteerItems = document.querySelectorAll('.volunteerItem');
    const assignedAreas = document.querySelectorAll('.assignedVolunteers');
    //setup drag for volunteers
    volunteerItems.forEach(item => {
        item.addEventListener('click', function () { toggleVolunteerSelection(this.getAttribute('datavolunteerid')); });
        item.addEventListener('dragstart', function (e) {
            draggedVolunteerId = this.getAttribute('datavolunteerid');
            this.classList.add('dragging');
            this.style.opacity = '0.5';
        });

        item.addEventListener('dragend', function () {
            this.classList.remove('dragging');
            this.style.opacity = '1';
            draggedVolunteerId = null;
        });
    });
    //setup drop zones
    assignedAreas.forEach(area => {
        area.addEventListener('dragover', function (e) {
            e.preventDefault();
            this.classList.add('droppable');
            this.style.backgroundColor = 'rgba(101, 172, 159, 0.1)';
            this.style.borderColor = '#65AC9F';
        });

        area.addEventListener('dragleave', function () {
            this.classList.remove('droppable');
            this.style.backgroundColor = '';
            this.style.borderColor = '';
        });

        area.addEventListener('drop', function (e) {
            e.preventDefault();
            this.classList.remove('droppable');
            this.style.backgroundColor = '';
            this.style.borderColor = '';

            if (draggedVolunteerId) {
                const taskId = this.getAttribute('dataTaskId');

                // Create and submit form
                const form = document.createElement('form');
                form.method = 'post';
                form.action = '/V/router.php?module=task&action=assignvolunteer';

                const taskInput = document.createElement('input');
                taskInput.type = 'hidden';
                taskInput.name = 'task_id';
                taskInput.value = taskId;

                const volunteerInput = document.createElement('input');
                volunteerInput.type = 'hidden';
                volunteerInput.name = 'volunteer_id';
                volunteerInput.value = draggedVolunteerId;
                //eventid stuff
                const eventId = document.querySelector('.dashboardLayout').getAttribute('data-event-id');
                const eventIdInput = document.createElement('input');
                eventIdInput.type = 'hidden';
                eventIdInput.name = 'event_id';
                eventIdInput.value = eventId;

                form.appendChild(taskInput);
                form.appendChild(volunteerInput);
                form.appendChild(eventIdInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
});












// Show assignment form or redirect to assignment action
// const taskId = this.getAttribute('datataskid');
//start drag and drop
//         });
//     });
// });