<?php
/**
 * Admin Product Specifications Management
 * Add custom fields for quick specifications display
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class TD_Classic_Product_Specs {
    
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_product_specs_metabox'));
        add_action('save_post', array($this, 'save_product_specs'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }
    
    /**
     * Add metabox for product specifications
     */
    public function add_product_specs_metabox() {
        add_meta_box(
            'td_product_specs',
            'Thông số sản phẩm TD Classic',
            array($this, 'render_specs_metabox'),
            'product',
            'normal',
            'high'
        );
    }
    
    /**
     * Render the specifications metabox
     */
    public function render_specs_metabox($post) {
        // Add nonce for security
        wp_nonce_field('td_product_specs_nonce', 'td_product_specs_nonce_field');
        
        // Get existing values
        $quick_specs = get_post_meta($post->ID, '_quick_specifications', true);
        $full_specs = get_post_meta($post->ID, '_product_specifications', true);
        $key_features = get_post_meta($post->ID, '_key_features', true);
        $product_model = get_post_meta($post->ID, '_product_model', true);
        $product_weight = get_post_meta($post->ID, '_product_weight', true);
        $custom_specs = get_post_meta($post->ID, '_custom_specifications', true);
        
        // Parse quick specs JSON
        $specs_array = array();
        if ($quick_specs) {
            $specs_array = json_decode($quick_specs, true);
            if (!$specs_array) {
                $specs_array = array();
            }
        }
        
        // Ensure we have at least 4 empty specs
        while (count($specs_array) < 4) {
            $specs_array[] = array('label' => '', 'value' => '');
        }
        
        // Parse custom specs JSON
        $custom_specs_array = array();
        if ($custom_specs) {
            $custom_specs_array = json_decode($custom_specs, true);
            if (!$custom_specs_array) {
                $custom_specs_array = array();
            }
        }
        
        // Ensure we have at least 2 empty custom specs
        while (count($custom_specs_array) < 2) {
            $custom_specs_array[] = array('label' => '', 'value' => '');
        }
        ?>
        
        <div class="td-product-specs-container">
            <style>
                .td-product-specs-container {
                    max-width: 100%;
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                }
                
                .specs-section {
                    background: #f9f9f9;
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    padding: 20px;
                    margin-bottom: 20px;
                }
                
                .specs-section h3 {
                    margin-top: 0;
                    color: #333;
                    font-size: 14px;
                    font-weight: 600;
                    border-bottom: 2px solid #333;
                    padding-bottom: 10px;
                }
                
                .quick-specs-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                    gap: 15px;
                    margin-top: 15px;
                }
                
                .spec-item {
                    display: flex;
                    gap: 10px;
                    align-items: center;
                    background: white;
                    padding: 12px;
                    border-radius: 6px;
                    border: 1px solid #ddd;
                }
                
                .spec-item input {
                    flex: 1;
                    padding: 8px 12px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    font-size: 14px;
                }
                
                .spec-item input:focus {
                    border-color: #333;
                    box-shadow: 0 0 0 2px rgba(51, 51, 51, 0.1);
                    outline: none;
                }
                
                .spec-label {
                    font-weight: 600;
                    color: #333;
                    min-width: 80px;
                    font-size: 13px;
                }
                
                .add-spec-btn {
                    background: #333;
                    color: white;
                    border: none;
                    padding: 8px 16px;
                    border-radius: 4px;
                    cursor: pointer;
                    font-size: 14px;
                    margin-top: 10px;
                }
                
                .add-spec-btn:hover {
                    background: #555;
                }
                
                .remove-spec-btn {
                    background: #dc3545;
                    color: white;
                    border: none;
                    width: 24px;
                    height: 24px;
                    border-radius: 50%;
                    cursor: pointer;
                    font-size: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                
                .remove-spec-btn:hover {
                    background: #c82333;
                }
                
                .full-specs-editor {
                    margin-top: 15px;
                }
                
                .key-features-editor {
                    margin-top: 15px;
                }
                
                .key-features-editor textarea {
                    width: 100%;
                    min-height: 120px;
                    padding: 12px;
                    border: 1px solid #ddd;
                    border-radius: 6px;
                    font-family: inherit;
                    font-size: 14px;
                    line-height: 1.5;
                }
                
                .help-text {
                    font-size: 13px;
                    color: #666;
                    margin-top: 8px;
                    font-style: italic;
                }
            </style>
            
            <!-- Quick Specifications Section -->
            
            <!-- Key Features Section -->
            <div class="specs-section">
                <h3><i class="dashicons dashicons-star-filled"></i> Điểm nổi bật</h3>
                <p class="help-text">Mỗi dòng là một điểm nổi bật. Tối đa 6 điểm.</p>
                
                <div class="key-features-editor">
                    <textarea name="key_features" placeholder="Nhập các điểm nổi bật, mỗi dòng một điểm:&#10;Công nghệ âm thanh tiên tiến&#10;Thiết kế hiện đại, sang trọng&#10;Chất lượng âm thanh vượt trội&#10;Dễ dàng lắp đặt và sử dụng"><?php echo esc_textarea($key_features); ?></textarea>
                </div>
            </div>
            
            <!-- Basic Product Info Section -->
            <div class="specs-section">
                <h3><i class="dashicons dashicons-admin-generic"></i> Thông tin cơ bản sản phẩm</h3>
                <p class="help-text">Thông tin cơ bản sẽ hiển thị trong modal thông số kỹ thuật.</p>
                
                <div class="basic-info-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="info-item">
                        <label for="product_model"><strong>Model sản phẩm:</strong></label>
                        <input type="text" id="product_model" name="product_model" value="<?php echo esc_attr($product_model); ?>" placeholder="VD: WQ15, TD-2024, ..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;" accept-charset="utf-8">
                        <small style="color: #666; font-size: 12px;">Nhập model chính xác của sản phẩm</small>
                    </div>
                    <div class="info-item">
                        <label for="product_weight"><strong>Trọng lượng:</strong></label>
                        <input type="text" id="product_weight" name="product_weight" value="<?php echo esc_attr($product_weight); ?>" placeholder="VD: 2.5kg, 1200g, ..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;" accept-charset="utf-8">
                        <small style="color: #666; font-size: 12px;">Bao gồm cả đơn vị đo (kg, g)</small>
                    </div>
                </div>
            </div>

            <!-- Custom Technical Specifications Section -->
            <div class="specs-section">
                <h3><i class="dashicons dashicons-admin-tools"></i> Thông số kỹ thuật chuyên ngành</h3>
                <p class="help-text">Các thông số kỹ thuật chuyên ngành của sản phẩm (VD: Công suất, Trở kháng, Dải tần số, ...).</p>
                
                <div class="custom-specs-grid" id="customSpecsGrid">
                    <?php foreach ($custom_specs_array as $index => $spec): ?>
                        <div class="spec-item">
                            <span class="spec-label">Thông số <?php echo $index + 1; ?>:</span>
                            <input type="text" 
                                   name="custom_specs[<?php echo $index; ?>][label]" 
                                   placeholder="Tên thông số (VD: Công suất)" 
                                   value="<?php echo esc_attr($spec['label']); ?>">
                            <input type="text" 
                                   name="custom_specs[<?php echo $index; ?>][value]" 
                                   placeholder="Giá trị (VD: 100W RMS)" 
                                   value="<?php echo esc_attr($spec['value']); ?>">
                            <?php if ($index >= 2): ?>
                                <button type="button" class="remove-spec-btn" onclick="removeCustomSpec(this)">×</button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <button type="button" class="add-spec-btn" onclick="addCustomSpec()">
                    <i class="dashicons dashicons-plus-alt"></i> Thêm thông số kỹ thuật
                </button>
            </div>

            <!-- Full Specifications Section -->
            <div class="specs-section">
                <h3><i class="dashicons dashicons-admin-page"></i> Mô tả chi tiết bổ sung</h3>
                <p class="help-text">Mô tả chi tiết bổ sung sẽ hiển thị cuối modal thông số kỹ thuật (tùy chọn).</p>
                
                <div class="full-specs-editor">
                    <?php
                    wp_editor(
                        $full_specs,
                        'product_specifications',
                        array(
                            'textarea_name' => 'product_specifications',
                            'textarea_rows' => 10,
                            'media_buttons' => false,
                            'teeny' => true,
                            'tinymce' => array(
                                'toolbar1' => 'bold,italic,underline,bullist,numlist,link,unlink',
                                'toolbar2' => '',
                            ),
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
        
        <script>
            let specCounter = <?php echo count($specs_array); ?>;
            let customSpecCounter = <?php echo count($custom_specs_array); ?>;
            
            function addQuickSpec() {
                if (specCounter >= 6) {
                    alert('Tối đa 6 thông số nhanh');
                    return;
                }
                
                const grid = document.getElementById('quickSpecsGrid');
                const newSpec = document.createElement('div');
                newSpec.className = 'spec-item';
                newSpec.innerHTML = `
                    <span class="spec-label">Thông số ${specCounter + 1}:</span>
                    <input type="text" name="quick_specs[${specCounter}][label]" placeholder="Tên thông số (VD: Thương hiệu)">
                    <input type="text" name="quick_specs[${specCounter}][value]" placeholder="Giá trị (VD: TD Classic)">
                    <button type="button" class="remove-spec-btn" onclick="removeSpec(this)">×</button>
                `;
                
                grid.appendChild(newSpec);
                specCounter++;
            }
            
            function removeSpec(button) {
                button.parentElement.remove();
                updateSpecLabels();
            }
            
            function updateSpecLabels() {
                const specs = document.querySelectorAll('#quickSpecsGrid .spec-item');
                specs.forEach((spec, index) => {
                    const label = spec.querySelector('.spec-label');
                    label.textContent = `Thông số ${index + 1}:`;
                    
                    const inputs = spec.querySelectorAll('input');
                    inputs[0].name = `quick_specs[${index}][label]`;
                    inputs[1].name = `quick_specs[${index}][value]`;
                });
                specCounter = specs.length;
            }
            
            // Custom specs functions
            function addCustomSpec() {
                if (customSpecCounter >= 8) {
                    alert('Tối đa 8 thông số kỹ thuật');
                    return;
                }
                
                const grid = document.getElementById('customSpecsGrid');
                const newSpec = document.createElement('div');
                newSpec.className = 'spec-item';
                newSpec.innerHTML = `
                    <span class="spec-label">Thông số ${customSpecCounter + 1}:</span>
                    <input type="text" name="custom_specs[${customSpecCounter}][label]" placeholder="Tên thông số (VD: Công suất)">
                    <input type="text" name="custom_specs[${customSpecCounter}][value]" placeholder="Giá trị (VD: 100W RMS)">
                    <button type="button" class="remove-spec-btn" onclick="removeCustomSpec(this)">×</button>
                `;
                
                grid.appendChild(newSpec);
                customSpecCounter++;
            }
            
            function removeCustomSpec(button) {
                button.parentElement.remove();
                updateCustomSpecLabels();
            }
            
            function updateCustomSpecLabels() {
                const specs = document.querySelectorAll('#customSpecsGrid .spec-item');
                specs.forEach((spec, index) => {
                    const label = spec.querySelector('.spec-label');
                    label.textContent = `Thông số ${index + 1}:`;
                    
                    const inputs = spec.querySelectorAll('input');
                    inputs[0].name = `custom_specs[${index}][label]`;
                    inputs[1].name = `custom_specs[${index}][value]`;
                });
                customSpecCounter = specs.length;
            }
        </script>
        
        <?php
    }
    
    /**
     * Save product specifications
     */
    public function save_product_specs($post_id) {
        // Verify nonce
        if (!isset($_POST['td_product_specs_nonce_field']) || 
            !wp_verify_nonce($_POST['td_product_specs_nonce_field'], 'td_product_specs_nonce')) {
            return;
        }
        
        // Check if user has permission to edit
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Save quick specifications
        if (isset($_POST['quick_specs'])) {
            $quick_specs = array();
            foreach ($_POST['quick_specs'] as $spec) {
                if (!empty($spec['label']) && !empty($spec['value'])) {
                    $quick_specs[] = array(
                        'label' => sanitize_text_field($spec['label']),
                        'value' => sanitize_text_field($spec['value'])
                    );
                }
            }
            update_post_meta($post_id, '_quick_specifications', json_encode($quick_specs, JSON_UNESCAPED_UNICODE));
        }
        
        // Save key features
        if (isset($_POST['key_features'])) {
            update_post_meta($post_id, '_key_features', sanitize_textarea_field($_POST['key_features']));
        }
        
        // Save product model
        if (isset($_POST['product_model'])) {
            update_post_meta($post_id, '_product_model', sanitize_text_field($_POST['product_model']));
        }
        
        // Save product weight
        if (isset($_POST['product_weight'])) {
            update_post_meta($post_id, '_product_weight', sanitize_text_field($_POST['product_weight']));
        }
        
        // Save custom specifications
        if (isset($_POST['custom_specs'])) {
            $custom_specs = array();
            foreach ($_POST['custom_specs'] as $spec) {
                if (!empty($spec['label']) && !empty($spec['value'])) {
                    $custom_specs[] = array(
                        'label' => sanitize_text_field($spec['label']),
                        'value' => sanitize_text_field($spec['value'])
                    );
                }
            }
            update_post_meta($post_id, '_custom_specifications', json_encode($custom_specs, JSON_UNESCAPED_UNICODE));
        }
        
        // Save full specifications
        if (isset($_POST['product_specifications'])) {
            update_post_meta($post_id, '_product_specifications', wp_kses_post($_POST['product_specifications']));
        }
    }
    
    /**
     * Enqueue admin scripts
     */
    public function enqueue_admin_scripts($hook) {
        if ('post.php' !== $hook && 'post-new.php' !== $hook) {
            return;
        }
        
        global $post_type;
        if ('product' !== $post_type) {
            return;
        }
        
        wp_enqueue_script('td-product-specs-admin', get_template_directory_uri() . '/assets/js/admin-product-specs.js', array('jquery'), '1.0.0', true);
    }
}

// Initialize the class
new TD_Classic_Product_Specs();

/**
 * Add settings for hotline and zalo
 */
add_action('admin_menu', 'td_classic_add_admin_menu');
add_action('admin_init', 'td_classic_settings_init');

function td_classic_add_admin_menu() {
    add_options_page(
        'TD Classic Settings',
        'TD Classic',
        'manage_options',
        'td_classic',
        'td_classic_options_page'
    );
}

function td_classic_settings_init() {
    register_setting('td_classic_settings', 'tdclassic_hotline');
    register_setting('td_classic_settings', 'tdclassic_zalo');
    
    add_settings_section(
        'td_classic_contact_section',
        'Thông tin liên hệ',
        'td_classic_contact_section_callback',
        'td_classic_settings'
    );
    
    add_settings_field(
        'tdclassic_hotline',
        'Số hotline',
        'tdclassic_hotline_render',
        'td_classic_settings',
        'td_classic_contact_section'
    );
    
    add_settings_field(
        'tdclassic_zalo',
        'Số Zalo',
        'tdclassic_zalo_render',
        'td_classic_settings',
        'td_classic_contact_section'
    );
}

function tdclassic_hotline_render() {
    $value = get_option('tdclassic_hotline', '1900 xxxx');
    echo '<input type="text" name="tdclassic_hotline" value="' . esc_attr($value) . '" placeholder="VD: 1900 1234" />';
    echo '<p class="description">Số hotline hiển thị trên trang sản phẩm</p>';
}

function tdclassic_zalo_render() {
    $value = get_option('tdclassic_zalo', '0901 234 567');
    echo '<input type="text" name="tdclassic_zalo" value="' . esc_attr($value) . '" placeholder="VD: 0901 234 567" />';
    echo '<p class="description">Số Zalo hiển thị trên trang sản phẩm</p>';
}

function td_classic_contact_section_callback() {
    echo '<p>Cấu hình thông tin liên hệ hiển thị trên trang sản phẩm</p>';
}

function td_classic_options_page() {
    ?>
    <div class="wrap">
        <h1>TD Classic Settings</h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('td_classic_settings');
            do_settings_sections('td_classic_settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
?>
