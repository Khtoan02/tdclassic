</div><!-- #content -->

    <!-- FOOTER DESIGN BY GEMINI - HIGHLIGHT SHOWROOM & WAREHOUSE -->
    <style>
        /* --- CSS VARIABLES & RESET --- */
        :root {
            --f-bg-color: #080808;       /* Đen sâu */
            --f-bg-card: #141414;        /* Nền card */
            --f-text-main: #ffffff;      /* Trắng tinh */
            --f-text-muted: #888888;     /* Xám bạc */
            --f-border-light: #333333;   /* Viền thường */
            --f-border-highlight: #555555; /* Viền nổi bật cho Showroom */
            --f-accent: #ffffff;         /* Màu nhấn */
        }

        .site-footer {
            background-color: var(--f-bg-color);
            color: var(--f-text-muted);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            padding-top: 70px;
            position: relative;
            z-index: 10;
        }

        .site-footer a {
            text-decoration: none;
            color: var(--f-text-muted);
            transition: all 0.3s ease;
        }

        .site-footer a:hover {
            color: var(--f-text-main);
            transform: translateX(3px);
        }

        .footer-container {
            max-width: 1440px; /* Mở rộng container một chút */
            margin: 0 auto;
            padding: 0 30px;
        }

        /* --- BRAND --- */
        .footer-brand {
            margin-bottom: 50px;
            border-bottom: 1px solid var(--f-border-light);
            padding-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-brand h2 {
            font-size: 2.2rem;
            color: var(--f-text-main);
            font-weight: 800;
            margin: 0;
            letter-spacing: -0.02em;
        }

        .footer-brand span {
            font-size: 13px; /* Điều chỉnh size chữ nhẹ nhàng hơn */
            text-transform: uppercase;
            letter-spacing: 1px; /* Giảm khoảng cách chữ để dòng slogan dài hiển thị đẹp hơn */
            opacity: 0.7;
            font-weight: 500;
        }

        /* --- GRID SYSTEM --- */
        .footer-grid {
            display: grid;
            grid-template-columns: 200px 1fr 380px; /* Cột 3 (Map) rộng hơn chút */
            gap: 50px;
        }

        .footer-heading {
            color: var(--f-text-main);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
            margin-bottom: 25px;
            display: block;
            opacity: 0.9;
        }

        /* --- PRODUCT LINKS --- */
        .product-links li {
            margin-bottom: 12px;
        }
        .product-links a {
            font-size: 15px;
            display: block;
            padding: 5px 0;
            border-bottom: 1px dashed #222;
        }
        .product-links a:hover {
            border-bottom-color: #555;
        }

        /* --- HIGHLIGHT BOX (SHOWROOM & WAREHOUSE) --- */
        .highlight-box {
            border: 1px solid var(--f-border-highlight);
            background: var(--f-bg-card);
            padding: 25px;
            border-radius: 6px;
            margin-bottom: 30px;
            position: relative;
        }
        
        /* Nhãn nổi bật */
        .highlight-label {
            position: absolute;
            top: -12px;
            left: 20px;
            background: var(--f-text-main);
            color: #000;
            padding: 2px 12px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 2px;
        }

        .highlight-title {
            color: var(--f-text-main);
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .highlight-address {
            font-size: 15px;
            color: #e0e0e0; /* Trắng sáng hơn text thường */
            line-height: 1.5;
        }

        /* --- OFFICE LIST (SECONDARY) --- */
        .office-list {
            padding-left: 10px;
            border-left: 2px solid var(--f-border-light);
        }

        .office-item {
            margin-bottom: 20px;
        }

        .office-title {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #ccc;
            margin-bottom: 4px;
            text-transform: uppercase;
        }
        
        .office-addr {
            font-size: 14px;
        }

        /* --- WAREHOUSE & MAP --- */
        .warehouse-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #2a2a2a;
        }
        .warehouse-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .map-wrapper {
            border: 1px solid var(--f-border-light);
            padding: 5px; /* Tạo khung viền cho map */
            background: #1a1a1a;
            border-radius: 4px;
        }

        .map-frame {
            width: 100%;
            height: 200px;
            display: block;
            background: #ddd;
        }

        /* --- BOTTOM --- */
        .footer-bottom {
            margin-top: 60px;
            border-top: 1px solid var(--f-border-light);
            padding: 30px 0;
            display: flex;
            justify-content: center; /* Căn giữa vì chỉ còn 1 nội dung */
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            text-align: center;
        }
        
        .contact-info-block p {
            margin: 0;
            font-size: 14px;
        }
        
        .footer-certs {
            margin-top: 25px;
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .dmca-badge img, .fake-goods-badge img {
            opacity: 0.8;
            transition: opacity 0.3s;
        }
        
        .dmca-badge:hover img, .fake-goods-badge:hover img {
            opacity: 1;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 1024px) {
            .footer-brand { flex-direction: column; align-items: flex-start; gap: 10px; }
            .footer-grid { grid-template-columns: 1fr; gap: 40px; }
            .highlight-box { padding: 20px; }
        }
    </style>

    <footer id="colophon" class="site-footer">
        <div class="footer-container">
            
            <!-- 1. BRAND HEADER -->
            <div class="footer-brand">
                <h2>TD CLASSIC®</h2>
                <span>Professional Audio Systems - Chuẩn mực âm thanh đích thực</span>
            </div>

            <!-- 2. MAIN GRID -->
            <div class="footer-grid">
                
                <!-- CỘT 1: SẢN PHẨM -->
                <div class="footer-col">
                    <h3 class="footer-heading">Danh mục sản phẩm</h3>
                    <ul class="product-links">
                        <li><a href="<?php echo home_url('/product-category/professional-speaker/'); ?>">Loa chuyên nghiệp</a></li>
                        <li><a href="<?php echo home_url('/product-category/amplifier/'); ?>">Thiết bị khuếch đại</a></li>
                        <li><a href="<?php echo home_url('/product-category/audio-mixer/'); ?>">Bàn trộn âm thanh</a></li>
                        <li><a href="<?php echo home_url('/product-category/signal-processor/'); ?>">Bộ xử lý tín hiệu</a></li>
                        <li><a href="<?php echo home_url('/product-category/microphone/'); ?>">Microphone</a></li>
                        <li><a href="<?php echo home_url('/product-category/resource-management/'); ?>">Quản lý nguồn</a></li>
                    </ul>
                    
                    <div style="margin-top: 40px;">
                        <h3 class="footer-heading" style="margin-bottom: 15px;">Liên hệ nhanh</h3>
                        <div class="contact-info-block">
                            <p style="color: #fff; font-size: 18px; font-weight: bold; margin-bottom: 5px;"><?php tdclassic_display_phone(); ?></p>
                            <p><?php tdclassic_display_email(); ?></p>
                        </div>
                        
                        <!-- Chứng nhận chuyển lên đây -->
                        <div class="footer-certs">
                             <a href="//www.dmca.com/Protection/Status.aspx?ID=b0b7c935-c097-42d6-993d-fc94ddf78bf2" title="DMCA.com Protection Status" class="dmca-badge" target="_blank">
                                <img src="https://images.dmca.com/Badges/DMCA_badge_grn_60w.png?ID=b0b7c935-c097-42d6-993d-fc94ddf78bf2" alt="DMCA.com Protection Status" />
                            </a>
                            <a href="/" title="Nói không với hàng giả" class="fake-goods-badge">
                                <img src="https://tdclassic.vn/wp-content/uploads/2025/10/Noi-khong-voi-hang-gia.png" alt="Nói không với hàng giả" style="height: 32px; width: auto;" />
                            </a>
                        </div>
                    </div>
                </div>

                <!-- CỘT 2: SHOWROOM & VĂN PHÒNG -->
                <div class="footer-col">
                    <!-- SHOWROOM HIGHLIGHT -->
                    <div class="highlight-box">
                        <span class="highlight-label">Trải nghiệm thực tế</span>
                        <div class="highlight-title">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7l8-4 8 4v14M8 21v-2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            SHOWROOM TRƯNG BÀY
                        </div>
                        <div class="highlight-address">
                            111A tổ 3 Thị trấn An Dương, Huyện An Dương, Thành phố Hải Phòng
                        </div>
                    </div>

                    <!-- OFFICE LIST -->
                    <h3 class="footer-heading">Văn phòng đại diện</h3>
                    <div class="office-list">
                        <div class="office-item">
                            <span class="office-title">Văn phòng Hải Phòng</span>
                            <span class="office-addr">Số 10 Đường Cầu Bính, Sở Dầu, Hồng Bàng, Hải Phòng</span>
                        </div>
                        <div class="office-item">
                            <span class="office-title">Văn phòng Hà Nội</span>
                            <span class="office-addr">Lô 5 - TT7 - Khu đấu giá Tứ Hiệp, Thanh Trì, Hà Nội</span>
                        </div>
                        <div class="office-item">
                            <span class="office-title">Văn phòng TP. Hồ Chí Minh</span>
                            <span class="office-addr">Toà nhà Phúc Tấn Nguyên, 400 Nguyễn Thị Thập, P. Tân Quy, Quận 7</span>
                        </div>
                    </div>
                </div>

                <!-- CỘT 3: KHO HÀNG & MAP -->
                <div class="footer-col">
                    <!-- WAREHOUSE HIGHLIGHT -->
                    <div class="highlight-box" style="border-color: #333; background: #0f0f0f;">
                        <span class="highlight-label" style="background: #ccc;">Logistics & Kho vận</span>
                        <div class="highlight-title">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                            HỆ THỐNG KHO HÀNG
                        </div>
                        <div class="warehouse-content">
                            <div class="warehouse-item">
                                <strong style="color: #fff; display: block; margin-bottom: 3px;">KHO SỐ 01</strong>
                                <span class="highlight-address" style="font-size: 14px; color: #aaa;">Số 10 Đường Cầu Bính, Sở Dầu, Hồng Bàng, Hải Phòng</span>
                            </div>
                            <div class="warehouse-item">
                                <strong style="color: #fff; display: block; margin-bottom: 3px;">KHO SỐ 02</strong>
                                <span class="highlight-address" style="font-size: 14px; color: #aaa;">Lô 35B+36+37A Khu Văn Tràng II, An Lão, Hải Phòng</span>
                            </div>
                        </div>
                    </div>

                    <!-- MAP -->
                    <div class="map-wrapper">
                        <iframe class="map-frame"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3727.999177617507!2d106.70327410000002!3d20.8720834!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314a7adc297467ef%3A0x2d9f6796b87197c!2zMjIgTmfDtCBRdXnhu4FuLCBU4buVIGTDom4gcGjhu5Egc-G7kSA1LCBOZ8O0IFF1eeG7gW4sIEjhuqNpIFBow7JuZw!5e0!3m2!1svi!2s!4v1754320853116!5m2!1svi!2s" 
                            style="border:0;" 
                            allowfullscreen="" pul
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

            </div>

            <!-- 3. BOTTOM INFO -->
            <div class="footer-bottom">
                <div class="company-legal">
                    <p style="margin: 0; color: #fff; font-weight: 600;">© <?php echo date('Y'); ?> CÔNG TY CỔ PHẦN CÔNG NGHỆ TAVA VIỆT NAM</p>
                    <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.5;">Mã số thuế: 0201879542 | Cấp ngày: 07/06/2018 | Nơi cấp: Sở Kế hoạch và Đầu tư TP. Hải Phòng</p>
                </div>
            </div>

        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>

</body>
</html>