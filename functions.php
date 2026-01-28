<?php
/**
 * TD Classic Theme Functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// === PERFORMANCE OPTIMIZATIONS ===

// 1. Cleanup WP Head (Remove Emojis, Embeds, etc.)
function tdclassic_minimize_wp_head()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    // Remove WP Embed
    if (!is_admin()) {
        wp_deregister_script('wp-embed');
    }
}
add_action('init', 'tdclassic_minimize_wp_head');

// 2. Add Preconnect/Preload Headers
function tdclassic_resource_hints($urls, $relation_type)
{
    if (wp_style_is('google-fonts', 'queue') && 'preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
            'crossorigin' => 'anonymous',
        );
        $urls[] = array(
            'href' => 'https://cdn.jsdelivr.net',
            'crossorigin' => 'anonymous',
        );
        $urls[] = array(
            'href' => 'https://cdn.tailwindcss.com',
            'crossorigin' => 'anonymous',
        );
    }
    return $urls;
}
add_filter('wp_resource_hints', 'tdclassic_resource_hints', 10, 2);

// 3. Defer Javascripts (Non-critical)
function tdclassic_defer_scripts($tag, $handle)
{
    // List of scripts to defer
    $defer_scripts = array(
        'bootstrap-js',
        'font-awesome',
        'lucide-icons',
        'tdclassic-main',
        'tdclassic-mega-menu',
        'tdclassic-carousel',
        'tdclassic-counter',
        'tdclassic-front-page',
        'tdclassic-partner-slider'
    );

    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }

    return $tag;
}
add_filter('script_loader_tag', 'tdclassic_defer_scripts', 10, 2);

// Include admin product specifications
require_once get_template_directory() . '/inc/admin-product-specs.php';

// Include consultation manager
require_once get_template_directory() . '/inc/admin-consultation-manager.php';

// Include company information management
require_once get_template_directory() . '/inc/admin-company-info.php';

// Include auto-create pages functionality
require_once get_template_directory() . '/inc/auto-create-pages.php';

/**
 * Get WooCommerce product categories with images and descriptions
 * Unified function that can be used for both front-page and mega menu
 * 
 * @param int $limit Number of categories to return
 * @param bool $hide_empty Whether to hide empty categories
 * @param bool $include_image Whether to include category image
 * @return array Formatted categories array
 */
function tdclassic_get_product_categories($limit = 6, $hide_empty = false, $include_image = true)
{
    // Lấy danh mục "Chưa phân loại" để loại bỏ
    $uncategorized_term = get_term_by('slug', 'uncategorized', 'product_cat');
    $exclude_ids = array();

    if ($uncategorized_term && !is_wp_error($uncategorized_term)) {
        $exclude_ids[] = $uncategorized_term->term_id;
    }

    $categories = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => $hide_empty,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'exclude' => $exclude_ids,
        'number' => $limit
    ));

    if (is_wp_error($categories) || empty($categories)) {
        return array();
    }

    $formatted_categories = array();

    foreach ($categories as $category) {
        // Bỏ qua danh mục "Chưa phân loại" nếu vẫn còn
        if ($category->slug === 'uncategorized' || strpos(strtolower($category->name), 'uncategorized') !== false) {
            continue;
        }

        // Lấy hình ảnh danh mục (nếu cần)
        $image_url = '';
        $image_alt = $category->name;

        if ($include_image) {
            $image_id = get_term_meta($category->term_id, 'thumbnail_id', true);
            if ($image_id) {
                $image_url = wp_get_attachment_image_url($image_id, 'large');
                $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                if (empty($image_alt)) {
                    $image_alt = $category->name;
                }
            } else {
                // Hình ảnh mặc định
                $image_url = 'https://www.hifivietnam.vn/wp-content/uploads/2024/05/hfvn-nhahathoguom-5.webp';
            }
        }

        // Lấy mô tả danh mục
        $description = $category->description;
        if (empty($description)) {
            $description = 'Khám phá các sản phẩm ' . strtolower($category->name) . ' chất lượng cao';
        }

        // URL danh mục
        $category_url = get_term_link($category);
        if (is_wp_error($category_url)) {
            $category_url = home_url('/product-category/' . $category->slug);
        }

        $formatted_categories[] = array(
            'id' => $category->term_id,
            'name' => $category->name,
            'slug' => $category->slug,
            'description' => $description,
            'image_url' => $image_url,
            'image_alt' => $image_alt,
            'url' => $category_url,
            'count' => $category->count
        );
    }

    return $formatted_categories;
}

/**
 * Get products by category for Mega Menu
 * @param string $category_slug Category slug
 * @param int $limit Number of products to return
 * @return array Formatted products array
 */
function tdclassic_get_products_by_category($category_slug, $limit = 8)
{
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $category_slug,
            ),
        ),
    );

    $products = get_posts($args);
    $formatted_products = array();

    foreach ($products as $product) {
        $product_id = $product->ID;
        $product_obj = function_exists('wc_get_product') ? wc_get_product($product_id) : null;

        // Get product image
        $image_id = get_post_thumbnail_id($product_id);
        $image_url = '';
        if ($image_id) {
            $image_url = wp_get_attachment_image_url($image_id, 'medium');
        } else {
            $image_url = function_exists('wc_placeholder_img_src') ? wc_placeholder_img_src('medium') : '';
        }

        // Get product price
        $price = '';
        if ($product_obj) {
            $price = $product_obj->get_price_html();
        }

        $formatted_products[] = array(
            'id' => $product_id,
            'title' => get_the_title($product_id),
            'url' => get_permalink($product_id),
            'image_url' => $image_url,
            'price' => $price,
            'price_raw' => $product_obj ? $product_obj->get_price() : 0,
        );
    }

    return $formatted_products;
}

/**
 * Get product categories for Mega Menu with featured image
 * Wrapper function using unified tdclassic_get_product_categories()
 * 
 * @param int $limit Number of categories
 * @return array Formatted categories with featured image
 */
function tdclassic_get_mega_menu_categories($limit = 10)
{
    // Use unified function with hide_empty=true and include_image=true
    return tdclassic_get_product_categories($limit, true, true);
}

/**
 * Get news categories for dropdown menu
 * @return array Formatted news categories
 */
function tdclassic_get_news_categories()
{
    $categories = get_categories(array(
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => true,
    ));

    $formatted_categories = array();

    foreach ($categories as $category) {
        $formatted_categories[] = array(
            'id' => $category->term_id,
            'name' => $category->name,
            'slug' => $category->slug,
            'url' => get_category_link($category->term_id),
            'count' => $category->count,
        );
    }

    return $formatted_categories;
}

// Theme setup
function tdclassic_setup()
{
    // Add theme support
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Register nav menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'tdclassic'),
        'footer' => __('Footer Menu', 'tdclassic'),
    ));

    // Set content width
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1200;
    }
}
add_action('after_setup_theme', 'tdclassic_setup');

// Enqueue scripts and styles
function tdclassic_scripts()
{
    $theme_version = '2.4.1';

    // Bootstrap CSS
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', array(), '5.3.0');

    // Theme stylesheet (base styles)
    wp_enqueue_style('tdclassic-style', get_stylesheet_uri(), array('bootstrap-css'), $theme_version);

    // Font Awesome 6.4.0 (Updated)
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');

    // Google Fonts - Outfit & Cormorant Garamond + Cinzel & Manrope for Product Page
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Outfit:wght@200;300;400;500;700;800&family=Cormorant+Garamond:ital,wght@1,300;1,500&family=Cinzel:wght@400;500;600;700&family=Manrope:wght@200;300;400;500;600;700&display=swap', array(), null);

    // Lucide Icons
    wp_enqueue_script('lucide-icons', 'https://unpkg.com/lucide@latest', array(), null, false);

    // ===== CSS MODULES - Load on all pages =====
    // Header CSS - New design - Load on all pages
    wp_enqueue_style('tdclassic-header-new', get_template_directory_uri() . '/assets/css/modules/header-new.css', array('tdclassic-style'), $theme_version);

    // Legacy header CSS (keep for backward compatibility if needed)
    // wp_enqueue_style('tdclassic-header', get_template_directory_uri() . '/assets/css/modules/header.css', array('tdclassic-style'), $theme_version);

    // Footer CSS - Load on all pages
    wp_enqueue_style('tdclassic-footer', get_template_directory_uri() . '/assets/css/modules/footer.css', array('tdclassic-style'), $theme_version);

    // ===== CSS COMPONENTS - Load on all pages =====
    // Mobile optimization - Load on all pages
    wp_enqueue_style('tdclassic-mobile', get_template_directory_uri() . '/assets/css/components/mobile.css', array('tdclassic-style'), $theme_version);

    // ===== CSS MODULES - Conditional loading =====
    // Front page CSS - Only on front page
    if (is_front_page()) {
        wp_enqueue_style('tdclassic-front-page', get_template_directory_uri() . '/assets/css/modules/front-page.css', array('tdclassic-style'), $theme_version);
        wp_enqueue_style('tdclassic-front-page-enhanced', get_template_directory_uri() . '/assets/css/modules/front-page-enhanced.css', array('tdclassic-front-page'), $theme_version);
    }

    // Product CSS - Only on product pages
    if (is_singular('product') || is_post_type_archive('product') || (function_exists('is_product_category') && is_product_category()) || is_page_template('page-san-pham.php')) {
        wp_enqueue_style('tdclassic-product', get_template_directory_uri() . '/assets/css/modules/product.css', array('tdclassic-style'), $theme_version);
        wp_enqueue_style('tdclassic-product-image', get_template_directory_uri() . '/assets/css/components/product-image.css', array('tdclassic-product'), $theme_version);
        wp_enqueue_style('tdclassic-product-tabs', get_template_directory_uri() . '/assets/css/components/product-tabs.css', array('tdclassic-product'), $theme_version);
    }

    // WordPress Caption Responsive CSS - Only on posts/blogs
    if (is_singular('post') || is_home() || is_category() || is_tag() || is_archive()) {
        wp_enqueue_style('tdclassic-caption', get_template_directory_uri() . '/assets/css/components/caption.css', array('tdclassic-style'), $theme_version);
    }

    // Projects CSS - Only on project pages
    if (is_post_type_archive('project') || is_singular('project')) {
        wp_enqueue_style('tdclassic-projects', get_template_directory_uri() . '/assets/css/modules/projects.css', array('tdclassic-style'), $theme_version);
    }

    // Project Archive CSS - Only on project archive page
    if (is_post_type_archive('project')) {
        wp_enqueue_style('tdclassic-project-archive', get_template_directory_uri() . '/assets/css/pages/project-archive.css', array('tdclassic-projects'), $theme_version);
    }

    // Company Profile CSS - Only on company profile page
    if (is_page_template('page-ho-so-nang-luc.php')) {
        wp_enqueue_style('tdclassic-company-profile', get_template_directory_uri() . '/assets/css/pages/company-profile.css', array('tdclassic-style'), $theme_version);
    }

    // ===== JAVASCRIPT MODULES =====
    // Bootstrap JS - Load globally
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array(), '5.3.0', true);

    // Main theme script - Load globally (header, footer, common features)
    // Helper utilities (load before main.js)
    wp_enqueue_script('tdclassic-helpers', get_template_directory_uri() . '/assets/js/utils/helpers.js', array(), $theme_version, true);

    wp_enqueue_script('tdclassic-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery', 'bootstrap-js', 'tdclassic-helpers'), $theme_version, true);

    // Mega Menu JS - Load globally for new header design
    wp_enqueue_script('tdclassic-mega-menu', get_template_directory_uri() . '/assets/js/modules/mega-menu.js', array('tdclassic-main'), $theme_version, true);

    // ===== JS MODULES - Conditional loading =====
    // Front page JS modules - Only on front page
    if (is_front_page()) {
        // Carousel module (reusable)
        wp_enqueue_script('tdclassic-carousel', get_template_directory_uri() . '/assets/js/modules/carousel.js', array('tdclassic-main'), $theme_version, true);

        // Counter module
        wp_enqueue_script('tdclassic-counter', get_template_directory_uri() . '/assets/js/modules/counter.js', array('tdclassic-main'), $theme_version, true);

        // Front page specific JS
        wp_enqueue_script('tdclassic-front-page', get_template_directory_uri() . '/assets/js/modules/front-page.js', array('tdclassic-carousel', 'tdclassic-counter'), $theme_version, true);
    }

    // Product JS - Only on product pages
    if (is_singular('product')) {
        wp_enqueue_script('tdclassic-single-product', get_template_directory_uri() . '/assets/js/modules/single-product.js', array('tdclassic-main'), $theme_version, true);
        wp_enqueue_script('tdclassic-product-tabs', get_template_directory_uri() . '/assets/js/components/product-tabs.js', array('tdclassic-main'), $theme_version, true);
    }

    // Partner slider - Load on pages that use it
    if (is_front_page() || is_page_template('page-doi-tac.php')) {
        wp_enqueue_script('tdclassic-partner-slider', get_template_directory_uri() . '/assets/js/components/partner-slider.js', array('tdclassic-main'), $theme_version, true);
    }

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'tdclassic_scripts');

// Add Tailwind CSS via CDN (Development Mode) with custom config
function tdclassic_add_tailwind()
{
    ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Cinzel"', 'serif'],
                        sans: ['"Manrope"', 'sans-serif'],
                    },
                    colors: {
                        void: '#050505',
                        metal: '#151515',
                        surface: '#1E1E1E',
                        gold: '#C5A059',
                        goldDim: '#8A703E',
                        dust: '#666666'
                    },
                    letterSpacing: {
                        'cinematic': '0.3em',
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                    }
                }
            }
        }
    </script>
    <?php
}
add_action('wp_head', 'tdclassic_add_tailwind', 10);

// Force WooCommerce to use custom product category template
add_filter('woocommerce_locate_template', 'tdclassic_woocommerce_locate_template', 10, 3);
function tdclassic_woocommerce_locate_template($template, $template_name, $template_path)
{
    // Force use of custom taxonomy-product_cat.php
    if ($template_name === 'archive-product.php' && ((function_exists('is_product_category') && is_product_category()) || (function_exists('is_product_tag') && is_product_tag()) || is_tax('product_cat'))) {
        $custom_template = get_template_directory() . '/woocommerce/taxonomy-product_cat.php';
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }
    return $template;
}

// Force product category pages to use proper taxonomy template
add_filter('template_include', 'tdclassic_force_taxonomy_template', 99);
function tdclassic_force_taxonomy_template($template)
{
    // Check if this is a product category page
    if ((function_exists('is_product_category') && is_product_category()) || is_tax('product_cat')) {
        $custom_template = get_template_directory() . '/woocommerce/taxonomy-product_cat.php';
        if (file_exists($custom_template)) {
            return $custom_template;
        }
        // Fallback to root level template
        $fallback_template = get_template_directory() . '/taxonomy-product_cat.php';
        if (file_exists($fallback_template)) {
            return $fallback_template;
        }
    }

    // Check for custom product_category taxonomy
    if (is_tax('product_category')) {
        $custom_template = get_template_directory() . '/taxonomy-product_category.php';
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }

    // Debug for admin
    if (current_user_can('administrator')) {
        echo '<!-- TEMPLATE BEING USED: ' . $template . ' -->';
    }
    return $template;
}

// ============================================
// PRODUCT CATEGORY PAGE - CUSTOM META BOXES
// ============================================

// Add custom meta boxes for WooCommerce products
add_action('add_meta_boxes', 'tdclassic_add_product_meta_boxes');
function tdclassic_add_product_meta_boxes()
{
    add_meta_box(
        'tdclassic_product_specs',
        'Thông Số Kỹ Thuật (Product Specs)',
        'tdclassic_product_specs_callback',
        'product',
        'side',
        'default'
    );

    add_meta_box(
        'tdclassic_product_badge',
        'Huy Hiệu Sản Phẩm (Badge)',
        'tdclassic_product_badge_callback',
        'product',
        'side',
        'default'
    );
}

// Product Specs meta box callback
function tdclassic_product_specs_callback($post)
{
    wp_nonce_field('tdclassic_save_product_meta', 'tdclassic_product_meta_nonce');
    $value = get_post_meta($post->ID, '_product_specs', true);
    ?>
    <p>
        <label for="product_specs">Thông số kỹ thuật hiển thị trên card:</label><br>
        <input type="text" id="product_specs" name="product_specs" value="<?php echo esc_attr($value); ?>" class="widefat"
            placeholder="VD: 2-Way, 400W RMS">
    </p>
    <p class="description">
        Ngắn gọn, hiển thị trên product card trong category page. VD: "2-Way, 400W", "Dual 12 inch", "Class D Amp"
    </p>
    <?php
}

// Product Badge meta box callback
function tdclassic_product_badge_callback($post)
{
    $value = get_post_meta($post->ID, '_product_badge', true);
    ?>
    <p>
        <label for="product_badge">Huy hiệu tùy chỉnh:</label><br>
        <select id="product_badge" name="product_badge" class="widefat">
            <option value="">-- Không có --</option>
            <option value="HOT" <?php selected($value, 'HOT'); ?>>🔥 HOT</option>
            <option value="NEW" <?php selected($value, 'NEW'); ?>>✨ NEW</option>
            <option value="BEST SELLER" <?php selected($value, 'BEST SELLER'); ?>>⭐ BEST SELLER</option>
            <option value="LIMITED" <?php selected($value, 'LIMITED'); ?>>⏰ LIMITED</option>
        </select>
    </p>
    <p class="description">
        Badge sẽ hiển thị ở góc trên phải của product image. Nếu sản phẩm đang Sale, badge Sale sẽ được ưu tiên hiển thị.
    </p>
    <?php
}

// Save meta box data
add_action('save_post_product', 'tdclassic_save_product_meta');
function tdclassic_save_product_meta($post_id)
{
    // Check nonce
    if (!isset($_POST['tdclassic_product_meta_nonce']) || !wp_verify_nonce($_POST['tdclassic_product_meta_nonce'], 'tdclassic_save_product_meta')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save product specs
    if (isset($_POST['product_specs'])) {
        update_post_meta($post_id, '_product_specs', sanitize_text_field($_POST['product_specs']));
    }

    // Save product badge
    if (isset($_POST['product_badge'])) {
        update_post_meta($post_id, '_product_badge', sanitize_text_field($_POST['product_badge']));
    }
}

// ============================================
// INFINITE SCROLL / LAZY LOAD HANDLER
// ============================================

add_action('wp_ajax_tdclassic_load_more_products', 'tdclassic_load_more_products');
add_action('wp_ajax_nopriv_tdclassic_load_more_products', 'tdclassic_load_more_products');

function tdclassic_load_more_products()
{
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $term_id = isset($_POST['term_id']) ? intval($_POST['term_id']) : 0;

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 12,
        'paged' => $paged,
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $term_id,
            )
        ),
        'orderby' => 'menu_order title',
        'order' => 'ASC'
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            global $product;
            if (!$product) {
                $product = function_exists('wc_get_product') ? wc_get_product(get_the_ID()) : null;
            }
            $product_specs = get_post_meta(get_the_ID(), '_product_specs', true);
            $product_badge = get_post_meta(get_the_ID(), '_product_badge', true);
            ?>
            <div class="product-card group cursor-pointer bg-void border border-white/5 p-4 hover:border-gold/30 transition-all">
                <a href="<?php the_permalink(); ?>">
                    <div class="img-container aspect-square bg-surface overflow-hidden mb-4 relative">
                        <?php if (has_post_thumbnail()): ?>
                            <img src="<?php the_post_thumbnail_url('medium_large'); ?>"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                alt="<?php the_title(); ?>" loading="lazy">
                        <?php else: ?>
                            <img src="https://images.unsplash.com/photo-1520697830682-bbb6e88e2516?q=80&w=600&auto=format&fit=crop"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                alt="<?php the_title(); ?>">
                        <?php endif; ?>

                        <?php if ($product && $product->is_on_sale()): ?>
                            <div class="absolute top-2 right-2 bg-gold text-black text-[10px] font-bold px-2 py-1">Sale</div>
                        <?php elseif ($product_badge): ?>
                            <div class="absolute top-2 right-2 bg-gold text-black text-[10px] font-bold px-2 py-1">
                                <?php echo esc_html($product_badge); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <h4 class="font-serif text-white text-sm md:text-base group-hover:text-gold transition-colors">
                        <?php the_title(); ?>
                    </h4>
                    <p class="font-sans text-gray-500 text-[10px] uppercase mt-1">
                        <?php
                        $categories = get_the_terms(get_the_ID(), 'product_cat');
                        if ($categories && !is_wp_error($categories)) {
                            echo esc_html($categories[0]->name);
                        }
                        ?>
                    </p>
                    <?php if ($product_specs): ?>
                        <p class="text-gold text-xs mt-2"><?php echo esc_html($product_specs); ?></p>
                    <?php endif; ?>
                </a>
            </div>
            <?php
        }
        wp_reset_postdata();
    }

    die();
}

add_action('wp_ajax_tdclassic_load_more_news', 'tdclassic_load_more_news');
add_action('wp_ajax_nopriv_tdclassic_load_more_news', 'tdclassic_load_more_news');

function tdclassic_load_more_news()
{
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $posts_per_page = 9;

    // 1. Local Posts
    $local_query = new WP_Query(
        array(
            'post_type' => 'post',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish'
        )
    );

    $combined_posts = array();

    // Process Local
    if ($local_query->have_posts()) {
        while ($local_query->have_posts()) {
            $local_query->the_post();
            $categories = get_the_category();
            $cat_slug = $categories ? $categories[0]->slug : 'uncategorized';
            $cat_name = $categories ? $categories[0]->name : 'Tin tức';

            $combined_posts[] = array(
                'origin' => 'local',
                'title' => get_the_title(),
                'link' => get_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'medium_large') ?: 'https://images.unsplash.com/photo-1516280440614-6697288d5d38?q=80&w=800&auto=format&fit=crop',
                'date' => get_the_date('d M Y'),
                'raw_date' => get_the_date('c'),
                'excerpt' => get_the_excerpt(),
                'category_slug' => $cat_slug,
                'category_name' => $cat_name,
                'read_time' => '5 min read'
            );
        }
        wp_reset_postdata();
    }

    // 2. Remote Posts (if available)
    if (function_exists('get_posts_from_main_site')) {
        // Create dummy variable for reference parameter to avoid Fatal Error
        $dummy_total_remote = 1;
        $remote_posts = get_posts_from_main_site($posts_per_page, $paged, $dummy_total_remote);

        if (!empty($remote_posts)) {
            foreach ($remote_posts as $remote_post) {
                $combined_posts[] = array(
                    'origin' => 'remote',
                    'title' => isset($remote_post['title']) ? $remote_post['title'] : '',
                    'link' => isset($remote_post['link']) ? $remote_post['link'] : '#',
                    'image' => isset($remote_post['image']) ? $remote_post['image'] : '',
                    'date' => isset($remote_post['date']) ? $remote_post['date'] : '',
                    'raw_date' => isset($remote_post['raw_date']) ? $remote_post['raw_date'] : '',
                    'excerpt' => isset($remote_post['excerpt']) ? $remote_post['excerpt'] : '',
                    'category_slug' => 'tin-tuc',
                    'category_name' => 'TavaLED',
                    'read_time' => '3 min read'
                );
            }
        }
    }

    // Sort combined
    usort($combined_posts, function ($a, $b) {
        $time_a = !empty($a['raw_date']) ? strtotime($a['raw_date']) : 0;
        $time_b = !empty($b['raw_date']) ? strtotime($b['raw_date']) : 0;
        return $time_b - $time_a;
    });

    // Check if we have any posts
    if (empty($combined_posts)) {
        die(); // Return empty to signal end
    }

    // Output HTML
    foreach ($combined_posts as $post) {
        ?>
        <article class="article-card group cursor-pointer flex flex-col h-full"
            data-category="<?php echo esc_attr($post['category_slug']); ?>">
            <a href="<?php echo esc_url($post['link']); ?>" class="block flex flex-col h-full">
                <div class="img-container aspect-[3/2] bg-surface overflow-hidden relative mb-6 border border-white/5">
                    <img src="<?php echo esc_url($post['image']); ?>" class="w-full h-full object-cover" loading="lazy"
                        decoding="async">
                    <div
                        class="absolute top-4 left-4 bg-black/80 backdrop-blur text-gold text-[10px] font-bold uppercase px-3 py-1 tracking-widest border border-gold/20">
                        <?php echo esc_html($post['category_name']); ?>
                    </div>
                </div>
                <div class="flex-1 flex flex-col">
                    <div class="flex items-center gap-3 mb-3 text-[10px] text-gray-500 font-sans tracking-widest uppercase">
                        <span><?php echo esc_html($post['date']); ?></span>
                        <span class="w-1 h-1 bg-gold rounded-full"></span>
                        <span><?php echo esc_html($post['read_time']); ?></span>
                    </div>
                    <h3 class="font-serif text-xl text-white mb-3 group-hover:text-gold transition-colors leading-snug">
                        <?php echo esc_html($post['title']); ?>
                    </h3>
                    <p class="font-sans text-xs text-gray-400 font-light leading-relaxed mb-6 line-clamp-3">
                        <?php echo esc_html(wp_trim_words($post['excerpt'], 20)); ?>
                    </p>
                    <div class="mt-auto pt-4 border-t border-white/5">
                        <span class="text-gold text-[10px] font-bold uppercase tracking-widest group-hover:underline">Đọc
                            tiếp</span>
                    </div>
                </div>
            </a>
        </article>
        <?php
    }

    die();
}

// Register widget areas
function tdclassic_widgets_init()
{
    register_sidebar(array(
        'name' => __('Footer Widget Area 1', 'tdclassic'),
        'id' => 'footer-1',
        'description' => __('Footer widget area 1', 'tdclassic'),
        'before_widget' => '<div class="col-md-4"><div class="widget %2$s">',
        'after_widget' => '</div></div>',
        'before_title' => '<h5 class="widget-title">',
        'after_title' => '</h5>',
    ));

    register_sidebar(array(
        'name' => __('Footer Widget Area 2', 'tdclassic'),
        'id' => 'footer-2',
        'description' => __('Footer widget area 2', 'tdclassic'),
        'before_widget' => '<div class="col-md-4"><div class="widget %2$s">',
        'after_widget' => '</div></div>',
        'before_title' => '<h5 class="widget-title">',
        'after_title' => '</h5>',
    ));

    register_sidebar(array(
        'name' => __('Footer Widget Area 3', 'tdclassic'),
        'id' => 'footer-3',
        'description' => __('Footer widget area 3', 'tdclassic'),
        'before_widget' => '<div class="col-md-4"><div class="widget %2$s">',
        'after_widget' => '</div></div>',
        'before_title' => '<h5 class="widget-title">',
        'after_title' => '</h5>',
    ));
}
add_action('widgets_init', 'tdclassic_widgets_init');

// Excerpt length
function tdclassic_excerpt_length($length)
{
    return 30;
}
add_filter('excerpt_length', 'tdclassic_excerpt_length');

// Excerpt more
function tdclassic_excerpt_more($more)
{
    return '... <a href="' . get_permalink() . '" class="read-more">Đọc thêm</a>';
}
add_filter('excerpt_more', 'tdclassic_excerpt_more');

// Custom post type for Projects
function tdclassic_create_project_post_type()
{
    register_post_type(
        'project',
        array(
            'labels' => array(
                'name' => __('Dự án', 'tdclassic'),
                'singular_name' => __('Dự án', 'tdclassic'),
                'add_new' => __('Thêm mới', 'tdclassic'),
                'add_new_item' => __('Thêm dự án mới', 'tdclassic'),
                'edit_item' => __('Chỉnh sửa dự án', 'tdclassic'),
                'new_item' => __('Dự án mới', 'tdclassic'),
                'view_item' => __('Xem dự án', 'tdclassic'),
                'search_items' => __('Tìm kiếm dự án', 'tdclassic'),
                'not_found' => __('Không tìm thấy dự án', 'tdclassic'),
                'not_found_in_trash' => __('Không tìm thấy dự án trong thùng rác', 'tdclassic'),
            ),
            'public' => true,
            'has_archive' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-portfolio',
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'rewrite' => array('slug' => 'du-an'),
            'taxonomies' => array('project_category')
        )
    );
}
add_action('init', 'tdclassic_create_project_post_type');

// Custom post type for Products
function tdclassic_create_product_post_type()
{
    register_post_type(
        'product',
        array(
            'labels' => array(
                'name' => __('Sản phẩm', 'tdclassic'),
                'singular_name' => __('Sản phẩm', 'tdclassic'),
                'add_new' => __('Thêm mới', 'tdclassic'),
                'add_new_item' => __('Thêm sản phẩm mới', 'tdclassic'),
                'edit_item' => __('Chỉnh sửa sản phẩm', 'tdclassic'),
                'new_item' => __('Sản phẩm mới', 'tdclassic'),
                'view_item' => __('Xem sản phẩm', 'tdclassic'),
                'search_items' => __('Tìm kiếm sản phẩm', 'tdclassic'),
                'not_found' => __('Không tìm thấy sản phẩm', 'tdclassic'),
                'not_found_in_trash' => __('Không tìm thấy sản phẩm trong thùng rác', 'tdclassic'),
            ),
            'public' => true,
            'has_archive' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-products',
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'rewrite' => array('slug' => 'san-pham'),
            'taxonomies' => array('product_category')
        )
    );
}
add_action('init', 'tdclassic_create_product_post_type');

// Custom post type for Partners
function tdclassic_create_partner_post_type()
{
    register_post_type(
        'partner',
        array(
            'labels' => array(
                'name' => __('Đối tác', 'tdclassic'),
                'singular_name' => __('Đối tác', 'tdclassic'),
                'add_new' => __('Thêm mới', 'tdclassic'),
                'add_new_item' => __('Thêm đối tác mới', 'tdclassic'),
                'edit_item' => __('Chỉnh sửa đối tác', 'tdclassic'),
                'new_item' => __('Đối tác mới', 'tdclassic'),
                'view_item' => __('Xem đối tác', 'tdclassic'),
                'search_items' => __('Tìm kiếm đối tác', 'tdclassic'),
                'not_found' => __('Không tìm thấy đối tác', 'tdclassic'),
                'not_found_in_trash' => __('Không tìm thấy đối tác trong thùng rác', 'tdclassic'),
            ),
            'public' => true,
            'has_archive' => false,
            'menu_position' => 6,
            'menu_icon' => 'dashicons-groups',
            'supports' => array('title', 'thumbnail'),
            'rewrite' => array('slug' => 'doi-tac'),
            'show_in_rest' => true,
        )
    );
}
add_action('init', 'tdclassic_create_partner_post_type');

// Custom post type for Agents
function tdclassic_create_agent_post_type()
{
    register_post_type(
        'agent',
        array(
            'labels' => array(
                'name' => __('Đại lý', 'tdclassic'),
                'singular_name' => __('Đại lý', 'tdclassic'),
                'add_new' => __('Thêm mới', 'tdclassic'),
                'add_new_item' => __('Thêm đại lý mới', 'tdclassic'),
                'edit_item' => __('Chỉnh sửa đại lý', 'tdclassic'),
                'new_item' => __('Đại lý mới', 'tdclassic'),
                'view_item' => __('Xem đại lý', 'tdclassic'),
                'search_items' => __('Tìm kiếm đại lý', 'tdclassic'),
                'not_found' => __('Không tìm thấy đại lý', 'tdclassic'),
                'not_found_in_trash' => __('Không tìm thấy đại lý trong thùng rác', 'tdclassic'),
            ),
            'public' => true,
            'has_archive' => false,
            'menu_position' => 7,
            'menu_icon' => 'dashicons-location',
            'supports' => array('title', 'thumbnail'),
            'rewrite' => array('slug' => 'dai-ly'),
            'show_in_rest' => true,
        )
    );
}
add_action('init', 'tdclassic_create_agent_post_type');

// Add meta boxes for agent
function tdclassic_add_agent_meta_boxes()
{
    add_meta_box(
        'agent_details',
        __('Thông tin đại lý', 'tdclassic'),
        'tdclassic_agent_meta_box_callback',
        'agent',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'tdclassic_add_agent_meta_boxes');

// Meta box callback function
function tdclassic_agent_meta_box_callback($post)
{
    wp_nonce_field('tdclassic_save_agent_meta', 'tdclassic_agent_meta_nonce');

    $address = get_post_meta($post->ID, '_agent_address', true);
    $google_maps_link = get_post_meta($post->ID, '_agent_google_maps_link', true);
    $phone = get_post_meta($post->ID, '_agent_phone', true);
    $email = get_post_meta($post->ID, '_agent_email', true);

    ?>
    <table class="form-table">
        <tr>
            <th scope="row"><label for="agent_address"><?php _e('Địa chỉ đại lý', 'tdclassic'); ?></label></th>
            <td><textarea name="agent_address" id="agent_address" rows="3"
                    class="large-text"><?php echo esc_textarea($address); ?></textarea></td>
        </tr>
        <tr>
            <th scope="row"><label for="agent_google_maps_link"><?php _e('Link Google Maps', 'tdclassic'); ?></label></th>
            <td><input type="url" name="agent_google_maps_link" id="agent_google_maps_link"
                    value="<?php echo esc_url($google_maps_link); ?>" class="large-text" /></td>
        </tr>
        <tr>
            <th scope="row"><label for="agent_phone"><?php _e('Số điện thoại', 'tdclassic'); ?></label></th>
            <td><input type="tel" name="agent_phone" id="agent_phone" value="<?php echo esc_attr($phone); ?>"
                    class="regular-text" /></td>
        </tr>
        <tr>
            <th scope="row"><label for="agent_email"><?php _e('Email', 'tdclassic'); ?></label></th>
            <td><input type="email" name="agent_email" id="agent_email" value="<?php echo esc_attr($email); ?>"
                    class="regular-text" /></td>
        </tr>
    </table>
    <?php
}

// Save agent meta data
function tdclassic_save_agent_meta($post_id)
{
    if (!isset($_POST['tdclassic_agent_meta_nonce']) || !wp_verify_nonce($_POST['tdclassic_agent_meta_nonce'], 'tdclassic_save_agent_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['agent_address'])) {
        update_post_meta($post_id, '_agent_address', sanitize_textarea_field($_POST['agent_address']));
    }

    if (isset($_POST['agent_google_maps_link'])) {
        update_post_meta($post_id, '_agent_google_maps_link', esc_url_raw($_POST['agent_google_maps_link']));
    }

    if (isset($_POST['agent_phone'])) {
        update_post_meta($post_id, '_agent_phone', sanitize_text_field($_POST['agent_phone']));
    }

    if (isset($_POST['agent_email'])) {
        update_post_meta($post_id, '_agent_email', sanitize_email($_POST['agent_email']));
    }
}
add_action('save_post', 'tdclassic_save_agent_meta');

// Add Google Maps API key setting
function tdclassic_add_google_maps_settings()
{
    add_settings_section(
        'tdclassic_google_maps_section',
        __('Google Maps Settings', 'tdclassic'),
        'tdclassic_google_maps_section_callback',
        'general'
    );

    add_settings_field(
        'tdclassic_google_maps_api_key',
        __('Google Maps API Key', 'tdclassic'),
        'tdclassic_google_maps_api_key_callback',
        'general',
        'tdclassic_google_maps_section'
    );

    register_setting('general', 'tdclassic_google_maps_api_key');
}
add_action('admin_init', 'tdclassic_add_google_maps_settings');

// Add company contact settings
function tdclassic_add_contact_settings()
{
    add_settings_section(
        'tdclassic_contact_section',
        __('Thông tin liên hệ công ty', 'tdclassic'),
        'tdclassic_contact_section_callback',
        'general'
    );

    add_settings_field(
        'tdclassic_company_phone',
        __('Số điện thoại công ty', 'tdclassic'),
        'tdclassic_company_phone_callback',
        'general',
        'tdclassic_contact_section'
    );
    add_settings_field(
        'tdclassic_company_email',
        __('Email công ty', 'tdclassic'),
        'tdclassic_company_email_callback',
        'general',
        'tdclassic_contact_section'
    );
    add_settings_field(
        'tdclassic_company_address',
        __('Địa chỉ công ty', 'tdclassic'),
        'tdclassic_company_address_callback',
        'general',
        'tdclassic_contact_section'
    );
    register_setting('general', 'tdclassic_company_phone');
    register_setting('general', 'tdclassic_company_email');
    register_setting('general', 'tdclassic_company_address');
}
add_action('admin_init', 'tdclassic_add_contact_settings');

function tdclassic_google_maps_section_callback()
{
    echo '<p>' . __('Nhập Google Maps API Key để hiển thị bản đồ đại lý.', 'tdclassic') . '</p>';
}

function tdclassic_google_maps_api_key_callback()
{
    $api_key = get_option('tdclassic_google_maps_api_key');
    echo '<input type="text" name="tdclassic_google_maps_api_key" value="' . esc_attr($api_key) . '" class="regular-text" />';
    echo '<p class="description">' . __('Lấy API Key từ <a href="https://console.cloud.google.com/" target="_blank">Google Cloud Console</a>', 'tdclassic') . '</p>';
}

function tdclassic_contact_section_callback()
{
    echo '<p>' . __('Cài đặt thông tin liên hệ sẽ được hiển thị trên website.', 'tdclassic') . '</p>';
}

function tdclassic_company_phone_callback()
{
    $phone = get_option('tdclassic_company_phone', '+84 904 433 799');
    echo '<input type="tel" name="tdclassic_company_phone" value="' . esc_attr($phone) . '" class="regular-text" />';
    echo '<p class="description">' . __('Số điện thoại sẽ hiển thị trên header và footer website', 'tdclassic') . '</p>';
}

function tdclassic_company_email_callback()
{
    $email = get_option('tdclassic_company_email', 'cskh.tdclassic@gmail.com');
    echo '<input type="email" name="tdclassic_company_email" value="' . esc_attr($email) . '" class="regular-text" />';
    echo '<p class="description">Email sẽ hiển thị trên website và dùng cho liên hệ.</p>';
}

function tdclassic_company_address_callback()
{
    $address = get_option('tdclassic_company_address', 'Số 22A Ngô Quyền, phường Ngô Quyền, Thành phố Hải Phòng, Việt Nam');
    echo '<textarea name="tdclassic_company_address" rows="3" class="large-text">' . esc_textarea($address) . '</textarea>';
    echo '<p class="description">' . __('Địa chỉ công ty sẽ hiển thị trên footer và trang liên hệ', 'tdclassic') . '</p>';
}

// Enqueue Google Maps API for agent page
function tdclassic_enqueue_google_maps()
{
    if (is_page_template('page-dai-ly.php')) {
        $api_key = get_option('tdclassic_google_maps_api_key');
        if ($api_key) {
            wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . esc_attr($api_key) . '&callback=initMap', array(), null, true);
        }
    }
}
add_action('wp_enqueue_scripts', 'tdclassic_enqueue_google_maps');

// Custom taxonomies
function tdclassic_create_taxonomies()
{
    // Product Categories
    register_taxonomy('product_category', 'product', array(
        'labels' => array(
            'name' => __('Danh mục sản phẩm', 'tdclassic'),
            'singular_name' => __('Danh mục sản phẩm', 'tdclassic'),
            'add_new_item' => __('Thêm danh mục mới', 'tdclassic'),
            'edit_item' => __('Chỉnh sửa danh mục', 'tdclassic'),
            'new_item' => __('Danh mục mới', 'tdclassic'),
            'view_item' => __('Xem danh mục', 'tdclassic'),
            'search_items' => __('Tìm kiếm danh mục', 'tdclassic'),
            'not_found' => __('Không tìm thấy danh mục', 'tdclassic'),
            'all_items' => __('Tất cả danh mục', 'tdclassic'),
            'menu_name' => __('Danh mục sản phẩm', 'tdclassic'),
        ),
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'danh-muc-san-pham'),
    ));

    // Project Categories
    register_taxonomy('project_category', 'project', array(
        'labels' => array(
            'name' => __('Danh mục dự án', 'tdclassic'),
            'singular_name' => __('Danh mục dự án', 'tdclassic'),
            'add_new_item' => __('Thêm danh mục mới', 'tdclassic'),
            'edit_item' => __('Chỉnh sửa danh mục', 'tdclassic'),
            'new_item' => __('Danh mục mới', 'tdclassic'),
            'view_item' => __('Xem danh mục', 'tdclassic'),
            'search_items' => __('Tìm kiếm danh mục', 'tdclassic'),
            'not_found' => __('Không tìm thấy danh mục', 'tdclassic'),
            'all_items' => __('Tất cả danh mục', 'tdclassic'),
            'menu_name' => __('Danh mục dự án', 'tdclassic'),
        ),
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'danh-muc-du-an'),
    ));
}
add_action('init', 'tdclassic_create_taxonomies');

// Add custom image sizes
function tdclassic_image_sizes()
{
    add_image_size('product-thumb', 300, 200, true);
    add_image_size('hero-image', 1200, 600, true);
    add_image_size('blog-thumb', 400, 250, true);
    // Project thumbnails: crisp, wide format
    add_image_size('project-thumb', 720, 480, true);
}
add_action('after_setup_theme', 'tdclassic_image_sizes');

// Custom navigation walker for Bootstrap
class Bootstrap_NavWalker extends Walker_Nav_Menu
{
    function start_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $class_names = $value = '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $output .= $indent . '<li' . $id . $value . $class_names . '>';

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a class="nav-link"' . $attributes . '>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

// Pagination
function tdclassic_pagination()
{
    global $wp_query;

    if ($wp_query->max_num_pages > 1) {
        echo '<nav aria-label="Page navigation">';
        echo '<ul class="pagination justify-content-center">';

        // Previous page
        if (get_previous_posts_link()) {
            echo '<li class="page-item">';
            previous_posts_link('<span class="page-link">« Trước</span>');
            echo '</li>';
        }

        // Page numbers
        $current = max(1, get_query_var('paged'));
        $total = $wp_query->max_num_pages;
        $start = max(1, $current - 2);
        $end = min($total, $current + 2);

        for ($i = $start; $i <= $end; $i++) {
            if ($i == $current) {
                echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
            }
        }

        // Next page
        if (get_next_posts_link()) {
            echo '<li class="page-item">';
            next_posts_link('<span class="page-link">Sau »</span>');
            echo '</li>';
        }

        echo '</ul>';
        echo '</nav>';
    }
}

// Clean WordPress head
function tdclassic_cleanup_head()
{
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
}
add_action('init', 'tdclassic_cleanup_head');

// Handle contact form submission
function handle_contact_form()
{
    // Check nonce
    if (!wp_verify_nonce($_POST['nonce'], 'contact_form_nonce')) {
        wp_die('Security check failed');
    }

    // Sanitize form data
    $name = sanitize_text_field($_POST['contact_name']);
    $email = sanitize_email($_POST['contact_email']);
    $phone = sanitize_text_field($_POST['contact_phone']);
    $company = sanitize_text_field($_POST['contact_company']);
    $subject = sanitize_text_field($_POST['contact_subject']);
    $message = sanitize_textarea_field($_POST['contact_message']);
    $newsletter = isset($_POST['contact_newsletter']) ? 1 : 0;

    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        wp_die('Vui lòng điền đầy đủ thông tin bắt buộc.');
    }

    // Validate email
    if (!is_email($email)) {
        wp_die('Email không hợp lệ.');
    }

    // Prepare email content
    $to = get_option('admin_email');
    $email_subject = 'Liên hệ từ website: ' . $subject;

    $email_body = "Thông tin liên hệ mới từ website:\n\n";
    $email_body .= "Họ tên: " . $name . "\n";
    $email_body .= "Email: " . $email . "\n";
    $email_body .= "Điện thoại: " . $phone . "\n";
    $email_body .= "Công ty: " . $company . "\n";
    $email_body .= "Chủ đề: " . $subject . "\n";
    $email_body .= "Đăng ký nhận tin: " . ($newsletter ? 'Có' : 'Không') . "\n\n";
    $email_body .= "Tin nhắn:\n" . $message . "\n\n";
    $email_body .= "---\n";
    $email_body .= "Gửi từ: " . get_bloginfo('name') . "\n";
    $email_body .= "Thời gian: " . current_time('mysql') . "\n";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $name . ' <' . $email . '>',
        'Reply-To: ' . $email
    );

    // Send email
    $sent = wp_mail($to, $email_subject, $email_body, $headers);

    if ($sent) {
        // Save to database (optional)
        global $wpdb;
        $table_name = $wpdb->prefix . 'contact_messages';

        $wpdb->insert(
            $table_name,
            array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'company' => $company,
                'subject' => $subject,
                'message' => $message,
                'newsletter' => $newsletter,
                'created_at' => current_time('mysql')
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s')
        );

        wp_die('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.');
    } else {
        wp_die('Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại sau.');
    }
}
add_action('wp_ajax_handle_contact_form', 'handle_contact_form');
add_action('wp_ajax_nopriv_handle_contact_form', 'handle_contact_form');

// Create contact messages table
function create_contact_messages_table()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'contact_messages';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(20),
        company varchar(255),
        subject varchar(255) NOT NULL,
        message text NOT NULL,
        newsletter tinyint(1) DEFAULT 0,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_setup_theme', 'create_contact_messages_table');

// Font Awesome - Now enqueued in tdclassic_scripts() function above
// Removed duplicate enqueue function

// Weather API Handler (Optional - for real weather data)
function handle_weather_api()
{
    if (!isset($_GET['lat']) || !isset($_GET['lon'])) {
        wp_die('Missing coordinates');
    }

    $lat = sanitize_text_field($_GET['lat']);
    $lon = sanitize_text_field($_GET['lon']);

    // Replace with your OpenWeatherMap API key
    $api_key = get_option('openweather_api_key', '');

    if (empty($api_key)) {
        wp_die('Weather API key not configured');
    }

    $url = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid={$api_key}&units=metric&lang=vi";

    $response = wp_remote_get($url);

    if (is_wp_error($response)) {
        wp_die('Weather API request failed');
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!$data || $data['cod'] != 200) {
        wp_die('Weather API error');
    }

    $weather_data = array(
        'temp' => round($data['main']['temp']),
        'description' => $data['weather'][0]['description'],
        'icon' => $data['weather'][0]['icon']
    );

    wp_send_json($weather_data);
}
add_action('wp_ajax_get_weather', 'handle_weather_api');
add_action('wp_ajax_nopriv_get_weather', 'handle_weather_api');

// Add weather API key setting to admin
function tdclassic_add_weather_settings()
{
    add_settings_section(
        'tdclassic_weather_section',
        'Weather API Settings',
        function () {
            echo '<p>Configure weather API for header weather widget.</p>';
        },
        'general'
    );

    add_settings_field(
        'openweather_api_key',
        'OpenWeatherMap API Key',
        function () {
            $api_key = get_option('openweather_api_key', '');
            echo '<input type="text" id="openweather_api_key" name="openweather_api_key" value="' . esc_attr($api_key) . '" class="regular-text" />';
            echo '<p class="description">Get your free API key from <a href="https://openweathermap.org/api" target="_blank">OpenWeatherMap</a></p>';
        },
        'general',
        'tdclassic_weather_section'
    );

    register_setting('general', 'openweather_api_key');
}
add_action('admin_init', 'tdclassic_add_weather_settings');

// Enqueue weather API URL for JavaScript
function tdclassic_localize_scripts()
{
    wp_localize_script('tdclassic-script', 'tdclassic_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('weather_nonce')
    ));
}
// Disabled to avoid injecting inline JS for weather in simplified header
// add_action('wp_enqueue_scripts', 'tdclassic_localize_scripts');

// Projects CSS - Now handled in tdclassic_scripts() function above
// Removed duplicate enqueue function

// Add weather API configuration to JavaScript
function tdclassic_weather_config()
{
    $api_key = get_option('openweather_api_key', '');
    ?>
    <script type="text/javascript">
        var tdWeatherConfig = {
            apiKey: '<?php echo esc_js($api_key); ?>',
            endpoint: 'https://api.openweathermap.org/data/2.5/weather'
        };
    </script>
    <?php
}
// Disabled inline weather config for simplified header
// add_action('wp_head', 'tdclassic_weather_config');

// Create sample product categories if none exist (disabled for WooCommerce)
/*
function tdclassic_create_sample_product_categories() {
    // Check if product categories already exist
    $existing_categories = get_terms(array(
        'taxonomy' => 'product_category',
        'hide_empty' => false
    ));
    
    if (empty($existing_categories)) {
        // Create sample categories
        $sample_categories = array(
            'web-development' => 'Phát triển Web',
            'mobile-app' => 'Ứng dụng Mobile',
            'design-services' => 'Thiết kế Đồ họa',
            'digital-marketing' => 'Digital Marketing',
            'consulting' => 'Tư vấn CNTT',
            'hosting-domain' => 'Hosting & Domain'
        );
        
        foreach ($sample_categories as $slug => $name) {
            if (!term_exists($slug, 'product_category')) {
                wp_insert_term($name, 'product_category', array('slug' => $slug));
            }
        }
        
        // Create sample products with categories
        tdclassic_create_sample_products();
    }
}
add_action('init', 'tdclassic_create_sample_product_categories');
*/

// Create sample products (disabled for WooCommerce)
/*
function tdclassic_create_sample_products() {
    // Check if products already exist
    $existing_products = get_posts(array(
        'post_type' => 'product',
        'posts_per_page' => 1,
        'post_status' => 'publish'
    ));
    
    if (empty($existing_products)) {
        $sample_products = array(
            array(
                'title' => 'Thiết kế Website responsive',
                'content' => 'Dịch vụ thiết kế website chuyên nghiệp, responsive trên mọi thiết bị.',
                'category' => 'web-development'
            ),
            array(
                'title' => 'Ứng dụng Mobile iOS/Android',
                'content' => 'Phát triển ứng dụng mobile native cho iOS và Android.',
                'category' => 'mobile-app'
            ),
            array(
                'title' => 'Thiết kế Logo & Brand Identity',
                'content' => 'Thiết kế logo và bộ nhận diện thương hiệu chuyên nghiệp.',
                'category' => 'design-services'
            ),
            array(
                'title' => 'Digital Marketing Strategy',
                'content' => 'Xây dựng chiến lược marketing số toàn diện cho doanh nghiệp.',
                'category' => 'digital-marketing'
            )
        );
        
        foreach ($sample_products as $product_data) {
            $product_id = wp_insert_post(array(
                'post_title' => $product_data['title'],
                'post_content' => $product_data['content'],
                'post_type' => 'product',
                'post_status' => 'publish'
            ));
            
            if ($product_id && !is_wp_error($product_id)) {
                // Assign category to product
                wp_set_post_terms($product_id, $product_data['category'], 'product_category');
            }
        }
    }
}
*/

/**
 * Product assets - Now handled in tdclassic_scripts() function above
 * Removed duplicate enqueue function
 */

/**
 * Override WooCommerce product tabs template
 */
function tdclassic_override_product_tabs_template($template, $template_name, $template_path)
{
    if ($template_name === 'single-product/tabs/tabs.php') {
        $template = get_template_directory() . '/woocommerce/single-product/tabs/custom-product-tabs.php';
    }
    return $template;
}
add_filter('wc_get_template', 'tdclassic_override_product_tabs_template', 10, 3);

/**
 * Email Configuration Settings
 */

// Add email configuration menu to admin
function tdclassic_add_email_config_menu()
{
    add_menu_page(
        'Cấu hình Email',
        'Cấu hình Email',
        'manage_options',
        'email-config',
        'tdclassic_email_config_page',
        'dashicons-email-alt',
        30
    );
}
add_action('admin_menu', 'tdclassic_add_email_config_menu');

// Email configuration page
function tdclassic_email_config_page()
{
    // Save settings
    if (isset($_POST['submit'])) {
        update_option('tdclassic_smtp_host', sanitize_text_field($_POST['smtp_host']));
        update_option('tdclassic_smtp_port', sanitize_text_field($_POST['smtp_port']));
        update_option('tdclassic_smtp_username', sanitize_text_field($_POST['smtp_username']));
        update_option('tdclassic_smtp_password', sanitize_text_field($_POST['smtp_password']));
        update_option('tdclassic_smtp_encryption', sanitize_text_field($_POST['smtp_encryption']));
        update_option('tdclassic_from_email', sanitize_email($_POST['from_email']));
        update_option('tdclassic_from_name', sanitize_text_field($_POST['from_name']));
        update_option('tdclassic_admin_email', sanitize_email($_POST['admin_email']));

        echo '<div class="notice notice-success"><p>Cấu hình email đã được lưu thành công!</p></div>';
    }

    // Get current settings
    $smtp_host = get_option('tdclassic_smtp_host', '');
    $smtp_port = get_option('tdclassic_smtp_port', '587');
    $smtp_username = get_option('tdclassic_smtp_username', '');
    $smtp_password = get_option('tdclassic_smtp_password', '');
    $smtp_encryption = get_option('tdclassic_smtp_encryption', 'tls');
    $from_email = get_option('tdclassic_from_email', get_option('admin_email'));
    $from_name = get_option('tdclassic_from_name', get_bloginfo('name'));
    $admin_email = get_option('tdclassic_admin_email', get_option('admin_email'));

    ?>
    <div class="wrap">
        <h1>Cấu hình Email</h1>
        <p>Thiết lập cấu hình SMTP để gửi email từ website.</p>

        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="smtp_host">SMTP Host</label>
                    </th>
                    <td>
                        <input type="text" id="smtp_host" name="smtp_host" value="<?php echo esc_attr($smtp_host); ?>"
                            class="regular-text" />
                        <p class="description">Ví dụ: smtp.gmail.com, smtp.office365.com</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="smtp_port">SMTP Port</label>
                    </th>
                    <td>
                        <input type="number" id="smtp_port" name="smtp_port" value="<?php echo esc_attr($smtp_port); ?>"
                            class="regular-text" />
                        <p class="description">Thường là 587 (TLS) hoặc 465 (SSL)</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="smtp_username">SMTP Username</label>
                    </th>
                    <td>
                        <input type="text" id="smtp_username" name="smtp_username"
                            value="<?php echo esc_attr($smtp_username); ?>" class="regular-text" />
                        <p class="description">Email đăng nhập SMTP</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="smtp_password">SMTP Password</label>
                    </th>
                    <td>
                        <input type="password" id="smtp_password" name="smtp_password"
                            value="<?php echo esc_attr($smtp_password); ?>" class="regular-text" />
                        <p class="description">Mật khẩu email hoặc app password</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="smtp_encryption">Mã hóa</label>
                    </th>
                    <td>
                        <select id="smtp_encryption" name="smtp_encryption">
                            <option value="tls" <?php selected($smtp_encryption, 'tls'); ?>>TLS</option>
                            <option value="ssl" <?php selected($smtp_encryption, 'ssl'); ?>>SSL</option>
                            <option value="none" <?php selected($smtp_encryption, 'none'); ?>>Không mã hóa</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="from_email">Email gửi từ</label>
                    </th>
                    <td>
                        <input type="email" id="from_email" name="from_email" value="<?php echo esc_attr($from_email); ?>"
                            class="regular-text" />
                        <p class="description">Email sẽ hiển thị trong phần "From"</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="from_name">Tên người gửi</label>
                    </th>
                    <td>
                        <input type="text" id="from_name" name="from_name" value="<?php echo esc_attr($from_name); ?>"
                            class="regular-text" />
                        <p class="description">Tên sẽ hiển thị trong phần "From"</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="admin_email">Email nhận thông báo</label>
                    </th>
                    <td>
                        <input type="email" id="admin_email" name="admin_email"
                            value="<?php echo esc_attr($admin_email); ?>" class="regular-text" />
                        <p class="description">Email nhận thông báo từ form liên hệ</p>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Lưu cấu hình">
                <button type="button" id="test_email" class="button button-secondary">Gửi email test</button>
            </p>
        </form>

        <div id="test_email_result" class="test-email-result" style="display: none;"></div>

        <?php
        // Enqueue admin email test script
        $theme_version = wp_get_theme()->get('Version');
        wp_enqueue_script('tdclassic-admin-email', get_template_directory_uri() . '/assets/js/admin/admin-email.js', array('jquery'), $theme_version, true);
        wp_localize_script('tdclassic-admin-email', 'tdclassicEmailTest', array(
            'nonce' => wp_create_nonce('tdclassic_test_email')
        ));
        ?>
    </div>
    <?php
}

// Test email functionality
function tdclassic_test_email()
{
    check_ajax_referer('tdclassic_test_email', 'nonce');

    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized');
    }

    $to = get_option('tdclassic_admin_email', get_option('admin_email'));
    $subject = 'Test Email - TD Classic Website';
    $message = "Đây là email test từ website TD Classic.\n\n";
    $message .= "Thời gian: " . current_time('mysql') . "\n";
    $message .= "Website: " . get_bloginfo('name') . "\n";
    $message .= "URL: " . get_bloginfo('url') . "\n\n";
    $message .= "Nếu bạn nhận được email này, có nghĩa là cấu hình SMTP đã hoạt động thành công!";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_option('tdclassic_from_name', get_bloginfo('name')) . ' <' . get_option('tdclassic_from_email', get_option('admin_email')) . '>'
    );

    $sent = wp_mail($to, $subject, $message, $headers);

    if ($sent) {
        wp_send_json_success('Email test đã được gửi thành công! Vui lòng kiểm tra hộp thư.');
    } else {
        wp_send_json_error('Không thể gửi email test. Vui lòng kiểm tra lại cấu hình SMTP.');
    }
}
add_action('wp_ajax_tdclassic_test_email', 'tdclassic_test_email');

// Configure WordPress to use SMTP
function tdclassic_configure_smtp($phpmailer)
{
    $smtp_host = get_option('tdclassic_smtp_host');
    $smtp_port = get_option('tdclassic_smtp_port', '587');
    $smtp_username = get_option('tdclassic_smtp_username');
    $smtp_password = get_option('tdclassic_smtp_password');
    $smtp_encryption = get_option('tdclassic_smtp_encryption', 'tls');

    // Only configure if SMTP settings are provided
    if (!empty($smtp_host) && !empty($smtp_username) && !empty($smtp_password)) {
        $phpmailer->isSMTP();
        $phpmailer->Host = $smtp_host;
        $phpmailer->Port = $smtp_port;
        $phpmailer->SMTPAuth = true;
        $phpmailer->Username = $smtp_username;
        $phpmailer->Password = $smtp_password;

        if ($smtp_encryption === 'ssl') {
            $phpmailer->SMTPSecure = 'ssl';
        } elseif ($smtp_encryption === 'tls') {
            $phpmailer->SMTPSecure = 'tls';
        }

        // Set from email and name
        $from_email = get_option('tdclassic_from_email', get_option('admin_email'));
        $from_name = get_option('tdclassic_from_name', get_bloginfo('name'));

        $phpmailer->setFrom($from_email, $from_name);
    }
}
add_action('phpmailer_init', 'tdclassic_configure_smtp');

// Update contact form to use configured admin email
function tdclassic_handle_contact_form()
{
    // Check nonce
    if (!wp_verify_nonce($_POST['nonce'], 'contact_form_nonce')) {
        wp_send_json_error('Security check failed');
    }

    // Sanitize form data
    $name = sanitize_text_field($_POST['contact_name']);
    $email = sanitize_email($_POST['contact_email']);
    $phone = sanitize_text_field($_POST['contact_phone']);
    $company = sanitize_text_field($_POST['contact_company']);
    $subject = sanitize_text_field($_POST['contact_subject']);
    $message = sanitize_textarea_field($_POST['contact_message']);
    $newsletter = isset($_POST['contact_newsletter']) ? 1 : 0;

    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        wp_send_json_error('Vui lòng điền đầy đủ thông tin bắt buộc.');
    }

    // Validate email
    if (!is_email($email)) {
        wp_send_json_error('Email không hợp lệ.');
    }

    // Prepare email content
    $to = get_option('tdclassic_admin_email', get_option('admin_email'));
    $email_subject = 'Liên hệ từ website: ' . $subject;

    $email_body = "Thông tin liên hệ mới từ website:\n\n";
    $email_body .= "Họ tên: " . $name . "\n";
    $email_body .= "Email: " . $email . "\n";
    $email_body .= "Điện thoại: " . $phone . "\n";
    $email_body .= "Công ty: " . $company . "\n";
    $email_body .= "Chủ đề: " . $subject . "\n";
    $email_body .= "Đăng ký nhận tin: " . ($newsletter ? 'Có' : 'Không') . "\n\n";
    $email_body .= "Tin nhắn:\n" . $message . "\n\n";
    $email_body .= "---\n";
    $email_body .= "Gửi từ: " . get_bloginfo('name') . "\n";
    $email_body .= "Thời gian: " . current_time('mysql') . "\n";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $name . ' <' . $email . '>',
        'Reply-To: ' . $email
    );

    // Send email
    $sent = wp_mail($to, $email_subject, $email_body, $headers);

    if ($sent) {
        // Save to database (optional)
        global $wpdb;
        $table_name = $wpdb->prefix . 'contact_messages';

        $wpdb->insert(
            $table_name,
            array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'company' => $company,
                'subject' => $subject,
                'message' => $message,
                'newsletter' => $newsletter,
                'created_at' => current_time('mysql')
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s')
        );

        wp_send_json_success('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.');
    } else {
        wp_send_json_error('Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại sau.');
    }
}
add_action('wp_ajax_handle_contact_form', 'tdclassic_handle_contact_form');
add_action('wp_ajax_nopriv_handle_contact_form', 'tdclassic_handle_contact_form');

// Remove old contact form handler
remove_action('wp_ajax_handle_contact_form', 'handle_contact_form');
remove_action('wp_ajax_nopriv_handle_contact_form', 'handle_contact_form');

/**
 * Contact Messages Management
 */

// Add contact messages submenu
function tdclassic_add_contact_messages_menu()
{
    add_submenu_page(
        'email-config',
        'Tin nhắn liên hệ',
        'Tin nhắn liên hệ',
        'manage_options',
        'contact-messages',
        'tdclassic_contact_messages_page'
    );
}
add_action('admin_menu', 'tdclassic_add_contact_messages_menu');

// Contact messages page
function tdclassic_contact_messages_page()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_messages';

    // Handle message deletion
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $wpdb->delete($table_name, array('id' => $id), array('%d'));
        echo '<div class="notice notice-success"><p>Tin nhắn đã được xóa thành công!</p></div>';
    }

    // Get messages with pagination
    $per_page = 20;
    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $offset = ($current_page - 1) * $per_page;

    $messages = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name ORDER BY created_at DESC LIMIT %d OFFSET %d",
            $per_page,
            $offset
        )
    );

    $total_messages = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    $total_pages = ceil($total_messages / $per_page);

    ?>
    <div class="wrap">
        <h1>Tin nhắn liên hệ</h1>
        <p>Tổng cộng: <?php echo $total_messages; ?> tin nhắn</p>

        <?php if (empty($messages)): ?>
            <div class="notice notice-info">
                <p>Chưa có tin nhắn liên hệ nào.</p>
            </div>
        <?php else: ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Thời gian</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Điện thoại</th>
                        <th>Chủ đề</th>
                        <th>Tin nhắn</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $message): ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i', strtotime($message->created_at)); ?></td>
                            <td>
                                <strong><?php echo esc_html($message->name); ?></strong>
                                <?php if (!empty($message->company)): ?>
                                    <br><small><?php echo esc_html($message->company); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="mailto:<?php echo esc_attr($message->email); ?>">
                                    <?php echo esc_html($message->email); ?>
                                </a>
                            </td>
                            <td>
                                <?php if (!empty($message->phone)): ?>
                                    <a href="tel:<?php echo esc_attr($message->phone); ?>">
                                        <?php echo esc_html($message->phone); ?>
                                    </a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><?php echo esc_html($message->subject); ?></td>
                            <td>
                                <div class="message-preview">
                                    <?php echo esc_html(wp_trim_words($message->message, 20, '...')); ?>
                                    <button type="button" class="button button-small view-message"
                                        data-message="<?php echo esc_attr($message->message); ?>"
                                        data-subject="<?php echo esc_attr($message->subject); ?>"
                                        data-name="<?php echo esc_attr($message->name); ?>">
                                        Xem chi tiết
                                    </button>
                                </div>
                            </td>
                            <td>
                                <a href="mailto:<?php echo esc_attr($message->email); ?>?subject=Re: <?php echo esc_attr($message->subject); ?>"
                                    class="button button-small">
                                    Trả lời
                                </a>
                                <a href="<?php echo admin_url('admin.php?page=contact-messages&action=delete&id=' . $message->id); ?>"
                                    class="button button-small button-link-delete"
                                    data-confirm-delete="Bạn có chắc chắn muốn xóa tin nhắn này?">
                                    Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if ($total_pages > 1): ?>
                <div class="tablenav">
                    <div class="tablenav-pages">
                        <?php
                        echo paginate_links(array(
                            'base' => add_query_arg('paged', '%#%'),
                            'format' => '',
                            'prev_text' => '&laquo; Trước',
                            'next_text' => 'Sau &raquo;',
                            'total' => $total_pages,
                            'current' => $current_page
                        ));
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Message Detail Modal -->
        <div id="message-modal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="modal-subject"></h2>
                <p><strong>Người gửi:</strong> <span id="modal-name"></span></p>
                <div id="modal-message"></div>
            </div>
        </div>

        <style>
            .modal {
                display: none;
                position: fixed;
                z-index: 1000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.4);
            }

            .modal-content {
                background-color: #fefefe;
                margin: 15% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
                max-width: 600px;
                border-radius: 5px;
            }

            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
                cursor: pointer;
            }

            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }

            .message-preview {
                max-width: 300px;
            }

            .view-message {
                margin-top: 5px;
            }
        </style>

        <script>
            jQuery(document).ready(function ($) {
                // Modal functionality
                $('.view-message').click(function () {
                    var message = $(this).data('message');
                    var subject = $(this).data('subject');
                    var name = $(this).data('name');

                    $('#modal-subject').text(subject);
                    $('#modal-name').text(name);
                    $('#modal-message').html(message.replace(/\n/g, '<br>'));
                    $('#message-modal').show();
                });

                $('.close').click(function () {
                    $('#message-modal').hide();
                });

                $(window).click(function (event) {
                    if (event.target == document.getElementById('message-modal')) {
                        $('#message-modal').hide();
                    }
                });
            });
        </script>
    </div>
    <?php
}

// Add export functionality
function tdclassic_export_contact_messages()
{
    if (isset($_GET['action']) && $_GET['action'] === 'export' && isset($_GET['page']) && $_GET['page'] === 'contact-messages') {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'contact_messages';

        $messages = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");

        // Set headers for CSV download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=contact-messages-' . date('Y-m-d') . '.csv');

        // Create file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        // Add BOM for UTF-8
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Add CSV headers
        fputcsv($output, array('Thời gian', 'Họ tên', 'Email', 'Điện thoại', 'Công ty', 'Chủ đề', 'Tin nhắn', 'Đăng ký nhận tin'));

        // Add data
        foreach ($messages as $message) {
            fputcsv($output, array(
                $message->created_at,
                $message->name,
                $message->email,
                $message->phone,
                $message->company,
                $message->subject,
                $message->message,
                $message->newsletter ? 'Có' : 'Không'
            ));
        }

        fclose($output);
        exit;
    }
}
add_action('admin_init', 'tdclassic_export_contact_messages');

// Add export button to contact messages page
function tdclassic_add_export_button()
{
    if (isset($_GET['page']) && $_GET['page'] === 'contact-messages') {
        ?>
        <div class="wrap">
            <h1>Tin nhắn liên hệ</h1>
            <div class="tablenav top">
                <div class="alignleft actions">
                    <a href="<?php echo admin_url('admin.php?page=contact-messages&action=export'); ?>"
                        class="button button-primary">
                        Xuất CSV
                    </a>
                </div>
            </div>
        </div>
        <?php
    }
}
add_action('admin_notices', 'tdclassic_add_export_button');

// Enqueue admin styles for email configuration
function tdclassic_admin_email_styles($hook)
{
    if ($hook === 'toplevel_page_email-config' || $hook === 'email-config_page_contact-messages') {
        wp_enqueue_style(
            'tdclassic-admin-email-config',
            get_template_directory_uri() . '/admin-email-config.css',
            array(),
            '1.0.0'
        );
    }
}
add_action('admin_enqueue_scripts', 'tdclassic_admin_email_styles');

/**
 * Helper functions to get company contact info
 */

// Get company phone number (backward compatible)
function tdclassic_get_company_phone()
{
    // Sử dụng hệ thống mới từ admin-company-info.php
    if (function_exists('tdclassic_get_primary_phone')) {
        return tdclassic_get_primary_phone();
    }
    return get_option('tdclassic_company_phone', '+84 904 433 799');
}

// Get company address (backward compatible)
function tdclassic_get_company_address()
{
    // Sử dụng hệ thống mới từ admin-company-info.php
    if (function_exists('tdclassic_get_primary_address')) {
        return tdclassic_get_primary_address();
    }
    return get_option('tdclassic_company_address', 'Số 22A Ngô Quyền, phường Ngô Quyền, Thành phố Hải Phòng, Việt Nam');
}

// Display company phone with link
function tdclassic_display_phone($echo = true)
{
    $phone = tdclassic_get_company_phone();
    $output = '<a href="tel:' . esc_attr(preg_replace('/[^0-9+]/', '', $phone)) . '">' . esc_html($phone) . '</a>';

    if ($echo) {
        echo $output;
    } else {
        return $output;
    }
}

// Display company address
function tdclassic_display_address($echo = true)
{
    $address = tdclassic_get_company_address();
    $output = '<span class="company-address">' . esc_html($address) . '</span>';

    if ($echo) {
        echo $output;
    } else {
        return $output;
    }
}

// Get company email (backward compatible)
function tdclassic_get_company_email()
{
    // Sử dụng hệ thống mới từ admin-company-info.php
    if (function_exists('tdclassic_get_primary_email')) {
        return tdclassic_get_primary_email();
    }
    return get_option('tdclassic_company_email', 'cskh.tdclassic@gmail.com');
}

// Display company email with mailto link
function tdclassic_display_email($echo = true)
{
    $email = tdclassic_get_company_email();
    $output = '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
    if ($echo) {
        echo $output;
    } else {
        return $output;
    }
}

/**
 * Company Profile (Hồ sơ năng lực) settings and helpers
 */

// Add Company Profile PDF setting to Settings → General
function tdclassic_add_company_profile_settings()
{
    add_settings_section(
        'tdclassic_company_profile_section',
        __('Hồ sơ năng lực', 'tdclassic'),
        function () {
            echo '<p>' . __('Cấu hình file PDF hồ sơ năng lực để hiển thị trên trang công khai.', 'tdclassic') . '</p>';
        },
        'general'
    );

    add_settings_field(
        'tdclassic_company_profile_pdf',
        __('File PDF hồ sơ năng lực', 'tdclassic'),
        'tdclassic_company_profile_pdf_callback',
        'general',
        'tdclassic_company_profile_section'
    );

    register_setting('general', 'tdclassic_company_profile_pdf');
}
add_action('admin_init', 'tdclassic_add_company_profile_settings');

// Render input + select button
function tdclassic_company_profile_pdf_callback()
{
    $pdf_url = esc_url(get_option('tdclassic_company_profile_pdf', ''));
    echo '<input type="url" id="tdclassic_company_profile_pdf" name="tdclassic_company_profile_pdf" value="' . $pdf_url . '" class="regular-text" placeholder="https://.../ho-so-nang-luc.pdf" />';
    echo ' <button type="button" class="button" id="tdclassic_select_company_profile_pdf">' . __('Chọn file', 'tdclassic') . '</button>';
    echo '<p class="description">' . __('Chọn hoặc dán URL file PDF. Sau khi lưu, trang Hồ sơ năng lực sẽ hiển thị tài liệu này.', 'tdclassic') . '</p>';
    ?>
    <script>
        (function ($) {
            $(document).on('click', '#tdclassic_select_company_profile_pdf', function (e) {
                e.preventDefault();
                if (typeof wp === 'undefined' || !wp.media) { return; }
                const frame = wp.media({
                    title: '<?php echo esc_js(__('Chọn file PDF hồ sơ năng lực', 'tdclassic')); ?>',
                    library: { type: 'application/pdf' },
                    button: { text: '<?php echo esc_js(__('Chọn', 'tdclassic')); ?>' },
                    multiple: false
                });
                frame.on('select', function () {
                    const attachment = frame.state().get('selection').first().toJSON();
                    if (attachment && attachment.url) {
                        $('#tdclassic_company_profile_pdf').val(attachment.url);
                    }
                });
                frame.open();
            });
        })(jQuery);
    </script>
    <?php
}

// Ensure media scripts available in admin
function tdclassic_admin_enqueue_media($hook)
{
    if ($hook === 'options-general.php') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'tdclassic_admin_enqueue_media');

// Helper to get Company Profile PDF URL
function tdclassic_get_company_profile_pdf_url()
{
    return esc_url(get_option('tdclassic_company_profile_pdf', ''));
}

// Shortcode to display the embedded Company Profile PDF
function tdclassic_company_profile_shortcode($atts)
{
    $pdf_url = tdclassic_get_company_profile_pdf_url();
    if (empty($pdf_url)) {
        return '<div class="alert alert-warning" role="alert">' . __('Chưa cấu hình file PDF hồ sơ năng lực. Vui lòng vào Settings → General để thiết lập.', 'tdclassic') . '</div>';
    }
    $download = '<p class="mt-3"><a class="btn btn-dark" href="' . esc_url($pdf_url) . '" target="_blank" rel="noopener">' . __('Tải về PDF', 'tdclassic') . '</a></p>';
    $embed = '<div class="container my-4"><div class="ratio ratio-4x3"><iframe src="' . esc_url($pdf_url) . '#view=fitH" style="border:0;" loading="lazy" allowfullscreen></iframe></div>' . $download . '</div>';
    return $embed;
}
add_shortcode('tdclassic_company_profile', 'tdclassic_company_profile_shortcode');

// Company Profile CSS - Now handled in tdclassic_scripts() function above
// Removed duplicate enqueue function

/**
 * Project helpers
 */
function tdclassic_get_project_thumb_url($post_id = null, $size = 'project-thumb')
{
    $post_id = $post_id ? $post_id : get_the_ID();
    if (has_post_thumbnail($post_id)) {
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);
        if ($image && !empty($image[0])) {
            return $image[0];
        }
    }
    // Placeholder mặc định theo phong cách TD Classic
    return get_template_directory_uri() . '/assets/images/project-placeholder.jpg';
}

/* --- CODE LẤY TIN (DÀNH CHO LOCALHOST / TIN TỨC) --- */
/**
 * Lấy bài viết từ site chính TavaLED thông qua REST API.
 *
 * @param int  $quantity     Số bài trên mỗi trang.
 * @param int  $page         Trang hiện tại (phục vụ phân trang).
 * @param int  $total_pages  (tham chiếu) Tổng số trang lấy từ header API.
 *
 * @return array Danh sách bài viết đã được chuẩn hoá.
 */
function get_posts_from_main_site($quantity = 3, $page = 1, &$total_pages = 1)
{
    $quantity = max(1, (int) $quantity);
    $page = max(1, (int) $page);
    $total_pages = 1;

    // 1. Nếu đang làm giao diện, có thể bật cache để nhẹ server hơn
    // $cache_key    = 'db_main_posts_' . $quantity . '_page_' . $page;
    // $cached_posts = get_transient($cache_key);
    // if (false !== $cached_posts) {
    //     $total_pages = isset($cached_posts['total_pages']) ? (int) $cached_posts['total_pages'] : 1;
    //     return isset($cached_posts['items']) ? $cached_posts['items'] : [];
    // }

    $api_url = add_query_arg(
        array(
            '_embed' => 1,
            'per_page' => $quantity,
            'page' => $page,
        ),
        'https://tavaled.vn/wp-json/wp/v2/posts'
    );

    // QUAN TRỌNG: Thêm 'sslverify' => false để tránh lỗi trên Localhost
    $response = wp_remote_get(
        $api_url,
        array(
            'timeout' => 15,
            'sslverify' => false,
        )
    );

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) != 200) {
        // Mẹo: In lỗi ra để xem nếu không lấy được tin
        // echo '<pre>'; print_r($response); echo '</pre>';
        return array();
    }

    $posts_data = json_decode(wp_remote_retrieve_body($response), true);
    $total_pages = (int) wp_remote_retrieve_header($response, 'x-wp-totalpages');
    if ($total_pages < 1) {
        $total_pages = 1;
    }

    $final_posts = array();

    if (!empty($posts_data) && is_array($posts_data)) {
        foreach ($posts_data as $post) {
            // Ảnh đại diện
            $thumbnail = isset($post['_embedded']['wp:featuredmedia'][0]['source_url'])
                ? $post['_embedded']['wp:featuredmedia'][0]['source_url']
                : 'https://via.placeholder.com/400x250?text=TavaLED';

            // Ngày đăng
            $raw_date = isset($post['date']) ? $post['date'] : '';
            $date = $raw_date ? date_i18n('d/m/Y', strtotime($raw_date)) : '';

            // Tác giả (nếu có _embed)
            $author_name = '';
            if (isset($post['_embedded']['author'][0]['name'])) {
                $author_name = $post['_embedded']['author'][0]['name'];
            }

            // Nội dung & thời gian đọc ước lượng
            $content_rendered = isset($post['content']['rendered']) ? $post['content']['rendered'] : '';
            $content_text = wp_strip_all_tags($content_rendered);
            $word_count = !empty($content_text) ? str_word_count($content_text) : 0;
            $reading_time = max(1, (int) ceil($word_count / 200));

            // Meta description (ưu tiên từ plugin SEO, fallback sang excerpt / content)
            $meta_description = '';
            // Yoast SEO thường lưu ở yoast_head_json.description
            if (isset($post['yoast_head_json']['description']) && !empty($post['yoast_head_json']['description'])) {
                $meta_description = wp_strip_all_tags($post['yoast_head_json']['description']);
            } elseif (isset($post['excerpt']['rendered']) && !empty($post['excerpt']['rendered'])) {
                $meta_description = wp_trim_words(wp_strip_all_tags($post['excerpt']['rendered']), 120, '...');
            } elseif (!empty($content_text)) {
                $meta_description = wp_trim_words($content_text, 120, '...');
            }

            // Category chính (nếu có _embed terms)
            $main_category = '';
            if (isset($post['_embedded']['wp:term'][0]) && is_array($post['_embedded']['wp:term'][0])) {
                foreach ($post['_embedded']['wp:term'][0] as $term) {
                    if (isset($term['name'])) {
                        $main_category = $term['name'];
                        break;
                    }
                }
            }

            $final_posts[] = array(
                'title' => isset($post['title']['rendered']) ? $post['title']['rendered'] : '',
                'link' => isset($post['link']) ? $post['link'] : '',
                'excerpt' => isset($post['excerpt']['rendered']) ? wp_trim_words(wp_strip_all_tags($post['excerpt']['rendered']), 120, '...') : '',
                'image' => $thumbnail,
                'date' => $date,
                'raw_date' => $raw_date,
                'author' => $author_name,
                'reading_time' => $reading_time,
                'main_category' => $main_category,
                'meta_description' => $meta_description,
            );
        }

        // Dev xong nếu muốn có thể bật cache lại cho nhẹ server
        // set_transient(
        //     $cache_key,
        //     array(
        //         'items'       => $final_posts,
        //         'total_pages' => $total_pages,
        //     ),
        //     600 // Cache 10 phút
        // );
    }

    return $final_posts;
}