<?php
$role = $_SESSION['role'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V</title>
    
    <!-- <link rel="stylesheet" href="View/projects/eventForm/createeventsuccess/createeventsuccess.css"> -->
    <link rel="stylesheet" type="text/css" href="/V/View/projects/eventForm/createeventsuccess/createeventsuccess.css">
</head>
<body>
    <div class="success-container">
        <!-- <div class="floating-particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div> -->
        
        <div class="success-icon">
            <div class="checkmark">✓</div>
        </div>
        
        <h1 class="success-title">Event Created Successfully!</h1>
        
        <?php if ($role === 'representative'): ?>
        <p class="success-message">
            <!-- Your environmental impact event has been successfully created and is now live. 
            Community members can start registering right away. -->
            Your environmental impact event has been successfully created!
            It is currently being reviewed and will appear in the project section once approved by a manager. Community members will be able to register shortly.
        </p>
        <?php endif; ?>
        <?php if ($role === 'manager'): ?>
        <p class="success-message">
            Your environmental impact event has been successfully created and is now live. 
            Community members can start registering right away.
            <!-- Your environmental impact event has been successfully created!
            It is currently being reviewed and will appear in the project section once approved by a manager. Community members will be able to register shortly. -->
        </p>
        <?php endif; ?>

        <div class="action-buttons">
            <!-- <button class="btn btn-primary" onclick="window.location.href='../../../V/router.php?module=projects&action=events'">Go to events</button> -->
                    <button class="btn btn-primary" onclick="window.location.href='../../../V/router.php?module=projects&action=events'">Go to events</button>
                            <!-- <a href="/V/router.php?module=projects&action=events">Manage Users</a> -->
        </div>
    </div>

    <!-- <script>
        function viewEvent() {
            // Simulate navigation to event page
            document.body.style.opacity = '0.7';
            setTimeout(() => {
                alert('Redirecting to event details page...');
                document.body.style.opacity = '1';
            }, 300);
        }

        function createAnother() {
            // Simulate going back to create form
            document.body.style.opacity = '0.7';
            setTimeout(() => {
                alert('Opening new event creation form...');
                document.body.style.opacity = '1';
            }, 300);
        }

        // Add some interactive sparkle effects
        document.addEventListener('mousemove', (e) => {
            if (Math.random() < 0.1) {
                createSparkle(e.clientX, e.clientY);
            }
        });

        function createSparkle(x, y) {
            const sparkle = document.createElement('div');
            sparkle.style.position = 'fixed';
            sparkle.style.left = x + 'px';
            sparkle.style.top = y + 'px';
            sparkle.style.width = '4px';
            sparkle.style.height = '4px';
            sparkle.style.background = '#3b82f6';
            sparkle.style.borderRadius = '50%';
            sparkle.style.pointerEvents = 'none';
            sparkle.style.zIndex = '1000';
            sparkle.style.animation = 'sparkle 1s ease-out forwards';
            
            document.body.appendChild(sparkle);
            
            setTimeout(() => {
                sparkle.remove();
            }, 1000);
        }

        // Add sparkle animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes sparkle {
                0% {
                    opacity: 1;
                    transform: scale(0) rotate(0deg);
                }
                50% {
                    opacity: 1;
                    transform: scale(1) rotate(180deg);
                }
                100% {
                    opacity: 0;
                    transform: scale(0) rotate(360deg);
                }
            }
        `;
        document.head.appendChild(style);
    </script> -->
</body>
</html>