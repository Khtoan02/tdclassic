<?php
/**
 * The template for displaying single project posts
 * Upgraded to Dark Luxury Aesthetic for TD Classic
 *
 * @package TD_Classic
 */

get_header(); ?>

<main id="primary" class="site-main bg-void text-gray-200 min-h-screen pt-36 md:pt-40 pb-20">
    <div class="max-w-4xl mx-auto px-6">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <!-- Breadcrumbs & Category Badge -->
                <nav class="mb-6 flex flex-wrap items-center gap-2 text-xs font-semibold uppercase tracking-widest text-gray-400" aria-label="Breadcrumb">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-gold transition-colors">Trang chủ</a>
                    <span class="text-white/20">/</span>
                    <a href="<?php echo esc_url(home_url('/du-an')); ?>" class="hover:text-gold transition-colors">Dự án</a>
                    <span class="text-white/20">/</span>
                    <span class="text-gold truncate max-w-[200px] sm:max-w-none"><?php the_title(); ?></span>
                </nav>

                <!-- Project Title & Meta -->
                <header class="mb-8">
                    <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl text-white font-bold tracking-tight mb-4 leading-tight">
                        <?php the_title(); ?>
                    </h1>

                    <div class="flex flex-wrap items-center gap-4 text-xs text-gray-400 border-b border-white/10 pb-6">
                        <span class="inline-flex items-center gap-1.5 text-gold">
                            <i class="fa-solid fa-calendar-days text-[11px]"></i>
                            <span><?php echo get_the_date('d/m/Y'); ?></span>
                        </span>

                        <?php $single_cats = get_the_terms(get_the_ID(), 'project_category'); if ($single_cats && !is_wp_error($single_cats)) : ?>
                            <span class="text-white/20">•</span>
                            <div class="flex flex-wrap items-center gap-2">
                                <?php foreach ($single_cats as $sc): ?>
                                    <a href="<?php echo esc_url(get_term_link($sc)); ?>" 
                                       class="px-2.5 py-0.5 rounded-full bg-white/5 border border-white/10 hover:border-gold text-gray-300 hover:text-gold text-[10px] font-bold uppercase tracking-wider transition-colors">
                                        <?php echo esc_html($sc->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </header>

                <!-- Featured Image -->
                <?php 
                $hero = function_exists('tdclassic_get_project_thumb_url') ? tdclassic_get_project_thumb_url(get_the_ID(), 'hero-image') : '';
                if (!$hero && has_post_thumbnail()) {
                    $hero = get_the_post_thumbnail_url(get_the_ID(), 'large');
                }
                ?>
                <?php if ($hero): ?>
                    <div class="mb-10 rounded-2xl overflow-hidden border border-white/10 shadow-2xl bg-metal">
                        <img src="<?php echo esc_url($hero); ?>" class="w-full h-auto object-cover max-h-[520px]" alt="<?php the_title_attribute(); ?>" loading="eager" decoding="async">
                    </div>
                <?php endif; ?>

                <!-- Entry Content -->
                <div class="entry-content font-sans text-gray-300 text-base md:text-lg leading-relaxed space-y-6">
                    <style>
                        .entry-content h2 { font-size: 1.75rem; font-weight: 700; color: #fff; margin-top: 2.25rem; margin-bottom: 1rem; border-left: 3px solid #C5A059; padding-left: 0.75rem; }
                        .entry-content h3 { font-size: 1.35rem; font-weight: 600; color: #fff; margin-top: 1.75rem; margin-bottom: 0.75rem; }
                        .entry-content p { margin-bottom: 1.25rem; line-height: 1.85; color: #d1d5db; }
                        .entry-content ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1.25rem; color: #9ca3af; }
                        .entry-content ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1.25rem; color: #9ca3af; }
                        .entry-content li { margin-bottom: 0.5rem; }
                        .entry-content a { color: #C5A059; text-decoration: underline; text-underline-offset: 4px; }
                        .entry-content a:hover { color: #fff; }
                        .entry-content blockquote { border-left: 4px solid #C5A059; padding: 1rem 1.5rem; background: rgba(255,255,255,0.02); border-radius: 0 8px 8px 0; font-style: italic; color: #e5e7eb; }
                        .entry-content img { border-radius: 0.75rem; max-width: 100%; height: auto; margin: 1.5rem auto; border: 1px solid rgba(255,255,255,0.08); }
                    </style>
                    <?php
                    the_content();

                    wp_link_pages(array(
                        'before' => '<div class="page-links mt-8 pt-4 border-t border-white/10 flex items-center gap-2"><span class="text-xs uppercase tracking-widest text-gray-500">' . __('Trang:', 'tdclassic') . '</span>',
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <!-- Navigation between Projects -->
                <nav class="mt-14 pt-8 border-t border-white/10" aria-label="Điều hướng dự án">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="w-full sm:w-auto">
                            <?php 
                            $prev_post = get_previous_post();
                            if ($prev_post) : ?>
                                <a href="<?php echo get_permalink($prev_post->ID); ?>" 
                                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-white/15 bg-white/5 hover:border-gold hover:text-gold text-white text-xs font-bold uppercase tracking-wider transition-all"
                                   rel="prev">
                                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                                    <span>Dự án trước</span>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="w-full sm:w-auto text-right">
                            <?php 
                            $next_post = get_next_post();
                            if ($next_post) : ?>
                                <a href="<?php echo get_permalink($next_post->ID); ?>" 
                                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-white/15 bg-white/5 hover:border-gold hover:text-gold text-white text-xs font-bold uppercase tracking-wider transition-all"
                                   rel="next">
                                    <span>Dự án sau</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </nav>

            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
