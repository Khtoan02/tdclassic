/**
 * TD Classic - Mega Menu Module
 * Handles mega menu tabs, panels, and slider functionality
 */

(function() {
    'use strict';

    // Initialize Mega Menu
    function initMegaMenu() {
        const tabs = document.querySelectorAll('.mm-tab-item');
        const panels = document.querySelectorAll('.mm-panel');

        if (!tabs.length || !panels.length) return;

        tabs.forEach(tab => {
            tab.addEventListener('mouseenter', () => {
                // Remove active class from all tabs
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                // Hide all panels
                panels.forEach(p => p.classList.remove('active'));

                // Show target panel
                const targetId = tab.getAttribute('data-target');
                const targetPanel = document.getElementById(targetId);
                if (targetPanel) {
                    targetPanel.classList.add('active');
                }
            });
        });
    }

    // Initialize Sliders
    function initSliders() {
        const sliderWrappers = document.querySelectorAll('.slider-wrapper');

        sliderWrappers.forEach(wrapper => {
            const container = wrapper.querySelector('.panel-slider-container');
            const prevBtn = wrapper.querySelector('.slider-btn.prev');
            const nextBtn = wrapper.querySelector('.slider-btn.next');

            if (!container || !prevBtn || !nextBtn) return;

            const scrollAmount = 220;

            // Previous button
            prevBtn.addEventListener('click', () => {
                container.scrollBy({ 
                    left: -scrollAmount, 
                    behavior: 'smooth' 
                });
            });

            // Next button
            nextBtn.addEventListener('click', () => {
                container.scrollBy({ 
                    left: scrollAmount, 
                    behavior: 'smooth' 
                });
            });

            // Drag to scroll
            let isDown = false;
            let startX;
            let scrollLeft;

            container.addEventListener('mousedown', (e) => {
                isDown = true;
                container.classList.add('active');
                startX = e.pageX - container.offsetLeft;
                scrollLeft = container.scrollLeft;
            });

            container.addEventListener('mouseleave', () => {
                isDown = false;
                container.classList.remove('active');
            });

            container.addEventListener('mouseup', () => {
                isDown = false;
                container.classList.remove('active');
            });

            container.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - container.offsetLeft;
                const walk = (x - startX) * 2;
                container.scrollLeft = scrollLeft - walk;
            });
        });
    }

    // Initialize Mobile Menu
    function initMobileMenu() {
        const mobMenuTrigger = document.getElementById('mob-menu-trigger');
        const closeMobMenu = document.getElementById('close-mob-menu');
        const mobMenuOverlay = document.getElementById('mobile-menu-overlay');

        if (!mobMenuTrigger || !closeMobMenu || !mobMenuOverlay) return;

        function openMobileMenu() {
            mobMenuOverlay.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileMenuFunc() {
            mobMenuOverlay.classList.remove('open');
            document.body.style.overflow = '';
        }

        mobMenuTrigger.addEventListener('click', openMobileMenu);
        closeMobMenu.addEventListener('click', closeMobileMenuFunc);
        mobMenuOverlay.addEventListener('click', (e) => {
            if (e.target === mobMenuOverlay) {
                closeMobileMenuFunc();
            }
        });
    }

    // Initialize Mobile Accordion
    function initMobileAccordion() {
        const accordionBtns = document.querySelectorAll('.mob-accordion-btn');

        accordionBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const content = this.nextElementSibling;
                const icon = this.querySelector('i');

                if (!content) return;

                content.classList.toggle('open');
                
                if (icon) {
                    if (content.classList.contains('open')) {
                        icon.style.transform = 'rotate(180deg)';
                    } else {
                        icon.style.transform = 'rotate(0deg)';
                    }
                }
            });
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initMegaMenu();
            initSliders();
            initMobileMenu();
            initMobileAccordion();
        });
    } else {
        initMegaMenu();
        initSliders();
        initMobileMenu();
        initMobileAccordion();
    }

})();

