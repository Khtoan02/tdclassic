<?php
/**
 * The template for displaying all single posts
 */

get_header(); 

// Increment view count
if (have_posts()) {
    while (have_posts()) {
        the_post();
        $post_id = get_the_ID();
        $views_count = get_post_meta($post_id, 'post_views_count', true);
        $views_count = $views_count ? $views_count : 0;
        update_post_meta($post_id, 'post_views_count', $views_count + 1);
    }
    rewind_posts();
}
?>

<main id="main" class="site-main single-post-page">
    <!-- Hero Section with Post Title -->
    <section class="post-hero-section">
        <div class="post-hero-background">
            <?php if (has_post_thumbnail()) : ?>
                <div class="post-hero-image" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>');"></div>
            <?php endif; ?>
            <div class="post-hero-overlay"></div>
            <div class="tech-grid-pattern"></div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="post-hero-content text-center">
                        <div class="post-categories">
                            <?php
                            $categories = get_the_category();
                            if ($categories) {
                                foreach ($categories as $category) {
                                    echo '<a href="' . get_category_link($category->term_id) . '" class="category-badge">' . $category->name . '</a>';
                                }
                            }
                            ?>
                        </div>
                        <h1 class="post-hero-title"><?php the_title(); ?></h1>
                        <div class="post-meta-info">
                            <div class="meta-item">
                                <i class="fas fa-user"></i>
                                <span><?php the_author(); ?></span>
                            </div>
                            <div class="meta-divider">•</div>
                            <div class="meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span><?php echo get_the_date('d/m/Y'); ?></span>
                            </div>
                            <div class="meta-divider">•</div>
                            <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                <span><?php echo estimated_reading_time(get_the_content()); ?> phút đọc</span>
                            </div>
                            <div class="meta-divider">•</div>
                            <div class="meta-item">
                                <i class="fas fa-eye"></i>
                                <span><?php echo get_post_meta(get_the_ID(), 'post_views_count', true) ?: 0; ?> lượt xem</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Section with 3-Column Layout -->
    <section class="post-content-section">
        <div class="row">
            <!-- Left Sidebar: Fixed (Outside Container) -->
            <div class="col-lg-3">
                <aside class="left-sidebar fixed-sidebar">
                    <!-- Menu: Article Content -->
                    <div class="sidebar-widget toc-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-list-ul"></i>
                            NỘI DUNG BÀI VIẾT
                        </h3>
                        <div class="toc-content" id="toc-content">
                            <!-- Auto-generated TOC will be inserted here -->
                        </div>
                    </div>

                    <!-- Author Information -->
                    <div class="sidebar-widget author-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-user"></i>
                            TÁC GIẢ
                        </h3>
                        <div class="author-info-compact">
                            <div class="author-avatar">
                                <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                            </div>
                            <h4 class="author-name"><?php the_author(); ?></h4>
                            <p class="author-description"><?php the_author_meta('description'); ?></p>
                        </div>
                    </div>

                    <!-- Share Article -->
                    <div class="sidebar-widget share-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-share-alt"></i>
                            CHIA SẺ BÀI VIẾT
                        </h3>
                        <div class="share-buttons-compact">
                            <button class="share-btn facebook" onclick="shareOnFacebook()">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button class="share-btn twitter" onclick="shareOnTwitter()">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button class="share-btn linkedin" onclick="shareOnLinkedIn()">
                                <i class="fab fa-linkedin-in"></i>
                            </button>
                            <button class="share-btn copy" onclick="copyLink()">
                                <i class="fas fa-link"></i>
                            </button>
                        </div>
                    </div>
                </aside>
            </div>

            <!-- Main Content: Inside Container -->
            <div class="col-lg-6">
                <div class="main-content-wrapper">
                    <div class="container">
                        <article class="post-content-wrapper">
                            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                
                                <!-- Post Excerpt -->
                                <?php if (has_excerpt()) : ?>
                                    <div class="post-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Post Content -->
                                <div class="post-content">
                                    <?php the_content(); ?>
                                </div>

                                <!-- Post Tags -->
                                <?php
                                $tags = get_the_tags();
                                if ($tags) :
                                ?>
                                    <div class="post-tags">
                                        <i class="fas fa-tags"></i>
                                        <?php
                                        foreach ($tags as $tag) {
                                            echo '<a href="' . get_tag_link($tag->term_id) . '" class="tag-item">#' . $tag->name . '</a>';
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Author Box -->
                                <div class="author-box">
                                    <div class="author-avatar">
                                        <?php echo get_avatar(get_the_author_meta('ID'), 100); ?>
                                    </div>
                                    <div class="author-info">
                                        <h4>Về tác giả</h4>
                                        <h5><?php the_author(); ?></h5>
                                        <p><?php the_author_meta('description'); ?></p>
                                        <div class="author-social">
                                            <?php if (get_the_author_meta('facebook')) : ?>
                                                <a href="<?php the_author_meta('facebook'); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                            <?php endif; ?>
                                            <?php if (get_the_author_meta('twitter')) : ?>
                                                <a href="<?php the_author_meta('twitter'); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                            <?php endwhile; endif; ?>
                        </article>

                        <!-- Related Posts -->
                        <div class="related-posts-section">
                            <h3 class="section-title">
                                <span class="title-text">Bài viết liên quan</span>
                                <span class="title-line"></span>
                            </h3>
                            <div class="related-posts-grid">
                                <?php
                                $related_posts = new WP_Query(array(
                                    'post_type' => 'post',
                                    'posts_per_page' => 3,
                                    'post__not_in' => array($post_id),
                                    'category__in' => wp_get_post_categories($post_id),
                                    'orderby' => 'rand'
                                ));

                                if ($related_posts->have_posts()) :
                                    while ($related_posts->have_posts()) : $related_posts->the_post();
                                ?>
                                    <article class="related-post-card">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="related-post-image">
                                                <a href="<?php the_permalink(); ?>">
                                                    <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>">
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        <div class="related-post-content">
                                            <div class="related-post-meta">
                                                <span class="meta-date">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    <?php echo get_the_date('d/m/Y'); ?>
                                                </span>
                                            </div>
                                            <h4 class="related-post-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h4>
                                        </div>
                                    </article>
                                <?php
                                    endwhile;
                                    wp_reset_postdata();
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar: Fixed (Outside Container) -->
            <div class="col-lg-3">
                <aside class="right-sidebar fixed-sidebar">
                    <!-- Latest Articles Widget -->
                    <div class="sidebar-widget latest-articles-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-newspaper"></i>
                            BÀI VIẾT MỚI NHẤT
                        </h3>
                        <div class="latest-articles-list">
                            <?php
                            $latest_posts = new WP_Query(array(
                                'post_type' => 'post',
                                'posts_per_page' => 3,
                                'post__not_in' => array($post_id),
                                'orderby' => 'date',
                                'order' => 'DESC'
                            ));

                            if ($latest_posts->have_posts()) :
                                while ($latest_posts->have_posts()) : $latest_posts->the_post();
                            ?>
                                <div class="latest-article-item">
                                    <div class="latest-article-info">
                                        <span class="article-date">
                                            <i class="fas fa-clock"></i>
                                            <?php echo get_the_date('d/m/Y'); ?>
                                        </span>
                                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        
                                    </div>
                                </div>
                            <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </div>

                    <!-- Categories Widget -->
                    <div class="sidebar-widget categories-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-folder-open"></i>
                            DANH MỤC
                        </h3>
                        <ul class="categories-list">
                            <?php
                            $categories = get_categories(array(
                                'orderby' => 'count',
                                'order' => 'DESC',
                                'number' => 10
                            ));

                            foreach ($categories as $category) {
                                echo '<li>';
                                echo '<a href="' . get_category_link($category->term_id) . '">';
                                echo '<span class="category-name">' . $category->name . '</span>';
                                echo '<span class="category-count">' . $category->count . '</span>';
                                echo '</a>';
                                echo '</li>';
                            }
                            ?>
                        </ul>
                    </div>

                    <!-- Newsletter Widget -->
                    <div class="sidebar-widget newsletter-widget">
                        <h3 class="widget-title">
                            <i class="fas fa-envelope"></i>
                            ĐĂNG KÝ NHẬN TIN
                        </h3>
                        <p>Nhận thông tin mới nhất về sản phẩm và khuyến mãi</p>
                        <form class="newsletter-form">
                            <input type="email" placeholder="Email của bạn" required>
                            <button type="submit">
                                <i class="fas fa-paper-plane"></i>
                                Đăng ký
                            </button>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="post-cta-section">
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
/* Single Post Page Styles - Optimized UI */
.single-post-page {
    background-color: #fff;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Post Hero Section - Optimized */
.post-hero-section {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #000 100%);
    color: #fff;
    padding: 100px 0 60px;
    position: relative;
    overflow: hidden;
}

.post-hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.post-hero-image {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-size: cover;
    background-position: center;
    opacity: 0.2;
}

.post-hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.tech-grid-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
    background-size: 40px 40px;
}

@keyframes gridMove {
    0% { transform: translate(0, 0); }
    100% { transform: translate(40px, 40px); }
}

.post-hero-content {
    position: relative;
    z-index: 10;
}

.post-categories {
    margin-bottom: 1.5rem;
}

.category-badge {
    display: inline-block;
    background: rgba(255, 255, 255, 0.15);
    color: #fff;
    padding: 0.5rem 1.2rem;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    margin: 0 0.4rem 0.4rem 0;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.category-badge:hover {
    background: #fff;
    color: #000;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.post-hero-title {
    font-size: 3.2rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    line-height: 1.1;
    color: #fff;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
}

.post-meta-info {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 1.2rem;
    font-size: 0.95rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #ccc;
    padding: 0.5rem 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    backdrop-filter: blur(10px);
}

.meta-item i {
    color: #fff;
    font-size: 1rem;
}

.meta-divider {
    display: none;
}

/* Post Content Section - Optimized 3-Column Layout */
.post-content-section {
    padding: 60px 0;
    background-color: #fafafa;
}

/* Main Content Wrapper */

/* Fixed Sidebars - Optimized */
.fixed-sidebar {
    position: sticky;
    top: 20px;
    max-height: calc(100vh - 100px);
    scrollbar-width: thin;
    scrollbar-color: #ccc transparent;
}

.fixed-sidebar::-webkit-scrollbar {
    width: 4px;
}

.fixed-sidebar::-webkit-scrollbar-track {
    background: transparent;
}

.fixed-sidebar::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 2px;
}

.left-sidebar,
.right-sidebar {
    padding: 0 15px;
    max-width: 350px;
    width: 100%;
}

.right-sidebar {
    float: left;
}

.left-sidebar {
    float: right;
}

/* Sidebar Widgets - Modern Design */
.sidebar-widget {
    background: #fff;
    border-radius: 16px;
    padding: 1.4rem;
    margin-bottom: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    border: 1px solid #f0f0f0;
    transition: all 0.3s ease;
}

.sidebar-widget:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
}

.widget-title {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    font-size: 1.2rem;
    font-weight: 700;
    color: #000;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0f0f0;
}

.widget-title i {
    color: #666;
    font-size: 1.1rem;
}

.widget-subtitle {
    font-size: 0.75rem;
    color: #999;
    font-weight: 400;
    margin-left: auto;
    background: #f8f9fa;
    padding: 0.3rem 0.6rem;
    border-radius: 12px;
}

/* Table of Contents Widget - Enhanced */

.toc-content ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.toc-content li {
    margin-bottom: 0.6rem;
}

.toc-content a {
    color: #555;
    text-decoration: none;
    font-size: 0.9rem;
    display: block;
    padding: 0.6rem 0.6rem;
    border-left: 3px solid transparent;
    border-radius: 8px;
    transition: all 0.3s ease;
    background: #fafafa;
}

.toc-content a:hover,
.toc-content a.active {
    color: #000;
    border-left-color: #000;
    background: #f0f0f0;
    transform: translateX(5px);
}

.toc-content ul ul {
    margin-top: 0.4rem;
}

/* Author Widget - Compact & Modern */
.author-info-compact {
    text-align: center;
}

.author-info-compact .author-avatar img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    margin-bottom: 1rem;
    border: 3px solid #f0f0f0;
    transition: all 0.3s ease;
}

.author-info-compact .author-avatar img:hover {
    border-color: #000;
    transform: scale(1.05);
}

.author-name {
    color: #000;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.author-description {
    color: #666;
    font-size: 0.85rem;
    line-height: 1.5;
    margin: 0;
}

/* Share Widget - Grid Layout */
.share-buttons-compact {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.8rem;
}

.share-btn {
    width: 100%;
    height: 42px;
    border: none;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1rem;
    font-weight: 500;
}

.share-btn.facebook {
    background: linear-gradient(135deg, #1877f2, #0d6efd);
}

.share-btn.twitter {
    background: linear-gradient(135deg, #1da1f2, #0ea5e9);
}

.share-btn.linkedin {
    background: linear-gradient(135deg, #0077b5, #0ea5e9);
}

.share-btn.copy {
    background: linear-gradient(135deg, #666, #555);
}

.share-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

/* Latest Articles Widget - Enhanced */
.latest-article-item {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
    margin-bottom: 1.2rem;
    padding-bottom: 1.2rem;
    border-bottom: 1px solid #f0f0f0;
    transition: all 0.3s ease;
}

.latest-article-item:hover {
    background: #fafafa;
    border-radius: 8px;
    padding: 0.8rem;
    margin: 0 -0.8rem 1.2rem -0.8rem;
}

.latest-article-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.latest-article-thumb {
    flex-shrink: 0;
}

.latest-article-thumb img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.latest-article-item:hover .latest-article-thumb img {
    transform: scale(1.1);
}

.latest-article-info h4 {
    margin-bottom: 0.4rem;
}

.latest-article-info h4 a {
    color: #000;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 600;
    line-height: 1.4;
    transition: color 0.3s ease;
}

.latest-article-info h4 a:hover {
    color: #666;
}

.article-date {
    color: #999;
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

/* Categories Widget - Modern List */
.categories-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.categories-list li {
    margin-bottom: 0.6rem;
}

.categories-list a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0.8rem;
    background: #fafafa;
    border-radius: 10px;
    text-decoration: none;
    color: #555;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.categories-list a:hover {
    background: #000;
    color: #fff;
    transform: translateX(5px);
    border-color: #000;
}

.category-count {
    background: #fff;
    color: #000;
    padding: 0.2rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.categories-list a:hover .category-count {
    background: #fff;
    color: #000;
}

/* Newsletter Widget - Enhanced Form */
.newsletter-widget p {
    color: #666;
    margin-bottom: 1.3rem;
    font-size: 0.85rem;
    line-height: 1.5;
}

.newsletter-form {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

.newsletter-form input {
    padding: 0.8rem 1rem;
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: #fafafa;
}

.newsletter-form input:focus {
    outline: none;
    border-color: #000;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
}

.newsletter-form button {
    padding: 0.8rem 1.2rem;
    background: #000;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-size: 0.9rem;
}

.newsletter-form button:hover {
    background: #333;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

/* Main Content Area - Enhanced */
.post-content-wrapper {
    background: #fff;
    border-radius: 16px;
    padding: 2.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    margin-bottom: 2.5rem;
    border: 1px solid #f0f0f0;
}

.post-excerpt {
    font-size: 1.1rem;
    color: #555;
    line-height: 1.7;
    padding: 1.8rem;
    background: #fafafa;
    border-left: 4px solid #000;
    margin-bottom: 2rem;
    border-radius: 0 8px 8px 0;
}

.post-content {
    font-size: 1rem;
    line-height: 1.7;
    color: #333;
}

.post-content h1,
.post-content h2,
.post-content h3,
.post-content h4,
.post-content h5,
.post-content h6 {
    margin-bottom: 1rem;
    font-weight: 700;
    color: #000;
}

.post-content h2 {
    font-size: 1.8rem;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 0.5rem;
}

.post-content h3 {
    font-size: 1.4rem;
}

.post-content p {
    margin-bottom: 1.3rem;
}

.post-content img {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    margin: 1.5rem 0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* WordPress Caption Styles - Responsive Images */
.post-content .wp-caption,
.post-content figure {
    max-width: 100% !important;
    width: 100% !important;
    margin: 1.5rem 0;
    text-align: center;
}

.post-content .wp-caption img,
.post-content figure img {
    max-width: 100% !important;
    width: 100% !important;
    height: auto !important;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    margin: 0;
}

.post-content .wp-caption-text,
.post-content figcaption {
    font-size: 0.9rem;
    color: #666;
    font-style: italic;
    margin-top: 0.8rem;
    padding: 0 1rem;
    line-height: 1.4;
}

/* Override inline styles for WordPress captions */
.post-content .wp-caption[style*="width"] {
    width: 100% !important;
    max-width: 100% !important;
}

.post-content .wp-caption img[style*="width"] {
    width: 100% !important;
    max-width: 100% !important;
}

.post-content blockquote {
    background: #fafafa;
    border-left: 4px solid #000;
    padding: 1.5rem;
    margin: 1.5rem 0;
    font-style: italic;
    border-radius: 0 8px 8px 0;
    color: #555;
}

.post-content ul,
.post-content ol {
    margin-bottom: 1.3rem;
    padding-left: 1.5rem;
}

.post-content li {
    margin-bottom: 0.5rem;
}

/* Post Tags - Enhanced */
.post-tags {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-top: 2.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #f0f0f0;
    flex-wrap: wrap;
}

.post-tags i {
    color: #666;
    font-size: 1.1rem;
}

.tag-item {
    display: inline-block;
    background: #f0f0f0;
    color: #555;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.tag-item:hover {
    background: #000;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
}

/* Author Box - Enhanced */
.author-box {
    display: flex;
    gap: 1.5rem;
    margin-top: 2.5rem;
    padding: 1.8rem;
    background: #fafafa;
    border-radius: 12px;
    border: 1px solid #f0f0f0;
}

.author-avatar img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.author-info h4 {
    color: #666;
    font-size: 0.85rem;
    margin-bottom: 0.4rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.author-info h5 {
    color: #000;
    font-size: 1.1rem;
    margin-bottom: 0.8rem;
}

.author-info p {
    color: #555;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.author-social {
    display: flex;
    gap: 0.8rem;
}

.author-social a {
    width: 32px;
    height: 32px;
    background: #000;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.author-social a:hover {
    background: #333;
    transform: translateY(-2px);
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
}

/* Related Posts - Enhanced */
.related-posts-section {
    margin-bottom: 2.5rem;
}

.section-title {
    position: relative;
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
}

.title-text {
    font-size: 1.6rem;
    font-weight: 700;
    color: #000;
}

.title-line {
    flex: 1;
    height: 2px;
    background: linear-gradient(45deg, #000, #666);
    border-radius: 1px;
}

.related-posts-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}

.related-post-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
}

.related-post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.related-post-image {
    height: 160px;
    overflow: hidden;
}

.related-post-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.related-post-card:hover .related-post-image img {
    transform: scale(1.1);
}

.related-post-content {
    padding: 1.3rem;
}

.related-post-meta {
    margin-bottom: 0.5rem;
}

.meta-date {
    color: #666;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.related-post-title {
    margin: 0;
}

.related-post-title a {
    color: #000;
    text-decoration: none;
    font-size: 1rem;
    font-weight: 600;
    line-height: 1.4;
    transition: color 0.3s ease;
}

.related-post-title a:hover {
    color: #666;
}

/* CTA Section - Enhanced */
.post-cta-section {
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
    animation: patternMove 20s linear infinite;
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
}

.cta-description {
    font-size: 1.1rem;
    color: #ccc;
    line-height: 1.6;
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

/* Responsive Design - Optimized */
@media (max-width: 1199px) {
    .left-sidebar,
    .right-sidebar {
        padding: 0 10px;
        max-width: 320px;
    }
    
    .sidebar-widget {
        padding: 1.5rem;
    }
    
    .main-content-wrapper {
        padding: 0 15px;
    }
    
    .post-hero-title {
        font-size: 2.8rem;
    }
}

@media (max-width: 991px) {
    .left-sidebar,
    .right-sidebar {
        position: relative;
        top: 0;
        max-height: none;
        margin-top: 2rem;
        padding: 0 15px;
        max-width: 300px;
    }
    
    .fixed-sidebar {
        position: relative;
        top: 0;
        max-height: none;
    }
    
    .related-posts-grid {
        grid-template-columns: 1fr;
    }
    
    .post-content-wrapper {
        padding: 2rem;
    }
    
    .main-content-wrapper {
        padding: 0 15px;
    }
    
    .post-hero-title {
        font-size: 2.4rem;
    }
}

@media (max-width: 768px) {
    .post-hero-section {
        padding: 80px 0 50px;
    }
    
    .post-hero-title {
        font-size: 2rem;
    }
    
    .post-meta-info {
        font-size: 0.85rem;
        gap: 0.8rem;
    }
    
    .post-content-wrapper {
        padding: 1.5rem;
    }
    
    .author-box {
        flex-direction: column;
        text-align: center;
    }
    
    .cta-title {
        font-size: 2rem;
    }
    
    .sidebar-widget {
        padding: 1.5rem;
    }
    
    .main-content-wrapper {
        padding: 0 10px;
    }
    
    /* Ẩn sidebar trên tablet */
    .left-sidebar,
    .right-sidebar {
        display: none;
    }
    
    /* Mở rộng nội dung chính khi ẩn sidebar */
    .col-lg-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    .post-excerpt {
        padding: 1.5rem;
        font-size: 1rem;
    }
    
    .related-posts-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
}

@media (max-width: 480px) {
    .post-hero-section {
        padding: 60px 0 40px;
    }
    
    .post-hero-title {
        font-size: 1.8rem;
    }
    
    .post-content-wrapper {
        padding: 1rem;
    }
    
    .share-buttons-compact {
        grid-template-columns: 1fr;
    }
    
    .sidebar-widget {
        padding: 1rem;
    }
    
    .main-content-wrapper {
        padding: 0 5px;
    }
    
    /* Ẩn sidebar trên điện thoại */
    .left-sidebar,
    .right-sidebar {
        display: none;
    }
    
    /* Mở rộng nội dung chính khi ẩn sidebar */
    .col-lg-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    .post-excerpt {
        padding: 1.2rem;
        font-size: 0.95rem;
    }
    
    .author-box {
        padding: 1.2rem;
    }
    
    .cta-title {
        font-size: 1.8rem;
    }
    
    .btn-cta-primary,
    .btn-cta-secondary {
        padding: 0.8rem 1.5rem;
        font-size: 0.9rem;
    }
}
</style>

<script>
// Table of Contents Generator
document.addEventListener('DOMContentLoaded', function() {
    const postContent = document.querySelector('.post-content');
    const tocContent = document.getElementById('toc-content');
    
    if (postContent && tocContent) {
        const headings = postContent.querySelectorAll('h2, h3');
        
        if (headings.length > 0) {
            const tocList = document.createElement('ul');
            
            headings.forEach((heading, index) => {
                // Add ID to heading for anchor link
                const headingId = 'heading-' + index;
                heading.id = headingId;
                
                // Create TOC item
                const tocItem = document.createElement('li');
                const tocLink = document.createElement('a');
                tocLink.href = '#' + headingId;
                tocLink.textContent = heading.textContent;
                
                tocItem.appendChild(tocLink);
                tocList.appendChild(tocItem);
            });
            
            tocContent.appendChild(tocList);
            
            // Smooth scroll to anchor
            tocContent.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    
                    if (targetElement) {
                        const offsetTop = targetElement.offsetTop - 100;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Highlight active section on scroll
            window.addEventListener('scroll', function() {
                let current = '';
                headings.forEach(heading => {
                    const rect = heading.getBoundingClientRect();
                    if (rect.top <= 150) {
                        current = heading.id;
                    }
                });
                
                tocContent.querySelectorAll('a').forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + current) {
                        link.classList.add('active');
                    }
                });
            });
        } else {
            tocContent.innerHTML = '<p style="color: #999;">Không có mục lục</p>';
        }
    }
});

// Share Functions
function shareOnFacebook() {
    const url = window.location.href;
    const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
    window.open(shareUrl, '_blank', 'width=600,height=400');
}

function shareOnTwitter() {
    const url = window.location.href;
    const title = document.querySelector('.post-hero-title').textContent;
    const shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`;
    window.open(shareUrl, '_blank', 'width=600,height=400');
}

function shareOnLinkedIn() {
    const url = window.location.href;
    const shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`;
    window.open(shareUrl, '_blank', 'width=600,height=400');
}

function copyLink() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        alert('Đã sao chép link bài viết!');
    });
}

// Newsletter Form
document.querySelector('.newsletter-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Cảm ơn bạn đã đăng ký nhận tin!');
    this.reset();
});
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