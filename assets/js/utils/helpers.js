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
     * Share functions
     */
    function shareOnFacebook() {
        var url = encodeURIComponent(window.location.href);
        var title = encodeURIComponent(document.title);
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + url + '&t=' + title, 'facebook', 'width=600,height=400');
    }

    function shareOnTwitter() {
        var url = encodeURIComponent(window.location.href);
        var text = encodeURIComponent(document.title);
        window.open('https://twitter.com/intent/tweet?url=' + url + '&text=' + text, 'twitter', 'width=600,height=400');
    }

    function shareOnLinkedIn() {
        var url = encodeURIComponent(window.location.href);
        window.open('https://www.linkedin.com/sharing/share-offsite/?url=' + url, 'linkedin', 'width=600,height=400');
    }

    function copyLink() {
        var url = window.location.href;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(url).then(function() {
                alert('Đã sao chép link vào clipboard!');
            });
        } else {
            // Fallback for older browsers
            var textArea = document.createElement('textarea');
            textArea.value = url;
            textArea.style.position = 'fixed';
            textArea.style.opacity = '0';
            document.body.appendChild(textArea);
            textArea.select();
            try {
                document.execCommand('copy');
                alert('Đã sao chép link vào clipboard!');
            } catch (err) {
                alert('Không thể sao chép link. Vui lòng sao chép thủ công.');
            }
            document.body.removeChild(textArea);
        }
    }

    function shareArticle(title, url) {
        if (navigator.share) {
            navigator.share({
                title: title,
                url: url
            }).catch(function(err) {
                console.log('Error sharing:', err);
            });
        } else {
            // Fallback: copy to clipboard
            copyLink();
        }
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
        shareOnFacebook: shareOnFacebook,
        shareOnTwitter: shareOnTwitter,
        shareOnLinkedIn: shareOnLinkedIn,
        copyLink: copyLink,
        shareArticle: shareArticle,
        sortProducts: sortProducts,
        sortProjects: sortProjects,
        openNewsPreview: openNewsPreview,
        closeNewsPreview: closeNewsPreview
    };

    // Also expose as global functions for backward compatibility
    window.shareOnFacebook = shareOnFacebook;
    window.shareOnTwitter = shareOnTwitter;
    window.shareOnLinkedIn = shareOnLinkedIn;
    window.copyLink = copyLink;
    window.shareArticle = shareArticle;
    window.sortProducts = sortProducts;
    window.sortProjects = sortProjects;
    window.openNewsPreview = openNewsPreview;
    window.closeNewsPreview = closeNewsPreview;
})();

