document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('highlightsTrack');
    const leftBtn = document.getElementById('scrollLeft');
    const rightBtn = document.getElementById('scrollRight');
    const container = document.getElementById('highlightsContainer');
    
    if (!track || !leftBtn || !rightBtn) {
        console.error('Carousel elements not found');
        return;
    }

    const cards = Array.from(document.querySelectorAll('.highlightCard:not(.clone)'));
    const cardWidth = 370; // 350px card + 20px gap
    const totalCards = cards.length;
    let currentIndex = totalCards; // Start at first real card (after left buffer)
    let isAnimating = false;

    // Initial setup - clone all cards on both sides to create seamless loop
    function setupInfiniteScroll() {
        // Remove existing clones
        const existingClones = track.querySelectorAll('.clone');
        existingClones.forEach(clone => clone.remove());

        // Prepend clones to the beginning (for left scrolling)
        for (let i = cards.length - 1; i >= 0; i--) {
            const clone = cards[i].cloneNode(true);
            clone.classList.add('clone');
            track.insertBefore(clone, track.firstChild);
        }

        // Append clones to the end (for right scrolling)
        cards.forEach(card => {
            const clone = card.cloneNode(true);
            clone.classList.add('clone');
            track.appendChild(clone);
        });

        // Set initial position to first real card (after left buffer)
        currentIndex = totalCards;
        track.style.transition = 'none';
        track.style.transform = `translateX(${-currentIndex * cardWidth}px)`;
        void track.offsetWidth;
    }

    // Smooth scrolling function with immediate repositioning
    function scrollTo(direction) {
        if (isAnimating) return;
        
        isAnimating = true;
        track.style.transition = 'transform 0.5s ease-in-out';
        
        if (direction === 'right') {
            currentIndex++;
        } else {
            currentIndex--;
        }
        
        track.style.transform = `translateX(${-currentIndex * cardWidth}px)`;
        
        // Reset position immediately after animation completes
        setTimeout(() => {
            if (currentIndex >= totalCards * 2) {
                // Scrolled past right clones, jump back to real cards
                track.style.transition = 'none';
                currentIndex = totalCards;
                track.style.transform = `translateX(${-currentIndex * cardWidth}px)`;
            } else if (currentIndex < totalCards) {
                // Scrolled past left clones, jump to end of real cards
                track.style.transition = 'none';
                currentIndex = totalCards * 2 - 1;
                track.style.transform = `translateX(${-currentIndex * cardWidth}px)`;
            }
            
            setTimeout(() => {
                isAnimating = false;
            }, 50);
        }, 500);
    }

    // Event listeners
    rightBtn.addEventListener('click', () => scrollTo('right'));
    leftBtn.addEventListener('click', () => scrollTo('left'));

    // Auto-scroll functionality
    let autoScrollInterval;

    function startAutoScroll() {
        autoScrollInterval = setInterval(() => {
            scrollTo('right');
        }, 4000);
    }

    function stopAutoScroll() {
        clearInterval(autoScrollInterval);
    }

    // Touch/swipe support
    let startX = 0;
    let currentX = 0;
    let isDragging = false;

    track.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        isDragging = true;
        stopAutoScroll();
    });

    track.addEventListener('touchmove', (e) => {
        if (!isDragging) return;
        currentX = e.touches[0].clientX;
        e.preventDefault();
    });

    track.addEventListener('touchend', () => {
        if (!isDragging) return;
        isDragging = false;
        
        const diffX = startX - currentX;
        
        if (Math.abs(diffX) > 50) {
            if (diffX > 0) {
                scrollTo('right');
            } else {
                scrollTo('left');
            }
        }
        
        startAutoScroll();
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            scrollTo('left');
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            scrollTo('right');
        }
    });

    // Mouse hover to pause auto-scroll
    container.addEventListener('mouseenter', stopAutoScroll);
    container.addEventListener('mouseleave', startAutoScroll);

    // Initialize
    setupInfiniteScroll();
    startAutoScroll();
});