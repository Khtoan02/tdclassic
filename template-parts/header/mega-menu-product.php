<?php
/**
 * Header Mega Menu Product - Redesigned Black & Gold luxury edition
 * Supports both WooCommerce database query and a premium mock-up fallback
 * Displays Name, Short Description, and Specs (No price displayed!)
 */

// Retrieve WooCommerce product categories
$mega_categories = tdclassic_get_mega_menu_categories(10);
$is_fallback = empty($mega_categories);

if ($is_fallback) {
    // Curated Mock categories with high-end Hi-Fi products, short descriptions and specs
    $mega_categories = array(
        array(
            'name'      => 'Dàn Âm Thanh Karaoke',
            'slug'      => 'dan-am-thanh-karaoke',
            'url'       => home_url('/san-pham?cat=dan-am-thanh-karaoke'),
            'image_url' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=600&auto=format&fit=crop',
            'image_alt' => 'Dàn Âm Thanh Karaoke',
            'products'  => array(
                array(
                    'title'     => 'Dàn Karaoke Hi-End Lava Gold',
                    'desc'      => 'Hệ thống karaoke gia đình cao cấp cho chất âm trung thực, ấm áp.',
                    'specs'     => 'CS: 1200W • 98dB • 35Hz-20kHz',
                    'url'       => home_url('/san-pham'),
                    'image_url' => 'https://images.unsplash.com/photo-1608155686393-8fdd966d784d?q=80&w=300&auto=format&fit=crop'
                ),
                array(
                    'title'     => 'Hệ Thống Karaoke Premium TD-01',
                    'desc'      => 'Cấu hình âm thanh karaoke gia đình mạnh mẽ, hoạt động bền bỉ.',
                    'specs'     => 'CS: 900W • 96dB • 40Hz-20kHz',
                    'url'       => home_url('/san-pham'),
                    'image_url' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?q=80&w=300&auto=format&fit=crop'
                ),
                array(
                    'title'     => 'Dàn Karaoke Gia Đình Luxury',
                    'desc'      => 'Thiết kế tinh xảo, phối ghép hoàn hảo từ linh kiện nhập khẩu.',
                    'specs'     => 'CS: 1500W • 99dB • 30Hz-22kHz',
                    'url'       => home_url('/san-pham'),
                    'image_url' => 'https://images.unsplash.com/photo-1618384887929-16ec33fab9ef?q=80&w=300&auto=format&fit=crop'
                )
            )
        ),
        array(
            'name'      => 'Loa Nghe Nhạc Hi-End',
            'slug'      => 'loa-nghe-nhac',
            'url'       => home_url('/san-pham?cat=loa-nghe-nhac'),
            'image_url' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?q=80&w=600&auto=format&fit=crop',
            'image_alt' => 'Loa Nghe Nhạc Hi-End',
            'products'  => array(
                array(
                    'title'     => 'Loa Cột Tannoy Kensington GR',
                    'desc'      => 'Dòng loa nghe nhạc cổ điển danh tiếng, chất âm ngọt ngào quý phái.',
                    'specs'     => 'CS: 500W • 93dB • 29Hz-27kHz',
                    'url'       => home_url('/san-pham'),
                    'image_url' => 'https://images.unsplash.com/photo-1618384887929-16ec33fab9ef?q=80&w=300&auto=format&fit=crop'
                ),
                array(
                    'title'     => 'Loa Bookshelf Focal Diablo Utopia',
                    'desc'      => 'Kiệt tác bookshelf Hi-End của Pháp, tái hiện âm thanh siêu trung thực.',
                    'specs'     => 'CS: 150W • 89dB • 44Hz-40kHz',
                    'url'       => home_url('/san-pham'),
                    'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=300&auto=format&fit=crop'
                ),
                array(
                    'title'     => 'Loa TD-Classic Signature Edition',
                    'desc'      => 'Phiên bản kỷ niệm chế tác thủ công từ gỗ óc chó cao cấp.',
                    'specs'     => 'CS: 450W • 98dB • 50Hz-20kHz',
                    'url'       => home_url('/san-pham'),
                    'image_url' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?q=80&w=300&auto=format&fit=crop'
                )
            )
        ),
        array(
            'name'      => 'Amply Hi-End Cao Cấp',
            'slug'      => 'amply-hi-end',
            'url'       => home_url('/san-pham?cat=amply-hi-end'),
            'image_url' => 'https://images.unsplash.com/photo-1535572290543-960a89797442?q=80&w=600&auto=format&fit=crop',
            'image_alt' => 'Amply Hi-End',
            'products'  => array(
                array(
                    'title'     => 'Amply Đèn McIntosh MC275',
                    'desc'      => 'Huyền thoại amply đèn với công suất mạnh mẽ, chất âm truyền cảm.',
                    'specs'     => 'CS: 75W/kênh • Đèn KT88 • 20Hz-20kHz',
                    'url'       => home_url('/san-pham'),
                    'image_url' => 'https://images.unsplash.com/photo-1535572290543-960a89797442?q=80&w=300&auto=format&fit=crop'
                ),
                array(
                    'title'     => 'Amply Tích Hợp Accuphase E-800',
                    'desc'      => 'Amply tích hợp đầu bảng chạy mạch thuần Class A tinh khiết.',
                    'specs'     => 'CS: 50W/kênh • 8 Ohms • Damping Factor 1000',
                    'url'       => home_url('/san-pham'),
                    'image_url' => 'https://images.unsplash.com/photo-1608155686393-8fdd966d784d?q=80&w=300&auto=format&fit=crop'
                ),
                array(
                    'title'     => 'Bộ Giải Mã DAC Hi-Res TD-Premium',
                    'desc'      => 'Bộ giải mã nhạc số cao cấp hỗ trợ định dạng DSD và MQA mới nhất.',
                    'specs'     => '32-bit/768kHz • XMOS • Nhôm nguyên khối',
                    'url'       => home_url('/san-pham'),
                    'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=300&auto=format&fit=crop'
                )
            )
        ),
        array(
            'name'      => 'Hệ Thống Xem Phim',
            'slug'      => 'he-thong-xem-phim',
            'url'       => home_url('/san-pham?cat=he-thong-xem-phim'),
            'image_url' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=600&auto=format&fit=crop',
            'image_alt' => 'Hệ Thống Xem Phim',
            'products'  => array(
                array(
                    'title'     => 'Dàn Xem Phim 7.2.4 Dolby Atmos',
                    'desc'      => 'Trải nghiệm rạp phim tại gia với âm thanh vòm ngập tràn cảm xúc.',
                    'specs'     => 'CS: 2200W • 11 Kênh • Dts:X Pro',
                    'url'       => home_url('/san-pham'),
                    'image_url' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=300&auto=format&fit=crop'
                ),
                array(
                    'title'     => 'Máy Chiếu Premium 4K Laser TD',
                    'desc'      => 'Máy chiếu laser độ sáng cao, màu sắc điện ảnh sắc nét vượt trội.',
                    'specs'     => '3000 Lumens • HDR10+ • Zoom 1.6x',
                    'url'       => home_url('/san-pham'),
                    'image_url' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=300&auto=format&fit=crop'
                ),
                array(
                    'title'     => 'Loa Center Custom Cinema Series',
                    'desc'      => 'Tái hiện lời thoại nhân vật vô cùng chân thực và rõ ràng.',
                    'specs'     => 'CS: 300W • 91dB • 3 đường tiếng',
                    'url'       => home_url('/san-pham'),
                    'image_url' => 'https://images.unsplash.com/photo-1618384887929-16ec33fab9ef?q=80&w=300&auto=format&fit=crop'
                )
            )
        )
    );
}
?>
<div class="has-mega-menu h-full flex items-center group">
    <a href="<?php echo esc_url(home_url('/san-pham')); ?>" 
       class="nav-link text-xs font-semibold uppercase tracking-widest <?php echo (is_post_type_archive('product') || is_singular('product') || is_tax('product_cat') || is_page('san-pham')) ? 'active text-gold' : 'text-gray-400'; ?> flex items-center gap-1.5 group-hover:text-gold cursor-pointer h-full">
        Sản phẩm
        <i class="fa-solid fa-chevron-down text-[8px] opacity-50 group-hover:opacity-100 transition-opacity mt-px"></i>
    </a>
    
    <!-- Premium Mega Menu Container -->
    <div class="mega-menu-wrapper">
        <div class="mega-menu-content w-full max-w-[1700px] mx-auto p-0 flex">
            
            <!-- Category Tabs Sidebar (Dynamic / Curated Fallback) -->
            <div class="mm-sidebar" id="mega-sidebar">
                <?php 
                $first_active = true;
                foreach ($mega_categories as $category) : 
                    $panel_id = 'panel-' . $category['slug'];
                ?>
                <div class="mm-tab-item <?php echo $first_active ? 'active' : ''; ?>" data-target="<?php echo esc_attr($panel_id); ?>">
                    <span><?php echo esc_html($category['name']); ?></span>
                    <i class="fa-solid fa-chevron-right text-[10px] opacity-40 group-hover:opacity-100 transition-opacity"></i>
                </div>
                <?php 
                    $first_active = false;
                endforeach; 
                ?>
            </div>

            <!-- Product Panels Content (Dynamic / Curated Fallback) -->
            <div class="mm-panels">
                <?php 
                $first_panel = true;
                foreach ($mega_categories as $category) : 
                    $panel_id = 'panel-' . $category['slug'];
                    
                    // Use mock products if fallback, otherwise query from WooCommerce database
                    $products = $is_fallback ? $category['products'] : tdclassic_get_products_by_category($category['slug'], 8);
                ?>
                <div class="mm-panel <?php echo $first_panel ? 'active' : ''; ?>" id="<?php echo esc_attr($panel_id); ?>">
                    
                    <!-- Products Slider / Grid -->
                    <div class="slider-wrapper">
                        <button class="slider-btn prev" aria-label="Previous Products"><i class="fa-solid fa-chevron-left"></i></button>
                        
                        <div class="panel-slider-container">
                            <?php if (!empty($products)) : ?>
                                <?php foreach ($products as $product) : ?>
                                <a href="<?php echo esc_url($product['url']); ?>" class="mini-product">
                                    <div class="aspect-square w-full overflow-hidden bg-black/40">
                                        <img src="<?php echo esc_url($product['image_url']); ?>" alt="<?php echo esc_attr($product['title']); ?>" loading="lazy">
                                    </div>
                                    <div class="p-4 flex-1 flex flex-col justify-between" style="min-height: 120px;">
                                        <h5 class="font-sans font-bold text-[11px] text-white leading-snug line-clamp-1 mb-1.5 group-hover:text-gold transition-colors"><?php echo esc_html($product['title']); ?></h5>
                                        
                                        <?php if (!empty($product['desc'])) : ?>
                                            <p class="text-[9.5px] text-gray-500 line-clamp-2 mb-2 font-sans leading-normal"><?php echo esc_html($product['desc']); ?></p>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($product['specs'])) : ?>
                                            <p class="text-[9px] font-sans text-gold font-bold mt-auto tracking-wide leading-none"><?php echo esc_html($product['specs']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </a>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-500 font-sans text-xs uppercase tracking-wider">Chưa có sản phẩm trong danh mục này.</div>
                            <?php endif; ?>
                        </div>
                        
                        <button class="slider-btn next" aria-label="Next Products"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>

                    <!-- Luxury Featured Spotlight Card (Right side) -->
                    <div class="panel-featured group">
                        <img src="<?php echo esc_url($category['image_url']); ?>" alt="<?php echo esc_attr($category['image_alt']); ?>" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#050505] via-[#050505]/40 to-transparent z-10 pointer-events-none"></div>
                        
                        <div class="absolute bottom-6 left-6 right-6 z-20">
                            <span class="bg-gold text-black text-[9px] font-bold px-2.5 py-1 uppercase tracking-wider rounded-sm mb-3.5 inline-block select-none shadow-[0_4px_10px_rgba(197,160,89,0.3)]">Nổi bật</span>
                            <h3 class="font-sans font-bold text-white text-xl tracking-wide mb-2 line-clamp-1 group-hover:text-gold transition-colors"><?php echo esc_html($category['name']); ?></h3>
                            <div class="w-10 h-[1px] bg-gold/50 mb-3.5 group-hover:w-20 transition-all duration-300"></div>
                            <a href="<?php echo esc_url($category['url']); ?>" class="text-[10px] font-bold uppercase tracking-widest text-white hover:text-gold transition-colors border-b border-white/20 pb-0.5 hover:border-gold">Xem tất cả</a>
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
