/* ============================================
   BOOK VIEWING PAGE SCRIPTS
   ============================================ */

// Filter bedspaces based on gender
function filterBedspaces() {
    const gender = document.getElementById('gender').value;
    const bedspaceSelect = document.getElementById('bedspace_id');
    const options = bedspaceSelect.querySelectorAll('option[data-gender]');
    
    bedspaceSelect.value = '';
    
    if (!gender) {
        options.forEach(option => {
            option.style.display = 'none';
        });
        bedspaceSelect.querySelector('option[value=""]').textContent = 'Please select your gender first';
        return;
    }
    
    let hasMatches = false;
    options.forEach(option => {
        if (option.dataset.gender === gender) {
            option.style.display = 'block';
            hasMatches = true;
        } else {
            option.style.display = 'none';
        }
    });
    
    if (hasMatches) {
        bedspaceSelect.querySelector('option[value=""]').textContent = 'Select a room';
    } else {
        bedspaceSelect.querySelector('option[value=""]').textContent = 'No rooms available for selected gender';
    }
}

// Handle form submission via AJAX
function handleFormSubmit(e) {
    e.preventDefault();
    
    const form = e.target;
    const submitBtn = form.querySelector('.submit-btn');
    const formData = new FormData(form);
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="loading-spinner"></span> Submitting...';
    
    // Clear previous errors
    clearErrors();
    
    // Send AJAX request
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Store success message in sessionStorage
            sessionStorage.setItem('bookingSuccess', data.message);
            
            // Redirect to available rooms
            window.location.href = data.redirect;
        } else {
            // Show validation errors
            if (data.errors) {
                showErrors(data.errors);
            } else {
                showErrorMessage(data.message || 'An error occurred');
            }
            
            // Reset button
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Submit Booking Request';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorMessage('Network error. Please try again.');
        
        // Reset button
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Submit Booking Request';
    });
}

// Show error message
function showErrorMessage(message) {
    const existingMsg = document.querySelector('.error-message');
    if (existingMsg) existingMsg.remove();
    
    const msgDiv = document.createElement('div');
    msgDiv.className = 'error-message';
    msgDiv.innerHTML = `
        <svg class="error-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        ${message}
    `;
    
    const formContainer = document.querySelector('.form-container');
    formContainer.insertBefore(msgDiv, formContainer.querySelector('.booking-form'));
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Show validation errors
function showErrors(errors) {
    for (const [field, messages] of Object.entries(errors)) {
        const input = document.querySelector(`[name="${field}"]`);
        if (input) {
            const formGroup = input.closest('.form-group');
            const errorSpan = document.createElement('span');
            errorSpan.className = 'error-text';
            errorSpan.textContent = messages[0];
            formGroup.appendChild(errorSpan);
            input.classList.add('error');
        }
    }
}

// Clear all errors
function clearErrors() {
    document.querySelectorAll('.error-text').forEach(el => el.remove());
    document.querySelectorAll('.error').forEach(el => el.classList.remove('error'));
    document.querySelectorAll('.error-message').forEach(el => el.remove());
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const genderSelect = document.getElementById('gender');
    if (genderSelect) {
        genderSelect.addEventListener('change', filterBedspaces);
        filterBedspaces();
    }
    
    // Set up AJAX form submission
    const bookingForm = document.querySelector('.booking-form');
    if (bookingForm) {
        bookingForm.addEventListener('submit', handleFormSubmit);
    }
});