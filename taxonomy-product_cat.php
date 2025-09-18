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
                                <div class="card product-card h-100">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="card-img-top position-relative">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('medium', array('class' => 'card-img-top')); ?>
                                            </a>
                                            <?php if ($product && $product->is_on_sale()) : ?>
                                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                                    <i class="fas fa-tag me-1"></i>Sale
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">
                                            <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                                                <?php the_title(); ?>
                                            </a>
                                        </h5>
                                        
                                        <div class="product-meta mb-2">
                                            <?php
                                            $terms = get_the_terms(get_the_ID(), 'product_cat');
                                            if ($terms && !is_wp_error($terms)) :
                                                foreach ($terms as $term) :
                                                    ?>
                                                    <span class="badge bg-secondary me-1">
                                                        <i class="fas fa-tag me-1"></i>
                                                        <?php echo $term->name; ?>
                                                    </span>
                                                <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </div>
                                        
                                        <div class="card-text flex-grow-1">
                                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                        </div>
                                        
                                        <div class="product-price mt-auto">
                                            <?php if ($product) : ?>
                                                <div class="price mb-2">
                                                    <?php echo $product->get_price_html(); ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-eye me-1"></i>
                                                    Xem chi tiết
                                                </a>
                                                
                                                <?php if ($product && $product->is_purchasable()) : ?>
                                                    <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" 
                                                       class="btn btn-primary btn-sm add-to-cart"
                                                       data-product_id="<?php echo $product->get_id(); ?>">
                                                        <i class="fas fa-shopping-cart me-1"></i>
                                                        Thêm vào giỏ
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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