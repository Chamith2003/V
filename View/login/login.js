
        function closeModal() {
            document.body.style.display = 'none';
        }

        function switchTab(event, tabType) {
            // Handle signup link click
            if (tabType === 'signup') {
                alert('Redirect to Sign Up page (This is just a demo)');
                return;
            }
        }

        // Form submission
        document.getElementById('signinForm').addEventListener('submit', function (e) {
            // e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            if (!email || !password) {
                e.preventDefault();
                alert('Please fill in all fields');
                return;
            }
            //     const remember = document.getElementById('remember').checked;

            //     // Simulate sign in process
            //     const submitBtn = document.querySelector('.btn-primary');
            //     const originalText = submitBtn.textContent;

            //     submitBtn.textContent = 'Signing in...';
            //     submitBtn.disabled = true;

            //     setTimeout(() => {
            //         alert('Sign in successful! (This is just a demo)');
            //         submitBtn.textContent = originalText;
            //         submitBtn.disabled = false;
            //     }, 1500);
            // });

            // // Add signup link functionality
            // document.querySelector('.signup-link-text').addEventListener('click', function(e) {
            //     // e.preventDefault();
            //     switchTab(null, 'signup');
            // });
            // document.querySelectorAll('input').forEach(input => {
            //     input.addEventListener('focus', function() {
            //         this.parentElement.style.transform = 'translateY(-2px)';
            //     });

            //     input.addEventListener('blur', function() {
            //         this.parentElement.style.transform = 'translateY(0)';
            //     });
        });
    