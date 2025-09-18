<?php
/**
 * The template for displaying single project posts
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header mb-4">
                            <nav class="breadcrumb-nav mb-2" aria-label="Breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/du-an')); ?>">Dự án</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
                                </ol>
                            </nav>
                            <h1 class="entry-title h2 mb-3"><?php the_title(); ?></h1>
                            <?php $single_cats = get_the_terms(get_the_ID(), 'project_category'); if ($single_cats && !is_wp_error($single_cats)) : ?>
                            <div class="project-badges mb-2" aria-label="Danh mục dự án">
                                <?php foreach ($single_cats as $sc): ?>
                                    <span class="badge badge-tag"><?php echo esc_html($sc->name); ?></span>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            <div class="entry-meta mb-3 small">
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    <?php echo get_the_date(); ?>
                                </small>
                            </div>

                            <div class="entry-thumbnail mb-4">
                                <?php 
                                $hero = function_exists('tdclassic_get_project_thumb_url') ? tdclassic_get_project_thumb_url(get_the_ID(), 'hero-image') : '';
                                if (!$hero && has_post_thumbnail()) {
                                    $hero = get_the_post_thumbnail_url(get_the_ID(), 'large');
                                }
                                ?>
                                <?php if ($hero): ?>
                                    <img src="<?php echo esc_url($hero); ?>" class="img-fluid rounded w-100" alt="<?php the_title(); ?>" loading="eager" decoding="async">
                                <?php else: ?>
                                    <div class="ratio ratio-21x9 bg-light d-flex align-items-center justify-content-center rounded">
                                        <span class="text-muted">Dự án TD Classic</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </header>

                        <div class="entry-content">
                            <?php
                            the_content();

                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'tdclassic'),
                                'after'  => '</div>',
                            ));
                            ?>
                        </div>

                        <footer class="entry-footer mt-4"></footer>
                    </article>

                    <!-- Navigation -->
                    <nav class="post-navigation mt-5" aria-label="Điều hướng bài viết">
                        <div class="d-flex justify-content-between gap-2">
                            <div>
                                <?php 
                                $prev_post = get_previous_post();
                                if ($prev_post) : ?>
                                    <a href="<?php echo get_permalink($prev_post->ID); ?>" class="btn btn-outline-primary d-inline-flex align-items-center" rel="prev" aria-label="Dự án trước: <?php echo esc_attr(get_the_title($prev_post)); ?>">
                                        <i class="fas fa-arrow-left me-2" aria-hidden="true"></i>
                                        <span>Dự án trước</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="text-end">
                                <?php 
                                $next_post = get_next_post();
                                if ($next_post) : ?>
                                    <a href="<?php echo get_permalink($next_post->ID); ?>" class="btn btn-outline-primary d-inline-flex align-items-center justify-content-end" rel="next" aria-label="Dự án sau: <?php echo esc_attr(get_the_title($next_post)); ?>">
                                        <span>Dự án sau</span>
                                        <i class="fas fa-arrow-right ms-2" aria-hidden="true"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </nav>

                <?php endwhile; ?>
            </div>
            
        </div>
    </div>
</main>

<?php get_footer(); ?> 

