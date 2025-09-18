<?php
/**
 * The template for displaying product category archive pages
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-12">
                <header class="page-header mb-5">
                    <h1 class="page-title">
                        <i class="fas fa-box me-2"></i>
                        Danh mục sản phẩm: <?php single_term_title(); ?>
                    </h1>
                    <?php if (term_description()) : ?>
                        <div class="page-description lead text-muted">
                            <?php echo term_description(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo home_url('/'); ?>">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo home_url('/san-pham'); ?>">Sản phẩm</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php single_term_title(); ?></li>
                        </ol>
                    </nav>
                </header>

                <!-- Filter Section -->
                <div class="filter-section mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <?php 
                                $term = get_queried_object();
                                $count = $term->count;
                                echo $count;
                                ?> sản phẩm
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-md-end">
                                <select class="form-select" style="width: auto;" onchange="sortProducts(this.value)">
                                    <option value="newest">Mới nhất</option>
                                    <option value="oldest">Cũ nhất</option>
                                    <option value="name-asc">Tên A-Z</option>
                                    <option value="name-desc">Tên Z-A</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (have_posts()) : ?>
                    <div class="row g-4 product-grid">
                        <?php while (have_posts()) : the_post(); ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="card h-100">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img src="<?php the_post_thumbnail_url('product-thumb'); ?>" class="card-img-top" alt="<?php the_title(); ?>">
                                    <?php else : ?>
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <span class="text-muted">Product Image</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title"><?php the_title(); ?></h5>
                                        <p class="card-text flex-grow-1"><?php the_excerpt(); ?></p>
                                        
                                        <div class="product-meta mb-3">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                <?php echo get_the_date(); ?>
                                                <span class="mx-2">|</span>
                                                <i class="fas fa-folder me-1"></i>
                                                <?php
                                                $terms = get_the_terms(get_the_ID(), 'product_category');
                                                if ($terms) {
                                                    $term_names = array();
                                                    foreach ($terms as $term) {
                                                        $term_names[] = '<a href="' . get_term_link($term) . '">' . $term->name . '</a>';
                                                    }
                                                    echo implode(', ', $term_names);
                                                }
                                                ?>
                                            </small>
                                        </div>
                                        
                                        <div class="mt-auto">
                                            <a href="<?php the_permalink(); ?>" class="btn btn-primary w-100">
                                                Xem chi tiết
                                            </a>
                                        </div>
                                    </div>
                                </div>
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
                    <div class="alert alert-info text-center" role="alert">
                        <h4>Không có sản phẩm nào trong danh mục này</h4>
                        <p class="mb-0">Hiện tại danh mục "<?php single_term_title(); ?>" chưa có sản phẩm nào.</p>
                        <a href="<?php echo home_url('/san-pham'); ?>" class="btn btn-primary mt-3">Xem tất cả sản phẩm</a>
                    </div>
                <?php endif; ?>

                <!-- Other Categories -->
                <div class="other-categories mt-5">
                    <h4 class="mb-4">Danh mục sản phẩm khác</h4>
                    <div class="row g-3">
                        <?php
                        $current_term = get_queried_object();
                        $product_categories = get_terms(array(
                            'taxonomy' => 'product_category',
                            'hide_empty' => true,
                            'exclude' => $current_term->term_id
                        ));
                        
                        if ($product_categories) :
                            foreach ($product_categories as $category) :
                        ?>
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h6 class="card-title"><?php echo $category->name; ?></h6>
                                        <p class="card-text text-muted"><?php echo $category->count; ?> sản phẩm</p>
                                        <a href="<?php echo get_term_link($category); ?>" class="btn btn-outline-primary btn-sm">
                                            Xem danh mục
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function sortProducts(sortBy) {
    const url = new URL(window.location);
    url.searchParams.set('orderby', sortBy);
    window.location.href = url.toString();
}
</script>

<?php get_footer(); ?> 