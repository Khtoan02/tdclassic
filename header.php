<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">

<head>
    <meta name="google-site-verification" content="35TfiXUHMlaZi3kdFlm-4Zg0SJIPBriGjPDah-BkYmo" />
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class('antialiased selection:bg-gold selection:text-black bg-black text-white'); ?>>
    <?php wp_body_open(); ?>

    <!-- === NEW PREMIUM FLOATING HEADER === -->
    <header class="header-wrapper sticky-header" id="main-header">

        <!-- Top Bar Segment (Luxury Separator) -->
        <?php get_template_part('template-parts/header/top-bar'); ?>

        <!-- Main Premium Navigation Bar -->
        <nav class="main-nav w-full relative">
            <div class="max-w-[1700px] mx-auto px-6 md:px-12 h-full">
                <div class="flex items-center justify-between h-full py-4 lg:py-0">

                    <!-- Mobile Trigger Menu Trigger -->
                    <div class="flex items-center gap-4 lg:hidden">
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', tdclassic_get_company_phone())); ?>"
                            class="w-10 h-10 flex items-center justify-center text-white text-base rounded-full border border-white/10 bg-white/5 hover:bg-white/20 transition-all">
                            <i class="fa-solid fa-phone text-xs"></i>
                        </a>
                        <button id="mob-menu-trigger"
                            class="w-10 h-10 flex items-center justify-center text-white text-base rounded-full border border-white/10 bg-white/5 hover:bg-white/20 transition-all"
                            aria-label="Mở trình đơn di động">
                            <i class="fa-solid fa-bars-staggered"></i>
                        </button>
                    </div>

                    <!-- LOGO AREA (Luxury Shine & Zoom) -->
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center group select-none">
                        <?php
                        $custom_logo_id = get_theme_mod('custom_logo');
                        if ($custom_logo_id) {
                            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                            if ($logo) {
                                echo '<img src="' . esc_url($logo[0]) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="h-10 md:h-12 w-auto object-contain opacity-90 group-hover:opacity-100 transition-opacity duration-300">';
                            }
                        } else {
                            echo '<span class="text-xl font-bold uppercase tracking-widest text-white font-serif">' . esc_html(get_bloginfo('name')) . '</span>';
                        }
                        ?>
                    </a>

                    <!-- PREMIUM DESKTOP MENU -->
                    <div class="hidden lg:flex items-center space-x-2 h-full">
                        <a href="<?php echo esc_url(home_url('/')); ?>"
                            class="nav-link text-xs font-semibold uppercase tracking-widest <?php echo is_front_page() ? 'active text-gold' : 'text-gray-400'; ?>">
                            Trang chủ
                        </a>
                        <a href="<?php echo esc_url(home_url('/gioi-thieu/')); ?>"
                            class="nav-link text-xs font-semibold uppercase tracking-widest <?php echo is_page('gioi-thieu') ? 'active text-gold' : 'text-gray-400'; ?>">
                            Giới thiệu
                        </a>

                        <!-- MEGA MENU (SẢN PHẨM) -->
                        <?php get_template_part('template-parts/header/mega-menu-product'); ?>

                        <!-- DROPDOWN MENU (TIN TỨC) -->
                        <?php
                        $news_categories = tdclassic_get_news_categories();
                        if (!empty($news_categories)):
                            ?>
                             <div class="has-dropdown h-full flex items-center group relative">
                                 <a href="<?php echo esc_url(home_url('/tin-tuc')); ?>"
                                     class="nav-link text-xs font-semibold uppercase tracking-widest <?php echo (is_home() || is_singular('post') || is_category()) ? 'active text-gold' : 'text-gray-400'; ?> flex items-center gap-1.5 group-hover:text-white cursor-pointer h-full">
                                     Tin tức
                                     <i class="fa-solid fa-chevron-down text-[8px] opacity-50 group-hover:opacity-100 transition-opacity mt-px"></i>
                                 </a>

                                 <!-- Dropdown Content -->
                                 <div class="dropdown-wrapper">
                                     <?php foreach ($news_categories as $news_cat): ?>
                                         <a href="<?php echo esc_url($news_cat['url']); ?>" class="dropdown-item">
                                             <?php echo esc_html($news_cat['name']); ?>
                                             <?php if ($news_cat['count'] > 0): ?>
                                                 <span class="text-gray-500 text-xs ml-2 normal-case">(<?php echo $news_cat['count']; ?>)</span>
                                             <?php endif; ?>
                                         </a>
                                     <?php endforeach; ?>
                                 </div>
                             </div>
                         <?php endif; ?>

                        <a href="<?php echo esc_url(home_url('/lien-he')); ?>"
                            class="nav-link text-xs font-semibold uppercase tracking-widest <?php echo is_page('lien-he') ? 'active text-gold' : 'text-gray-400'; ?>">
                            Liên hệ
                        </a>
                    </div>

                    <!-- Right Interactions (Online Support Badge) -->
                    <div class="flex items-center gap-4">
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', tdclassic_get_company_phone())); ?>"
                            class="hidden md:flex glass-btn-luxury px-6 py-2.5 rounded-full items-center gap-3 group transition-all">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-white group-hover:text-gold transition-colors">Tư vấn ngay</span>
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.8)]"></span>
                            </span>
                        </a>
                    </div>

                </div>
            </div>
        </nav>

        <!-- Header Bottom (Product Categories Bar) -->
        <?php get_template_part('template-parts/header/header-bottom'); ?>
    </header>

    <!-- === MOBILE MENU DRAWER (RESPONSIVE) === -->
    <?php get_template_part('template-parts/header/mobile-menu'); ?>
    <!-- === END MOBILE MENU === -->