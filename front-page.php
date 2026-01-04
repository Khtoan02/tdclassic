<?php
/**
 * The front page template file
 *
 * @package TD Classic
 */

get_header();
?>

<!-- Page specific styles moved to style.css and Tailwind loaded via functions.php -->

<div class="td-redesign-wrapper antialiased selection:bg-gold selection:text-black">

    <!-- Noise Overlay -->
    <div class="noise"></div>

    <!-- 1. HERO SECTION -->
    <!-- Custom Animations & Slider Styles -->
    <style>
        @keyframes slowZoom {
            0% { transform: scale(1); }
            100% { transform: scale(1.15); }
        }
        @keyframes fadeUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes progressLoading {
            0% { width: 0%; }
            100% { width: 100%; }
        }
        .animate-slow-zoom {
            animation: slowZoom 20s linear infinite alternate;
        }
        .animate-fade-up-1 { animation: fadeUp 0.8s ease-out forwards; opacity: 0; }
        .animate-fade-up-2 { animation: fadeUp 0.8s ease-out 0.2s forwards; opacity: 0; }
        .animate-fade-up-3 { animation: fadeUp 0.8s ease-out 0.4s forwards; opacity: 0; }
        .animate-fade-up-4 { animation: fadeUp 0.8s ease-out 0.6s forwards; opacity: 0; }
        
        /* Slider Classes */
        .hero-slide {
            transition: opacity 1.2s ease-in-out;
            opacity: 0; 
            z-index: 0;
            pointer-events: none;
        }
        .hero-slide.active {
            opacity: 1;
            z-index: 1;
            pointer-events: auto;
        }
        
        /* Progress Bar */
        .slide-progress-bar {
            height: 2px;
            background: rgba(255,255,255,0.2);
            position: relative;
            overflow: hidden;
        }
        .slide-progress-fill {
            height: 100%;
            background: #D4AF37;
            width: 0;
        }
        .slide-progress-fill.running {
            animation: progressLoading 5s linear infinite;
        }
        
        /* Premium Button */
        .btn-gold {
            background: linear-gradient(45deg, #D4AF37, #F2D06B);
            color: #000;
            position: relative;
            overflow: hidden;
        }
        .btn-gold::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: 0.5s;
        }
        .btn-gold:hover::after {
            left: 100%;
        }
        .nav-btn {
            backdrop-filter: blur(5px);
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s;
        }
        .nav-btn:hover {
            background: #D4AF37;
            border-color: #D4AF37;
            color: black;
        }
    </style>

    <!-- 1. HERO SECTION (Premium Cinematic - Aligned) -->
    <section class="relative w-full bg-black group overflow-hidden h-[85vh] md:h-auto md:aspect-[21/9]">
        
        <!-- SLIDER BACKGROUNDS -->
        <div id="hero-slider-container" class="absolute inset-0 w-full h-full">
            <!-- Slide 1 -->
            <div class="hero-slide active absolute inset-0 w-full h-full">
                <img src="https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?q=80&w=1920&auto=format&fit=crop"
                    class="w-full h-full object-cover animate-slow-zoom" alt="Stage Light">
            </div>
            <!-- Slide 2 -->
            <div class="hero-slide absolute inset-0 w-full h-full">
                <img src="https://images.unsplash.com/photo-1598653222000-6b7b7a552625?q=80&w=1920&auto=format&fit=crop"
                    class="w-full h-full object-cover animate-slow-zoom" alt="Technology">
            </div>
            <!-- Slide 3 -->
            <div class="hero-slide absolute inset-0 w-full h-full">
                <img src="https://images.unsplash.com/photo-1470222557941-b682485a77c2?q=80&w=1920&auto=format&fit=crop"
                    class="w-full h-full object-cover animate-slow-zoom" style="animation-delay: -5s;" alt="Live Event">
            </div>

            <!-- Premium Gradient Overlay (Smoother transition) -->
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent opacity-90 pointer-events-none z-10"></div>
        </div>

        <!-- HERO CONTENT (Strict Container Alignment) -->
        <div class="absolute inset-0 z-20 flex items-end">
            <div class="container mx-auto px-6 md:px-12 pb-16 md:pb-20 relative">
                
                <!-- Content Group -->
                <div class="max-w-4xl relative">
                    
                    <!-- Eyebrow -->
                    <div class="flex items-center gap-4 mb-6 animate-fade-up-1">
                        <div class="w-12 h-[1px] bg-gold"></div>
                        <span class="font-sans text-gold text-[10px] md:text-sm tracking-[0.3em] font-bold uppercase drop-shadow-md">Professional Audio Systems</span>
                    </div>

                    <!-- Main Title (Massive & Tight) -->
                    <h1 class="animate-fade-up-2 font-serif text-5xl md:text-7xl lg:text-9xl text-white leading-[0.9] mb-8 tracking-tighter drop-shadow-2xl">
                        The Art <br class="md:hidden"> of Sound
                    </h1>

                    <!-- Description -->
                    <p class="animate-fade-up-3 font-sans text-gray-300 text-sm md:text-xl font-light leading-relaxed max-w-2xl mb-10 drop-shadow-lg opacity-90 border-l border-white/20 pl-6">
                        TD Classic định nghĩa lại trải nghiệm âm thanh chuyên nghiệp. <br class="hidden md:block">
                        Kiệt tác kỹ thuật Châu Âu, tinh chỉnh cho tâm hồn Việt.
                    </p>

                    <!-- Status / Scroll Indicator -->
                    <div class="animate-fade-up-4 flex items-center gap-4">
                        <div class="h-1 w-20 bg-gold rounded-full"></div>
                    </div>
                </div>

                <!-- DECORATIVE STAR (Aligned to Container Right) -->
                <div class="absolute bottom-20 right-6 md:right-12 z-20 hidden md:block animate-pulse-slow">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="currentColor" class="text-white/10 rotate-12">
                        <path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- NAVIGATION ARROWS (Floating Cleanly) -->
        <button onclick="prevSlide()" class="hidden md:flex absolute top-1/2 left-0 z-30 w-24 h-full items-center justify-center text-white/10 hover:text-white/60 transition-colors duration-500 group -translate-y-1/2">
            <i data-lucide="chevron-left" class="w-20 h-20 stroke-[0.5] transform group-hover:-translate-x-2 transition-transform duration-500"></i>
        </button>

        <button onclick="nextSlide()" class="hidden md:flex absolute top-1/2 right-0 z-30 w-24 h-full items-center justify-center text-white/10 hover:text-white/60 transition-colors duration-500 group -translate-y-1/2">
            <i data-lucide="chevron-right" class="w-20 h-20 stroke-[0.5] transform group-hover:translate-x-2 transition-transform duration-500"></i>
        </button>

    </section>

    <script>
        // Professional Slider Logic
        let currentSlide = 0;
        const slides = document.querySelectorAll('.hero-slide');
        const slideFill = document.getElementById('slide-fill');
        const currentEl = document.getElementById('slide-current');
        const totalSlides = slides.length;
        let slideInterval;
        let isAutoPlaying = true;

        function updateSliderUI(index) {
            // Update Number
            currentEl.textContent = '0' + (index + 1);
            
            // Reset Animation
            slideFill.classList.remove('running');
            void slideFill.offsetWidth; // trigger reflow
            if(isAutoPlaying) slideFill.classList.add('running');
            else slideFill.style.width = '100%'; // Full if paused manually
        }

        function showSlide(index) {
            // Handle Wrap
            if (index >= totalSlides) currentSlide = 0;
            else if (index < 0) currentSlide = totalSlides - 1;
            else currentSlide = index;

            // Toggle Classes
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === currentSlide);
            });
            
            updateSliderUI(currentSlide);
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        function prevSlide() {
            resetAutoPlay(); // Interaction stops auto for a moment or permanently? Let's just reset timer
            showSlide(currentSlide - 1);
        }
        
        // Wrapper for Next button to reset timer too
        const manualNext = () => {
             resetAutoPlay();
             nextSlide();
        }
        
        // Override the onclicks in HTML for cleaner logic if needed, but direct calls work fine
        // Note: HTML onclicks call functions. We need to make sure Next button calls manualNext or similar if we want to reset.
        // Let's just update the functions called by buttons.

        function resetAutoPlay() {
            clearInterval(slideInterval);
            isAutoPlaying = true; // restart
            slideInterval = setInterval(nextSlide, 5000);
        }

        function initSlider() {
            if(slides.length === 0) return;
            slideInterval = setInterval(nextSlide, 5000);
        }

        document.addEventListener('DOMContentLoaded', initSlider);

        // Update button onclicks dynamically to use the reset logic
        document.querySelector('button[onclick="nextSlide()"]').onclick = () => {
            clearInterval(slideInterval);
            nextSlide();
            slideInterval = setInterval(nextSlide, 5000);
        };
        document.querySelector('button[onclick="prevSlide()"]').onclick = () => {
            clearInterval(slideInterval);
            showSlide(currentSlide - 1);
            slideInterval = setInterval(nextSlide, 5000);
        };
    </script>

    <!-- 2. BRAND DNA -->
    <section id="dna" class="py-32 bg-metal relative overflow-hidden">
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-24">
                <span class="font-sans text-gold text-xs tracking-cinematic uppercase block mb-4">Câu chuyện thương
                    hiệu</span>
                <h2 class="font-sans font-bold text-4xl md:text-5xl text-white">Linh Hồn Của Âm Thanh</h2>
                <div class="w-24 h-[1px] bg-gold mx-auto mt-8 opacity-50"></div>
            </div>

            <!-- Block 1: Sứ Mệnh (Mission) - Flex Logic -->
            <div class="flex flex-col md:flex-row gap-16 items-center mb-32">
                <div class="w-full md:w-1/2 relative group">
                    <div class="absolute -top-4 -left-4 w-24 h-24 border-t border-l border-gold/30"></div>
                    <div
                        class="aspect-[4/3] overflow-hidden transition-all duration-1000">
                        <img src="https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=1200&auto=format&fit=crop"
                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-1000"
                            alt="Sứ mệnh âm thanh" loading="lazy">
                    </div>
                </div>
                <div class="w-full md:w-1/2 lg:pl-12">
                    <span
                        class="text-6xl font-serif text-white/5 absolute -translate-y-10 -translate-x-4">Mission</span>
                    <h3 class="text-3xl font-sans font-bold text-white mb-6 relative z-10">Sứ Mệnh Kiến Tạo</h3>
                    <p class="font-sans text-gray-400 font-light leading-relaxed text-lg mb-6 text-justify">
                        Sứ mệnh của TD Classic không dừng lại ở việc sản xuất thiết bị. Chúng tôi khao khát <strong>xóa
                            nhòa ranh giới</strong> giữa âm thanh tái tạo và âm thanh thực tế. Mỗi sản phẩm ra đời là
                        kết quả của hàng ngàn giờ nghiên cứu để mang lại rung cảm chân thật nhất cho người nghe.
                    </p>
                    <div class="flex items-center gap-4 text-gold text-sm font-sans tracking-widest uppercase">
                        <span>Trung thực</span> <span class="w-1 h-1 bg-gold rounded-full"></span> <span>Cảm xúc</span>
                    </div>
                </div>
            </div>

            <!-- Block 2: Tầm Nhìn (Vision) - Flex Logic Reversed -->
            <div class="flex flex-col md:flex-row-reverse gap-16 items-center mb-32">
                <div class="w-full md:w-1/2 relative group">
                    <div class="absolute -bottom-4 -right-4 w-24 h-24 border-b border-r border-gold/30"></div>
                    <div
                        class="aspect-[4/3] overflow-hidden transition-all duration-1000">
                        <img src="https://tdclassic.vn/wp-content/uploads/2025/10/2-HE-THONG-AM-THANH-GOM-NHUNG-GI.jpg"
                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-1000"
                            alt="Tầm nhìn" loading="lazy">
                    </div>
                </div>
                <div class="w-full md:w-1/2 lg:pr-12 text-left md:text-right">
                    <span
                        class="text-6xl font-serif text-white/5 absolute -translate-y-10 right-auto md:right-0 md:left-auto left-0 translate-x-0 md:translate-x-12">Vision</span>
                    <h3 class="text-3xl font-sans font-bold text-white mb-6 relative z-10">Tầm Nhìn Vươn Xa</h3>
                    <p class="font-sans text-gray-400 font-light leading-relaxed text-lg mb-6 text-justify md:text-right"
                        dir="auto">
                        Định vị trở thành biểu tượng <strong>số 1 về Pro Audio</strong> tại Việt Nam. TD Classic hướng
                        tới việc xây dựng một hệ sinh thái âm thanh toàn diện, nơi công nghệ phục vụ nghệ thuật, và chất
                        lượng Việt Nam vươn tầm quốc tế.
                    </p>
                </div>
            </div>

            <!-- Block 3: Giá Trị Cốt Lõi -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-void p-8 border border-white/5 hover:border-gold/50 transition-colors group">
                    <i data-lucide="gem"
                        class="w-10 h-10 text-gold mb-6 stroke-1 group-hover:scale-110 transition-transform"></i>
                    <h4 class="font-sans font-bold text-xl text-white mb-4">Tinh Hoa (Craftsmanship)</h4>
                    <p class="font-sans text-gray-500 text-sm leading-relaxed">
                        Sự tỉ mỉ trong từng mối hàn, từng lớp sơn. Chúng tôi coi mỗi sản phẩm là một tác phẩm nghệ thuật
                        cần được hoàn thiện thủ công kết hợp công nghệ chính xác.
                    </p>
                </div>
                <div class="bg-void p-8 border border-white/5 hover:border-gold/50 transition-colors group">
                    <i data-lucide="users"
                        class="w-10 h-10 text-gold mb-6 stroke-1 group-hover:scale-110 transition-transform"></i>
                    <h4 class="font-sans font-bold text-xl text-white mb-4">Con Người (People)</h4>
                    <p class="font-sans text-gray-500 text-sm leading-relaxed">
                        Đội ngũ kỹ sư R&D và kỹ thuật viên không chỉ giỏi chuyên môn mà còn có đôi tai thẩm âm tinh tế,
                        thấu hiểu nhu cầu khắt khe của khách hàng.
                    </p>
                </div>
                <div class="bg-void p-8 border border-white/5 hover:border-gold/50 transition-colors group">
                    <i data-lucide="map"
                        class="w-10 h-10 text-gold mb-6 stroke-1 group-hover:scale-110 transition-transform"></i>
                    <h4 class="font-sans font-bold text-xl text-white mb-4">Quy Mô (Scale)</h4>
                    <p class="font-sans text-gray-500 text-sm leading-relaxed">
                        Mạng lưới phân phối trải rộng 3 miền. Hệ thống Showroom tiêu chuẩn Lab. Hàng ngàn dự án đã được
                        lắp đặt và vận hành ổn định.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. CATEGORY OVERVIEW (Dynamic from Admin Images) -->
    <?php
    // Define Category Sections & Fetch Dynamic Images
    $sections = [
        [
            'id' => 'mixer',
            'bg' => 'bg-metal',
            'cat_slug' => 'mixer',
            'cat_num' => '01',
            'short_title' => 'Bàn Trộn',
            'title' => 'Bàn Trộn Âm Thanh',
            'desc' => 'Trái tim của hệ thống live sound. Bàn trộn TD Classic cung cấp khả năng mix nhạc cụ và giọng hát chính xác, với Preamp độ ồn thấp và EQ âm nhạc cao cấp.',
            'specs' => ['• Preamp chất lượng cao', '• Tích hợp Effects chuyên nghiệp', '• Kết nối USB/Bluetooth linh hoạt'],
            'img' => '', // Will be dynamic
            'reverse' => false
        ],
        [
            'id' => 'speakers',
            'bg' => 'bg-void',
            'cat_slug' => 'professional-speaker',
            'cat_num' => '02',
            'short_title' => 'Loa Pro', 
            'title' => 'Loa Chuyên Nghiệp',
            'desc' => 'Dòng loa biểu diễn đỉnh cao. Củ loa Neodymium tái tạo trung âm dày, treble tơi nhuyễn. Phù hợp cho sự kiện, hội trường và các không gian giải trí cao cấp.',
            'specs' => ['• Công suất cực đại lớn', '• Góc phủ âm tối ưu', '• Linh kiện nhập khẩu Châu Âu'],
            'img' => '',
            'reverse' => true
        ],
        [
            'id' => 'amps',
            'bg' => 'bg-metal',
            'cat_slug' => 'amplifier',
            'cat_num' => '03',
            'short_title' => 'Khuếch Đại', 
            'title' => 'Thiết Bị Khuếch Đại',
            'desc' => 'Sức mạnh tiềm ẩn. Dòng cục đẩy công suất TD Classic đảm bảo sự ổn định và uy lực cho toàn bộ hệ thống loa, hoạt động bền bỉ 24/7.',
            'specs' => ['• Mạch công suất hiệu suất cao', '• Nguồn xuyến ổn định', '• Hệ thống bảo vệ toàn diện'],
            'img' => '',
            'reverse' => false
        ],
        [
            'id' => 'processor',
            'bg' => 'bg-void',
            'cat_slug' => 'signal-processor',
            'cat_num' => '04',
            'short_title' => 'Bộ Xử Lý', 
            'title' => 'Bộ Xử Lý Tín Hiệu',
            'desc' => 'Bộ não thông minh. Các thiết bị DSP, Crossover và Equalizer giúp tinh chỉnh chi tiết từng dải tần, tối ưu hóa không gian âm học.',
            'specs' => ['• Chip DSP 32-bit/64-bit', '• Giao diện điều khiển trực quan', '• Xử lý độ trễ cực thấp'],
            'img' => '',
            'reverse' => true
        ],
        [
            'id' => 'mics',
            'bg' => 'bg-metal',
            'cat_slug' => 'microphone',
            'cat_num' => '05',
            'short_title' => 'Micro', 
            'title' => 'Microphone',
            'desc' => 'Bắt trọn cảm xúc. Micro không dây và có dây với độ nhạy cao, khả năng chống hú tốt và tái tạo giọng hát trung thực, ấm áp.',
            'specs' => ['• Sóng UHF ổn định', '• Củ mic độ nhạy cao', '• Thiết kế sang trọng, bền bỉ'],
            'img' => '',
            'reverse' => false
        ],
        [
            'id' => 'power',
            'bg' => 'bg-void',
            'cat_slug' => 'quan-ly-nguon',
            'cat_num' => '06',
            'short_title' => 'Q.Lý Nguồn', 
            'title' => 'Quản Lý Nguồn',
            'desc' => 'An toàn tuyệt đối. Thiết bị quản lý nguồn giúp bật tắt hệ thống theo trình tự, bảo vệ thiết bị khỏi sốc điện và các sự cố lưới điện.',
            'specs' => ['• Aptomat bảo vệ quá tải', '• Lọc nhiễu nguồn điện', '• Hiển thị điện áp thời gian thực'],
            'img' => '',
            'reverse' => true
        ],
    ];

    // Dynamic Image Fetching Logic
    foreach ($sections as &$sec) {
        $term = get_term_by('slug', $sec['cat_slug'], 'product_cat');
        if ($term && !is_wp_error($term)) {
            $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
            if ($thumbnail_id) {
                // Get Image URL (Use 'large' to ensure high quality for both grid and banner)
                $image_url = wp_get_attachment_image_url($thumbnail_id, 'large'); 
                if ($image_url) {
                    $sec['img'] = $image_url;
                }
            }
        }
        // Fallback if no admin image found
        if (empty($sec['img'])) {
             // Fallback to a placeholder or keep empty (which might default to placeholder in loop if logic added)
             $sec['img'] = 'https://placehold.co/600x400/1a1a1a/D4AF37?text=' . urlencode($sec['title']);
        }
    }
    unset($sec);
    ?>

    <section id="overview" class="py-24 bg-void">
        <div class="container mx-auto px-6 md:px-12">
            <div class="text-center mb-16">
                <span class="font-sans text-gold text-xs tracking-cinematic uppercase">Tổng quan danh mục</span>
                <h2 class="font-sans font-bold text-3xl md:text-5xl text-white mb-6">Hệ Sinh Thái Sản Phẩm</h2>
            </div>
            
            <!-- Dynamic Grid Loop -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <?php foreach ($sections as $grid_item): ?>
                <a href="#<?php echo esc_attr($grid_item['id']); ?>"
                    class="group relative aspect-[3/4] bg-surface overflow-hidden border border-white/5 hover:border-gold/50 transition-all">
                    <img src="<?php echo esc_url($grid_item['img']); ?>"
                        class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700"
                        loading="lazy">
                    <div class="absolute bottom-4 left-0 w-full text-center">
                        <p class="font-sans font-bold text-white text-lg group-hover:text-gold transition-colors">
                            <?php echo esc_html($grid_item['short_title']); ?>
                        </p>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- 4. PRODUCT SECTIONS (DYNAMIC & CHECKED ZIGZAG) -->

    <?php
    // $sections is already defined and enriched above.
    foreach ($sections as $sec):
        // Using FLEX ROW REVERSE for Robust Zigzag (Compatible with Tailwind CDN)
        // If Reverse=True (Image Left, Text Right) -> Use flex-row
        // If Reverse=False (Text Left, Image Right) -> Use flex-row-reverse
        // Note: DOM order is Image First, Text Second.
        // flex-row: Image - Text
        // flex-row-reverse: Text - Image
        $flex_class = $sec['reverse'] ? 'md:flex-row' : 'md:flex-row-reverse';
        ?>
        <section id="<?php echo esc_attr($sec['id']); ?>"
            class="<?php echo esc_attr($sec['bg']); ?> py-24 border-t border-white/5">
            <div class="container mx-auto px-6 md:px-12">
                <!-- Intro Block -->
                <!-- Flex Container with Zigzag Logic -->
                <div class="flex flex-col <?php echo $flex_class; ?> gap-16 items-center mb-12">

                    <!-- Image Wrapper (Always First in DOM for Mobile Stack Image-Top) -->
                    <div class="w-full md:w-1/2 relative h-[400px] bg-void overflow-hidden group border border-white/5">
                        <img src="<?php echo esc_url($sec['img']); ?>"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                            alt="Cover" loading="lazy">
                    </div>

                    <!-- Text Wrapper (Always Second in DOM) -->
                    <div class="w-full md:w-1/2">
                        <span class="font-sans text-gold text-xs tracking-cinematic uppercase block mb-4">Category
                            <?php echo esc_html($sec['cat_num']); ?></span>
                        <h3 class="font-sans font-bold text-3xl md:text-5xl text-white mb-6 leading-tight">
                            <?php echo esc_html($sec['title']); ?>
                        </h3>
                        <p class="font-sans text-gray-400 font-light leading-relaxed mb-6 text-justify">
                            <?php echo esc_html($sec['desc']); ?>
                        </p>
                        <ul class="space-y-2 font-sans text-sm text-gray-500">
                            <?php foreach ($sec['specs'] as $spec): ?>
                                <li><?php echo esc_html($spec); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </div>

                <!-- Product Slider (Dynamic) -->
                <div class="relative">
                    <h3 class="font-sans text-white text-sm uppercase tracking-widest mb-6 border-l-2 border-gold pl-4">Sản
                        phẩm nổi bật (Vuốt để xem)</h3>
                    <div class="flex overflow-x-auto gap-6 pb-8 snap-x no-scrollbar">
                        <?php
                        $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 6,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field' => 'slug',
                                    'terms' => $sec['cat_slug']
                                )
                            )
                        );
                        $query = new WP_Query($args);

                        if ($query->have_posts()):
                            while ($query->have_posts()):
                                $query->the_post();
                                global $product;
                                $price = $product ? $product->get_price_html() : '';
                                ?>
                                <!-- Item -->
                                <div
                                    class="min-w-[280px] md:min-w-[320px] snap-start bg-<?php echo ($sec['bg'] === 'bg-metal') ? 'void' : 'metal'; ?> p-4 border border-white/5 group hover:border-gold/50 transition-all">
                                    <div class="aspect-square bg-surface overflow-hidden mb-4 relative">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php if (has_post_thumbnail()): ?>
                                                <img src="<?php the_post_thumbnail_url('medium_large'); ?>"
                                                    class="w-full h-full object-cover zoom-img"
                                                    loading="lazy">
                                            <?php else: ?>
                                                <div class="w-full h-full flex items-center justify-center bg-gray-800 text-gray-600">No
                                                    Image</div>
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <h4 class="text-white font-sans font-bold text-lg truncate"><a
                                            href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    <p class="text-xs text-gray-500 mb-2 truncate">
                                        <?php
                                        $cats = get_the_terms(get_the_ID(), 'product_cat');
                                        if ($cats && !is_wp_error($cats)) {
                                            echo esc_html($cats[0]->name);
                                        }
                                        ?>
                                    </p>
                                    <p class="text-gold text-xs tracking-wider">
                                        <?php echo $price ? $price : 'Liên hệ'; ?>
                                    </p>
                                </div>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        else:
                            ?>
                            <div class="p-8 text-gray-500 italic">Đang cập nhật sản phẩm cho danh mục này...</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endforeach; ?>

    <!-- 5. TECHNOLOGY & QUALITY -->
    <section class="py-32 bg-metal relative overflow-hidden border-y border-white/5">
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10"></div>
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-16">
                <span class="font-sans text-gold text-xs tracking-cinematic uppercase">Technology</span>
                <h2 class="font-sans font-bold text-3xl md:text-5xl text-white mb-6">Công Nghệ & Chất Lượng</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="p-6 border border-white/5 hover:bg-void transition-colors">
                    <i data-lucide="cpu" class="w-10 h-10 text-gold mb-4"></i>
                    <h4 class="text-white font-sans font-bold text-xl mb-3 text-center">DSP 32-Bit</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">Chip xử lý tín hiệu kỹ thuật số tiên tiến nhất, cho
                        độ phân giải âm thanh cao.</p>
                </div>
                <div class="p-6 border border-white/5 hover:bg-void transition-colors">
                    <i data-lucide="activity" class="w-10 h-10 text-gold mb-4"></i>
                    <h4 class="text-white font-sans font-bold text-xl mb-3 text-center">RTA Testing</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">Đo đáp tuyến tần số thực tế (Real Time Analyzer)
                        đảm bảo độ phẳng tuyệt đối.</p>
                </div>
                <div class="p-6 border border-white/5 hover:bg-void transition-colors">
                    <i data-lucide="shield-check" class="w-10 h-10 text-gold mb-4"></i>
                    <h4 class="text-white font-sans font-bold text-xl mb-3 text-center">Burn-in 48h</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">Quy trình chạy thử tải nặng liên tục 48 giờ trước
                        khi xuất xưởng.</p>
                </div>
                <div class="p-6 border border-white/5 hover:bg-void transition-colors">
                    <i data-lucide="layers" class="w-10 h-10 text-gold mb-4"></i>
                    <h4 class="text-white font-sans font-bold text-xl mb-3 text-center">Linh Kiện Nhập</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">Tụ điện, trở, sò công suất nhập khẩu từ các thương
                        hiệu hàng đầu.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. APPLICATIONS -->
    <section class="py-32 bg-void">
        <div class="container mx-auto px-6 md:px-12">
            <div class="text-center mb-24">
                <span class="font-sans text-gold text-xs tracking-cinematic uppercase">Giải pháp chuyên sâu</span>
                <h2 class="font-sans font-bold text-3xl md:text-5xl text-white mb-6">Ứng Dụng Thực Tế</h2>
                <p class="text-gray-400 mt-4 max-w-2xl mx-auto font-light">Chúng tôi không áp dụng một công thức cho tất
                    cả. Mỗi không gian là một bài toán âm học riêng biệt cần lời giải chính xác.</p>
            </div>

            <div class="space-y-24">
                <!-- App 1: Bar & Lounge (Image Left) -->
                <!-- Use md:flex-row (Image-Text) -->
                <div class="flex flex-col md:flex-row gap-12 items-center">
                    <div class="w-full md:w-1/2 relative group">
                        <div class="absolute -top-4 -left-4 w-16 h-16 border-t border-l border-gold/50"></div>
                        <img src="https://images.unsplash.com/photo-1570752321219-41822a21a761?q=80&w=800&auto=format&fit=crop"
                            class="w-full transition-all duration-1000"
                            loading="lazy">
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="text-4xl font-serif text-white/10">01</span>
                            <h3 class="text-white font-sans font-bold text-2xl">Bar & Lounge</h3>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-gold text-xs uppercase tracking-widest mb-2">Thách thức</h4>
                                <p class="text-gray-400 text-sm font-light">Không gian ồn ào, vật liệu tiêu âm kém
                                    (kính, đá). Cần áp lực âm thanh lớn (SPL cao) để kích thích không khí nhưng không
                                    được gây chói tai hay mệt mỏi cho khách hàng ngồi lâu.</p>
                            </div>
                            <div>
                                <h4 class="text-gold text-xs uppercase tracking-widest mb-2">Giải pháp TD Classic</h4>
                                <p class="text-gray-400 text-sm font-light">Sử dụng hệ thống Array phân tán đều hoặc loa
                                    Full công suất lớn. Tinh chỉnh DSP để cắt dải tần gây chói, tăng cường dải trầm sâu
                                    (Sub-bass) tạo độ "đầm".</p>
                            </div>
                            <div class="bg-metal p-4 border border-white/5">
                                <h4 class="text-white text-xs uppercase tracking-widest mb-2">Cấu hình đề xuất</h4>
                                <p class="text-gray-500 text-xs">Loa Array LA-210 • Subwoofer S-2180 • Cục đẩy 4 kênh
                                    D-4800</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- App 2: Karaoke VIP (Text Left) -->
                <!-- Use md:flex-row-reverse (Text-Image) -->
                <div class="flex flex-col md:flex-row-reverse gap-12 items-center">
                    <div class="w-full md:w-1/2 relative group">
                        <div class="absolute -bottom-4 -right-4 w-16 h-16 border-b border-r border-gold/50"></div>
                        <img src="https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?q=80&w=800&auto=format&fit=crop"
                            class="w-full transition-all duration-1000"
                            loading="lazy">
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="text-4xl font-serif text-white/10">02</span>
                            <h3 class="text-white font-sans font-bold text-2xl">Karaoke Luxury</h3>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-gold text-xs uppercase tracking-widest mb-2">Thách thức</h4>
                                <p class="text-gray-400 text-sm font-light">Khách hàng hát không chuyên nghiệp, dễ xảy
                                    ra hú rít. Yêu cầu hiệu ứng Vocal (Echo/Reverb) phải nịnh giọng, dễ hát, nhạc nền
                                    phải bốc.</p>
                            </div>
                            <div>
                                <h4 class="text-gold text-xs uppercase tracking-widest mb-2">Giải pháp TD Classic</h4>
                                <p class="text-gray-400 text-sm font-light">Micro độ nhạy cao kết hợp Vang số chống hú 4
                                    cấp độ. Setup chế độ Effect riêng biệt cho từng thể loại nhạc (Bolero/Remix). Loa
                                    chịu tải tốt trong phòng kín.</p>
                            </div>
                            <div class="bg-metal p-4 border border-white/5">
                                <h4 class="text-white text-xs uppercase tracking-widest mb-2">Cấu hình đề xuất</h4>
                                <p class="text-gray-500 text-xs">Loa Full TD-12 Pro • Sub S-1800 • Micro M-20 Gold •
                                    Vang X-6 Pro</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- App 3: Hội Trường (Image Left) -->
                <!-- Use md:flex-row (Image-Text) -->
                <div class="flex flex-col md:flex-row gap-12 items-center">
                    <div class="w-full md:w-1/2 relative group">
                        <div class="absolute -top-4 -left-4 w-16 h-16 border-t border-l border-gold/50"></div>
                        <img src="https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=800&auto=format&fit=crop"
                            class="w-full transition-all duration-1000"
                            loading="lazy">
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="text-4xl font-serif text-white/10">03</span>
                            <h3 class="text-white font-sans font-bold text-2xl">Hội Trường & Sự Kiện</h3>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-gold text-xs uppercase tracking-widest mb-2">Thách thức</h4>
                                <p class="text-gray-400 text-sm font-light">Không gian rộng, trần cao, dễ bị vang vọng
                                    (Reverb tự nhiên) làm đục tiếng nói. Cần độ phủ âm đều cho cả hàng ghế đầu và cuối.
                                </p>
                            </div>
                            <div>
                                <h4 class="text-gold text-xs uppercase tracking-widest mb-2">Giải pháp TD Classic</h4>
                                <p class="text-gray-400 text-sm font-light">Sử dụng loa Column hoặc Array có tính định
                                    hướng cao. Tính toán góc phủ âm để giảm thiểu phản xạ trần/sàn. Tối ưu dải trung
                                    (Mid) cho giọng nói rõ nét.</p>
                            </div>
                            <div class="bg-metal p-4 border border-white/5">
                                <h4 class="text-white text-xs uppercase tracking-widest mb-2">Cấu hình đề xuất</h4>
                                <p class="text-gray-500 text-xs">Loa Column C-10s • Sub S-15 Compact • Micro W-1000</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

<script>
    // Initialize Lucide Icons
    lucide.createIcons();

    // Smooth Scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>

<?php
get_footer();