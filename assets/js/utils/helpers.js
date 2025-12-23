/**
 * TD Classic - Helper Utilities
 * Common utility functions used across the theme
 */

(function() {
    'use strict';

    /**
     * Initialize data attributes (animation delays, wave bar heights, etc.)
     */
    function initDataAttributes() {
        // Set animation delays from data attributes
        document.querySelectorAll('[data-animation-delay]').forEach(function(el) {
            var delay = el.getAttribute('data-animation-delay');
            if (delay !== null && delay !== '') {
                el.style.setProperty('--animation-delay', delay + 's');
            }
        });

        // Set wave bar heights from data attributes
        document.querySelectorAll('.wave-bar[data-height]').forEach(function(el) {
            var height = el.getAttribute('data-height');
            if (height !== null && height !== '') {
                el.style.setProperty('--wave-height', height + '%');
            }
        });
    }

    /**
     * Sort functions for taxonomy pages
     */
    function sortProducts(sortBy) {
        var url = new URL(window.location.href);
        url.searchParams.set('sort', sortBy);
        window.location.href = url.toString();
    }

    function sortProjects(sortBy) {
        var url = new URL(window.location.href);
        url.searchParams.set('sort', sortBy);
        window.location.href = url.toString();
    }

    /**
     * News preview functions
     */
    function openNewsPreview(title, image, description, url) {
        // This function should be implemented in the news module
        // For now, just redirect to the news URL
        if (url) {
            window.location.href = url;
        }
    }

    function closeNewsPreview() {
        var preview = document.getElementById('news-preview-modal');
        if (preview) {
            preview.style.display = 'none';
        }
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDataAttributes);
    } else {
        initDataAttributes();
    }

    // Export to global scope
    window.TDClassicHelpers = {
        sortProducts: sortProducts,
        sortProjects: sortProjects,
        openNewsPreview: openNewsPreview,
        closeNewsPreview: closeNewsPreview
    };

    // Also expose as global functions for backward compatibility
    window.sortProducts = sortProducts;
    window.sortProjects = sortProjects;
    window.openNewsPreview = openNewsPreview;
    window.closeNewsPreview = closeNewsPreview;
})();

