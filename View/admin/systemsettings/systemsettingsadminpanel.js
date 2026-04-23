// Global variables
let currentHighlight = null;
let allHighlights = [];

// Load highlights on page load
document.addEventListener('DOMContentLoaded', function() {
    loadHighlights();
});

// Load all highlights using AJAX
async function loadHighlights() {
    try {
        const response = await fetch('/V/router.php?module=admin&action=getallhighlights');
        const data = await response.json();

        if (data.success) {
            allHighlights = data.highlights;
            renderHighlights(data.highlights);
        } else {
            showMessage(data.message || 'Failed to load highlights');
        }
    } catch (error) {
        console.error('Error loading highlights:', error);
        showMessage('Failed to load highlights');
    }
}

// Render highlights to the list
function renderHighlights(highlights) {
    const highlightsList = document.getElementById('highlightsList');
    
    if (!highlights || highlights.length === 0) {
        highlightsList.innerHTML = '<p style="color: #666; text-align: center; padding: 20px;">No highlights found.</p>';
        return;
    }

    highlightsList.innerHTML = highlights.map(highlight => `
        <div class="highlightCard" data-id="${highlight.id}">
            <div class="highlightCardContent">
                <div class="highlightImage">
                    ${highlight.media_url ? 
                        `<img src="${highlight.media_url}" alt="${highlight.title}">` : 
                        '<div class="noImage">No Image</div>'}
                </div>
                <div class="highlightInfo">
                    <h4 class="highlightTitle">${highlight.title}</h4>
                    <p class="highlightDescription">${highlight.description || 'No description'}</p>
                    <div class="highlightMeta">
                        <span class="highlightOrder">Order: ${highlight.display_order}</span>
                        <span class="highlightStatus ${highlight.status === 'active' ? 'statusActive' : 'statusInactive'}">
                            ${highlight.status}
                        </span>
                    </div>
                </div>
                <div class="highlightActions">
                    <button class="editBtn" onclick="openEditHighlightModal(${highlight.id})"
                    title="edit">
                        <span><img src="/V/View/resources/edit.png"></span>
                    </button>
                    <button class="deleteBtn" onclick="confirmHighlight${highlight.status === 'active' ? 'Deactivation':'Activation'}(${highlight.id})"
                    title="${highlight.status === 'active' ? 'archive' : 'unarchive'}">
                        <span><img src="/V/View/resources/${highlight.status === 'active' ? 'archive' : 'unarchive'}.png"></span>
                    </button>
                </div>
            </div>
        </div>
    `).join('');
}

// Open modal for adding new highlight
function openAddHighlightModal() {
    //start a clean fresh modal
    currentHighlight = null;
    document.getElementById('highlightModalTitle').textContent = 'Add New Highlight';
    document.getElementById('highlightForm').reset();
    document.getElementById('highlightId').value = '';
    document.getElementById('highlightOverlay').classList.add('active');
}

// Open modal for editing existing highlight
async function openEditHighlightModal(highlightId) {
    try {
        const formData = new FormData();
        formData.append('highlightId',highlightId );//key-value
        const response = await fetch('/V/router.php?module=admin&action=gethighlightdetails', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();

        if (!data.success) {
            showMessage(data.message);
            return;
        }

        //get the highlight assoc index of data return
        const highlight = data.highlight;
        currentHighlight = highlight;

        // Populate form fields
        document.getElementById('highlightModalTitle').textContent = 'Edit Highlight';
        document.getElementById('highlightId').value = highlight.id;
        document.getElementById('highlightTitle').value = highlight.title;
        document.getElementById('highlightDesc').value = highlight.description || '';
        document.getElementById('highlightOrder').value = highlight.display_order;
        document.getElementById('highlightStatus').value = highlight.status;

        // Show modal
        document.getElementById('highlightOverlay').classList.add('active');

    } catch (error) {
        console.error('Error fetching highlight details:', error);
        showMessage('Failed to load highlight details');
    }
}

// Close highlight modal
function closeHighlightModal() {
    document.getElementById('highlightOverlay').classList.remove('active');
    document.getElementById('highlightForm').reset();//clear the form as well
    currentHighlight = null;
}

// Handle form submission
document.getElementById('highlightForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    await saveHighlight();
});

// Save highlight (add or update)
async function saveHighlight() {
    try {
        const formData = new FormData();
        const highlightId = document.getElementById('highlightId').value;//previously fetched from database when fetching all highlights
        
        formData.append('title', document.getElementById('highlightTitle').value);
        formData.append('description', document.getElementById('highlightDesc').value);
        formData.append('display_order', document.getElementById('highlightOrder').value);
        formData.append('status', document.getElementById('highlightStatus').value);
        
        // Add image if selected
        const imageFile = document.getElementById('highlightMedia').files[0];
        if (imageFile) {
            formData.append('image', imageFile);
        }

        // Determine action based on whether we're editing or adding
        const action = highlightId ? 'updatehighlight' : 'createhighlight';//if highlightId exists then we are editing already fetched one from DB
        if (highlightId) {
            formData.append('highlightId', highlightId);//updating an existing one so send its index
        }

        const response = await fetch(`/V/router.php?module=admin&action=${action}`, {//branch into 2 branches like updating and creating
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showMessage(data.message);
            closeHighlightModal();
            loadHighlights(); // Refresh the list
        } else {
            showMessage(data.message);
        }
    } catch (error) {
        console.error('Error saving highlight:', error);
        showMessage('Failed to save highlight');
    }
}

// Confirm highlight deactivation
function confirmHighlightDeactivation(highlightId) {
    const highlight = allHighlights.find(h => h.id === highlightId);
    const title = highlight ? highlight.title : 'this highlight';
    
    if (confirm(`Are you sure you want to remove "${title}" from the homepage?`)) {
        deactivateHighlight(highlightId);
    }
}

// Deactivate highlight
async function deactivateHighlight(highlightId) {
    try {
        const formData = new FormData();
        formData.append('highlightId', highlightId);

        const response = await fetch('/V/router.php?module=admin&action=deactivatehighlight', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showMessage(data.message);
            loadHighlights(); // Refresh the list
        } else {
            showMessage(data.message);
        }
    } catch (error) {
        console.error('Error deactivating highlight:', error);
        showMessage('Failed to deactivate highlight');
    }
}




// Confirm highlight activation
function confirmHighlightActivation(highlightId) {
    const highlight = allHighlights.find(h => h.id === highlightId);
    const title = highlight ? highlight.title : 'this highlight';
    
    if (confirm(`Are you sure you want to add "${title}" to the homepage?`)) {
        activateHighlight(highlightId);
    }
}

// Activate highlight
async function activateHighlight(highlightId) {
    try {
        const formData = new FormData();
        formData.append('highlightId', highlightId);

        const response = await fetch('/V/router.php?module=admin&action=activatehighlight', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showMessage(data.message);
            loadHighlights(); // Refresh the list
        } else {
            showMessage(data.message);
        }
    } catch (error) {
        console.error('Error activating highlight:', error);
        showMessage('Failed to activate highlight');
    }
}

















// Show message function 
function showMessage(message) {
    alert(message);
    
}

// Close modal when clicking outside
document.getElementById('highlightOverlay')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeHighlightModal();
    }
});