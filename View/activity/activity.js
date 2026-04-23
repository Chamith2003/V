
// Tab switching functionality
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.tab');
    const tabContents = document.querySelectorAll('.tabContent');

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            const targetTab = this.dataset.tab;

            // Remove active class from all tabs and contents
            tabs.forEach(t => t.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            // Add active class to clicked tab and corresponding content
            this.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
        });
    });

    // Add hover effects and smooth transitions
    const activityCards = document.querySelectorAll('.activityCard');
    activityCards.forEach(card => {
        card.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-4px)';
        });


        card.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0)';
        });
    });
});

        
    
    
    
    
    
    



// Global variables for elements
// const startBtn = document.getElementById('btn-scan-qr'); // **REMOVED** - now using a class selector
// const filterbtn=document.getElementsByClassName('filter-chip');
    const filterChips = document.querySelectorAll('.filter-chip');
const stopBtn = document.getElementById('btn-stop-scan');
const overlay = document.getElementById('scanner-overlay');
const resultContainer = document.getElementById('qr-result');
const outputData = document.getElementById('outputData');

// Variable to hold the Html5QrcodeScanner instance
let html5QrcodeScanner;
const readerId = "reader"; // ID of the div element where the scanner renders
let currentEventId = null; // Variable to store the event_id for the current scan

// Function to stop the scanner and close the overlay (kept the same)
function stopAndCloseScanner() {
    // ... (your existing stopAndCloseScanner function) ...
    if (html5QrcodeScanner) {
        html5QrcodeScanner.clear().then(() => {
            console.log("Scanner stopped successfully.");
            overlay.style.display = 'none';
            resultContainer.style.display = 'none';
            outputData.innerText = '';
            html5QrcodeScanner = null; // Reset instance
            currentEventId = null; // Reset event ID
        }).catch(error => {
            console.warn("Failed to stop scanner, forcing close.", error);
            overlay.style.display = 'none';
            html5QrcodeScanner = null;
            currentEventId = null;
        });
    } else {
        overlay.style.display = 'none';
        currentEventId = null;
    }
}

// Function to send data to the backend
function sendAttendanceToServer(volunteerId, eventId) {
    console.log('Sending attendance', { volunteerId, eventId });
    fetch("/V/router.php?module=attendance&action=mark", {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Accept': '*/*'
        },
        body: `volunteer_id=${encodeURIComponent(volunteerId)}&event_id=${encodeURIComponent(eventId)}`
    })
        .then(resp => resp.text().then(text => ({ status: resp.status, ok: resp.ok, text })))
        .then(({ status, ok, text }) => {
            console.log('Attendance raw response:', status, text);
            let data = null;
            try {
                data = text ? JSON.parse(text) : null;
            } catch (e) {
                const escaped = escapeHtml(text || '');



                resultContainer.classList.remove("success");
                resultContainer.classList.add("error");
                resultContainer.innerHTML = `❌ Error:Invalid ID or attendance already submitted.`;
                resultContainer.style.display = "block";

                throw new Error('Invalid JSON response');
            }

            if (!ok) {
                // const msg = data && data.message ? data.message : `Server returned ${status}`;
                resultContainer.classList.remove("success");
                resultContainer.classList.add("error");
                resultContainer.innerHTML = `❌ Attendance Already Recorded.`;
                resultContainer.style.display = "block";

                return;
            }

            if (data && data.success) {
                resultContainer.classList.remove("error");
                resultContainer.classList.add("success");
                resultContainer.innerHTML = `✔ Attendance marked for Volunteer ID: ${data.volunteer_id}`;
                resultContainer.style.display = "block";

            } else {
                const msg = data && data.message ? data.message : '❌ Attendance Already Recorded.';
                resultContainer.innerHTML = `<strong>❌ ${escapeHtml(msg)}</strong>`;
                resultContainer.style.backgroundColor = '#f8d7da';
            }
            resultContainer.style.display = "block";
        })
        .catch(err => {
            console.error('Attendance request failed', err);
            if (!resultContainer.innerHTML) {
                resultContainer.innerHTML = `<strong>❌ ${escapeHtml(err.message || 'network error')}</strong>`;
                resultContainer.style.backgroundColor = '#f8d7da';
                resultContainer.style.display = "block";
            }
        });
}

// Utility to escape HTML so server responses can be shown safely
function escapeHtml(unsafe) {
    return String(unsafe)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

// Function called when a QR code is successfully scanned
function onScanSuccess(decodedText, decodedResult) {
    // 1. Send the data to the backend for processing
    if (currentEventId && decodedText) {
        sendAttendanceToServer(decodedText, currentEventId);
    }


    // 2. Stop the scanner
    if (html5QrcodeScanner) {
        html5QrcodeScanner.clear().catch(error => {
            console.error("Failed to stop scanning after success.", error);
        });
        html5QrcodeScanner = null;
    }

    console.log(`Successfully scanned: ${decodedText}`, decodedResult);
}

// Function called when the scan fails (kept the same)
function onScanFailure(error) {
    // console.warn(`Code scan error = ${error}`); 
}

// Event listener for the start button clicks (targeting the class)
document.querySelectorAll('.btn-scan-qr').forEach(button => {
    button.addEventListener('click', (event) => {
        // Get the event ID from the data attribute of the clicked button
        currentEventId = event.currentTarget.getAttribute('data-event-id');

        // 1. Show the overlay
        overlay.style.display = 'flex';
        resultContainer.style.display = 'none'; // Hide previous result

        // 2. Initialize the Scanner
        html5QrcodeScanner = new Html5QrcodeScanner(
            readerId, // The ID of the div element where the scanner will render
            {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                rememberLastUsedCamera: true
            },
                /* verbose= */ false
        );

        // 3. Render the scanner and start the camera
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    });
});

// Event listener for the stop/close button click (kept the same)
stopBtn.addEventListener('click', stopAndCloseScanner);

// Optional: Close overlay on pressing the Escape key (kept the same)
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && overlay.style.display === 'flex') {
        stopAndCloseScanner();
    }
});

// Feedback & Photos modal
document.querySelectorAll('.btn-feedback-photos').forEach(button => {
    button.addEventListener('click', (event) => {
        const eventId = event.currentTarget.getAttribute('data-event-id');
        const eventName = event.currentTarget.getAttribute('data-event-name');

        document.getElementById('event-name').value = eventName;
        document.getElementById('event-id').value = eventId;
        document.getElementById('feedback-overlay').classList.add('active');
    });
});

// **NEW CODE: Event listener for manual User ID submission**
    document.querySelector('.submit-id-button').addEventListener('click', function() {
        const userIdInput = document.getElementById('userID');
        const userId = userIdInput.value.trim();
        
        // Validate input
        if (!userId) {
            resultContainer.classList.remove("success");
            resultContainer.classList.add("error");
            resultContainer.innerHTML = `❌ Please enter a valid User ID`;
            resultContainer.style.display = "block";
            return;
        }

        // Validate that userId is numeric
        if (!/^\d+$/.test(userId)) {
            resultContainer.classList.remove("success");
            resultContainer.classList.add("error");
            resultContainer.innerHTML = `❌ User ID must contain only numbers`;
            resultContainer.style.display = "block";
            return;
        }

        // Check if we have a current event ID
        if (!currentEventId) {
            resultContainer.classList.remove("success");
            resultContainer.classList.add("error");
            resultContainer.innerHTML = `❌ No event selected. Please try again.`;
            resultContainer.style.display = "block";
            return;
        }

        // Send the user ID to the backend
        sendAttendanceToServer(userId, currentEventId);
        
        // Clear the input field after submission
        userIdInput.value = '';
    });

    // **NEW CODE: Allow Enter key to submit user ID**
    document.getElementById('userID').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.querySelector('.submit-id-button').click();
        }
    });


// Allow Enter key to submit user ID
document.getElementById('userID').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.querySelector('.submit-id-button').click();
    }
});



filterChips.forEach((chip) => {
    chip.addEventListener('click', function() {//anoynomus one time use function
        // Remove active class from all chips
        filterChips.forEach(c => c.classList.remove('active'));
        
        // Add active class to clicked chip
        this.classList.add('active');
        
        // Get filter type
        const filtertype = this.getAttribute('data-filter');
        console.log('Filter selected:', filtertype);
        
        // Add filtering logic here
        applyFilter(filtertype);
    });
});

function applyFilter(filtertype) {
    // Filtering logic
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/V/router.php?module=activity&action=activity';
    
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'filter';
    input.value = filtertype;

    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}


const feedbackoverlay = document.getElementById('feedback-overlay');
const closeBtn = document.getElementById('close-feedback-btn');
const cancelBtn = document.getElementById('cancel-btn');
const submitBtn = document.getElementById('submit-btn');
const demoBtn = document.getElementById('demo-btn');
const form = document.getElementById('feedback-form');
const fileInput = document.getElementById('file-input');
const uploadArea = document.getElementById('file-upload-area');
const fileList = document.getElementById('file-list');
const filePreview = document.getElementById('file-preview');
const starBtns = document.querySelectorAll('.star-btn');
const successMsg = document.getElementById('success-msg');
let selectedRating = 0;
const selectedFiles = [];

// Open modal
demoBtn.addEventListener('click', () => {
    feedbackoverlay.classList.add('active');
});

// Close modal
const closeModal = () => {
    feedbackoverlay.classList.remove('active');
    resetForm();
};


closeBtn.addEventListener('click', closeModal);
cancelBtn.addEventListener('click', closeModal);

// Star rating
starBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        selectedRating = parseInt(btn.dataset.rating);
        starBtns.forEach((b, idx) => {
            if (idx < selectedRating) {
                b.classList.add('active');
            } else {
                b.classList.remove('active');
            }
        });
    });
});

// File upload area click
uploadArea.addEventListener('click', () => fileInput.click());

// Drag and drop
uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.classList.add('drag-over');
});

uploadArea.addEventListener('dragleave', () => {
    uploadArea.classList.remove('drag-over');
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('drag-over');
    handleFiles(e.dataTransfer.files);
});

// File input change
fileInput.addEventListener('change', (e) => {
    handleFiles(e.target.files);
});

// Handle files
function handleFiles(files) {
    Array.from(files).forEach(file => {
        if (file.size > 5 * 1024 * 1024) {
            alert(`${file.name} exceeds 5MB limit`);
            return;
        }
        if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
            alert(`${file.name} is not a valid image format`);
            return;
        }
        selectedFiles.push(file);
        displayFile(file);
    });
}

// Display file preview
function displayFile(file) {
    const reader = new FileReader();
    reader.onload = (e) => {
        // Image preview
        const preview = document.createElement('div');
        preview.className = 'preview-item';
        preview.innerHTML = `
                <img src="${e.target.result}" alt="preview">
                <button class="remove-file" type="button">✕</button>
            `;
        preview.querySelector('.remove-file').addEventListener('click', () => {
            removeFile(file, preview);
        });
        filePreview.appendChild(preview);

        // File list item
        const listItem = document.createElement('li');
        listItem.className = 'file-list-item';
        listItem.innerHTML = `
                <span>📄 ${file.name} (${(file.size / 1024).toFixed(2)} KB)</span>
                <button class="remove-file" type="button">Remove</button>
            `;
        listItem.querySelector('.remove-file').addEventListener('click', () => {
            removeFile(file, listItem);
        });
        fileList.appendChild(listItem);
    };
    reader.readAsDataURL(file);
}

// Remove file
function removeFile(file, element) {
    selectedFiles.splice(selectedFiles.indexOf(file), 1);
    element.remove();
}

// Submit form
// submitBtn.addEventListener('click', (e) => {
//     e.preventDefault();

//     if (!form.checkValidity()) {
//         alert('Please fill in all required fields');
//         return;
//     }

//     if (selectedRating === 0) {
//         alert('Please select a rating');
//         return;
//     }

//     submitBtn.disabled = true;
//     submitBtn.innerHTML = '<span class="loading"></span> Sending...';

//     // Simulate API call
//     setTimeout(() => {
//         console.log({
//             email: document.getElementById('email').value,
//             feedback: document.getElementById('feedback').value,
//             rating: selectedRating,
//             files: selectedFiles.map(f => f.name)
//         });

//         submitBtn.disabled = false;
//         submitBtn.innerHTML = 'Send Feedback';
//         successMsg.classList.add('show');
//         form.reset();
//         selectedRating = 0;
//         starBtns.forEach(btn => btn.classList.remove('active'));
//         selectedFiles.length = 0;
//         filePreview.innerHTML = '';
//         fileList.innerHTML = '';

//         setTimeout(() => {
//             closeModal();
//             successMsg.classList.remove('show');
//         }, 2000);
//     }, 1500);
// });

// Reset form
function resetForm() {
    form.reset();
    selectedRating = 0;
    starBtns.forEach(btn => btn.classList.remove('active'));
    selectedFiles.length = 0;
    filePreview.innerHTML = '';
    fileList.innerHTML = '';
    successMsg.classList.remove('show');
}

// Close on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && feedbackoverlay.classList.contains('active')) {
        closeModal();
    }
});


// Submit form
submitBtn.addEventListener('click', (e) => {
    e.preventDefault();

    if (!form.checkValidity()) {
        alert('Please fill in all required fields');
        return;
    }

    if (selectedRating === 0) {
        alert('Please select a rating');
        return;
    }

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="loading"></span> Sending...';

    // Create FormData to send files
    const formData = new FormData();
    formData.append('email', document.getElementById('email').value);
    formData.append('event_name', document.getElementById('event-name').value);
    formData.append('event_id', document.getElementById('event-id').value);
    formData.append('feedback', document.getElementById('feedback').value);
    formData.append('rating', selectedRating);

    // Append files
    selectedFiles.forEach((file, index) => {
        formData.append('files[]', file);
    });

    // Send to backend
    fetch('/V/router.php?module=feedback&action=sendemail', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Send Feedback';

            if (data.success) {
                successMsg.classList.add('show');
                form.reset();
                selectedRating = 0;
                starBtns.forEach(btn => btn.classList.remove('active'));
                selectedFiles.length = 0;
                filePreview.innerHTML = '';
                fileList.innerHTML = '';

                setTimeout(() => {
                    closeModal();
                    successMsg.classList.remove('show');
                }, 2000);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(err => {
            console.error('Error:', err);
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Send Feedback';
            alert('Failed to send feedback. Please try again.');
        });
});



function processedFilter(){
    const pastFilter = document.getElementById('past-filter');
        if (pastFilter) {//only do this if it has a past filter
    
        const value = pastFilter.value;
        const pastcards = document.querySelectorAll('#past-grid .activityCard');
        pastcards.forEach(card => {
            const processed = card.getAttribute('data-processed');
            const dateVisible = card.getAttribute('data-date-visible') !== 'false';//must be kept notfalse to show when u only run processed without going thruh date filter first
            //When the attribute doesn't exist yet, getAttribute returns null, and null !== 'false' is true — so cards are treated as visible. 
            if (!dateVisible) {//not visible datewise
                card.style.display = 'none';
            }
            else if (value === 'all' ) {//must restore the cards
                card.style.display = 'block';
            } else if (value === 'processed') {
                card.style.display = processed === '1' ? 'block' : 'none';//if points are processed value is 1
            } else if (value === 'unprocessed') {
                card.style.display = processed === '0' ? 'block' : 'none';//unprocessed cards have processed value =0 thus it shows unprocessed ones here
            }
        });
    
    }
}

function applyDateandProcessedFilter(){
        const startDate=document.getElementById('start_date');
        const endDate=document.getElementById('end_date');
        const startDateValue=startDate.value;
        const endDateValue=endDate.value;
        const cards = document.querySelectorAll('.activityCard');
        const role = document.getElementById('userrole').dataset.role;//dataset.* is how you read a data-* attribute here data-user-id turns to  dataset.userId (kebab-case turns to camelCase)

    cards.forEach(card => {
        if(!startDateValue || !endDateValue){
            card.setAttribute('data-date-visible', 'true');//so dateVisible is true here
        } else {
            const eventDate = card.getAttribute('data-eventDate');
            card.setAttribute('data-date-visible', 
                (eventDate >= startDateValue && eventDate <= endDateValue) ? 'true' : 'false'
            );
        }
        //handle non past for organizers here itself and handle all types for volunteer and others here itself
        if(role==='manager'||role==='representative'||role==='organisationrep'){
        // Handle display for non-past cards (ongoing/future) directly here and send past hhandling to process event
        if (!card.closest('#past-grid')) {//if card is not in past grid run code
            card.style.display = card.getAttribute('data-date-visible') === 'false' ? 'none' : 'block';
        }
    }else{//volunteers handle all past/present/future here
        card.style.display = card.getAttribute('data-date-visible') === 'false' ? 'none' : 'block';
    }
    });
     if(role==='manager'||role==='representative'||role==='organisationrep'){
    processedFilter(); //only do past processing if you are an organizer
        }

}

document.getElementById('dateFilterResetBtn').addEventListener('click',function () {
    document.getElementById('start_date').value = '';
    document.getElementById('end_date').value = '';
    const role = document.getElementById('userrole').dataset.role;
    document.querySelectorAll('.activityCard').forEach(card=>{
        card.setAttribute('data-date-visible', 'true');
        if(role==='manager'||role==='representative'||role==='organisationrep'){
        if (!card.closest('#past-grid')) {
            card.style.display = 'block'; // restore ongoing/future(nonpast and send non past to processedevent filter)
            }
        }
        else {//for volunteer handle all cards here
            card.style.display = 'block';
        }
    });
     if(role==='manager'||role==='representative'||role==='organisationrep'){
    processedFilter(); //only do past processing if you are an organizer
        } // reapply processed filter after reset
});