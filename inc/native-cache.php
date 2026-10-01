<?php
/**
 * TD Classic Native HTML Page Cache (Code Tay 100% - Zero Plugin)
 * Tự động tạo bản tĩnh HTML siêu nhẹ giúp đưa TTFB về 20ms - 50ms mà không cần bất kỳ plugin nào.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class TD_Classic_Native_Cache {

    private static $instance = null;
    private $cache_dir = '';

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->cache_dir = WP_CONTENT_DIR . '/cache/tdclassic';

        // Start caching on frontend
        add_action('template_redirect', array($this, 'maybe_serve_or_capture_cache'), 0);

        // Auto purge on content changes
        add_action('save_post', array($this, 'purge_cache'));
        add_action('edit_terms', array($this, 'purge_cache'));
        add_action('switch_theme', array($this, 'purge_cache'));

        // AJAX Purge from Admin
        add_action('wp_ajax_tdclassic_purge_native_cache', array($this, 'ajax_purge_cache'));
    }

    /**
     * Check if current request can be cached
     */
    private function can_cache() {
        if (is_admin() || is_user_logged_in()) {
            return false;
        }

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'HEAD') {
            return false;
        }

        // Skip WooCommerce dynamic pages
        if (function_exists('is_cart') && is_cart()) return false;
        if (function_exists('is_checkout') && is_checkout()) return false;
        if (function_exists('is_account_page') && is_account_page()) return false;

        // Skip WP Login & Admin
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        if (strpos($uri, 'wp-login.php') !== false || strpos($uri, 'wp-admin') !== false) {
            return false;
        }

        // Skip search or non-pagination query strings
        if (!empty($_GET)) {
            $allowed_keys = array('page', 'paged');
            foreach (array_keys($_GET) as $key) {
                if (!in_array($key, $allowed_keys, true)) {
                    return false;
                }
            }
        }

        return true;
    }

    private function ensure_cache_dir() {
        if (empty($this->cache_dir)) {
            $upload_dir = wp_upload_dir();
            $this->cache_dir = $upload_dir['basedir'] . '/tdclassic-cache';
        }
        if (!is_dir($this->cache_dir)) {
            @mkdir($this->cache_dir, 0755, true);
        }
    }

    /**
     * Get unique cache key for current request
     */
    private function get_cache_file() {
        $this->ensure_cache_dir();
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $uri  = $_SERVER['REQUEST_URI'] ?? '/';
        $is_mobile = wp_is_mobile() ? '_mob' : '_desk';
        
        $hash = md5($host . '|' . $uri . '|' . $is_mobile);
        return $this->cache_dir . '/' . $hash . '.html';
    }

    /**
     * Serve cache if fresh, or capture output
     */
    public function maybe_serve_or_capture_cache() {
        if (!$this->can_cache()) {
            return;
        }

        $cache_file = $this->get_cache_file();

        // 1. SERVE CACHE IF AVAILABLE & FRESH (24h)
        if (file_exists($cache_file) && (time() - filemtime($cache_file) < 86400)) {
            $cached_html = @file_get_contents($cache_file);
            if (!empty($cached_html) && strlen($cached_html) > 1000) {
                if (!headers_sent()) {
                    header('Content-Type: text/html; charset=UTF-8');
                    header('X-TDClassic-Cache: HIT (Code Tay)');
                }
                echo $cached_html;
                echo "\n<!-- TD Classic Native Cache HIT: " . date('Y-m-d H:i:s', filemtime($cache_file)) . " -->";
                exit;
            }
        }

        // 2. CAPTURE & SAVE CACHE
        ob_start(array($this, 'capture_and_save_cache'));
    }

    /**
     * Output buffer callback to save HTML
     */
    public function capture_and_save_cache($buffer) {
        // Only cache valid 200 OK HTML responses with real content
        if (strlen($buffer) > 1000 && http_response_code() === 200) {
            $this->ensure_cache_dir();
            $cache_file = $this->get_cache_file();
            @file_put_contents($cache_file, $buffer);
        }
        return $buffer;
    }

    /**
     * Purge all native cache files
     */
    public function purge_cache() {
        $this->ensure_cache_dir();
        if (is_dir($this->cache_dir)) {
            $files = glob($this->cache_dir . '/*.html');
            if ($files) {
                foreach ($files as $file) {
                    if (is_file($file)) {
                        @unlink($file);
                    }
                }
            }
        }
    }

    /**
     * AJAX Purge Cache
     */
    public function ajax_purge_cache() {
        check_ajax_referer('tdclassic_diagnostics_nonce', 'nonce');
        if (!current_user_can('manage_options')) {
            wp_send_json_error();
        }

        $this->purge_cache();
        wp_send_json_success(array('message' => 'Đã xóa toàn bộ cache HTML code tay!'));
    }

    /**
     * Get Cache Stats (files count & total size)
     */
    public function get_stats() {
        $this->ensure_cache_dir();
        $count = 0;
        $size_bytes = 0;

        if (is_dir($this->cache_dir)) {
            $files = glob($this->cache_dir . '/*.html');
            if ($files) {
                $count = count($files);
                foreach ($files as $file) {
                    $size_bytes += filesize($file);
                }
            }
        }

        return array(
            'count'    => $count,
            'size_mb'  => round($size_bytes / 1048576, 2)
        );
    }
}

// Instantiate
TD_Classic_Native_Cache::get_instance();
