<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta name="google-site-verification" content="35TfiXUHMlaZi3kdFlm-4Zg0SJIPBriGjPDah-BkYmo" />
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#main"><?php _e('Skip to content', 'tdclassic'); ?></a>

    <!-- Top Header - Thông tin liên hệ và Social -->
    <div class="top-header">
        <div class="container">
            <div class="contact-info">
                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', tdclassic_get_company_phone())); ?>" class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span><?php echo esc_html(tdclassic_get_company_phone()); ?></span>
                </a>
                <a href="mailto:<?php echo esc_attr(tdclassic_get_company_email()); ?>" class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span><?php echo esc_html(tdclassic_get_company_email()); ?></span>
                </a>
            </div>
            <div class="top-actions">
                <?php
                $profile_page = get_page_by_path('ho-so-nang-luc');
                $profile_url = $profile_page ? get_permalink($profile_page->ID) : home_url('/ho-so-nang-luc');
                ?>
                <a href="<?php echo esc_url($profile_url); ?>" class="btn-profile" title="Hồ sơ năng lực">
                    <i class="fas fa-file"></i>
                    <span class="d-none d-sm-inline ms-1">Hồ sơ năng lực</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Header - Logo và Navigation -->
    <header id="masthead" class="site-header main-header">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <div class="header-left d-flex align-items-center">
                    <!-- Logo -->
                    <a class="navbar-brand me-3" href="<?php echo esc_url(home_url('/')); ?>">
                        <?php
                        $custom_logo_id = get_theme_mod('custom_logo');
                        if ($custom_logo_id) {
                            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                            echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" height="30">';
                        } else {
                            bloginfo('name');
                        }
                        ?>
                    </a>
					<!-- Simplified: Removed JS-dependent DateTime & Weather Widget -->
                </div>
                
                <!-- Bottom Header - Mobile Navigation -->
				<div class="bottom-header">
						<a href="<?php echo home_url('/san-pham'); ?>" class="mobile-nav-item">
							<i class="fas fa-box"></i>
							<span class="nav-text">Sản phẩm</span>
						</a>
						<a href="<?php echo home_url('/tin-tuc'); ?>" class="mobile-nav-item">
							<i class="fas fa-share-alt"></i>
							<span class="nav-text">Kinh nghiệm</span>
						</a>
						<a href="<?php echo home_url('/lien-he'); ?>" class="mobile-nav-item">
							<i class="fas fa-envelope"></i>
							<span class="nav-text">Liên hệ</span>
						</a>
				</div>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/'); ?>">
                                <i class="fas fa-home me-1"></i>Trang chủ
                            </a>
                        </li>
                        
                        <!-- Products Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="<?php echo home_url('/san-pham'); ?>" id="productsDropdown" role="button">
                                <i class="fas fa-box me-1"></i>Sản phẩm
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="productsDropdown">
                                <li><a class="dropdown-item" href="<?php echo home_url('/san-pham'); ?>">
                                    <i class="fas fa-th-large me-2"></i>Tất cả sản phẩm
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <?php
                                $product_categories = array();
                                if (class_exists('WooCommerce')) {
                                    $product_categories = get_terms(array(
                                        'taxonomy' => 'product_cat',
                                        'hide_empty' => false,
                                        'orderby' => 'name',
                                        'order' => 'ASC'
                                    ));
                                }
                                
                                // Debug: Check if we have categories
                                if (is_wp_error($product_categories)) {
                                    error_log('Product categories error: ' . $product_categories->get_error_message());
                                }
                                
                                $category_icons = array(
                                    // Audio & Sound categories
                                    'combo' => 'fas fa-layer-group',
                                    'ban-tron' => 'fas fa-circle',
                                    'tron' => 'fas fa-circle',
                                    'am-thanh' => 'fas fa-volume-up',
                                    'bo-xu-ly' => 'fas fa-microchip',
                                    'xu-ly' => 'fas fa-microchip',
                                    'tin-hieu' => 'fas fa-wave-square',
                                    'loa' => 'fas fa-volume-up',
                                    'chuyen-nghiep' => 'fas fa-star',
                                    'microphone' => 'fas fa-microphone',
                                    'micro' => 'fas fa-microphone',
                                    'phu-kien' => 'fas fa-plug',
                                    'quan-ly' => 'fas fa-cogs',
                                    'nguon' => 'fas fa-plug',
                                    'thiet-bi' => 'fas fa-cog',
                                    'khuech-dai' => 'fas fa-broadcast-tower',
                                    'amplifier' => 'fas fa-broadcast-tower',
                                    // General categories
                                    'web' => 'fas fa-globe',
                                    'mobile' => 'fas fa-mobile-alt',
                                    'app' => 'fas fa-mobile-alt',
                                    'desktop' => 'fas fa-desktop',
                                    'design' => 'fas fa-palette',
                                    'graphic' => 'fas fa-palette',
                                    'marketing' => 'fas fa-bullhorn',
                                    'digital' => 'fas fa-bullhorn',
                                    'consulting' => 'fas fa-users',
                                    'hosting' => 'fas fa-server',
                                    'domain' => 'fas fa-link',
                                    'ecommerce' => 'fas fa-shopping-cart',
                                    'seo' => 'fas fa-search',
                                    'default' => 'fas fa-folder'
                                );
                                
                                if ($product_categories && !is_wp_error($product_categories) && !empty($product_categories)) :
                                    foreach ($product_categories as $category) :
                                        $icon = $category_icons['default'];
                                        $slug = $category->slug;
                                        foreach ($category_icons as $key => $value) {
                                            if (strpos($slug, $key) !== false) {
                                                $icon = $value;
                                                break;
                                            }
                                        }
                                ?>
                                    <li><a class="dropdown-item" href="<?php echo get_term_link($category); ?>">
                                        <i class="<?php echo $icon; ?> me-2"></i>
                                        <?php echo $category->name; ?>
                                        <span class="badge bg-secondary ms-2"><?php echo $category->count; ?></span>
                                    </a></li>
                                <?php
                                    endforeach;
                                else :
                                ?>
                                    <li><a class="dropdown-item disabled" href="#">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <?php echo !class_exists('WooCommerce') ? 'Cần kích hoạt WooCommerce' : 'Chưa có danh mục sản phẩm'; ?>
                                    </a></li>
                                <?php
                                endif;
                                ?>
                            </ul>
                        </li>
                        
                        <!-- News Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="<?php echo home_url('/tin-tuc'); ?>" id="newsDropdown" role="button">
                                <i class="fas fa-newspaper me-1"></i>Tin tức
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="newsDropdown">
                                <li><a class="dropdown-item" href="<?php echo home_url('/tin-tuc'); ?>">
                                    <i class="fas fa-list me-2"></i>Tất cả tin tức
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <?php
                                $news_categories = get_categories(array(
                                    'orderby' => 'name',
                                    'order' => 'ASC',
                                    'hide_empty' => false
                                ));
                                
                                $news_icons = array(
                                    'tech' => 'fas fa-microchip',
                                    'business' => 'fas fa-briefcase',
                                    'marketing' => 'fas fa-chart-line',
                                    'tutorial' => 'fas fa-graduation-cap',
                                    'news' => 'fas fa-newspaper',
                                    'event' => 'fas fa-calendar-alt',
                                    'default' => 'fas fa-folder-open'
                                );
                                
                                if ($news_categories) :
                                    foreach ($news_categories as $category) :
                                        $icon = $news_icons['default'];
                                        $slug = $category->slug;
                                        foreach ($news_icons as $key => $value) {
                                            if (strpos($slug, $key) !== false) {
                                                $icon = $value;
                                                break;
                                            }
                                        }
                                ?>
                                    <li><a class="dropdown-item" href="<?php echo get_category_link($category); ?>">
                                        <i class="<?php echo $icon; ?> me-2"></i>
                                        <?php echo $category->name; ?>
                                        <span class="badge bg-secondary ms-2"><?php echo $category->count; ?></span>
                                    </a></li>
                                <?php
                                    endforeach;
                                endif;
                                ?>
                            </ul>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/du-an'); ?>">
                                <i class="fas fa-briefcase me-1"></i>Dự án
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/lien-he'); ?>">
                                <i class="fas fa-envelope me-1"></i>Liên hệ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/dai-ly'); ?>">
                                <i class="fa-solid fa-store me-1"></i>Đại lý
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    

    <div id="content" class="site-content"> 