<?php
/**
 * The front page template file
 *
 * @package TD Classic
 */

get_header();
?>

<!-- Enhanced Front Page Styles -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/front-page-enhanced.css">

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <!-- Hero Section - Hình ảnh + Danh mục sản phẩm -->
        <section class="hero-section">
            <div class="hero-background">
                <div class="hero-background-image" style="background-image: url('https://www.hifivietnam.vn/wp-content/uploads/2024/05/hfvn-nhahathoguom-5.webp');"></div>
                <div class="hero-overlay"></div>
            </div>
            
            <div class="hero-content">
                <div class="container">
                    <div class="hero-categories">
                    
                        <div class="categories-grid">
                            <?php
                            // Lấy danh mục sản phẩm từ WooCommerce sử dụng helper function
                            $product_categories = tdclassic_get_product_categories(6);
                            
                            if (!empty($product_categories)) :
                                foreach ($product_categories as $category) :
                                    ?>
                                    <a href="<?php echo esc_url($category['url']); ?>" class="category-card">
                                        <div class="category-image">
                                            <img src="<?php echo esc_url($category['image_url']); ?>" alt="<?php echo esc_attr($category['image_alt']); ?>">
                                        </div>
                                        <div class="category-content">
                                            <h3><?php echo strtoupper($category['name']); ?></h3>
                                            <p><?php echo esc_html($category['description']); ?></p>
                                            <div class="category-arrow">
                                                <i class="fas fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </a>
                                    <?php
                                endforeach;
                            else :
                                // Fallback nếu không có danh mục nào
                                ?>
                                <div class="col-12 text-center">
                                    <p>Không có danh mục sản phẩm nào được tìm thấy.</p>
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Work Process Section - MỚI -->
        <section class="work-process-section">
            <div class="container">
                <div class="section-header text-center">
                    <div class="section-badge">
                        <i class="fas fa-cogs"></i>
                        <span>Quy trình làm việc</span>
                    </div>
                    <h2 class="section-title">Quy trình chuyên nghiệp</h2>
                    <p class="section-description">
                        Chúng tôi tuân thủ quy trình làm việc chuẩn quốc tế để đảm bảo chất lượng và hiệu quả tối ưu
                    </p>
                </div>
                
                <div class="process-timeline">
                    <div class="process-step">
                        <div class="step-number">01</div>
                        <div class="step-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="step-title">Khảo sát & Tư vấn</h3>
                        <p class="step-description">
                            Khảo sát không gian, phân tích nhu cầu và đưa ra giải pháp tối ưu nhất
                        </p>
                        <div class="step-duration">
                            <i class="fas fa-clock"></i>
                            <span>1-2 ngày</span>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="step-number">02</div>
                        <div class="step-icon">
                            <i class="fas fa-drafting-compass"></i>
                        </div>
                        <h3 class="step-title">Thiết kế & Lập kế hoạch</h3>
                        <p class="step-description">
                            Thiết kế hệ thống âm thanh chi tiết, lập kế hoạch thi công và báo giá cụ thể
                        </p>
                        <div class="step-duration">
                            <i class="fas fa-clock"></i>
                            <span>2-3 ngày</span>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="step-number">03</div>
                        <div class="step-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h3 class="step-title">Lắp đặt & Thi công</h3>
                        <p class="step-description">
                            Lắp đặt thiết bị theo đúng tiêu chuẩn kỹ thuật, đảm bảo an toàn và chất lượng
                        </p>
                        <div class="step-duration">
                            <i class="fas fa-clock"></i>
                            <span>3-7 ngày</span>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="step-number">04</div>
                        <div class="step-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3 class="step-title">Kiểm tra & Nghiệm thu</h3>
                        <p class="step-description">
                            Kiểm tra chất lượng âm thanh, hướng dẫn sử dụng và bàn giao cho khách hàng
                        </p>
                        <div class="step-duration">
                            <i class="fas fa-clock"></i>
                            <span>1 ngày</span>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="step-number">05</div>
                        <div class="step-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3 class="step-title">Bảo trì & Hỗ trợ</h3>
                        <p class="step-description">
                            Dịch vụ bảo trì định kỳ và hỗ trợ kỹ thuật 24/7 sau khi bàn giao
                        </p>
                        <div class="step-duration">
                            <i class="fas fa-clock"></i>
                            <span>Liên tục</span>
                        </div>
                    </div>
                </div>
                
                <div class="process-cta text-center">
                    <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="btn-primary">
                        <i class="fas fa-calendar-check"></i>
                        <span>Đặt lịch tư vấn</span>
                    </a>
                </div>
            </div>
        </section>
        
        <!-- About Section - Nâng cấp hoàn toàn -->
        <section class="about-section">
            <div class="container">
                <div class="about-header text-center">
                    <div class="section-badge">
                        <i class="fas fa-info-circle"></i>
                        <span>Về chúng tôi</span>
                    </div>
                    <h2 class="section-title">TD Classic - Chuyên gia âm thanh hàng đầu</h2>
                    <p class="section-subtitle">
                        Với hơn 10 năm kinh nghiệm trong lĩnh vực âm thanh, TD Classic tự hào là đơn vị tiên phong 
                        trong việc cung cấp các giải pháp âm thanh chất lượng cao cho mọi nhu cầu từ gia đình đến doanh nghiệp.
                    </p>
                </div>
                
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="about-content">
                            <div class="about-description">
                                <h3 class="about-heading">Chúng tôi là ai?</h3>
                                <p class="about-text">
                                    TD Classic được thành lập với sứ mệnh mang đến những trải nghiệm âm thanh tuyệt vời nhất 
                                    cho khách hàng Việt Nam. Chúng tôi không chỉ bán thiết bị, mà còn cung cấp giải pháp 
                                    âm thanh toàn diện từ thiết kế, lắp đặt đến bảo trì.
                                </p>
                                
                                <div class="about-highlights">
                                    <div class="highlight-item">
                                        <div class="highlight-icon">
                                            <i class="fas fa-award"></i>
                                        </div>
                                        <div class="highlight-content">
                                            <h4>Chất lượng quốc tế</h4>
                                            <p>Sản phẩm chính hãng từ các thương hiệu uy tín hàng đầu thế giới</p>
                                        </div>
                                    </div>
                                    
                                    <div class="highlight-item">
                                        <div class="highlight-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="highlight-content">
                                            <h4>Đội ngũ chuyên môn</h4>
                                            <p>Kỹ sư âm thanh có chứng chỉ quốc tế và kinh nghiệm thực tế</p>
                                        </div>
                                    </div>
                                    
                                    <div class="highlight-item">
                                        <div class="highlight-icon">
                                            <i class="fas fa-headset"></i>
                                        </div>
                                        <div class="highlight-content">
                                            <h4>Hỗ trợ 24/7</h4>
                                            <p>Dịch vụ khách hàng và hỗ trợ kỹ thuật suốt 24 giờ</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="about-actions">
                                <a href="<?php echo esc_url(home_url('/ve-chung-toi')); ?>" class="btn-primary btn-about">
                                    <i class="fas fa-info-circle"></i>
                                    <span>Tìm hiểu thêm</span>
                                </a>
                                <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="btn-outline btn-about">
                                    <i class="fas fa-phone"></i>
                                    <span>Liên hệ ngay</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="about-visual">
                            <div class="about-image-wrapper">
                                <img src="https://sokamedia.vn/wp-content/uploads/2024/06/cho-thue-am-thanh-anh-sang-tphcm1.jpg" alt="TD Classic Studio" class="about-main-image">
                                <div class="about-brand-info">
                                    <div class="brand-badge">
                                        <i class="fas fa-crown"></i>
                                        <span>Thương hiệu uy tín</span>
                                    </div>
                                    <div class="brand-description">
                                        <p>TD Classic - Đối tác tin cậy của các thương hiệu âm thanh hàng đầu Việt Nam</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="about-stats-grid">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-project-diagram"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-number" data-count="2500">2500</div>
                                        <div class="stat-label">Dự án hoàn thành</div>
                                        <div class="stat-description">Từ gia đình đến doanh nghiệp lớn</div>
                                    </div>
                                </div>
                                
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-number" data-count="15">15</div>
                                        <div class="stat-label">Năm kinh nghiệm</div>
                                        <div class="stat-description">Chuyên môn sâu rộng</div>
                                    </div>
                                </div>
                                
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-number" data-count="3500">954+</div>
                                        <div class="stat-label">Khách hàng hài lòng</div>
                                        <div class="stat-description">Đánh giá 5 sao</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
        
        
        <!-- Featured Products Section -->
        <section class="featured-products-section">
            <div class="container">
                <div class="section-header text-center">
                    <div class="section-badge">
                        <i class="fas fa-star"></i>
                        <span>Sản phẩm nổi bật</span>
                    </div>
                    <h2 class="section-title">Khám phá các sản phẩm chất lượng</h2>
                    <p class="section-description">
                        Những sản phẩm được lựa chọn kỹ lưỡng với chất lượng vượt trội và dịch vụ hậu mãi tận tâm
                    </p>
                </div>
                
                <div class="products-carousel-container">
                    <div class="products-carousel" id="products-carousel">
                        <?php
                        // Get all products from WooCommerce
                        $products = new WP_Query(array(
                            'post_type' => 'product',
                            'posts_per_page' => 12,
                            'post_status' => 'publish',
                            'orderby' => 'date',
                            'order' => 'DESC'
                        ));
                        
                        if ($products->have_posts()) :
                            while ($products->have_posts()) : $products->the_post();
                                $product_categories = get_the_terms(get_the_ID(), 'product_category');
                                $category_name = '';
                                if ($product_categories && !is_wp_error($product_categories)) {
                                    $category_name = $product_categories[0]->name;
                                }
                                
                                // Generate random view count starting from 2731
                                $view_count = 2731 + rand(0, 500);
                        ?>
                            <div class="product-slide">
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
                            wp_reset_postdata();
                        else :
                        ?>
                            <div class="no-products">
                                <div class="no-products-icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <h3>Chưa có sản phẩm nào</h3>
                                <p>Hiện tại chúng tôi chưa có sản phẩm nào để hiển thị.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="carousel-controls">
                        <button class="carousel-btn prev" id="carousel-prev">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="carousel-dots" id="carousel-dots"></div>
                        <button class="carousel-btn next" id="carousel-next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section: Loa Chuyên Nghiệp (Professional Speaker) -->
        <section class="featured-products-section" style="Background-color: #f8f9fa">
            <div class="container">
                <div class="section-header text-center">
                    <div class="section-badge">
                        <i class="fas fa-volume-up"></i>
                        <span>Loa chuyên nghiệp</span>
                    </div>
                    <h2 class="section-title">Sản phẩm Loa Chuyên Nghiệp</h2>
                    <p class="section-description">Các mẫu loa công suất cao, chất lượng âm thanh vượt trội dành cho sân khấu, sự kiện, hội trường...</p>
                </div>
                <div class="products-carousel-container">
                    <div class="products-carousel" id="speaker-carousel">
                        <?php
                        $products = new WP_Query(array(
                            'post_type' => 'product',
                            'posts_per_page' => 8,
                            'post_status' => 'publish',
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'slug',
                                    'terms'    => 'professional-speaker',
                                ),
                            ),
                        ));
                        if ($products->have_posts()) :
                            while ($products->have_posts()) : $products->the_post();
                                $product_categories = get_the_terms(get_the_ID(), 'product_category');
                                $category_name = '';
                                if ($product_categories && !is_wp_error($product_categories)) {
                                    $category_name = $product_categories[0]->name;
                                }
                        ?>
                        <div class="product-slide">
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
                        <?php endwhile; wp_reset_postdata(); else : ?>
                        <div class="no-products">
                            <div class="no-products-icon">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <h3>Chưa có sản phẩm nào</h3>
                            <p>Hiện tại chưa có sản phẩm nào trong danh mục này.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="carousel-controls">
                        <button class="carousel-btn prev" id="speaker-carousel-prev">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="carousel-dots" id="speaker-carousel-dots"></div>
                        <button class="carousel-btn next" id="speaker-carousel-next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Section: Thiết Bị Khuếch Đại (Amplifier) -->
        <section class="featured-products-section">
            <div class="container">
                <div class="section-header text-center">
                    <div class="section-badge">
                        <i class="fas fa-broadcast-tower"></i>
                        <span>Thiết bị khuếch đại</span>
                    </div>
                    <h2 class="section-title">Sản phẩm Thiết Bị Khuếch Đại</h2>
                    <p class="section-description">Ampli, cục đẩy công suất, preamp chuyên nghiệp cho hệ thống âm thanh lớn.</p>
                </div>
                <div class="products-carousel-container">
                    <div class="products-carousel" id="amplifier-carousel">
                        <?php
                        $products = new WP_Query(array(
                            'post_type' => 'product',
                            'posts_per_page' => 8,
                            'post_status' => 'publish',
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'slug',
                                    'terms'    => 'amplifier',
                                ),
                            ),
                        ));
                        if ($products->have_posts()) :
                            while ($products->have_posts()) : $products->the_post();
                                $product_categories = get_the_terms(get_the_ID(), 'product_category');
                                $category_name = '';
                                if ($product_categories && !is_wp_error($product_categories)) {
                                    $category_name = $product_categories[0]->name;
                                }
                        ?>
                        <div class="product-slide">
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
                        <?php endwhile; wp_reset_postdata(); else : ?>
                        <div class="no-products">
                            <div class="no-products-icon">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <h3>Chưa có sản phẩm nào</h3>
                            <p>Hiện tại chưa có sản phẩm nào trong danh mục này.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="carousel-controls">
                        <button class="carousel-btn prev" id="amplifier-carousel-prev">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="carousel-dots" id="amplifier-carousel-dots"></div>
                        <button class="carousel-btn next" id="amplifier-carousel-next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Services Section -->
        <section class="services-section">
            <div class="container">
                <div class="section-header text-center">
                    <div class="section-badge">
                        <i class="fas fa-cogs"></i>
                        <span>Dịch vụ chuyên nghiệp</span>
                    </div>
                    <h2 class="section-title">Giải pháp âm thanh toàn diện</h2>
                    <p class="section-description">
                        Chúng tôi cung cấp đầy đủ giải pháp âm thanh chất lượng cao, đáp ứng mọi nhu cầu từ cá nhân đến doanh nghiệp
                    </p>
                </div>
                
                <div class="services-grid">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <h3>Âm thanh gia đình</h3>
                        <p>Hệ thống âm thanh chất lượng cao cho không gian gia đình, tạo trải nghiệm nghe nhạc tuyệt vời</p>
                        <a href="<?php echo esc_url(home_url('/san-pham')); ?>" class="service-link">
                            <span>Tìm hiểu thêm</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3>Âm thanh văn phòng</h3>
                        <p>Giải pháp âm thanh chuyên nghiệp cho văn phòng, hội trường và không gian làm việc</p>
                        <a href="<?php echo esc_url(home_url('/san-pham')); ?>" class="service-link">
                            <span>Tìm hiểu thêm</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-music"></i>
                        </div>
                        <h3>Âm thanh sự kiện</h3>
                        <p>Hệ thống âm thanh công suất cao cho các sự kiện, lễ hội và biểu diễn chuyên nghiệp</p>
                        <a href="<?php echo esc_url(home_url('/san-pham')); ?>" class="service-link">
                            <span>Tìm hiểu thêm</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- CTA Section -->
        <section class="cta-section">
            <div class="container">
                <div class="cta-content text-center">
                    <h2>Sẵn sàng nâng cấp hệ thống âm thanh?</h2>
                    <p>Đội ngũ chuyên gia của chúng tôi sẵn sàng tư vấn và hỗ trợ bạn tìm ra giải pháp phù hợp nhất</p>
                    <div class="cta-actions">
                        <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="btn-primary">
                            <i class="fas fa-phone"></i>
                            <span>Liên hệ tư vấn</span>
                        </a>
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', tdclassic_get_company_phone())); ?>" class="btn-secondary">
                            <i class="fas fa-headphones"></i>
                            <span>Gọi ngay: <?php echo esc_html(tdclassic_get_company_phone()); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Partner Section -->
        <section class="partner-section">
            <div class="container">
                <div class="section-header text-center">
                    <h2 class="section-title">Đối tác tin cậy</h2>
                    <p class="section-subtitle">Chúng tôi tự hào được hợp tác với những thương hiệu uy tín hàng đầu</p>
                </div>
                
                <div class="partner-slider-container">
                    <div class="partner-slider" id="partner-slider">
                        <?php
                        $partners = get_posts(array(
                            'post_type' => 'partner',
                            'posts_per_page' => -1,
                            'post_status' => 'publish',
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        ));
                        
                        if ($partners) {
                            foreach ($partners as $partner) {
                                $logo = get_the_post_thumbnail($partner->ID, 'medium');
                                if ($logo) {
                                    echo '<div class="partner-item">';
                                    echo '<div class="partner-logo">';
                                    echo $logo;
                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                        } else {
                            // Fallback demo partners
                            $demo_partners = array(
                                'Samsung', 'LG', 'Sony', 'Panasonic', 'JBL', 'Bose', 'Harman Kardon', 'Yamaha'
                            );
                            foreach ($demo_partners as $partner_name) {
                                echo '<div class="partner-item">';
                                echo '<div class="partner-logo">';
                                echo '<div class="demo-logo">' . esc_html($partner_name) . '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- News/Blog Section -->
        <section class="news-section">
            <div class="container">
                <div class="section-header text-center">
                    <div class="section-badge">
                        <i class="fas fa-newspaper"></i>
                        <span>Tin tức & Bài viết</span>
                    </div>
                    <h2 class="section-title">Tất cả bài viết</h2>
                    <p class="section-description">Cập nhật thông tin mới nhất về công nghệ, xu hướng thị trường và kiến thức hữu ích về âm thanh.</p>
                </div>
                <div class="news-grid">
                    <?php
                    $news_query = new WP_Query(array(
                        'post_type' => 'post',
                        'posts_per_page' => 6, // chỉ lấy tối đa 6 bài
                        'post_status' => 'publish',
                        'orderby' => 'date',
                        'order' => 'DESC',
                    ));
                    if ($news_query->have_posts()) :
                        while ($news_query->have_posts()) : $news_query->the_post();
                    ?>
                    <div class="news-card">
                        <div class="news-image-wrap">
                            <?php if (has_post_thumbnail()) : ?>
                                <img class="news-image" src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="<?php the_title(); ?>">
                            <?php else : ?>
                                <div class="news-placeholder">
                                    <i class="fas fa-image"></i>
                                    <span>Chưa có ảnh</span>
                                </div>
                            <?php endif; ?>
                            <div class="news-gradient-overlay"></div>
                        </div>
                        <div class="news-content">
                            <div class="news-meta">
                                <span class="news-category">
                                    <i class="fas fa-folder"></i> <?php $cats = get_the_category(); if ($cats) echo esc_html($cats[0]->name); ?>
                                </span>
                                <span class="news-date">
                                    <i class="fas fa-calendar-alt"></i> <?php echo get_the_date(); ?>
                                </span>
                            </div>
                            <h3 class="news-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="news-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?>
                            </p>
                            <div class="news-actions">
                                <a href="<?php the_permalink(); ?>" class="btn-news-details">
                                    <i class="fas fa-eye"></i>
                                    <span>Xem chi tiết</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; wp_reset_postdata(); else : ?>
                    <div class="no-products">
                        <div class="no-products-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h3>Chưa có bài viết nào</h3>
                        <p>Hiện tại chưa có bài viết nào để hiển thị.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        
    </main>
</div>

<script>
// Counter animation for stats
document.addEventListener('DOMContentLoaded', function() {
    const statNumbers = document.querySelectorAll('.stat-number');
    
    const animateCounter = (element, target) => {
        let current = 0;
        const increment = target / 100;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current);
        }, 20);
    };
    
    // Intersection Observer for stats animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = parseInt(entry.target.dataset.count);
                animateCounter(entry.target, target);
                observer.unobserve(entry.target);
            }
        });
    });
    
    statNumbers.forEach(stat => {
        observer.observe(stat);
    });
    
    // Category cards are now simple <a> tags - no JavaScript needed
    
    // Products Carousel functionality
    const carousel = document.getElementById('products-carousel');
    const prevBtn = document.getElementById('carousel-prev');
    const nextBtn = document.getElementById('carousel-next');
    const dotsContainer = document.getElementById('carousel-dots');
    
    if (carousel && prevBtn && nextBtn && dotsContainer) {
        const slides = carousel.querySelectorAll('.product-slide');
        const slideWidth = slides[0]?.offsetWidth + 30; // Including gap
        let currentSlide = 0;
        const maxSlides = slides.length;
        
        // Create dots
        const totalDots = Math.ceil(maxSlides / getSlidesPerView());
        for (let i = 0; i < totalDots; i++) {
            const dot = document.createElement('div');
            dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
            dot.addEventListener('click', () => goToSlide(i));
            dotsContainer.appendChild(dot);
        }
        
        function getSlidesPerView() {
            if (window.innerWidth <= 480) return 1;
            if (window.innerWidth <= 768) return 1;
            if (window.innerWidth <= 1024) return 2;
            return 3;
        }
        
        function updateCarousel() {
            const slidesPerView = getSlidesPerView();
            const maxSlidesToShow = maxSlides - slidesPerView + 1;
            const translateX = -currentSlide * slideWidth;
            
            carousel.style.transform = `translateX(${translateX}px)`;
            
            // Update dots
            const dots = dotsContainer.querySelectorAll('.carousel-dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === Math.floor(currentSlide / slidesPerView));
            });
            
            // Update buttons
            prevBtn.disabled = currentSlide === 0;
            nextBtn.disabled = currentSlide >= maxSlidesToShow;
        }
        
        function goToSlide(slideIndex) {
            const slidesPerView = getSlidesPerView();
            currentSlide = slideIndex * slidesPerView;
            updateCarousel();
        }
        
        function nextSlide() {
            const slidesPerView = getSlidesPerView();
            const maxSlidesToShow = maxSlides - slidesPerView + 1;
            if (currentSlide < maxSlidesToShow) {
                currentSlide++;
                updateCarousel();
            }
        }
        
        function prevSlide() {
            if (currentSlide > 0) {
                currentSlide--;
                updateCarousel();
            }
        }
        
        // Event listeners
        prevBtn.addEventListener('click', prevSlide);
        nextBtn.addEventListener('click', nextSlide);
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                prevSlide();
            } else if (e.key === 'ArrowRight') {
                nextSlide();
            }
        });
        
        // Touch/swipe support for mobile
        let startX = 0;
        let endX = 0;
        
        carousel.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });
        
        carousel.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            const diff = startX - endX;
            
            if (Math.abs(diff) > 50) { // Minimum swipe distance
                if (diff > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
        });
        
        // Auto-play functionality
        let autoPlayInterval;
        
        function startAutoPlay() {
            autoPlayInterval = setInterval(() => {
                const slidesPerView = getSlidesPerView();
                const maxSlidesToShow = maxSlides - slidesPerView + 1;
                
                if (currentSlide >= maxSlidesToShow) {
                    currentSlide = 0;
                } else {
                    currentSlide++;
                }
                updateCarousel();
            }, 5000); // Change slide every 5 seconds
        }
        
        function stopAutoPlay() {
            if (autoPlayInterval) {
                clearInterval(autoPlayInterval);
            }
        }
        
        // Start auto-play
        startAutoPlay();
        
        // Pause auto-play on hover
        carousel.addEventListener('mouseenter', stopAutoPlay);
        carousel.addEventListener('mouseleave', startAutoPlay);
        
        // Handle window resize
        window.addEventListener('resize', () => {
            currentSlide = 0;
            updateCarousel();
        });
        
        // Initialize carousel
        updateCarousel();
    }

    // News Carousel functionality
    const newsCarousel = document.getElementById('news-carousel');
    const newsPrevBtn = document.getElementById('news-carousel-prev');
    const newsNextBtn = document.getElementById('news-carousel-next');
    const newsDotsContainer = document.getElementById('news-carousel-dots');
    
    if (newsCarousel && newsPrevBtn && newsNextBtn && newsDotsContainer) {
        const newsSlides = newsCarousel.querySelectorAll('.news-slide');
        const newsSlideWidth = newsSlides[0]?.offsetWidth + 30; // Including gap
        let newsCurrentSlide = 0;
        const newsMaxSlides = newsSlides.length;

        function getNewsSlidesPerView() {
            if (window.innerWidth <= 480) return 1;
            if (window.innerWidth <= 768) return 1;
            if (window.innerWidth <= 1024) return 2;
            return 3;
        }

        // Create dots
        const newsTotalDots = Math.ceil(newsMaxSlides / getNewsSlidesPerView());
        for (let i = 0; i < newsTotalDots; i++) {
            const dot = document.createElement('div');
            dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
            dot.addEventListener('click', () => goToNewsSlide(i));
            newsDotsContainer.appendChild(dot);
        }

        function updateNewsCarousel() {
            const slidesPerView = getNewsSlidesPerView();
            const maxSlidesToShow = newsMaxSlides - slidesPerView + 1;
            const translateX = -newsCurrentSlide * newsSlideWidth;
            newsCarousel.style.transform = `translateX(${translateX}px)`;
            // Update dots
            const dots = newsDotsContainer.querySelectorAll('.carousel-dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === Math.floor(newsCurrentSlide / slidesPerView));
            });
            // Update buttons
            newsPrevBtn.disabled = newsCurrentSlide === 0;
            newsNextBtn.disabled = newsCurrentSlide >= maxSlidesToShow;
        }
        function goToNewsSlide(slideIndex) {
            const slidesPerView = getNewsSlidesPerView();
            newsCurrentSlide = slideIndex * slidesPerView;
            updateNewsCarousel();
        }
        function nextNewsSlide() {
            const slidesPerView = getNewsSlidesPerView();
            const maxSlidesToShow = newsMaxSlides - slidesPerView + 1;
            if (newsCurrentSlide < maxSlidesToShow) {
                newsCurrentSlide++;
                updateNewsCarousel();
            }
        }
        function prevNewsSlide() {
            if (newsCurrentSlide > 0) {
                newsCurrentSlide--;
                updateNewsCarousel();
            }
        }
        // Event listeners
        newsPrevBtn.addEventListener('click', prevNewsSlide);
        newsNextBtn.addEventListener('click', nextNewsSlide);
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                prevNewsSlide();
            } else if (e.key === 'ArrowRight') {
                nextNewsSlide();
            }
        });
        // Touch/swipe support for mobile
        let newsStartX = 0;
        let newsEndX = 0;
        newsCarousel.addEventListener('touchstart', (e) => {
            newsStartX = e.touches[0].clientX;
        });
        newsCarousel.addEventListener('touchend', (e) => {
            newsEndX = e.changedTouches[0].clientX;
            const diff = newsStartX - newsEndX;
            if (Math.abs(diff) > 50) {
                if (diff > 0) {
                    nextNewsSlide();
                } else {
                    prevNewsSlide();
                }
            }
        });
        // Auto-play functionality
        let newsAutoPlayInterval;
        function startNewsAutoPlay() {
            newsAutoPlayInterval = setInterval(() => {
                const slidesPerView = getNewsSlidesPerView();
                const maxSlidesToShow = newsMaxSlides - slidesPerView + 1;
                if (newsCurrentSlide >= maxSlidesToShow) {
                    newsCurrentSlide = 0;
                } else {
                    newsCurrentSlide++;
                }
                updateNewsCarousel();
            }, 5000);
        }
        function stopNewsAutoPlay() {
            if (newsAutoPlayInterval) {
                clearInterval(newsAutoPlayInterval);
            }
        }
        // Start auto-play
        startNewsAutoPlay();
        // Pause auto-play on hover
        newsCarousel.addEventListener('mouseenter', stopNewsAutoPlay);
        newsCarousel.addEventListener('mouseleave', startNewsAutoPlay);
        // Handle window resize
        window.addEventListener('resize', () => {
            newsCurrentSlide = 0;
            updateNewsCarousel();
        });
        // Initialize carousel
        updateNewsCarousel();
    }

    // Speaker Carousel functionality
    const speakerCarousel = document.getElementById('speaker-carousel');
    const speakerPrevBtn = document.getElementById('speaker-carousel-prev');
    const speakerNextBtn = document.getElementById('speaker-carousel-next');
    const speakerDotsContainer = document.getElementById('speaker-carousel-dots');

    if (speakerCarousel && speakerPrevBtn && speakerNextBtn && speakerDotsContainer) {
        const speakerSlides = speakerCarousel.querySelectorAll('.product-slide');
        const speakerSlideWidth = speakerSlides[0]?.offsetWidth + 30; // Including gap
        let speakerCurrentSlide = 0;
        const speakerMaxSlides = speakerSlides.length;

        function getSpeakerSlidesPerView() {
            if (window.innerWidth <= 480) return 1;
            if (window.innerWidth <= 768) return 1;
            if (window.innerWidth <= 1024) return 2;
            return 3;
        }

        // Create dots
        const speakerTotalDots = Math.ceil(speakerMaxSlides / getSpeakerSlidesPerView());
        for (let i = 0; i < speakerTotalDots; i++) {
            const dot = document.createElement('div');
            dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
            dot.addEventListener('click', () => goToSpeakerSlide(i));
            speakerDotsContainer.appendChild(dot);
        }

        function updateSpeakerCarousel() {
            const slidesPerView = getSpeakerSlidesPerView();
            const maxSlidesToShow = speakerMaxSlides - slidesPerView + 1;
            const translateX = -speakerCurrentSlide * speakerSlideWidth;
            speakerCarousel.style.transform = `translateX(${translateX}px)`;
            // Update dots
            const dots = speakerDotsContainer.querySelectorAll('.carousel-dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === Math.floor(speakerCurrentSlide / slidesPerView));
            });
            // Update buttons
            speakerPrevBtn.disabled = speakerCurrentSlide === 0;
            speakerNextBtn.disabled = speakerCurrentSlide >= maxSlidesToShow;
        }
        function goToSpeakerSlide(slideIndex) {
            const slidesPerView = getSpeakerSlidesPerView();
            speakerCurrentSlide = slideIndex * slidesPerView;
            updateSpeakerCarousel();
        }
        function nextSpeakerSlide() {
            const slidesPerView = getSpeakerSlidesPerView();
            const maxSlidesToShow = speakerMaxSlides - slidesPerView + 1;
            if (speakerCurrentSlide < maxSlidesToShow) {
                speakerCurrentSlide++;
                updateSpeakerCarousel();
            }
        }
        function prevSpeakerSlide() {
            if (speakerCurrentSlide > 0) {
                speakerCurrentSlide--;
                updateSpeakerCarousel();
            }
        }
        // Event listeners
        speakerPrevBtn.addEventListener('click', prevSpeakerSlide);
        speakerNextBtn.addEventListener('click', nextSpeakerSlide);
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                prevSpeakerSlide();
            } else if (e.key === 'ArrowRight') {
                nextSpeakerSlide();
            }
        });
        // Touch/swipe support for mobile
        let speakerStartX = 0;
        let speakerEndX = 0;
        speakerCarousel.addEventListener('touchstart', (e) => {
            speakerStartX = e.touches[0].clientX;
        });
        speakerCarousel.addEventListener('touchend', (e) => {
            speakerEndX = e.changedTouches[0].clientX;
            const diff = speakerStartX - speakerEndX;
            if (Math.abs(diff) > 50) {
                if (diff > 0) {
                    nextSpeakerSlide();
                } else {
                    prevSpeakerSlide();
                }
            }
        });
        // Auto-play functionality
        let speakerAutoPlayInterval;
        function startSpeakerAutoPlay() {
            speakerAutoPlayInterval = setInterval(() => {
                const slidesPerView = getSpeakerSlidesPerView();
                const maxSlidesToShow = speakerMaxSlides - slidesPerView + 1;
                if (speakerCurrentSlide >= maxSlidesToShow) {
                    speakerCurrentSlide = 0;
                } else {
                    speakerCurrentSlide++;
                }
                updateSpeakerCarousel();
            }, 5000);
        }
        function stopSpeakerAutoPlay() {
            if (speakerAutoPlayInterval) {
                clearInterval(speakerAutoPlayInterval);
            }
        }
        // Start auto-play
        startSpeakerAutoPlay();
        // Pause auto-play on hover
        speakerCarousel.addEventListener('mouseenter', stopSpeakerAutoPlay);
        speakerCarousel.addEventListener('mouseleave', startSpeakerAutoPlay);
        // Handle window resize
        window.addEventListener('resize', () => {
            speakerCurrentSlide = 0;
            updateSpeakerCarousel();
        });
        // Initialize carousel
        updateSpeakerCarousel();
    }

    // Amplifier Carousel functionality
    const amplifierCarousel = document.getElementById('amplifier-carousel');
    const amplifierPrevBtn = document.getElementById('amplifier-carousel-prev');
    const amplifierNextBtn = document.getElementById('amplifier-carousel-next');
    const amplifierDotsContainer = document.getElementById('amplifier-carousel-dots');

    if (amplifierCarousel && amplifierPrevBtn && amplifierNextBtn && amplifierDotsContainer) {
        const amplifierSlides = amplifierCarousel.querySelectorAll('.product-slide');
        const amplifierSlideWidth = amplifierSlides[0]?.offsetWidth + 30; // Including gap
        let amplifierCurrentSlide = 0;
        const amplifierMaxSlides = amplifierSlides.length;

        function getAmplifierSlidesPerView() {
            if (window.innerWidth <= 480) return 1;
            if (window.innerWidth <= 768) return 1;
            if (window.innerWidth <= 1024) return 2;
            return 3;
        }

        // Create dots
        const amplifierTotalDots = Math.ceil(amplifierMaxSlides / getAmplifierSlidesPerView());
        for (let i = 0; i < amplifierTotalDots; i++) {
            const dot = document.createElement('div');
            dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
            dot.addEventListener('click', () => goToAmplifierSlide(i));
            amplifierDotsContainer.appendChild(dot);
        }

        function updateAmplifierCarousel() {
            const slidesPerView = getAmplifierSlidesPerView();
            const maxSlidesToShow = amplifierMaxSlides - slidesPerView + 1;
            const translateX = -amplifierCurrentSlide * amplifierSlideWidth;
            amplifierCarousel.style.transform = `translateX(${translateX}px)`;
            // Update dots
            const dots = amplifierDotsContainer.querySelectorAll('.carousel-dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === Math.floor(amplifierCurrentSlide / slidesPerView));
            });
            // Update buttons
            amplifierPrevBtn.disabled = amplifierCurrentSlide === 0;
            amplifierNextBtn.disabled = amplifierCurrentSlide >= maxSlidesToShow;
        }
        function goToAmplifierSlide(slideIndex) {
            const slidesPerView = getAmplifierSlidesPerView();
            amplifierCurrentSlide = slideIndex * slidesPerView;
            updateAmplifierCarousel();
        }
        function nextAmplifierSlide() {
            const slidesPerView = getAmplifierSlidesPerView();
            const maxSlidesToShow = amplifierMaxSlides - slidesPerView + 1;
            if (amplifierCurrentSlide < maxSlidesToShow) {
                amplifierCurrentSlide++;
                updateAmplifierCarousel();
            }
        }
        function prevAmplifierSlide() {
            if (amplifierCurrentSlide > 0) {
                amplifierCurrentSlide--;
                updateAmplifierCarousel();
            }
        }
        // Event listeners
        amplifierPrevBtn.addEventListener('click', prevAmplifierSlide);
        amplifierNextBtn.addEventListener('click', nextAmplifierSlide);
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                prevAmplifierSlide();
            } else if (e.key === 'ArrowRight') {
                nextAmplifierSlide();
            }
        });
        // Touch/swipe support for mobile
        let amplifierStartX = 0;
        let amplifierEndX = 0;
        amplifierCarousel.addEventListener('touchstart', (e) => {
            amplifierStartX = e.touches[0].clientX;
        });
        amplifierCarousel.addEventListener('touchend', (e) => {
            amplifierEndX = e.changedTouches[0].clientX;
            const diff = amplifierStartX - amplifierEndX;
            if (Math.abs(diff) > 50) {
                if (diff > 0) {
                    nextAmplifierSlide();
                } else {
                    prevAmplifierSlide();
                }
            }
        });
        // Auto-play functionality
        let amplifierAutoPlayInterval;
        function startAmplifierAutoPlay() {
            amplifierAutoPlayInterval = setInterval(() => {
                const slidesPerView = getAmplifierSlidesPerView();
                const maxSlidesToShow = amplifierMaxSlides - slidesPerView + 1;
                if (amplifierCurrentSlide >= maxSlidesToShow) {
                    amplifierCurrentSlide = 0;
                } else {
                    amplifierCurrentSlide++;
                }
                updateAmplifierCarousel();
            }, 5000);
        }
        function stopAmplifierAutoPlay() {
            if (amplifierAutoPlayInterval) {
                clearInterval(amplifierAutoPlayInterval);
            }
        }
        // Start auto-play
        startAmplifierAutoPlay();
        // Pause auto-play on hover
        amplifierCarousel.addEventListener('mouseenter', stopAmplifierAutoPlay);
        amplifierCarousel.addEventListener('mouseleave', startAmplifierAutoPlay);
        // Handle window resize
        window.addEventListener('resize', () => {
            amplifierCurrentSlide = 0;
            updateAmplifierCarousel();
        });
        // Initialize carousel
        updateAmplifierCarousel();
    }
    
    // Counter animation for About Section stats
    const statNumbers = document.querySelectorAll('.stat-number[data-count]');
    
    const animateCounter = (element) => {
        const target = parseInt(element.getAttribute('data-count'));
        const duration = 2000; // 2 seconds
        const step = target / (duration / 16); // 60fps
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current) + '+';
        }, 16);
    };
    
    // Intersection Observer for counter animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statNumber = entry.target;
                animateCounter(statNumber);
                observer.unobserve(statNumber);
            }
        });
    }, { threshold: 0.5 });
    
    statNumbers.forEach(statNumber => {
        observer.observe(statNumber);
    });
    
    // Brand info hover effect enhancement
    const brandInfo = document.querySelector('.about-brand-info');
    if (brandInfo) {
        brandInfo.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(0)';
        });
        
        brandInfo.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(100%)';
        });
    }
});
</script>

<?php get_footer(); ?> 