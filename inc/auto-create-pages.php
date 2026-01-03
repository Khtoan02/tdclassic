<?php
/**
 * Auto Create Required Pages
 * 
 * Tự động tạo các trang cần thiết cho website nếu chưa tồn tại
 * File này được include trong functions.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Tạo các trang cần thiết khi theme được kích hoạt hoặc khi admin truy cập
 */
function tdclassic_create_required_pages()
{
    // Chỉ chạy trong admin hoặc khi theme được kích hoạt
    if (!is_admin() && !did_action('after_switch_theme')) {
        return;
    }

    // Danh sách các trang cần tạo
    $pages = [
        [
            'title' => 'Giới thiệu',
            'slug' => 'gioi-thieu',
            'template' => 'page-gioi-thieu.php',
            'content' => '<!-- Nội dung được render từ template page-gioi-thieu.php -->',
        ],
        [
            'title' => 'Blog',
            'slug' => 'blog',
            'template' => 'page-blog.php',
            'content' => '<!-- Nội dung được render từ template page-blog.php -->',
        ],
        [
            'title' => 'Tin tức',
            'slug' => 'tin-tuc',
            'template' => 'page-tin-tuc.php',
            'content' => '<!-- Nội dung được render từ template page-tin-tuc.php -->',
        ],
        [
            'title' => 'Hồ sơ năng lực',
            'slug' => 'ho-so-nang-luc',
            'template' => 'page-ho-so-nang-luc.php',
            'content' => '<!-- Nội dung được render từ template page-ho-so-nang-luc.php -->',
        ],
        [
            'title' => 'Liên hệ',
            'slug' => 'lien-he',
            'template' => 'page-lien-he.php',
            'content' => '<!-- Nội dung được render từ template page-lien-he.php -->',
        ],
        [
            'title' => 'Sản phẩm',
            'slug' => 'san-pham',
            'template' => 'page-san-pham.php',
            'content' => '<!-- Nội dung được render từ template page-san-pham.php -->',
        ],
        [
            'title' => 'Đại lý',
            'slug' => 'dai-ly',
            'template' => 'page-dai-ly.php',
            'content' => '<!-- Nội dung được render từ template page-dai-ly.php -->',
        ],
    ];

    $created_pages = [];

    foreach ($pages as $page_data) {
        // Kiểm tra xem trang đã tồn tại chưa (bằng slug)
        $existing_page = get_page_by_path($page_data['slug']);

        if ($existing_page) {
            // Trang đã tồn tại, kiểm tra và cập nhật template nếu cần
            $current_template = get_post_meta($existing_page->ID, '_wp_page_template', true);
            if ($current_template !== $page_data['template']) {
                update_post_meta($existing_page->ID, '_wp_page_template', $page_data['template']);
            }
            continue;
        }

        // Tạo trang mới
        $page_id = wp_insert_post([
            'post_title' => $page_data['title'],
            'post_name' => $page_data['slug'],
            'post_content' => $page_data['content'],
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_author' => 1,
            'comment_status' => 'closed',
            'ping_status' => 'closed',
        ]);

        if ($page_id && !is_wp_error($page_id)) {
            // Set page template
            update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            $created_pages[] = $page_data['title'];
        }
    }

    // Hiển thị thông báo nếu có trang được tạo
    if (!empty($created_pages) && is_admin()) {
        add_action('admin_notices', function () use ($created_pages) {
            $pages_list = implode(', ', $created_pages);
            echo '<div class="notice notice-success is-dismissible">';
            echo '<p><strong>TD Classic:</strong> Đã tự động tạo các trang: ' . esc_html($pages_list) . '</p>';
            echo '</div>';
        });
    }

    return $created_pages;
}

// Hook vào admin_init để chạy khi admin truy cập
add_action('admin_init', 'tdclassic_create_required_pages');

// Hook vào after_switch_theme để chạy khi theme được kích hoạt
add_action('after_switch_theme', 'tdclassic_create_required_pages');

/**
 * Thêm nút "Tạo trang còn thiếu" trong admin menu
 */
function tdclassic_add_create_pages_menu()
{
    add_submenu_page(
        'themes.php',
        'Tạo trang TD Classic',
        'Tạo trang TD Classic',
        'manage_options',
        'tdclassic-create-pages',
        'tdclassic_create_pages_admin_page'
    );
}
add_action('admin_menu', 'tdclassic_add_create_pages_menu');

/**
 * Trang admin để tạo pages
 */
function tdclassic_create_pages_admin_page()
{
    ?>
    <div class="wrap">
        <h1>Tạo trang TD Classic</h1>

        <?php
        // Xử lý khi form được submit
        if (
            isset($_POST['tdclassic_create_pages_nonce']) &&
            wp_verify_nonce($_POST['tdclassic_create_pages_nonce'], 'tdclassic_create_pages')
        ) {

            $created = tdclassic_create_required_pages();

            if (!empty($created)) {
                echo '<div class="notice notice-success"><p>Đã tạo các trang: <strong>' . esc_html(implode(', ', $created)) . '</strong></p></div>';
            } else {
                echo '<div class="notice notice-info"><p>Tất cả các trang đã tồn tại.</p></div>';
            }
        }
        ?>

        <p>Click nút bên dưới để tự động tạo các trang cần thiết cho theme TD Classic:</p>

        <form method="post">
            <?php wp_nonce_field('tdclassic_create_pages', 'tdclassic_create_pages_nonce'); ?>
            <p>
                <button type="submit" class="button button-primary button-hero">
                    🚀 Tạo/Kiểm tra các trang
                </button>
            </p>
        </form>

        <hr>

        <h2>Danh sách trang sẽ được tạo:</h2>
        <table class="widefat striped">
            <thead>
                <tr>
                    <th>Trang</th>
                    <th>Slug</th>
                    <th>Template</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $pages_to_check = [
                    ['Giới thiệu', 'gioi-thieu', 'page-gioi-thieu.php'],
                    ['Blog', 'blog', 'page-blog.php'],
                    ['Tin tức', 'tin-tuc', 'page-tin-tuc.php'],
                    ['Hồ sơ năng lực', 'ho-so-nang-luc', 'page-ho-so-nang-luc.php'],
                    ['Liên hệ', 'lien-he', 'page-lien-he.php'],
                    ['Sản phẩm', 'san-pham', 'page-san-pham.php'],
                    ['Đại lý', 'dai-ly', 'page-dai-ly.php'],
                ];

                foreach ($pages_to_check as $page) {
                    $existing = get_page_by_path($page[1]);
                    $status = $existing ? '<span style="color: green;">✅ Đã có</span>' : '<span style="color: red;">❌ Chưa có</span>';
                    $link = $existing ? '<a href="' . get_permalink($existing->ID) . '" target="_blank">Xem</a>' : '';
                    echo '<tr>';
                    echo '<td>' . esc_html($page[0]) . '</td>';
                    echo '<td><code>/' . esc_html($page[1]) . '/</code></td>';
                    echo '<td><code>' . esc_html($page[2]) . '</code></td>';
                    echo '<td>' . $status . ' ' . $link . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}
