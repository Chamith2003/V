/* <script> 
     // Get DOM elements
        const emailState = document.getElementById('email-state');
        const verificationState = document.getElementById('verification-state');
        const emailForm = document.getElementById('email-form');
        const verificationForm = document.getElementById('verification-form');
        const emailInput = document.getElementById('email');
        const sentEmailSpan = document.getElementById('sent-email');
        const codeInputs = document.querySelectorAll('.code-input');
        const backToEmailLink = document.getElementById('back-to-email');
        const resendCodeLink = document.getElementById('resend-code');

        // Handle email form submission
        emailForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = emailInput.value;
            
            if (email) {
                // Show verification state
                emailState.classList.add('hidden');
                verificationState.classList.remove('hidden');
                sentEmailSpan.textContent = email;
                
                // Focus first code input
                codeInputs[0].focus();
            }
        });

        

        // Handle code input navigation
        codeInputs.forEach((input, index) => {
            input.addEventListener('input', function(e) {
                const value = e.target.value;
                
                // Only allow numbers
                if (!/^\d$/.test(value)) {
                    e.target.value = '';
                    return;
                }
                
                // Move to next input
                if (value && index < codeInputs.length - 1) {
                    codeInputs[index + 1].focus();
                }
            });
            
            input.addEventListener('keydown', function(e) {
                // Handle backspace
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    codeInputs[index - 1].focus();
                }
            });
        });

        // Handle verification form submission
        verificationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const code = Array.from(codeInputs).map(input => input.value).join('');
            
            if (code.length === 6) {
                if (code === '123456') {
            window.location.href = '/V/View/userdash/resetpw/resetpw2.php';
             } else {
            alert('Invalid verification code. Please try again.');
            codeInputs.forEach(input => input.value = '');
            codeInputs[0].focus();
        }

                //alert('Verification code submitted: ' + code);

                // Here you would typically send the code to your server
            } else {
                alert('Please enter all 6 digits');
            }
        });

        // Handle back to email
        backToEmailLink.addEventListener('click', function(e) {
            e.preventDefault();
            verificationState.classList.add('hidden');
            emailState.classList.remove('hidden');
            
            // Clear code inputs
            codeInputs.forEach(input => input.value = '');
        });

        // Handle resend code
        resendCodeLink.addEventListener('click', function(e) {
            e.preventDefault();
            alert('Verification code resent to ' + sentEmailSpan.textContent);
            // Clear and focus first input
            codeInputs.forEach(input => input.value = '');
            codeInputs[0].focus();
        });
    

        //resetpw2

        // Handle Cancel button - go back to previous page
document.getElementById('cancelPasswordBtn').addEventListener('click', function() {
    window.history.back();
});

// Handle Update Password button - redirect to homepage
document.getElementById('updatePasswordBtn').addEventListener('click', function() {
    // Add your password validation logic here first
    // For example:
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmNewPassword').value;
    
    if (newPassword !== confirmPassword) {
        document.getElementById('passwordUpdateErrorMessage').style.display = 'block';
        return;
    }
    
    // If validation passes, redirect to homepage
    window.location.href = '/V/router.php?module=page&action=homepage';
});

</script> */
      
// C:\wamp64\www\V\View\userdash\resetpw\resetpw.js

// Get DOM elements
const emailState = document.getElementById('email-state');
const verificationState = document.getElementById('verification-state');
const emailForm = document.getElementById('email-form');
const verificationForm = document.getElementById('verification-form');
const emailInput = document.getElementById('email');
const sentEmailSpan = document.getElementById('sent-email');
const codeInputs = document.querySelectorAll('.code-input');
const backToEmailLink = document.getElementById('back-to-email');
const resendCodeLink = document.getElementById('resend-code');

// Convenience: backend URL builder
function pwUrl(action) {
    return '/V/router.php?module=pwreset&action=' + action;
}

// send email form
emailForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    const email = emailInput.value.trim();
    if (!email) return alert('Enter your email');

    try {
        const res = await fetch(pwUrl('sendcode'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email })
        });
        const data = await res.json();
        if (res.ok && data.success) {
            emailState.classList.add('hidden');
            verificationState.classList.remove('hidden');
            sentEmailSpan.textContent = email;
            codeInputs.forEach(i => i.value = '');
            codeInputs[0].focus();
            alert('Verification code sent to your email.');
        } else {
            alert(data.message || 'Failed to send code');
        }
    } catch (err) {
        console.error(err);
        alert('Network error.');
    }
});

// handle code inputs navigation
codeInputs.forEach((input, index) => {
    input.addEventListener('input', function(e) {
        const value = e.target.value;
        if (!/^\d$/.test(value)) {
            e.target.value = '';
            return;
        }
        if (value && index < codeInputs.length - 1) {
            codeInputs[index + 1].focus();
        }
    });

    input.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && !e.target.value && index > 0) {
            codeInputs[index - 1].focus();
        }
    });
});

// verify code submit
verificationForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    const code = Array.from(codeInputs).map(i => i.value).join('');
    if (code.length !== 6) return alert('Please enter all 6 digits');

    try {
        const res = await fetch(pwUrl('verifycode'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ code })
        });
        const data = await res.json();
        if (res.ok && data.success) {
            // open change password page
            window.location.href = '/V/router.php?module=pwreset&action=showchange';
        } else {
            alert(data.message || 'Invalid code');
            codeInputs.forEach(i => i.value = '');
            codeInputs[0].focus();
        }
    } catch (err) {
        console.error(err);
        alert('Network error.');
    }
});

// resend
resendCodeLink.addEventListener('click', async function(e) {
    e.preventDefault();
    const email = sentEmailSpan.textContent || emailInput.value.trim();
    if (!email) return alert('Email not found');

    try {
        const res = await fetch(pwUrl('sendcode'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email })
        });
        const data = await res.json();
        if (res.ok && data.success) {
            alert('Verification code resent.');
            codeInputs.forEach(i => i.value = '');
            codeInputs[0].focus();
        } else {
            alert(data.message || 'Failed to resend');
        }
    } catch (err) {
        console.error(err);
        alert('Network error.');
    }
});

// back to email
backToEmailLink.addEventListener('click', function(e) {
    e.preventDefault();
    verificationState.classList.add('hidden');
    emailState.classList.remove('hidden');
    codeInputs.forEach(input => input.value = '');
});

// resetpw2 page logic (change password)
// For resetpw2.php we expect elements: newPassword, confirmNewPassword, updatePasswordBtn, cancelPasswordBtn, passwordUpdateErrorMessage
const updateBtn = document.getElementById('updatePasswordBtn');
if (updateBtn) {
    updateBtn.addEventListener('click', async function() {
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmNewPassword').value;
        const errorEl = document.getElementById('passwordUpdateErrorMessage');
        if (errorEl) errorEl.style.display = 'none';

        if (!newPassword || newPassword.length < 8) {
            if (errorEl) errorEl.textContent = 'Password must be at least 8 characters';
            if (errorEl) errorEl.style.display = 'block';
            return;
        }
        if (newPassword !== confirmPassword) {
            if (errorEl) errorEl.textContent = 'Passwords do not match';
            if (errorEl) errorEl.style.display = 'block';
            return;
        }

        try {
            const res = await fetch(pwUrl('updatepassword'), {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ newPassword })
            });
            const data = await res.json();
            if (res.ok && data.success) {
                alert('Password updated. You can now log in.');
                window.location.href = '/V/router.php?module=page&action=homepage';
            } else {
                if (errorEl) errorEl.textContent = data.message || 'Failed to update password';
                if (errorEl) errorEl.style.display = 'block';
            }
        } catch (err) {
            console.error(err);
            alert('Network error.');
        }
    });

    const cancelBtn = document.getElementById('cancelPasswordBtn');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            window.history.back();
        });
    }
}
