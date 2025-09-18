<?php
/**
 * The template for displaying the blog page
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-12">
                <header class="page-header mb-5">
                    <h1 class="page-title">Blog</h1>
                    <p class="page-description lead text-muted">
                        Cập nhật những thông tin mới nhất về công nghệ, xu hướng thị trường và kiến thức hữu ích
                    </p>
                </header>

                <?php if (have_posts()) : ?>
                    <div class="row g-4">
                        <?php while (have_posts()) : the_post(); ?>
                            <div class="col-lg-6 col-md-12">
                                <article class="blog-post">
                                    <div class="card h-100">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <img src="<?php the_post_thumbnail_url('blog-thumb'); ?>" class="card-img-top" alt="<?php the_title(); ?>">
                                        <?php else : ?>
                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                                <span class="text-muted">Blog Image</span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="card-body d-flex flex-column">
                                            <div class="blog-meta mb-3">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    <?php echo get_the_date(); ?>
                                                    <span class="mx-2">|</span>
                                                    <i class="fas fa-user me-1"></i>
                                                    <?php the_author(); ?>
                                                    <?php if (get_the_category()) : ?>
                                                        <span class="mx-2">|</span>
                                                        <i class="fas fa-folder me-1"></i>
                                                        <?php the_category(', '); ?>
                                                    <?php endif; ?>
                                                </small>
                                            </div>
                                            
                                            <h5 class="card-title">
                                                <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h5>
                                            
                                            <p class="card-text flex-grow-1"><?php the_excerpt(); ?></p>
                                            
                                            <div class="mt-auto">
                                                <a href="<?php the_permalink(); ?>" class="btn btn-outline-primary">
                                                    Đọc thêm
                                                </a>
                                                
                                                <?php if (get_the_tags()) : ?>
                                                    <div class="blog-tags mt-3">
                                                        <small class="text-muted">
                                                            <i class="fas fa-tags me-1"></i>
                                                            <?php the_tags('', ', ', ''); ?>
                                                        </small>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <!-- Pagination -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <?php tdclassic_pagination(); ?>
                        </div>
                    </div>

                <?php else : ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info text-center" role="alert">
                                <h4>Chưa có bài viết nào</h4>
                                <p class="mb-0">Hiện tại chúng tôi chưa có bài viết nào để hiển thị. Vui lòng quay lại sau.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?> 