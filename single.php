<?php
/**
 * The template for displaying all single posts - Product Category Page
 */

get_header(); ?>

<main id="main" class="site-main product-category-page">
    <!-- Hero Section with Category Title -->
    <section class="category-hero-section">
        <div class="category-hero-background">
            <div class="category-hero-overlay"></div>
            <div class="tech-grid-pattern"></div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="category-hero-content text-center">
                        <h1 class="category-hero-title">
                            <span class="category-title-main"><?php single_cat_title(); ?></span>
                            <span class="category-title-sub">THIẾT BỊ ÂM THANH CHUYÊN NGHIỆP</span>
                        </h1>
                        <div class="category-description-wrapper">
                            <p class="category-hero-description">
                                <?php 
                                $description = category_description();
                                echo $description ? $description : 'Khám phá bộ sưu tập thiết bị âm thanh chuyên nghiệp với chất lượng vượt trội, phù hợp cho mọi nhu cầu từ cá nhân đến doanh nghiệp.';
                                ?>
                            </p>
                        </div>
                        <div class="category-stats">
                            <div class="stat-item">
                                <div class="stat-number"><?php 
                                    $current_cat = get_queried_object();
                                    $product_count = $current_cat->count;
                                    echo $product_count;
                                ?>+</div>
                                <div class="stat-label">Sản phẩm</div>
                            </div>
                            <div class="stat-divider"></div>
                            <div class="stat-item">
                                <div class="stat-number">100%</div>
                                <div class="stat-label">Chính hãng</div>
                            </div>
                            <div class="stat-divider"></div>
                            <div class="stat-item">
                                <div class="stat-number">24/7</div>
                                <div class="stat-label">Hỗ trợ</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Grid Section -->
    <section class="products-grid-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-header">
                        <h2 class="section-title">
                            <span class="title-text">Sản phẩm trong danh mục</span>
                            <span class="title-line"></span>
                        </h2>
                        <div class="section-filters">
                            <div class="filter-item active" data-filter="all">
                                <i class="fas fa-th-large"></i>
                                <span>Tất cả</span>
                            </div>
                            <div class="filter-item" data-filter="featured">
                                <i class="fas fa-star"></i>
                                <span>Nổi bật</span>
                            </div>
                            <div class="filter-item" data-filter="new">
                                <i class="fas fa-sparkles"></i>
                                <span>Mới nhất</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="products-grid">
                <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 12,
                    'paged' => $paged,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'terms' => get_queried_object()->slug,
                        ),
                    ),
                );
                $product_query = new WP_Query($args);
                if ($product_query->have_posts()) :
                    $product_count = 0;
                    while ($product_query->have_posts()) : $product_query->the_post();
                        $product_count++;
                        global $product;
                        
                        // Get product data
                        $product_id = get_the_ID();
                        $product_title = get_the_title();
                        $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'full');
                        $product_image_url = $product_image ? $product_image[0] : wc_placeholder_img_src();
                        $product_link = get_permalink();
                        $product_short_description = $product->get_short_description();
                        
                        // Get product categories
                        $categories = get_the_terms($product_id, 'product_cat');
                        $main_category = $categories && !is_wp_error($categories) ? $categories[0]->name : '';
                        
                        // Determine badge
                        $badge = '';
                        $badge_class = '';
                        if ($product->is_featured()) {
                            $badge = 'NỔI BẬT';
                            $badge_class = 'featured';
                        } elseif (strtotime(get_the_date()) > strtotime('-30 days')) {
                            $badge = 'MỚI';
                            $badge_class = 'new';
                        }
                        
                        // Animation delay
                        $delay = ($product_count % 4) * 0.1;
                ?>
                    <a href="<?php echo esc_url($product_link); ?>" class="product-card-wrapper" data-category="<?php echo esc_attr($badge_class ? $badge_class : 'all'); ?>" data-animation-delay="<?php echo esc_attr($delay); ?>">
                        <div class="modern-product-card">
                            <div class="product-image-container">
                                <div class="product-image">
                                    <img src="<?php echo esc_url($product_image_url); ?>" alt="<?php echo esc_attr($product_title); ?>" loading="lazy">
                                </div>
                                <?php if ($badge): ?>
                                    <div class="product-badge <?php echo esc_attr($badge_class); ?>">
                                        <span><?php echo esc_html($badge); ?></span>
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
                                    <?php echo esc_html($product_title); ?>
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
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <div class="no-products-wrapper col-12">
                        <div class="no-products-content">
                            <div class="no-products-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3>Không có sản phẩm nào trong danh mục này</h3>
                            <p>Vui lòng kiểm tra lại hoặc khám phá các danh mục khác</p>
                            <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn-back-to-shop">
                                <i class="fas fa-arrow-left"></i>
                                <span>Quay về cửa hàng</span>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php
            // Pagination - moved outside products-grid
            if ($product_query->max_num_pages > 1) :
            ?>
                <div class="pagination-wrapper col-12">
                    <div class="modern-pagination">
                        <?php
                        echo paginate_links(array(
                            'total' => $product_query->max_num_pages,
                            'current' => $paged,
                            'prev_text' => '<i class="fas fa-chevron-left"></i><span>Trước</span>',
                            'next_text' => '<span>Sau</span><i class="fas fa-chevron-right"></i>',
                            'type' => 'list'
                        ));
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Audio Solutions Section -->
    <section class="audio-solutions-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-header text-center">
                        <h2 class="section-title">
                            <span class="title-text">Giải pháp âm thanh tối ưu cho mọi nhu cầu</span>
                            <span class="title-line"></span>
                        </h2>
                        <p class="section-description">
                            Chúng tôi cung cấp các giải pháp âm thanh chuyên nghiệp, phù hợp với mọi nhu cầu từ cá nhân đến doanh nghiệp
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="solution-content">
                        <div class="solution-features">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>Công nghệ tiên tiến</h4>
                                    <p>Sử dụng công nghệ âm thanh mới nhất với chất lượng cao cấp</p>
                                </div>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>Đội ngũ chuyên nghiệp</h4>
                                    <p>Kỹ thuật viên giàu kinh nghiệm, tư vấn và hỗ trợ tận tâm</p>
                                </div>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>Lắp đặt chuyên nghiệp</h4>
                                    <p>Dịch vụ lắp đặt, cân chỉnh và bảo trì toàn diện</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="solution-visual">
                        <div class="tech-visualization">
                            <div class="audio-waveform">
                                <div class="wave-bar" data-height="40"></div>
                                <div class="wave-bar" data-height="70"></div>
                                <div class="wave-bar" data-height="90"></div>
                                <div class="wave-bar" data-height="60"></div>
                                <div class="wave-bar" data-height="80"></div>
                                <div class="wave-bar" data-height="50"></div>
                                <div class="wave-bar" data-height="85"></div>
                                <div class="wave-bar" data-height="45"></div>
                            </div>
                            <div class="solution-stats">
                                <div class="stat-circle">
                                    <div class="stat-value">15+</div>
                                    <div class="stat-label">Năm kinh nghiệm</div>
                                </div>
                                <div class="stat-circle">
                                    <div class="stat-value">500+</div>
                                    <div class="stat-label">Dự án hoàn thành</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Latest News Section -->
    <section class="latest-news-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-header">
                        <div class="section-header-content">
                            <h2 class="section-title">
                                <span class="title-text">Tin tức mới nhất</span>
                                <span class="title-line"></span>
                            </h2>
                            <p class="section-description">Cập nhật thông tin và kiến thức chuyên môn về âm thanh</p>
                        </div>
                        <div class="section-header-action">
                            <a href="<?php echo home_url('/tin-tuc'); ?>" class="btn-view-all">
                                <span>Xem tất cả</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="news-grid">
                <?php
                $news_query = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'orderby' => 'date',
                    'order' => 'DESC',
                ));
                if ($news_query->have_posts()) :
                    $news_count = 0;
                    while ($news_query->have_posts()) : $news_query->the_post();
                    $news_count++;
                    $delay = $news_count * 0.1;
                ?>
                    <article class="modern-news-card" data-animation-delay="<?php echo esc_attr($delay); ?>">
                        <div class="news-card-inner">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="news-image">
                                    <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                    <div class="news-image-overlay">
                                        <div class="news-category-badge">
                                            <i class="fas fa-folder"></i>
                                            <span><?php the_category(', '); ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="news-content">
                                <div class="news-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span><?php echo get_the_date('d/m/Y'); ?></span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-clock"></i>
                                        <span><?php echo estimated_reading_time(get_the_content()); ?> phút đọc</span>
                                    </div>
                                </div>
                                <h3 class="news-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <div class="news-excerpt">
                                    <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                </div>
                                <div class="news-footer">
                                    <a href="<?php the_permalink(); ?>" class="btn-read-more">
                                        <span>Đọc thêm</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                    <div class="news-share">
                                        <button class="btn-share" data-share-title="<?php echo esc_attr(get_the_title()); ?>" data-share-url="<?php echo esc_url(get_permalink()); ?>">
                                            <i class="fas fa-share-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <div class="no-news">
                        <div class="no-news-content">
                            <i class="fas fa-newspaper"></i>
                            <h3>Chưa có tin tức nào</h3>
                            <p>Hãy quay lại sau để cập nhật thông tin mới nhất</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Contact CTA Section -->
    <section class="contact-cta-section">
        <div class="container">
            <div class="cta-wrapper">
                <div class="cta-background">
                    <div class="cta-pattern"></div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="cta-content">
                            <h2 class="cta-title">Cần tư vấn về giải pháp âm thanh?</h2>
                            <p class="cta-description">
                                Đội ngũ chuyên gia của TD Classic sẵn sàng lắng nghe và tư vấn giải pháp phù hợp nhất với nhu cầu của bạn
                            </p>
                            <div class="cta-features">
                                <div class="cta-feature">
                                    <i class="fas fa-phone"></i>
                                    <span>Tư vấn miễn phí</span>
                                </div>
                                <div class="cta-feature">
                                    <i class="fas fa-clock"></i>
                                    <span>Hỗ trợ 24/7</span>
                                </div>
                                <div class="cta-feature">
                                    <i class="fas fa-shipping-fast"></i>
                                    <span>Giao hàng toàn quốc</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="cta-actions">
                            <a href="<?php echo home_url('/lien-he'); ?>" class="btn-cta-primary">
                                <i class="fas fa-headphones"></i>
                                <span>Liên hệ tư vấn</span>
                            </a>
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', tdclassic_get_company_phone())); ?>" class="btn-cta-secondary">
                                <i class="fas fa-phone"></i>
                                <span>Hotline: <?php echo esc_html(tdclassic_get_company_phone()); ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
/* Modern Product Category Page Styles */
.product-category-page {
    background-color: #fff;
}

/* Category Hero Section */
.category-hero-section {
    background: #424242;
    background: radial-gradient(circle,rgba(66, 66, 66, 1) 0%, rgba(0, 0, 0, 1) 100%);
    color: #fff;
    padding: 100px 0 80px;
    position: relative;
    overflow: hidden;
}

.category-hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.category-hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
}

 {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
    background-size: 50px 50px;
    animation: gridMove 20s linear infinite;
}

@keyframes gridMove {
    0% { transform: translate(0, 0); }
    100% { transform: translate(50px, 50px); }
}

.category-hero-content {
    position: relative;
    z-index: 10;
}

.category-hero-title {
    margin-bottom: 2rem;
}

.category-title-main {
    display: block;
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    background: linear-gradient(45deg, #fff, #ccc);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.category-title-sub {
    display: block;
    font-size: 1.2rem;
    font-weight: 400;
    color: #ccc;
    letter-spacing: 3px;
    text-transform: uppercase;
}

.category-description-wrapper {
    margin: 0 auto 3rem;
}

.category-hero-description {
    font-size: 1.2rem;
    color: #ccc;
    line-height: 1.8;
}

.category-stats {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 2rem;
    margin-top: 3rem;
}

.category-stats .stat-item {
    text-align: center;
}

.category-stats .stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 0.5rem;
}

.category-stats .stat-label {
    font-size: 0.9rem;
    color: #999;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.category-stats .stat-divider {
    width: 1px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
}

/* Products Grid Section */
.products-grid-section {
    padding: 40px 0;
    background-color: #f8f9fa;
}

.section-header {
    margin-bottom: 4rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 2rem;
}

.section-title {
    position: relative;
    display: flex;
    align-items: center;
    gap: 1rem;
    margin: 0;
}

.title-text {
    font-size: 2.5rem;
    font-weight: 700;
    color: #000;
}

.title-line {
    width: 100px;
    height: 3px;
    background: linear-gradient(45deg, #000, #666);
}

.section-filters {
    display: flex;
    gap: 1rem;
}

.filter-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.8rem 1.5rem;
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    color: #666;
}

.filter-item:hover,
.filter-item.active {
    background: #000;
    color: #fff;
    border-color: #000;
    transform: translateY(-2px);
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 4rem;
    justify-content: center;
    align-content: start;
}

.product-card-wrapper {
    animation: fadeInUp 0.6s ease forwards;
    opacity: 0;
    transform: translateY(30px);
    justify-self: center;
    max-width: 450px;
    width: 100%;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modern-product-card {
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    position: relative;
    width: 100%;
    height: 100%;
}

.modern-product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.product-image-container {
    position: relative;
    overflow: hidden;
}

.product-image {
    overflow: hidden;
    position: relative;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.modern-product-card:hover .product-image img {
    transform: scale(1.1);
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
}

.modern-product-card:hover .image-overlay {
    opacity: 1;
}

.overlay-content {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.btn-overlay-primary,
.btn-overlay-secondary {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.8rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-overlay-primary {
    background: #fff;
    color: #000;
}

.btn-overlay-secondary {
    background: transparent;
    color: #fff;
    border: 1px solid #fff;
    padding: 0.8rem;
}

.btn-overlay-primary:hover {
    background: #000;
    color: #fff;
}

.btn-overlay-secondary:hover {
    background: #fff;
    color: #000;
}

.product-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    z-index: 5;
}

.product-badge span {
    background: #000;
    color: #fff;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.product-badge.featured span {
    background: linear-gradient(45deg, #FFD700, #FFA500);
    color: #000;
}

.product-badge.new span {
    background: linear-gradient(45deg, #00C851, #007E33);
}

.product-tech-indicator {
    position: absolute;
    top: 15px;
    right: 15px;
    display: flex;
    gap: 3px;
}

.tech-dot {
    width: 6px;
    height: 6px;
    background: rgba(255, 255, 255, 0.6);
    border-radius: 50%;
    animation: techPulse 2s ease-in-out infinite;
}

.tech-dot:nth-child(2) {
    animation-delay: 0.3s;
}

.tech-dot:nth-child(3) {
    animation-delay: 0.6s;
}

@keyframes techPulse {
    0%, 100% { opacity: 0.6; transform: scale(1); }
    50% { opacity: 1; transform: scale(1.2); }
}

.product-content {
    padding: 1.5rem;
}

.product-category-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: #f0f0f0;
    color: #666;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
    margin-bottom: 1rem;
}

.product-title {
    margin-bottom: 1rem;
}

.product-title a {
    color: #000;
    font-size: 1.2rem;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.3s ease;
}

.product-title a:hover {
    color: #666;
}

.product-description {
    margin-bottom: 1rem;
}

.product-description p {
    color: #666;
    line-height: 1.6;
    margin: 0;
}

.product-features {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    color: #666;
    font-size: 0.85rem;
}

.feature-item i {
    color: #28a745;
    font-size: 0.8rem;
}

.product-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.btn-product-detail {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.8rem 1.5rem;
    background: #000;
    color: #fff;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-product-detail:hover {
    background: #333;
    color: #fff;
    transform: translateX(5px);
}

.btn-product-contact {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.8rem;
    background: transparent;
    color: #666;
    text-decoration: none;
    border: 1px solid #e0e0e0;
    border-radius: 20px;
    transition: all 0.3s ease;
}

.btn-product-contact:hover {
    background: #000;
    color: #fff;
    border-color: #000;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 3rem;
}

.modern-pagination ul {
    display: flex;
    gap: 0.5rem;
    list-style: none;
    padding: 0;
    margin: 0;
}

.modern-pagination li {
    margin: 0;
}

.modern-pagination a,
.modern-pagination span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.8rem 1.2rem;
    background: #fff;
    color: #666;
    text-decoration: none;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-weight: 500;
}

.modern-pagination a:hover,
.modern-pagination .current span {
    background: #000;
    color: #fff;
    border-color: #000;
}

/* No Products */
.no-products-wrapper {
    grid-column: 1 / -1;
    display: flex;
    justify-content: center;
    padding: 4rem 0;
}

.no-products-content {
    text-align: center;
    max-width: 400px;
}

.no-products-icon {
    font-size: 4rem;
    color: #ccc;
    margin-bottom: 1.5rem;
}

.no-products-content h3 {
    color: #000;
    margin-bottom: 1rem;
}

.no-products-content p {
    color: #666;
    margin-bottom: 2rem;
}

.btn-back-to-shop {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.8rem 2rem;
    background: #000;
    color: #fff;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-back-to-shop:hover {
    background: #333;
    color: #fff;
    transform: translateX(-5px);
}

/* Audio Solutions Section */
.audio-solutions-section {
    padding: 80px 0;
    background-color: #fff;
}

.solution-content {
    padding: 2rem 0;
}

.solution-features {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.solution-features .feature-item {
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
}

.solution-features .feature-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #000, #333);
    color: #fff;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.solution-features .feature-content h4 {
    color: #000;
    margin-bottom: 0.5rem;
    font-size: 1.2rem;
}

.solution-features .feature-content p {
    color: #666;
    margin: 0;
    line-height: 1.6;
}

.solution-visual {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.tech-visualization {
    position: relative;
    width: 100%;
    max-width: 400px;
}

.audio-waveform {
    display: flex;
    align-items: end;
    justify-content: center;
    gap: 8px;
    height: 200px;
    margin-bottom: 2rem;
}

.wave-bar {
    width: 20px;
    background: linear-gradient(to top, #000, #666);
    border-radius: 10px 10px 0 0;
    animation: waveAnimation 2s ease-in-out infinite;
}

.wave-bar:nth-child(even) {
    animation-delay: 0.3s;
}

.wave-bar:nth-child(3n) {
    animation-delay: 0.6s;
}

@keyframes waveAnimation {
    0%, 100% { transform: scaleY(0.5); opacity: 0.6; }
    50% { transform: scaleY(1); opacity: 1; }
}

.solution-stats {
    display: flex;
    justify-content: space-around;
    gap: 2rem;
}

.stat-circle {
    text-align: center;
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 15px;
    border: 2px solid #e0e0e0;
    transition: all 0.3s ease;
}

.stat-circle:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #000;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.9rem;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Partners & Certifications Section */
.partners-certifications-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
}

.partners-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.partner-item {
    background: #fff;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #e0e0e0;
}

.partner-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.partner-logo {
    position: relative;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.partner-name {
    font-size: 1.2rem;
    font-weight: 700;
    color: #000;
    letter-spacing: 1px;
}

.partner-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.9);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
    font-size: 2rem;
}

.partner-item:hover .partner-overlay {
    opacity: 1;
}

/* Latest News Section */
.latest-news-section {
    padding: 80px 0;
    background-color: #fff;
}

.section-header-content {
    flex: 1;
}

.section-header-action .btn-view-all {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.8rem 1.5rem;
    background: transparent;
    color: #000;
    text-decoration: none;
    border: 1px solid #000;
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.section-header-action .btn-view-all:hover {
    background: #000;
    color: #fff;
}

.news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.modern-news-card {
    animation: fadeInUp 0.6s ease forwards;
    opacity: 0;
    transform: translateY(30px);
}

.news-card-inner {
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.news-card-inner:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.news-image {
    height: 200px;
    overflow: hidden;
    position: relative;
}

.news-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.news-card-inner:hover .news-image img {
    transform: scale(1.1);
}

.news-image-overlay {
    position: absolute;
    top: 15px;
    left: 15px;
}

.news-category-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(0, 0, 0, 0.8);
    color: #fff !important;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
}

.news-category-badge a{color: #fff !important;}


.news-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.news-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    color: #666;
    font-size: 0.85rem;
}

.meta-item i {
    color: #999;
}

.news-title {
    margin-bottom: 1rem;
    flex-grow: 1;
}

.news-title a {
    color: #000;
    text-decoration: none;
    font-size: 1.1rem;
    font-weight: 600;
    line-height: 1.4;
    transition: color 0.3s ease;
}

.news-title a:hover {
    color: #666;
}

.news-excerpt {
    margin-bottom: 1.5rem;
}

.news-excerpt p {
    color: #666;
    line-height: 1.6;
    margin: 0;
}

.news-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}

.btn-read-more {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #000;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-read-more:hover {
    color: #666;
    transform: translateX(5px);
}

.btn-share {
    background: transparent;
    border: 1px solid #e0e0e0;
    color: #666;
    padding: 0.5rem;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-share:hover {
    background: #000;
    color: #fff;
    border-color: #000;
}

/* Contact CTA Section */
.contact-cta-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #000 0%, #1a1a1a 100%);
    color: #fff;
    position: relative;
    overflow: hidden;
}

.cta-wrapper {
    position: relative;
    z-index: 10;
}

.cta-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.cta-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
    background-size: 40px 40px;
    animation: patternMove 15s linear infinite;
}

@keyframes patternMove {
    0% { transform: translate(0, 0); }
    100% { transform: translate(40px, 40px); }
}

.cta-content {
    position: relative;
    z-index: 10;
}

.cta-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #fff;
}

.cta-description {
    font-size: 1.1rem;
    color: #ccc;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.cta-features {
    display: flex;
    gap: 2rem;
    margin-bottom: 0;
}

.cta-feature {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #ccc;
    font-size: 0.9rem;
}

.cta-feature i {
    color: #fff;
    font-size: 1.1rem;
}

.cta-actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    position: relative;
    z-index: 10;
}

.btn-cta-primary,
.btn-cta-secondary {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.8rem;
    padding: 1rem 2rem;
    text-decoration: none;
    border-radius: 30px;
    font-weight: 600;
    transition: all 0.4s ease;
    border: none;
    font-size: 1rem;
}

.btn-cta-primary {
    background: #fff;
    color: #000;
}

.btn-cta-primary:hover {
    background: #f0f0f0;
    color: #000;
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
}

.btn-cta-secondary {
    background: transparent;
    color: #fff;
    border: 1px solid #fff;
}

.btn-cta-secondary:hover {
    background: #fff;
    color: #000;
    transform: translateY(-3px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .category-title-main {
        font-size: 2.5rem;
    }
    
    .category-title-sub {
        font-size: 1rem;
        letter-spacing: 2px;
    }
    
    .category-stats {
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1.5rem;
    }
    
    .section-filters {
        flex-wrap: wrap;
    }
    
    .filter-item {
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
    }
    
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        justify-content: center;
    }
    
    .product-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn-product-contact {
        justify-content: center;
    }
    
    .solution-features .feature-item {
        display: flex;
        flex-direction: column;
        text-align: center;
        gap: 1rem;
        flex-wrap: nowrap;
        align-content: center;
        align-items: center;
    }
    
    .cta-features {
        flex-direction: column;
        gap: 1rem;
    }
    
    .cta-title {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .category-hero-section {
        padding: 60px 0 50px;
    }
    
    .category-title-main {
        font-size: 2rem;
    }
    
    .title-text {
        font-size: 2rem;
    }
    
    .products-grid {
        grid-template-columns: 1fr;
        justify-content: center;
    }
    
    .modern-product-card {
        max-width: 100%;
    }
    
    .partners-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .news-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Share functionality
function shareProduct(title, url) {
    if (navigator.share) {
        navigator.share({
            title: title,
            url: url
        });
    } else {
        // Fallback
        const shareText = `${title} - ${url}`;
        navigator.clipboard.writeText(shareText).then(() => {
            alert('Đã sao chép link sản phẩm!');
        });
    }
}

function shareArticle(title, url) {
    if (navigator.share) {
        navigator.share({
            title: title,
            url: url
        });
    } else {
        // Fallback
        const shareText = `${title} - ${url}`;
        navigator.clipboard.writeText(shareText).then(() => {
            alert('Đã sao chép link bài viết!');
        });
    }
}

// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterItems = document.querySelectorAll('.filter-item');
    const productCards = document.querySelectorAll('.product-card-wrapper');
    
    filterItems.forEach(filter => {
        filter.addEventListener('click', function() {
            // Remove active class from all filters
            filterItems.forEach(f => f.classList.remove('active'));
            // Add active class to clicked filter
            this.classList.add('active');
            
            const filterValue = this.getAttribute('data-filter');
            
            productCards.forEach(card => {
                if (filterValue === 'all' || card.getAttribute('data-category') === filterValue) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
});

// Reading time estimation
function estimatedReadingTime(content) {
    const wordsPerMinute = 200; // Average reading speed
    const words = content.split(' ').length;
    const minutes = Math.ceil(words / wordsPerMinute);
    return minutes;
}
</script>

<?php
// Helper function for reading time
function estimated_reading_time($content) {
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200);
    return max(1, $reading_time);
}
?>

<?php get_footer(); ?>