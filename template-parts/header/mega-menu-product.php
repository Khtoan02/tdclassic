<?php
/**
 * Header Mega Menu Product
 */

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
