<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="error-404-page">
            <div class="container">
                <div class="error-content">
                    <!-- 404 Animation Container -->
                    <div class="error-animation">
                        <div class="error-gif-container">
                            <!-- Placeholder TD Classic style -->
                            <div class="error-gif-placeholder">
                                <div class="error-number">404</div>
                                <div class="td-classic-icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/td-classic-icon.svg" alt="TD Classic" width="48" height="48" />
                                </div>
                                <div class="error-animation-dots">
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Error Message -->
                    <div class="error-message">
                        <h1 class="error-title">Không tìm thấy trang</h1>
                        <p class="error-description">
                            Trang bạn truy cập không tồn tại hoặc đã bị xóa.<br>
                            Vui lòng kiểm tra lại đường dẫn hoặc sử dụng các lựa chọn bên dưới.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="error-actions">
                        <a href="<?php echo home_url('/'); ?>" class="btn btn-home">
                            <i class="fas fa-home me-1"></i>
                            Trang chủ
                        </a>
                        <div class="error-links">
                            <a href="<?php echo home_url('/san-pham'); ?>" class="btn btn-outline-dark">
                                <i class="fas fa-box me-1"></i>
                                Sản phẩm
                            </a>
                            <a href="<?php echo home_url('/blog'); ?>" class="btn btn-outline-dark">
                                <i class="fas fa-newspaper me-1"></i>
                                Tin tức
                            </a>
                            <a href="<?php echo home_url('/lien-he'); ?>" class="btn btn-outline-dark">
                                <i class="fas fa-envelope me-1"></i>
                                Liên hệ
                            </a>
                        </div>
                    </div>

                    <!-- Search Section -->
                    <div class="error-search">
                        <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                            <div class="search-input-group">
                                <input type="search" class="form-control" placeholder="Tìm kiếm..." value="<?php echo get_search_query(); ?>" name="s" aria-label="Tìm kiếm">
                                <button type="submit" class="btn btn-dark" aria-label="Tìm kiếm">
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
    min-height: 60vh;
    display: flex;
    align-items: center;
    background: #181818;
    padding: 2rem 0;
}
.error-content {
    text-align: center;
    max-width: 480px;
    margin: 0 auto;
    background: #222;
    border-radius: 18px;
    padding: 2rem 1.2rem 1.5rem 1.2rem;
    box-shadow: 0 2px 16px rgba(0,0,0,0.12);
    color: #fff;
    animation: fadeInUp 0.7s;
}
.error-animation {
    margin-bottom: 1.2rem;
}
.error-gif-container {
    display: flex;
    justify-content: center;
    margin-bottom: 0.8rem;
}
.error-gif-placeholder {
    width: 180px;
    height: 120px;
    background: linear-gradient(135deg, #232323 0%, #444 100%);
    border-radius: 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.18);
    margin-bottom: 0.2rem;
    gap: 0.2rem;
}
.error-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #fff;
    text-shadow: 0 2px 8px rgba(0,0,0,0.25);
    margin-bottom: 0.2rem;
    animation: errorPulse 2s ease-in-out infinite;
    letter-spacing: 2px;
}
.bat-trang-icon {
    margin-bottom: 0.2rem;
}
.error-animation-dots {
    display: flex;
    gap: 0.25rem;
}
.dot {
    width: 8px;
    height: 8px;
    background: #fff;
    border-radius: 50%;
    animation: dotBounce 1.5s ease-in-out infinite;
}
.dot:nth-child(2) { animation-delay: 0.18s; }
.dot:nth-child(3) { animation-delay: 0.36s; }
@keyframes errorPulse {
    0%, 100% { transform: scale(1);}
    50% { transform: scale(1.07);}
}
@keyframes dotBounce {
    0%, 100% { transform: translateY(0);}
    50% { transform: translateY(-7px);}
}
.error-message {
    margin-bottom: 1.1rem;
}
.error-title {
    font-size: 1.45rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 0.3rem;
    line-height: 1.2;
    letter-spacing: 0.5px;
}
.error-description {
    font-size: 1rem;
    color: #bbb;
    margin: 0 auto;
    line-height: 1.5;
    max-width: 340px;
}
.error-actions {
    margin-bottom: 1.1rem;
}
.btn-home {
    font-size: 1rem;
    padding: 0.6rem 1.2rem;
    border-radius: 24px;
    font-weight: 600;
    background: #111;
    color: #fff;
    border: none;
    margin-bottom: 0.7rem;
    margin-right: 0.2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: background 0.2s, color 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}
.btn-home:hover, .btn-home:focus {
    background: #333;
    color: #fff;
    text-decoration: none;
}
.error-links {
    display: flex;
    justify-content: center;
    gap: 0.3rem;
    flex-wrap: wrap;
}
.error-links .btn {
    padding: 0.5rem 1.1rem;
    border-radius: 18px;
    font-weight: 500;
    font-size: 0.98rem;
    background: transparent;
    color: #fff;
    border: 1px solid #444;
    transition: background 0.2s, color 0.2s, border 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    margin-bottom: 0.2rem;
}
.error-links .btn:hover, .error-links .btn:focus {
    background: #333;
    color: #fff;
    border-color: #222;
    text-decoration: none;
}
.error-search {
    background: #191919;
    padding: 1rem 0.7rem 0.7rem 0.7rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    border: 1px solid #232323;
    margin-top: 0.5rem;
}
.search-input-group {
    display: flex;
    max-width: 320px;
    margin: 0 auto;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    background: #232323;
}
.search-input-group .form-control {
    border: none;
    padding: 0.6rem 1rem;
    font-size: 1rem;
    border-radius: 0;
    flex: 1;
    background: #232323;
    color: #fff;
}
.search-input-group .form-control:focus {
    box-shadow: none;
    outline: none;
    background: #232323;
    color: #fff;
}
.search-input-group .btn {
    border: none;
    padding: 0.6rem 1rem;
    background: #111;
    color: #fff;
    border-radius: 0;
    transition: background 0.2s;
    font-size: 1rem;
    display: flex;
    align-items: center;
}
.search-input-group .btn:hover, .search-input-group .btn:focus {
    background: #333;
    color: #fff;
}
@media (max-width: 600px) {
    .error-content {
        padding: 1.2rem 0.3rem 1rem 0.3rem;
        max-width: 98vw;
    }
    .error-gif-placeholder {
        width: 120px;
        height: 80px;
    }
    .error-title {
        font-size: 1.1rem;
    }
    .error-description {
        font-size: 0.95rem;
    }
    .btn-home, .error-links .btn {
        font-size: 0.95rem;
        padding: 0.5rem 0.7rem;
    }
    .search-input-group {
        max-width: 98vw;
    }
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(24px);}
    to { opacity: 1; transform: translateY(0);}
}
</style>

<?php get_footer(); ?>