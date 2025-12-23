/**
 * TD Classic - Admin Email Test
 * Handles email test functionality in admin panel
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        $('#test_email').on('click', function() {
            var button = $(this);
            var originalText = button.text();
            
            button.text('Đang gửi...').prop('disabled', true);
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'tdclassic_test_email',
                    nonce: (typeof tdclassicEmailTest !== 'undefined' && tdclassicEmailTest.nonce) ? tdclassicEmailTest.nonce : ''
                },
                success: function(response) {
                    var resultHtml = '';
                    if (response.success) {
                        resultHtml = '<div class="notice notice-success"><p>' + response.data + '</p></div>';
                    } else {
                        resultHtml = '<div class="notice notice-error"><p>' + response.data + '</p></div>';
                    }
                    $('#test_email_result').html(resultHtml).show();
                },
                error: function() {
                    $('#test_email_result').html('<div class="notice notice-error"><p>Có lỗi xảy ra khi gửi email test.</p></div>').show();
                },
                complete: function() {
                    button.text(originalText).prop('disabled', false);
                }
            });
        });
    });
})(jQuery);

