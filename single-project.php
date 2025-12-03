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
                            <style>
                                .breadcrumb-modern {
                                    background: #f9f9fb;
                                    border-radius: 8px;
                                    box-shadow: 0 2px 8px 0 rgba(80,80,120,0.04);
                                    padding: 2px 10px;
                                    margin-bottom: 0.8rem;
                                    overflow: hidden;
                                    white-space: nowrap;
                                    font-size: .95rem;
                                }
                                .breadcrumb-modern .breadcrumb-item + .breadcrumb-item::before {
                                    content: '\203A';
                                    color: #b3b3b3;
                                    margin: 0 8px;
                                    font-size: 1.1em;
                                }
                                .breadcrumb-modern .breadcrumb-item a {
                                    color: #3471f7;
                                    text-decoration: none;
                                    transition: color 0.2s;
                                }
                                .breadcrumb-modern .breadcrumb-item a:hover {
                                    text-decoration: underline;
                                }
                                .breadcrumb-modern .breadcrumb-item.active {
                                    color: #21243d;
                                    font-weight: 600;
                                    display: inline-block;
                                    max-width: 60vw;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    vertical-align: bottom;
                                }
                                @media (max-width:600px) {
                                    .breadcrumb-modern {
                                        padding: 2px 8px;
                                        font-size: .92rem;
                                    }
                                }
                            </style>
                            <!-- Breadcrumb Section: Modern -->
                            <nav class="breadcrumb-nav mb-2" aria-label="Breadcrumb">
                                <ol class="breadcrumb breadcrumb-modern align-items-center m-0">
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

