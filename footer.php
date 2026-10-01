</main><!-- #main-content -->

    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="footer-container">
            
            <!-- 1. BRAND HEADER -->
            <div class="footer-brand">
                <h2>TD CLASSIC®</h2>
                <span>Professional Audio Systems - Chuẩn mực âm thanh đích thực</span>
            </div>

            <!-- 2. MAIN GRID -->
            <div class="footer-grid">
                
                <!-- CỘT 1: LIÊN HỆ -->
                <div class="footer-col">
                    <h3 class="footer-heading" style="margin-bottom: 20px;">Liên hệ nhanh</h3>
                    <div class="contact-info-block">
                        <p style="color: #fff; font-size: 18px; font-weight: bold; margin-bottom: 5px;"><?php tdclassic_display_phone(); ?></p>
                        <p><?php tdclassic_display_email(); ?></p>
                    </div>
                    
                    <div class="footer-certs">
                        <a href="https://www.dmca.com/Protection/Status.aspx?ID=b0b7c935-c097-42d6-993d-fc94ddf78bf2&refurl=https://tdclassic.vn/" title="DMCA.com Protection Status" class="dmca-badge cert-tooltip" target="_blank" rel="noopener noreferrer" data-tooltip="Bảo vệ bản quyền DMCA">
                            <img src="https://images.dmca.com/Badges/DMCA_badge_grn_60w.png?ID=b0b7c935-c097-42d6-993d-fc94ddf78bf2" alt="DMCA.com Protection Status" width="60" height="60" />
                        </a>
                        <a href="#" class="fake-goods-badge cert-tooltip" data-tooltip="Cam kết 100% Chính hãng">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/badges/noi-khong-hang-gia.webp'); ?>" alt="Nói không với hàng giả" width="100" height="32" style="height: 32px; width: auto;" loading="lazy" />
                        </a>
                    </div>
                </div>

                <!-- CỘT 2: HỆ THỐNG VĂN PHÒNG -->
                <div class="footer-col">
                    <h3 class="footer-heading">Hệ thống văn phòng</h3>
                    <div class="office-list space-y-4 border-none pl-0">
                        <!-- Hải Phòng -->
                        <div class="highlight-box mb-0 py-4 px-5">
                            <div class="highlight-title text-sm">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 21h18M5 21V7l8-4 8 4v14M8 21v-2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                VP & SHOWROOM HẢI PHÒNG
                            </div>
                            <div class="highlight-address text-xs text-gray-300">
                                Lô BT36-06 Khu đô thị (KĐT) thương mại & nhà ở công nhân Tràng Duệ, Phường An Dương, TP Hải Phòng, Việt Nam
                            </div>
                        </div>

                        <!-- Hà Nội -->
                        <div class="highlight-box mb-0 py-4 px-5">
                            <div class="highlight-title text-sm">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" x2="16" y1="21" y2="21"/><line x1="12" x2="12" y1="17" y2="21"/></svg>
                                VĂN PHÒNG HÀ NỘI
                            </div>
                            <div class="highlight-address text-xs text-gray-300">
                                Lô 5 - TT7 - Khu đấu giá Tứ Hiệp, Thanh Trì, Hà Nội
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CỘT 3: VĂN PHÒNG & MAP -->
                <div class="footer-col">
                    <!-- MAP -->
                    <div class="map-wrapper">
                        <iframe class="map-frame"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3727.999177617507!2d106.70327410000002!3d20.8720834!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314a7adc297467ef%3A0x2d9f6796b87197c!2zMjIgTmfDtCBRdXnhu4FuLCBU4buVIGTDom4gcGjhu5Egc-G7kSA1LCBOZ8O0IFF1eeG7gW4sIEjhuqNpIFBow7JuZw!5e0!3m2!1svi!2s!4v1754320853116!5m2!1svi!2s" 
                            title="Bản đồ định vị văn phòng TD Classic tại Hải Phòng"
                            width="340"
                            height="200"
                            style="border:0;" 
                            allowfullscreen=""
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
                    <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.7;">Mã số thuế: 0201879542 | Cấp ngày: 07/06/2018 | Nơi cấp: Sở Kế hoạch và Đầu tư TP. Hải Phòng</p>
                </div>
            </div>

        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

<!-- Lucide Icons Safe Init -->
<script>
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
</script>

<!-- Speculation Rules for Instant Navigation -->
<script type="speculationrules">
{
  "prerender": [{
    "where": {
      "and": [
        { "href_matches": "/*" },
        { "not": { "href_matches": "/wp-admin/*" } },
        { "not": { "href_matches": "/wp-login.php" } }
      ]
    },
    "eagerness": "moderate"
  }]
}
</script>

</body>
</html>