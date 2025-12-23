/**
 * TD Classic - Admin Consultation Manager
 * Handles consultation deletion confirmation
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        // Handle delete confirmation
        $('[data-confirm-delete]').on('click', function(e) {
            var confirmMessage = $(this).data('confirm-delete') || 'Bạn có chắc chắn muốn xóa?';
            if (!confirm(confirmMessage)) {
                e.preventDefault();
                return false;
            }
        });
    });
})(jQuery);

