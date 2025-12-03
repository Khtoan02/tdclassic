<?php
/**
 * Template Name: San Pham
 * The template for displaying the products page
 */

get_header(); ?>

<main id="main" class="site-main products-page">
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
                            <span class="category-title-main">Sản phẩm</span>
                            <span class="category-title-sub">GIẢI PHÁP & SẢN PHẨM</span>
                        </h1>
                        <div class="category-description-wrapper">
                            <p class="category-hero-description">Khám phá các giải pháp và sản phẩm âm thanh chuyên nghiệp được thiết kế cho doanh nghiệp hiện đại.</p>
                        </div>
                        <div class="category-stats">
                            <div class="stat-item">
                                <div class="stat-number"><?php echo (int) wp_count_posts('product')->publish; ?>+</div>
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

    <!-- Filter Section -->
    <section class="products-filter">
        <div class="container">
            <div class="filter-wrapper">
                <div class="filter-tabs">
                    <button class="filter-tab active" data-filter="all">Tất cả</button>
                    <?php
                    $product_categories = get_terms(array(
                        'taxonomy' => 'product_category',
                        'hide_empty' => true,
                    ));
                    
                    if ($product_categories && !is_wp_error($product_categories)) :
                        foreach ($product_categories as $category) :
                    ?>
                        <button class="filter-tab" data-filter="<?php echo $category->slug; ?>">
                            <?php echo $category->name; ?>
                        </button>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
                
                <div class="filter-search">
                    <input type="text" id="product-search" placeholder="Tìm kiếm sản phẩm...">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="products-grid">
        <div class="container">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $products = new WP_Query(array(
                'post_type' => 'product',
                'posts_per_page' => 9, // 3x3 grid
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC',
                'paged' => $paged
            ));
            
            if ($products->have_posts()) :
            ?>
                <div class="products-container" id="products-container" >
                    <?php
                    while ($products->have_posts()) : $products->the_post();
                        $product_categories = get_the_terms(get_the_ID(), 'product_category');
                        $category_classes = '';
                        $category_name = '';
                        if ($product_categories && !is_wp_error($product_categories)) {
                            foreach ($product_categories as $category) {
                                $category_classes .= ' category-' . $category->slug;
                            }
                            $category_name = $product_categories[0]->name;
                        }
                    ?>
                        <a href="<?php the_permalink(); ?>" class="product-card-wrapper<?php echo $category_classes; ?>" data-title="<?php echo strtolower(get_the_title()); ?>">
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
                    <?php
                    endwhile;
                    ?>
                </div>

                <!-- Pagination -->
                <div class="products-pagination">
                    <?php
                    $total_pages = $products->max_num_pages;
                    if ($total_pages > 1) :
                        echo paginate_links(array(
                            'base' => get_pagenum_link(1) . '%_%',
                            'format' => 'page/%#%',
                            'current' => $paged,
                            'total' => $total_pages,
                            'prev_text' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15,18 9,12 15,6"></polyline></svg>',
                            'next_text' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"></polyline></svg>'
                        ));
                    endif;
                    wp_reset_postdata();
                    ?>
                </div>

            <?php else : ?>
                <div class="no-products">
                    <div class="no-products-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg>
                    </div>
                    <h3>Chưa có sản phẩm nào</h3>
                    <p>Hiện tại chúng tôi chưa có sản phẩm nào để hiển thị. Vui lòng quay lại sau.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Why Choose TD Classic Section -->
    <section class="why-choose-section">
        <div class="container">
            <div class="section-header">
                <h2>Tại sao bạn nên chọn sản phẩm TD Classic?</h2>
                <p>Khám phá 5 yếu tố cốt lõi làm nên sự khác biệt của chúng tôi</p>
            </div>
            
            <div class="features-slider-container">
                <div class="features-slider" id="features-slider">
                    <div class="feature-slide active">
                        <div class="feature-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                            </svg>
                        </div>
                        <h3>Chất lượng vượt trội</h3>
                        <p>Mỗi sản phẩm được thiết kế và sản xuất theo tiêu chuẩn quốc tế với công nghệ hiện đại nhất. Chúng tôi cam kết mang đến cho khách hàng những sản phẩm có chất lượng vượt trội, bền bỉ theo thời gian.</p>
                    </div>
                    
                    <div class="feature-slide">
                        <div class="feature-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"></path>
                                <line x1="16" y1="8" x2="2" y2="22"></line>
                                <line x1="17.5" y1="15" x2="9" y2="15"></line>
                            </svg>
                        </div>
                        <h3>Thiết kế sáng tạo</h3>
                        <p>Đội ngũ thiết kế giàu kinh nghiệm của chúng tôi luôn đặt sự sáng tạo và tính thẩm mỹ lên hàng đầu. Mỗi sản phẩm không chỉ có chức năng tuyệt vời mà còn mang vẻ đẹp tinh tế, phù hợp với xu hướng hiện đại.</p>
                    </div>
                    
                    <div class="feature-slide">
                        <div class="feature-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0-6 0"></path>
                                <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 0 1-2.827 0l-4.244-4.243a8 8 0 1 1 11.314 0z"></path>
                            </svg>
                        </div>
                        <h3>Hỗ trợ 24/7</h3>
                        <p>Đội ngũ hỗ trợ khách hàng chuyên nghiệp của TD Classic sẵn sàng phục vụ bạn 24/7. Chúng tôi cam kết giải đáp mọi thắc mắc và hỗ trợ khách hàng một cách nhanh chóng, hiệu quả nhất.</p>
                    </div>
                    
                    <div class="feature-slide">
                        <div class="feature-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </div>
                        <h3>Bảo hành toàn diện</h3>
                        <p>Mọi sản phẩm của TD Classic đều được bảo hành toàn diện với thời gian dài. Chúng tôi tự tin về chất lượng sản phẩm và cam kết chăm sóc khách hàng sau bán hàng một cách tốt nhất.</p>
                    </div>
                    
                    <div class="feature-slide">
                        <div class="feature-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                            </svg>
                        </div>
                        <h3>Tối ưu hiệu suất</h3>
                        <p>Sản phẩm TD Classic được tối ưu hóa để mang lại hiệu suất làm việc tốt nhất. Chúng tôi luôn nghiên cứu và cải tiến để đảm bảo sản phẩm hoạt động mượt mà, tiết kiệm năng lượng và nâng cao năng suất làm việc.</p>
                    </div>
                </div>
                
                <div class="slider-controls">
                    <button class="slider-btn prev-btn" id="prev-btn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="15,18 9,12 15,6"></polyline>
                        </svg>
                    </button>
                    
                    <div class="slider-dots">
                        <button class="dot active" data-slide="0"></button>
                        <button class="dot" data-slide="1"></button>
                        <button class="dot" data-slide="2"></button>
                        <button class="dot" data-slide="3"></button>
                        <button class="dot" data-slide="4"></button>
                    </div>
                    
                    <button class="slider-btn next-btn" id="next-btn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9,18 15,12 9,6"></polyline>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="products-cta">
        <div class="container">
            <div class="cta-content">
                <h2>Cần tư vấn về sản phẩm?</h2>
                <p>Đội ngũ chuyên gia của chúng tôi sẵn sàng hỗ trợ bạn tìm ra giải pháp phù hợp nhất</p>
                <div class="cta-buttons">
                    <a href="<?php echo home_url('/lien-he'); ?>" class="btn btn-primary">Liên hệ ngay</a>
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', tdclassic_get_company_phone())); ?>" class="btn btn-secondary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        Gọi ngay
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
/* Products Page - Hero Section (reused from blog category hero) */
.category-hero-section { background: radial-gradient(circle, rgba(66,66,66,1) 0%, rgba(0,0,0,1) 100%); color: #fff; padding: 100px 0 80px; position: relative; overflow: hidden; }
.category-hero-background { position: absolute; inset: 0; z-index: 1; }
.category-hero-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.3); }
.tech-grid-pattern { position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px); background-size: 50px 50px; }
.category-hero-content { position: relative; z-index: 10; }
.category-hero-title { margin-bottom: 2rem; }
.category-title-main { display: block; font-size: 3.5rem; font-weight: 800; margin-bottom: .5rem; background: linear-gradient(45deg, #fff, #ccc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
.category-title-sub { display: block; font-size: 1.2rem; font-weight: 400; color: #ccc; letter-spacing: 3px; text-transform: uppercase; }
.category-description-wrapper { margin: 0 auto 3rem; }
.category-hero-description { font-size: 1.2rem; color: #ccc; line-height: 1.8; }
.category-stats { display: flex; justify-content: center; align-items: center; gap: 2rem; margin-top: 3rem; }
.category-stats .stat-item { text-align: center; }
.category-stats .stat-number { font-size: 2rem; font-weight: 700; color: #fff; margin-bottom: .5rem; }
.category-stats .stat-label { font-size: .9rem; color: #999; text-transform: uppercase; letter-spacing: 1px; }
.category-stats .stat-divider { width: 1px; height: 40px; background: rgba(255,255,255,0.2); }
@media (max-width: 768px) { .category-title-main { font-size: 2.5rem; } .category-title-sub { font-size:1rem; letter-spacing:2px; } .category-stats { flex-wrap: wrap; gap: 1rem; } }
@media (max-width: 480px) { .category-hero-section { padding:60px 0 50px; } .category-title-main { font-size:2rem; } }
</style>

<script>
// Product filtering and search functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const productCards = document.querySelectorAll('.product-card');
    const searchInput = document.getElementById('product-search');
    
    // Filter functionality
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            // Update active tab
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Filter products
            productCards.forEach(card => {
                if (filter === 'all' || card.classList.contains('category-' + filter)) {
                    card.style.display = 'block';
                    setTimeout(() => card.style.opacity = '1', 10);
                } else {
                    card.style.opacity = '0';
                    setTimeout(() => card.style.display = 'none', 300);
                }
            });
        });
    });
    
    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        productCards.forEach(card => {
            const title = card.dataset.title;
            if (title.includes(searchTerm)) {
                card.style.display = 'block';
                setTimeout(() => card.style.opacity = '1', 10);
            } else {
                card.style.opacity = '0';
                setTimeout(() => card.style.display = 'none', 300);
            }
        });
    });
    
    // Features slider functionality
    const slider = document.getElementById('features-slider');
    const slides = document.querySelectorAll('.feature-slide');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    let currentSlide = 0;
    
    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        slides[index].classList.add('active');
        dots[index].classList.add('active');
    }
    
    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }
    
    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
    }
    
    // Button controls
    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);
    
    // Dot controls
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            showSlide(currentSlide);
        });
    });
    
    // Shift + Mouse wheel control
    slider.addEventListener('wheel', function(e) {
        if (e.shiftKey) {
            e.preventDefault();
            if (e.deltaY > 0) {
                nextSlide();
            } else {
                prevSlide();
            }
        }
    });
});
</script>

<?php get_footer(); ?> 