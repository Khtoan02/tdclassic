<?php
/**
 * The template for displaying single product posts
 */

get_header(); ?>

<main id="main" class="site-main product-page">
    <?php while (have_posts()) : the_post(); ?>
        <!-- Breadcrumb Section -->
        <section class="breadcrumb-section">
            <style>
                .breadcrumb-modern {
                    background: #f9f9fb;
                    border-radius: 8px;
                    box-shadow: 0 2px 8px 0 rgba(80,80,120,0.04);
                    padding: 2px 10px;
                    margin-bottom: 0.8rem;
                    overflow: hidden;
                    white-space: nowrap;
                    font-size: .95rem;
                }
                .breadcrumb-modern .breadcrumb-item + .breadcrumb-item::before {
                    content: '\203A';
                    color: #b3b3b3;
                    margin: 0 8px;
                    font-size: 1.1em;
                }
                .breadcrumb-modern .breadcrumb-item a {
                    color: #3471f7;
                    text-decoration: none;
                    transition: color 0.2s;
                }
                .breadcrumb-modern .breadcrumb-item a:hover {
                    text-decoration: underline;
                }
                .breadcrumb-modern .breadcrumb-item.active {
                    color: #21243d;
                    font-weight: 600;
                    display: inline-block;
                    max-width: 60vw;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    vertical-align: bottom;
                }
                @media (max-width:600px) {
                    .breadcrumb-modern {
                        padding: 2px 8px;
                        font-size: .92rem;
                    }
                }
            </style>
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-modern align-items-center m-0">
                        <?php 
                        $product_categories = get_the_terms(get_the_ID(), 'product_cat');
                        $main_category = null;
                        if ($product_categories && !is_wp_error($product_categories)) {
                            $main_category = $product_categories[0];
                        }
                        if ($main_category) : ?>
                            <li class="breadcrumb-item"><a href="<?php echo get_term_link($main_category); ?>"><?php echo $main_category->name; ?></a></li>
                        <?php else : ?>
                            <li class="breadcrumb-item"><a href="<?php echo home_url('/san-pham'); ?>">Sản phẩm</a></li>
                        <?php endif; ?>
                        <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
                    </ol>
                </nav>
            </div>
        </section>

        <!-- Enhanced Product Hero Section -->
        <div class="product-hero-section">
            <div class="hero-background-pattern"></div>
            <div class="container">
                <div class="row">
                    <!-- Product Images Gallery -->
                    <div class="col-lg-6">
                        <div class="product-gallery-wrapper">
                        <?php if (has_post_thumbnail()) : ?>
                                <!-- Main Product Image with thumbnail rail (mobile-first) -->
                                <div class="main-image-container mobile-two-col-gallery">
                                    <div class="product-badges">
                                        <span class="badge badge-premium">
                                            <i class="fas fa-crown"></i>
                                            <span>Premium</span>
                                        </span>
                                        <span class="badge badge-trusted">
                                            <i class="fas fa-shield-check"></i>
                                            <span>Tin cậy</span>
                                        </span>
                                        <span class="badge badge-authentic">
                                            <i class="fas fa-certificate"></i>
                                            <span>Chính hãng</span>
                                        </span>
                                    </div>
                                    
                                    <!-- Thumbnails rail (left) -->
                                    <div class="thumbs-rail">
                                        <?php
                                        $thumb_urls = array();
                                        $thumb_urls[] = get_the_post_thumbnail_url(get_the_ID(), 'large');
                                        $gallery_meta = get_post_meta(get_the_ID(), '_product_image_gallery', true);
                                        if (!empty($gallery_meta)) {
                                            $ids = array_filter(array_map('trim', explode(',', $gallery_meta)));
                                            foreach ($ids as $gid) {
                                                $u = wp_get_attachment_image_url($gid, 'large');
                                                if ($u) { $thumb_urls[] = $u; }
                                            }
                                        } else {
                                            $imgs = get_attached_media('image', get_the_ID());
                                            foreach ($imgs as $att) {
                                                $u = wp_get_attachment_image_url($att->ID, 'large');
                                                if ($u && !in_array($u, $thumb_urls, true)) { $thumb_urls[] = $u; }
                                            }
                                        }
                                        foreach ($thumb_urls as $i => $u) : ?>
                                            <button class="thumb-item<?php echo $i === 0 ? ' active' : ''; ?>" data-image="<?php echo esc_url($u); ?>" aria-label="Xem ảnh">
                                                <img src="<?php echo esc_url($u); ?>" alt="Thumb">
                                            </button>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="main-image-wrapper">
                                        <img src="<?php the_post_thumbnail_url('large'); ?>" 
                                             class="product-main-image" 
                                             alt="<?php the_title(); ?>"
                                             id="mainProductImage">
                                        
                                        <div class="image-overlay">
                                            <div class="overlay-actions">
                                                <button class="action-btn zoom-btn" data-bs-toggle="modal" data-bs-target="#imageModal" title="Phóng to hình ảnh">
                                                    <i class="fas fa-search-plus"></i>
                                                </button>
                                                <button class="action-btn fullscreen-btn" title="Xem toàn màn hình">
                                                    <i class="fas fa-expand"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Mobile Floating Actions -->
                                        <div class="mobile-floating-actions">
                                            <button class="floating-btn mobile-zoom-btn" title="Xem chi tiết">
                                                <i class="fas fa-search-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                        <?php endif; ?>
                        </div>
                            
                        <!-- Enhanced Quick Contact -->
                            <div class="enhanced-contact-section">
                                <div class="contact-section-header">
                                    <div class="header-content">
                                        <h4>Liên hệ ngay</h4>
                                        <div class="availability-indicator">
                                            <div class="status-dot"></div>
                                            <span>Sẵn sàng hỗ trợ</span>
                                        </div>
                                    </div>
                                    <div class="response-time">
                                        <i class="fas fa-clock"></i>
                                        <span>Phản hồi < 30 phút</span>
                                    </div>
                                </div>
                                
                                <div class="contact-methods-grid">
                                    <!-- Hotline Contact -->
                                    <a href="tel:<?php echo str_replace(' ', '', tdclassic_get_company_phone()); ?>" class="contact-method-card hotline-card">
                                        <div class="method-icon-wrapper">
                                            <div class="method-icon">
                                                <i class="fas fa-phone-volume"></i>
                                            </div>
                                            <div class="icon-badge">
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="method-content">
                                            <div class="method-title">Hotline 24/7</div>
                                            <div class="method-subtitle"><?php echo tdclassic_get_company_phone(); ?></div>
                                            <div class="method-description">Tư vấn trực tiếp với chuyên gia</div>
                                        </div>
                                        <div class="method-arrow">
                                            <i class="fas fa-arrow-right"></i>
                                        </div>
                                    </a>
                                    
                                    <!-- Zalo Contact -->
                                    <a href="https://zalo.me/<?php echo str_replace(' ', '', tdclassic_get_company_phone()); ?>" class="contact-method-card zalo-card" target="_blank">
                                        <div class="method-icon-wrapper">
                                            <div class="method-icon zalo-icon">
                                                <i class="fas fa-comments"></i>
                                            </div>
                                            <div class="icon-badge zalo-badge">
                                                <i class="fas fa-bolt"></i>
                                            </div>
                                        </div>
                                        <div class="method-content">
                                            <div class="method-title">Chat Zalo</div>
                                            <div class="method-subtitle"><?php echo tdclassic_get_company_phone(); ?></div>
                                            <div class="method-description">Nhắn tin nhanh, hỗ trợ ngay</div>
                                        </div>
                                        <div class="method-arrow">
                                            <i class="fas fa-external-link-alt"></i>
                                        </div>
                                    </a>
                                    
                                    <!-- Email Contact -->
                                    <a href="mailto:<?php echo tdclassic_get_company_email(); ?>" class="contact-method-card email-card">
                                        <div class="method-icon-wrapper">
                                            <div class="method-icon">
                                                <i class="fas fa-envelope-open-text"></i>
                                            </div>
                                            <div class="icon-badge">
                                                <i class="fas fa-check"></i>
                                            </div>
                                        </div>
                                        <div class="method-content">
                                            <div class="method-title">Email hỗ trợ</div>
                                            <div class="method-subtitle"><?php echo tdclassic_get_company_email(); ?></div>
                                            <div class="method-description">Gửi thông tin chi tiết dự án</div>
                                        </div>
                                        <div class="method-arrow">
                                            <i class="fas fa-paper-plane"></i>
                                        </div>
                                    </a>
                                </div>
                                
                                <div class="contact-footer">
                                    <div class="footer-info">
                                        <i class="fas fa-shield-check"></i>
                                        <span>Bảo mật thông tin 100% - Tư vấn miễn phí</span>
                                    </div>
                                </div>
                            </div>
                    </div>
                    
                    <!-- Enhanced Product Information -->
                    <div class="col-lg-6">
                        <div class="product-info">
                            
                            <!-- Rating then Title -->
                            <div class="title-section">
                                <div class="product-rating">
                                    <span class="product-header">
                            <?php
                            $product_categories = get_the_terms(get_the_ID(), 'product_cat');
                            if ($product_categories && !is_wp_error($product_categories)) :
                                $primary_category = $product_categories[0];
                            ?>
                            <div class="product-category">
                                <i class="fas fa-headphones-alt"></i>
                                <span><?php echo esc_html($primary_category->name); ?></span>
                            </div>
                            <?php else : ?>
                            <div class="product-category">
                                <i class="fas fa-headphones-alt"></i>
                                <span>Thiết bị âm thanh</span>
                            </div>
                            <?php endif; ?>
                            </span>
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    
                                    <span class="rating-text">(4.9/5 - 127 đánh giá)</span>
                                </div>
                                <h1 class="product-title"><?php the_title(); ?></h1>
                            </div>
                            
                            <!-- Product Description -->
                            <div class="product-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 35, '...'); ?>
                            </div>

                            <!-- Social Proof -->
                            <div class="social-proof">
                                <div class="proof-item">
                                    <i class="fas fa-users"></i>
                                    <span><strong>1,247</strong> khách hàng đã mua</span>
                                </div>
                                <div class="proof-item">
                                    <i class="fas fa-eye"></i>
                                    <span><strong>5,632</strong> lượt xem</span>
                                </div>
                                <div class="proof-item">
                                    <i class="fas fa-thumbs-up"></i>
                                    <span><strong>98.6</strong> % khách hàng hài lòng</span>
                                </div>
                            </div>

                            <!-- Key Features -->
                            <div class="key-features">
                                <h3>Điểm nổi bật</h3>
                                <div class="features-list">
                                    <?php 
                                    $key_features = get_post_meta(get_the_ID(), '_key_features', true);
                                    if ($key_features) :
                                        $features = explode("\n", $key_features);
                                        foreach ($features as $feature) :
                                            if (trim($feature)) :
                                    ?>
                                    <div class="feature-item">
                                        <i class="fas fa-check"></i>
                                        <span><?php echo esc_html(trim($feature)); ?></span>
                                    </div>
                                    <?php 
                                            endif;
                                        endforeach;
                                    else :
                                    ?>
                                    <div class="feature-item">
                                        <i class="fas fa-check"></i>
                                        <span>Công nghệ âm thanh tiên tiến</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-check"></i>
                                        <span>Thiết kế hiện đại, sang trọng</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-check"></i>
                                        <span>Chất lượng âm thanh vượt trội</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-check"></i>
                                        <span>Dễ dàng lắp đặt và sử dụng</span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            

                            <!-- Trust Statement for Large Projects -->
                            <div class="trust-statement">
                                <div class="statement-content">
                                    <div class="statement-icon">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div class="statement-text">
                                        <h4>Tin cậy cho các công trình lớn</h4>
                                        <p>Được tin dùng bởi hơn <strong>500+ dự án</strong> khách sạn, resort, trung tâm thương mại và các công trình quy mô lớn trên toàn quốc</p>
                                        <div class="statement-badges">
                                            <span class="mini-badge">Hotels & Resorts</span>
                                            <span class="mini-badge">Shopping Malls</span>
                                            <span class="mini-badge">Office Buildings</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Trust Indicators -->
                            <div class="trust-indicators">
                                <div class="trust-item">
                                    <i class="fas fa-certificate"></i>
                                    <span>Sản phẩm chính hãng 100%</span>
                                </div>
                                <div class="trust-item">
                                    <i class="fas fa-tags"></i>
                                    <span>Giá cả cạnh tranh nhất thị trường</span>
                                </div>
                                <div class="trust-item">
                                    <i class="fas fa-shipping-fast"></i>
                                    <span>Giao hàng nhanh toàn quốc</span>
                                </div>
                                <div class="trust-item">
                                    <i class="fas fa-tools"></i>
                                    <span>Hỗ trợ kỹ thuật 24/7</span>
                                </div>
                            </div>
                          
                                                    
                            <!-- Primary actions: Specs + Contact in one row -->
                            <div class="primary-actions">
                                <button class="btn btn-outline-dark specs-toggle" data-bs-toggle="modal" data-bs-target="#specsModal">
                                    <i class="fas fa-list-ul me-2"></i>
                                    Xem thông số kỹ thuật
                                </button>
                                <button class="btn btn-dark contact-consultation-btn" data-bs-toggle="modal" data-bs-target="#consultationModal">
                                    <i class="fas fa-headset me-2"></i>
                                    Liên hệ tư vấn & báo giá
                                </button>
                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        

        <!-- Audio Solutions Section -->
        <section class="audio-solutions-section">
            <div class="container">
                <div class="section-header text-center">
                    <div class="section-badge">
                        <i class="fas fa-cogs"></i>
                        <span>Giải pháp âm thanh</span>
                    </div>
                    <h2 class="section-title">Giải pháp âm thanh tối ưu cho mọi nhu cầu</h2>
                    <p class="section-description">
                        Chúng tôi cung cấp các giải pháp âm thanh chuyên nghiệp, phù hợp với mọi nhu cầu từ cá nhân đến doanh nghiệp
                    </p>
                </div>
                
                <div class="solutions-grid">
                    <div class="solution-card">
                        <div class="solution-image">
                            <img src="https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Âm thanh chất lượng cao">
                            <div class="solution-overlay">
                                <div class="solution-icon">
                                    <i class="fas fa-volume-up"></i>
                                </div>
                            </div>
                        </div>
                        <div class="solution-content">
                            <h3>Âm thanh chất lượng cao</h3>
                            <p>Công nghệ âm thanh tiên tiến, cho chất lượng âm thanh sống động và chân thực nhất.</p>
                            <ul class="solution-features">
                                <li><i class="fas fa-check"></i> Chất lượng âm thanh Hi-Fi</li>
                                <li><i class="fas fa-check"></i> Công nghệ chống nhiễu tiên tiến</li>
                                <li><i class="fas fa-check"></i> Tương thích đa thiết bị</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="solution-card">
                        <div class="solution-image">
                            <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Dễ dàng cài đặt">
                            <div class="solution-overlay">
                                <div class="solution-icon">
                                    <i class="fas fa-cogs"></i>
                                </div>
                            </div>
                        </div>
                        <div class="solution-content">
                            <h3>Dễ dàng cài đặt</h3>
                            <p>Thiết kế thông minh, dễ dàng lắp đặt và sử dụng ngay cả với người không chuyên.</p>
                            <ul class="solution-features">
                                <li><i class="fas fa-check"></i> Hướng dẫn chi tiết từng bước</li>
                                <li><i class="fas fa-check"></i> Hỗ trợ kỹ thuật 24/7</li>
                                <li><i class="fas fa-check"></i> Cài đặt tại nhà miễn phí</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="solution-card">
                        <div class="solution-image">
                            <img src="https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Bền bỉ theo thời gian">
                            <div class="solution-overlay">
                                <div class="solution-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                            </div>
                        </div>
                        <div class="solution-content">
                            <h3>Bền bỉ theo thời gian</h3>
                            <p>Vật liệu cao cấp, thiết kế chắc chắn đảm bảo độ bền và tuổi thọ sản phẩm.</p>
                            <ul class="solution-features">
                                <li><i class="fas fa-check"></i> Vật liệu cao cấp chống ăn mòn</li>
                                <li><i class="fas fa-check"></i> Bảo hành lên đến 24 tháng</li>
                                <li><i class="fas fa-check"></i> Bảo trì định kỳ miễn phí</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="solutions-stats">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Dự án hoàn thành</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">98%</div>
                        <div class="stat-label">Khách hàng hài lòng</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Hỗ trợ kỹ thuật</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">15+</div>
                        <div class="stat-label">Năm kinh nghiệm</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Latest News Section -->
        <section class="latest-news-section">
            <div class="container">
                <div class="section-header text-center">
                    <div class="section-badge">
                        <i class="fas fa-newspaper"></i>
                        <span>Tin tức & Kiến thức</span>
                    </div>
                    <h2 class="section-title">Cập nhật thông tin mới nhất</h2>
                    <p class="section-description">
                        Những thông tin hữu ích về công nghệ âm thanh và xu hướng mới nhất trong ngành
                    </p>
                </div>
                
                <?php
                // Get latest blog posts
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'meta_query' => array(
                        array(
                            'key' => '_thumbnail_id',
                            'compare' => 'EXISTS'
                        )
                    )
                );
                
                $latest_posts = new WP_Query($args);
                
                if ($latest_posts->have_posts()) : ?>
                    <div class="articles-grid">
                        <?php while ($latest_posts->have_posts()) : $latest_posts->the_post(); ?>
                            <article class="article-card">
                                <div class="article-image">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="<?php the_title(); ?>" loading="lazy">
                                    <?php else : ?>
                                        <div class="article-placeholder">
                                            <i class="fas fa-newspaper"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="article-overlay">
                                        <div class="article-date">
                                            <span class="day"><?php echo get_the_date('d'); ?></span>
                                            <span class="month"><?php echo get_the_date('M'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="article-content">
                                    <div class="article-meta">
                                        <span class="article-category">
                                            <?php
                                            $categories = get_the_category();
                                            if ($categories) {
                                                echo $categories[0]->name;
                                            }
                                            ?>
                                        </span>
                                        <span class="article-read-time">
                                            <i class="fas fa-clock"></i>
                                            <?php echo rand(3, 8); ?> phút đọc
                                        </span>
                                    </div>
                                    
                                    <h3 class="article-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    
                                    <p class="article-excerpt">
                                        <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                    </p>
                                    
                                    <div class="article-footer">
                                        <div class="article-author">
                                            <i class="fas fa-user"></i>
                                            <span><?php the_author(); ?></span>
                                        </div>
                                        <a href="<?php the_permalink(); ?>" class="article-read-more">
                                            <span>Đọc tiếp</span>
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    
                    <div class="news-cta text-center">
                        <a href="<?php echo esc_url(home_url('/tin-tuc')); ?>" class="btn-primary">
                            <i class="fas fa-newspaper"></i>
                            <span>Xem tất cả tin tức</span>
                        </a>
                    </div>
                <?php
                    wp_reset_postdata();
                else :
                ?>
                    <div class="no-posts-wrapper">
                        <div class="no-posts-content">
                            <div class="no-posts-icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <h3>Chưa có bài viết nào</h3>
                            <p>Hiện tại chúng tôi chưa có bài viết nào để hiển thị.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        

        <!-- Other Products Section -->
        <section class="other-products-section">
            <div class="container">
                <div class="section-header">
                    <h2>Các sản phẩm khác</h2>
                    <p>Khám phá thêm các sản phẩm âm thanh chất lượng cao</p>
                </div>
                
                <div class="products-container">
                    <?php
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 4,
                        'post__not_in' => array(get_the_ID()),
                        'orderby' => 'rand'
                    );
                    
                    $other_products = new WP_Query($args);
                    
                    if ($other_products->have_posts()) :
                        while ($other_products->have_posts()) : $other_products->the_post();
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
                                            <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>" loading="lazy">
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
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </section>


        <!-- Simplified Image Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php the_title(); ?> - Hình ảnh sản phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="image-gallery-modal">
                            <div class="main-modal-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php the_post_thumbnail_url('full'); ?>" class="img-fluid" alt="<?php the_title(); ?>" id="modalMainImage">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Specifications Modal -->
        <div class="modal fade" id="specsModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thông số kỹ thuật - <?php the_title(); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                                        <div class="modal-body">
                        <div class="specifications-content">
                            <div class="specs-grid">
                                <!-- Basic Information -->
                                <div class="spec-category">
                                    <h6>Thông số cơ bản</h6>
                                    <div class="spec-item">
                                        <span class="spec-label">Thương hiệu:</span>
                                        <span class="spec-value">TD Classic</span>
                                    </div>
                                    <?php 
                                    $product_model = get_post_meta(get_the_ID(), '_product_model', true);
                                    if ($product_model) :
                                    ?>
                                    <div class="spec-item">
                                        <span class="spec-label">Model:</span>
                                        <span class="spec-value"><?php echo esc_html($product_model); ?></span>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php 
                                    $product_weight = get_post_meta(get_the_ID(), '_product_weight', true);
                                    if ($product_weight) :
                                    ?>
                                    <div class="spec-item">
                                        <span class="spec-label">Trọng lượng:</span>
                                        <span class="spec-value"><?php echo esc_html($product_weight); ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Custom Technical Specifications -->
                                <?php 
                                $custom_specs = get_post_meta(get_the_ID(), '_custom_specifications', true);
                                if ($custom_specs) :
                                    $specs_array = json_decode($custom_specs, true);
                                    if ($specs_array && is_array($specs_array) && count($specs_array) > 0) :
                                ?>
                                <div class="spec-category">
                                    <h6>Thông số kỹ thuật</h6>
                                    <?php foreach ($specs_array as $spec) : ?>
                                        <div class="spec-item">
                                            <span class="spec-label"><?php echo esc_html($spec['label']); ?>:</span>
                                            <span class="spec-value"><?php echo esc_html($spec['value']); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; endif; ?>

                                <!-- Warranty & Support -->
                                <div class="spec-category">
                                    <h6>Bảo hành & Hỗ trợ</h6>
                                    <div class="spec-item">
                                        <span class="spec-label">Bảo hành:</span>
                                        <span class="spec-value">12-24 tháng chính hãng</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="spec-label">Hỗ trợ kỹ thuật:</span>
                                        <span class="spec-value">24/7</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Additional Description -->
                            <?php 
                            $additional_specs = get_post_meta(get_the_ID(), '_product_specifications', true);
                            if ($additional_specs) :
                            ?>
                            <div class="additional-description">
                                <h6>Thông tin bổ sung</h6>
                                <div class="description-content">
                                    <?php echo wp_kses_post($additional_specs); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary specs-contact-btn" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#consultationModal">Liên hệ tư vấn</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Consultation & Quote Modal -->
        <div class="modal fade" id="consultationModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content consultation-modal-content">
                    <!-- Enhanced Header -->
                    <div class="modal-header consultation-header">
                        <div class="header-content">
                            <div class="header-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="header-text">
                                <h4 class="modal-title mb-1">Tư vấn & Báo giá miễn phí</h4>
                                <p class="product-name mb-0"><?php the_title(); ?></p>
                            </div>
                        </div>
                        <button type="button" class="btn-close consultation-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                                        <div class="modal-body consultation-body">
                        <!-- Enhanced Intro Section -->
                        <div class="consultation-intro-enhanced">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="intro-content-enhanced">
                                        <h5 class="intro-title">
                                            <i class="fas fa-star text-warning me-2"></i>
                                            Tư vấn miễn phí từ chuyên gia
                                        </h5>
                                        <p class="intro-description">
                                            Đội ngũ kỹ sư âm thanh với <strong>10+ năm kinh nghiệm</strong> sẽ tư vấn giải pháp tối ưu cho dự án của bạn
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="intro-features">
                                        <div class="feature-badge">
                                            <i class="fas fa-clock text-primary"></i>
                                            <span>Phản hồi 30 phút</span>
                                        </div>
                                        <div class="feature-badge">
                                            <i class="fas fa-shield-alt text-success"></i>
                                            <span>Cam kết chất lượng</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form id="consultationForm" class="consultation-form-enhanced">
                                                        <input type="hidden" name="product_id" value="<?php echo get_the_ID(); ?>">
                            <input type="hidden" name="product_name" value="<?php the_title(); ?>">
                            
                            <!-- Personal Information Section -->
                            <div class="form-section mb-4">
                                <h6 class="section-title">
                                    <i class="fas fa-user me-2"></i>
                                    Thông tin liên hệ
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control enhanced-input" id="consultName" name="customer_name" placeholder="Nhập họ và tên" required>
                                            <label for="consultName">
                                                <i class="fas fa-user me-1"></i>
                                                Họ và tên *
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control enhanced-input" id="consultPhone" name="customer_phone" placeholder="Nhập số điện thoại" required>
                                            <label for="consultPhone">
                                                <i class="fas fa-phone me-1"></i>
                                                Số điện thoại *
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="email" class="form-control enhanced-input" id="consultEmail" name="customer_email" placeholder="Nhập email">
                                            <label for="consultEmail">
                                                <i class="fas fa-envelope me-1"></i>
                                                Email
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control enhanced-input" id="consultCompany" name="company_name" placeholder="Nhập tên công ty">
                                            <label for="consultCompany">
                                                <i class="fas fa-building me-1"></i>
                                                Công ty/Tổ chức
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Project Details Section -->
                            <div class="form-section mb-4">
                                <h6 class="section-title">
                                    <i class="fas fa-project-diagram me-2"></i>
                                    Chi tiết dự án
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="projectType" class="form-label enhanced-label">
                                            <i class="fas fa-building me-1"></i>
                                            Loại dự án
                                        </label>
                                        <div class="select-wrapper">
                                            <select class="form-control enhanced-select" id="projectType" name="project_type">
                                                <option value="">Chọn loại dự án</option>
                                                <option value="home">🏠 Gia đình/Cá nhân</option>
                                                <option value="office">🏢 Văn phòng</option>
                                                <option value="restaurant">🍽️ Nhà hàng/Cafe</option>
                                                <option value="hotel">🏨 Khách sạn/Resort</option>
                                                <option value="retail">🏪 Cửa hàng/Showroom</option>
                                                <option value="mall">🏬 Trung tâm thương mại</option>
                                                <option value="other">📋 Khác</option>
                                            </select>
                                            <i class="fas fa-chevron-down select-arrow"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="projectBudget" class="form-label enhanced-label">
                                            <i class="fas fa-dollar-sign me-1"></i>
                                            Ngân sách dự kiến
                                        </label>
                                        <div class="select-wrapper">
                                            <select class="form-control enhanced-select" id="projectBudget" name="project_budget">
                                                <option value="">Chọn mức ngân sách</option>
                                                <option value="under-50m">💰 Dưới 50 triệu</option>
                                                <option value="50m-100m">💰 50 - 100 triệu</option>
                                                <option value="100m-500m">💰 100 - 500 triệu</option>
                                                <option value="500m-1b">💰 500 triệu - 1 tỷ</option>
                                                <option value="over-1b">💰 Trên 1 tỷ</option>
                                                <option value="discuss">💬 Thảo luận trực tiếp</option>
                                            </select>
                                            <i class="fas fa-chevron-down select-arrow"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <textarea class="form-control enhanced-textarea" id="consultAddress" name="project_address" placeholder="Nhập địa chỉ dự án" style="height: 80px;"></textarea>
                                        <label for="consultAddress">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            Địa chỉ dự án
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Consultation Needs Section -->
                            <div class="form-section mb-4">
                                <h6 class="section-title">
                                    <i class="fas fa-tasks me-2"></i>
                                    Nhu cầu tư vấn
                                </h6>
                                <div class="consultation-options-enhanced">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="need-card">
                                                <input class="need-checkbox" type="checkbox" id="needQuote" name="needs[]" value="quote">
                                                <label class="need-label" for="needQuote">
                                                    <div class="need-icon">
                                                        <i class="fas fa-calculator"></i>
                                                    </div>
                                                    <div class="need-content">
                                                        <h6 class="need-title">Báo giá chi tiết</h6>
                                                        <p class="need-desc">Nhận báo giá chính xác cho dự án</p>
                                                    </div>
                                                    <div class="need-check">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="need-card">
                                                <input class="need-checkbox" type="checkbox" id="needDesign" name="needs[]" value="design">
                                                <label class="need-label" for="needDesign">
                                                    <div class="need-icon">
                                                        <i class="fas fa-drafting-compass"></i>
                                                    </div>
                                                    <div class="need-content">
                                                        <h6 class="need-title">Thiết kế hệ thống</h6>
                                                        <p class="need-desc">Tư vấn thiết kế âm thanh tối ưu</p>
                                                    </div>
                                                    <div class="need-check">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="need-card">
                                                <input class="need-checkbox" type="checkbox" id="needInstall" name="needs[]" value="install">
                                                <label class="need-label" for="needInstall">
                                                    <div class="need-icon">
                                                        <i class="fas fa-tools"></i>
                                                    </div>
                                                    <div class="need-content">
                                                        <h6 class="need-title">Tư vấn lắp đặt</h6>
                                                        <p class="need-desc">Hướng dẫn lắp đặt chuyên nghiệp</p>
                                                    </div>
                                                    <div class="need-check">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="need-card">
                                                <input class="need-checkbox" type="checkbox" id="needDemo" name="needs[]" value="demo">
                                                <label class="need-label" for="needDemo">
                                                    <div class="need-icon">
                                                        <i class="fas fa-play-circle"></i>
                                                    </div>
                                                    <div class="need-content">
                                                        <h6 class="need-title">Demo sản phẩm</h6>
                                                        <p class="need-desc">Trải nghiệm sản phẩm trực tiếp</p>
                                                    </div>
                                                    <div class="need-check">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="form-floating">
                                        <textarea class="form-control enhanced-textarea" id="projectNote" name="project_note" placeholder="Mô tả chi tiết về dự án" style="height: 100px;"></textarea>
                                        <label for="projectNote">
                                            <i class="fas fa-edit me-1"></i>
                                            Mô tả chi tiết dự án
                                        </label>
                                    </div>
                                    <small class="form-text text-muted mt-1">
                                        Ví dụ: không gian, yêu cầu âm thanh, thời gian triển khai...
                                    </small>
                                </div>
                            </div>

                            <!-- Enhanced Promise Section -->
                            <div class="consultation-promise-enhanced">
                                <div class="promise-header">
                                    <h6 class="promise-title">
                                        <i class="fas fa-shield-alt me-2"></i>
                                        Cam kết của chúng tôi
                                    </h6>
                                    </div>
                                <div class="promise-grid">
                                    <div class="promise-item-enhanced">
                                        <div class="promise-icon">
                                            <i class="fas fa-clock"></i>
                                    </div>
                                        <div class="promise-content">
                                            <h6>Phản hồi nhanh</h6>
                                            <p>Trong vòng 30 phút</p>
                                        </div>
                                    </div>
                                    <div class="promise-item-enhanced">
                                        <div class="promise-icon">
                                            <i class="fas fa-user-graduate"></i>
                                        </div>
                                        <div class="promise-content">
                                            <h6>Chuyên gia tư vấn</h6>
                                            <p>10+ năm kinh nghiệm</p>
                                        </div>
                                    </div>
                                    <div class="promise-item-enhanced">
                                        <div class="promise-icon">
                                            <i class="fas fa-gift"></i>
                                        </div>
                                        <div class="promise-content">
                                            <h6>Miễn phí khảo sát</h6>
                                            <p>Tận nơi cho dự án lớn</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                                        <!-- Simple Modal Footer -->
                    <div class="modal-footer consultation-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>
                            Đóng
                        </button>
                        <button type="button" class="btn btn-success btn-lg" id="submitConsultation">
                            <i class="fas fa-paper-plane me-2"></i>
                            Gửi yêu cầu tư vấn
                        </button>
                    </div>
                </div>
            </div>
        </div>

    <?php endwhile; ?>
</main>

<script>
// Add JavaScript for consultation button functionality
document.addEventListener('DOMContentLoaded', function() {
    const consultationBtn = document.querySelector('.contact-consultation-btn');
    if (consultationBtn) {
        consultationBtn.addEventListener('click', function() {
            const consultationModal = new bootstrap.Modal(document.getElementById('consultationModal'));
            consultationModal.show();
        });
    }
    // Thumbnail -> main image swap (mobile gallery)
    const mainImg = document.getElementById('mainProductImage');
    const thumbBtns = document.querySelectorAll('.thumb-item');
    if (mainImg && thumbBtns.length) {
        thumbBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const url = this.getAttribute('data-image');
                if (url) {
                    mainImg.setAttribute('src', url);
                    document.querySelectorAll('.thumb-item.active').forEach(el => el.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });
    }
    
    // Add nonce for AJAX security
    window.consultationNonce = '<?php echo wp_create_nonce("consultation_nonce"); ?>';
});

// Product filtering and search functionality
document.addEventListener('DOMContentLoaded', function() {
    // Products Grid filtering
    const filterItems = document.querySelectorAll('.products-grid-section .filter-tab');
    const productCards = document.querySelectorAll('.products-grid-section .product-card');
    const searchInput = document.getElementById('related-product-search');
    
    // Filter functionality
    if (filterItems.length > 0) {
        filterItems.forEach(item => {
            item.addEventListener('click', function() {
                const filter = this.dataset.filter;
                
                // Update active filter
                filterItems.forEach(f => f.classList.remove('active'));
                this.classList.add('active');
                
                // Filter products
                productCards.forEach(card => {
                    const cardParent = card.parentElement || card;
                    if (filter === 'all' || card.dataset.filter === filter || card.classList.contains('category-' + filter)) {
                        cardParent.style.display = 'block';
                        setTimeout(() => {
                            cardParent.style.opacity = '1';
                            cardParent.style.transform = 'translateY(0)';
                        }, 10);
                    } else {
                        cardParent.style.opacity = '0';
                        cardParent.style.transform = 'translateY(20px)';
                        setTimeout(() => cardParent.style.display = 'none', 300);
                    }
                });
            });
        });
    }
    
    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            
            productCards.forEach(card => {
                const cardParent = card.parentElement || card;
                const title = card.dataset.title || '';
                const content = card.textContent.toLowerCase();
                
                if (searchTerm === '' || title.includes(searchTerm) || content.includes(searchTerm)) {
                    cardParent.style.display = 'block';
                    setTimeout(() => {
                        cardParent.style.opacity = '1';
                        cardParent.style.transform = 'translateY(0)';
                    }, 10);
                } else {
                    cardParent.style.opacity = '0';
                    cardParent.style.transform = 'translateY(20px)';
                    setTimeout(() => cardParent.style.display = 'none', 300);
                }
            });
        });
    }
    
    // Solution cards hover effects
    const solutionCards = document.querySelectorAll('.solution-card');
    solutionCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Article cards animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe article cards
    const articleCards = document.querySelectorAll('.article-card');
    articleCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });
    
    // Stats counter animation
    const statNumbers = document.querySelectorAll('.stat-number');
    const statsObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const finalNumber = target.textContent.replace(/[^0-9]/g, '');
                const suffix = target.textContent.replace(/[0-9]/g, '');
                
                if (finalNumber) {
                    animateCounter(target, 0, parseInt(finalNumber), suffix, 2000);
                }
                statsObserver.unobserve(target);
            }
        });
    }, observerOptions);
    
    statNumbers.forEach(stat => {
        statsObserver.observe(stat);
    });
    
    function animateCounter(element, start, end, suffix, duration) {
        const range = end - start;
        const increment = range / (duration / 16);
        let current = start;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= end) {
                current = end;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current) + suffix;
        }, 16);
    }
});
</script>

<?php
// Enqueue enhanced consultation modal styles
wp_enqueue_style('consultation-modal-enhanced', get_template_directory_uri() . '/assets/css/consultation-modal-enhanced.css', array(), '1.0.0');
?>

<?php get_footer(); ?> 