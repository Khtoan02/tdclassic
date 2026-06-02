<?php
/**
 * Header Bottom Segment - Premium Product Categories Navigation
 * Handles horizontal list on desktop and touch swipe carousel on mobile.
 */

// Retrieve WooCommerce product categories (including empty ones)
$bottom_categories = tdclassic_get_mega_menu_categories(12);

// Check if empty, fallback to curated high-end categories list for visual stability
if (empty($bottom_categories)) {
    $bottom_categories = array(
        array(
            'name' => 'Dàn Âm Thanh Karaoke',
            'url'  => home_url('/san-pham?cat=dan-am-thanh-karaoke'),
            'slug' => 'dan-am-thanh-karaoke'
        ),
        array(
            'name' => 'Loa Nghe Nhạc Hi-End',
            'url'  => home_url('/san-pham?cat=loa-nghe-nhac'),
            'slug' => 'loa-nghe-nhac'
        ),
        array(
            'name' => 'Amply Cao Cấp',
            'url'  => home_url('/san-pham?cat=amply-hi-end'),
            'slug' => 'amply-hi-end'
        ),
        array(
            'name' => 'Hệ Thống Xem Phim',
            'url'  => home_url('/san-pham?cat=he-thong-xem-phim'),
            'slug' => 'he-thong-xem-phim'
        ),
        array(
            'name' => 'Phụ Kiện Âm Thanh',
            'url'  => home_url('/san-pham?cat=phu-kien-am-thanh'),
            'slug' => 'phu-kien-am-thanh'
        )
    );
}
?>
<div class="header-bottom-wrapper w-full">
    <div class="max-w-[1700px] mx-auto px-6 md:px-12">
        
        <!-- Mobile/Tablet Horizontal Swipeable Categories Bar -->
        <div class="flex lg:hidden overflow-x-auto whitespace-nowrap scrollbar-none gap-5 py-0.5 justify-start items-center" id="mobile-bottom-cats">
            <?php foreach ($bottom_categories as $cat) : ?>
                <a href="<?php echo esc_url($cat['url']); ?>" 
                   class="bottom-cat-link text-[10px] font-semibold uppercase tracking-wider text-gray-400 hover:text-gold active:text-gold transition-colors inline-block select-none">
                    <?php echo esc_html($cat['name']); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Desktop Luxury Fixed Row with Elegant Gold Delimiter Dots -->
        <div class="hidden lg:flex justify-center items-center gap-7 h-full py-0.5">
            <?php 
            $count = count($bottom_categories);
            $i = 0;
            foreach ($bottom_categories as $cat) : 
                $i++;
            ?>
                <a href="<?php echo esc_url($cat['url']); ?>" 
                   class="bottom-cat-link relative text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 hover:text-gold transition-all duration-300 py-1 select-none">
                    <?php echo esc_html($cat['name']); ?>
                </a>
                
                <?php if ($i < $count) : ?>
                    <span class="w-1 h-1 rounded-full bg-gold/40 mx-1 select-none pointer-events-none"></span>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    </div>
</div>
