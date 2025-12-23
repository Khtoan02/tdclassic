<?php
/**
 * The front page template file
 *
 * @package TD Classic
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <!-- Hero Section - Hình ảnh + Danh mục sản phẩm -->
        <section class="hero-section">
            <div class="hero-background">
                <div class="hero-background-image" data-bg-image="https://www.hifivietnam.vn/wp-content/uploads/2024/05/hfvn-nhahathoguom-5.webp"></div>
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
        <section class="featured-products-section">
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

<?php get_footer(); ?> 