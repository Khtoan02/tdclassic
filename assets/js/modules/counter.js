/**
 * TD Classic - Counter Animation Module
 * Animated counter for statistics and numbers
 */

(function() {
    'use strict';

    /**
     * Animate counter from 0 to target value
     * @param {HTMLElement} element - Element to animate
     * @param {number} target - Target number
     * @param {number} duration - Animation duration in ms
     */
    function animateCounter(element, target, duration = 2000) {
        const increment = target / (duration / 16); // 60fps
        let current = 0;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current) + (element.dataset.suffix || '');
        }, 16);
    }

    /**
     * Initialize counter animations
     * @param {string} selector - Selector for counter elements
     */
    function initCounters(selector = '.stat-number') {
        const statNumbers = document.querySelectorAll(selector + '[data-count]');

        if (statNumbers.length === 0) {
            return;
        }

        // Intersection Observer for stats animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = parseInt(entry.target.dataset.count);
                    const duration = parseInt(entry.target.dataset.duration) || 2000;
                    animateCounter(entry.target, target, duration);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        statNumbers.forEach(stat => {
            observer.observe(stat);
        });
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            initCounters();
        });
    } else {
        initCounters();
    }

    // Export to global scope
    window.TDClassicCounter = {
        init: initCounters,
        animate: animateCounter
    };
})();

