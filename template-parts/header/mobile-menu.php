<?php
/**
 * Header Mobile Menu - Luxury Premium Design
 */

// Load data again if needed because this is a separate template part
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
                    echo '<img src="' . esc_url($logo[0]) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="header-logo-mobile h-8 w-auto object-contain">';
                }
            } else {
                echo '<span class="text-lg font-bold text-white uppercase tracking-widest font-serif">' . esc_html(get_bloginfo('name')) . '</span>';
            }
            ?>
            <button id="close-mob-menu" class="text-gray-400 hover:text-white p-2" aria-label="Đóng trình đơn">
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>
        </div>

        <!-- Mobile Links Scrollable -->
        <div class="flex-1 overflow-y-auto py-6">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="mob-link">Trang chủ</a>
            <a href="<?php echo esc_url(home_url('/gioi-thieu/')); ?>" class="mob-link">Giới thiệu</a>

            <!-- Accordion: Sản phẩm - Always Show, with Fallback if Empty -->
            <div class="mob-accordion">
                <div class="mob-link mob-accordion-btn cursor-pointer">
                    <span>Sản phẩm</span>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300"></i>
                </div>
                <div class="mob-accordion-content">
                    <?php if (!empty($mega_categories)): ?>
                        <?php foreach ($mega_categories as $category): ?>
                            <a href="<?php echo esc_url($category['url']); ?>"
                                class="mob-sub-link"><?php echo esc_html($category['name']); ?></a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Luxury Fallbacks when WooCommerce has no categories -->
                        <a href="<?php echo esc_url(home_url('/san-pham?cat=dan-am-thanh-karaoke')); ?>" class="mob-sub-link">
                            Dàn Âm Thanh Karaoke
                        </a>
                        <a href="<?php echo esc_url(home_url('/san-pham?cat=he-thong-xem-phim')); ?>" class="mob-sub-link">
                            Hệ Thống Xem Phim
                        </a>
                        <a href="<?php echo esc_url(home_url('/san-pham?cat=loa-nghe-nhac')); ?>" class="mob-sub-link">
                            Loa Nghe Nhạc Cao Cấp
                        </a>
                        <a href="<?php echo esc_url(home_url('/san-pham?cat=amply-hi-end')); ?>" class="mob-sub-link">
                            Amply Hi-End
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo esc_url(home_url('/san-pham')); ?>" class="mob-sub-link" style="color: var(--gold); border-left: 1px solid rgba(197, 160, 89, 0.2); margin-top: 4px;">
                        Tất cả sản phẩm <i class="fa-solid fa-arrow-right text-[8px] ml-1"></i>
                    </a>
                </div>
            </div>

            <!-- Accordion: Tin tức - Dynamic -->
            <?php if (!empty($news_categories)): ?>
                <div class="mob-accordion">
                    <div class="mob-link mob-accordion-btn cursor-pointer">
                        <span>Tin tức</span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300"></i>
                    </div>
                    <div class="mob-accordion-content">
                        <?php foreach ($news_categories as $news_cat): ?>
                            <a href="<?php echo esc_url($news_cat['url']); ?>"
                                class="mob-sub-link"><?php echo esc_html($news_cat['name']); ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="mob-link">Liên hệ</a>
        </div>

        <!-- Mobile Footer -->
        <div class="p-6 border-t border-white/10 bg-white/2 shrink-0">
            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', tdclassic_get_company_phone())); ?>"
                class="flex items-center justify-center w-full py-3 bg-[#050505] text-[#C5A059] border border-[#C5A059]/40 hover:bg-[#C5A059]/10 hover:border-[#C5A059] transition-all font-bold uppercase tracking-widest text-xs mb-6 rounded-full shadow-[0_0_15px_rgba(197,160,89,0.15)]">
                <i class="fa-solid fa-phone-volume mr-2 text-xs"></i> Tư vấn ngay
            </a>
            
            <div class="flex flex-col gap-2.5 text-xs text-gray-400 uppercase tracking-wider mb-5">
                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', tdclassic_get_company_phone())); ?>" class="hover:text-white transition-colors flex items-center">
                    <i class="fa-solid fa-phone mr-3 text-gold"></i> <?php echo esc_html(tdclassic_get_company_phone()); ?>
                </a>
                <a href="mailto:<?php echo esc_attr(tdclassic_get_company_email()); ?>" class="hover:text-white transition-colors flex items-center">
                    <i class="fa-solid fa-envelope mr-3 text-gold"></i> <?php echo esc_html(tdclassic_get_company_email()); ?>
                </a>
            </div>
            
            <div class="flex gap-6 text-gray-400 text-lg">
                <a href="#" class="hover:text-gold transition-colors"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                <a href="#" class="hover:text-gold transition-colors"><i class="fa-brands fa-youtube text-sm"></i></a>
                <a href="#" class="hover:text-gold transition-colors"><i class="fa-brands fa-tiktok text-sm"></i></a>
            </div>
        </div>
    </div>
</div>