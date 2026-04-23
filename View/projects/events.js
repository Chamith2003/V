

// FIXED: Store eventId globally when modal opens
let currentDeleteEventId = null;
function showForm(eventId, spotsAvailable) {
    document.getElementById("joinEventId").value = eventId;
    document.getElementById("participants").setAttribute('max', spotsAvailable);
    document.getElementById("participants").setAttribute('placeholder', 'Enter number (max: ' + spotsAvailable + ')');
    document.getElementById("form").classList.add("active");
}

function showEditForm(eventId) {
    document.getElementById("editForm_" + eventId).classList.add("active");
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove("active");
    }
}


function openModal() {
    document.getElementById("modalOverlay").style.display = "flex";
    document.querySelector(".page-content").classList.add("blurred");
}



function toggleParticipants() {
    let groupRadio = document.querySelector('input[value="group"]');
    let field = document.getElementById("participantsField");
    if (groupRadio.checked) {
        field.style.display = "block";
    } else {
        field.style.display = "none";
    }
}

function confirmSelection() {
    let choice = document.querySelector('input[name="joinType"]:checked');
    if (choice) {
        if (choice.value === "group") {
            let num = document.getElementById("participants").value;
            if (!num) {
                alert("Please enter number of participants.");
                return;
            }
            alert(`You selected: Group with ${num} participants`);
        } else {
            alert("You selected: Individual");
        }
        closeModal();
    } else {
        alert("Please select an option.");
    }
}

document.addEventListener('click', function (event) {
    if (event.target.classList.contains('overlay')) {
        event.target.classList.remove('active');
    }
});
//now replaced by calendar's leave event

// function withdrawEvent(eventId) {
//     if (confirm('Are you sure you want to withdraw from this event?')) {
//         const form = document.createElement('form');
//         form.method = 'POST';
//         form.action = '/V/router.php?module=projects&action=withdrawevent';
//         const input = document.createElement('input');
//         input.type = 'hidden';
//         input.name = 'event_id';
//         input.value = eventId;
//         form.appendChild(input);
//         document.body.appendChild(form);
//         form.submit();
//     }
// }
// function withdrawEvent(eventId) {
//     document.getElementById("withdrawEventId").value = eventId;
//     document.getElementById("withdrawForm").classList.add("active");
// }
// function openModaldelete() {
//     document.getElementById('modalOverlay').classList.add('active');
// }
function openModaldelete(eventId) {
    currentDeleteEventId = eventId;
    document.getElementById('modalOverlay').style.display = 'flex';
}

// function closeModaldelete() {
//     const modal = document.getElementById('modalOverlay');
//     modal.style.display = "none";
// }
function closeModaldelete() {
    const modal = document.getElementById('modalOverlay');
    modal.style.display = "none";
    currentDeleteEventId = null;
}

// function confirmDelete() {
//     alert('Event deleted successfully!');
//     closeModaldelete();
// }

function confirmDelete() {
    if (currentDeleteEventId) {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'GET';
        form.action = '/V/router.php';
        
        // Add module parameter
        const moduleInput = document.createElement('input');
        moduleInput.type = 'hidden';
        moduleInput.name = 'module';
        moduleInput.value = 'projects';
        form.appendChild(moduleInput);
        
        // Add action parameter
        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = 'deleteevent';
        form.appendChild(actionInput);
        
        // Add id parameter
        const idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'id';
        idInput.value = currentDeleteEventId;
        form.appendChild(idInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Close modal when clicking outside of it
// document.getElementById('modalOverlay').addEventListener('click', function(e){
//     if (e.target === this) {
//         closeModaldelete();
//     }
// });
document.addEventListener('DOMContentLoaded', function() {
    const modalOverlay = document.getElementById('modalOverlay');
    if (modalOverlay) {
        modalOverlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModaldelete();
            }
        });
    }
});


// Add smooth scroll to event card on page load
window.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash;
    if (hash) {
        const eventCard = document.querySelector(hash);
        if (eventCard) {
            setTimeout(() => {
                eventCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                eventCard.classList.add('highlight-card');
                
                // Remove highlight after 0.8 second
                setTimeout(() => {
                    eventCard.classList.remove('highlight-card');
                }, 800);
            }, 400);
        }
    }
});

function clearFilters() {
    // Redirect to the events page without any query parameters
    window.location.href = '/V/router.php?module=projects&action=events';
}
window.addEventListener('load', function() {
    // Check if this is a page refresh (not a normal navigation)
    if (performance === 1 || performance.getEntriesByType('navigation')[0]?.type === 'reload') {
        // Check if there are any filter parameters in the URL
        const urlParams = new URLSearchParams(window.location.search);
        const hasFilters = urlParams.has('search') || urlParams.has('location') || 
                          urlParams.has('event_type') || urlParams.has('date');
        
        if (hasFilters) {
            // Redirect to clean URL without filters
            window.location.href = '/V/router.php?module=projects&action=events';
        }
    }
});


function confirmLeaveEvent(eventId) {
    let modalHtml = `
            <span class="close-btn" onclick="closeWithdrawModal()">&times;</span>
            <h2>Withdraw from Event</h2>
            <p>Are you sure you want to withdraw from this event?</p>
            <p>This action cannot be undone and may result in loss of level points.</p>
            <div class="modal-buttons">
                <button class="btn btn-cancel" onclick="closeWithdrawModal()">Cancel</button>
                <button class="btn btn-confirm" onclick="leaveEvent(${eventId})">Confirm Withdraw</button>
            </div>`;
    document.getElementById('modal').innerHTML = modalHtml;
    document.getElementById('withdrawOverlay').classList.add('active');
}

function showmessage(message) {
    let modalHtml = `
            <span class="close-btn" onclick="closeWithdrawModalAndReload()">&times;</span>
            <h2>Notification</h2>
            <p>${message}</p>
            <div class="modal-buttons">
                <button class="btn btn-confirm" onclick="closeWithdrawModalAndReload()">OK</button>
            </div>`;
    document.getElementById('modal').innerHTML = modalHtml;
    document.getElementById('withdrawOverlay').classList.add('active');
}

function closeWithdrawModal() {
    document.getElementById('withdrawOverlay').classList.remove('active');
}

function closeWithdrawModalAndReload() {
    document.getElementById('withdrawOverlay').classList.remove('active');
    window.location.reload();
}

document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('withdrawOverlay');
    if (overlay) {
        overlay.addEventListener('click', function (e) {
            if (e.target === this) {//this means when u click the overlay(background) itself
                closeWithdrawModalAndReload();
            }
        });
    }
});
