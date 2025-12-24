<?php
/**
 * Header Mobile Menu
 */

// Load data again if needed because this is a separate template part
// In a highly optimized theme we might pass args, but calling these cached functions is fine
$mega_categories = tdclassic_get_mega_menu_categories(10);
$news_categories = tdclassic_get_news_categories();
?>
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
