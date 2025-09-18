<?php
/**
 * Admin Consultation Management
 * Manage customer consultation requests and email configuration
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class TD_Classic_Consultation_Manager {
    
    public function __construct() {
        add_action('init', array($this, 'create_consultations_table'));
        add_action('wp_ajax_submit_consultation', array($this, 'handle_consultation_submission'));
        add_action('wp_ajax_nopriv_submit_consultation', array($this, 'handle_consultation_submission'));
        add_action('admin_menu', array($this, 'add_consultation_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_consultation_admin_scripts'));
    }
    
    /**
     * Convert project type from English to Vietnamese
     */
    private function get_project_type_label($type) {
        $types = array(
            'home' => 'Gia đình/Cá nhân',
            'office' => 'Văn phòng',
            'restaurant' => 'Nhà hàng/Cafe',
            'hotel' => 'Khách sạn/Resort',
            'retail' => 'Cửa hàng/Showroom',
            'mall' => 'Trung tâm thương mại',
            'other' => 'Khác'
        );
        
        return isset($types[$type]) ? $types[$type] : $type;
    }
    
    /**
     * Convert consultation needs from English to Vietnamese
     */
    private function get_consultation_needs_label($needs) {
        $needs_map = array(
            'quote' => 'Báo giá chi tiết',
            'design' => 'Thiết kế hệ thống',
            'install' => 'Tư vấn lắp đặt',
            'demo' => 'Demo sản phẩm'
        );
        
        // Handle comma-separated needs
        $needs_array = explode(', ', $needs);
        $translated_needs = array();
        
        foreach ($needs_array as $need) {
            $need = trim($need);
            $translated_needs[] = isset($needs_map[$need]) ? $needs_map[$need] : $need;
        }
        
        return implode(', ', $translated_needs);
    }
    
    /**
     * Convert project budget from English to Vietnamese
     */
    private function get_project_budget_label($budget) {
        $budgets = array(
            'under-50m' => 'Dưới 50 triệu',
            '50m-100m' => '50 - 100 triệu',
            '100m-500m' => '100 - 500 triệu',
            '500m-1b' => '500 triệu - 1 tỷ',
            'over-1b' => 'Trên 1 tỷ',
            'discuss' => 'Thảo luận trực tiếp',
        );
        return isset($budgets[$budget]) ? $budgets[$budget] : $budget;
    }
    
    /**
     * Create consultations table
     */
    public function create_consultations_table() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'td_consultations';
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            product_id bigint(20) NOT NULL,
            product_name varchar(255) NOT NULL,
            customer_name varchar(100) NOT NULL,
            customer_phone varchar(20) NOT NULL,
            customer_email varchar(100) DEFAULT '',
            company_name varchar(100) DEFAULT '',
            project_address text DEFAULT '',
            project_type varchar(50) DEFAULT '',
            project_budget varchar(50) DEFAULT '',
            consultation_needs text DEFAULT '',
            project_note text DEFAULT '',
            status varchar(20) DEFAULT 'new',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    /**
     * Handle AJAX consultation submission
     */
    public function handle_consultation_submission() {
        // Set proper charset for Vietnamese
        header('Content-Type: application/json; charset=UTF-8');
        
        // Check if POST data exists
        if (empty($_POST)) {
            wp_send_json_error(array(
                'message' => 'Không nhận được dữ liệu. Vui lòng thử lại.'
            ));
        }
        
        // Verify nonce for security
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'consultation_nonce')) {
            wp_send_json_error(array(
                'message' => 'Lỗi bảo mật. Vui lòng tải lại trang và thử lại.'
            ));
        }
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'td_consultations';
        
        // Validate required fields
        if (empty($_POST['customer_name']) || empty($_POST['customer_phone'])) {
            wp_send_json_error(array(
                'message' => 'Vui lòng điền đầy đủ họ tên và số điện thoại.'
            ));
        }
        
        // Sanitize input data
        $data = array(
            'product_id' => isset($_POST['product_id']) ? intval($_POST['product_id']) : 0,
            'product_name' => isset($_POST['product_name']) ? sanitize_text_field($_POST['product_name']) : '',
            'customer_name' => sanitize_text_field($_POST['customer_name']),
            'customer_phone' => sanitize_text_field($_POST['customer_phone']),
            'customer_email' => isset($_POST['customer_email']) ? sanitize_email($_POST['customer_email']) : '',
            'company_name' => isset($_POST['company_name']) ? sanitize_text_field($_POST['company_name']) : '',
            'project_address' => isset($_POST['project_address']) ? sanitize_textarea_field($_POST['project_address']) : '',
            'project_type' => isset($_POST['project_type']) ? sanitize_text_field($_POST['project_type']) : '',
            'project_budget' => isset($_POST['project_budget']) ? sanitize_text_field($_POST['project_budget']) : '',
            'consultation_needs' => isset($_POST['needs']) ? sanitize_text_field(implode(', ', (array)$_POST['needs'])) : '',
            'project_note' => isset($_POST['project_note']) ? sanitize_textarea_field($_POST['project_note']) : '',
            'status' => 'new'
        );
        
        // Insert into database
        $result = $wpdb->insert($table_name, $data);
        
        if ($result !== false) {
            // Send confirmation email
            $this->send_confirmation_email($data);
            
            // Send notification email to admin
            $this->send_admin_notification_email($data);
            
            wp_send_json_success(array(
                'message' => 'Yêu cầu tư vấn đã được gửi thành công! Chuyên gia sẽ liên hệ với bạn trong vòng 30 phút.'
            ));
        } else {
            // Log database error for debugging
            error_log('Database insert failed: ' . $wpdb->last_error);
            
            wp_send_json_error(array(
                'message' => 'Có lỗi xảy ra khi lưu thông tin. Vui lòng thử lại sau hoặc liên hệ trực tiếp qua hotline.'
            ));
        }
    }
    
    /**
     * Send confirmation email to customer
     */
    private function send_confirmation_email($data) {
        $email_template = get_option('td_consultation_email_template', $this->get_default_email_template());
        $admin_email = get_option('td_consultation_admin_email', get_option('admin_email'));
        $company_name = get_option('td_consultation_company_name', 'TD Classic');
        
        // Replace placeholders
        $email_content = str_replace(
            array(
                '{customer_name}',
                '{product_name}',
                '{company_name}',
                '{admin_email}',
                '{hotline}'
            ),
            array(
                $data['customer_name'],
                $data['product_name'],
                $company_name,
                $admin_email,
                get_option('tdclassic_hotline', '1900 xxxx')
            ),
            $email_template
        );
        
        $subject = "Xác nhận yêu cầu tư vấn - {$data['product_name']} - $company_name";
        
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            "From: $company_name <$admin_email>"
        );
        
        if (!empty($data['customer_email'])) {
            wp_mail($data['customer_email'], $subject, $email_content, $headers);
        }
    }
    
    /**
     * Send notification email to admin
     */
    private function send_admin_notification_email($data) {
        $admin_email = get_option('td_consultation_admin_email', get_option('admin_email'));
        $company_name = get_option('td_consultation_company_name', 'TD Classic');
        
        $subject = "Yêu cầu tư vấn mới - {$data['product_name']}";
        
        $message = "
        <h3>Yêu cầu tư vấn mới từ website</h3>
        <table style='border-collapse: collapse; width: 100%;'>
            <tr><td style='border: 1px solid #ddd; padding: 8px; background: #f9f9f9; font-weight: bold;'>Sản phẩm:</td><td style='border: 1px solid #ddd; padding: 8px;'>{$data['product_name']}</td></tr>
            <tr><td style='border: 1px solid #ddd; padding: 8px; background: #f9f9f9; font-weight: bold;'>Họ tên:</td><td style='border: 1px solid #ddd; padding: 8px;'>{$data['customer_name']}</td></tr>
            <tr><td style='border: 1px solid #ddd; padding: 8px; background: #f9f9f9; font-weight: bold;'>Điện thoại:</td><td style='border: 1px solid #ddd; padding: 8px;'>{$data['customer_phone']}</td></tr>
            <tr><td style='border: 1px solid #ddd; padding: 8px; background: #f9f9f9; font-weight: bold;'>Email:</td><td style='border: 1px solid #ddd; padding: 8px;'>{$data['customer_email']}</td></tr>
            <tr><td style='border: 1px solid #ddd; padding: 8px; background: #f9f9f9; font-weight: bold;'>Công ty:</td><td style='border: 1px solid #ddd; padding: 8px;'>{$data['company_name']}</td></tr>
            <tr><td style='border: 1px solid #ddd; padding: 8px; background: #f9f9f9; font-weight: bold;'>Loại dự án:</td><td style='border: 1px solid #ddd; padding: 8px;'>{$data['project_type']}</td></tr>
            <tr><td style='border: 1px solid #ddd; padding: 8px; background: #f9f9f9; font-weight: bold;'>Ngân sách:</td><td style='border: 1px solid #ddd; padding: 8px;'>{$data['project_budget']}</td></tr>
            <tr><td style='border: 1px solid #ddd; padding: 8px; background: #f9f9f9; font-weight: bold;'>Nhu cầu:</td><td style='border: 1px solid #ddd; padding: 8px;'>{$data['consultation_needs']}</td></tr>
            <tr><td style='border: 1px solid #ddd; padding: 8px; background: #f9f9f9; font-weight: bold;'>Địa chỉ dự án:</td><td style='border: 1px solid #ddd; padding: 8px;'>{$data['project_address']}</td></tr>
            <tr><td style='border: 1px solid #ddd; padding: 8px; background: #f9f9f9; font-weight: bold;'>Ghi chú:</td><td style='border: 1px solid #ddd; padding: 8px;'>{$data['project_note']}</td></tr>
        </table>
        
        <p><strong>Vui lòng liên hệ khách hàng trong vòng 30 phút!</strong></p>
        ";
        
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            "From: $company_name <$admin_email>"
        );
        
        wp_mail($admin_email, $subject, $message, $headers);
    }
    
    /**
     * Get default email template
     */
    private function get_default_email_template() {
        return '
        <div style="max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif;">
            <div style="background: #000; color: #fff; padding: 20px; text-align: center;">
                <h2>{company_name}</h2>
                <p>Cảm ơn bạn đã quan tâm đến sản phẩm của chúng tôi</p>
            </div>
            
            <div style="padding: 30px; background: #f9f9f9;">
                <p>Xin chào <strong>{customer_name}</strong>,</p>
                
                <p>Chúng tôi đã nhận được yêu cầu tư vấn của bạn về sản phẩm <strong>{product_name}</strong>.</p>
                
                <p>Đội ngũ chuyên gia của {company_name} sẽ liên hệ với bạn trong vòng <strong>30 phút</strong> để tư vấn chi tiết về sản phẩm và giải pháp phù hợp nhất.</p>
                
                <div style="background: #fff; padding: 20px; border-radius: 8px; margin: 20px 0;">
                    <h3 style="margin-top: 0;">Thông tin liên hệ</h3>
                    <p><strong>Hotline:</strong> {hotline}</p>
                    <p><strong>Email:</strong> {admin_email}</p>
                </div>
                
                <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua thông tin trên.</p>
                
                <p>Trân trọng,<br><strong>Đội ngũ {company_name}</strong></p>
            </div>
            
            <div style="background: #333; color: #fff; padding: 15px; text-align: center; font-size: 12px;">
                <p>Email này được gửi tự động, vui lòng không trả lời.</p>
            </div>
        </div>';
    }
    
    /**
     * Add consultation admin menu
     */
    public function add_consultation_admin_menu() {
        add_menu_page(
            'Quản lý tư vấn',
            'CSKH',
            'manage_options',
            'td-consultations',
            array($this, 'consultations_admin_page'),
            'dashicons-groups',
            26
        );
        
        add_submenu_page(
            'td-consultations',
            'Danh sách yêu cầu',
            'Danh sách yêu cầu',
            'manage_options',
            'td-consultations',
            array($this, 'consultations_admin_page')
        );
        
        add_submenu_page(
            'td-consultations',
            'Cấu hình Email',
            'Cấu hình Email',
            'manage_options',
            'td-consultation-settings',
            array($this, 'consultation_settings_page')
        );
    }
    
    /**
     * Consultations admin page
     */
    public function consultations_admin_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'td_consultations';
        
        // Handle status update
        if (isset($_POST['update_status']) && isset($_POST['consultation_id'])) {
            $wpdb->update(
                $table_name,
                array('status' => sanitize_text_field($_POST['status'])),
                array('id' => intval($_POST['consultation_id']))
            );
            echo '<div class="notice notice-success"><p>Cập nhật trạng thái thành công!</p></div>';
        }
        
        // Get consultations
        $consultations = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");
        
        ?>
        <div class="wrap">
            <h1>Quản lý yêu cầu tư vấn</h1>
            
            <div class="consultation-stats" style="display: flex; gap: 20px; margin: 20px 0;">
                <div style="background: #fff; padding: 15px; border-radius: 8px; border-left: 4px solid #0073aa;">
                    <h3 style="margin: 0; color: #0073aa;"><?php echo $wpdb->get_var("SELECT COUNT(*) FROM $table_name"); ?></h3>
                    <p style="margin: 5px 0 0 0;">Tổng yêu cầu</p>
                </div>
                <div style="background: #fff; padding: 15px; border-radius: 8px; border-left: 4px solid #00a32a;">
                    <h3 style="margin: 0; color: #00a32a;"><?php echo $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'completed'"); ?></h3>
                    <p style="margin: 5px 0 0 0;">Đã hoàn thành</p>
                </div>
                <div style="background: #fff; padding: 15px; border-radius: 8px; border-left: 4px solid #d63638;">
                    <h3 style="margin: 0; color: #d63638;"><?php echo $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'new'"); ?></h3>
                    <p style="margin: 5px 0 0 0;">Chưa xử lý</p>
                </div>
            </div>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Điện thoại</th>
                        <th>Sản phẩm</th>
                        <th>Loại dự án</th>
                        <th>Nhu cầu</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consultations as $consultation) : ?>
                    <tr>
                        <td><?php echo $consultation->id; ?></td>
                        <td>
                            <strong><?php echo esc_html($consultation->customer_name); ?></strong>
                            <?php if ($consultation->company_name) : ?>
                                <br><small><?php echo esc_html($consultation->company_name); ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="tel:<?php echo esc_attr($consultation->customer_phone); ?>"><?php echo esc_html($consultation->customer_phone); ?></a>
                            <?php if ($consultation->customer_email) : ?>
                                <br><a href="mailto:<?php echo esc_attr($consultation->customer_email); ?>"><?php echo esc_html($consultation->customer_email); ?></a>
                            <?php endif; ?>
                        </td>
                        <td><?php echo esc_html($consultation->product_name); ?></td>
                        <td><?php echo esc_html($this->get_project_type_label($consultation->project_type)); ?></td>
                        <td><?php echo esc_html($this->get_consultation_needs_label($consultation->consultation_needs)); ?></td>
                        <td>
                            <span class="status-<?php echo $consultation->status; ?>" style="padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; 
                                <?php 
                                switch($consultation->status) {
                                    case 'new': echo 'background: #d63638; color: white;'; break;
                                    case 'processing': echo 'background: #dba617; color: white;'; break;
                                    case 'completed': echo 'background: #00a32a; color: white;'; break;
                                    default: echo 'background: #666; color: white;';
                                }
                                ?>">
                                <?php 
                                switch($consultation->status) {
                                    case 'new': echo 'Mới'; break;
                                    case 'processing': echo 'Đang xử lý'; break;
                                    case 'completed': echo 'Hoàn thành'; break;
                                    default: echo ucfirst($consultation->status);
                                }
                                ?>
                            </span>
                        </td>
                        <td><?php echo date('d/m/Y H:i', strtotime($consultation->created_at)); ?></td>
                        <td>
                            <button type="button" class="button button-small" onclick="viewConsultation(<?php echo $consultation->id; ?>)">Xem</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- View Consultation Modal -->
        <div id="consultationModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
            <div style="background-color: #fefefe; margin: 5% auto; padding: 20px; border-radius: 8px; width: 80%; max-width: 600px; max-height: 80%; overflow-y: auto;">
                <span style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;" onclick="closeModal()">&times;</span>
                <div id="consultationDetails"></div>
            </div>
        </div>
        
        <script>
        function viewConsultation(id) {
            var consultations = <?php echo json_encode($consultations); ?>;
            var consultation = consultations.find(c => c.id == id);
            
            var html = '<h2>Chi tiết yêu cầu tư vấn #' + id + '</h2>';
            html += '<table style="width: 100%; border-collapse: collapse;">';
            html += '<tr><td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">Khách hàng:</td><td style="padding: 8px; border: 1px solid #ddd;">' + consultation.customer_name + '</td></tr>';
            html += '<tr><td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">Điện thoại:</td><td style="padding: 8px; border: 1px solid #ddd;"><a href="tel:' + consultation.customer_phone + '">' + consultation.customer_phone + '</a></td></tr>';
            if (consultation.customer_email) {
                html += '<tr><td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">Email:</td><td style="padding: 8px; border: 1px solid #ddd;"><a href="mailto:' + consultation.customer_email + '">' + consultation.customer_email + '</a></td></tr>';
            }
            if (consultation.company_name) {
                html += '<tr><td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">Công ty:</td><td style="padding: 8px; border: 1px solid #ddd;">' + consultation.company_name + '</td></tr>';
            }
            html += '<tr><td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">Sản phẩm:</td><td style="padding: 8px; border: 1px solid #ddd;">' + consultation.product_name + '</td></tr>';
            if (consultation.project_type) {
                var projectTypeLabels = {
                    'home': 'Gia đình/Cá nhân',
                    'office': 'Văn phòng',
                    'restaurant': 'Nhà hàng/Cafe',
                    'hotel': 'Khách sạn/Resort',
                    'retail': 'Cửa hàng/Showroom',
                    'mall': 'Trung tâm thương mại',
                    'other': 'Khác'
                };
                var projectTypeLabel = projectTypeLabels[consultation.project_type] || consultation.project_type;
                html += '<tr><td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">Loại dự án:</td><td style="padding: 8px; border: 1px solid #ddd;">' + projectTypeLabel + '</td></tr>';
            }
            if (consultation.project_budget) {
                var budgetLabels = {
                    'under-50m': 'Dưới 50 triệu',
                    '50m-100m': '50 - 100 triệu',
                    '100m-500m': '100 - 500 triệu',
                    '500m-1b': '500 triệu - 1 tỷ',
                    'over-1b': 'Trên 1 tỷ',
                    'discuss': 'Thảo luận trực tiếp'
                };
                var budgetLabel = budgetLabels[consultation.project_budget] || consultation.project_budget;
                html += '<tr><td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">Ngân sách:</td><td style="padding: 8px; border: 1px solid #ddd;">' + budgetLabel + '</td></tr>';
            }
            if (consultation.consultation_needs) {
                // Chuyển đổi nhu cầu sang tiếng Việt
                var needsLabels = {
                    'quote': 'Báo giá chi tiết',
                    'design': 'Thiết kế hệ thống',
                    'install': 'Tư vấn lắp đặt',
                    'demo': 'Demo sản phẩm'
                };
                var needs = consultation.consultation_needs.split(',');
                var translatedNeeds = needs.map(function(need) {
                    var n = need.trim();
                    return needsLabels[n] || n;
                });
                var needsLabel = translatedNeeds.join(', ');
                html += '<tr><td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">Nhu cầu:</td><td style="padding: 8px; border: 1px solid #ddd;">' + needsLabel + '</td></tr>';
            }
            if (consultation.project_address) {
                html += '<tr><td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">Địa chỉ dự án:</td><td style="padding: 8px; border: 1px solid #ddd;">' + consultation.project_address + '</td></tr>';
            }
            if (consultation.project_note) {
                html += '<tr><td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">Ghi chú:</td><td style="padding: 8px; border: 1px solid #ddd;">' + consultation.project_note + '</td></tr>';
            }
            html += '<tr><td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9; font-weight: bold;">Ngày tạo:</td><td style="padding: 8px; border: 1px solid #ddd;">' + new Date(consultation.created_at).toLocaleString('vi-VN') + '</td></tr>';
            html += '</table>';
            
            html += '<form method="post" style="margin-top: 20px;">';
            html += '<input type="hidden" name="consultation_id" value="' + id + '">';
            html += '<label for="status">Cập nhật trạng thái:</label> ';
            html += '<select name="status" id="status">';
            html += '<option value="new"' + (consultation.status == 'new' ? ' selected' : '') + '>Mới</option>';
            html += '<option value="processing"' + (consultation.status == 'processing' ? ' selected' : '') + '>Đang xử lý</option>';
            html += '<option value="completed"' + (consultation.status == 'completed' ? ' selected' : '') + '>Hoàn thành</option>';
            html += '</select> ';
            html += '<input type="submit" name="update_status" value="Cập nhật" class="button button-primary">';
            html += '</form>';
            
            document.getElementById('consultationDetails').innerHTML = html;
            document.getElementById('consultationModal').style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('consultationModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            var modal = document.getElementById('consultationModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
        </script>
        <?php
    }
    
    /**
     * Consultation settings page
     */
    public function consultation_settings_page() {
        if (isset($_POST['save_settings'])) {
            update_option('td_consultation_admin_email', sanitize_email($_POST['admin_email']));
            update_option('td_consultation_company_name', sanitize_text_field($_POST['company_name']));
            update_option('td_consultation_email_template', wp_kses_post($_POST['email_template']));
            echo '<div class="notice notice-success"><p>Cài đặt đã được lưu!</p></div>';
        }
        
        $admin_email = get_option('td_consultation_admin_email', get_option('admin_email'));
        $company_name = get_option('td_consultation_company_name', 'TD Classic');
        $email_template = get_option('td_consultation_email_template', $this->get_default_email_template());
        
        ?>
        <div class="wrap">
            <h1>Cấu hình Email tư vấn</h1>
            
            <form method="post">
                <table class="form-table">
                    <tr>
                        <th scope="row">Email nhận thông báo</th>
                        <td>
                            <input type="email" name="admin_email" value="<?php echo esc_attr($admin_email); ?>" class="regular-text" required>
                            <p class="description">Email sẽ nhận thông báo khi có yêu cầu tư vấn mới</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Tên công ty</th>
                        <td>
                            <input type="text" name="company_name" value="<?php echo esc_attr($company_name); ?>" class="regular-text" required>
                            <p class="description">Tên công ty hiển thị trong email</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Template email xác nhận</th>
                        <td>
                            <textarea name="email_template" rows="20" class="large-text code"><?php echo esc_textarea($email_template); ?></textarea>
                            <p class="description">
                                Các biến có thể sử dụng: {customer_name}, {product_name}, {company_name}, {admin_email}, {hotline}
                            </p>
                        </td>
                    </tr>
                </table>
                
                <p class="submit">
                    <input type="submit" name="save_settings" class="button-primary" value="Lưu cài đặt">
                </p>
            </form>
        </div>
        <?php
    }
    
    /**
     * Enqueue admin scripts
     */
    public function enqueue_consultation_admin_scripts($hook) {
        if (strpos($hook, 'td-consultation') !== false) {
            wp_enqueue_script('jquery');
        }
    }
}

// Initialize the class
new TD_Classic_Consultation_Manager();
?>
