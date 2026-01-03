<?php
/**
 * Template Name: Giới thiệu - About Us
 * Description: Trang giới thiệu công ty với thiết kế luxury dark mode
 */

get_header(); ?>

<style>
    /* Page Specific Styles */
    /* Global styles moved to style.css */

    .timeline-line {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        width: 1px;
        height: 100%;
        background: linear-gradient(to bottom, transparent, #C5A059, transparent);
    }

    .stats-counter {
        font-feature-settings: 'tnum' on, 'lnum' on;
    }

    .text-justify-last {
        text-align: justify;
        text-justify: inter-word;
    }
</style>

<div class="noise"></div>

<!-- HERO SECTION -->
<section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden"
    style="background-color: #050505;">
    <!-- Background Image with overlay -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?q=80&w=1600&auto=format&fit=crop"
            class="w-full h-full object-cover opacity-30" alt="Sound Studio" decoding="sync" fetchpriority="high">
        <div class="absolute inset-0 bg-gradient-to-t from-[#050505] via-[#050505]/80 to-transparent"></div>
    </div>

    <div class="container mx-auto px-6 md:px-12 relative z-10 text-center py-24">
        <span class="inline-block font-sans text-xs tracking-[0.3em] uppercase mb-6" style="color: #C5A059;">About
            Us</span>
        <h1 class="font-sans font-bold text-5xl md:text-7xl text-white mb-6">Về Chúng Tôi</h1>
        <p class="font-sans text-gray-400 text-lg max-w-2xl mx-auto font-light leading-relaxed">
            Hơn một thập kỷ kiến tạo chuẩn mực âm thanh chuyên nghiệp tại Việt Nam
        </p>
    </div>
</section>

<!-- BRAND STORY SECTION -->
<section class="py-24" style="background-color: #151515; border-top: 1px solid rgba(255,255,255,0.05);">
    <div class="container mx-auto px-6 md:px-12">
        <div class="grid md:grid-cols-2 gap-16 items-center">
            <!-- Text Content -->
            <div class="order-2 md:order-1">
                <span class="font-sans text-xs tracking-[0.3em] uppercase mb-4 block" style="color: #C5A059;">Our
                    Story</span>
                <h2 class="font-sans font-bold text-3xl md:text-4xl text-white mb-6">Câu Chuyện Thương Hiệu</h2>
                <div class="space-y-4 font-sans text-gray-400 font-light leading-relaxed text-justify-last">
                    <p>
                        <strong class="text-white">TD Classic</strong> được thành lập với sứ mệnh mang đến những giải
                        pháp âm thanh chuyên nghiệp
                        đẳng cấp quốc tế cho thị trường Việt Nam. Xuất phát từ niềm đam mê với âm nhạc và sự am hiểu sâu
                        sắc
                        về công nghệ âm thanh, chúng tôi đã không ngừng nghiên cứu và phát triển những sản phẩm đáp ứng
                        tiêu chuẩn khắt khe nhất.
                    </p>
                    <p>
                        Qua hơn 10 năm hoạt động, TD Classic đã trở thành đối tác tin cậy của hàng ngàn doanh nghiệp,
                        từ các quán bar, karaoke cao cấp đến những hội trường lớn và sân khấu biểu diễn chuyên nghiệp
                        trên khắp cả nước.
                    </p>
                </div>

                <!-- Trust Indicators -->
                <div class="flex flex-wrap gap-6 mt-8 pt-8" style="border-top: 1px solid rgba(255,255,255,0.1);">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="#C5A059" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                        <span class="font-sans text-sm text-gray-400">Bảo hành chính hãng</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="#C5A059" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                        <span class="font-sans text-sm text-gray-400">Hỗ trợ 24/7</span>
                    </div>
                </div>
            </div>

            <!-- Image -->
            <div class="order-1 md:order-2 relative group">
                <div class="absolute -top-4 -right-4 w-24 h-24 border-t border-r"
                    style="border-color: rgba(197,160,89,0.3);"></div>
                <div class="aspect-[4/3] overflow-hidden" style="background-color: #1E1E1E;">
                    <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?q=80&w=1200&auto=format&fit=crop"
                        class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-1000 filter grayscale group-hover:grayscale-0"
                        alt="TD Classic Story" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STATS SECTION -->
<section class="py-20" style="background-color: #050505;">
    <div class="container mx-auto px-6 md:px-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="p-6 border" style="border-color: rgba(255,255,255,0.05);">
                <span class="block font-serif text-4xl md:text-5xl text-white stats-counter"
                    style="color: #C5A059;">10+</span>
                <span class="font-sans text-xs uppercase tracking-widest text-gray-500 mt-2 block">Năm Kinh
                    Nghiệm</span>
            </div>
            <div class="p-6 border" style="border-color: rgba(255,255,255,0.05);">
                <span class="block font-serif text-4xl md:text-5xl text-white stats-counter"
                    style="color: #C5A059;">1000+</span>
                <span class="font-sans text-xs uppercase tracking-widest text-gray-500 mt-2 block">Dự Án Hoàn
                    Thành</span>
            </div>
            <div class="p-6 border" style="border-color: rgba(255,255,255,0.05);">
                <span class="block font-serif text-4xl md:text-5xl text-white stats-counter"
                    style="color: #C5A059;">63</span>
                <span class="font-sans text-xs uppercase tracking-widest text-gray-500 mt-2 block">Tỉnh Thành Phủ
                    Sóng</span>
            </div>
            <div class="p-6 border" style="border-color: rgba(255,255,255,0.05);">
                <span class="block font-serif text-4xl md:text-5xl text-white stats-counter"
                    style="color: #C5A059;">50+</span>
                <span class="font-sans text-xs uppercase tracking-widest text-gray-500 mt-2 block">Đại Lý Ủy
                    Quyền</span>
            </div>
        </div>
    </div>
</section>

<!-- MISSION & VISION -->
<section class="py-24" style="background-color: #151515; border-top: 1px solid rgba(255,255,255,0.05);">
    <div class="container mx-auto px-6 md:px-12">
        <div class="text-center mb-16">
            <span class="font-sans text-xs tracking-[0.3em] uppercase" style="color: #C5A059;">Philosophy</span>
            <h2 class="font-sans font-bold text-3xl md:text-4xl text-white mt-4">Sứ Mệnh & Tầm Nhìn</h2>
        </div>

        <div class="grid md:grid-cols-2 gap-12">
            <!-- Mission -->
            <div class="p-8 border transition-all hover:border-[#C5A059]/50"
                style="background-color: #050505; border-color: rgba(255,255,255,0.05);">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 flex items-center justify-center border" style="border-color: #C5A059;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="#C5A059" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76" />
                        </svg>
                    </div>
                    <h3 class="font-sans font-bold text-2xl text-white">Sứ Mệnh</h3>
                </div>
                <p class="font-sans text-gray-400 font-light leading-relaxed text-justify-last">
                    Mang đến những giải pháp âm thanh chuyên nghiệp với chất lượng vượt trội, giá cả hợp lý,
                    góp phần nâng cao trải nghiệm nghe nhìn cho người Việt. Chúng tôi cam kết đồng hành cùng
                    khách hàng từ tư vấn, lắp đặt đến bảo hành, bảo trì lâu dài.
                </p>
            </div>

            <!-- Vision -->
            <div class="p-8 border transition-all hover:border-[#C5A059]/50"
                style="background-color: #050505; border-color: rgba(255,255,255,0.05);">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 flex items-center justify-center border" style="border-color: #C5A059;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="#C5A059" stroke-width="2">
                            <circle cx="12" cy="12" r="2" />
                            <path
                                d="M22 12c-2.667 4.667-6 7-10 7s-7.333-2.333-10-7c2.667-4.667 6-7 10-7s7.333 2.333 10 7" />
                        </svg>
                    </div>
                    <h3 class="font-sans font-bold text-2xl text-white">Tầm Nhìn</h3>
                </div>
                <p class="font-sans text-gray-400 font-light leading-relaxed text-justify-last">
                    Trở thành thương hiệu âm thanh chuyên nghiệp số 1 Việt Nam, được công nhận về chất lượng
                    sản phẩm và dịch vụ. Xây dựng hệ sinh thái âm thanh toàn diện, từ sản xuất, phân phối
                    đến đào tạo kỹ thuật viên chuyên nghiệp trên toàn quốc.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CORE VALUES -->
<section class="py-24" style="background-color: #050505; border-top: 1px solid rgba(255,255,255,0.05);">
    <div class="container mx-auto px-6 md:px-12">
        <div class="text-center mb-16">
            <span class="font-sans text-xs tracking-[0.3em] uppercase" style="color: #C5A059;">Core Values</span>
            <h2 class="font-sans font-bold text-3xl md:text-4xl text-white mt-4">Giá Trị Cốt Lõi</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Value 1 -->
            <div class="text-center p-8 group">
                <div class="w-20 h-20 mx-auto mb-6 flex items-center justify-center border group-hover:border-[#C5A059] transition-colors"
                    style="border-color: rgba(255,255,255,0.1);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                        stroke="#C5A059" stroke-width="1.5">
                        <polygon
                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                    </svg>
                </div>
                <h3 class="font-sans font-bold text-xl text-white mb-4">Chất Lượng</h3>
                <p class="font-sans text-sm text-gray-500 font-light leading-relaxed">
                    Cam kết chất lượng sản phẩm đạt tiêu chuẩn quốc tế. Mỗi sản phẩm đều trải qua quy trình kiểm định
                    nghiêm ngặt 48 giờ trước khi đến tay khách hàng.
                </p>
            </div>

            <!-- Value 2 -->
            <div class="text-center p-8 group">
                <div class="w-20 h-20 mx-auto mb-6 flex items-center justify-center border group-hover:border-[#C5A059] transition-colors"
                    style="border-color: rgba(255,255,255,0.1);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                        stroke="#C5A059" stroke-width="1.5">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <h3 class="font-sans font-bold text-xl text-white mb-4">Uy Tín</h3>
                <p class="font-sans text-sm text-gray-500 font-light leading-relaxed">
                    Xây dựng niềm tin từ sự minh bạch và chính trực. Hơn 10 năm đồng hành cùng hàng ngàn khách hàng là
                    minh chứng cho cam kết của chúng tôi.
                </p>
            </div>

            <!-- Value 3 -->
            <div class="text-center p-8 group">
                <div class="w-20 h-20 mx-auto mb-6 flex items-center justify-center border group-hover:border-[#C5A059] transition-colors"
                    style="border-color: rgba(255,255,255,0.1);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                        stroke="#C5A059" stroke-width="1.5">
                        <path
                            d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                    </svg>
                </div>
                <h3 class="font-sans font-bold text-xl text-white mb-4">Sáng Tạo</h3>
                <p class="font-sans text-sm text-gray-500 font-light leading-relaxed">
                    Không ngừng đổi mới và cải tiến. Đội ngũ R&D luôn nghiên cứu những công nghệ mới nhất để mang đến
                    giải pháp tối ưu cho khách hàng.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- TEAM SECTION (Optional) -->
<section class="py-24" style="background-color: #151515; border-top: 1px solid rgba(255,255,255,0.05);">
    <div class="container mx-auto px-6 md:px-12">
        <div class="text-center mb-16">
            <span class="font-sans text-xs tracking-[0.3em] uppercase" style="color: #C5A059;">Our Team</span>
            <h2 class="font-sans font-bold text-3xl md:text-4xl text-white mt-4">Đội Ngũ Chuyên Gia</h2>
            <p class="font-sans text-gray-500 text-sm mt-4 max-w-xl mx-auto">
                Những con người tâm huyết với âm thanh, sẵn sàng mang đến giải pháp tốt nhất cho bạn
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <?php
            $team = [
                ['role' => 'Kỹ sư R&D', 'count' => '8+', 'desc' => 'Nghiên cứu & Phát triển'],
                ['role' => 'Kỹ thuật viên', 'count' => '20+', 'desc' => 'Lắp đặt & Bảo trì'],
                ['role' => 'Chuyên viên tư vấn', 'count' => '15+', 'desc' => 'Hỗ trợ Khách hàng'],
                ['role' => 'Đối tác Đại lý', 'count' => '50+', 'desc' => 'Trên toàn quốc'],
            ];
            foreach ($team as $member): ?>
                <div class="p-6 text-center border border-white/5 hover:border-[#C5A059]/50 transition-colors"
                    style="background-color: #050505;">
                    <span class="block font-sans font-bold text-3xl mb-2"
                        style="color: #C5A059;"><?php echo $member['count']; ?></span>
                    <h4 class="font-sans text-white text-sm font-bold mb-1"><?php echo $member['role']; ?></h4>
                    <p class="font-sans text-xs text-gray-500"><?php echo $member['desc']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="py-24 relative overflow-hidden"
    style="background-color: #050505; border-top: 1px solid rgba(255,255,255,0.05);">
    <div class="absolute inset-0 opacity-20">
        <img src="https://images.unsplash.com/photo-1571974599782-87624638275e?q=80&w=1600&auto=format&fit=crop"
            class="w-full h-full object-cover" loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-t from-[#050505] via-[#050505]/90 to-[#050505]"></div>
    </div>

    <div class="container mx-auto px-6 md:px-12 relative z-10 text-center">
        <h2 class="font-sans font-bold text-3xl md:text-4xl text-white mb-6">Sẵn Sàng Hợp Tác?</h2>
        <p class="font-sans text-gray-400 max-w-xl mx-auto mb-10">
            Liên hệ ngay để nhận tư vấn miễn phí từ đội ngũ chuyên gia của chúng tôi
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo esc_url(home_url('/lien-he/')); ?>"
                class="inline-block font-sans text-sm font-bold uppercase tracking-widest px-8 py-4 transition-all"
                style="background-color: #C5A059; color: #000;">
                Liên Hệ Ngay
            </a>
            <a href="<?php echo esc_url(home_url('/san-pham/')); ?>"
                class="inline-block font-sans text-sm font-bold uppercase tracking-widest px-8 py-4 border text-white transition-all hover:border-[#C5A059] hover:text-[#C5A059]"
                style="border-color: rgba(255,255,255,0.2);">
                Xem Sản Phẩm
            </a>
        </div>
    </div>
</section>

<!-- LEGAL FOOTNOTE -->
<section class="py-16 font-sans text-[10px] leading-relaxed"
    style="background-color: #050505; color: #666666; border-top: 1px solid rgba(255,255,255,0.05);">
    <div class="container mx-auto px-6 md:px-12 max-w-4xl">
        <div class="text-center opacity-50">
            <p>Thông tin được cung cấp trên trang này phản ánh hoạt động của công ty tại thời điểm cập nhật.
                TD Classic bảo lưu quyền thay đổi thông tin mà không cần báo trước.</p>
            <p class="mt-4">Mã tài liệu: DOC-ABOUT-<?php echo date('Y'); ?> | Bản quyền © <?php echo date('Y'); ?> TD
                Classic Audio. Mọi quyền được bảo lưu.</p>
        </div>
    </div>
</section>

<?php get_footer(); ?>