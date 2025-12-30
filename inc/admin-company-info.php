<?php
/**
 * Admin Company Information Management
 * Quản lý thông tin doanh nghiệp cho TD Classic Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Company Info menu to WordPress admin
 */
function tdclassic_add_company_info_menu() {
    add_menu_page(
        'Thông tin Doanh nghiệp',           // Page title
        'Thông tin',                         // Menu title
        'manage_options',                    // Capability
        'tdclassic-company-info',           // Menu slug
        'tdclassic_company_info_page',      // Callback function
        'dashicons-building',                // Icon
        25                                   // Position
    );
}
add_action('admin_menu', 'tdclassic_add_company_info_menu');

/**
 * Register settings
 */
function tdclassic_register_company_info_settings() {
    // Tab 1: Thông tin doanh nghiệp
    register_setting('tdclassic_company_info_general', 'tdclassic_company_name');
    register_setting('tdclassic_company_info_general', 'tdclassic_company_description');
    register_setting('tdclassic_company_info_general', 'tdclassic_site_icon');
    register_setting('tdclassic_company_info_general', 'tdclassic_company_logo');
    register_setting('tdclassic_company_info_general', 'tdclassic_meta_description');
    register_setting('tdclassic_company_info_general', 'tdclassic_site_url');
    
    // Tab 2: Liên hệ doanh nghiệp
    register_setting('tdclassic_company_info_contact', 'tdclassic_company_phones');
    register_setting('tdclassic_company_info_contact', 'tdclassic_company_emails');
    register_setting('tdclassic_company_info_contact', 'tdclassic_company_addresses');
    
    // Tab 3: Hồ sơ năng lực
    register_setting('tdclassic_company_info_profile', 'tdclassic_company_profile_pdf');
}
add_action('admin_init', 'tdclassic_register_company_info_settings');

/**
 * Company Info Admin Page
 */
function tdclassic_company_info_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Get current tab
    $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';
    
    // Save settings
    if (isset($_POST['tdclassic_save_company_info'])) {
        check_admin_referer('tdclassic_company_info_nonce');
        
        if ($active_tab === 'general') {
            // Update WordPress native settings
            update_option('blogname', sanitize_text_field($_POST['tdclassic_company_name']));
            update_option('blogdescription', sanitize_text_field($_POST['tdclassic_company_description']));
            update_option('siteurl', esc_url_raw($_POST['tdclassic_site_url']));
            update_option('home', esc_url_raw($_POST['tdclassic_site_url']));
            
            // Custom settings
            update_option('tdclassic_meta_description', sanitize_textarea_field($_POST['tdclassic_meta_description']));
            update_option('tdclassic_company_logo', absint($_POST['tdclassic_company_logo']));
            update_option('tdclassic_site_icon', absint($_POST['tdclassic_site_icon']));
            
            // Sync với WordPress Customizer
            if (!empty($_POST['tdclassic_company_logo'])) {
                set_theme_mod('custom_logo', absint($_POST['tdclassic_company_logo']));
            }
            if (!empty($_POST['tdclassic_site_icon'])) {
                update_option('site_icon', absint($_POST['tdclassic_site_icon']));
            }
            
        } elseif ($active_tab === 'contact') {
            update_option('tdclassic_company_phones', sanitize_textarea_field($_POST['tdclassic_company_phones']));
            update_option('tdclassic_company_emails', sanitize_textarea_field($_POST['tdclassic_company_emails']));
            update_option('tdclassic_company_addresses', sanitize_textarea_field($_POST['tdclassic_company_addresses']));
            
            // Sync với settings cũ (backward compatibility)
            $phones = explode("\n", sanitize_textarea_field($_POST['tdclassic_company_phones']));
            $emails = explode("\n", sanitize_textarea_field($_POST['tdclassic_company_emails']));
            $addresses = explode("\n", sanitize_textarea_field($_POST['tdclassic_company_addresses']));
            
            if (!empty($phones[0])) {
                update_option('tdclassic_company_phone', trim($phones[0]));
            }
            if (!empty($emails[0])) {
                update_option('tdclassic_company_email', trim($emails[0]));
            }
            if (!empty($addresses[0])) {
                update_option('tdclassic_company_address', trim($addresses[0]));
            }
            
        } elseif ($active_tab === 'profile') {
            update_option('tdclassic_company_profile_pdf', esc_url_raw($_POST['tdclassic_company_profile_pdf']));
        }
        
        echo '<div class="notice notice-success is-dismissible"><p><strong>Đã lưu thay đổi thành công!</strong></p></div>';
    }
    
    // Get current values
    $company_name = get_option('blogname', '');
    $company_description = get_option('blogdescription', '');
    $site_url = get_option('siteurl', '');
    $meta_description = get_option('tdclassic_meta_description', '');
    $company_logo_id = get_option('tdclassic_company_logo', get_theme_mod('custom_logo'));
    $site_icon_id = get_option('tdclassic_site_icon', get_option('site_icon'));
    
    $company_phones = get_option('tdclassic_company_phones', get_option('tdclassic_company_phone', ''));
    $company_emails = get_option('tdclassic_company_emails', get_option('tdclassic_company_email', ''));
    $company_addresses = get_option('tdclassic_company_addresses', get_option('tdclassic_company_address', ''));
    
    $company_profile_pdf = get_option('tdclassic_company_profile_pdf', '');
    
    ?>
    <div class="wrap tdclassic-company-info-wrap">
        <h1><i class="dashicons dashicons-building"></i> Quản lý Thông tin Doanh nghiệp</h1>
        <p class="description">Quản lý thông tin công ty, liên hệ và hồ sơ năng lực. Thông tin này sẽ được hiển thị trên toàn bộ website.</p>
        
        <h2 class="nav-tab-wrapper">
            <a href="?page=tdclassic-company-info&tab=general" class="nav-tab <?php echo $active_tab === 'general' ? 'nav-tab-active' : ''; ?>">
                <i class="dashicons dashicons-admin-generic"></i> Thông tin Doanh nghiệp
            </a>
            <a href="?page=tdclassic-company-info&tab=contact" class="nav-tab <?php echo $active_tab === 'contact' ? 'nav-tab-active' : ''; ?>">
                <i class="dashicons dashicons-phone"></i> Liên hệ Doanh nghiệp
            </a>
            <a href="?page=tdclassic-company-info&tab=profile" class="nav-tab <?php echo $active_tab === 'profile' ? 'nav-tab-active' : ''; ?>">
                <i class="dashicons dashicons-media-document"></i> Hồ sơ Năng lực
            </a>
        </h2>
        
        <form method="post" action="" class="tdclassic-company-info-form">
            <?php wp_nonce_field('tdclassic_company_info_nonce'); ?>
            
            <div class="tab-content">
                <?php if ($active_tab === 'general') : ?>
                    <!-- Tab 1: Thông tin doanh nghiệp -->
                    <div class="tab-pane active">
                        <table class="form-table" role="presentation">
                            <tbody>
                                <tr>
                                    <th scope="row">
                                        <label for="tdclassic_company_name">Tên Doanh nghiệp <span class="required">*</span></label>
                                    </th>
                                    <td>
                                        <input type="text" id="tdclassic_company_name" name="tdclassic_company_name" 
                                               value="<?php echo esc_attr($company_name); ?>" class="regular-text" required>
                                        <p class="description">Tên trang web sẽ hiển thị trên tiêu đề trình duyệt và trong kết quả tìm kiếm.</p>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th scope="row">
                                        <label for="tdclassic_company_description">Mô tả</label>
                                    </th>
                                    <td>
                                        <textarea id="tdclassic_company_description" name="tdclassic_company_description" 
                                                  rows="3" class="large-text"><?php echo esc_textarea($company_description); ?></textarea>
                                        <p class="description">Mô tả ngắn gọn về doanh nghiệp (Slogan).</p>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th scope="row">
                                        <label for="tdclassic_site_icon">Biểu tượng Trang Web (Favicon)</label>
                                    </th>
                                    <td>
                                        <div class="tdclassic-media-upload">
                                            <input type="hidden" id="tdclassic_site_icon" name="tdclassic_site_icon" 
                                                   value="<?php echo esc_attr($site_icon_id); ?>">
                                            <div class="tdclassic-media-preview">
                                                <?php if ($site_icon_id) : 
                                                    $icon_url = wp_get_attachment_image_url($site_icon_id, 'thumbnail');
                                                ?>
                                                    <img src="<?php echo esc_url($icon_url); ?>" alt="Site Icon" class="preview-image">
                                                <?php else : ?>
                                                    <div class="placeholder">
                                                        <i class="dashicons dashicons-format-image"></i>
                                                        <span>Chưa có favicon</span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="tdclassic-media-actions">
                                                <button type="button" class="button tdclassic-upload-btn" data-target="tdclassic_site_icon">
                                                    Chọn Favicon
                                                </button>
                                                <button type="button" class="button tdclassic-remove-btn" data-target="tdclassic_site_icon" 
                                                        <?php echo !$site_icon_id ? 'style="display:none;"' : ''; ?>>
                                                    Xóa
                                                </button>
                                            </div>
                                        </div>
                                        <p class="description">Biểu tượng hiển thị trên tab trình duyệt. Khuyến nghị: 512x512px, định dạng PNG hoặc ICO.</p>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th scope="row">
                                        <label for="tdclassic_company_logo">Logo Trang Web</label>
                                    </th>
                                    <td>
                                        <div class="tdclassic-media-upload">
                                            <input type="hidden" id="tdclassic_company_logo" name="tdclassic_company_logo" 
                                                   value="<?php echo esc_attr($company_logo_id); ?>">
                                            <div class="tdclassic-media-preview">
                                                <?php if ($company_logo_id) : 
                                                    $logo_url = wp_get_attachment_image_url($company_logo_id, 'medium');
                                                ?>
                                                    <img src="<?php echo esc_url($logo_url); ?>" alt="Company Logo" class="preview-image">
                                                <?php else : ?>
                                                    <div class="placeholder">
                                                        <i class="dashicons dashicons-format-image"></i>
                                                        <span>Chưa có logo</span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="tdclassic-media-actions">
                                                <button type="button" class="button tdclassic-upload-btn" data-target="tdclassic_company_logo">
                                                    Chọn Logo
                                                </button>
                                                <button type="button" class="button tdclassic-remove-btn" data-target="tdclassic_company_logo" 
                                                        <?php echo !$company_logo_id ? 'style="display:none;"' : ''; ?>>
                                                    Xóa
                                                </button>
                                            </div>
                                        </div>
                                        <p class="description">Logo hiển thị trên header website. Khuyến nghị: chiều cao 50-80px, nền trong suốt (PNG).</p>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th scope="row">
                                        <label for="tdclassic_meta_description">Meta Description</label>
                                    </th>
                                    <td>
                                        <textarea id="tdclassic_meta_description" name="tdclassic_meta_description" 
                                                  rows="4" class="large-text" maxlength="160"><?php echo esc_textarea($meta_description); ?></textarea>
                                        <p class="description">Mô tả trang web hiển thị trong kết quả tìm kiếm Google (tối đa 160 ký tự). 
                                            <strong>Còn lại: <span id="meta-char-count"><?php echo 160 - strlen($meta_description); ?></span> ký tự</strong></p>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th scope="row">
                                        <label for="tdclassic_site_url">Link Trang Web</label>
                                    </th>
                                    <td>
                                        <input type="url" id="tdclassic_site_url" name="tdclassic_site_url" 
                                               value="<?php echo esc_url($site_url); ?>" class="regular-text" required>
                                        <p class="description">URL chính thức của website (bao gồm https://).</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                <?php elseif ($active_tab === 'contact') : ?>
                    <!-- Tab 2: Liên hệ doanh nghiệp -->
                    <div class="tab-pane active">
                        <table class="form-table" role="presentation">
                            <tbody>
                                <tr>
                                    <th scope="row">
                                        <label for="tdclassic_company_phones">Số Điện thoại Liên hệ</label>
                                    </th>
                                    <td>
                                        <textarea id="tdclassic_company_phones" name="tdclassic_company_phones" 
                                                  rows="5" class="large-text" placeholder="Nhập mỗi số điện thoại trên một dòng&#10;Ví dụ:&#10;+84 904 433 799&#10;0904 433 799"><?php echo esc_textarea($company_phones); ?></textarea>
                                        <p class="description">
                                            <i class="dashicons dashicons-info"></i> Mỗi số điện thoại trên một dòng. Số đầu tiên sẽ được sử dụng làm số chính trên header và footer.
                                        </p>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th scope="row">
                                        <label for="tdclassic_company_emails">Email Liên hệ</label>
                                    </th>
                                    <td>
                                        <textarea id="tdclassic_company_emails" name="tdclassic_company_emails" 
                                                  rows="5" class="large-text" placeholder="Nhập mỗi email trên một dòng&#10;Ví dụ:&#10;info@tdclassic.vn&#10;sales@tdclassic.vn&#10;support@tdclassic.vn"><?php echo esc_textarea($company_emails); ?></textarea>
                                        <p class="description">
                                            <i class="dashicons dashicons-info"></i> Mỗi email trên một dòng. Email đầu tiên sẽ được sử dụng làm email chính trên header và footer.
                                        </p>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th scope="row">
                                        <label for="tdclassic_company_addresses">Địa chỉ</label>
                                    </th>
                                    <td>
                                        <textarea id="tdclassic_company_addresses" name="tdclassic_company_addresses" 
                                                  rows="5" class="large-text" placeholder="Nhập mỗi địa chỉ trên một dòng&#10;Ví dụ:&#10;Số 22A Ngô Quyền, phường Ngô Quyền, TP. Hải Phòng&#10;Văn phòng chi nhánh: 123 Đường ABC, Quận XYZ, TP. HCM"><?php echo esc_textarea($company_addresses); ?></textarea>
                                        <p class="description">
                                            <i class="dashicons dashicons-info"></i> Mỗi địa chỉ trên một dòng. Địa chỉ đầu tiên sẽ được sử dụng làm địa chỉ chính trên footer và trang liên hệ.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div class="tdclassic-info-box">
                            <h3><i class="dashicons dashicons-yes-alt"></i> Thông tin đã lưu sẽ hiển thị tại:</h3>
                            <ul>
                                <li>✓ Header - Thanh thông tin liên hệ phía trên</li>
                                <li>✓ Footer - Thông tin công ty và liên hệ</li>
                                <li>✓ Trang Liên hệ - Form và thông tin công ty</li>
                                <li>✓ Trang Đại lý - Thông tin chi tiết từng đại lý</li>
                            </ul>
                        </div>
                    </div>
                    
                <?php elseif ($active_tab === 'profile') : ?>
                    <!-- Tab 3: Hồ sơ năng lực -->
                    <div class="tab-pane active">
                        <table class="form-table" role="presentation">
                            <tbody>
                                <tr>
                                    <th scope="row">
                                        <label for="tdclassic_company_profile_pdf">File Hồ sơ Năng lực (PDF)</label>
                                    </th>
                                    <td>
                                        <div class="tdclassic-pdf-upload">
                                            <input type="url" id="tdclassic_company_profile_pdf" name="tdclassic_company_profile_pdf" 
                                                   value="<?php echo esc_url($company_profile_pdf); ?>" class="large-text" 
                                                   placeholder="https://example.com/wp-content/uploads/ho-so-nang-luc.pdf">
                                            <button type="button" class="button button-primary tdclassic-pdf-select-btn">
                                                <i class="dashicons dashicons-media-document"></i> Chọn file PDF
                                            </button>
                                        </div>
                                        
                                        <?php if ($company_profile_pdf) : ?>
                                            <div class="tdclassic-pdf-preview">
                                                <div class="pdf-info">
                                                    <i class="dashicons dashicons-media-document"></i>
                                                    <div class="pdf-details">
                                                        <strong>File hiện tại:</strong>
                                                        <a href="<?php echo esc_url($company_profile_pdf); ?>" target="_blank" rel="noopener">
                                                            <?php echo basename($company_profile_pdf); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                                <a href="<?php echo esc_url($company_profile_pdf); ?>" class="button" target="_blank">
                                                    <i class="dashicons dashicons-visibility"></i> Xem PDF
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <p class="description">
                                            <i class="dashicons dashicons-info"></i> Upload file PDF hồ sơ năng lực công ty. 
                                            File này sẽ hiển thị trên trang "Hồ sơ năng lực" và có thể download.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div class="tdclassic-info-box">
                            <h3><i class="dashicons dashicons-info"></i> Hướng dẫn sử dụng:</h3>
                            <ol>
                                <li>Click nút "Chọn file PDF" để upload hoặc chọn file từ thư viện Media</li>
                                <li>Chỉ chọn file PDF (định dạng .pdf)</li>
                                <li>Sau khi lưu, file sẽ hiển thị trên trang Hồ sơ năng lực</li>
                                <li>Người dùng có thể xem trực tuyến hoặc tải về file PDF</li>
                            </ol>
                            
                            <p><strong>Trang hiển thị:</strong> 
                                <?php 
                                $profile_page = get_page_by_path('ho-so-nang-luc');
                                if ($profile_page) {
                                    echo '<a href="' . get_permalink($profile_page->ID) . '" target="_blank">Xem trang Hồ sơ năng lực</a>';
                                } else {
                                    echo '<span style="color: #dc3545;">Chưa tạo trang "Hồ sơ năng lực". Vui lòng tạo trang với slug "ho-so-nang-luc".</span>';
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <p class="submit">
                <button type="submit" name="tdclassic_save_company_info" class="button button-primary button-large">
                    <i class="dashicons dashicons-yes"></i> Lưu Thay đổi
                </button>
            </p>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Media Upload for Images
        $('.tdclassic-upload-btn').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var targetId = button.data('target');
            var isLogo = targetId.includes('logo');
            
            var frame = wp.media({
                title: isLogo ? 'Chọn Logo' : 'Chọn Favicon',
                button: { text: 'Sử dụng hình ảnh này' },
                library: { type: 'image' },
                multiple: false
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#' + targetId).val(attachment.id);
                
                var preview = button.closest('.tdclassic-media-upload').find('.tdclassic-media-preview');
                preview.html('<img src="' + attachment.url + '" alt="Preview" class="preview-image">');
                button.siblings('.tdclassic-remove-btn').show();
            });
            
            frame.open();
        });
        
        // Remove Image
        $('.tdclassic-remove-btn').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var targetId = button.data('target');
            
            $('#' + targetId).val('');
            var preview = button.closest('.tdclassic-media-upload').find('.tdclassic-media-preview');
            preview.html('<div class="placeholder"><i class="dashicons dashicons-format-image"></i><span>Chưa có hình</span></div>');
            button.hide();
        });
        
        // PDF Upload
        $('.tdclassic-pdf-select-btn').click(function(e) {
            e.preventDefault();
            
            var frame = wp.media({
                title: 'Chọn file PDF Hồ sơ năng lực',
                button: { text: 'Chọn file này' },
                library: { type: 'application/pdf' },
                multiple: false
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#tdclassic_company_profile_pdf').val(attachment.url);
            });
            
            frame.open();
        });
        
        // Meta description character counter
        $('#tdclassic_meta_description').on('input', function() {
            var length = $(this).val().length;
            var remaining = 160 - length;
            $('#meta-char-count').text(remaining);
            
            if (remaining < 0) {
                $('#meta-char-count').css('color', '#dc3545');
            } else if (remaining < 20) {
                $('#meta-char-count').css('color', '#ffc107');
            } else {
                $('#meta-char-count').css('color', '#28a745');
            }
        });
    });
    </script>
    <?php
}

/**
 * Enqueue admin styles and scripts
 */
function tdclassic_company_info_admin_assets($hook) {
    if ($hook !== 'toplevel_page_tdclassic-company-info') {
        return;
    }
    
    wp_enqueue_media();
    wp_enqueue_style(
        'tdclassic-company-info-admin',
        get_template_directory_uri() . '/assets/css/admin-company-info.css',
        array(),
        '1.0.0'
    );
}
add_action('admin_enqueue_scripts', 'tdclassic_company_info_admin_assets');

/**
 * Helper functions to get company information
 */

// Get all company phones as array
function tdclassic_get_company_phones() {
    $phones = get_option('tdclassic_company_phones', '');
    if (empty($phones)) {
        $phones = get_option('tdclassic_company_phone', '');
    }
    return array_filter(array_map('trim', explode("\n", $phones)));
}

// Get primary company phone
function tdclassic_get_primary_phone() {
    $phones = tdclassic_get_company_phones();
    return !empty($phones) ? $phones[0] : '+84 904 433 799';
}

// Get all company emails as array
function tdclassic_get_company_emails() {
    $emails = get_option('tdclassic_company_emails', '');
    if (empty($emails)) {
        $emails = get_option('tdclassic_company_email', '');
    }
    return array_filter(array_map('trim', explode("\n", $emails)));
}

// Get primary company email
function tdclassic_get_primary_email() {
    $emails = tdclassic_get_company_emails();
    return !empty($emails) ? $emails[0] : 'info@tdclassic.vn';
}

// Get all company addresses as array
function tdclassic_get_company_addresses() {
    $addresses = get_option('tdclassic_company_addresses', '');
    if (empty($addresses)) {
        $addresses = get_option('tdclassic_company_address', '');
    }
    return array_filter(array_map('trim', explode("\n", $addresses)));
}

// Get primary company address
function tdclassic_get_primary_address() {
    $addresses = tdclassic_get_company_addresses();
    return !empty($addresses) ? $addresses[0] : 'Số 22A Ngô Quyền, phường Ngô Quyền, Thành phố Hải Phòng, Việt Nam';
}

// Get meta description for SEO
function tdclassic_get_meta_description() {
    return get_option('tdclassic_meta_description', get_bloginfo('description'));
}

// Add meta description to head
function tdclassic_add_meta_description() {
    if (is_front_page() || is_home()) {
        $meta_description = tdclassic_get_meta_description();
        if (!empty($meta_description)) {
            echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";
        }
    }
}
add_action('wp_head', 'tdclassic_add_meta_description', 1);

/**
 * Template display functions - hiển thị tất cả thông tin liên hệ
 */

// Display all company phones
function tdclassic_display_all_phones($separator = '<br>', $echo = true) {
    $phones = tdclassic_get_company_phones();
    $output = '';
    
    if (!empty($phones)) {
        $phone_links = array();
        foreach ($phones as $phone) {
            $phone_clean = preg_replace('/[^0-9+]/', '', $phone);
            $phone_links[] = '<a href="tel:' . esc_attr($phone_clean) . '">' . esc_html($phone) . '</a>';
        }
        $output = implode($separator, $phone_links);
    }
    
    if ($echo) {
        echo $output;
    } else {
        return $output;
    }
}

// Display all company emails
function tdclassic_display_all_emails($separator = '<br>', $echo = true) {
    $emails = tdclassic_get_company_emails();
    $output = '';
    
    if (!empty($emails)) {
        $email_links = array();
        foreach ($emails as $email) {
            $email_links[] = '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
        }
        $output = implode($separator, $email_links);
    }
    
    if ($echo) {
        echo $output;
    } else {
        return $output;
    }
}

// Display all company addresses
function tdclassic_display_all_addresses($separator = '<br>', $echo = true) {
    $addresses = tdclassic_get_company_addresses();
    $output = '';
    
    if (!empty($addresses)) {
        $address_items = array();
        foreach ($addresses as $address) {
            $address_items[] = '<span class="company-address">' . esc_html($address) . '</span>';
        }
        $output = implode($separator, $address_items);
    }
    
    if ($echo) {
        echo $output;
    } else {
        return $output;
    }
}

// Display contact info block (useful for contact page, footer)
function tdclassic_display_contact_block($show_icon = true, $echo = true) {
    $phones = tdclassic_get_company_phones();
    $emails = tdclassic_get_company_emails();
    $addresses = tdclassic_get_company_addresses();
    
    $output = '<div class="tdclassic-contact-block">';
    
    if (!empty($phones)) {
        $output .= '<div class="contact-item phones">';
        if ($show_icon) {
            $output .= '<i class="fas fa-phone"></i> ';
        }
        $output .= '<div class="contact-content">';
        foreach ($phones as $phone) {
            $phone_clean = preg_replace('/[^0-9+]/', '', $phone);
            $output .= '<a href="tel:' . esc_attr($phone_clean) . '">' . esc_html($phone) . '</a><br>';
        }
        $output .= '</div></div>';
    }
    
    if (!empty($emails)) {
        $output .= '<div class="contact-item emails">';
        if ($show_icon) {
            $output .= '<i class="fas fa-envelope"></i> ';
        }
        $output .= '<div class="contact-content">';
        foreach ($emails as $email) {
            $output .= '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a><br>';
        }
        $output .= '</div></div>';
    }
    
    if (!empty($addresses)) {
        $output .= '<div class="contact-item addresses">';
        if ($show_icon) {
            $output .= '<i class="fas fa-map-marker-alt"></i> ';
        }
        $output .= '<div class="contact-content">';
        foreach ($addresses as $address) {
            $output .= '<span>' . esc_html($address) . '</span><br>';
        }
        $output .= '</div></div>';
    }
    
    $output .= '</div>';
    
    if ($echo) {
        echo $output;
    } else {
        return $output;
    }
}


