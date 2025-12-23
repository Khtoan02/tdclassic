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
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFrontPage);
    } else {
        initFrontPage();
    }
})();

