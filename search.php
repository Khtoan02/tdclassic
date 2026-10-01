<?php
/**
 * The template for displaying search results pages
 *
 * @package TD_Classic
 */

get_header();

global $wp_query;
$search_query = get_search_query();
$total_results = $wp_query->found_posts;
?>

<main id="primary" class="site-main bg-void text-gray-200 min-h-screen pb-20 page-header-clearance">
    <!-- Search Header -->
    <section class="border-b border-white/10 bg-gradient-to-b from-metal/40 to-transparent py-10 md:py-16">
        <div class="max-w-6xl mx-auto px-6">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-gold text-xs font-semibold uppercase tracking-widest mb-4">
                <i class="fa-solid fa-magnifying-glass text-[10px]"></i>
                <span>Tìm kiếm</span>
            </div>

            <h1 class="font-serif text-2xl sm:text-3xl md:text-5xl text-white font-bold tracking-tight mb-4 break-words">
                Kết quả cho: <span class="text-gold">"<?php echo esc_html($search_query); ?>"</span>
            </h1>

            <p class="text-sm md:text-base text-gray-400 font-light">
                Tìm thấy <strong class="text-white font-semibold"><?php echo (int)$total_results; ?></strong> kết quả phù hợp
            </p>

            <!-- Search Bar Inline -->
            <form role="search" method="get" class="mt-8 max-w-xl" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="relative flex items-center">
                    <input type="search" name="s" value="<?php echo esc_attr($search_query); ?>"
                        class="w-full bg-surface border border-white/15 rounded-full py-3.5 pl-5 pr-14 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-gold transition-colors"
                        placeholder="Tìm kiếm sản phẩm, bài viết..." required>
                    <button type="submit"
                        class="absolute right-1.5 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-gold hover:bg-goldDim text-black flex items-center justify-center transition-colors"
                        aria-label="Tìm kiếm">
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Results Section -->
    <div class="max-w-6xl mx-auto px-6 py-12 md:py-16">
        <?php if (have_posts()) : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <?php while (have_posts()) : the_post(); 
                    $post_type = get_post_type();
                    $type_label = ($post_type === 'product') ? 'Sản phẩm' : (($post_type === 'project') ? 'Dự án' : 'Tin tức');
                    $thumb_url = has_post_thumbnail() 
                        ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') 
                        : get_template_directory_uri() . '/assets/images/placeholder.jpg';
                ?>
                    <article class="group bg-surface/50 border border-white/10 rounded-2xl overflow-hidden hover:border-gold/40 transition-all duration-300 flex flex-col h-full hover:shadow-[0_8px_30px_rgba(0,0,0,0.5)]">
                        <!-- Image Container -->
                        <a href="<?php the_permalink(); ?>" class="relative aspect-video sm:aspect-square overflow-hidden bg-metal block">
                            <img src="<?php echo esc_url($thumb_url); ?>" 
                                 alt="<?php the_title_attribute(); ?>"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90 group-hover:opacity-100"
                                 loading="lazy">
                            <!-- Type Badge -->
                            <div class="absolute top-3 left-3 bg-black/70 backdrop-blur-md border border-white/10 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-gold">
                                <?php echo esc_html($type_label); ?>
                            </div>
                        </a>

                        <!-- Content -->
                        <div class="p-5 md:p-6 flex flex-col flex-grow">
                            <span class="text-[11px] uppercase tracking-widest font-mono mb-2" style="color: #9ca3af !important;">
                                <?php echo get_the_date('d/m/Y'); ?>
                            </span>

                            <h2 class="font-serif text-lg md:text-xl text-white font-semibold line-clamp-2 mb-3 group-hover:text-gold transition-colors">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <p class="text-xs md:text-sm text-gray-400 line-clamp-3 mb-6 font-light leading-relaxed flex-grow">
                                <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                            </p>

                            <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-gold hover:text-white transition-colors mt-auto">
                                <span>Xem chi tiết</span>
                                <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <div class="mt-12 pt-8 border-t border-white/10 flex justify-center search-pagination">
                <style>
                    .search-pagination .page-numbers {
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        min-width: 48px;
                        min-height: 48px;
                        padding: 10px 18px;
                        margin: 0 4px;
                        font-size: 14px;
                    }
                </style>
                <?php
                echo paginate_links(array(
                    'prev_text' => '<i class="fa-solid fa-chevron-left me-1"></i> ' . __('Trước', 'tdclassic'),
                    'next_text' => __('Sau', 'tdclassic') . ' <i class="fa-solid fa-chevron-right ms-1"></i>',
                    'type'      => 'list',
                ));
                ?>
            </div>

        <?php else : ?>
            <!-- Empty State -->
            <div class="text-center py-16 px-4 bg-surface/30 border border-white/5 rounded-3xl max-w-2xl mx-auto">
                <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gold text-2xl">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <h2 class="font-serif text-2xl text-white font-semibold mb-3">Không tìm thấy nội dung phù hợp</h2>
                <p class="text-sm text-gray-400 max-w-md mx-auto mb-8 font-light leading-relaxed">
                    Rất tiếc, chúng tôi không tìm thấy kết quả nào cho từ khóa "<?php echo esc_html($search_query); ?>". Vui lòng thử tìm với từ khóa khác hoặc quay lại danh mục sản phẩm.
                </p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="<?php echo esc_url(home_url('/san-pham')); ?>" 
                       class="px-6 py-3 rounded-full bg-gold hover:bg-goldDim text-black text-xs font-bold uppercase tracking-widest transition-colors">
                        Khám phá sản phẩm
                    </a>
                    <a href="<?php echo esc_url(home_url('/')); ?>" 
                       class="px-6 py-3 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 text-white text-xs font-bold uppercase tracking-widest transition-colors">
                        Về trang chủ
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
