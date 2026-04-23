
        document.getElementById('contactForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const form = document.getElementById('contactForm');
            const messageDiv = document.getElementById('contactMessage');
            const submitBtn = document.getElementById('submitContactBtn');
            
            const formData = new FormData(form);
            
            try {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Sending...';
                
                const response = await fetch('/V/router.php?module=contact&action=send', {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                });
                
                const responseText = await response.text();
                
                try {
                    const data = JSON.parse(responseText);
                    
                    messageDiv.style.display = 'block';
                    
                    if (data.success) {
                        messageDiv.style.backgroundColor = '#d4edda';
                        messageDiv.style.color = '#155724';
                        messageDiv.style.border = '1px solid #c3e6cb';
                        messageDiv.textContent = '✓ ' + data.message;
                        form.reset();
                        
                        setTimeout(() => {
                            messageDiv.style.display = 'none';
                        }, 3000);
                    } else {
                        messageDiv.style.backgroundColor = '#fdecea';
                        messageDiv.style.color = '#721c24';
                        messageDiv.style.border = '1px solid #f5c6cb';
                        messageDiv.textContent = '✗ ' + data.message;
                    }
                } catch (parseError) {
                    console.error('Failed to parse response:', responseText);
                    messageDiv.style.display = 'block';
                    messageDiv.style.backgroundColor = '#fdecea';
                    messageDiv.style.color = '#721c24';
                    messageDiv.style.border = '1px solid #f5c6cb';
                    messageDiv.textContent = '✗ Server error: ' + responseText;
                }
                
            } catch (error) {
                console.error('Error:', error);
                messageDiv.style.display = 'block';
                messageDiv.style.backgroundColor = '#fdecea';
                messageDiv.style.color = '#721c24';
                messageDiv.style.border = '1px solid #f5c6cb';
                messageDiv.textContent = '✗ An error occurred while sending your message';
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Send Message';
            }
        });
