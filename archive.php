<?php
/**
 * The template for displaying archive pages (Tags, Author, Date, Taxonomies)
 *
 * @package TD_Classic
 */

get_header(); ?>

<main id="primary" class="site-main bg-void text-gray-200 min-h-screen pt-28 md:pt-36 pb-20">
    <div class="max-w-6xl mx-auto px-6 py-10 md:py-16">
        <header class="mb-12 border-b border-white/10 pb-8">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-gold text-xs font-semibold uppercase tracking-widest mb-4">
                <span>Chuyên mục lưu trữ</span>
            </div>
            <h1 class="font-serif text-3xl md:text-5xl text-white font-bold tracking-tight mb-3">
                <?php the_archive_title(); ?>
            </h1>
            <?php the_archive_description('<div class="text-sm md:text-base text-gray-400 font-light mt-2 max-w-2xl leading-relaxed">', '</div>'); ?>
        </header>

        <?php if (have_posts()) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while (have_posts()) : the_post(); 
                    $thumb_url = has_post_thumbnail() 
                        ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') 
                        : get_template_directory_uri() . '/assets/images/placeholder.jpg';
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('group bg-surface/50 border border-white/10 rounded-2xl overflow-hidden hover:border-gold/40 transition-all duration-300 flex flex-col h-full hover:shadow-[0_8px_30px_rgba(0,0,0,0.5)]'); ?>>
                        <a href="<?php the_permalink(); ?>" class="aspect-video overflow-hidden bg-metal block relative">
                            <img src="<?php echo esc_url($thumb_url); ?>" 
                                 alt="<?php the_title_attribute(); ?>"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90 group-hover:opacity-100"
                                 loading="lazy">
                        </a>

                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex items-center gap-3 text-xs text-gray-400 mb-3">
                                <span><?php echo get_the_date('d/m/Y'); ?></span>
                                <span>•</span>
                                <span><?php the_author(); ?></span>
                            </div>

                            <h2 class="font-serif text-xl text-white font-bold line-clamp-2 mb-3 group-hover:text-gold transition-colors">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <div class="text-sm text-gray-400 font-light leading-relaxed line-clamp-3 mb-6 flex-grow">
                                <?php the_excerpt(); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-gold hover:text-white transition-colors mt-auto">
                                <span>Đọc tiếp</span>
                                <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <div class="mt-12 pt-8 border-t border-white/10 flex justify-center">
                <?php
                the_posts_pagination(array(
                    'prev_text' => '<i class="fa-solid fa-chevron-left me-1"></i> ' . __('Trước', 'tdclassic'),
                    'next_text' => __('Sau', 'tdclassic') . ' <i class="fa-solid fa-chevron-right ms-1"></i>',
                ));
                ?>
            </div>

        <?php else : ?>
            <div class="text-center py-16 px-4 bg-surface/30 border border-white/5 rounded-3xl max-w-xl mx-auto">
                <h3 class="font-serif text-2xl text-white font-semibold mb-3">Chưa có bài viết</h3>
                <p class="text-sm text-gray-400 mb-6">Mục này hiện tại chưa có nội dung nào.</p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center px-6 py-3 rounded-full bg-gold hover:bg-goldDim text-black text-xs font-bold uppercase tracking-widest transition-colors">
                    Về trang chủ
                </a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
