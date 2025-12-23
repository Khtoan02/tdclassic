<?php
/**
 * The template for displaying category archives
 */

get_header(); ?>

<main id="main" class="site-main blog-category-page">
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
                            <span class="category-title-sub">KIẾN THỨC & TIN TỨC</span>
                        </h1>
                        <div class="category-description-wrapper">
                            <p class="category-hero-description">
                                <?php 
                                $description = category_description();
                                echo $description ? $description : 'Cập nhật những thông tin mới nhất về âm thanh chuyên nghiệp, kiến thức kỹ thuật và các giải pháp tối ưu cho hệ thống âm thanh.';
                                ?>
                            </p>
                        </div>
                        <div class="category-stats">
                            <div class="stat-item">
                                <div class="stat-number"><?php 
                                    $current_cat = get_queried_object();
                                    echo $current_cat->count;
                                ?>+</div>
                                <div class="stat-label">Bài viết</div>
                            </div>
                            <div class="stat-divider"></div>
                            <div class="stat-item">
                                <div class="stat-number">100%</div>
                                <div class="stat-label">Chất lượng</div>
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

    <!-- Blog Posts Grid Section -->
    <section class="blog-posts-grid-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-header">
                        <h2 class="section-title">
                            <span class="title-text">Bài viết trong danh mục</span>
                            <span class="title-line"></span>
                        </h2>
                        <div class="section-filters">
                            <div class="filter-item active" data-filter="all">
                                <i class="fas fa-th-large"></i>
                                <span>Tt cả</span>
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

            <div class="blog-posts-grid">
                <?php
                if (have_posts()) :
                    $post_count = 0;
                    while (have_posts()) : the_post();
                        $post_count++;
                        $post_id = get_the_ID();
                        $views = get_post_meta($post_id, 'post_views_count', true) ?: 0;
                        
                        // Animation delay
                        $delay = ($post_count % 3) * 0.1;
                ?>
                    <article class="blog-post-card" style="animation-delay: <?php echo $delay; ?>s;">
                        <div class="post-card-inner">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                                    </a>
                                    <div class="post-category-badge">
                                        <?php
                                        $categories = get_the_category();
                                        if ($categories) {
                                            echo '<a href="' . get_category_link($categories[0]->term_id) . '">' . $categories[0]->name . '</a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="post-content">
                                <div class="post-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-user"></i>
                                        <span><?php the_author(); ?></span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span><?php echo get_the_date('d/m/Y'); ?></span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-eye"></i>
                                        <span><?php echo $views; ?> lượt xem</span>
                                    </div>
                                </div>
                                
                                <h2 class="post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                
                                <div class="post-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                                
                                <div class="post-footer">
                                    <a href="<?php the_permalink(); ?>" class="btn-read-more">
                                        <span>Đọc thêm</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                    <div class="post-share">
                                        <!-- Social sharing removed -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php
                    endwhile;
                    
                    // Pagination
                    if ($wp_query->max_num_pages > 1) :
                ?>
                    
                    </div>
                    <div class="pagination-wrapper col-12">
                        <div class="modern-pagination">
                            <?php
                            echo paginate_links(array(
                                'total' => $wp_query->max_num_pages,
                                'prev_text' => '<i class="fas fa-chevron-left"></i><span>Trước</span>',
                                'next_text' => '<span>Sau</span><i class="fas fa-chevron-right"></i>',
                                'type' => 'list'
                            ));
                            ?>
                        </div>
                <?php
                    endif;
                else :
                ?>
                    <div class="no-posts-wrapper col-12">
                        <div class="no-posts-content">
                            <div class="no-posts-icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <h3>Chưa có bài viết nào trong danh mục này</h3>
                            <p>Vui lòng quay lại sau để cập nhật thông tin mới nhất</p>
                            <a href="<?php echo home_url('/tin-tuc'); ?>" class="btn-back-to-blog">
                                <i class="fas fa-arrow-left"></i>
                                <span>Quay về trang tin tức</span>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    
</main>

<style>
/* Blog Category Page Styles */
.blog-category-page {
    background-color: #fff;
}

/* Category Hero Section */
.category-hero-section {
    background: #424242;
    background: radial-gradient(circle, rgba(66, 66, 66, 1) 0%, rgba(0, 0, 0, 1) 100%);
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

/* Blog Posts Grid Section */
.blog-posts-grid-section {
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

/* Blog Posts Grid */
.blog-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 4rem;
}

.blog-post-card {
    animation: fadeInUp 0.6s ease forwards;
    opacity: 0;
    transform: translateY(30px);
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.post-card-inner {
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.post-card-inner:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.post-image {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.post-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.post-card-inner:hover .post-image img {
    transform: scale(1.1);
}

.post-category-badge {
    position: absolute;
    top: 15px;
    left: 15px;
}

.post-category-badge a {
    background: rgba(0, 0, 0, 0.8);
    color: #fff;
    padding: 0.4rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
}

.post-category-badge a:hover {
    background: #000;
}

.post-content {
    padding: 2rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.post-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    font-size: 0.85rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    color: #666;
}

.meta-item i {
    color: #999;
    font-size: 0.8rem;
}

.post-title {
    margin-bottom: 1rem;
}

.post-title a {
    color: #000;
    text-decoration: none;
    font-size: 1.4rem;
    font-weight: 700;
    line-height: 1.3;
    transition: color 0.3s ease;
}

.post-title a:hover {
    color: #666;
}

.post-excerpt {
    color: #666;
    line-height: 1.6;
    margin-bottom: 2rem;
    flex-grow: 1;
}

.post-footer {
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

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

.modern-pagination ul {
    display: flex;
    gap: 0.25rem;
    list-style: none;
    padding: 0;
    margin: 0;
    align-items: center;
}

.modern-pagination li {
    margin: 0;
}

.modern-pagination a,
.modern-pagination span {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    padding: 0.6rem 1rem;
    background: #f8f9fa;
    color: #495057;
    text-decoration: none;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    transition: all 0.2s ease;
    font-weight: 500;
    font-size: 0.9rem;
    min-width: 2.5rem;
    height: 2.5rem;
    position: relative;
    overflow: hidden;
}

.modern-pagination a:hover {
    background: #e9ecef;
    color: #212529;
    border-color: #adb5bd;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.modern-pagination .current span {
    background: #000;
    color: #fff;
    border-color: #000;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.modern-pagination .prev a,
.modern-pagination .next a {
    padding: 0.6rem 1.2rem;
    min-width: auto;
}

.modern-pagination .prev a:hover,
.modern-pagination .next a:hover {
    background: #000;
    color: #fff;
    border-color: #000;
}

.modern-pagination .dots {
    color: #6c757d;
    padding: 0.6rem 0.5rem;
    border: none;
    background: transparent;
    cursor: default;
}

.modern-pagination .dots:hover {
    background: transparent;
    transform: none;
    box-shadow: none;
}

/* No Posts */
.no-posts-wrapper {
    grid-column: 1 / -1;
    display: flex;
    justify-content: center;
    padding: 4rem 0;
}

.no-posts-content {
    text-align: center;
    max-width: 400px;
}

.no-posts-icon {
    font-size: 4rem;
    color: #ccc;
    margin-bottom: 1.5rem;
}

.no-posts-content h3 {
    color: #000;
    margin-bottom: 1rem;
}

.no-posts-content p {
    color: #666;
    margin-bottom: 2rem;
}

.btn-back-to-blog {
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

.btn-back-to-blog:hover {
    background: #333;
    color: #fff;
    transform: translateX(-5px);
}

/* Newsletter Section */
.newsletter-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #000 0%, #1a1a1a 100%);
    color: #fff;
}

.newsletter-wrapper {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 20px;
    padding: 3rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.newsletter-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.newsletter-description {
    font-size: 1.1rem;
    color: #ccc;
    line-height: 1.6;
}


.form-group {
    display: flex;
    width: 100%;
    max-width: 500px;
    background: #fff;
    border-radius: 50px;
    overflow: hidden;
}

.form-group input {
    flex: 1;
    padding: 1rem 2rem;
    border: none;
    outline: none;
    font-size: 1rem;
}

.form-group button {
    padding: 1rem 2rem;
    background: #000;
    color: #fff;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
}

.form-group button:hover {
    background: #333;
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
    }
    
    .section-filters {
        flex-wrap: wrap;
    }
    
    .blog-posts-grid {
        grid-template-columns: 1fr;
    }
    
    .newsletter-wrapper {
        padding: 2rem;
    }
    
    .newsletter-title {
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
    
    .form-group {
        flex-direction: column;
        border-radius: 10px;
    }
    
    .form-group button {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
// Newsletter Form
document.querySelector('.newsletter-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Cảm ơn bạn đã đăng ký nhận tin!');
    this.reset();
});

// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterItems = document.querySelectorAll('.filter-item');
    const postCards = document.querySelectorAll('.blog-post-card');
    
    filterItems.forEach(filter => {
        filter.addEventListener('click', function() {
            // Remove active class from all filters
            filterItems.forEach(f => f.classList.remove('active'));
            // Add active class to clicked filter
            this.classList.add('active');
            
            const filterValue = this.getAttribute('data-filter');
            
            // For now just show all posts since we don't have filter data
            // You can implement actual filtering logic here
            postCards.forEach(card => {
                card.style.display = 'block';
            });
        });
    });
});
</script>

<?php get_footer(); ?> 