/**
 * TD Classic - Carousel Module
 * Reusable carousel functionality for products, news, etc.
 */

(function() {
    'use strict';

    /**
     * Initialize a carousel
     * @param {Object} options - Carousel configuration
     */
    function initCarousel(options) {
        const {
            carouselId,
            prevBtnId,
            nextBtnId,
            dotsContainerId,
            slideSelector = '.product-slide',
            slidesPerViewConfig = {
                mobile: 1,
                tablet: 1,
                desktop: 2,
                large: 3
            },
            autoPlayInterval = 5000,
            gap = 30
        } = options;

        const carousel = document.getElementById(carouselId);
        const prevBtn = document.getElementById(prevBtnId);
        const nextBtn = document.getElementById(nextBtnId);
        const dotsContainer = document.getElementById(dotsContainerId);

        if (!carousel || !prevBtn || !nextBtn || !dotsContainer) {
            return;
        }

        const slides = carousel.querySelectorAll(slideSelector);
        if (slides.length === 0) {
            return;
        }

        const slideWidth = slides[0].offsetWidth + gap;
        let currentSlide = 0;
        const maxSlides = slides.length;
        let autoPlayTimer = null;

        /**
         * Get number of slides per view based on screen size
         */
        function getSlidesPerView() {
            if (window.innerWidth <= 480) return slidesPerViewConfig.mobile || 1;
            if (window.innerWidth <= 768) return slidesPerViewConfig.tablet || 1;
            if (window.innerWidth <= 1024) return slidesPerViewConfig.desktop || 2;
            return slidesPerViewConfig.large || 3;
        }

        /**
         * Update carousel position and controls
         */
        function updateCarousel() {
            const slidesPerView = getSlidesPerView();
            const maxSlidesToShow = maxSlides - slidesPerView + 1;
            const translateX = -currentSlide * slideWidth;

            carousel.style.transform = `translateX(${translateX}px)`;

            // Update dots
            const dots = dotsContainer.querySelectorAll('.carousel-dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === Math.floor(currentSlide / slidesPerView));
            });

            // Update buttons
            prevBtn.disabled = currentSlide === 0;
            nextBtn.disabled = currentSlide >= maxSlidesToShow;
        }

        /**
         * Go to specific slide
         */
        function goToSlide(slideIndex) {
            const slidesPerView = getSlidesPerView();
            currentSlide = slideIndex * slidesPerView;
            updateCarousel();
        }

        /**
         * Go to next slide
         */
        function nextSlide() {
            const slidesPerView = getSlidesPerView();
            const maxSlidesToShow = maxSlides - slidesPerView + 1;
            if (currentSlide < maxSlidesToShow) {
                currentSlide++;
                updateCarousel();
            }
        }

        /**
         * Go to previous slide
         */
        function prevSlide() {
            if (currentSlide > 0) {
                currentSlide--;
                updateCarousel();
            }
        }

        /**
         * Start auto-play
         */
        function startAutoPlay() {
            if (autoPlayInterval <= 0) return;
            
            autoPlayTimer = setInterval(() => {
                const slidesPerView = getSlidesPerView();
                const maxSlidesToShow = maxSlides - slidesPerView + 1;
                
                if (currentSlide >= maxSlidesToShow) {
                    currentSlide = 0;
                } else {
                    currentSlide++;
                }
                updateCarousel();
            }, autoPlayInterval);
        }

        /**
         * Stop auto-play
         */
        function stopAutoPlay() {
            if (autoPlayTimer) {
                clearInterval(autoPlayTimer);
                autoPlayTimer = null;
            }
        }

        // Create dots
        const slidesPerView = getSlidesPerView();
        const totalDots = Math.ceil(maxSlides / slidesPerView);
        dotsContainer.innerHTML = '';
        for (let i = 0; i < totalDots; i++) {
            const dot = document.createElement('div');
            dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
            dot.addEventListener('click', () => goToSlide(i));
            dotsContainer.appendChild(dot);
        }

        // Event listeners
        prevBtn.addEventListener('click', prevSlide);
        nextBtn.addEventListener('click', nextSlide);

        // Keyboard navigation
        const handleKeydown = (e) => {
            if (e.key === 'ArrowLeft') {
                prevSlide();
            } else if (e.key === 'ArrowRight') {
                nextSlide();
            }
        };
        document.addEventListener('keydown', handleKeydown);

        // Touch/swipe support for mobile
        let startX = 0;
        let endX = 0;

        carousel.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });

        carousel.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            const diff = startX - endX;

            if (Math.abs(diff) > 50) { // Minimum swipe distance
                if (diff > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
        });

        // Auto-play functionality
        if (autoPlayInterval > 0) {
            startAutoPlay();
            carousel.addEventListener('mouseenter', stopAutoPlay);
            carousel.addEventListener('mouseleave', startAutoPlay);
        }

        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                currentSlide = 0;
                const slidesPerView = getSlidesPerView();
                const totalDots = Math.ceil(maxSlides / slidesPerView);
                dotsContainer.innerHTML = '';
                for (let i = 0; i < totalDots; i++) {
                    const dot = document.createElement('div');
                    dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
                    dot.addEventListener('click', () => goToSlide(i));
                    dotsContainer.appendChild(dot);
                }
                updateCarousel();
            }, 250);
        });

        // Initialize carousel
        updateCarousel();
    }

    // Export to global scope
    window.TDClassicCarousel = {
        init: initCarousel
    };
})();

