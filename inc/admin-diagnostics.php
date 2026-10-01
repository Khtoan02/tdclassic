<?php
/**
 * TD Classic Performance & Diagnostics Manager
 * Hệ thống giám sát tốc độ tải trang, ghi nhận lỗi file 404, chẩn đoán host và xuất báo cáo cho AI.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class TD_Classic_Diagnostics {

    private static $instance = null;
    private $perf_table = '';
    private $error_table = '';

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        global $wpdb;
        $this->perf_table = $wpdb->prefix . 'td_perf_logs';
        $this->error_table = $wpdb->prefix . 'td_error_logs';

        // Table creation
        add_action('init', array($this, 'init_tables'));
        add_action('admin_init', array($this, 'init_tables'));
        add_action('after_switch_theme', array($this, 'init_tables'));

        // Admin Menu & Assets
        add_action('admin_menu', array($this, 'register_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));

        // AJAX endpoints
        add_action('wp_ajax_tdclassic_record_telemetry', array($this, 'ajax_record_telemetry'));
        add_action('wp_ajax_nopriv_tdclassic_record_telemetry', array($this, 'ajax_record_telemetry'));

        add_action('wp_ajax_tdclassic_record_asset_error', array($this, 'ajax_record_asset_error'));
        add_action('wp_ajax_nopriv_tdclassic_record_asset_error', array($this, 'ajax_record_asset_error'));

        add_action('wp_ajax_tdclassic_run_audit_page', array($this, 'ajax_run_audit_page'));
        add_action('wp_ajax_tdclassic_clear_perf_logs', array($this, 'ajax_clear_perf_logs'));
        add_action('wp_ajax_tdclassic_clear_error_logs', array($this, 'ajax_clear_error_logs'));
        add_action('wp_ajax_tdclassic_export_diagnostics', array($this, 'ajax_export_diagnostics'));

        // Frontend Telemetry Injection
        add_action('wp_footer', array($this, 'inject_frontend_collector'), 9999);

        // Server-side 404 Logging
        add_action('template_redirect', array($this, 'log_server_404'));
    }

    /**
     * Create or update database tables
     */
    public function init_tables() {
        $db_version = get_option('tdclassic_diagnostics_db_ver', '');
        $target_version = '1.0.1';

        if ($db_version === $target_version) {
            return;
        }

        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql_perf = "CREATE TABLE {$this->perf_table} (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            url varchar(255) NOT NULL,
            is_mobile tinyint(1) DEFAULT 0,
            server_time_ms float DEFAULT 0,
            client_ttfb_ms float DEFAULT 0,
            dom_ready_ms float DEFAULT 0,
            load_time_ms float DEFAULT 0,
            lcp_ms float DEFAULT 0,
            cls float DEFAULT 0,
            fcp_ms float DEFAULT 0,
            memory_mb float DEFAULT 0,
            query_count int(11) DEFAULT 0,
            ip varchar(45) DEFAULT '',
            user_agent varchar(255) DEFAULT '',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY url_idx (url(191)),
            KEY created_idx (created_at)
        ) $charset_collate;";

        $sql_error = "CREATE TABLE {$this->error_table} (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            error_type varchar(50) NOT NULL,
            target_url text NOT NULL,
            page_url varchar(255) DEFAULT '',
            status_code int(5) DEFAULT 404,
            message text DEFAULT '',
            ip varchar(45) DEFAULT '',
            user_agent varchar(255) DEFAULT '',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY error_type_idx (error_type),
            KEY created_idx (created_at)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql_perf);
        dbDelta($sql_error);

        update_option('tdclassic_diagnostics_db_ver', $target_version);
    }

    /**
     * Register Admin Menu
     */
    public function register_admin_menu() {
        add_menu_page(
            'Giám Sát & Lỗi Host',
            'Giám Sát Host',
            'manage_options',
            'tdclassic-diagnostics',
            array($this, 'render_admin_page'),
            'dashicons-performance',
            30
        );
    }

    /**
     * Enqueue Admin Assets
     */
    public function enqueue_admin_assets($hook) {
        if (strpos($hook, 'tdclassic-diagnostics') === false) {
            return;
        }

        $theme_version = wp_get_theme()->get('Version');

        wp_enqueue_style(
            'tdclassic-diagnostics-css',
            get_template_directory_uri() . '/assets/css/admin/diagnostics.css',
            array(),
            $theme_version
        );

        wp_enqueue_script(
            'tdclassic-diagnostics-js',
            get_template_directory_uri() . '/assets/js/admin/diagnostics.js',
            array('jquery'),
            $theme_version,
            true
        );

        wp_localize_script('tdclassic-diagnostics-js', 'tdDiagnostics', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('tdclassic_diagnostics_nonce'),
            'site_url' => home_url('/'),
            'pages_to_audit' => array(
                array('title' => 'Trang chủ', 'url' => home_url('/')),
                array('title' => 'Sản phẩm', 'url' => home_url('/san-pham/')),
                array('title' => 'Dự án', 'url' => home_url('/du-an/')),
                array('title' => 'Tin tức', 'url' => home_url('/tin-tuc/')),
                array('title' => 'Liên hệ', 'url' => home_url('/lien-he/')),
                array('title' => 'Hồ sơ năng lực', 'url' => home_url('/ho-so-nang-luc/')),
                array('title' => 'Đại lý', 'url' => home_url('/dai-ly/'))
            )
        ));
    }

    /**
     * Inject lightweight telemetry collector in frontend footer
     */
    public function inject_frontend_collector() {
        if (is_admin()) {
            return;
        }

        $server_time = 0;
        if (isset($_SERVER['REQUEST_TIME_FLOAT'])) {
            $server_time = round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000, 2);
        }

        $peak_mem = round(memory_get_peak_usage() / 1048576, 2);
        $queries = get_num_queries();
        $ajax_url = admin_url('admin-ajax.php');
        $current_url = home_url($_SERVER['REQUEST_URI'] ?? '/');
        ?>
        <script id="td-telemetry-collector">
        (function() {
            var serverMetrics = {
                url: <?php echo json_encode($current_url); ?>,
                server_time_ms: <?php echo $server_time; ?>,
                memory_mb: <?php echo $peak_mem; ?>,
                query_count: <?php echo $queries; ?>,
                ajax_url: <?php echo json_encode($ajax_url); ?>
            };

            // Catch broken asset loading (404 / failed scripts, styles, images)
            window.addEventListener('error', function(e) {
                try {
                    var target = e.target;
                    if (target && (target.tagName === 'IMG' || target.tagName === 'SCRIPT' || target.tagName === 'LINK')) {
                        var assetUrl = target.src || target.href;
                        if (assetUrl && !assetUrl.startsWith('data:') && !assetUrl.startsWith('blob:')) {
                            var payload = (window.URLSearchParams) ? new URLSearchParams() : new FormData();
                            payload.append('action', 'tdclassic_record_asset_error');
                            payload.append('target_url', assetUrl);
                            payload.append('page_url', window.location.href);
                            payload.append('error_type', target.tagName.toLowerCase() + '_load_error');
                            payload.append('message', 'Không thể tải file ' + target.tagName + ': ' + assetUrl);
                            
                            if (navigator.sendBeacon) {
                                navigator.sendBeacon(serverMetrics.ajax_url, payload);
                            } else {
                                fetch(serverMetrics.ajax_url, { method: 'POST', body: payload, keepalive: true }).catch(function(){});
                            }
                        }
                    }
                } catch(err) {}
            }, true);

            // Record Navigation Timing & Core Web Vitals
            var lcpVal = 0;
            var clsVal = 0;
            var fcpVal = 0;

            if ('PerformanceObserver' in window) {
                try {
                    var poLcp = new PerformanceObserver(function(entryList) {
                        var entries = entryList.getEntries();
                        if (entries.length > 0) {
                            lcpVal = Math.round(entries[entries.length - 1].startTime);
                        }
                    });
                    poLcp.observe({ type: 'largest-contentful-paint', buffered: true });

                    var poCls = new PerformanceObserver(function(entryList) {
                        entryList.getEntries().forEach(function(entry) {
                            if (!entry.hadRecentInput) {
                                clsVal += entry.value;
                            }
                        });
                    });
                    poCls.observe({ type: 'layout-shift', buffered: true });

                    var poPaint = new PerformanceObserver(function(entryList) {
                        entryList.getEntries().forEach(function(entry) {
                            if (entry.name === 'first-contentful-paint') {
                                fcpVal = Math.round(entry.startTime);
                            }
                        });
                    });
                    poPaint.observe({ type: 'paint', buffered: true });
                } catch(e) {}
            }

            function sendPerfData() {
                try {
                    var perf = window.performance;
                    if (!perf) return;

                    var client_ttfb = 0;
                    var dom_ready = 0;
                    var load_time = 0;

                    var nav = perf.getEntriesByType && perf.getEntriesByType('navigation')[0];
                    if (nav) {
                        client_ttfb = Math.round(nav.responseStart - nav.requestStart);
                        dom_ready = Math.round(nav.domContentLoadedEventEnd - nav.startTime);
                        load_time = Math.round(nav.loadEventEnd - nav.startTime);
                    } else if (perf.timing) {
                        var t = perf.timing;
                        client_ttfb = t.responseStart > t.requestStart ? Math.round(t.responseStart - t.requestStart) : 0;
                        dom_ready = t.domContentLoadedEventEnd > t.navigationStart ? Math.round(t.domContentLoadedEventEnd - t.navigationStart) : 0;
                        load_time = t.loadEventEnd > t.navigationStart ? Math.round(t.loadEventEnd - t.navigationStart) : 0;
                    }

                    if (load_time <= 0 && nav && nav.duration > 0) {
                        load_time = Math.round(nav.duration);
                    }

                    var isMobile = (window.innerWidth <= 768 || /Mobi|Android|iPhone/i.test(navigator.userAgent)) ? 1 : 0;

                    var payload = (window.URLSearchParams) ? new URLSearchParams() : new FormData();
                    payload.append('action', 'tdclassic_record_telemetry');
                    payload.append('url', serverMetrics.url);
                    payload.append('is_mobile', isMobile);
                    payload.append('server_time_ms', serverMetrics.server_time_ms);
                    payload.append('client_ttfb_ms', client_ttfb);
                    payload.append('dom_ready_ms', dom_ready);
                    payload.append('load_time_ms', load_time);
                    payload.append('lcp_ms', lcpVal);
                    payload.append('cls', clsVal ? clsVal.toFixed(3) : 0);
                    payload.append('fcp_ms', fcpVal);
                    payload.append('memory_mb', serverMetrics.memory_mb);
                    payload.append('query_count', serverMetrics.query_count);

                    if (navigator.sendBeacon) {
                        navigator.sendBeacon(serverMetrics.ajax_url, payload);
                    } else {
                        fetch(serverMetrics.ajax_url, { method: 'POST', body: payload, keepalive: true }).catch(function(){});
                    }
                } catch(err) {}
            }

            window.addEventListener('load', function() {
                setTimeout(sendPerfData, 1000);
            });
        })();
        </script>
        <?php
    }

    /**
     * Server-side 404 Logging
     */
    public function log_server_404() {
        if (is_404()) {
            $req_url = home_url($_SERVER['REQUEST_URI'] ?? '');
            $referer = wp_get_referer() ?: 'Direct / External';

            // Filter out common bot scanners if needed, but log asset 404s
            $this->record_error(array(
                'error_type'  => 'page_404',
                'target_url'  => $req_url,
                'page_url'    => $referer,
                'status_code' => 404,
                'message'     => 'Trang không tìm thấy (404 Not Found)'
            ));
        }
    }

    /**
     * AJAX: Record Telemetry
     */
    public function ajax_record_telemetry() {
        $url = isset($_POST['url']) ? esc_url_raw($_POST['url']) : '';
        if (empty($url)) {
            wp_send_json_error();
        }

        $is_mobile = !empty($_POST['is_mobile']) ? 1 : 0;
        $server_time = floatval($_POST['server_time_ms'] ?? 0);
        $client_ttfb = floatval($_POST['client_ttfb_ms'] ?? 0);
        $dom_ready   = floatval($_POST['dom_ready_ms'] ?? 0);
        $load_time   = floatval($_POST['load_time_ms'] ?? 0);
        $lcp         = floatval($_POST['lcp_ms'] ?? 0);
        $cls         = floatval($_POST['cls'] ?? 0);
        $fcp         = floatval($_POST['fcp_ms'] ?? 0);
        $memory_mb   = floatval($_POST['memory_mb'] ?? 0);
        $queries     = intval($_POST['query_count'] ?? 0);

        $ip = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '');
        $ua = sanitize_text_field(substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 250));

        global $wpdb;
        $wpdb->insert(
            $this->perf_table,
            array(
                'url'            => $url,
                'is_mobile'      => $is_mobile,
                'server_time_ms' => $server_time,
                'client_ttfb_ms' => $client_ttfb,
                'dom_ready_ms'   => $dom_ready,
                'load_time_ms'   => $load_time,
                'lcp_ms'         => $lcp,
                'cls'            => $cls,
                'fcp_ms'         => $fcp,
                'memory_mb'      => $memory_mb,
                'query_count'    => $queries,
                'ip'             => $ip,
                'user_agent'     => $ua,
                'created_at'     => current_time('mysql')
            ),
            array('%s', '%d', '%f', '%f', '%f', '%f', '%f', '%f', '%f', '%f', '%d', '%s', '%s', '%s')
        );

        // Keep maximum 200 recent rows to prevent table bloat
        $wpdb->query("DELETE FROM {$this->perf_table} WHERE id NOT IN (SELECT id FROM (SELECT id FROM {$this->perf_table} ORDER BY id DESC LIMIT 200) AS t)");

        $this->save_snapshot_report();

        wp_send_json_success();
    }

    /**
     * AJAX: Record Broken Asset Error
     */
    public function ajax_record_asset_error() {
        $target_url = isset($_POST['target_url']) ? esc_url_raw($_POST['target_url']) : '';
        if (empty($target_url)) {
            wp_send_json_error();
        }

        $page_url = isset($_POST['page_url']) ? esc_url_raw($_POST['page_url']) : '';
        $type = sanitize_text_field($_POST['error_type'] ?? 'asset_error');
        $msg = sanitize_text_field($_POST['message'] ?? 'Asset load failed');

        $this->record_error(array(
            'error_type'  => $type,
            'target_url'  => $target_url,
            'page_url'    => $page_url,
            'status_code' => 404,
            'message'     => $msg
        ));

        wp_send_json_success();
    }

    /**
     * Helper: Record error to DB
     */
    public function record_error($data) {
        global $wpdb;

        $target = esc_url_raw($data['target_url'] ?? '');
        $page = esc_url_raw($data['page_url'] ?? '');
        $type = sanitize_text_field($data['error_type'] ?? 'general_error');
        $code = intval($data['status_code'] ?? 404);
        $msg = sanitize_text_field($data['message'] ?? '');
        $ip = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '');
        $ua = sanitize_text_field(substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 250));

        // Deduplicate recent same error in last 5 minutes
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM {$this->error_table} WHERE target_url = %s AND created_at > DATE_SUB(NOW(), INTERVAL 5 MINUTE) LIMIT 1",
            $target
        ));

        if ($exists) {
            return;
        }

        $wpdb->insert(
            $this->error_table,
            array(
                'error_type'  => $type,
                'target_url'  => $target,
                'page_url'    => $page,
                'status_code' => $code,
                'message'     => $msg,
                'ip'          => $ip,
                'user_agent'  => $ua,
                'created_at'  => current_time('mysql')
            ),
            array('%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s')
        );

        // Keep maximum 150 error rows
        $wpdb->query("DELETE FROM {$this->error_table} WHERE id NOT IN (SELECT id FROM (SELECT id FROM {$this->error_table} ORDER BY id DESC LIMIT 150) AS t)");

        $this->save_snapshot_report();
    }

    /**
     * AJAX: Run On-Demand Audit on a Single Page
     */
    public function ajax_run_audit_page() {
        check_ajax_referer('tdclassic_diagnostics_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Unauthorized'));
        }

        $url = isset($_POST['url']) ? esc_url_raw($_POST['url']) : '';
        if (empty($url)) {
            wp_send_json_error(array('message' => 'URL is required'));
        }

        $start_time = microtime(true);
        $response = wp_remote_get($url, array(
            'timeout'     => 15,
            'sslverify'   => false,
            'redirection' => 5,
            'user-agent'  => 'Mozilla/5.0 (TDClassic Auditor; WordPress ' . get_bloginfo('version') . ')'
        ));
        $fetch_time_ms = round((microtime(true) - $start_time) * 1000, 1);

        if (is_wp_error($response)) {
            wp_send_json_error(array(
                'url'           => $url,
                'status'        => 'error',
                'error_message' => $response->get_error_message(),
                'time_ms'       => $fetch_time_ms
            ));
        }

        $status_code = wp_remote_retrieve_response_code($response);
        $headers = wp_remote_retrieve_headers($response);
        $body = wp_remote_retrieve_body($response);
        $body_size_kb = round(strlen($body) / 1024, 1);

        $server = $headers['server'] ?? 'Unknown';
        $content_encoding = $headers['content-encoding'] ?? 'none';
        $cache_control = $headers['cache-control'] ?? 'none';
        $litespeed_cache = $headers['x-litespeed-cache'] ?? ($headers['x-lsadc-cache'] ?? 'none');

        // Extract and audit linked assets (scripts, stylesheets, images)
        $broken_assets = array();
        $total_assets_checked = 0;

        // Find scripts
        preg_match_all('/<script\b[^>]*src=[\'"]([^\'"]+)[\'"]/i', $body, $script_matches);
        // Find styles
        preg_match_all('/<link\b[^>]*rel=[\'"]stylesheet[\'"][^>]*href=[\'"]([^\'"]+)[\'"]/i', $body, $style_matches);
        // Find images
        preg_match_all('/<img\b[^>]*src=[\'"]([^\'"]+)[\'"]/i', $body, $img_matches);

        $all_assets = array_unique(array_merge(
            $script_matches[1] ?? array(),
            $style_matches[1] ?? array(),
            $img_matches[1] ?? array()
        ));

        $site_domain = wp_parse_url(home_url(), PHP_URL_HOST);

        // Check local assets (limit to 25 assets to avoid excessive wait)
        $checked_count = 0;
        foreach ($all_assets as $asset_url) {
            if ($checked_count >= 25) break;

            // Normalize relative URLs
            if (strpos($asset_url, '//') === 0) {
                $asset_url = 'https:' . $asset_url;
            } elseif (strpos($asset_url, '/') === 0) {
                $asset_url = home_url($asset_url);
            }

            // Only check internal / local site assets
            $asset_host = wp_parse_url($asset_url, PHP_URL_HOST);
            if ($asset_host !== $site_domain) {
                continue;
            }

            // Skip data URIs or query-only
            if (strpos($asset_url, 'data:') === 0) {
                continue;
            }

            $checked_count++;
            $total_assets_checked++;

            $asset_res = wp_remote_head($asset_url, array('timeout' => 5, 'sslverify' => false));
            $asset_code = is_wp_error($asset_res) ? 0 : wp_remote_retrieve_response_code($asset_res);

            if ($asset_code >= 400 || $asset_code === 0) {
                $broken_assets[] = array(
                    'url'    => $asset_url,
                    'status' => $asset_code ?: 'Timeout / Failed',
                    'type'   => (strpos($asset_url, '.css') !== false ? 'CSS' : (strpos($asset_url, '.js') !== false ? 'JS' : 'Image'))
                );

                // Record into Error table
                $this->record_error(array(
                    'error_type'  => 'asset_404',
                    'target_url'  => $asset_url,
                    'page_url'    => $url,
                    'status_code' => $asset_code ?: 404,
                    'message'     => 'Asset audit phát hiện file lỗi'
                ));
            }
        }

        wp_send_json_success(array(
            'url'              => $url,
            'status_code'      => $status_code,
            'fetch_time_ms'    => $fetch_time_ms,
            'body_size_kb'     => $body_size_kb,
            'server'           => $server,
            'content_encoding' => $content_encoding,
            'cache_control'    => $cache_control,
            'litespeed_cache'  => $litespeed_cache,
            'assets_checked'   => $total_assets_checked,
            'broken_assets'    => $broken_assets
        ));
    }

    /**
     * AJAX: Clear Performance Logs
     */
    public function ajax_clear_perf_logs() {
        check_ajax_referer('tdclassic_diagnostics_nonce', 'nonce');
        if (!current_user_can('manage_options')) {
            wp_send_json_error();
        }

        global $wpdb;
        $wpdb->query("TRUNCATE TABLE {$this->perf_table}");
        $this->save_snapshot_report();
        wp_send_json_success();
    }

    /**
     * AJAX: Clear Error Logs
     */
    public function ajax_clear_error_logs() {
        check_ajax_referer('tdclassic_diagnostics_nonce', 'nonce');
        if (!current_user_can('manage_options')) {
            wp_send_json_error();
        }

        global $wpdb;
        $wpdb->query("TRUNCATE TABLE {$this->error_table}");
        $this->save_snapshot_report();
        wp_send_json_success();
    }

    /**
     * AJAX: Export Diagnostics Data
     */
    public function ajax_export_diagnostics() {
        check_ajax_referer('tdclassic_diagnostics_nonce', 'nonce');
        if (!current_user_can('manage_options')) {
            wp_send_json_error();
        }

        $report = $this->generate_full_report();
        wp_send_json_success($report);
    }

    /**
     * Generate Full Report Array
     */
    public function generate_full_report() {
        global $wpdb;

        // Host Info
        $host_info = $this->get_host_specs();

        // Speed Metrics Summary
        $perf_stats = $wpdb->get_row("SELECT 
            COUNT(*) as total_samples,
            AVG(server_time_ms) as avg_server_ms,
            AVG(client_ttfb_ms) as avg_ttfb_ms,
            AVG(dom_ready_ms) as avg_dom_ms,
            AVG(load_time_ms) as avg_load_ms,
            AVG(lcp_ms) as avg_lcp_ms,
            AVG(cls) as avg_cls,
            MAX(load_time_ms) as max_load_ms
        FROM {$this->perf_table}");

        // Slowest 5 URLs
        $slowest_pages = $wpdb->get_results("SELECT 
            url, 
            AVG(load_time_ms) as avg_load, 
            AVG(server_time_ms) as avg_server, 
            COUNT(*) as hits 
        FROM {$this->perf_table} 
        GROUP BY url 
        ORDER BY avg_load DESC 
        LIMIT 5", ARRAY_A);

        // Recent 15 errors
        $recent_errors = $wpdb->get_results("SELECT 
            error_type, target_url, page_url, status_code, message, created_at 
        FROM {$this->error_table} 
        ORDER BY id DESC 
        LIMIT 15", ARRAY_A);

        return array(
            'generated_at'   => current_time('mysql'),
            'site_url'       => home_url('/'),
            'host_specs'     => $host_info,
            'performance'    => array(
                'total_samples'  => intval($perf_stats->total_samples ?? 0),
                'avg_server_ms'  => round(floatval($perf_stats->avg_server_ms ?? 0), 1),
                'avg_client_ttfb_ms' => round(floatval($perf_stats->avg_ttfb_ms ?? 0), 1),
                'avg_dom_ready_ms'   => round(floatval($perf_stats->avg_dom_ms ?? 0), 1),
                'avg_load_time_ms'   => round(floatval($perf_stats->avg_load_ms ?? 0), 1),
                'avg_lcp_ms'         => round(floatval($perf_stats->avg_lcp_ms ?? 0), 1),
                'avg_cls'            => round(floatval($perf_stats->avg_cls ?? 0), 3),
                'slowest_pages'      => $slowest_pages
            ),
            'errors'         => array(
                'total_logged'   => $wpdb->get_var("SELECT COUNT(*) FROM {$this->error_table}"),
                'recent_errors'  => $recent_errors
            )
        );
    }

    /**
     * Save Snapshot Report to File for AI inspection
     */
    public function save_snapshot_report() {
        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['basedir'] . '/tdclassic-diagnostics-report.json';

        $report = $this->generate_full_report();
        @file_put_contents($file_path, wp_json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Get Host Specs
     */
    public function get_host_specs() {
        global $wpdb;

        // DB benchmark (ping)
        $db_start = microtime(true);
        $wpdb->query("SELECT 1");
        $db_latency_ms = round((microtime(true) - $db_start) * 1000, 2);

        // Loopback internal cURL check
        $loop_start = microtime(true);
        $loop_res = wp_remote_get(home_url('/'), array('timeout' => 5, 'sslverify' => false));
        $loop_time_ms = round((microtime(true) - $loop_start) * 1000, 1);
        $loop_status = is_wp_error($loop_res) ? 'Lỗi: ' . $loop_res->get_error_message() : (wp_remote_retrieve_response_code($loop_res) . ' OK');

        // OPcache info
        $opcache_enabled = function_exists('opcache_get_status') && !empty(opcache_get_status(false)['opcache_enabled']);
        $opcache_memory = 0;
        if ($opcache_enabled) {
            $op_status = opcache_get_status(false);
            $opcache_memory = round(($op_status['memory_usage']['used_memory'] ?? 0) / 1048576, 1);
        }

        // Active plugins
        $active_plugins = get_option('active_plugins', array());

        return array(
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'server_ip'       => $_SERVER['SERVER_ADDR'] ?? ($_SERVER['LOCAL_ADDR'] ?? 'Unknown'),
            'php_version'     => PHP_VERSION,
            'php_memory_limit'=> ini_get('memory_limit'),
            'wp_memory_limit' => WP_MEMORY_LIMIT,
            'max_execution_time' => ini_get('max_execution_time') . 's',
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size'   => ini_get('post_max_size'),
            'mysql_version'   => $wpdb->db_version(),
            'db_latency_ms'   => $db_latency_ms,
            'loopback_test'   => array('status' => $loop_status, 'time_ms' => $loop_time_ms),
            'opcache'         => array('enabled' => $opcache_enabled, 'used_memory_mb' => $opcache_memory),
            'litespeed_cache_plugin' => in_array('litespeed-cache/litespeed-cache.php', $active_plugins),
            'active_plugins_count'   => count($active_plugins),
            'active_plugins_list'    => $active_plugins
        );
    }

    /**
     * Render Admin Dashboard Page
     */
    public function render_admin_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        global $wpdb;

        $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'overview';
        $host_specs = $this->get_host_specs();

        // Fetch Perf stats
        $perf_summary = $wpdb->get_row("SELECT 
            COUNT(*) as total_samples,
            AVG(server_time_ms) as avg_server_ms,
            AVG(client_ttfb_ms) as avg_ttfb_ms,
            AVG(dom_ready_ms) as avg_dom_ms,
            AVG(load_time_ms) as avg_load_ms,
            AVG(lcp_ms) as avg_lcp_ms,
            AVG(cls) as avg_cls
        FROM {$this->perf_table}");

        $total_errors = $wpdb->get_var("SELECT COUNT(*) FROM {$this->error_table}");

        // Recent perf logs
        $recent_perf = $wpdb->get_results("SELECT * FROM {$this->perf_table} ORDER BY id DESC LIMIT 50");

        // Recent errors
        $recent_errors = $wpdb->get_results("SELECT * FROM {$this->error_table} ORDER BY id DESC LIMIT 50");
        ?>
        <div class="wrap td-diag-wrap">
            <header class="td-diag-header">
                <div class="td-diag-header-title">
                    <span class="dashicons dashicons-performance td-diag-icon"></span>
                    <div>
                        <h1>Hệ Thống Giám Sát Hiệu Năng & Lỗi Host</h1>
                        <p class="description">Theo dõi trực quan tốc độ tải trang thực tế, bắt lỗi file 404/hỏng và chẩn đoán cấu hình máy chủ web.</p>
                    </div>
                </div>
                <div class="td-diag-header-actions">
                    <button type="button" id="btn-copy-ai-report" class="button button-primary">
                        <span class="dashicons dashicons-clipboard"></span> Copy Báo Cáo Cho AI
                    </button>
                    <button type="button" id="btn-export-json" class="button button-secondary">
                        <span class="dashicons dashicons-download"></span> Tải JSON Debug
                    </button>
                </div>
            </header>

            <!-- Navigation Tabs -->
            <nav class="nav-tab-wrapper td-diag-tabs">
                <a href="?page=tdclassic-diagnostics&tab=overview" class="nav-tab <?php echo $active_tab === 'overview' ? 'nav-tab-active' : ''; ?>">
                    <span class="dashicons dashicons-admin-generic"></span> 1. Cấu Hình Host & Server
                </a>
                <a href="?page=tdclassic-diagnostics&tab=speed" class="nav-tab <?php echo $active_tab === 'speed' ? 'nav-tab-active' : ''; ?>">
                    <span class="dashicons dashicons-dashboard"></span> 2. Tốc Độ Tải Trang Thực Tế (<?php echo intval($perf_summary->total_samples ?? 0); ?>)
                </a>
                <a href="?page=tdclassic-diagnostics&tab=errors" class="nav-tab <?php echo $active_tab === 'errors' ? 'nav-tab-active' : ''; ?>">
                    <span class="dashicons dashicons-warning"></span> 3. Bắt Lỗi & File Hỏng (<?php echo intval($total_errors); ?>)
                </a>
                <a href="?page=tdclassic-diagnostics&tab=audit" class="nav-tab <?php echo $active_tab === 'audit' ? 'nav-tab-active' : ''; ?>">
                    <span class="dashicons dashicons-search"></span> 4. Chẩn Đoán Tức Thì (1-Click Audit)
                </a>
            </nav>

            <div class="td-diag-content">

                <?php if ($active_tab === 'overview'): ?>
                    <!-- TAB 1: HOST & SERVER OVERVIEW -->
                    <div class="td-card-grid">
                        <div class="td-diag-card">
                            <h3><span class="dashicons dashicons-cloud"></span> Máy Chủ Web (Web Server)</h3>
                            <table class="td-diag-table-mini">
                                <tr>
                                    <td>Phần mềm Server:</td>
                                    <td><strong><?php echo esc_html($host_specs['server_software']); ?></strong></td>
                                </tr>
                                <tr>
                                    <td>IP Máy chủ:</td>
                                    <td><code><?php echo esc_html($host_specs['server_ip']); ?></code></td>
                                </tr>
                                <tr>
                                    <td>LiteSpeed Cache Plugin:</td>
                                    <td>
                                        <?php if ($host_specs['litespeed_cache_plugin']): ?>
                                            <span class="td-badge td-badge-success">Đã kích hoạt</span>
                                        <?php else: ?>
                                            <span class="td-badge td-badge-warning">Chưa cài LiteSpeed Cache</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tự kiểm tra Loopback (Internal ping):</td>
                                    <td>
                                        <span class="td-badge td-badge-info"><?php echo esc_html($host_specs['loopback_test']['status']); ?> (<?php echo esc_html($host_specs['loopback_test']['time_ms']); ?>ms)</span>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="td-diag-card">
                            <h3><span class="dashicons dashicons-admin-tools"></span> Môi Trường PHP & Bộ Nhớ</h3>
                            <table class="td-diag-table-mini">
                                <tr>
                                    <td>Phiên bản PHP:</td>
                                    <td><strong>PHP <?php echo esc_html($host_specs['php_version']); ?></strong></td>
                                </tr>
                                <tr>
                                    <td>PHP Memory Limit:</td>
                                    <td><strong><?php echo esc_html($host_specs['php_memory_limit']); ?></strong> (WP: <?php echo esc_html($host_specs['wp_memory_limit']); ?>)</td>
                                </tr>
                                <tr>
                                    <td>Max Execution Time:</td>
                                    <td><?php echo esc_html($host_specs['max_execution_time']); ?></td>
                                </tr>
                                <tr>
                                    <td>OPcache:</td>
                                    <td>
                                        <?php if ($host_specs['opcache']['enabled']): ?>
                                            <span class="td-badge td-badge-success">Bật (<?php echo esc_html($host_specs['opcache']['used_memory_mb']); ?> MB RAM)</span>
                                        <?php else: ?>
                                            <span class="td-badge td-badge-danger">Tắt</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="td-diag-card">
                            <h3><span class="dashicons dashicons-database"></span> Cơ Sở Dữ Liệu MySQL</h3>
                            <table class="td-diag-table-mini">
                                <tr>
                                    <td>Phiên bản MySQL/MariaDB:</td>
                                    <td><strong><?php echo esc_html($host_specs['mysql_version']); ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Độ trễ truy vấn (Ping latency):</td>
                                    <td>
                                        <strong class="<?php echo $host_specs['db_latency_ms'] < 5 ? 'td-text-success' : 'td-text-warning'; ?>">
                                            <?php echo esc_html($host_specs['db_latency_ms']); ?> ms
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Số plugin đang chạy:</td>
                                    <td><?php echo intval($host_specs['active_plugins_count']); ?> plugins</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Host Explanation Card -->
                    <div class="td-diag-card td-mt-4">
                        <h3><span class="dashicons dashicons-info"></span> Hướng Dẫn & Đánh Giá Tương Thích Host</h3>
                        <p>Dữ liệu trên phản ánh chính xác cấu hình phần cứng và phần mềm của Host nơi website đang chạy. Bạn có thể bấm nút <strong>"Copy Báo Cáo Cho AI"</strong> ở góc trên bên phải để gửi thông tin này cho AI khi cần debug các vấn đề giật lag, timeout hoặc tối ưu chuyên sâu.</p>
                        <ul class="td-spec-list">
                            <li><strong>PHP Memory Limit:</strong> Khuyến nghị từ <strong>256M</strong> trở lên để WooCommerce và cache template chạy tối đa hiệu năng.</li>
                            <li><strong>OPcache:</strong> Cực kỳ quan trọng trên Hosting thực tế, giúp lưu mã nhị phân PHP compiled vào RAM và tăng tốc TTFB gấp 3-5 lần.</li>
                            <li><strong>Loopback Ping:</strong> Đo thời gian host tự kết nối với chính mình. Nếu dưới <strong>200ms</strong> là server phản hồi rất nhanh; nếu trên <strong>1000ms</strong> hoặc timeout có nghĩa firewall host đang chặn loopback hoặc DNS host bị chậm.</li>
                        </ul>
                    </div>

                <?php elseif ($active_tab === 'speed'): ?>
                    <!-- TAB 2: SPEED LOGS (RUM) -->
                    <div class="td-stat-banner">
                        <div class="td-stat-box">
                            <span class="td-stat-label">Thời gian Server sinh HTML (TTFB)</span>
                            <span class="td-stat-value td-text-primary"><?php echo round(floatval($perf_summary->avg_server_ms ?? 0)); ?> ms</span>
                            <span class="td-stat-sub">Mục tiêu: < 300ms</span>
                        </div>
                        <div class="td-stat-box">
                            <span class="td-stat-label">Thời gian Client TTFB</span>
                            <span class="td-stat-value td-text-info"><?php echo round(floatval($perf_summary->avg_ttfb_ms ?? 0)); ?> ms</span>
                            <span class="td-stat-sub">Bao gồm mạng + DNS + Host</span>
                        </div>
                        <div class="td-stat-box">
                            <span class="td-stat-label">DOM Ready (Khung giao diện)</span>
                            <span class="td-stat-value td-text-warning"><?php echo round(floatval($perf_summary->avg_dom_ms ?? 0)); ?> ms</span>
                            <span class="td-stat-sub">Mục tiêu: < 1200ms</span>
                        </div>
                        <div class="td-stat-box">
                            <span class="td-stat-label">Tải Hoàn Tất (Window Load)</span>
                            <span class="td-stat-value <?php echo (floatval($perf_summary->avg_load_ms ?? 0) < 2500) ? 'td-text-success' : 'td-text-danger'; ?>">
                                <?php echo round(floatval($perf_summary->avg_load_ms ?? 0)); ?> ms
                            </span>
                            <span class="td-stat-sub">Toàn bộ ảnh, CSS, JS</span>
                        </div>
                        <div class="td-stat-box">
                            <span class="td-stat-label">Core Web Vitals LCP</span>
                            <span class="td-stat-value <?php echo (floatval($perf_summary->avg_lcp_ms ?? 0) < 2500) ? 'td-text-success' : 'td-text-danger'; ?>">
                                <?php echo round(floatval($perf_summary->avg_lcp_ms ?? 0) / 1000, 2); ?> s
                            </span>
                            <span class="td-stat-sub">Google Xanh: < 2.5s</span>
                        </div>
                    </div>

                    <div class="td-diag-card td-mt-4">
                        <div class="td-card-header-flex">
                            <h3><span class="dashicons dashicons-list-view"></span> Lịch Sử Tải Trang Gần Nhất (50 lần truy cập)</h3>
                            <button type="button" id="btn-clear-perf" class="button button-link-delete">
                                <span class="dashicons dashicons-trash"></span> Xóa Lịch Sử Tốc Độ
                            </button>
                        </div>
                        <div class="td-table-responsive">
                            <table class="wp-list-table widefat fixed striped">
                                <thead>
                                    <tr>
                                        <th style="width: 250px;">Đường Dẫn (URL)</th>
                                        <th style="width: 80px;">Thiết bị</th>
                                        <th style="width: 100px;">Server TTFB</th>
                                        <th style="width: 100px;">Client TTFB</th>
                                        <th style="width: 100px;">DOM Ready</th>
                                        <th style="width: 100px;">Load Time</th>
                                        <th style="width: 90px;">LCP</th>
                                        <th style="width: 80px;">CLS</th>
                                        <th style="width: 90px;">RAM / SQL</th>
                                        <th style="width: 130px;">Thời Gian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($recent_perf)): ?>
                                        <tr>
                                            <td colspan="10" class="td-text-center">Chưa có dữ liệu đo tốc độ. Hãy mở trang ngoài website để ghi nhận lần đầu tiên!</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($recent_perf as $row): ?>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo esc_url($row->url); ?>" target="_blank" class="td-link-url">
                                                        <?php echo esc_html(wp_parse_url($row->url, PHP_URL_PATH) ?: '/'); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php if ($row->is_mobile): ?>
                                                        <span class="td-badge td-badge-info">📱 Mobile</span>
                                                    <?php else: ?>
                                                        <span class="td-badge td-badge-secondary">💻 PC</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><strong><?php echo esc_html(round($row->server_time_ms)); ?> ms</strong></td>
                                                <td><?php echo esc_html(round($row->client_ttfb_ms)); ?> ms</td>
                                                <td><?php echo esc_html(round($row->dom_ready_ms)); ?> ms</td>
                                                <td>
                                                    <span class="td-badge <?php echo $row->load_time_ms < 2000 ? 'td-badge-success' : ($row->load_time_ms < 4000 ? 'td-badge-warning' : 'td-badge-danger'); ?>">
                                                        <?php echo esc_html(round($row->load_time_ms)); ?> ms
                                                    </span>
                                                </td>
                                                <td><?php echo $row->lcp_ms > 0 ? (round($row->lcp_ms / 1000, 2) . 's') : '-'; ?></td>
                                                <td><?php echo esc_html($row->cls); ?></td>
                                                <td><small><?php echo esc_html($row->memory_mb); ?>MB / <?php echo intval($row->query_count); ?>q</small></td>
                                                <td><small><?php echo esc_html($row->created_at); ?></small></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?php elseif ($active_tab === 'errors'): ?>
                    <!-- TAB 3: ERRORS & BROKEN ASSETS -->
                    <div class="td-diag-card">
                        <div class="td-card-header-flex">
                            <h3><span class="dashicons dashicons-dismiss"></span> Danh Sách File Hỏng & Lỗi 404 Đã Ghi Nhận</h3>
                            <button type="button" id="btn-clear-errors" class="button button-link-delete">
                                <span class="dashicons dashicons-trash"></span> Xóa Lịch Sử Lỗi
                            </button>
                        </div>
                        <p class="description">Hệ thống tự động phát hiện khi trình duyệt người dùng gặp lỗi không tải được CSS, JavaScript, Hình ảnh hoặc các đường dẫn 404.</p>

                        <div class="td-table-responsive td-mt-3">
                            <table class="wp-list-table widefat fixed striped">
                                <thead>
                                    <tr>
                                        <th style="width: 110px;">Loại Lỗi</th>
                                        <th>File / URL Bị Hỏng</th>
                                        <th>Trang Gặp Lỗi</th>
                                        <th style="width: 80px;">Mã HTTP</th>
                                        <th style="width: 140px;">Thời Gian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($recent_errors)): ?>
                                        <tr>
                                            <td colspan="5" class="td-text-center td-text-success">
                                                <span class="dashicons dashicons-yes-alt"></span> Tuyệt vời! Hiện không có file nào bị lỗi 404 hoặc hỏng.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($recent_errors as $err): ?>
                                            <tr>
                                                <td>
                                                    <span class="td-badge <?php echo strpos($err->error_type, 'load_error') !== false ? 'td-badge-danger' : 'td-badge-warning'; ?>">
                                                        <?php echo esc_html($err->error_type); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <code class="td-code-broken"><?php echo esc_html($err->target_url); ?></code>
                                                    <?php if ($err->message): ?>
                                                        <div class="td-sub-msg"><?php echo esc_html($err->message); ?></div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo esc_url($err->page_url); ?>" target="_blank">
                                                        <?php echo esc_html(wp_parse_url($err->page_url, PHP_URL_PATH) ?: $err->page_url); ?>
                                                    </a>
                                                </td>
                                                <td><span class="td-badge td-badge-danger"><?php echo intval($err->status_code); ?></span></td>
                                                <td><small><?php echo esc_html($err->created_at); ?></small></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?php elseif ($active_tab === 'audit'): ?>
                    <!-- TAB 4: 1-CLICK AUDIT -->
                    <div class="td-diag-card">
                        <div class="td-card-header-flex">
                            <div>
                                <h3><span class="dashicons dashicons-search"></span> Chẩn Đoán Toàn Bộ Trang Chính & Quét File Hỏng</h3>
                                <p class="description">Công cụ sẽ quét lần lượt các trang trọng yếu, đo tốc độ phản hồi từ Host (TTFB) và kiểm tra toàn bộ CSS, JS, Ảnh xem có file nào bị 404 không.</p>
                            </div>
                            <button type="button" id="btn-start-full-audit" class="button button-primary button-hero">
                                <span class="dashicons dashicons-controls-play"></span> Bắt Đầu Chẩn Đoán Ngay
                            </button>
                        </div>

                        <!-- Progress Bar -->
                        <div id="td-audit-progress-container" class="td-progress-wrap" style="display: none;">
                            <div class="td-progress-bar">
                                <div id="td-audit-progress-fill" class="td-progress-fill" style="width: 0%;"></div>
                            </div>
                            <span id="td-audit-status-text" class="td-progress-text">Đang chuẩn bị...</span>
                        </div>

                        <!-- Results Table -->
                        <div class="td-table-responsive td-mt-4">
                            <table class="wp-list-table widefat fixed striped" id="td-audit-results-table">
                                <thead>
                                    <tr>
                                        <th style="width: 180px;">Trang Kiểm Tra</th>
                                        <th style="width: 90px;">Mã HTTP</th>
                                        <th style="width: 120px;">Tốc Độ (TTFB)</th>
                                        <th style="width: 100px;">Dung Lượng</th>
                                        <th style="width: 100px;">Nén Gzip</th>
                                        <th style="width: 120px;">LiteSpeed Cache</th>
                                        <th>File Kiểm Tra & Lỗi Phát Hiện</th>
                                    </tr>
                                </thead>
                                <tbody id="td-audit-results-body">
                                    <tr>
                                        <td colspan="7" class="td-text-center">Bấm nút "Bắt Đầu Chẩn Đoán Ngay" để quét tự động toàn bộ website.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Modal / Notification Toast -->
            <div id="td-toast" class="td-toast" style="display: none;"></div>
        </div>
        <?php
    }
}

// Instantiate
TD_Classic_Diagnostics::get_instance();
