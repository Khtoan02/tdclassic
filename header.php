<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta name="google-site-verification" content="35TfiXUHMlaZi3kdFlm-4Zg0SJIPBriGjPDah-BkYmo" />
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@200;300;400;500;700;800&family=Cormorant+Garamond:ital,wght@1,300;1,500&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* --- CORE VARIABLES --- */
        :root {
            --header-bg: #050505; 
            --glass-border-color: rgba(255, 255, 255, 0.1);
            --mega-menu-bg: #0a0a0a;
            --accent-blue: #3b82f6;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #000;
            color: white;
            margin: 0;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- HEADER STRUCTURE --- */
        .header-wrapper {
            position: relative;
            width: 100%;
            z-index: 9999;
            background-color: var(--header-bg);
            border-bottom: 1px solid var(--glass-border-color);
        }

        .top-bar {
            height: 40px;
            background: rgba(255,255,255,0.03);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .main-nav {
            height: 70px;
            position: relative;
        }

        @media (min-width: 1024px) {
            .main-nav { height: 90px; }
        }

        /* --- NAV LINKS --- */
        .nav-link {
            position: relative;
            padding: 8px 12px; /* Adjusted padding */
            border-radius: 99px;
            transition: color 0.3s ease;
            overflow: hidden;
            display: inline-block;
            white-space: nowrap;
        }

        .nav-link:hover {
            color: white;
            text-shadow: 0 0 10px rgba(255,255,255,0.5);
        }

        /* --- SUPER MEGA MENU (SẢN PHẨM) --- */
        .mega-menu-wrapper {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            pointer-events: none;
            z-index: 9998;
        }

        @media (min-width: 1024px) {
            .mega-menu-wrapper { display: block; }
        }

        .has-mega-menu:hover .mega-menu-wrapper {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: all;
        }

        .mega-menu-content {
            background: var(--mega-menu-bg);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 50px rgba(0,0,0,0.9);
            height: 500px;
            display: flex;
        }

        /* --- SIMPLE DROPDOWN MENU (TIN TỨC) --- */
        .dropdown-wrapper {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 220px;
            background: #0a0a0a;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-top: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            pointer-events: none;
            z-index: 9998;
            padding: 10px 0;
        }

        .has-dropdown:hover .dropdown-wrapper {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: all;
        }

        .dropdown-item {
            display: block;
            padding: 10px 20px;
            color: #9ca3af;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            border-left: 2px solid transparent;
        }

        .dropdown-item:hover {
            color: white;
            background: rgba(255, 255, 255, 0.05);
            border-left-color: var(--accent-blue);
            padding-left: 25px; /* Slight shift effect */
        }

        /* --- MEGA MENU COMPONENTS --- */
        .mm-sidebar {
            width: 280px;
            background: rgba(255, 255, 255, 0.02);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            padding: 30px 0;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .mm-tab-item {
            padding: 15px 30px;
            cursor: pointer;
            color: #9ca3af;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.9rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            position: relative;
        }

        .mm-tab-item:hover, .mm-tab-item.active {
            color: white;
            background: rgba(255, 255, 255, 0.05);
        }

        .mm-tab-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: var(--accent-blue);
            box-shadow: 0 0 10px var(--accent-blue);
        }

        .mm-panels {
            flex: 1;
            position: relative;
            padding: 30px 40px;
            overflow: hidden;
            display: flex;
        }

        .mm-panel {
            position: absolute;
            inset: 30px 40px;
            opacity: 0;
            visibility: hidden;
            transform: translateX(20px);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            gap: 40px;
            width: calc(100% - 80px);
            height: calc(100% - 60px);
        }

        .mm-panel.active {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
        }

        .slider-wrapper {
            flex: 1;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .panel-slider-container {
            width: 100%;
            overflow-x: auto;
            display: flex;
            gap: 20px;
            scroll-behavior: smooth;
            padding-bottom: 20px;
            scrollbar-width: none; 
            -ms-overflow-style: none;
            align-items: flex-start;
            cursor: grab;
            user-select: none;
        }
        
        .panel-slider-container.active { cursor: grabbing; scroll-behavior: auto; }
        .panel-slider-container::-webkit-scrollbar { display: none; }

        .slider-btn {
            position: absolute;
            top: 40%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .slider-wrapper:hover .slider-btn { opacity: 1; }
        .slider-btn:hover { background: white; color: black; }
        .slider-btn.prev { left: 0; }
        .slider-btn.next { right: 0; }

        .mini-product {
            width: 200px;
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            pointer-events: none;
        }
        
        .mini-product.clickable { pointer-events: auto; }
        .mini-product:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-5px);
        }

        .mini-product img {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
            opacity: 0.9;
            transition: opacity 0.3s;
            pointer-events: none;
        }
        .mini-product:hover img { opacity: 1; }
        
        .panel-featured {
            width: 280px;
            height: 100%;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            flex-shrink: 0;
        }
        .panel-featured img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s ease;
        }
        .panel-featured:hover img { transform: scale(1.05); }

        /* --- MOBILE MENU STYLES --- */
        .mobile-menu-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
            z-index: 10000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .mobile-menu-overlay.open { opacity: 1; visibility: visible; }

        .mobile-drawer {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 85%;
            max-width: 320px;
            background: #080808;
            z-index: 10001;
            transform: translateX(-100%);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            border-right: 1px solid rgba(255,255,255,0.1);
            display: flex;
            flex-direction: column;
        }
        .mobile-menu-overlay.open .mobile-drawer { transform: translateX(0); }

        .mob-link {
            display: block;
            padding: 16px 24px;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #ccc;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .mob-link:hover { color: white; background: rgba(255,255,255,0.05); }

        .mob-accordion-btn {
            width: 100%;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .mob-accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background: rgba(0,0,0,0.3);
        }
        .mob-accordion-content.open { max-height: 500px; }
        
        .mob-sub-link {
            display: block;
            padding: 12px 24px 12px 40px;
            font-size: 14px;
            color: #999;
            border-left: 2px solid transparent;
        }
        .mob-sub-link:hover {
            color: white;
            border-left-color: var(--accent-blue);
            background: rgba(255,255,255,0.02);
        }

        /* --- BUTTONS & LOGO --- */
        .glass-btn-luxury {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(5px);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);
            transition: all 0.3s ease;
        }
        .glass-btn-luxury:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.3);
            box-shadow: 0 0 15px rgba(255,255,255,0.2);
            transform: translateY(-1px);
        }
        
        /* Logo Placeholder Styling */
        .logo-placeholder {
            /* Bạn có thể thay đổi kích thước max-h tại đây nếu logo thực tế khác */
            max-height: 50px; 
            width: auto;
            object-fit: contain;
        }
    </style>
</head>


<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

    <!-- === START HEADER SECTION === -->
    <header class="header-wrapper" id="main-header">
        
        <!-- Top Bar -->
        <div class="top-bar hidden md:flex justify-between items-center px-4 md:px-8 max-w-[1600px] mx-auto text-[10px] uppercase tracking-[0.15em] text-gray-400">
            <div class="flex gap-8">
                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', tdclassic_get_company_phone())); ?>" class="hover:text-white transition-colors flex items-center gap-2 group">
                    <i class="fa-solid fa-phone text-xs group-hover:text-blue-400 transition-colors"></i> 
                    <span><?php echo esc_html(tdclassic_get_company_phone()); ?></span>
                </a>
                <a href="mailto:<?php echo esc_attr(tdclassic_get_company_email()); ?>" class="hover:text-white transition-colors flex items-center gap-2 group">
                    <i class="fa-solid fa-envelope text-xs group-hover:text-blue-400 transition-colors"></i>
                    <span><?php echo esc_html(tdclassic_get_company_email()); ?></span>
                </a>
            </div>
            <div class="flex gap-6">
                <span class="text-white/30">|</span>
                <?php
                $profile_page = get_page_by_path('ho-so-nang-luc');
                $profile_url = $profile_page ? get_permalink($profile_page->ID) : home_url('/ho-so-nang-luc');
                ?>
                <a href="<?php echo esc_url($profile_url); ?>" class="hover:text-white transition-colors">Hồ sơ năng lực</a>
                <a href="<?php echo esc_url(home_url('/dai-ly')); ?>" class="hover:text-white transition-colors">Đại lý</a>
            </div>
        </div>

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
                        
                        <!-- 1. SUPER MEGA MENU TRIGGER (SẢN PHẨM) -->
                        <?php
                        // Lấy danh mục sản phẩm cho mega menu
                        $mega_categories = tdclassic_get_mega_menu_categories(10);
                        if (!empty($mega_categories)) :
                        ?>
                        <div class="has-mega-menu h-full flex items-center group">
                            <a href="<?php echo esc_url(home_url('/san-pham')); ?>" class="nav-link text-xs font-bold uppercase tracking-widest text-gray-400 flex items-center gap-1 group-hover:text-white cursor-pointer h-full">
                                Sản phẩm
                                <i class="fa-solid fa-chevron-down text-[8px] opacity-50 group-hover:opacity-100 transition-opacity mt-px"></i>
                            </a>
                            
                            <!-- Mega Menu Wrapper -->
                            <div class="mega-menu-wrapper">
                                <div class="mega-menu-content w-full max-w-[1600px] mx-auto p-0 flex">
                                    <!-- Sidebar Tabs - Dynamic from WordPress -->
                                    <div class="mm-sidebar" id="mega-sidebar">
                                        <?php 
                                        $first_active = true;
                                        foreach ($mega_categories as $index => $category) : 
                                            $panel_id = 'panel-' . $category['slug'];
                                        ?>
                                        <div class="mm-tab-item <?php echo $first_active ? 'active' : ''; ?>" data-target="<?php echo esc_attr($panel_id); ?>">
                                            <span><?php echo esc_html($category['name']); ?></span>
                                            <i class="fa-solid fa-chevron-right text-[10px] opacity-50"></i>
                                        </div>
                                        <?php 
                                            $first_active = false;
                                        endforeach; 
                                        ?>
                                    </div>

                                    <!-- Content Panels (Slider & Featured) - Dynamic from WordPress -->
                                    <div class="mm-panels">
                                        <?php 
                                        $first_panel = true;
                                        foreach ($mega_categories as $category) : 
                                            $panel_id = 'panel-' . $category['slug'];
                                            $products = tdclassic_get_products_by_category($category['slug'], 8);
                                        ?>
                                        <div class="mm-panel <?php echo $first_panel ? 'active' : ''; ?>" id="<?php echo esc_attr($panel_id); ?>">
                                            <div class="slider-wrapper">
                                                <button class="slider-btn prev"><i class="fa-solid fa-chevron-left"></i></button>
                                                <div class="panel-slider-container">
                                                    <?php if (!empty($products)) : ?>
                                                        <?php foreach ($products as $product) : ?>
                                                        <a href="<?php echo esc_url($product['url']); ?>" class="mini-product clickable">
                                                            <img src="<?php echo esc_url($product['image_url']); ?>" alt="<?php echo esc_attr($product['title']); ?>">
                                                            <div class="p-3">
                                                                <h5 class="font-bold text-sm text-white"><?php echo esc_html($product['title']); ?></h5>
                                                                <?php if (!empty($product['price'])) : ?>
                                                                <p class="text-[10px] text-gray-400 mt-1"><?php echo wp_kses_post($product['price']); ?></p>
                                                                <?php endif; ?>
                                                            </div>
                                                        </a>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <div class="p-10 text-gray-400">Chưa có sản phẩm trong danh mục này.</div>
                                                    <?php endif; ?>
                                                </div>
                                                <button class="slider-btn next"><i class="fa-solid fa-chevron-right"></i></button>
                                            </div>
                                            <!-- Featured Image - Ảnh đại diện cho danh mục, chiều cao = chiều cao sidebar -->
                                            <div class="panel-featured">
                                                <img src="<?php echo esc_url($category['image_url']); ?>" alt="<?php echo esc_attr($category['image_alt']); ?>">
                                                <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                                                <div class="absolute bottom-6 left-6">
                                                    <span class="bg-blue-600 text-[9px] font-bold px-2 py-1 uppercase rounded mb-2 inline-block">Nổi bật</span>
                                                    <h3 class="text-xl font-bold mb-2"><?php echo esc_html($category['name']); ?></h3>
                                                    <a href="<?php echo esc_url($category['url']); ?>" class="text-xs font-bold uppercase tracking-widest border-b border-white pb-1">Xem tất cả</a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                            $first_panel = false;
                                        endforeach; 
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- 2. DROPDOWN MENU (TIN TỨC) - Dynamic from WordPress -->
                        <?php
                        $news_categories = tdclassic_get_news_categories();
                        if (!empty($news_categories)) :
                        ?>
                        <div class="has-dropdown h-full flex items-center group relative">
                            <a href="<?php echo esc_url(home_url('/tin-tuc')); ?>" class="nav-link text-xs font-bold uppercase tracking-widest text-gray-400 flex items-center gap-1 group-hover:text-white cursor-pointer h-full">
                                Tin tức
                                <i class="fa-solid fa-chevron-down text-[8px] opacity-50 group-hover:opacity-100 transition-opacity mt-px"></i>
                            </a>
                            
                            <!-- Dropdown Content - Dynamic from WordPress -->
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
    <div id="mobile-menu-overlay" class="mobile-menu-overlay">
        <div class="mobile-drawer">
            <!-- Mobile Header -->
            <div class="h-20 flex items-center justify-between px-6 border-b border-white/10 shrink-0">
                <!-- Mobile Logo -->
                <?php
                $custom_logo_id = get_theme_mod('custom_logo');
                if ($custom_logo_id) {
                    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                    if ($logo) {
                        echo '<img src="' . esc_url($logo[0]) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="h-8 w-auto">';
                    }
                } else {
                    echo '<span class="text-lg font-bold text-white">' . esc_html(get_bloginfo('name')) . '</span>';
                }
                ?>
                <button id="close-mob-menu" class="text-gray-400 hover:text-white p-2">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Links Scrollable -->
            <div class="flex-1 overflow-y-auto py-6">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="mob-link">Trang chủ</a>
                
                <!-- Accordion: Sản phẩm - Dynamic -->
                <?php if (!empty($mega_categories)) : ?>
                <div class="mob-accordion">
                    <div class="mob-link mob-accordion-btn cursor-pointer">
                        <span>Sản phẩm</span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300"></i>
                    </div>
                    <div class="mob-accordion-content">
                        <?php foreach ($mega_categories as $category) : ?>
                        <a href="<?php echo esc_url($category['url']); ?>" class="mob-sub-link"><?php echo esc_html($category['name']); ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Accordion: Tin tức - Dynamic -->
                <?php if (!empty($news_categories)) : ?>
                <div class="mob-accordion">
                    <div class="mob-link mob-accordion-btn cursor-pointer">
                        <span>Tin tức</span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300"></i>
                    </div>
                    <div class="mob-accordion-content">
                        <?php foreach ($news_categories as $news_cat) : ?>
                        <a href="<?php echo esc_url($news_cat['url']); ?>" class="mob-sub-link"><?php echo esc_html($news_cat['name']); ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="mob-link">Liên hệ</a>
            </div>

            <!-- Mobile Footer -->
            <div class="p-6 border-t border-white/10 bg-white/5 shrink-0">
                <a href="#" class="flex items-center justify-center w-full py-3 bg-white text-black font-bold uppercase tracking-widest text-xs mb-6">
                    Tư vấn ngay
                </a>
                <div class="flex flex-col gap-2 text-xs text-gray-500 uppercase tracking-wider mb-4">
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', tdclassic_get_company_phone())); ?>">
                        <i class="fa-solid fa-phone mr-2"></i> <?php echo esc_html(tdclassic_get_company_phone()); ?>
                    </a>
                    <a href="mailto:<?php echo esc_attr(tdclassic_get_company_email()); ?>">
                        <i class="fa-solid fa-envelope mr-2"></i> <?php echo esc_html(tdclassic_get_company_email()); ?>
                    </a>
                </div>
                <div class="flex gap-6 text-gray-400 text-lg">
                     <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                     <a href="#"><i class="fa-brands fa-youtube"></i></a>
                     <a href="#"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- === END MOBILE MENU === -->