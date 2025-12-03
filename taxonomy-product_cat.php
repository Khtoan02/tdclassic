<?php
/**
 * The template for displaying WooCommerce product category archives
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package TD_Classic
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <header class="page-header">
                    <?php
                    $queried_object = get_queried_object();
                    ?>
                    <h1 class="page-title">
                        <i class="fas fa-folder-open me-2"></i>
                        <?php echo single_term_title('', false); ?>
                    </h1>
                    <?php
                    $term_description = term_description();
                    if (!empty($term_description)) :
                        echo '<div class="archive-description">' . $term_description . '</div>';
                    endif;
                    ?>
                </header>

                <?php if (have_posts()) : ?>
                    <div class="row">
                        <?php
                        while (have_posts()) :
                            the_post();
                            global $product;
                            if (!$product) {
                                $product = wc_get_product(get_the_ID());
                            }
                            ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <a href="<?php the_permalink(); ?>" class="product-card-wrapper">
                                    <div class="modern-product-card">
                                        <div class="product-image-container">
                                            <div class="product-image">
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <img src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="<?php the_title(); ?>" loading="lazy">
                                                <?php else : ?>
                                                    <div class="product-placeholder">
                                                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                            <polyline points="21,15 16,10 5,21"></polyline>
                                                        </svg>
                                                        <span class="placeholder-text">Chưa có ảnh</span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php if ($product && $product->is_on_sale()) : ?>
                                                <div class="product-badge sale">
                                                    <span>Sale</span>
                                                </div>
                                            <?php endif; ?>
                                            <div class="product-tech-indicator">
                                                <div class="tech-dot"></div>
                                                <div class="tech-dot"></div>
                                                <div class="tech-dot"></div>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <h3 class="product-title">
                                                <?php the_title(); ?>
                                            </h3>
                                            <div class="product-features">
                                                <div class="feature-item">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Chính hãng</span>
                                                </div>
                                                <div class="feature-item">
                                                    <i class="fas fa-shield-alt"></i>
                                                    <span>Bảo hành</span>
                                                </div>
                                                <div class="feature-item">
                                                    <i class="fas fa-shipping-fast"></i>
                                                    <span>Giao nhanh</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
                        endwhile;
                        ?>
                    </div>

                    <?php
                    // Custom pagination
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $total_pages = $wp_query->max_num_pages;
                    
                    if ($total_pages > 1) :
                        ?>
                        <nav aria-label="Products pagination">
                            <ul class="pagination justify-content-center">
                                <?php
                                echo paginate_links(array(
                                    'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                                    'format' => '?paged=%#%',
                                    'current' => max(1, $paged),
                                    'total' => $total_pages,
                                    'prev_text' => '<i class="fas fa-chevron-left"></i>',
                                    'next_text' => '<i class="fas fa-chevron-right"></i>',
                                    'type' => 'list',
                                    'end_size' => 1,
                                    'mid_size' => 1
                                ));
                                ?>
                            </ul>
                        </nav>
                    <?php endif; ?>

                <?php else : ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Không tìm thấy sản phẩm nào</strong>
                        <p class="mb-0">Hiện tại chưa có sản phẩm nào trong danh mục này.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-4">
                <aside class="sidebar">
                    <!-- Product Categories -->
                    <div class="widget">
                        <h5 class="widget-title">
                            <i class="fas fa-list me-2"></i>
                            Danh mục sản phẩm
                        </h5>
                        <ul class="list-unstyled">
                            <?php
                            $categories = get_terms(array(
                                'taxonomy' => 'product_cat',
                                'hide_empty' => false,
                                'orderby' => 'name',
                                'order' => 'ASC'
                            ));
                            
                            if ($categories && !is_wp_error($categories)) :
                                foreach ($categories as $category) :
                                    $is_current = (get_queried_object_id() == $category->term_id);
                                    ?>
                                    <li class="mb-2">
                                        <a href="<?php echo get_term_link($category); ?>" 
                                           class="d-flex justify-content-between align-items-center text-decoration-none <?php echo $is_current ? 'text-primary fw-bold' : ''; ?>">
                                            <span>
                                                <i class="fas fa-folder me-2"></i>
                                                <?php echo $category->name; ?>
                                            </span>
                                            <span class="badge bg-secondary"><?php echo $category->count; ?></span>
                                        </a>
                                    </li>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </div>

                    <!-- Latest Products -->
                    <div class="widget">
                        <h5 class="widget-title">
                            <i class="fas fa-star me-2"></i>
                            Sản phẩm mới
                        </h5>
                        <?php
                        $latest_products = get_posts(array(
                            'post_type' => 'product',
                            'posts_per_page' => 5,
                            'orderby' => 'date',
                            'order' => 'DESC'
                        ));
                        
                        if ($latest_products) :
                            ?>
                            <div class="list-group">
                                <?php
                                foreach ($latest_products as $product_post) :
                                    setup_postdata($product_post);
                                    $product = wc_get_product($product_post->ID);
                                    ?>
                                    <a href="<?php echo get_permalink($product_post->ID); ?>" 
                                       class="list-group-item list-group-item-action d-flex align-items-center">
                                        <?php if (has_post_thumbnail($product_post->ID)) : ?>
                                            <img src="<?php echo get_the_post_thumbnail_url($product_post->ID, 'thumbnail'); ?>" 
                                                 class="me-3 rounded" 
                                                 width="60" 
                                                 height="60"
                                                 alt="<?php echo get_the_title($product_post->ID); ?>">
                                        <?php endif; ?>
                                        <div>
                                            <h6 class="mb-1"><?php echo get_the_title($product_post->ID); ?></h6>
                                            <?php if ($product) : ?>
                                                <small class="text-muted"><?php echo $product->get_price_html(); ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                <?php
                                endforeach;
                                wp_reset_postdata();
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</main>

<?php
get_footer(); 