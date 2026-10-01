<?php
/**
 * The template for displaying all generic pages
 *
 * @package TD_Classic
 */

get_header(); ?>

<main id="primary" class="site-main bg-void text-gray-200 min-h-screen pt-28 md:pt-36 pb-20">
    <?php while (have_posts()) : the_post(); ?>
        <!-- Page Header / Hero -->
        <section class="border-b border-white/10 bg-gradient-to-b from-metal/40 to-transparent py-10 md:py-16">
            <div class="max-w-4xl mx-auto px-6">
                <!-- Breadcrumb / Badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-gold text-xs font-semibold uppercase tracking-widest mb-4">
                    <span><?php bloginfo('name'); ?></span>
                    <span>/</span>
                    <span class="text-gray-400">Trang</span>
                </div>

                <h1 class="font-serif text-3xl md:text-5xl lg:text-6xl text-white font-bold tracking-tight mb-4">
                    <?php the_title(); ?>
                </h1>

                <?php if (has_excerpt()) : ?>
                    <p class="text-base md:text-lg text-gray-400 font-light leading-relaxed max-w-2xl">
                        <?php echo get_the_excerpt(); ?>
                    </p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Page Content -->
        <article id="post-<?php the_ID(); ?>" <?php post_class('max-w-4xl mx-auto px-6 py-10 md:py-14'); ?>>
            <?php if (has_post_thumbnail()) : ?>
                <div class="mb-10 rounded-2xl overflow-hidden border border-white/10 shadow-2xl">
                    <?php the_post_thumbnail('large', array('class' => 'w-full h-auto object-cover max-h-[480px]')); ?>
                </div>
            <?php endif; ?>

            <div class="entry-content font-sans text-gray-300 text-base md:text-lg leading-relaxed space-y-6">
                <style>
                    .entry-content h2 { font-size: 1.85rem; font-weight: 700; color: #fff; margin-top: 2rem; margin-bottom: 1rem; border-left: 3px solid #C5A059; padding-left: 0.75rem; }
                    .entry-content h3 { font-size: 1.45rem; font-weight: 600; color: #fff; margin-top: 1.5rem; margin-bottom: 0.75rem; }
                    .entry-content p { margin-bottom: 1.25rem; line-height: 1.8; color: #d1d5db; }
                    .entry-content ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1.25rem; color: #9ca3af; }
                    .entry-content ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1.25rem; color: #9ca3af; }
                    .entry-content li { margin-bottom: 0.5rem; }
                    .entry-content a { color: #C5A059; text-decoration: underline; text-underline-offset: 4px; }
                    .entry-content a:hover { color: #fff; }
                    .entry-content blockquote { border-left: 4px solid #C5A059; padding: 1rem 1.5rem; background: rgba(255,255,255,0.02); border-radius: 0 8px 8px 0; font-style: italic; color: #e5e7eb; }
                    .entry-content table { width: 100%; border-collapse: collapse; margin: 1.5rem 0; border: 1px solid rgba(255,255,255,0.1); }
                    .entry-content th, .entry-content td { padding: 0.75rem 1rem; border: 1px solid rgba(255,255,255,0.1); text-align: left; }
                    .entry-content th { background: rgba(255,255,255,0.05); color: #fff; font-weight: 600; }
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

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
