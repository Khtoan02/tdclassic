<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="error-404-page">
            <div class="container">
                <div class="error-content">
                    <!-- 404 Animation Container -->
                    <div class="error-animation">
                        <div class="error-gif-container">
                            <!-- Placeholder cho GIF 404 - bạn có thể thay thế bằng URL GIF thực tế -->
                            <div class="error-gif-placeholder">
                                <div class="error-number">404</div>
                                <div class="error-animation-dots">
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                </div>
                            </div>
                            <!-- Uncomment và thay thế URL GIF thực tế -->
                            <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/images/404-animation.gif" alt="404 Animation" class="error-gif"> -->
                        </div>
                    </div>

                    <!-- Error Message -->
                    <div class="error-message">
                        <h1 class="error-title">Rất tiếc, không tìm thấy trang</h1>
                        <p class="error-description">
                            Trang bạn đang tìm kiếm có thể đã bị di chuyển, xóa hoặc không tồn tại.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="error-actions">
                        <a href="<?php echo home_url('/'); ?>" class="btn btn-primary btn-home">
                            <i class="fas fa-home me-2"></i>
                            Quay về trang chủ
                        </a>
                        
                        <div class="error-links">
                            <a href="<?php echo home_url('/san-pham'); ?>" class="btn btn-outline-dark">
                                <i class="fas fa-box me-2"></i>
                                Xem sản phẩm
                            </a>
                            <a href="<?php echo home_url('/blog'); ?>" class="btn btn-outline-dark">
                                <i class="fas fa-newspaper me-2"></i>
                                Đọc tin tức
                            </a>
                            <a href="<?php echo home_url('/lien-he'); ?>" class="btn btn-outline-dark">
                                <i class="fas fa-envelope me-2"></i>
                                Liên hệ
                            </a>
                        </div>
                    </div>

                    <!-- Search Section -->
                    <div class="error-search">
                        <h3>Tìm kiếm nội dung</h3>
                        <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                            <div class="search-input-group">
                                <input type="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo get_search_query(); ?>" name="s">
                                <button type="submit" class="btn btn-dark">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
/* 404 Page Styles */
.error-404-page {
    max-height: 40vh;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    padding: 4rem 0;
}

.error-content {
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}

/* Animation Container */
.error-animation {
    margin-bottom: 3rem;
}

.error-gif-container {
    position: relative;
    display: inline-block;
    margin-bottom: 2rem;
}

.error-gif-placeholder {
    width: 300px;
    height: 200px;
    background: linear-gradient(135deg, #000 0%, #333 100%);
    border-radius: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.error-number {
    font-size: 4rem;
    font-weight: 700;
    color: #fff;
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    margin-bottom: 1rem;
    animation: errorPulse 2s ease-in-out infinite;
}

.error-animation-dots {
    display: flex;
    gap: 0.5rem;
}

.dot {
    width: 12px;
    height: 12px;
    background: #fff;
    border-radius: 50%;
    animation: dotBounce 1.5s ease-in-out infinite;
}

.dot:nth-child(2) {
    animation-delay: 0.2s;
}

.dot:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes errorPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

@keyframes dotBounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.error-gif {
    max-width: 100%;
    height: auto;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

/* Error Message */
.error-message {
    margin-bottom: 3rem;
}

.error-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #000;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.error-description {
    font-size: 1.1rem;
    color: #666;
    max-width: 500px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Action Buttons */
.error-actions {
    margin-bottom: 3rem;
}

.btn-home {
    font-size: 1.1rem;
    padding: 1rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.btn-home:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.error-links {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.error-links .btn {
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.error-links .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Search Section */
.error-search {
    background: #fff;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    border: 1px solid #e9ecef;
}

.error-search h3 {
    font-size: 1.5rem;
    color: #000;
    margin-bottom: 1.5rem;
    font-weight: 600;
}

.search-input-group {
    display: flex;
    max-width: 400px;
    margin: 0 auto;
    border-radius: 50px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.search-input-group .form-control {
    border: none;
    padding: 1rem 1.5rem;
    font-size: 1rem;
    border-radius: 0;
    flex: 1;
}

.search-input-group .form-control:focus {
    box-shadow: none;
    outline: none;
}

.search-input-group .btn {
    border: none;
    padding: 1rem 1.5rem;
    background: #000;
    color: #fff;
    border-radius: 0;
    transition: all 0.3s ease;
}

.search-input-group .btn:hover {
    background: #333;
}

/* Responsive Design */
@media (max-width: 768px) {
    .error-404-page {
        padding: 2rem 0;
        max-height: 40vh;
    }
    
    .error-title {
        font-size: 2rem;
    }
    
    .error-description {
        font-size: 1rem;
    }
    
    .error-gif-placeholder {
        width: 250px;
        height: 150px;
    }
    
    .error-number {
        font-size: 3rem;
    }
    
    .error-links {
        flex-direction: column;
        align-items: center;
    }
    
    .error-links .btn {
        width: 100%;
        max-width: 250px;
    }
    
    .search-input-group {
        flex-direction: column;
        border-radius: 15px;
    }
    
    .search-input-group .form-control,
    .search-input-group .btn {
        border-radius: 0;
    }
    
    .search-input-group .form-control {
        border-radius: 15px 15px 0 0;
    }
    
    .search-input-group .btn {
        border-radius: 0 0 15px 15px;
    }
}

@media (max-width: 480px) {
    .error-title {
        font-size: 1.75rem;
    }
    
    .error-gif-placeholder {
        width: 200px;
        height: 120px;
    }
    
    .error-number {
        font-size: 2.5rem;
    }
    
    .btn-home {
        font-size: 1rem;
        padding: 0.875rem 1.75rem;
    }
}

/* Animation for page load */
.error-content {
    animation: fadeInUp 0.8s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Hover effects */
.error-gif-placeholder:hover {
    transform: scale(1.02);
    transition: transform 0.3s ease;
}

.error-search:hover {
    transform: translateY(-2px);
    transition: transform 0.3s ease;
}
</style>

<?php get_footer(); ?> 