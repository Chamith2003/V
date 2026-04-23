
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('selectionForm');
    const checkboxes = document.querySelectorAll('.rep-checkbox');
    const selectedCountElement = document.getElementById('selectedCount');
    const submitBtn = document.getElementById('submitBtn');
    
    const MAX_SELECTIONS = parseInt(form ? form.getAttribute('data-needed-count') : 2);

    function updateSelectionState() {
        const selectedCheckboxes = document.querySelectorAll('.rep-checkbox:checked');
        const selectedCount = selectedCheckboxes.length;
        
        if (selectedCountElement) {
            selectedCountElement.textContent = selectedCount;
        }
        
        if (submitBtn) {
            if (selectedCount === MAX_SELECTIONS) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }
        
        checkboxes.forEach(function(checkbox) {
            if (!checkbox.checked && selectedCount >= MAX_SELECTIONS) {
                checkbox.disabled = true;
                checkbox.parentElement.querySelector('.rep-card-content').style.opacity = '0.5';
                checkbox.parentElement.querySelector('.rep-card-content').style.cursor = 'not-allowed';
            } else if (!checkbox.checked) {
                checkbox.disabled = false;
                checkbox.parentElement.querySelector('.rep-card-content').style.opacity = '1';
                checkbox.parentElement.querySelector('.rep-card-content').style.cursor = 'pointer';
            }
        });
    }
    
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', updateSelectionState);
    });
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const selectedCheckboxes = document.querySelectorAll('.rep-checkbox:checked');
            const selectedCount = selectedCheckboxes.length;
            
            if (selectedCount !== MAX_SELECTIONS) {
                e.preventDefault();
                alert('Please select exactly ' + MAX_SELECTIONS + ' representative(s).');
                return false;
            }
            
            const confirmed = confirm('Are you sure you want to appoint ' + (MAX_SELECTIONS === 1 ? 'this representative' : 'these ' + MAX_SELECTIONS + ' representatives') + ' as Organization Representative(s) for 12 months?');
            if (!confirmed) {
                e.preventDefault();
                return false;
            }
            
            return true;
        });
    }
    
    updateSelectionState();
});
