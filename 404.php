<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="error-404-modern">
            <div class="error-container">
                <!-- Left Panel - Animation -->
                <div class="error-animation-panel">
                    <div class="electric-scene">
                        <!-- Bóng đèn chập chờn -->
                        <div class="lightbulb-container">
                            <div class="bulb">
                                <svg class="bulb-svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.87-3.13-7-7-7zM9 21v1c0 .55.45 1 1 1h4c.55 0 1-.45 1-1v-1H9z"/>
                                </svg>
                                <div class="bulb-halo"></div>
                                <div class="electric-sparks">
                                    <span class="spark"></span>
                                    <span class="spark"></span>
                                    <span class="spark"></span>
                                </div>
                            </div>
                            <div class="wire"></div>
                        </div>
                        
                        <!-- Số 404 hiện đại -->
                        <div class="error-number-modern">
                            <div class="number-glow">404</div>
                            <div class="number-flicker">404</div>
                            <div class="number-main">404</div>
                        </div>
                        
                        <!-- Circuit lines -->
                        <div class="circuit-lines">
                            <div class="line line-1"></div>
                            <div class="line line-2"></div>
                            <div class="line line-3"></div>
                        </div>
                    </div>
                </div>

                <!-- Right Panel - Content -->
                <div class="error-content-panel">
                    <div class="content-wrapper">
                        <div class="error-header">
                            <h1 class="error-title-modern">Trang này đang gặp sự cố</h1>
                            <p class="error-subtitle">Có vẻ như trang bạn tìm kiếm đang bị lỗi</p>
                        </div>

                        <div class="error-description-modern">
                            <p>Đừng lo! Chúng tôi sẽ giúp bạn tìm đường về. Trang bạn truy cập có thể đã bị di chuyển, xóa hoặc đang gặp sự cố điện áp.</p>
                        </div>

                        <div class="error-actions-modern">
                            <a href="<?php echo home_url('/'); ?>" class="btn-primary-modern">
                                <i class="fas fa-home"></i>
                                <span>Quay về trang chủ</span>
                            </a>
                            
                            <div class="secondary-actions">
                                <a href="<?php echo home_url('/san-pham'); ?>" class="btn-secondary-modern">
                                    <i class="fas fa-box"></i>
                                    <span>Sản phẩm</span>
                                </a>
                                <a href="<?php echo home_url('/blog'); ?>" class="btn-secondary-modern">
                                    <i class="fas fa-newspaper"></i>
                                    <span>Blog</span>
                                </a>
                                <a href="<?php echo home_url('/lien-he'); ?>" class="btn-secondary-modern">
                                    <i class="fas fa-headset"></i>
                                    <span>Hỗ trợ</span>
                                </a>
                            </div>
                        </div>

                        <!-- Search Box -->
                        <div class="search-section-modern">
                            <h3 class="search-title">Hoặc tìm kiếm trong bóng tối</h3>
                            <form role="search" method="get" class="search-form-modern" action="<?php echo home_url('/'); ?>">
                                <div class="search-input-modern">
                                    <input type="search" class="search-field" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo get_search_query(); ?>" name="s" aria-label="Tìm kiếm">
                                    <button type="submit" class="search-btn" aria-label="Tìm kiếm">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Helpful Links -->
                        <div class="helpful-links-modern">
                            <h3 class="links-title">Có thể bạn cần</h3>
                            <div class="links-grid">
                                <a href="<?php echo home_url('/gioi-thieu'); ?>" class="link-item">
                                    <i class="fas fa-info-circle"></i>
                                    <span>Về chúng tôi</span>
                                </a>
                                <a href="<?php echo home_url('/chinh-sach'); ?>" class="link-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Chính sách</span>
                                </a>
                                <a href="<?php echo home_url('/dich-vu'); ?>" class="link-item">
                                    <i class="fas fa-cogs"></i>
                                    <span>Dịch vụ</span>
                                </a>
                                <a href="tel:<?php echo get_option('phone'); ?>" class="link-item">
                                    <i class="fas fa-phone"></i>
                                    <span>Liên hệ nhanh</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
/* Modern 404 Page Styles */
.error-404-modern {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0c0c0c 0%, #1a1a1a 100%);
    padding: 2rem;
    position: relative;
    overflow: hidden;
}

.error-404-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 30% 20%, rgba(255, 235, 59, 0.05) 0%, transparent 50%),
        radial-gradient(circle at 70% 80%, rgba(100, 255, 255, 0.05) 0%, transparent 50%);
    animation: ambientFlicker 4s infinite;
}

.error-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    max-width: 1200px;
    width: 100%;
    position: relative;
    z-index: 2;
}

/* Animation Panel */
.error-animation-panel {
    display: flex;
    align-items: center;
    justify-content: center;
}

.electric-scene {
    position: relative;
    width: 100%;
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Lightbulb */
.lightbulb-container {
    position: absolute;
    top: 20%;
    left: 50%;
    transform: translateX(-50%);
}

.bulb {
    position: relative;
    width: 80px;
    height: 80px;
}

.bulb-svg {
    width: 80px;
    height: 80px;
    color: #ffeb3b;
    filter: drop-shadow(0 0 20px #ffeb3b);
    animation: modernBulbFlicker 2.5s infinite;
}

.bulb-halo {
    position: absolute;
    top: -20px;
    left: -20px;
    right: -20px;
    bottom: -20px;
    background: radial-gradient(circle, rgba(255, 235, 59, 0.4) 0%, transparent 70%);
    border-radius: 50%;
    animation: modernHaloFlicker 2.5s infinite;
}

.electric-sparks {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.spark {
    position: absolute;
    width: 4px;
    height: 4px;
    background: #ffeb3b;
    border-radius: 50%;
    animation: sparkFloat 3s infinite;
}

.spark:nth-child(1) {
    top: 10px;
    left: 20px;
    animation-delay: 0s;
}

.spark:nth-child(2) {
    top: 50px;
    right: 15px;
    animation-delay: 1s;
}

.spark:nth-child(3) {
    bottom: 10px;
    left: 40px;
    animation-delay: 2s;
}

.wire {
    position: absolute;
    top: 100px;
    left: 50%;
    width: 3px;
    height: 60px;
    background: linear-gradient(to bottom, #666, #333);
    transform: translateX(-50%);
    border-radius: 2px;
}

/* Error Number */
.error-number-modern {
    position: relative;
    font-size: 8rem;
    font-weight: 900;
    letter-spacing: -5px;
    margin-top: 120px;
}

.number-glow {
    position: absolute;
    top: 0;
    left: 0;
    color: #ffeb3b;
    filter: blur(15px);
    opacity: 0.7;
    animation: numberGlow 3s infinite;
}

.number-flicker {
    position: absolute;
    top: 0;
    left: 0;
    color: #fff;
    opacity: 0.8;
    animation: numberFlicker 1.5s infinite;
}

.number-main {
    position: relative;
    color: #fff;
    text-shadow: 0 0 40px rgba(255, 255, 255, 0.5);
    animation: numberMain 2s infinite;
}

/* Circuit Lines */
.circuit-lines {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.line {
    position: absolute;
    background: linear-gradient(90deg, transparent, #ffeb3b, transparent);
    animation: circuitFlow 4s infinite;
}

.line-1 {
    top: 30%;
    left: 10%;
    width: 80%;
    height: 2px;
    animation-delay: 0s;
}

.line-2 {
    top: 60%;
    left: 20%;
    width: 60%;
    height: 2px;
    animation-delay: 1.5s;
}

.line-3 {
    bottom: 20%;
    left: 15%;
    width: 70%;
    height: 2px;
    animation-delay: 3s;
}

/* Content Panel */
.error-content-panel {
    display: flex;
    align-items: center;
}

.content-wrapper {
    width: 100%;
}

.error-header {
    margin-bottom: 2rem;
}

.error-title-modern {
    font-size: 2.5rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 0.5rem;
    line-height: 1.2;
}

.error-subtitle {
    font-size: 1.2rem;
    color: #bbb;
    font-weight: 400;
}

.error-description-modern {
    margin-bottom: 2.5rem;
}

.error-description-modern p {
    font-size: 1.1rem;
    color: #999;
    line-height: 1.6;
}

/* Actions */
.error-actions-modern {
    margin-bottom: 3rem;
}

.btn-primary-modern {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: linear-gradient(135deg, #ffeb3b 0%, #ffc107 100%);
    color: #000;
    padding: 1rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1.1rem;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(255, 235, 59, 0.3);
    margin-bottom: 1.5rem;
}

.btn-primary-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(255, 235, 59, 0.4);
}

.secondary-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-secondary-modern {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.05);
    color: #fff;
    padding: 1rem 1.5rem;
    border-radius: 16px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.1);
    flex: 1;
    min-width: 120px;
}

.btn-secondary-modern:hover {
    background: rgba(255, 235, 59, 0.1);
    border-color: rgba(255, 235, 59, 0.3);
    transform: translateY(-2px);
}

.btn-secondary-modern i {
    font-size: 1.5rem;
    color: #ffeb3b;
}

.btn-secondary-modern span {
    font-size: 0.9rem;
    font-weight: 500;
}

/* Search Section */
.search-section-modern {
    margin-bottom: 2.5rem;
}

.search-title {
    font-size: 1.2rem;
    color: #bbb;
    margin-bottom: 1rem;
    font-weight: 500;
}

.search-form-modern {
    position: relative;
}

.search-input-modern {
    position: relative;
    display: flex;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
}

.search-input-modern:focus-within {
    border-color: rgba(255, 235, 59, 0.3);
    box-shadow: 0 0 20px rgba(255, 235, 59, 0.1);
}

.search-field {
    flex: 1;
    background: transparent;
    border: none;
    padding: 1rem 1.5rem;
    color: #fff;
    font-size: 1rem;
    outline: none;
}

.search-field::placeholder {
    color: #666;
}

.search-btn {
    background: linear-gradient(135deg, #ffeb3b 0%, #ffc107 100%);
    border: none;
    padding: 1rem 1.5rem;
    color: #000;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-btn:hover {
    background: linear-gradient(135deg, #ffc107 0%, #ff8f00 100%);
}

/* Helpful Links */
.helpful-links-modern {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-top: 2rem;
}

.links-title {
    font-size: 1.1rem;
    color: #bbb;
    margin-bottom: 1.5rem;
    font-weight: 500;
}

.links-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.link-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 12px;
    text-decoration: none;
    color: #bbb;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.link-item:hover {
    background: rgba(255, 235, 59, 0.1);
    border-color: rgba(255, 235, 59, 0.2);
    color: #fff;
    transform: translateX(5px);
}

.link-item i {
    color: #ffeb3b;
    width: 16px;
}

/* Animations */
@keyframes ambientFlicker {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

@keyframes modernBulbFlicker {
    0%, 45%, 47%, 63%, 100% { 
        opacity: 1;
        filter: drop-shadow(0 0 20px #ffeb3b);
    }
    46%, 62% { 
        opacity: 0.4;
        filter: drop-shadow(0 0 5px #ffeb3b);
    }
}

@keyframes modernHaloFlicker {
    0%, 45%, 47%, 63%, 100% { 
        opacity: 1;
        transform: scale(1);
    }
    46%, 62% { 
        opacity: 0.3;
        transform: scale(0.8);
    }
}

@keyframes sparkFloat {
    0%, 100% { 
        opacity: 0;
        transform: translateY(0) scale(0);
    }
    50% { 
        opacity: 1;
        transform: translateY(-20px) scale(1);
    }
}

@keyframes numberGlow {
    0%, 100% { opacity: 0.7; }
    50% { opacity: 0.3; }
}

@keyframes numberFlicker {
    0%, 85%, 87%, 100% { opacity: 0.8; }
    86% { opacity: 0.2; }
}

@keyframes numberMain {
    0%, 90%, 92%, 100% { 
        opacity: 1;
        text-shadow: 0 0 40px rgba(255, 255, 255, 0.5);
    }
    91% { 
        opacity: 0.6;
        text-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
    }
}

@keyframes circuitFlow {
    0% { opacity: 0; transform: translateX(-100%); }
    50% { opacity: 1; }
    100% { opacity: 0; transform: translateX(100%); }
}

/* Responsive */
@media (max-width: 968px) {
    .error-container {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .electric-scene {
        height: 300px;
    }
    
    .error-number-modern {
        font-size: 6rem;
    }
    
    .error-title-modern {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .error-404-modern {
        padding: 1rem;
    }
    
    .error-number-modern {
        font-size: 4rem;
    }
    
    .secondary-actions {
        flex-direction: column;
    }
    
    .links-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>