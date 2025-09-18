<?php
/**
 * Template Name: Liên hệ
 * The template for displaying the contact page
 */

get_header(); ?>

<main id="main" class="site-main contact-page">
    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Liên hệ với chúng tôi</h1>
                <p class="hero-subtitle">Hãy liên hệ với chúng tôi để được tư vấn miễn phí về dự án của bạn</p>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form-section">
        <div class="container">
            <div class="row g-5">
                <!-- Contact Form -->
                <div class="col-lg-8">
                    <div class="contact-form-wrapper">
                        <div class="form-header">
                            <h3>Gửi tin nhắn cho chúng tôi</h3>
                            <p>Điền thông tin bên dưới và chúng tôi sẽ liên hệ lại trong thời gian sớm nhất</p>
                        </div>
                        
                        <form id="contact-form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>" class="contact-form">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact-name" class="form-label">Họ và tên *</label>
                                        <input type="text" class="form-control" id="contact-name" name="contact_name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact-email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="contact-email" name="contact_email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact-phone" class="form-label">Số điện thoại</label>
                                        <input type="tel" class="form-control" id="contact-phone" name="contact_phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact-company" class="form-label">Công ty</label>
                                        <input type="text" class="form-control" id="contact-company" name="contact_company">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="contact-subject" class="form-label">Chủ đề *</label>
                                        <select class="form-select" id="contact-subject" name="contact_subject" required>
                                            <option value="">Chọn chủ đề</option>
                                            <option value="tu-van">Tư vấn dự án</option>
                                            <option value="san-pham">Hỏi về sản phẩm</option>
                                            <option value="ho-tro">Hỗ trợ kỹ thuật</option>
                                            <option value="hop-tac">Hợp tác kinh doanh</option>
                                            <option value="khac">Khác</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="contact-message" class="form-label">Tin nhắn *</label>
                                        <textarea class="form-control" id="contact-message" name="contact_message" rows="6" required placeholder="Vui lòng mô tả chi tiết nhu cầu của bạn..."></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="contact-newsletter" name="contact_newsletter" value="1">
                                        <label class="form-check-label" for="contact-newsletter">
                                            Tôi muốn nhận thông tin về các sản phẩm và dịch vụ mới
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg contact-submit-btn">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M22 2L11 13"></path>
                                            <polygon points="22,2 15,22 11,13 2,9"></polygon>
                                        </svg>
                                        Gửi tin nhắn
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="action" value="handle_contact_form">
                            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('contact_form_nonce'); ?>">
                        </form>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-4">
                    <div class="contact-info-wrapper">
                        <div class="contact-info-header">
                            <h3>Thông tin liên hệ</h3>
                            <p>Chúng tôi luôn sẵn sàng hỗ trợ bạn</p>
                        </div>
                        
                        <div class="contact-info-list">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                </div>
                                <div class="contact-content">
                                    <h6>Địa chỉ</h6>
                                    <p><?php tdclassic_display_address(); ?></p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                </div>
                                <div class="contact-content">
                                    <h6>Điện thoại</h6>
                                    <p><?php tdclassic_display_phone(); ?></p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                        <polyline points="22,6 12,13 2,6"></polyline>
                                    </svg>
                                </div>
                                <div class="contact-content">
                                    <h6>Email</h6>
                                    <p>
                                        <?php tdclassic_display_email(); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12,6 12,12 16,14"></polyline>
                                    </svg>
                                </div>
                                <div class="contact-content">
                                    <h6>Giờ làm việc</h6>
                                    <p>
                                        Thứ 2 - Thứ 6: 8:00 - 17:00<br>
                                        Thứ 7: 8:00 - 12:00<br>
                                        Chủ nhật: Nghỉ
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="social-media-section">
                            <h6>Kết nối với chúng tôi</h6>
                            <div class="social-links">
                                <a href="#" class="social-link">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                                <a href="#" class="social-link">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                </a>
                                <a href="#" class="social-link">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </a>
                                <a href="#" class="social-link">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <div class="section-header">
                <h2>Vị trí của chúng tôi</h2>
                <p>Ghé thăm văn phòng của chúng tôi để trao đổi trực tiếp</p>
            </div>
            <div class="map-container">
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3727.999177617507!2d106.70327410000002!3d20.8720834!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314a7adc297467ef%3A0x2d9f6796b87197c!2zMjIgTmfDtCBRdXnhu4FuLCBU4buVIGTDom4gcGjhu5Egc-G7kSA1LCBOZ8O0IFF1eeG7gW4sIEjhuqNpIFBow7JuZw!5e0!3m2!1svi!2s!4v1754320853116!5m2!1svi!2s" 
                            width="100%" 
                            height="400" 
                            style="border:0; border-radius: 16px;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="section-header">
                <h2>Câu hỏi thường gặp</h2>
                <p>Những câu hỏi phổ biến về dịch vụ của chúng tôi</p>
            </div>
            <div class="faq-container">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                Thời gian thực hiện một dự án là bao lâu?
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Thời gian thực hiện dự án phụ thuộc vào độ phức tạp và yêu cầu cụ thể. Thông thường, một dự án website cơ bản mất 2-4 tuần, dự án phức tạp có thể mất 2-3 tháng.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                Chi phí cho một dự án là bao nhiêu?
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Chi phí được tính dựa trên phạm vi và độ phức tạp của dự án. Chúng tôi cung cấp báo giá chi tiết sau khi trao đổi yêu cầu cụ thể với khách hàng.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                Có hỗ trợ sau khi hoàn thành dự án không?
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Có, chúng tôi cung cấp dịch vụ bảo trì và hỗ trợ kỹ thuật trong 6 tháng đầu miễn phí. Sau đó, khách hàng có thể gia hạn gói bảo trì theo nhu cầu.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="contact-cta">
        <div class="container">
            <div class="cta-content">
                <h2>Sẵn sàng bắt đầu dự án?</h2>
                <p>Hãy liên hệ ngay để được tư vấn và báo giá chi tiết</p>
                <div class="cta-buttons">
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', tdclassic_get_company_phone())); ?>" class="btn btn-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        Gọi ngay
                    </a>
                    <a href="mailto:<?php echo tdclassic_get_company_email(); ?>" class="btn btn-secondary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        Gửi email
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contact form submission
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('.contact-submit-btn');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = `
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="spinning">
                    <path d="M21 12a9 9 0 11-6.219-8.56"></path>
                </svg>
                Đang gửi...
            `;
            submitBtn.disabled = true;
            
            // Submit form via AJAX
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    alert('Cảm ơn bạn! Tin nhắn đã được gửi thành công. Chúng tôi sẽ liên hệ lại sớm nhất.');
                    this.reset();
                } else {
                    // Show error message
                    alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
            })
            .finally(() => {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }
});
</script>

<style>
/* Contact Page Styles */
.contact-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.contact-hero {
    background: linear-gradient(135deg, #000 0%, #333 100%);
    color: #fff;
    padding: 80px 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.contact-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.contact-hero .hero-content {
    position: relative;
    z-index: 2;
}

.contact-hero .hero-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
    background: linear-gradient(45deg, #fff, #f0f0f0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.contact-hero .hero-subtitle {
    font-size: 1.25rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
}

.contact-form-section {
    padding: 80px 0;
    background: #fff;
}

.contact-form-wrapper {
    background: #fff;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    border: 1px solid rgba(0,0,0,0.05);
}

.form-header {
    text-align: center;
    margin-bottom: 40px;
}

.form-header h3 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #000;
}

.form-header p {
    color: #666;
    font-size: 1.1rem;
}

.contact-form .form-group {
    margin-bottom: 1.5rem;
}

.contact-form .form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
    display: block;
}

.contact-form .form-control,
.contact-form .form-select {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.contact-form .form-control:focus,
.contact-form .form-select:focus {
    border-color: #000;
    box-shadow: 0 0 0 3px rgba(0,0,0,0.1);
    background: #fff;
}

.contact-submit-btn {
    background: linear-gradient(45deg, #000, #333);
    border: none;
    border-radius: 12px;
    padding: 15px 30px;
    font-size: 1.1rem;
    font-weight: 600;
    color: #fff;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.contact-submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    color: #fff;
}

.contact-submit-btn svg {
    transition: transform 0.3s ease;
}

.contact-submit-btn:hover svg {
    transform: translateX(3px);
}

.contact-submit-btn.spinning svg {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.contact-info-wrapper {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 20px;
    padding: 40px;
    height: 100%;
    border: 1px solid rgba(0,0,0,0.05);
}

.contact-info-header {
    text-align: center;
    margin-bottom: 40px;
}

.contact-info-header h3 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #000;
}

.contact-info-header p {
    color: #666;
}

.contact-info-list {
    margin-bottom: 40px;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 30px;
    padding: 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.contact-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.contact-icon {
    background: linear-gradient(45deg, #000, #333);
    color: #fff;
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    flex-shrink: 0;
}

.contact-content h6 {
    font-weight: 600;
    color: #000;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.contact-content p {
    color: #666;
    margin: 0;
    line-height: 1.6;
}

.contact-content a {
    color: #000;
    text-decoration: none;
    transition: color 0.3s ease;
}

.contact-content a:hover {
    color: #666;
}

.social-media-section {
    text-align: center;
    padding-top: 30px;
    border-top: 1px solid rgba(0,0,0,0.1);
}

.social-media-section h6 {
    font-weight: 600;
    color: #000;
    margin-bottom: 20px;
}

.social-links {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.social-link {
    background: #fff;
    color: #000;
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.social-link:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    color: #000;
}

.map-section {
    padding: 80px 0;
    background: #f8f9fa;
}

.section-header {
    margin-bottom: 50px;
}

.section-header h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #000;
}

.section-header p {
    color: #666;
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto;
}

.map-container {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.faq-section {
    padding: 80px 0;
    background: #fff;
}

.faq-container {
    max-width: 800px;
    margin: 0 auto;
}

.accordion-item {
    border: none;
    margin-bottom: 20px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.accordion-button {
    background: #f8f9fa;
    border: none;
    padding: 20px 25px;
    font-weight: 600;
    color: #000;
    font-size: 1.1rem;
}

.accordion-button:not(.collapsed) {
    background: linear-gradient(45deg, #000, #333);
    color: #fff;
}

.accordion-button:focus {
    box-shadow: none;
    border: none;
}

.accordion-body {
    padding: 25px;
    background: #fff;
    color: #666;
    line-height: 1.6;
}

.contact-cta {
    padding: 80px 0;
    background: linear-gradient(135deg, #000 0%, #333 100%);
    color: #fff;
    text-align: center;
}

.contact-cta h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.contact-cta p {
    font-size: 1.25rem;
    opacity: 0.9;
    margin-bottom: 40px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-buttons {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.cta-buttons .btn {
    padding: 15px 30px;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
}

.cta-buttons .btn-primary {
    background: #fff;
    color: #000;
    border: none;
}

.cta-buttons .btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(255,255,255,0.2);
    color: #000;
}

.cta-buttons .btn-secondary {
    background: transparent;
    color: #fff;
    border: 2px solid #fff;
}

.cta-buttons .btn-secondary:hover {
    background: #fff;
    color: #000;
    transform: translateY(-3px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .contact-hero .hero-title {
        font-size: 2rem;
    }
    
    .contact-hero .hero-subtitle {
        font-size: 1rem;
    }
    
    .contact-form-wrapper,
    .contact-info-wrapper {
        padding: 30px 20px;
    }
    
    .form-header h3 {
        font-size: 1.5rem;
    }
    
    .section-header h2 {
        font-size: 2rem;
    }
    
    .contact-cta h2 {
        font-size: 2rem;
    }
    
    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .cta-buttons .btn {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .contact-hero {
        padding: 60px 0;
    }
    
    .contact-form-section,
    .map-section,
    .faq-section,
    .contact-cta {
        padding: 60px 0;
    }
    
    .contact-hero .hero-title {
        font-size: 1.75rem;
    }
    
    .form-header h3 {
        font-size: 1.25rem;
    }
    
    .section-header h2 {
        font-size: 1.75rem;
    }
    
    .contact-cta h2 {
        font-size: 1.75rem;
    }
}
</style>

<?php get_footer(); ?> 