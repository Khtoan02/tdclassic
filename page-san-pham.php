<?php
/**
 * Template Name: San Pham
 * The template for displaying the products page - Luxury Dark Mobile-Optimized Edition
 */

get_header(); ?>

<style>
/* Scoped Dark Theme Overrides for Products Page */
html, body, .products-page {
    background-color: #050505 !important;
    color: #f3f4f6 !important;
}
.products-page p, 
.products-page .text-gray-400,
.products-page .text-gray-300 {
    color: #e5e5e5 !important;
}
.products-page .filter-tab {
    background: rgba(255, 255, 255, 0.05) !important;
    border: 1px solid rgba(255, 255, 255, 0.12) !important;
    color: #f3f4f6 !important;
}
.products-page .filter-tab:hover {
    border-color: #C5A059 !important;
    color: #C5A059 !important;
    background: rgba(197, 160, 89, 0.1) !important;
}
.products-page .filter-tab.active {
    background: #C5A059 !important;
    border-color: #C5A059 !important;
    color: #000000 !important;
    font-weight: 700 !important;
    box-shadow: 0 0 15px rgba(197, 160, 89, 0.3) !important;
}
.products-page input#product-search {
    background: rgba(255, 255, 255, 0.05) !important;
    border: 1px solid rgba(255, 255, 255, 0.15) !important;
    color: #ffffff !important;
}
.products-page .product-card {
    background: #111111 !important;
    background-color: #111111 !important;
    border: 1px solid rgba(255, 255, 255, 0.06) !important;
}
</style>

<main id="main" class="site-main products-page bg-[#050505] text-white selection:bg-[#C5A059] selection:text-black">
    <!-- Hero Section -->
    <section class="category-hero-section page-header-clearance relative pb-12 sm:pb-16 bg-[#050505] border-b border-white/5 overflow-hidden text-center">
        <div class="absolute inset-0 z-0 opacity-20 pointer-events-none bg-[radial-gradient(#C5A059_1px,transparent_1px)] [background-size:24px_24px]"></div>
        <div class="container mx-auto px-4 relative z-10 max-w-4xl">
            <span class="inline-block text-[#C5A059] font-sans text-xs font-bold tracking-[0.25em] uppercase mb-3 px-3 py-1 rounded-full bg-[#C5A059]/10 border border-[#C5A059]/20">
                Bộ Sưu Tập Âm Thanh TD Classic
            </span>
            <h1 class="text-2xl sm:text-4xl lg:text-6xl font-extrabold uppercase tracking-tight text-white mb-4 font-serif break-words">
                Hệ Thống <span class="text-[#C5A059]">Sản Phẩm</span>
            </h1>
            <p class="text-sm sm:text-base text-gray-400 max-w-2xl mx-auto font-light leading-relaxed mb-8">
                Khám phá các dòng thiết bị âm thanh chuyên nghiệp, dàn karaoke cao cấp và giải pháp âm thanh chuẩn mực được phối ghép bởi chuyên gia.
            </p>

            <!-- Stats Bar -->
            <div class="inline-flex items-center justify-center gap-4 sm:gap-8 px-6 py-3 rounded-full bg-white/5 border border-white/10 text-xs text-gray-300">
                <div class="flex items-center gap-2">
                    <span class="font-bold text-white text-sm sm:text-base text-[#C5A059]"><?php echo (int) wp_count_posts('product')->publish; ?>+</span>
                    <span>Thiết bị</span>
                </div>
                <span class="w-1 h-3 bg-white/20"></span>
                <div class="flex items-center gap-2">
                    <span class="font-bold text-white text-sm sm:text-base text-[#C5A059]">100%</span>
                    <span>Chính hãng</span>
                </div>
                <span class="w-1 h-3 bg-white/20"></span>
                <div class="flex items-center gap-2">
                    <span class="font-bold text-white text-sm sm:text-base text-[#C5A059]">24/7</span>
                    <span>Bảo hành tận nơi</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Sticky Filter & Search Bar -->
    <div class="sticky top-0 z-30 backdrop-blur-md border-b border-white/10 py-3 transition-all duration-300 shadow-lg" style="background-color: #080808 !important;">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex flex-col md:flex-row items-center justify-between gap-3">
                <!-- Mobile Horizontal Touch Scroller for Categories -->
                <div class="w-full md:w-auto flex-1 overflow-x-auto whitespace-nowrap scrollbar-none flex items-center gap-2 py-1 touch-pan-x" id="products-filter-bar">
                    <button class="filter-tab active text-xs font-semibold px-4 py-2 rounded-full border border-[#C5A059] bg-[#C5A059] text-black shadow-[0_0_12px_rgba(197,160,89,0.25)] transition-all shrink-0 cursor-pointer" data-filter="all">
                        Tất cả
                    </button>
                    <?php
                    $prod_tax = 'product_category';
                    if (taxonomy_exists('product_cat')) {
                        $prod_tax = 'product_cat';
                    }

                    $product_categories = get_terms(array(
                        'taxonomy' => $prod_tax,
                        'hide_empty' => true,
                        'orderby' => 'count',
                        'order' => 'DESC',
                        'number' => 15
                    ));
                    
                    if ($product_categories && !is_wp_error($product_categories)) :
                        foreach ($product_categories as $category) :
                    ?>
                        <button class="filter-tab text-xs font-medium px-4 py-2 rounded-full border border-white/10 bg-white/5 text-gray-300 hover:text-white hover:border-[#C5A059]/60 hover:bg-[#C5A059]/10 transition-all shrink-0 cursor-pointer" data-filter="<?php echo esc_attr($category->slug); ?>">
                            <?php echo esc_html($category->name); ?>
                        </button>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>

                <!-- Instant Search Input -->
                <div class="relative w-full md:w-72 shrink-0">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" id="product-search" placeholder="Tìm tên sản phẩm..." 
                           class="w-full border border-white/10 focus:border-[#C5A059] rounded-full py-2 pl-9 pr-4 text-xs placeholder-gray-400 outline-none transition-all"
                           style="background-color: rgba(255,255,255,0.06) !important; color: #ffffff !important;">
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid Section -->
    <section class="py-8 sm:py-12 lg:py-16">
        <div class="container mx-auto px-4 max-w-7xl">
            <h2 class="sr-only">Danh sách sản phẩm TD Classic</h2>
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $products = new WP_Query(array(
                'post_type' => 'product',
                'posts_per_page' => 12,
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC',
                'paged' => $paged
            ));
            
            if ($products->have_posts()) :
            ?>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6" id="products-container">
                    <?php
                    while ($products->have_posts()) : $products->the_post();
                        $product_terms = get_the_terms(get_the_ID(), $prod_tax);
                        $category_classes = '';
                        $category_name = '';
                        if ($product_terms && !is_wp_error($product_terms)) {
                            foreach ($product_terms as $category) {
                                $category_classes .= ' category-' . $category->slug;
                            }
                            $category_name = $product_terms[0]->name;
                        }
                    ?>
                        <a href="<?php the_permalink(); ?>" 
                           class="product-card group flex flex-col bg-[#121212] border border-white/5 hover:border-[#C5A059]/40 rounded-xl overflow-hidden transition-all duration-300 transform hover:-translate-y-1 <?php echo esc_attr($category_classes); ?>" 
                           data-title="<?php echo esc_attr(strtolower(get_the_title())); ?>">
                            
                            <!-- Image Container -->
                            <div class="relative aspect-square w-full bg-[#181818] overflow-hidden flex items-center justify-center">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php the_post_thumbnail_url('medium_large'); ?>" 
                                         alt="<?php the_title_attribute(); ?>" 
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" 
                                         loading="lazy">
                                <?php else : ?>
                                    <div class="flex flex-col items-center justify-center text-gray-600">
                                        <i class="fa-solid fa-volume-high text-3xl mb-2 text-[#C5A059]/40"></i>
                                        <span class="text-[10px] uppercase tracking-wider text-gray-500">TD Classic</span>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($category_name)) : ?>
                                    <span class="absolute top-2.5 left-2.5 px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider bg-black/75 text-[#C5A059] border border-[#C5A059]/30 backdrop-blur-sm line-clamp-1 max-w-[80%]">
                                        <?php echo esc_html($category_name); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Card Body -->
                            <div class="p-3 sm:p-4 flex flex-col justify-between flex-1">
                                <div>
                                    <span class="text-[10px] text-gray-400 uppercase tracking-widest block mb-1">Chính hãng</span>
                                    <h3 class="text-xs sm:text-sm font-semibold text-white group-hover:text-[#C5A059] line-clamp-2 leading-snug font-sans transition-colors">
                                        <?php the_title(); ?>
                                    </h3>
                                </div>

                                <div class="flex items-center justify-between pt-3 border-t border-white/5 mt-3">
                                    <span class="text-[11px] sm:text-xs font-bold text-[#C5A059] uppercase tracking-wider">Báo giá ngay</span>
                                    <span class="w-6 h-6 rounded-full bg-white/5 flex items-center justify-center text-gray-400 group-hover:bg-[#C5A059] group-hover:text-black transition-all">
                                        <i class="fa-solid fa-arrow-right text-[9px]"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    <?php
                    endwhile;
                    ?>
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    <?php
                    $total_pages = $products->max_num_pages;
                    if ($total_pages > 1) :
                        echo paginate_links(array(
                            'base' => get_pagenum_link(1) . '%_%',
                            'format' => 'page/%#%',
                            'current' => $paged,
                            'total' => $total_pages,
                            'prev_text' => '<span class="sr-only">Trang trước</span><i class="fa-solid fa-chevron-left text-xs" aria-hidden="true"></i>',
                            'next_text' => '<span class="sr-only">Trang sau</span><i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i>',
                            'type' => 'plain',
                        ));
                    endif;
                    wp_reset_postdata();
                    ?>
                </div>

            <?php else : ?>
                <div class="text-center py-16 bg-white/5 border border-white/10 rounded-2xl max-w-xl mx-auto">
                    <i class="fa-solid fa-box-open text-4xl text-[#C5A059] mb-4"></i>
                    <h3 class="text-xl font-bold text-white mb-2">Chưa có sản phẩm nào</h3>
                    <p class="text-sm text-gray-400">Danh mục sản phẩm đang được cập nhật. Vui lòng liên hệ hotline để nhận tư vấn trực tiếp.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Why Choose TD Classic - Luxury Edition -->
    <section class="py-12 sm:py-16 bg-[#090909] border-t border-white/5">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#C5A059] block mb-2">Cam Kết Vàng</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-white font-serif">Tại sao chọn thiết bị tại TD Classic?</h2>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <div class="p-6 rounded-xl bg-white/5 border border-white/5 hover:border-[#C5A059]/30 transition-all text-center">
                    <div class="w-12 h-12 rounded-full bg-[#C5A059]/10 border border-[#C5A059]/20 flex items-center justify-center mx-auto mb-4 text-[#C5A059]">
                        <i class="fa-solid fa-certificate text-lg"></i>
                    </div>
                    <h3 class="font-bold text-white text-base mb-2">100% Chính Hãng</h3>
                    <p class="text-xs text-gray-400 leading-relaxed">Đầy đủ CO, CQ và giấy tờ nhập khẩu chính ngạch từ các thương hiệu Hi-End hàng đầu thế giới.</p>
                </div>

                <div class="p-6 rounded-xl bg-white/5 border border-white/5 hover:border-[#C5A059]/30 transition-all text-center">
                    <div class="w-12 h-12 rounded-full bg-[#C5A059]/10 border border-[#C5A059]/20 flex items-center justify-center mx-auto mb-4 text-[#C5A059]">
                        <i class="fa-solid fa-sliders text-lg"></i>
                    </div>
                    <h3 class="font-bold text-white text-base mb-2">Setup Chuẩn Chuyên Gia</h3>
                    <p class="text-xs text-gray-400 leading-relaxed">Đo lường âm học bằng thiết bị chuyên dụng và căn chỉnh tối ưu cho từng không gian kiến trúc.</p>
                </div>

                <div class="p-6 rounded-xl bg-white/5 border border-white/5 hover:border-[#C5A059]/30 transition-all text-center">
                    <div class="w-12 h-12 rounded-full bg-[#C5A059]/10 border border-[#C5A059]/20 flex items-center justify-center mx-auto mb-4 text-[#C5A059]">
                        <i class="fa-solid fa-shield-halved text-lg"></i>
                    </div>
                    <h3 class="font-bold text-white text-base mb-2">Bảo Hành Tận Nơi</h3>
                    <p class="text-xs text-gray-400 leading-relaxed">Chế độ bảo hành chính hãng lên đến 36 tháng cùng dịch vụ bảo trì định kỳ định kỳ miễn phí.</p>
                </div>

                <div class="p-6 rounded-xl bg-white/5 border border-white/5 hover:border-[#C5A059]/30 transition-all text-center">
                    <div class="w-12 h-12 rounded-full bg-[#C5A059]/10 border border-[#C5A059]/20 flex items-center justify-center mx-auto mb-4 text-[#C5A059]">
                        <i class="fa-solid fa-headset text-lg"></i>
                    </div>
                    <h3 class="font-bold text-white text-base mb-2">Tư Vấn 24/7</h3>
                    <p class="text-xs text-gray-400 leading-relaxed">Đội ngũ kỹ thuật viên giàu kinh nghiệm sẵn sàng lắng nghe và giải đáp mọi yêu cầu của bạn.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Bottom Call-To-Action Banner -->
    <section class="py-12 bg-gradient-to-r from-[#111] via-[#1a1710] to-[#111] border-t border-white/10 text-center">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-2xl sm:text-3xl font-bold text-white font-serif mb-3">Bạn cần tìm giải pháp âm thanh chuyên biệt?</h2>
            <p class="text-sm text-gray-300 mb-6">Liên hệ trực tiếp với chuyên gia âm thanh TD Classic để nhận cấu hình tối ưu và mức giá ưu đãi nhất.</p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="px-6 py-3 rounded-full bg-[#C5A059] text-black font-bold uppercase tracking-widest text-xs hover:bg-[#d8b46e] transition-all shadow-[0_0_20px_rgba(197,160,89,0.3)]">
                    Yêu cầu tư vấn
                </a>
                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', tdclassic_get_company_phone())); ?>" class="px-6 py-3 rounded-full bg-white/5 border border-white/20 text-white font-bold uppercase tracking-widest text-xs hover:border-[#C5A059] hover:text-[#C5A059] transition-all flex items-center gap-2">
                    <i class="fa-solid fa-phone text-xs text-[#C5A059]"></i>
                    Hotline: <?php echo esc_html(tdclassic_get_company_phone()); ?>
                </a>
            </div>
        </div>
    </section>
</main>

<style>
/* Product Pagination Styles */
.page-numbers {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 38px;
    height: 38px;
    padding: 0 12px;
    margin: 0 4px;
    border-radius: 9999px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #e5e5e5;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s ease;
}
.page-numbers:hover {
    border-color: #C5A059;
    color: #C5A059;
    background: rgba(197, 160, 89, 0.1);
}
.page-numbers.current {
    background: #C5A059;
    border-color: #C5A059;
    color: #000;
    font-weight: 700;
    box-shadow: 0 0 15px rgba(197, 160, 89, 0.3);
}
.page-numbers.dots {
    border: none;
    background: transparent;
    color: #888;
}
</style>

<script>
// Filter & Search Script with URL Query Support
document.addEventListener('DOMContentLoaded', function() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const productCards = document.querySelectorAll('.product-card');
    const searchInput = document.getElementById('product-search');
    
    function applyFilter(filter) {
        filterTabs.forEach(t => {
            if (t.dataset.filter === filter) {
                t.classList.add('active', 'bg-[#C5A059]', 'text-black', 'border-[#C5A059]');
                t.classList.remove('bg-white/5', 'text-gray-300', 'border-white/10');
            } else {
                t.classList.remove('active', 'bg-[#C5A059]', 'text-black', 'border-[#C5A059]');
                t.classList.add('bg-white/5', 'text-gray-300', 'border-white/10');
            }
        });
        
        productCards.forEach(card => {
            if (filter === 'all' || card.classList.contains('category-' + filter)) {
                card.style.display = 'flex';
                setTimeout(() => card.style.opacity = '1', 10);
            } else {
                card.style.opacity = '0';
                card.style.display = 'none';
            }
        });
    }

    // Filter Click
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            applyFilter(this.dataset.filter);
        });
    });
    
    // Search Input
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            productCards.forEach(card => {
                const title = card.dataset.title || '';
                if (title.includes(query)) {
                    card.style.display = 'flex';
                    card.style.opacity = '1';
                } else {
                    card.style.display = 'none';
                    card.style.opacity = '0';
                }
            });
        });
    }

    // URL parameter auto-filter (?cat=slug)
    const urlParams = new URLSearchParams(window.location.search);
    const catParam = urlParams.get('cat');
    if (catParam) {
        applyFilter(catParam);
        const activeTab = document.querySelector(`.filter-tab[data-filter="${catParam}"]`);
        if (activeTab) {
            activeTab.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        }
    }
});
</script>

<?php get_footer(); ?>