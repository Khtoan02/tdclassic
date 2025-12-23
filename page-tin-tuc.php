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
                        <div class="hero-categories-section">
                            <div class="hero-categories-container">
                                <div class="hero-categories-scroll-wrapper" id="categoriesScroll">
                                    <div class="hero-categories-scroll-content">
                                        <?php
                                        $categories = get_categories(array(
                                            'orderby' => 'count',
                                            'order' => 'DESC',
                                            'number' => 12
                                        ));
                                        
                                        foreach ($categories as $category) :
                                        ?>
                                            <a href="<?php echo get_category_link($category->term_id); ?>" class="hero-category-btn">
                                                <span class="hero-category-name"><?php echo $category->name; ?></span>
                                                <span class="hero-category-count"><?php echo $category->count; ?> bài</span>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                
                                <button class="hero-scroll-btn hero-scroll-left" id="scrollLeft">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                
                                <button class="hero-scroll-btn hero-scroll-right" id="scrollRight">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
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
                // LẤY BÀI VIẾT CẢ TỪ WEBSITE (LOCAL) VÀ TavaLED
                $paged          = (get_query_var('paged')) ? (int) get_query_var('paged') : 1;
                $posts_per_page = 4; // Số bài local + số bài remote mỗi trang (6 + 6 = 12 bài)

                // 1. Bài viết local (TD Classic)
                $local_query = new WP_Query(
                    array(
                        'post_type'      => 'post',
                        'posts_per_page' => $posts_per_page,
                        'paged'          => $paged,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    )
                );

                $combined_posts = array();
                $total_pages_local = $local_query->max_num_pages;

                if ($local_query->have_posts()) {
                    while ($local_query->have_posts()) {
                        $local_query->the_post();

                        $post_id        = get_the_ID();
                        $post_title     = get_the_title();
                        $post_link      = get_permalink();
                        $post_image     = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'large');
                        $post_image_url = $post_image ? $post_image[0] : '';
                        $post_excerpt   = wp_trim_words(get_the_excerpt(), 25);
                        $post_date      = get_the_date('d/m/Y');
                        $post_raw_date  = get_the_date('c');
                        $post_author    = get_the_author();

                        $categories     = get_the_category();
                        $main_category  = $categories ? $categories[0]->name : 'Tin tức';
                        $reading_time   = estimated_reading_time(get_the_content());

                        // Badge cho bài local
                        $badge       = '';
                        $badge_class = '';
                        if (strtotime(get_the_date()) > strtotime('-7 days')) {
                            $badge       = 'MỚI';
                            $badge_class = 'recent';
                        } elseif (get_post_meta($post_id, 'popular_post', true)) {
                            $badge       = 'HOT';
                            $badge_class = 'popular';
                        }

                        $combined_posts[] = array(
                            'origin'        => 'local',
                            'title'         => $post_title,
                            'link'          => $post_link,
                            'image'         => $post_image_url,
                            'date'          => $post_date,
                            'raw_date'      => $post_raw_date,
                            'excerpt'       => $post_excerpt,
                            'meta_description' => $post_excerpt,
                            'author'        => $post_author,
                            'main_category' => $main_category,
                            'reading_time'  => $reading_time,
                            'badge'         => $badge,
                            'badge_class'   => $badge_class,
                        );
                    }
                    wp_reset_postdata();
                }

                // 2. Bài viết remote từ TavaLED
                $total_pages_remote = 1;
                $remote_posts       = get_posts_from_main_site($posts_per_page, $paged, $total_pages_remote);

                if (!empty($remote_posts)) {
                    foreach ($remote_posts as $remote_post) {
                        $combined_posts[] = array(
                            'origin'        => 'remote',
                            'title'         => isset($remote_post['title']) ? $remote_post['title'] : '',
                            'link'          => isset($remote_post['link']) ? $remote_post['link'] : '#',
                            'image'         => isset($remote_post['image']) ? $remote_post['image'] : '',
                            'date'          => isset($remote_post['date']) ? $remote_post['date'] : '',
                            'raw_date'      => isset($remote_post['raw_date']) ? $remote_post['raw_date'] : '',
                            'excerpt'       => isset($remote_post['excerpt']) ? $remote_post['excerpt'] : '',
                            'meta_description' => !empty($remote_post['meta_description']) ? $remote_post['meta_description'] : (isset($remote_post['excerpt']) ? $remote_post['excerpt'] : ''),
                            'author'        => !empty($remote_post['author']) ? $remote_post['author'] : 'TavaLED',
                            'main_category' => !empty($remote_post['main_category']) ? $remote_post['main_category'] : 'Tin tức',
                            'reading_time'  => isset($remote_post['reading_time']) ? (int) $remote_post['reading_time'] : 1,
                            // Badge remote: mặc định mới trong 7 ngày là "MỚI", còn lại là "HOT"
                            'badge'         => (isset($remote_post['raw_date']) && strtotime($remote_post['raw_date']) > strtotime('-7 days')) ? 'MỚI' : 'HOT',
                            'badge_class'   => (isset($remote_post['raw_date']) && strtotime($remote_post['raw_date']) > strtotime('-7 days')) ? 'recent' : 'popular',
                        );
                    }
                }

                // 3. Nếu không có bài nào
                if (empty($combined_posts)) :
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
                <?php
                else :
                    // 4. Sắp xếp tất cả bài theo ngày đăng mới nhất (dựa trên raw_date)
                    usort(
                        $combined_posts,
                        function ($a, $b) {
                            $time_a = !empty($a['raw_date']) ? strtotime($a['raw_date']) : 0;
                            $time_b = !empty($b['raw_date']) ? strtotime($b['raw_date']) : 0;
                            return $time_b <=> $time_a;
                        }
                    );

                    $post_count = 0;
                    foreach ($combined_posts as $post_item) :
                        $post_count++;

                        $origin        = $post_item['origin']; // local | remote
                        $post_title    = $post_item['title'];
                        $post_link     = $post_item['link'];
                        $post_image_url= $post_item['image'];
                        $post_date     = $post_item['date'];
                        $post_excerpt  = $post_item['excerpt'];
                        $meta_description = !empty($post_item['meta_description']) ? $post_item['meta_description'] : $post_excerpt;
                        $post_author   = $post_item['author'];
                        $main_category = $post_item['main_category'];
                        $reading_time  = (int) $post_item['reading_time'];
                        $badge         = $post_item['badge'];
                        $badge_class   = $post_item['badge_class'];

                        // Animation delay
                        $delay = ($post_count % 4) * 0.1;
                ?>
                    <div class="news-post-card-wrapper" data-category="<?php echo esc_attr($badge_class ? $badge_class : 'all'); ?>" style="animation-delay: <?php echo esc_attr($delay); ?>s;">
                        <div class="modern-news-card">
                            <div class="news-image-container">
                                <div class="news-image">
                                    <?php if (!empty($post_image_url)) : ?>
                                        <picture>
                                            <img src="<?php echo esc_url($post_image_url); ?>" 
                                                 alt="<?php echo esc_attr(wp_strip_all_tags($post_title)); ?>" 
                                                 loading="lazy"
                                                 decoding="async"
                                                 width="400"
                                                 height="250">
                                        </picture>
                                    <?php else : ?>
                                        <div class="placeholder-image">
                                            <i class="fas fa-newspaper"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="image-overlay">
                                        <div class="overlay-content">
                                            <?php if ($origin === 'remote') : ?>
                                                <!-- Bài TavaLED: hiện popup trước -->
                                                <button class="btn-overlay-primary" type="button" data-news-preview data-title="<?php echo esc_attr(wp_strip_all_tags($post_title)); ?>" data-image="<?php echo esc_url($post_image_url); ?>" data-description="<?php echo esc_attr(wp_strip_all_tags($meta_description)); ?>" data-url="<?php echo esc_url($post_link); ?>">
                                                    <i class="fas fa-eye"></i>
                                                    <span>Xem nhanh</span>
                                                </button>
                                            <?php else : ?>
                                                <!-- Bài local: trỏ thẳng ra single -->
                                                <a href="<?php echo esc_url($post_link); ?>" class="btn-overlay-primary">
                                                    <i class="fas fa-eye"></i>
                                                    <span>Đọc bài viết</span>
                                                </a>
                                            <?php endif; ?>
                                            <button class="btn-overlay-secondary btn-share" data-share-title="<?php echo esc_attr(wp_strip_all_tags($post_title)); ?>" data-share-url="<?php echo esc_url($post_link); ?>">
                                                <i class="fas fa-share-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($badge) : ?>
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
                                        <span><?php echo esc_html($post_date); ?></span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-user"></i>
                                        <span><?php echo esc_html($post_author); ?></span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-clock"></i>
                                        <span><?php echo (int) $reading_time; ?> phút đọc</span>
                                    </div>
                                </div>
                                <div class="news-category-tag">
                                    <i class="fas fa-tag"></i>
                                    <span><?php echo esc_html($main_category); ?></span>
                                </div>
                                <h3 class="news-title">
                                    <?php if ($origin === 'remote') : ?>
                                        <a href="javascript:void(0)" class="news-preview-link" data-news-preview data-title="<?php echo esc_attr(wp_strip_all_tags($post_title)); ?>" data-image="<?php echo esc_url($post_image_url); ?>" data-description="<?php echo esc_attr(wp_strip_all_tags($meta_description)); ?>" data-url="<?php echo esc_url($post_link); ?>">
                                            <?php echo esc_html(wp_strip_all_tags($post_title)); ?>
                                        </a>
                                    <?php else : ?>
                                        <a href="<?php echo esc_url($post_link); ?>">
                                            <?php echo esc_html(wp_strip_all_tags($post_title)); ?>
                                        </a>
                                    <?php endif; ?>
                                </h3>
                                <div class="news-description">
                                    <p><?php echo esc_html($post_excerpt); ?></p>
                                </div>
                                <div class="news-actions">
                                    <?php if ($origin === 'remote') : ?>
                                        <button class="btn-news-detail" type="button" data-news-preview data-title="<?php echo esc_attr(wp_strip_all_tags($post_title)); ?>" data-image="<?php echo esc_url($post_image_url); ?>" data-description="<?php echo esc_attr(wp_strip_all_tags($meta_description)); ?>" data-url="<?php echo esc_url($post_link); ?>">
                                            <span>Xem chi tiết</span>
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    <?php else : ?>
                                        <a href="<?php echo esc_url($post_link); ?>" class="btn-news-detail">
                                            <span>Đọc thêm</span>
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    endforeach;

                    // 5. Pagination: lấy max giữa local & remote
                    $total_pages = max((int) $total_pages_local, (int) $total_pages_remote);
                    if ($total_pages > 1) :
                ?>
                    <div class="pagination-wrapper col-12">
                        <div class="modern-pagination">
                            <?php
                            $big = 999999999;
                            // Trên mobile, rút gọn số trang hiển thị để tránh tràn ngang
                            $is_mobile = wp_is_mobile();
                            echo paginate_links(
                                array(
                                    'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                    'format'    => '?paged=%#%',
                                    'current'   => max(1, $paged),
                                    'total'     => $total_pages,
                                    'prev_text' => '<i class="fas fa-chevron-left"></i><span>Trước</span>',
                                    'next_text' => '<span>Sau</span><i class="fas fa-chevron-right"></i>',
                                    'type'      => 'list',
                                    // Desktop: hiển thị nhiều số trang hơn, Mobile: chỉ giữ current ±1
                                    'end_size'  => $is_mobile ? 1 : 2,
                                    'mid_size'  => $is_mobile ? 0 : 2,
                                )
                            );
                            ?>
                        </div>
                    </div>
                <?php
                    endif;
                endif;
                ?>
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
    <!-- Modal xem nhanh bài viết TavaLED -->
    <div id="newsPreviewModal" class="news-preview-modal" aria-hidden="true">
        <div class="news-preview-backdrop" onclick="closeNewsPreview()"></div>
        <div class="news-preview-dialog" role="dialog" aria-modal="true" aria-labelledby="newsPreviewTitle">
            <button type="button" class="news-preview-close" onclick="closeNewsPreview()">
                <i class="fas fa-times"></i>
            </button>
            <div class="news-preview-content">
                <div class="news-preview-header">
                    <span class="news-preview-badge">TavaLED</span>
                    <h3 id="newsPreviewTitle" class="news-preview-title"></h3>
                </div>
                <div class="news-preview-body">
                    <div class="news-preview-image">
                        <img src="" alt="" class="news-preview-image-tag">
                    </div>
                    <p class="news-preview-description"></p>
                </div>
                <div class="news-preview-footer">
                    <a href="#" target="_blank" rel="noopener" class="btn-news-preview-detail">
                        <span>Xem bài đầy đủ</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
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
    border-top: 1px solid rgba(0, 0, 0, 0.05);
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
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    margin-bottom: 4rem;
    justify-content: center;
    align-content: start;
}

@media (max-width: 1200px) {
    .news-posts-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
}

@media (max-width: 768px) {
    .news-posts-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
}

.news-post-card-wrapper {
    animation: fadeInUp 0.6s ease forwards;
    opacity: 0;
    transform: translateY(30px);
    width: 100%;
    display: flex;
    flex-direction: column;
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
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    width: 100%;
    height: 100%;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.modern-news-card:hover {
    transform: translateY(-12px) scale(1.02);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    border-color: rgba(0, 0, 0, 0.1);
}

.modern-news-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(0, 0, 0, 0.05));
    opacity: 0;
    transition: opacity 0.5s ease;
    z-index: 1;
    pointer-events: none;
}

.modern-news-card:hover::before {
    opacity: 1;
}

.news-image-container {
    position: relative;
    overflow: hidden;
    height: 280px;
    border-radius: 15px 15px 0 0;
}

.news-image {
    overflow: hidden;
    position: relative;
    height: 100%;
    width: 100%;
}

.news-image picture,
.news-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
}

.news-image img {
    filter: brightness(1) contrast(1.05) saturate(1.1);
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
    transform: scale(1.08);
    filter: brightness(1.05) contrast(1.1) saturate(1.15);
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
    padding: 1.8rem;
    position: relative;
    z-index: 2;
    flex: 1;
    display: flex;
    flex-direction: column;
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

/* Hero Categories Section */
.hero-categories-section {
    margin-top: 3rem;
    position: relative;
    z-index: 10;
}

.hero-categories-container {
    position: relative;
    display: flex;
    align-items: center;
    gap: 1rem;
    max-width: 1000px;
    margin: 0 auto;
}

.hero-scroll-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
    backdrop-filter: blur(10px);
    color: #fff;
}

.hero-scroll-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.4);
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 5px 20px rgba(255, 255, 255, 0.1);
}

.hero-scroll-left {
    left: -25px;
}

.hero-scroll-right {
    right: -25px;
}

.hero-categories-scroll-wrapper {
    flex: 1;
    overflow: hidden;
    margin: 0 2rem;
}

.hero-categories-scroll-content {
    display: flex;
    gap: 1rem;
    transition: transform 0.3s ease;
    padding: 0.5rem 0;
    width: max-content;
}

.hero-category-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.3rem;
    padding: 1rem 1.5rem;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    text-decoration: none;
    transition: all 0.3s ease;
    min-width: 120px;
    flex-shrink: 0;
    white-space: nowrap;
    backdrop-filter: blur(10px);
}

.hero-category-btn:hover {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.3);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(255, 255, 255, 0.1);
}

.hero-category-name {
    font-weight: 600;
    font-size: 0.9rem;
    color: #fff;
    transition: color 0.3s ease;
}

.hero-category-count {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.7);
    transition: color 0.3s ease;
}

.hero-category-btn:hover .hero-category-name {
    color: #fff;
}

.hero-category-btn:hover .hero-category-count {
    color: rgba(255, 255, 255, 0.9);
}

/* Desktop: Show 6 categories per row */
@media (min-width: 1200px) {
    .hero-category-btn {
        min-width: calc((100vw - 200px)- 20px);
        max-width: calc((100vw - 200px) / 6 - 20px);
    }
}

/* Tablet: Show 4 categories per row */
@media (min-width: 768px) and (max-width: 1199px) {
    .hero-category-btn {
        min-width: calc((100vw - 150px) / 4 - 15px);
        max-width: calc((100vw - 150px) / 4 - 15px);
    }
}

/* Mobile: Show 2 categories per row */
@media (max-width: 767px) {
    .hero-category-btn {
        min-width: calc((100vw - 100px) / 2 - 10px);
        max-width: calc((100vw - 100px) / 2 - 10px);
    }
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
    /* Khi nằm trong grid, cho pagination chiếm full width để không phá layout thẻ bài */
    grid-column: 1 / -1;
}

.modern-pagination {
    width: 100%;
    display: flex;
    justify-content: center;
}

.modern-pagination ul {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    list-style: none;
    padding: 0.4rem 0.6rem;
    margin: 0;
    background: #fff;
    border-radius: 999px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
}

.modern-pagination li {
    margin: 0;
}

.modern-pagination a,
.modern-pagination span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 38px;
    height: 38px;
    padding: 0 0.9rem;
    background: transparent;
    color: #666;
    text-decoration: none;
    border-radius: 999px;
    border: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: background 0.25s ease, color 0.25s ease, transform 0.2s ease;
}

.modern-pagination a:hover {
    background: rgba(0, 0, 0, 0.06);
    color: #000;
    transform: translateY(-1px);
}

/* Trang hiện tại */
.modern-pagination .current {
    background: #000;
    color: #fff;
    cursor: default;
    pointer-events: none;
    transform: translateY(-1px);
}

/* Nút Prev/Next nổi bật hơn một chút */
.modern-pagination .prev a,
.modern-pagination .next a {
    padding-inline: 1.1rem;
    font-size: 0.85rem;
}

/* Dấu ... (dots) */
.modern-pagination .dots {
    opacity: 0.7;
}

/* UX tốt hơn trên mobile: cho phép scroll ngang cụm pagination nếu quá nhiều trang */
@media (max-width: 768px) {
    .pagination-wrapper {
        justify-content: flex-start;
    }

    .modern-pagination {
        justify-content: flex-start;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .modern-pagination ul {
        justify-content: flex-start;
        white-space: nowrap;
        padding-inline: 0.5rem;
    }
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

/* Modal xem nhanh bài viết TavaLED */
.news-preview-modal {
    position: fixed;
    inset: 0;
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.news-preview-modal.is-active {
    display: flex;
}

.news-preview-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
}

.news-preview-dialog {
    position: relative;
    z-index: 2;
    max-width: 600px;
    width: 90%;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
    padding: 1.8rem 2rem 1.8rem;
    animation: fadeInUp 0.35s ease;
}

.news-preview-close {
    position: absolute;
    top: 14px;
    right: 16px;
    border: none;
    background: transparent;
    color: #999;
    font-size: 1.1rem;
    cursor: pointer;
    transition: color 0.2s ease, transform 0.2s ease;
}

.news-preview-close:hover {
    color: #000;
    transform: scale(1.05);
}

.news-preview-content {
    position: relative;
}

.news-preview-header {
    margin-bottom: 1rem;
}

.news-preview-badge {
    display: inline-block;
    padding: 0.2rem 0.75rem;
    border-radius: 999px;
    background: #000;
    color: #fff;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    margin-bottom: 0.5rem;
}

.news-preview-title {
    font-size: 1.4rem;
    font-weight: 700;
    margin: 0;
    color: #000;
}

.news-preview-body {
    margin: 1rem 0 1.5rem;
}

.news-preview-image {
    margin-bottom: 1rem;
    border-radius: 12px;
    overflow: hidden;
    max-height: 260px;
}

.news-preview-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.news-preview-description {
    margin: 0;
    color: #555;
    line-height: 1.7;
}

.news-preview-footer {
    display: flex;
    justify-content: flex-end;
}

.btn-news-preview-detail {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.7rem 1.4rem;
    border-radius: 999px;
    background: #000;
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.25s ease, transform 0.25s ease, box-shadow 0.25s ease;
}

.btn-news-preview-detail:hover {
    background: #333;
    color: #fff;
    transform: translateX(3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
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
    
    /* Mobile & tablet: 1 cột cho thẻ bài để tránh vỡ layout */
    .news-posts-grid {
        grid-template-columns: 1fr;
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
    
    .hero-categories-section {
        margin-top: 2rem;
    }
    
    .hero-categories-container {
        margin: 0 1rem;
    }
    
    .hero-scroll-btn {
        width: 35px;
        height: 35px;
        font-size: 0.8rem;
    }
    
    .hero-scroll-left {
        left: -15px;
    }
    
    .hero-scroll-right {
        right: -15px;
    }
    
    .hero-categories-scroll-wrapper {
        margin: 0 1.5rem;
    }
    
    .hero-category-btn {
        min-width: 100px;
        padding: 0.8rem 1rem;
    }
    
    .hero-category-name {
        font-size: 0.85rem;
    }
    
    .hero-category-count {
        font-size: 0.75rem;
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

// Enhanced filter functionality with smooth animations
document.addEventListener('DOMContentLoaded', function() {
    const filterItems = document.querySelectorAll('.filter-item');
    const newsCards = document.querySelectorAll('.news-post-card-wrapper');
    
    // Intersection Observer for lazy loading animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
            }
        });
    }, observerOptions);
    
    // Observe all news cards
    newsCards.forEach(card => {
        card.style.animationPlayState = 'paused';
        observer.observe(card);
    });
    
    filterItems.forEach(filter => {
        filter.addEventListener('click', function() {
            // Remove active class from all filters
            filterItems.forEach(f => f.classList.remove('active'));
            // Add active class to clicked filter
            this.classList.add('active');
            
            const filterValue = this.getAttribute('data-filter');
            
            newsCards.forEach((card, index) => {
                if (filterValue === 'all' || card.getAttribute('data-category') === filterValue) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 50);
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
    
    // Categories scroll functionality
    const scrollLeftBtn = document.getElementById('scrollLeft');
    const scrollRightBtn = document.getElementById('scrollRight');
    const categoriesScroll = document.getElementById('categoriesScroll');
    const categoriesContent = categoriesScroll.querySelector('.hero-categories-scroll-content');
    
    if (scrollLeftBtn && scrollRightBtn && categoriesScroll) {
        let scrollPosition = 0;
        const scrollAmount = 200;
        const maxScroll = categoriesContent.scrollWidth - categoriesScroll.clientWidth;
        
        // Update button visibility
        function updateButtons() {
            scrollLeftBtn.style.opacity = scrollPosition > 0 ? '1' : '0.5';
            scrollRightBtn.style.opacity = scrollPosition < maxScroll ? '1' : '0.5';
        }
        
        // Scroll left
        scrollLeftBtn.addEventListener('click', () => {
            scrollPosition = Math.max(0, scrollPosition - scrollAmount);
            categoriesContent.style.transform = `translateX(-${scrollPosition}px)`;
            updateButtons();
        });
        
        // Scroll right
        scrollRightBtn.addEventListener('click', () => {
            scrollPosition = Math.min(maxScroll, scrollPosition + scrollAmount);
            categoriesContent.style.transform = `translateX(-${scrollPosition}px)`;
            updateButtons();
        });
        
        // Touch/swipe support for mobile
        let startX = 0;
        let isScrolling = false;
        
        categoriesScroll.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isScrolling = true;
        });
        
        categoriesScroll.addEventListener('touchmove', (e) => {
            if (!isScrolling) return;
            e.preventDefault();
            const currentX = e.touches[0].clientX;
            const diffX = startX - currentX;
            const newPosition = Math.max(0, Math.min(maxScroll, scrollPosition + diffX));
            
            categoriesContent.style.transform = `translateX(-${newPosition}px)`;
            scrollPosition = newPosition;
            updateButtons();
        });
        
        categoriesScroll.addEventListener('touchend', () => {
            isScrolling = false;
        });
        
        // Initialize
        updateButtons();
        
        // Hide scroll buttons on mobile if not needed
        if (window.innerWidth <= 768) {
            const checkScroll = () => {
                if (maxScroll <= 0) {
                    scrollLeftBtn.style.display = 'none';
                    scrollRightBtn.style.display = 'none';
                } else {
                    scrollLeftBtn.style.display = 'flex';
                    scrollRightBtn.style.display = 'flex';
                }
            };
            checkScroll();
            window.addEventListener('resize', checkScroll);
        }
    }
    
    // Modal xem nhanh bài viết TavaLED
    window.openNewsPreview = function(title, image, description, url) {
        const modal = document.getElementById('newsPreviewModal');
        if (!modal) return;

        const titleEl   = modal.querySelector('.news-preview-title');
        const imageEl   = modal.querySelector('.news-preview-image-tag');
        const descEl    = modal.querySelector('.news-preview-description');
        const linkEl    = modal.querySelector('.btn-news-preview-detail');

        if (titleEl)   titleEl.textContent   = title || '';
        if (imageEl) {
            if (image) {
                imageEl.src = image;
                imageEl.alt = title || '';
                imageEl.style.display = 'block';
            } else {
                imageEl.src = '';
                imageEl.alt = '';
                imageEl.style.display = 'none';
            }
        }
        if (descEl)    descEl.textContent    = description || '';
        if (linkEl)    linkEl.setAttribute('href', url || '#');

        modal.classList.add('is-active');
        document.body.style.overflow = 'hidden';
    };

    window.closeNewsPreview = function() {
        const modal = document.getElementById('newsPreviewModal');
        if (!modal) return;
        modal.classList.remove('is-active');
        document.body.style.overflow = '';
    };
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