<?php
/**
 * Admin Product Specifications Management
 * Quản lý thông số kỹ thuật sản phẩm - Hỗ trợ nhận diện & dán nhanh tự động cho TD Classic
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
            'Bảng Thông Số Kỹ Thuật (TD Classic)',
            array($this, 'render_specs_metabox'),
            'product',
            'normal',
            'high'
        );
    }
    
    /**
     * Render the simplified specifications metabox with smart paste
     */
    public function render_specs_metabox($post) {
        wp_nonce_field('td_product_specs_nonce', 'td_product_specs_nonce_field');
        
        $custom_specs = get_post_meta($post->ID, '_custom_specifications', true);
        $specs_array = array();
        if ($custom_specs) {
            $specs_array = json_decode($custom_specs, true);
        }
        if (!is_array($specs_array)) {
            $specs_array = array();
        }
        
        // If empty, start with 3 empty rows
        if (empty($specs_array)) {
            $specs_array = array(
                array('label' => '', 'value' => ''),
                array('label' => '', 'value' => ''),
                array('label' => '', 'value' => '')
            );
        }
        ?>
        <div class="td-specs-metabox-wrapper">
            <style>
                .td-specs-metabox-wrapper {
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                }
                .td-specs-toolbar {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    margin-bottom: 14px;
                    flex-wrap: wrap;
                }
                .td-btn-gold {
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                    background: linear-gradient(135deg, #D4AF37 0%, #b8972e 100%);
                    color: #000;
                    border: 1px solid #b8972e;
                    padding: 8px 16px;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 13px;
                    font-weight: 600;
                    transition: all 0.2s;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
                }
                .td-btn-gold:hover {
                    background: #c5a028;
                    color: #000;
                    box-shadow: 0 2px 6px rgba(212,175,55,0.3);
                }
                .td-btn-dark {
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                    background: #1e293b;
                    color: #fff;
                    border: 1px solid #0f172a;
                    padding: 8px 15px;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 13px;
                    font-weight: 500;
                    transition: all 0.2s;
                }
                .td-btn-dark:hover {
                    background: #334155;
                    color: #fff;
                }
                .td-btn-secondary {
                    display: inline-flex;
                    align-items: center;
                    gap: 5px;
                    background: #f1f5f9;
                    color: #475569;
                    border: 1px solid #cbd5e1;
                    padding: 8px 14px;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 13px;
                    font-weight: 500;
                    transition: all 0.2s;
                }
                .td-btn-secondary:hover {
                    background: #e2e8f0;
                    color: #1e293b;
                }
                
                /* Quick Paste Box */
                .td-quick-paste-box {
                    display: none;
                    background: #f8fafc;
                    border: 2px dashed #D4AF37;
                    border-radius: 8px;
                    padding: 16px;
                    margin-bottom: 16px;
                    animation: tdFadeIn 0.3s ease;
                }
                @keyframes tdFadeIn {
                    from { opacity: 0; transform: translateY(-6px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .td-quick-paste-box textarea {
                    width: 100%;
                    min-height: 140px;
                    padding: 12px;
                    border: 1px solid #cbd5e1;
                    border-radius: 6px;
                    font-family: Consolas, Monaco, "Courier New", monospace;
                    font-size: 13px;
                    line-height: 1.6;
                    box-sizing: border-box;
                    background: #fff;
                }
                .td-quick-paste-box textarea:focus {
                    border-color: #D4AF37;
                    outline: none;
                    box-shadow: 0 0 0 1px #D4AF37;
                }
                .td-quick-paste-actions {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    margin-top: 10px;
                    flex-wrap: wrap;
                    gap: 10px;
                }
                
                /* Table Styles */
                .td-specs-table {
                    width: 100%;
                    border-collapse: collapse;
                    background: #fff;
                    border: 1px solid #e2e8f0;
                    border-radius: 6px;
                    overflow: hidden;
                    margin-bottom: 12px;
                }
                .td-specs-table th {
                    background: #f8fafc;
                    padding: 10px 14px;
                    font-size: 13px;
                    font-weight: 600;
                    color: #334155;
                    border-bottom: 1px solid #e2e8f0;
                    text-align: left;
                }
                .td-specs-table td {
                    padding: 8px 12px;
                    border-bottom: 1px solid #f1f5f9;
                    vertical-align: middle;
                }
                .td-specs-table tr:last-child td {
                    border-bottom: none;
                }
                .td-specs-table input[type="text"] {
                    width: 100%;
                    padding: 8px 12px;
                    border: 1px solid #cbd5e1;
                    border-radius: 4px;
                    font-size: 13px;
                    box-sizing: border-box;
                    transition: border-color 0.2s;
                }
                .td-specs-table input[type="text"]:focus {
                    border-color: #D4AF37;
                    box-shadow: 0 0 0 1px #D4AF37;
                    outline: none;
                }
                .td-btn-del-spec {
                    background: #fee2e2;
                    color: #ef4444;
                    border: 1px solid #fecaca;
                    width: 28px;
                    height: 28px;
                    border-radius: 4px;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 14px;
                    font-weight: bold;
                    transition: all 0.2s;
                    margin: 0 auto;
                }
                .td-btn-del-spec:hover {
                    background: #ef4444;
                    color: #fff;
                }
                .td-specs-hint {
                    color: #64748b;
                    font-size: 12px;
                    line-height: 1.5;
                }
            </style>

            <!-- Actions Toolbar -->
            <div class="td-specs-toolbar">
                <button type="button" class="td-btn-gold" onclick="tdToggleQuickPaste()">
                    <span class="dashicons dashicons-clipboard" style="font-size: 16px; width: 16px; height: 16px; line-height: 16px;"></span>
                    📋 Dán nhanh từ Excel / Văn bản
                </button>
                <button type="button" class="td-btn-dark" onclick="tdAddSpecRow()">
                    <span class="dashicons dashicons-plus-alt2" style="font-size: 16px; width: 16px; height: 16px; line-height: 16px;"></span>
                    Thêm dòng
                </button>
                <button type="button" class="td-btn-secondary" onclick="tdClearAllSpecs()">
                    <span class="dashicons dashicons-trash" style="font-size: 16px; width: 16px; height: 16px; line-height: 16px;"></span>
                    Xóa hết bảng
                </button>
                <span class="td-specs-hint" style="margin-left: auto;">
                    💡 Có thể dán trực tiếp (Ctrl+V) vào ô bất kỳ hoặc bấm nút dán nhanh màu vàng.
                </span>
            </div>

            <!-- Quick Paste Box (Collapsible) -->
            <div class="td-quick-paste-box" id="tdQuickPasteBox">
                <div style="font-weight: 600; color: #1e293b; margin-bottom: 8px; font-size: 13px;">
                    📝 Dán văn bản thông số vào khung dưới (Tự động nhận diện Excel, Word, hoặc dấu hai chấm ":"):
                </div>
                <textarea id="tdPasteInput" placeholder="Ví dụ 1: Copy trực tiếp 2 cột từ Excel / Google Sheets rồi dán vào đây.

Ví dụ 2: Dán văn bản theo dòng:
Model: TD-12 Pro
Công suất: 450W RMS
Trở kháng: 8 Ohms
Dải tần số: 50Hz - 20kHz
Độ nhạy: 98 dB SPL
Kích thước: 600 x 360 x 382 mm
Trọng lượng: 18.5 kg"></textarea>
                
                <div class="td-quick-paste-actions">
                    <div style="display: flex; gap: 15px; align-items: center; font-size: 13px; color: #334155;">
                        <label style="cursor: pointer;">
                            <input type="radio" name="td_paste_mode" value="replace" checked> Thay thế toàn bộ bảng
                        </label>
                        <label style="cursor: pointer;">
                            <input type="radio" name="td_paste_mode" value="append"> Thêm tiếp vào cuối bảng
                        </label>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" class="td-btn-gold" onclick="tdExecuteQuickPaste()">
                            ⚡ Nhận diện & Điền vào bảng
                        </button>
                        <button type="button" class="td-btn-secondary" onclick="tdToggleQuickPaste()">
                            Đóng
                        </button>
                    </div>
                </div>
            </div>

            <!-- Specifications Table -->
            <table class="td-specs-table" id="tdSpecsTable">
                <thead>
                    <tr>
                        <th style="width: 38%;">Tên thông số (VD: Model, Công suất, Trở kháng, Dải tần, Trọng lượng...)</th>
                        <th style="width: 54%;">Giá trị (VD: TD-12 Pro, 450W RMS, 8 Ohms, 50Hz - 20kHz, 18.5kg...)</th>
                        <th style="width: 8%; text-align: center;">Xóa</th>
                    </tr>
                </thead>
                <tbody id="tdSpecsTableBody">
                    <?php foreach ($specs_array as $index => $spec): ?>
                        <tr class="td-spec-row">
                            <td>
                                <input type="text" 
                                       name="custom_specs[<?php echo $index; ?>][label]" 
                                       placeholder="Tên thông số..." 
                                       value="<?php echo esc_attr(isset($spec['label']) ? $spec['label'] : ''); ?>">
                            </td>
                            <td>
                                <input type="text" 
                                       name="custom_specs[<?php echo $index; ?>][value]" 
                                       placeholder="Giá trị thông số..." 
                                       value="<?php echo esc_attr(isset($spec['value']) ? $spec['value'] : ''); ?>">
                            </td>
                            <td style="text-align: center;">
                                <button type="button" class="td-btn-del-spec" onclick="tdRemoveSpecRow(this)" title="Xóa dòng này">×</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <script>
            // Toggle Quick Paste Box
            function tdToggleQuickPaste() {
                const box = document.getElementById('tdQuickPasteBox');
                if (box.style.display === 'none' || box.style.display === '') {
                    box.style.display = 'block';
                    document.getElementById('tdPasteInput').focus();
                } else {
                    box.style.display = 'none';
                }
            }

            // Smart Parser for pasted text
            function tdParsePastedSpecs(text) {
                if (!text || typeof text !== 'string') return [];
                const lines = text.split(/\r?\n/);
                const results = [];
                
                for (let rawLine of lines) {
                    let line = rawLine.trim();
                    if (!line) continue;
                    
                    // Skip markdown table separators like |---|---|
                    if (/^\|?[\s-:]+\|[\s-:]+\|?$/.test(line)) continue;
                    
                    let label = '', value = '';
                    
                    // 1. Check Tab-separated (Excel / Google Sheets / Word Tables)
                    if (line.includes('\t')) {
                        const parts = line.split('\t');
                        label = parts[0].trim();
                        value = parts.slice(1).join(' ').trim();
                    }
                    // 2. Check Pipe-separated (|)
                    else if (line.includes('|')) {
                        const parts = line.split('|').map(p => p.trim()).filter(p => p !== '');
                        if (parts.length >= 2) {
                            label = parts[0];
                            value = parts.slice(1).join(' - ');
                        }
                    }
                    // 3. Check Colon (: or Asian colon ：)
                    else if (line.includes(':') || line.includes('：')) {
                        const sep = line.includes(':') ? ':' : '：';
                        const firstColon = line.indexOf(sep);
                        label = line.substring(0, firstColon).trim();
                        value = line.substring(firstColon + 1).trim();
                    }
                    // 4. Check Dash separated with spaces (" - " or " – ")
                    else if (/\s+[-–—]\s+/.test(line)) {
                        const parts = line.split(/\s+[-–—]\s+/);
                        label = parts[0].trim();
                        value = parts.slice(1).join(' - ').trim();
                    }
                    // 5. Fallback: Entire line as label
                    else {
                        label = line;
                        value = '';
                    }
                    
                    // Strip leading bullet markers (•, -, *, 1., etc.)
                    label = label.replace(/^[\s•\-\*]+/, '').replace(/^\d+[\.\)]\s*/, '').trim();
                    
                    if (label || value) {
                        results.push({ label, value });
                    }
                }
                return results;
            }

            // Populate table from parsed specs
            function tdPopulateSpecsTable(specs, mode = 'replace') {
                if (!specs || specs.length === 0) {
                    alert('Không tìm thấy thông số nào từ nội dung dán!');
                    return;
                }
                
                const tbody = document.getElementById('tdSpecsTableBody');
                if (mode === 'replace') {
                    tbody.innerHTML = '';
                }
                
                specs.forEach((item) => {
                    const row = document.createElement('tr');
                    row.className = 'td-spec-row';
                    row.innerHTML = `
                        <td>
                            <input type="text" placeholder="Tên thông số..." value="${tdEscapeHtml(item.label)}">
                        </td>
                        <td>
                            <input type="text" placeholder="Giá trị thông số..." value="${tdEscapeHtml(item.value)}">
                        </td>
                        <td style="text-align: center;">
                            <button type="button" class="td-btn-del-spec" onclick="tdRemoveSpecRow(this)" title="Xóa dòng này">×</button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
                
                tdReindexRows();
            }

            // Execute Quick Paste from Textarea
            function tdExecuteQuickPaste() {
                const text = document.getElementById('tdPasteInput').value;
                if (!text.trim()) {
                    alert('Vui lòng dán văn bản thông số vào khung trước!');
                    return;
                }
                
                const modeInput = document.querySelector('input[name="td_paste_mode"]:checked');
                const mode = modeInput ? modeInput.value : 'replace';
                
                const parsed = tdParsePastedSpecs(text);
                if (parsed.length > 0) {
                    tdPopulateSpecsTable(parsed, mode);
                    document.getElementById('tdPasteInput').value = '';
                    document.getElementById('tdQuickPasteBox').style.display = 'none';
                } else {
                    alert('Không nhận diện được dòng thông số nào. Vui lòng kiểm tra lại định dạng!');
                }
            }

            // Add single row
            function tdAddSpecRow() {
                const tbody = document.getElementById('tdSpecsTableBody');
                const rowCount = tbody.querySelectorAll('.td-spec-row').length;
                const newRow = document.createElement('tr');
                newRow.className = 'td-spec-row';
                newRow.innerHTML = `
                    <td>
                        <input type="text" name="custom_specs[${rowCount}][label]" placeholder="Tên thông số...">
                    </td>
                    <td>
                        <input type="text" name="custom_specs[${rowCount}][value]" placeholder="Giá trị thông số...">
                    </td>
                    <td style="text-align: center;">
                        <button type="button" class="td-btn-del-spec" onclick="tdRemoveSpecRow(this)" title="Xóa dòng này">×</button>
                    </td>
                `;
                tbody.appendChild(newRow);
                newRow.querySelector('input').focus();
            }

            // Remove single row
            function tdRemoveSpecRow(btn) {
                const row = btn.closest('.td-spec-row');
                const tbody = document.getElementById('tdSpecsTableBody');
                if (tbody.querySelectorAll('.td-spec-row').length > 1) {
                    row.remove();
                } else {
                    row.querySelectorAll('input').forEach(input => input.value = '');
                }
                tdReindexRows();
            }

            // Clear all rows
            function tdClearAllSpecs() {
                if (confirm('Bạn có chắc chắn muốn xóa toàn bộ bảng thông số này?')) {
                    const tbody = document.getElementById('tdSpecsTableBody');
                    tbody.innerHTML = `
                        <tr class="td-spec-row">
                            <td><input type="text" name="custom_specs[0][label]" placeholder="Tên thông số..."></td>
                            <td><input type="text" name="custom_specs[0][value]" placeholder="Giá trị thông số..."></td>
                            <td style="text-align: center;"><button type="button" class="td-btn-del-spec" onclick="tdRemoveSpecRow(this)">×</button></td>
                        </tr>
                    `;
                }
            }

            // Re-index input names
            function tdReindexRows() {
                const tbody = document.getElementById('tdSpecsTableBody');
                tbody.querySelectorAll('.td-spec-row').forEach((r, idx) => {
                    const inputs = r.querySelectorAll('input');
                    if (inputs.length >= 2) {
                        inputs[0].name = `custom_specs[${idx}][label]`;
                        inputs[1].name = `custom_specs[${idx}][value]`;
                    }
                });
            }

            // Helper to escape HTML characters
            function tdEscapeHtml(str) {
                if (!str) return '';
                return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
            }

            // Direct Clipboard Paste Listener on table inputs
            document.addEventListener('DOMContentLoaded', function() {
                const table = document.getElementById('tdSpecsTable');
                if (!table) return;
                
                table.addEventListener('paste', function(e) {
                    const target = e.target;
                    if (!target || target.tagName !== 'INPUT') return;
                    
                    const text = (e.clipboardData || window.clipboardData).getData('text');
                    if (!text) return;
                    
                    const lines = text.split(/\r?\n/).map(l => l.trim()).filter(Boolean);
                    // If multi-line or contains tab/colon, automatically ask to fill
                    if (lines.length > 1 || text.includes('\t')) {
                        const parsed = tdParsePastedSpecs(text);
                        if (parsed.length > 1) {
                            e.preventDefault();
                            if (confirm(`Phát hiện bạn đang dán ${parsed.length} dòng thông số kỹ thuật.\nBạn có muốn tự động điền vào bảng không?`)) {
                                tdPopulateSpecsTable(parsed, 'replace');
                            }
                        }
                    }
                });
            });
        </script>
        <?php
    }
    
    /**
     * Save product specifications
     */
    public function save_product_specs($post_id) {
        if (!isset($_POST['td_product_specs_nonce_field']) || 
            !wp_verify_nonce($_POST['td_product_specs_nonce_field'], 'td_product_specs_nonce')) {
            return;
        }
        
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        if (isset($_POST['custom_specs']) && is_array($_POST['custom_specs'])) {
            $custom_specs = array();
            foreach ($_POST['custom_specs'] as $spec) {
                $label = isset($spec['label']) ? sanitize_text_field(trim($spec['label'])) : '';
                $value = isset($spec['value']) ? sanitize_text_field(trim($spec['value'])) : '';
                if ($label !== '' || $value !== '') {
                    $custom_specs[] = array(
                        'label' => $label,
                        'value' => $value
                    );
                }
            }
            if (!empty($custom_specs)) {
                update_post_meta($post_id, '_custom_specifications', json_encode($custom_specs, JSON_UNESCAPED_UNICODE));
            } else {
                delete_post_meta($post_id, '_custom_specifications');
            }
        } else {
            delete_post_meta($post_id, '_custom_specifications');
        }
    }
    
    /**
     * Enqueue admin scripts if needed
     */
    public function enqueue_admin_scripts($hook) {
        // Handled inline cleanly
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
    register_setting('td_classic_settings', 'tdclassic_turnstile_site_key');
    register_setting('td_classic_settings', 'tdclassic_turnstile_secret_key');
    
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

    add_settings_section(
        'td_classic_security_section',
        'Bảo mật & Chống Spam (Cloudflare Turnstile)',
        'td_classic_security_section_callback',
        'td_classic_settings'
    );

    add_settings_field(
        'tdclassic_turnstile_site_key',
        'Turnstile Site Key',
        'tdclassic_turnstile_site_key_render',
        'td_classic_settings',
        'td_classic_security_section'
    );

    add_settings_field(
        'tdclassic_turnstile_secret_key',
        'Turnstile Secret Key',
        'tdclassic_turnstile_secret_key_render',
        'td_classic_settings',
        'td_classic_security_section'
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

function tdclassic_turnstile_site_key_render() {
    $value = get_option('tdclassic_turnstile_site_key', '');
    echo '<input type="text" name="tdclassic_turnstile_site_key" value="' . esc_attr($value) . '" class="regular-text" placeholder="1x00000000000000000000AA" />';
    echo '<p class="description">Site Key được cung cấp bởi Cloudflare Turnstile. Sử dụng 1x00000000000000000000AA làm Testing Key.</p>';
}

function tdclassic_turnstile_secret_key_render() {
    $value = get_option('tdclassic_turnstile_secret_key', '');
    echo '<input type="password" name="tdclassic_turnstile_secret_key" value="' . esc_attr($value) . '" class="regular-text" placeholder="1x0000000000000000000000000000000AA" />';
    echo '<p class="description">Secret Key được cung cấp bởi Cloudflare Turnstile. Sử dụng 1x0000000000000000000000000000000AA làm Testing Key.</p>';
}

function td_classic_contact_section_callback() {
    echo '<p>Cấu hình thông tin liên hệ hiển thị trên trang sản phẩm</p>';
}

function td_classic_security_section_callback() {
    echo '<p>Cấu hình khóa Cloudflare Turnstile để bảo vệ các Form liên hệ trên website.</p>';
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
