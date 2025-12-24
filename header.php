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

    <!-- === START HEADER SECTION === -->
    <header class="header-wrapper" id="main-header">
        
        <!-- Top Bar -->
        <?php get_template_part('template-parts/header/top-bar'); ?>

        <!-- Main Navigation -->
        <nav class="main-nav w-full">
            <div class="max-w-[1500px] mx-auto px-6 h-full">
                <div class="flex items-center justify-between h-full">
                    
                    <!-- Mobile Trigger -->
                    <button id="mob-menu-trigger" class="lg:hidden text-white text-xl p-2 hover:bg-white/10 rounded-full transition z-50">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>

                    <!-- LOGO AREA -->
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center group select-none">
                        <?php
                        $custom_logo_id = get_theme_mod('custom_logo');
                        if ($custom_logo_id) {
                            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                            if ($logo) {
                                echo '<img src="' . esc_url($logo[0]) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="logo-placeholder opacity-90 group-hover:opacity-100 transition-opacity">';
                            }
                        } else {
                            // Fallback to text logo
                            echo '<span class="text-xl font-bold text-white">' . esc_html(get_bloginfo('name')) . '</span>';
                        }
                        ?>
                    </a>

                    <!-- DESKTOP MENU -->
                    <div class="hidden lg:flex items-center space-x-1 h-full">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link text-xs font-bold uppercase tracking-widest text-white">
                            Trang chủ
                        </a>
                        
                        <!-- MEGA MENU (SẢN PHẨM) -->
                         <?php get_template_part('template-parts/header/mega-menu-product'); ?>

                        <!-- DROPDOWN MENU (TIN TỨC) -->
                        <?php
                        $news_categories = tdclassic_get_news_categories();
                        if (!empty($news_categories)) :
                        ?>
                        <div class="has-dropdown h-full flex items-center group relative">
                            <a href="<?php echo esc_url(home_url('/tin-tuc')); ?>" class="nav-link text-xs font-bold uppercase tracking-widest text-gray-400 flex items-center gap-1 group-hover:text-white cursor-pointer h-full">
                                Tin tức
                                <i class="fa-solid fa-chevron-down text-[8px] opacity-50 group-hover:opacity-100 transition-opacity mt-px"></i>
                            </a>
                            
                            <!-- Dropdown Content -->
                            <div class="dropdown-wrapper">
                                <?php foreach ($news_categories as $news_cat) : ?>
                                <a href="<?php echo esc_url($news_cat['url']); ?>" class="dropdown-item">
                                    <?php echo esc_html($news_cat['name']); ?>
                                    <?php if ($news_cat['count'] > 0) : ?>
                                    <span class="text-gray-500 text-xs ml-2">(<?php echo $news_cat['count']; ?>)</span>
                                    <?php endif; ?>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="nav-link text-xs font-bold uppercase tracking-widest text-gray-400">
                            Liên hệ
                        </a>
                    </div>

                    <!-- Right Interactions -->
                    <div class="flex items-center gap-2 md:gap-4">
                        <div class="relative">
                            <button class="search-btn text-white group">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <span>Tìm kiếm...</span>
                            </button>
                        </div>

                        <a href="#" class="hidden md:flex glass-btn-luxury px-6 py-2.5 rounded-full items-center gap-3 group">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-white">Tư vấn</span>
                            <div class="w-1.5 h-1.5 rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.8)]"></div>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- === MOBILE MENU DRAWER (RESPONSIVE) === -->
    <?php get_template_part('template-parts/header/mobile-menu'); ?>
    <!-- === END MOBILE MENU === -->