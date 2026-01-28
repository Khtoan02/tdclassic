<?php
/**
 * Template Name: Liên hệ
 * The template for displaying the contact page
 */

// Get company information
$addresses = tdclassic_get_company_addresses();
$phones = tdclassic_get_company_phones();
$emails = tdclassic_get_company_emails();
$primary_phone = !empty($phones) ? $phones[0] : '';
$secondary_phone = !empty($phones) && count($phones) > 1 ? $phones[1] : '';
$primary_email = !empty($emails) ? $emails[0] : '';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>

    <!-- Tailwind and Global Styles loaded via functions.php -->
    <style>
        /* Global styles moved to style.css */

        /* Input Field Animation */
        .input-group {
            position: relative;
            margin-bottom: 2rem;
        }

        .input-field {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid #333;
            padding: 1rem 0;
            color: white;
            font-family: 'Manrope', sans-serif;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .input-field:focus {
            outline: none;
            border-bottom-color: #C5A059;
        }

        .input-label {
            position: absolute;
            top: 1rem;
            left: 0;
            color: #666;
            font-size: 0.875rem;
            pointer-events: none;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .input-field:focus~.input-label,
        .input-field:not(:placeholder-shown)~.input-label {
            top: -0.75rem;
            font-size: 0.75rem;
            color: #C5A059;
        }

        /* Checkbox styling */
        input[type="checkbox"] {
            appearance: none;
            width: 1rem;
            height: 1rem;
            border: 1px solid #666;
            border-radius: 2px;
            background: transparent;
            cursor: pointer;
            position: relative;
        }

        input[type="checkbox"]:checked {
            background: #C5A059;
            border-color: #C5A059;
        }

        input[type="checkbox"]:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: black;
            font-size: 0.75rem;
        }

        /* Location Card Hover Effect */
        .location-card {
            transition: all 0.3s ease;
        }

        .location-card:hover {
            transform: translateY(-4px);
            border-color: #C5A059 !important;
        }

        /* Location Content Display */
        .location-content {
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .location-content.hidden {
            display: none;
        }
    </style>
</head>

<body class="antialiased selection:bg-gold selection:text-black">

    <?php wp_body_open(); ?>

    <div class="noise"></div>

    <?php get_header(); ?>

    <!-- HERO HEADER -->
    <section class="pt-40 pb-20 bg-void relative overflow-hidden">
        <div class="container mx-auto px-6 md:px-12 text-center relative z-10">
            <span class="font-sans text-gold text-xs tracking-[0.4em] uppercase block mb-6 animate-fade-in">Kết nối &
                Hợp tác</span>
            <h1 class="font-sans font-bold text-5xl md:text-7xl text-white mb-8">Liên Hệ TD Classic</h1>
            <div class="w-24 h-[1px] bg-gradient-to-r from-transparent via-gold to-transparent mx-auto mb-6"></div>
            <p class="font-sans text-gray-400 max-w-2xl mx-auto text-base leading-relaxed">
                Đồng hành cùng hơn 1,000+ dự án âm thanh chuyên nghiệp trên toàn quốc.
                Chúng tôi sẵn sàng lắng nghe và biến ý tưởng của bạn thành hiện thực.
            </p>
        </div>
        <!-- Abstract Background lines -->
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 L100 0" stroke="white" stroke-width="0.1" fill="none" />
                <path d="M20 100 L100 20" stroke="white" stroke-width="0.1" fill="none" />
            </svg>
        </div>
    </section>

    <!-- BRAND STORY SECTION -->
    <section class="py-20 bg-void border-b border-white/5">
        <div class="container mx-auto px-6 md:px-12">
            <div class="max-w-5xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <span class="font-sans text-gold text-xs tracking-[0.3em] uppercase block mb-4">Our Story</span>
                        <h2 class="font-sans font-bold text-3xl md:text-4xl text-white mb-6">Hành Trình Định Nghĩa Lại
                            Âm Thanh Chuyên Nghiệp</h2>
                        <div class="w-16 h-[1px] bg-gold mb-8"></div>
                    </div>
                    <div class="space-y-6">
                        <p class="font-sans text-gray-400 text-sm leading-relaxed text-justify">
                            Từ năm 2018, TD Classic đã không ngừng nghiên cứu và phát triển các giải pháp âm thanh tiên
                            tiến,
                            phục vụ hàng nghìn dự án từ các quán bar, karaoke cao cấp đến hội trường sự kiện quy mô lớn.
                            Chúng tôi hiểu rằng âm thanh không chỉ là công nghệ, mà là cảm xúc được truyền tải qua từng
                            nốt nhạc.
                        </p>
                        <p class="font-sans text-gray-400 text-sm leading-relaxed text-justify">
                            Với đội ngũ kỹ sư âm thanh giàu kinh nghiệm và hệ thống showroom, kho hàng trải dài khắp
                            Việt Nam,
                            TD Classic tự hào là đối tác tin cậy của những thương hiệu hàng đầu trong và ngoài nước.
                        </p>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-16 pt-12 border-t border-white/10">
                    <div class="text-center">
                        <div class="font-serif text-4xl text-gold mb-2">7+</div>
                        <div class="font-sans text-xs text-gray-500 uppercase tracking-wider">Năm kinh nghiệm</div>
                    </div>
                    <div class="text-center">
                        <div class="font-serif text-4xl text-gold mb-2">1,000+</div>
                        <div class="font-sans text-xs text-gray-500 uppercase tracking-wider">Dự án hoàn thành</div>
                    </div>
                    <div class="text-center">
                        <div class="font-serif text-4xl text-gold mb-2">3</div>
                        <div class="font-sans text-xs text-gray-500 uppercase tracking-wider">Văn phòng toàn quốc</div>
                    </div>
                    <div class="text-center">
                        <div class="font-serif text-4xl text-gold mb-2">24/7</div>
                        <div class="font-sans text-xs text-gray-500 uppercase tracking-wider">Hỗ trợ kỹ thuật</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NETWORK LOCATIONS SECTION -->
    <section class="py-20 bg-metal">
        <div class="container mx-auto px-6 md:px-12">
            <div class="text-center mb-16">
                <span class="font-sans text-gold text-xs tracking-[0.3em] uppercase block mb-4">Nationwide
                    Network</span>
                <h2 class="font-sans font-bold text-3xl md:text-4xl text-white mb-4">Hệ Thống Trên Toàn Quốc</h2>
                <div class="w-24 h-[1px] bg-gradient-to-r from-transparent via-gold to-transparent mx-auto"></div>
            </div>

            <!-- SHOWROOM HIGHLIGHT -->
            <div class="max-w-4xl mx-auto mb-12">
                <div class="bg-void border-2 border-gold/30 p-8 md:p-10 relative overflow-hidden group">
                    <div
                        class="absolute -right-8 -top-8 w-32 h-32 bg-gold/10 rounded-full blur-2xl group-hover:bg-gold/20 transition-all">
                    </div>
                    <div
                        class="absolute top-6 right-6 bg-gold text-black px-4 py-1 text-xs font-bold uppercase tracking-wider">
                        Trải nghiệm thực tế
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-14 h-14 border-2 border-gold flex items-center justify-center flex-shrink-0">
                                <i data-lucide="building-2" class="w-7 h-7 text-gold"></i>
                            </div>
                            <div>
                                <h3 class="font-sans font-bold text-2xl text-white mb-2">Showroom Trưng Bày Chính</h3>
                                    Lô BT36-06 Khu đô thị (KĐT) thương mại & nhà ở công nhân Tràng Duệ, Phường An Dương, TP Hải Phòng, Việt Nam
                                </p>
                                <div class="flex flex-wrap gap-4 text-xs">
                                    <div class="flex items-center gap-2 text-gold">
                                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        <span class="font-sans">Phòng Demo Chuyên Nghiệp</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-gold">
                                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        <span class="font-sans">Tư Vấn 1-1 Miễn Phí</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-gold">
                                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        <span class="font-sans">Trưng Bày Đầy Đủ Sản Phẩm</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- OFFICES GRID -->
            <div class="mb-12">
                <h3 class="font-sans font-bold text-xl text-white mb-6 text-center">Văn Phòng Đại Diện</h3>
                <div class="flex justify-center">
                    <!-- Hà Nội Office -->
                    <div class="location-card bg-surface border border-white/10 p-6 hover:shadow-xl max-w-md w-full">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 border border-white/20 flex items-center justify-center">
                                <i data-lucide="map-pin" class="w-5 h-5 text-gold"></i>
                            </div>
                            <h4 class="font-sans font-bold text-lg text-white">Văn Phòng Hà Nội</h4>
                        </div>
                        <p class="font-sans text-sm text-gray-400 mb-3">
                            Lô 5 - TT7 - Khu đấu giá Tứ Hiệp, Thanh Trì, Hà Nội
                        </p>
                        <div class="text-xs text-gray-500 font-sans">
                            <i data-lucide="phone" class="w-3 h-3 inline mr-1"></i>
                            Hotline: <?php echo esc_html($primary_phone); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- WAREHOUSE SECTION -->
            <div class="max-w-4xl mx-auto">
                <h3 class="font-sans font-bold text-xl text-white mb-6 text-center">Hệ Thống Kho Hàng & Logistics</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Warehouse 01 -->
                    <div class="bg-void/50 border border-white/5 p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-gold/10 border border-gold/30 flex items-center justify-center">
                                <i data-lucide="warehouse" class="w-5 h-5 text-gold"></i>
                            </div>
                            <h4 class="font-sans font-bold text-white">Kho Số 01</h4>
                        </div>
                        <p class="font-sans text-sm text-gray-400">
                            Số 10 Đường Cầu Bính, Sở Dầu, Hồng Bàng, Hải Phòng
                        </p>
                        <div class="mt-3 text-xs text-gray-500">
                            <span class="text-gold">●</span> Kho chính - Sẵn hàng 24/7
                        </div>
                    </div>

                    <!-- Warehouse 02 -->
                    <div class="bg-void/50 border border-white/5 p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-gold/10 border border-gold/30 flex items-center justify-center">
                                <i data-lucide="warehouse" class="w-5 h-5 text-gold"></i>
                            </div>
                            <h4 class="font-sans font-bold text-white">Kho Số 02</h4>
                        </div>
                        <p class="font-sans text-sm text-gray-400">
                            Lô 35B+36+37A Khu Văn Tràng II, An Lão, Hải Phòng
                        </p>
                        <div class="mt-3 text-xs text-gray-500">
                            <span class="text-gold">●</span> Kho dự phòng - Sản phẩm số lượng lớn
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN CONTACT CONTENT -->
    <section class="py-32 bg-void">
        <div class="container mx-auto px-6 md:px-12">
            <div class="text-center mb-16">
                <span class="font-sans text-gold text-xs tracking-[0.3em] uppercase block mb-4">Get In Touch</span>
                <h2 class="font-sans font-bold text-3xl md:text-4xl text-white mb-4">Gửi Yêu Cầu Tư Vấn</h2>
                <div class="w-24 h-[1px] bg-gradient-to-r from-transparent via-gold to-transparent mx-auto"></div>
            </div>

            <div class="grid lg:grid-cols-12 gap-16">

                <!-- LEFT COLUMN: CONTACT INFO -->
                <div class="lg:col-span-5 space-y-8">
                    <!-- Quick Contact -->
                    <div class="bg-metal p-8 border border-white/5">
                        <h3 class="font-sans font-bold text-xl text-white mb-6 border-l-2 border-gold pl-4">Liên Hệ
                            Nhanh</h3>

                        <div class="space-y-6">
                            <?php if ($primary_phone || $secondary_phone): ?>
                                <div class="flex items-start gap-4 group">
                                    <div
                                        class="w-12 h-12 border border-white/10 flex items-center justify-center group-hover:border-gold transition-colors flex-shrink-0">
                                        <i data-lucide="phone" class="w-5 h-5 text-gold"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-white font-sans font-bold text-base mb-2">Hotline 24/7</h4>
                                        <?php if ($primary_phone): ?>
                                            <p class="text-gray-400 text-sm font-sans mb-1">
                                                Tư vấn: <a
                                                    href="tel:<?php echo esc_attr(str_replace(' ', '', $primary_phone)); ?>"
                                                    class="text-white hover:text-gold transition-colors"><?php echo esc_html($primary_phone); ?></a>
                                            </p>
                                        <?php endif; ?>
                                        <?php if ($secondary_phone): ?>
                                            <p class="text-gray-400 text-sm font-sans">
                                                Kỹ thuật: <a
                                                    href="tel:<?php echo esc_attr(str_replace(' ', '', $secondary_phone)); ?>"
                                                    class="text-white hover:text-gold transition-colors"><?php echo esc_html($secondary_phone); ?></a>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($primary_email): ?>
                                <div class="flex items-start gap-4 group">
                                    <div
                                        class="w-12 h-12 border border-white/10 flex items-center justify-center group-hover:border-gold transition-colors flex-shrink-0">
                                        <i data-lucide="mail" class="w-5 h-5 text-gold"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-white font-sans font-bold text-base mb-2">Email Hỗ Trợ</h4>
                                        <p class="text-gray-400 text-sm font-sans">
                                            <a href="mailto:<?php echo esc_attr($primary_email); ?>"
                                                class="hover:text-gold transition-colors"><?php echo esc_html($primary_email); ?></a>
                                        </p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="flex items-start gap-4 group">
                                <div
                                    class="w-12 h-12 border border-white/10 flex items-center justify-center group-hover:border-gold transition-colors flex-shrink-0">
                                    <i data-lucide="clock" class="w-5 h-5 text-gold"></i>
                                </div>
                                <div>
                                    <h4 class="text-white font-sans font-bold text-base mb-2">Thời Gian Phục Vụ</h4>
                                    <p class="text-gray-400 text-sm font-sans">24/7 - Không ngừng nghỉ</p>
                                    <p class="text-gray-500 text-xs font-sans mt-1">Hotline luôn sẵn sàng hỗ trợ bạn</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Commitment Box -->
                    <div
                        class="bg-gradient-to-br from-gold/5 to-transparent p-8 border border-gold/20 relative overflow-hidden group">
                        <div
                            class="absolute -right-6 -bottom-6 w-24 h-24 bg-gold/10 rounded-full blur-xl group-hover:bg-gold/20 transition-colors">
                        </div>

                        <h3 class="font-sans font-bold text-white text-lg mb-6 flex items-center gap-3 relative z-10">
                            <i data-lucide="heart-handshake" class="w-5 h-5 text-gold"></i> Cam Kết Của Chúng Tôi
                        </h3>
                        <p class="font-sans text-gray-300 text-sm leading-relaxed text-justify mb-6 relative z-10">
                            Tại TD Classic, chúng tôi hiểu rằng mỗi dự án âm thanh đều mang trong mình một câu chuyện
                            riêng,
                            một cảm xúc cần được truyền tải hoàn hảo. Đội ngũ kỹ sư của chúng tôi không chỉ là những
                            chuyên gia
                            kỹ thuật, mà còn là những người đồng hành nhiệt huyết, sẵn sàng lắng nghe và biến ý tưởng
                            của bạn
                            thành hiện thực.
                        </p>
                        <div class="flex items-center gap-4 relative z-10">
                            <div class="h-px flex-1 bg-gradient-to-r from-gold to-transparent"></div>
                            <span class="font-sans font-bold text-gold text-sm tracking-widest">TD Classic Team</span>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: CONTACT FORM -->
                <div class="lg:col-span-7">
                    <div class="bg-surface p-8 md:p-12 border border-white/5 relative overflow-hidden">
                        <!-- Decorative element -->
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-gold/5 rounded-full blur-3xl pointer-events-none">
                        </div>

                        <h2 class="font-sans font-bold text-2xl text-white mb-2">Điền Thông Tin</h2>
                        <p class="font-sans text-gray-500 text-xs uppercase tracking-widest mb-10">Phản hồi trong vòng 2
                            giờ làm việc</p>

                        <form id="contact-form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>"
                            class="space-y-8">
                            <div class="grid md:grid-cols-2 gap-8">
                                <div class="input-group">
                                    <input type="text" id="name" name="contact_name" class="input-field" required
                                        placeholder=" ">
                                    <label for="name" class="input-label">Họ và tên *</label>
                                </div>
                                <div class="input-group">
                                    <input type="tel" id="phone" name="contact_phone" class="input-field" required
                                        placeholder=" ">
                                    <label for="phone" class="input-label">Số điện thoại *</label>
                                </div>
                            </div>

                            <div class="input-group">
                                <input type="email" id="email" name="contact_email" class="input-field" placeholder=" ">
                                <label for="email" class="input-label">Email (Tùy chọn)</label>
                            </div>

                            <div class="input-group">
                                <input type="text" id="company" name="contact_company" class="input-field"
                                    placeholder=" ">
                                <label for="company" class="input-label">Công ty / Dự án</label>
                            </div>

                            <div class="input-group">
                                <label class="text-gray-500 text-xs uppercase tracking-widest block mb-4">Loại hình quan
                                    tâm</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" name="contact_interests[]" value="Bar & Lounge">
                                        <span class="text-gray-400 text-sm group-hover:text-white transition-colors">Bar
                                            & Lounge</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" name="contact_interests[]" value="Karaoke Kinh Doanh">
                                        <span
                                            class="text-gray-400 text-sm group-hover:text-white transition-colors">Karaoke
                                            Kinh Doanh</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" name="contact_interests[]" value="Hội Trường / Sự Kiện">
                                        <span class="text-gray-400 text-sm group-hover:text-white transition-colors">Hội
                                            Trường / Sự Kiện</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" name="contact_interests[]" value="Mua lẻ thiết bị">
                                        <span class="text-gray-400 text-sm group-hover:text-white transition-colors">Mua
                                            lẻ thiết bị</span>
                                    </label>
                                </div>
                            </div>

                            <div class="input-group">
                                <textarea id="message" name="contact_message" class="input-field h-32 resize-none"
                                    required placeholder=" "></textarea>
                                <label for="message" class="input-label">Nội dung cần tư vấn *</label>
                            </div>

                            <div class="pt-4">
                                <button type="submit"
                                    class="w-full bg-gold hover:bg-white text-black font-serif font-bold uppercase tracking-[0.2em] py-4 transition-all duration-300 flex items-center justify-center gap-2 group">
                                    Gửi thông tin <i data-lucide="arrow-right"
                                        class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                                </button>
                                <p class="text-center text-gray-600 text-[10px] mt-4 font-sans">
                                    Bằng việc gửi thông tin, bạn đồng ý với chính sách bảo mật của chúng tôi.
                                </p>
                            </div>

                            <input type="hidden" name="action" value="handle_contact_form">
                            <input type="hidden" name="nonce"
                                value="<?php echo wp_create_nonce('contact_form_nonce'); ?>">
                        </form>

                        <!-- Form response message -->
                        <div id="form-response" class="mt-4 hidden"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MAP SECTION (Redesigned with Individual Location Cards) -->
    <section class="py-20 bg-metal border-t border-white/5">
        <div class="container mx-auto px-6 md:px-12">
            <div class="text-center mb-12">
                <span class="font-sans text-gold text-xs tracking-[0.3em] uppercase block mb-4">Find Us</span>
                <h2 class="font-sans font-bold text-3xl md:text-4xl text-white mb-4">Tìm Đường Đến TD Classic</h2>
                <div class="w-24 h-[1px] bg-gradient-to-r from-transparent via-gold to-transparent mx-auto mb-4"></div>
                <p class="text-gray-400 text-sm font-sans">Chọn địa điểm bạn muốn ghé thăm</p>
            </div>

            <div class="max-w-6xl mx-auto">
                <!-- Location Tabs -->
                <div class="flex flex-wrap gap-3 justify-center mb-10">
                    <button onclick="showLocation('showroom')" data-location="showroom"
                        class="location-tab active bg-gold text-black px-6 py-3 font-sans text-sm font-semibold uppercase tracking-wider transition-all duration-300 hover:bg-white">
                        <i data-lucide="building-2" class="w-4 h-4 inline mr-2"></i>
                        Showroom An Dương
                    </button>
                    <button onclick="showLocation('hanoi')" data-location="hanoi"
                        class="location-tab bg-surface text-gray-400 px-6 py-3 font-sans text-sm font-semibold uppercase tracking-wider transition-all duration-300 hover:bg-void hover:text-white">
                        <i data-lucide="map-pin" class="w-4 h-4 inline mr-2"></i>
                        VP Hà Nội
                    </button>

                </div>

                <!-- Location Content Containers -->
                <div class="space-y-8">

                    <!-- SHOWROOM LOCATION -->
                    <div id="location-showroom" class="location-content active">
                        <div class="grid lg:grid-cols-5 gap-8">
                            <!-- Location Info Card -->
                            <div class="lg:col-span-2 bg-void border border-gold/30 p-8 relative overflow-hidden group">
                                <div
                                    class="absolute -right-6 -top-6 w-24 h-24 bg-gold/10 rounded-full blur-2xl group-hover:bg-gold/20 transition-all">
                                </div>
                                <div
                                    class="absolute top-4 right-4 bg-gold text-black px-3 py-1 text-[10px] font-bold uppercase tracking-widest">
                                    Trải nghiệm
                                </div>

                                <div class="relative z-10">
                                    <div class="w-12 h-12 border-2 border-gold flex items-center justify-center mb-4">
                                        <i data-lucide="building-2" class="w-6 h-6 text-gold"></i>
                                    </div>
                                    <h3 class="font-sans font-bold text-xl text-white mb-2">Showroom Trưng Bày</h3>
                                    <p class="text-xs text-gold uppercase tracking-wider mb-6 font-sans">Địa điểm chính
                                    </p>

                                    <div class="space-y-4 mb-6">
                                        <div class="flex items-start gap-3">
                                            <i data-lucide="map-pin" class="w-4 h-4 text-gold flex-shrink-0 mt-1"></i>
                                            <p class="text-sm text-gray-300 font-sans leading-relaxed">
                                            Lô BT36-06 Khu đô thị (KĐT) thương mại & nhà ở công nhân Tràng Duệ, Phường An Dương, TP Hải Phòng, Việt Nam
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i data-lucide="phone" class="w-4 h-4 text-gold flex-shrink-0"></i>
                                            <a href="tel:<?php echo esc_attr(str_replace(' ', '', $primary_phone)); ?>"
                                                class="text-sm text-white hover:text-gold transition-colors">
                                                <?php echo esc_html($primary_phone); ?>
                                            </a>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i data-lucide="clock" class="w-4 h-4 text-gold flex-shrink-0"></i>
                                            <span class="text-sm text-gray-400">Phục vụ 24/7</span>
                                        </div>
                                    </div>

                                    <a href="https://maps.google.com/?q=111A+tổ+3+Thị+trấn+An+Dương+Hải+Phòng"
                                        target="_blank"
                                        class="inline-flex items-center gap-2 bg-gold text-black px-6 py-3 font-sans text-sm font-bold uppercase tracking-wider hover:bg-white transition-all duration-300 group/btn">
                                        <i data-lucide="navigation"
                                            class="w-4 h-4 group-hover/btn:rotate-45 transition-transform"></i>
                                        Chỉ đường
                                    </a>
                                </div>
                            </div>

                            <!-- Map -->
                            <div
                                class="lg:col-span-3 bg-void border border-white/10 overflow-hidden relative h-[450px]">
                                <div class="absolute inset-0 bg-void/20 pointer-events-none z-10"></div>
                                <iframe class="w-full h-full"
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3727.5!2d106.586!3d20.877!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjDCsDUyJzM3LjIiTiAxMDbCsDM1JzA5LjYiRQ!5e0!3m2!1svi!2s!4v1620000000000!5m2!1svi!2s"
                                    style="border:0;" allowfullscreen="" loading="lazy">
                                </iframe>
                            </div>
                        </div>
                    </div>



                    <!-- HÀ NỘI OFFICE LOCATION -->
                    <div id="location-hanoi" class="location-content hidden">
                        <div class="grid lg:grid-cols-5 gap-8">
                            <!-- Location Info Card -->
                            <div class="lg:col-span-2 bg-surface border border-white/10 p-8 relative">
                                <div class="w-12 h-12 border border-white/20 flex items-center justify-center mb-4">
                                    <i data-lucide="briefcase" class="w-6 h-6 text-gold"></i>
                                </div>
                                <h3 class="font-sans font-bold text-xl text-white mb-2">Văn Phòng Hà Nội</h3>
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-6 font-sans">Representative
                                    Office</p>

                                <div class="space-y-4 mb-6">
                                    <div class="flex items-start gap-3">
                                        <i data-lucide="map-pin" class="w-4 h-4 text-gold flex-shrink-0 mt-1"></i>
                                        <p class="text-sm text-gray-300 font-sans leading-relaxed">
                                            Lô 5 - TT7 - Khu đấu giá Tứ Hiệp, Thanh Trì, Hà Nội
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <i data-lucide="phone" class="w-4 h-4 text-gold flex-shrink-0"></i>
                                        <a href="tel:<?php echo esc_attr(str_replace(' ', '', $primary_phone)); ?>"
                                            class="text-sm text-white hover:text-gold transition-colors">
                                            <?php echo esc_html($primary_phone); ?>
                                        </a>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <i data-lucide="users" class="w-4 h-4 text-gold flex-shrink-0"></i>
                                        <span class="text-sm text-gray-400">Tư vấn & Hỗ trợ khu vực phía Bắc</span>
                                    </div>
                                </div>

                                <a href="https://maps.google.com/?q=Lô+5+TT7+Khu+Tứ+Hiệp+Thanh+Trì+Hà+Nội"
                                    target="_blank"
                                    class="inline-flex items-center gap-2 border border-gold text-gold px-6 py-3 font-sans text-sm font-bold uppercase tracking-wider hover:bg-gold hover:text-black transition-all duration-300 group/btn">
                                    <i data-lucide="navigation"
                                        class="w-4 h-4 group-hover/btn:rotate-45 transition-transform"></i>
                                    Chỉ đường
                                </a>
                            </div>

                            <!-- Map -->
                            <div
                                class="lg:col-span-3 bg-void border border-white/10 overflow-hidden relative h-[450px]">
                                <div class="absolute inset-0 bg-void/20 pointer-events-none z-10"></div>
                                <iframe class="w-full h-full"
                                    src="https://maps.google.com/maps?q=L%C3%B4+5+-+TT7+-+Khu+%C4%91%E1%BA%A5u+gi%C3%A1+T%E1%BB%A9+Hi%E1%BB%87p,+Thanh+Tr%C3%AC,+H%C3%A0+N%E1%BB%99i&output=embed"
                                    style="border:0;" allowfullscreen="" loading="lazy">
                                </iframe>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </section>

    <?php get_footer(); ?>

    <script>
        lucide.createIcons();

        // Location tab switching
        function showLocation(location) {
            // Hide all location contents
            document.querySelectorAll('.location-content').forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('active');
            });

            // Remove active class from all tabs
            document.querySelectorAll('.location-tab').forEach(tab => {
                tab.classList.remove('active', 'bg-gold', 'text-black');
                tab.classList.add('bg-surface', 'text-gray-400');
            });

            // Show selected location content
            const selectedContent = document.getElementById('location-' + location);
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
                selectedContent.classList.add('active');
            }

            // Activate selected tab
            event.target.classList.add('active', 'bg-gold', 'text-black');
            event.target.classList.remove('bg-surface', 'text-gray-400');

            // Reinitialize Lucide icons for newly shown content
            lucide.createIcons();
        }

        // Contact form handling
        document.getElementById('contact-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const responseDiv = document.getElementById('form-response');

            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i data-lucide="loader" class="w-4 h-4 animate-spin"></i> Đang gửi...';
            lucide.createIcons();

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    responseDiv.classList.remove('hidden');
                    if (data.success) {
                        responseDiv.className = 'mt-4 p-4 bg-green-500/10 border border-green-500 text-green-500 font-sans text-sm rounded';
                        responseDiv.textContent = data.data.message || 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất.';
                        this.reset();
                    } else {
                        responseDiv.className = 'mt-4 p-4 bg-red-500/10 border border-red-500 text-red-500 font-sans text-sm rounded';
                        responseDiv.textContent = data.data || 'Có lỗi xảy ra. Vui lòng thử lại.';
                    }
                })
                .catch(error => {
                    responseDiv.classList.remove('hidden');
                    responseDiv.className = 'mt-4 p-4 bg-red-500/10 border border-red-500 text-red-500 font-sans text-sm rounded';
                    responseDiv.textContent = 'Có lỗi xảy ra. Vui lòng thử lại.';
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Gửi thông tin <i data-lucide="arrow-right" class="w-4 h-4"></i>';
                    lucide.createIcons();
                });
        });
    </script>

    <?php wp_footer(); ?>
</body>

</html>