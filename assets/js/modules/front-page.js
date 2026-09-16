/**
 * TD Classic - Front Page Module
 * Front page specific functionality
 */

(function() {
    'use strict';

    /**
     * Initialize front page features
     */
    function initFrontPage() {
        // Set hero background image from data attribute
        const heroBgImage = document.querySelector('.hero-background-image[data-bg-image]');
        if (heroBgImage) {
            const bgImageUrl = heroBgImage.getAttribute('data-bg-image');
            if (bgImageUrl) {
                heroBgImage.style.setProperty('--hero-bg-image', `url('${bgImageUrl}')`);
                heroBgImage.style.backgroundImage = `url('${bgImageUrl}')`;
            }
        }

        // Initialize counter animations
        if (window.TDClassicCounter) {
            window.TDClassicCounter.init('.stat-number');
        }

        // Initialize carousels
        if (window.TDClassicCarousel) {
            // Products Carousel
            window.TDClassicCarousel.init({
                carouselId: 'products-carousel',
                prevBtnId: 'carousel-prev',
                nextBtnId: 'carousel-next',
                dotsContainerId: 'carousel-dots',
                slideSelector: '.product-slide',
                slidesPerViewConfig: {
                    mobile: 1,
                    tablet: 1,
                    desktop: 2,
                    large: 3
                },
                autoPlayInterval: 5000
            });

            // News Carousel
            window.TDClassicCarousel.init({
                carouselId: 'news-carousel',
                prevBtnId: 'news-carousel-prev',
                nextBtnId: 'news-carousel-next',
                dotsContainerId: 'news-carousel-dots',
                slideSelector: '.news-slide',
                slidesPerViewConfig: {
                    mobile: 1,
                    tablet: 1,
                    desktop: 2,
                    large: 3
                },
                autoPlayInterval: 5000
            });

            // Speaker Carousel
            window.TDClassicCarousel.init({
                carouselId: 'speaker-carousel',
                prevBtnId: 'speaker-carousel-prev',
                nextBtnId: 'speaker-carousel-next',
                dotsContainerId: 'speaker-carousel-dots',
                slideSelector: '.product-slide',
                slidesPerViewConfig: {
                    mobile: 1,
                    tablet: 1,
                    desktop: 2,
                    large: 3
                },
                autoPlayInterval: 5000
            });

            // Amplifier Carousel
            window.TDClassicCarousel.init({
                carouselId: 'amplifier-carousel',
                prevBtnId: 'amplifier-carousel-prev',
                nextBtnId: 'amplifier-carousel-next',
                dotsContainerId: 'amplifier-carousel-dots',
                slideSelector: '.product-slide',
                slidesPerViewConfig: {
                    mobile: 1,
                    tablet: 1,
                    desktop: 2,
                    large: 3
                },
                autoPlayInterval: 5000
            });
        }

        // Brand info hover effect
        const brandInfo = document.querySelector('.about-brand-info');
        if (brandInfo) {
            brandInfo.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(0)';
            });
            
            brandInfo.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(100%)';
            });
        }

        // Hero Cinematic Slider
        const slides = document.querySelectorAll('.hero-slide');
        if (slides.length > 0) {
            let currentSlide = 0;
            const totalSlides = slides.length;
            let slideInterval = null;

            function showSlide(index) {
                if (index >= totalSlides) currentSlide = 0;
                else if (index < 0) currentSlide = totalSlides - 1;
                else currentSlide = index;

                slides.forEach((slide, i) => {
                    slide.classList.toggle('active', i === currentSlide);
                });
            }

            function nextSlide() {
                showSlide(currentSlide + 1);
            }

            function prevSlide() {
                showSlide(currentSlide - 1);
            }

            function startAutoPlay() {
                clearInterval(slideInterval);
                slideInterval = setInterval(nextSlide, 5000);
            }

            // Bind navigation buttons
            const nextBtn = document.getElementById('hero-next-btn');
            const prevBtn = document.getElementById('hero-prev-btn');

            if (nextBtn) {
                nextBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    nextSlide();
                    startAutoPlay();
                });
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    prevSlide();
                    startAutoPlay();
                });
            }

            // Expose globally for backward compatibility
            window.nextSlide = function() {
                nextSlide();
                startAutoPlay();
            };
            window.prevSlide = function() {
                prevSlide();
                startAutoPlay();
            };

            startAutoPlay();
        }
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFrontPage);
    } else {
        initFrontPage();
    }
})();

