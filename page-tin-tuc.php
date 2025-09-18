<?php
/**
 * Template Name: Tin tức - Modern News Page
 * The template for displaying the news/blog page
 */

get_header(); ?>

<main id="main" class="site-main news-page">
    <!-- Hero Section -->
    <section class="news-hero-section">
        <div class="news-hero-background">
            <div class="news-hero-overlay"></div>
            <div class="tech-grid-pattern"></div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="news-hero-content text-center">
                        <h1 class="news-hero-title">
                            <span class="news-title-main">Tin tức</span>
                            <span class="news-title-sub">CẬP NHẬT THÔNG TIN MỚI NHẤT</span>
                        </h1>
                        <div class="news-description-wrapper">
                            <p class="news-hero-description">
                                Cập nhật những thông tin mới nhất về công nghệ, xu hướng thị trường và kiến thức hữu ích từ đội ngũ chuyên gia của chúng tôi.
                            </p>
                        </div>
                        <div class="news-stats">
                            <div class="stat-item">
                                <div class="stat-number"><?php 
                                    $post_count = wp_count_posts('post');
                                    echo $post_count->publish;
                                ?>+</div>
                                <div class="stat-label">Bài viết</div>
                            </div>
                            <div class="stat-divider"></div>
                            <div class="stat-item">
                                <div class="stat-number"><?php echo count(get_categories()); ?>+</div>
                                <div class="stat-label">Chủ đề</div>
                            </div>
                            <div class="stat-divider"></div>
                            <div class="stat-item">
                                <div class="stat-number">24/7</div>
                                <div class="stat-label">Cập nhật</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News Grid Section -->
    <section class="latest-news-grid-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-header">
                        <h2 class="section-title">
                            <span class="title-text">Bài viết mới nhất</span>
                            <span class="title-line"></span>
                        </h2>
                        <div class="section-filters">
                            <div class="filter-item active" data-filter="all">
                                <i class="fas fa-th-large"></i>
                                <span>Tất cả</span>
                            </div>
                            <div class="filter-item" data-filter="recent">
                                <i class="fas fa-clock"></i>
                                <span>Mới nhất</span>
                            </div>
                            <div class="filter-item" data-filter="popular">
                                <i class="fas fa-fire"></i>
                                <span>Phổ biến</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="news-posts-grid">
                <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $blog_posts = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 12,
                    'paged' => $paged,
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));

                if ($blog_posts->have_posts()) :
                    $post_count = 0;
                    while ($blog_posts->have_posts()) : $blog_posts->the_post();
                        $post_count++;
                        
                        // Get post data
                        $post_id = get_the_ID();
                        $post_title = get_the_title();
                        $post_image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
                        $post_image_url = $post_image ? $post_image[0] : '';
                        $post_link = get_permalink();
                        $post_excerpt = get_the_excerpt();
                        
                        // Get post categories
                        $categories = get_the_category();
                        $main_category = $categories ? $categories[0]->name : '';
                        
                        // Determine badge
                        $badge = '';
                        $badge_class = '';
                        if (strtotime(get_the_date()) > strtotime('-7 days')) {
                            $badge = 'MỚI';
                            $badge_class = 'recent';
                        } elseif (get_post_meta($post_id, 'popular_post', true)) {
                            $badge = 'HOT';
                            $badge_class = 'popular';
                        }
                        
                        // Animation delay
                        $delay = ($post_count % 4) * 0.1;
                ?>
                    <div class="news-post-card-wrapper" data-category="<?php echo esc_attr($badge_class ? $badge_class : 'all'); ?>" style="animation-delay: <?php echo $delay; ?>s;">
                        <div class="modern-news-card">
                            <div class="news-image-container">
                                <div class="news-image">
                                    <?php if ($post_image_url) : ?>
                                        <img src="<?php echo esc_url($post_image_url); ?>" alt="<?php echo esc_attr($post_title); ?>" loading="lazy">
                                    <?php else : ?>
                                        <div class="placeholder-image">
                                            <i class="fas fa-newspaper"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="image-overlay">
                                        <div class="overlay-content">
                                            <a href="<?php echo esc_url($post_link); ?>" class="btn-overlay-primary">
                                                <i class="fas fa-eye"></i>
                                                <span>Đọc bài viết</span>
                                            </a>
                                            <button class="btn-overlay-secondary" onclick="shareArticle('<?php echo esc_js($post_title); ?>', '<?php echo esc_url($post_link); ?>')">
                                                <i class="fas fa-share-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($badge): ?>
                                    <div class="news-badge <?php echo esc_attr($badge_class); ?>">
                                        <span><?php echo esc_html($badge); ?></span>
                                    </div>
                                <?php endif; ?>
                                <div class="news-tech-indicator">
                                    <div class="tech-dot"></div>
                                    <div class="tech-dot"></div>
                                    <div class="tech-dot"></div>
                                </div>
                            </div>
                            <div class="news-content">
                                <div class="news-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span><?php echo get_the_date('d/m/Y'); ?></span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-user"></i>
                                        <span><?php the_author(); ?></span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-clock"></i>
                                        <span><?php echo estimated_reading_time(get_the_content()); ?> phút đọc</span>
                                    </div>
                                </div>
                                <div class="news-category-tag">
                                    <i class="fas fa-tag"></i>
                                    <span><?php echo esc_html($main_category); ?></span>
                                </div>
                                <h3 class="news-title">
                                    <a href="<?php echo esc_url($post_link); ?>"><?php echo esc_html($post_title); ?></a>
                                </h3>
                                <div class="news-description">
                                    <p><?php echo wp_trim_words($post_excerpt, 15); ?></p>
                                </div>
                                <div class="news-tags">
                                    <?php if (get_the_tags()) : ?>
                                        <div class="tags-list">
                                            <i class="fas fa-tags"></i>
                                            <?php the_tags('', ', ', ''); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="news-actions">
                                    <a href="<?php echo esc_url($post_link); ?>" class="btn-news-detail">
                                        <span>Đọc thêm</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    endwhile;
                    
                    // Pagination
                    if ($blog_posts->max_num_pages > 1) :
                ?>
                    <div class="pagination-wrapper col-12">
                        <div class="modern-pagination">
                            <?php
                            $big = 999999999;
                            echo paginate_links(array(
                                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                'format' => '?paged=%#%',
                                'current' => max(1, get_query_var('paged')),
                                'total' => $blog_posts->max_num_pages,
                                'prev_text' => '<i class="fas fa-chevron-left"></i><span>Trước</span>',
                                'next_text' => '<span>Sau</span><i class="fas fa-chevron-right"></i>',
                                'type' => 'list'
                            ));
                            ?>
                        </div>
                    </div>
                <?php
                    endif;
                    wp_reset_postdata();
                else :
                ?>
                    <div class="no-news-wrapper col-12">
                        <div class="no-news-content">
                            <div class="no-news-icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <h3>Chưa có bài viết nào</h3>
                            <p>Hiện tại chúng tôi chưa có bài viết nào để hiển thị. Vui lòng quay lại sau.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-header text-center">
                        <h2 class="section-title">
                            <span class="title-text">Danh mục bài viết</span>
                            <span class="title-line"></span>
                        </h2>
                        <p class="section-description">
                            Khám phá các chủ đề đa dạng và phong phú
                        </p>
                    </div>
                </div>
            </div>
            <div class="categories-grid">
                <?php
                $categories = get_categories(array(
                    'orderby' => 'count',
                    'order' => 'DESC',
                    'number' => 8
                ));
                
                foreach ($categories as $category) :
                ?>
                    <div class="category-item">
                        <div class="category-card">
                            <div class="category-icon">
                                <i class="fas fa-folder"></i>
                            </div>
                            <div class="category-content">
                                <h4><?php echo $category->name; ?></h4>
                                <p><?php echo $category->count; ?> bài viết</p>
                                <?php if ($category->description) : ?>
                                    <small class="category-desc"><?php echo wp_trim_words($category->description, 8); ?></small>
                                <?php endif; ?>
                                <a href="<?php echo get_category_link($category->term_id); ?>" class="btn-category">
                                    Xem danh mục
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-wrapper">
                <div class="newsletter-background">
                    <div class="newsletter-pattern"></div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="newsletter-content">
                            <h2 class="newsletter-title">Đăng ký nhận tin tức mới nhất</h2>
                            <p class="newsletter-description">
                                Nhận thông báo về những bài viết mới nhất và xu hướng công nghệ hot nhất qua email của bạn.
                            </p>
                            <div class="newsletter-features">
                                <div class="newsletter-feature">
                                    <i class="fas fa-envelope"></i>
                                    <span>Email hàng tuần</span>
                                </div>
                                <div class="newsletter-feature">
                                    <i class="fas fa-lightning"></i>
                                    <span>Nội dung độc quyền</span>
                                </div>
                                <div class="newsletter-feature">
                                    <i class="fas fa-gift"></i>
                                    <span>Ưu đãi đặc biệt</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="newsletter-form">
                            <form class="subscription-form">
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Nhập email của bạn..." required>
                                    <button type="submit" class="btn-subscribe">
                                        <i class="fas fa-paper-plane"></i>
                                        <span>Đăng ký</span>
                                    </button>
                                </div>
                                <small class="form-text">Chúng tôi không spam và bảo mật thông tin của bạn.</small>
                            </form>
                        </div>
                    </div>
                </div>
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
                            <h2 class="cta-title">Có câu hỏi hoặc đề xuất chủ đề?</h2>
                            <p class="cta-description">
                                Chúng tôi luôn hoan nghênh những ý tưởng và câu hỏi từ độc giả. Hãy liên hệ với chúng tôi để chia sẻ suy nghĩ của bạn.
                            </p>
                            <div class="cta-features">
                                <div class="cta-feature">
                                    <i class="fas fa-comments"></i>
                                    <span>Phản hồi nhanh</span>
                                </div>
                                <div class="cta-feature">
                                    <i class="fas fa-lightbulb"></i>
                                    <span>Ý tưởng mới</span>
                                </div>
                                <div class="cta-feature">
                                    <i class="fas fa-users"></i>
                                    <span>Cộng đồng</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="cta-actions">
                            <a href="<?php echo home_url('/lien-he'); ?>" class="btn-cta-primary">
                                <i class="fas fa-envelope"></i>
                                <span>Gửi ý kiến</span>
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
/* Modern News Page Styles */
.news-page {
    background-color: #fff;
}

/* News Hero Section */
.news-hero-section {
    background: #424242;
    background: radial-gradient(circle,rgba(66, 66, 66, 1) 0%, rgba(0, 0, 0, 1) 100%);
    color: #fff;
    padding: 100px 0 80px;
    position: relative;
    overflow: hidden;
}

.news-hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.news-hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
}

.tech-grid-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
    background-size: 50px 50px;
}

@keyframes gridMove {
    0% { transform: translate(0, 0); }
    100% { transform: translate(50px, 50px); }
}

.news-hero-content {
    position: relative;
    z-index: 10;
}

.news-hero-title {
    margin-bottom: 2rem;
}

.news-title-main {
    display: block;
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    background: linear-gradient(45deg, #fff, #ccc);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.news-title-sub {
    display: block;
    font-size: 1.2rem;
    font-weight: 400;
    color: #ccc;
    letter-spacing: 3px;
    text-transform: uppercase;
}

.news-description-wrapper {
    margin: 0 auto 3rem;
}

.news-hero-description {
    font-size: 1.2rem;
    color: #ccc;
    line-height: 1.8;
}

.news-stats {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 2rem;
    margin-top: 3rem;
}

.news-stats .stat-item {
    text-align: center;
}

.news-stats .stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 0.5rem;
}

.news-stats .stat-label {
    font-size: 0.9rem;
    color: #999;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.news-stats .stat-divider {
    width: 1px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
}

/* Latest News Grid Section */
.latest-news-grid-section {
    padding: 80px 0;
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

.news-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 4rem;
    justify-content: center;
    align-content: start;
}

.news-post-card-wrapper {
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

.modern-news-card {
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    position: relative;
    width: 100%;
    height: 100%;
}

.modern-news-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.news-image-container {
    position: relative;
    overflow: hidden;
    height: 250px;
}

.news-image {
    overflow: hidden;
    position: relative;
    height: 100%;
}

.news-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.placeholder-image {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: #999;
}

.modern-news-card:hover .news-image img {
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

.modern-news-card:hover .image-overlay {
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

.news-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    z-index: 5;
}

.news-badge span {
    background: #000;
    color: #fff;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.news-badge.recent span {
    background: linear-gradient(45deg, #28a745, #20c997);
}

.news-badge.popular span {
    background: linear-gradient(45deg, #dc3545, #fd7e14);
}

.news-tech-indicator {
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

.news-content {
    padding: 1.5rem;
}

.news-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
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

.news-category-tag {
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

.news-title {
    margin-bottom: 1rem;
}

.news-title a {
    color: #000;
    font-size: 1.2rem;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.3s ease;
    line-height: 1.4;
}

.news-title a:hover {
    color: #666;
}

.news-description {
    margin-bottom: 1.5rem;
}

.news-description p {
    color: #666;
    line-height: 1.6;
    margin: 0;
}

.news-tags {
    margin-bottom: 1.5rem;
}

.tags-list {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #666;
    font-size: 0.85rem;
}

.tags-list a {
    color: #666;
    text-decoration: none;
    transition: color 0.3s ease;
}

.tags-list a:hover {
    color: #000;
}

.news-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.btn-news-detail {
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

.btn-news-detail:hover {
    background: #333;
    color: #fff;
    transform: translateX(5px);
}

/* Categories Section */
.categories-section {
    padding: 80px 0;
    background-color: #fff;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.category-item {
    animation: fadeInUp 0.6s ease forwards;
}

.category-card {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    height: 100%;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    border-color: #000;
}

.category-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #000, #333);
    color: #fff;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin: 0 auto 1.5rem;
}

.category-content h4 {
    color: #000;
    margin-bottom: 0.5rem;
    font-size: 1.2rem;
}

.category-content p {
    color: #666;
    margin-bottom: 0.5rem;
}

.category-desc {
    color: #999;
    font-size: 0.85rem;
    margin-bottom: 1.5rem;
    display: block;
}

.btn-category {
    display: inline-flex;
    align-items: center;
    padding: 0.6rem 1.2rem;
    background: transparent;
    color: #000;
    text-decoration: none;
    border: 1px solid #000;
    border-radius: 20px;
    font-weight: 500;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.btn-category:hover {
    background: #000;
    color: #fff;
}

/* Newsletter Section */
.newsletter-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    color: #fff;
    position: relative;
    overflow: hidden;
}

.newsletter-wrapper {
    position: relative;
    z-index: 10;
}

.newsletter-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.newsletter-pattern {
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

.newsletter-content {
    position: relative;
    z-index: 10;
}

.newsletter-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #fff;
}

.newsletter-description {
    font-size: 1.1rem;
    color: #ccc;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.newsletter-features {
    display: flex;
    gap: 2rem;
    margin-bottom: 0;
}

.newsletter-feature {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #ccc;
    font-size: 0.9rem;
}

.newsletter-feature i {
    color: #fff;
    font-size: 1.1rem;
}

.newsletter-form {
    position: relative;
    z-index: 10;
}

.subscription-form .form-group {
    position: relative;
    margin-bottom: 1rem;
}

.subscription-form .form-control {
    width: 100%;
    padding: 1rem 1.5rem;
    border: none;
    border-radius: 30px;
    font-size: 1rem;
    background: rgba(255, 255, 255, 0.9);
    color: #000;
    margin-bottom: 1rem;
}

.subscription-form .form-control:focus {
    outline: none;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
}

.btn-subscribe {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.8rem;
    padding: 1rem 2rem;
    background: #fff;
    color: #000;
    border: none;
    border-radius: 30px;
    font-weight: 600;
    transition: all 0.4s ease;
    font-size: 1rem;
    cursor: pointer;
}

.btn-subscribe:hover {
    background: #f0f0f0;
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
}

.form-text {
    color: #ccc;
    font-size: 0.8rem;
    text-align: center;
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

/* No News */
.no-news-wrapper {
    grid-column: 1 / -1;
    display: flex;
    justify-content: center;
    padding: 4rem 0;
}

.no-news-content {
    text-align: center;
    max-width: 400px;
}

.no-news-icon {
    font-size: 4rem;
    color: #ccc;
    margin-bottom: 1.5rem;
}

.no-news-content h3 {
    color: #000;
    margin-bottom: 1rem;
}

.no-news-content p {
    color: #666;
    margin-bottom: 2rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .news-title-main {
        font-size: 2.5rem;
    }
    
    .news-title-sub {
        font-size: 1rem;
        letter-spacing: 2px;
    }
    
    .news-stats {
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
    
    .news-posts-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    
    .news-meta {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .newsletter-features,
    .cta-features {
        flex-direction: column;
        gap: 1rem;
    }
    
    .newsletter-title,
    .cta-title {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .news-hero-section {
        padding: 60px 0 50px;
    }
    
    .news-title-main {
        font-size: 2rem;
    }
    
    .title-text {
        font-size: 2rem;
    }
    
    .news-posts-grid {
        grid-template-columns: 1fr;
    }
    
    .categories-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Share functionality
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
    const newsCards = document.querySelectorAll('.news-post-card-wrapper');
    
    filterItems.forEach(filter => {
        filter.addEventListener('click', function() {
            // Remove active class from all filters
            filterItems.forEach(f => f.classList.remove('active'));
            // Add active class to clicked filter
            this.classList.add('active');
            
            const filterValue = this.getAttribute('data-filter');
            
            newsCards.forEach(card => {
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
    
    // Newsletter subscription
    const subscriptionForm = document.querySelector('.subscription-form');
    if (subscriptionForm) {
        subscriptionForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            if (email) {
                alert('Cảm ơn bạn đã đăng ký! Chúng tôi sẽ gửi tin tức mới nhất đến email của bạn.');
                this.reset();
            }
        });
    }
});

// Reading time estimation
function estimated_reading_time(content) {
    const word_count = content.split(' ').length;
    const reading_time = Math.ceil(word_count / 200);
    return Math.max(1, reading_time);
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