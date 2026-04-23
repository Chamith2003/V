const leaves = document.querySelectorAll('.leaf');
        leaves.forEach((leaf, index) => {
            const duration = 3 + Math.random() * 2;
            leaf.style.animation = `float ${duration}s ease-in-out infinite`;
        });


        
        // Generate random stars
        // const starsContainer = document.getElementById('starsContainer');
        // const starCount = 50;

        // for (let i = 0; i < starCount; i++) {
        //     const star = document.createElement('div');
        //     star.className = 'star';
        //     star.style.left = Math.random() * 100 + '%';
        //     star.style.top = Math.random() * 100 + '%';
        //     star.style.animationDelay = Math.random() * 3 + 's';
        //     starsContainer.appendChild(star);
        // }

        // Floating leaves animation enhancement