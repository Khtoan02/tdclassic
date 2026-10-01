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
        /* Hero Section Geometry (Zero Layout Shift) */
        .hero-cinematic-section {
            position: relative;
            width: 100%;
            background-color: #000;
            overflow: hidden;
            height: 700px;
        }
        @media (max-width: 768px) {
            .hero-cinematic-section {
                height: 580px;
            }
        }

        @keyframes fadeUp {
            0% { transform: translateY(8px); }
            100% { transform: translateY(0); }
        }
        @keyframes progressLoading {
            0% { width: 0%; }
            100% { width: 100%; }
        }
        .animate-fade-up-1, .animate-fade-up-2, .animate-fade-up-3, .animate-fade-up-4 {
            opacity: 1;
            transform: translateY(0);
        }
        @media (prefers-reduced-motion: no-preference) {
            .animate-fade-up-1 { animation: fadeUp 0.4s ease-out; }
            .animate-fade-up-2 { animation: fadeUp 0.5s ease-out; }
            .animate-fade-up-3 { animation: fadeUp 0.6s ease-out; }
            .animate-fade-up-4 { animation: fadeUp 0.7s ease-out; }
        }
        
        /* Slider Classes */
        .hero-slide {
            transition: opacity 0.8s ease-in-out;
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
    <section class="hero-cinematic-section group">
        
        <!-- SLIDER BACKGROUNDS -->
        <div id="hero-slider-container" class="absolute inset-0 w-full h-full">
            <div class="hero-slide active absolute inset-0 w-full h-full">
                <picture class="w-full h-full block">
                    <source media="(max-width: 768px)" srcset="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/hero/hero-1-mobile.webp'); ?>" type="image/webp">
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/hero/hero-1.webp'); ?>"
                        class="w-full h-full object-cover"
                        alt="TD Classic Live Event Hero"
                        width="1920" height="814"
                        fetchpriority="high">
                </picture>
            </div>
            <!-- Slide 1 -->
            <div class="hero-slide absolute inset-0 w-full h-full">
                <img data-src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/hero/hero-2.webp'); ?>"
                    class="w-full h-full object-cover" alt="TD Classic Stage Light"
                    width="1920" height="823"
                    loading="lazy" decoding="async">
            </div>
            <!-- Slide 2 -->
            <div class="hero-slide absolute inset-0 w-full h-full">
                <img data-src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/hero/hero-3.webp'); ?>"
                    class="w-full h-full object-cover" alt="TD Classic Technology"
                    width="1920" height="823"
                    loading="lazy" decoding="async">
            </div>
            <!-- Slide 3 -->
            <div class="hero-slide absolute inset-0 w-full h-full">
                <img data-src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/hero/hero-4.webp'); ?>"
                    class="w-full h-full object-cover" alt="TD Classic Concert Sound"
                    width="1920" height="823"
                    loading="lazy" decoding="async">
            </div>

            <!-- Premium Gradient Overlay (Smoother transition) -->
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent opacity-90 pointer-events-none z-10"></div>
        </div>

        <!-- HERO CONTENT (Strict Container Alignment) -->
        <div class="absolute inset-0 z-20 flex items-end">
            <div class="container mx-auto px-6 md:px-12 pb-12 sm:pb-16 md:pb-20 pt-28 md:pt-0 relative">
                
                <!-- Content Group -->
                <div class="max-w-4xl relative">
                    
                    <!-- Eyebrow -->
                    <div class="flex items-center gap-3 md:gap-4 mb-3 md:mb-6 animate-fade-up-1">
                        <div class="w-8 md:w-12 h-[1px] bg-gold"></div>
                        <span class="font-sans text-gold text-xs md:text-sm tracking-[0.2em] md:tracking-[0.3em] font-bold uppercase drop-shadow-md">Professional Audio Systems</span>
                    </div>

                    <!-- Main Title (Massive & Tight) -->
                    <h1 class="animate-fade-up-2 font-serif text-4xl sm:text-6xl md:text-7xl lg:text-9xl text-white leading-[1.05] md:leading-[0.9] mb-4 md:mb-8 tracking-tight md:tracking-tighter drop-shadow-2xl">
                        The Art <br class="sm:hidden"> of Sound
                    </h1>

                    <!-- Description -->
                    <p class="animate-fade-up-3 font-sans text-gray-200 text-sm sm:text-base md:text-xl font-light leading-relaxed max-w-2xl mb-6 md:mb-10 drop-shadow-lg opacity-95 border-l-2 border-gold/40 pl-4 md:pl-6">
                        TD Classic định nghĩa lại trải nghiệm âm thanh chuyên nghiệp. <br class="hidden sm:block">
                        Kiệt tác kỹ thuật Châu Âu, tinh chỉnh cho tâm hồn Việt.
                    </p>

                    <!-- Status / Scroll Indicator -->
                    <div class="animate-fade-up-4 flex items-center gap-4">
                        <div class="h-1 w-16 md:w-20 bg-gold rounded-full"></div>
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
        <button onclick="prevSlide()" aria-label="Slide trước" class="flex absolute top-1/2 left-4 md:left-12 -translate-y-1/2 z-30 w-10 h-10 md:w-14 md:h-14 rounded-full border border-white/10 bg-black/45 backdrop-blur-md items-center justify-center text-white/60 hover:text-gold hover:border-gold/50 hover:bg-black/75 transition-all duration-300 group cursor-pointer shadow-[0_4px_20px_rgba(0,0,0,0.5)]">
            <i class="fa-solid fa-chevron-left text-sm md:text-lg transform group-hover:-translate-x-0.5 transition-transform duration-300"></i>
        </button>

        <button onclick="nextSlide()" aria-label="Slide tiếp theo" class="flex absolute top-1/2 right-4 md:right-12 -translate-y-1/2 z-30 w-10 h-10 md:w-14 md:h-14 rounded-full border border-white/10 bg-black/45 backdrop-blur-md items-center justify-center text-white/60 hover:text-gold hover:border-gold/50 hover:bg-black/75 transition-all duration-300 group cursor-pointer shadow-[0_4px_20px_rgba(0,0,0,0.5)]">
            <i class="fa-solid fa-chevron-right text-sm md:text-lg transform group-hover:translate-x-0.5 transition-transform duration-300"></i>
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
            if (currentEl) {
                currentEl.textContent = '0' + (index + 1);
            }
            
            // Reset Animation
            if (slideFill) {
                slideFill.classList.remove('running');
                void slideFill.offsetWidth; // trigger reflow
                if(isAutoPlaying) slideFill.classList.add('running');
                else slideFill.style.width = '100%'; // Full if paused manually
            }
        }

        function showSlide(index) {
            // Handle Wrap
            if (index >= totalSlides) currentSlide = 0;
            else if (index < 0) currentSlide = totalSlides - 1;
            else currentSlide = index;

            // Toggle Classes & Load On-Demand
            slides.forEach((slide, i) => {
                const isActive = (i === currentSlide);
                slide.classList.toggle('active', isActive);
                if (isActive) {
                    const img = slide.querySelector('img[data-src]');
                    if (img) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                }
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
            // Delay first auto-slide so Core Web Vitals measures slide 0 correctly
            setTimeout(() => {
                slideInterval = setInterval(nextSlide, 6000);
            }, 6000);
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
            <div class="flex flex-col md:flex-row gap-8 md:gap-16 items-center mb-16 md:mb-32">
                <div class="w-full md:w-1/2 relative group">
                    <div class="absolute -top-4 -left-4 w-20 sm:w-24 h-20 sm:h-24 border-t border-l border-gold/30 pointer-events-none"></div>
                    <div
                        class="aspect-[4/3] overflow-hidden rounded-lg transition-all duration-1000">
                        <img src="https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=1200&auto=format&fit=crop"
                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-1000"
                            alt="Sứ mệnh kiến tạo âm thanh TD Classic" width="800" height="600" loading="lazy">
                    </div>
                </div>
                <div class="w-full md:w-1/2 lg:pl-12 relative">
                    <span
                        class="text-4xl sm:text-6xl font-serif text-white/30 absolute -translate-y-8 sm:-translate-y-10 -translate-x-2 sm:-translate-x-4 select-none pointer-events-none" aria-hidden="true">Mission</span>
                    <h3 class="text-2xl sm:text-3xl font-sans font-bold text-white mb-4 sm:mb-6 relative z-10">Sứ Mệnh Kiến Tạo</h3>
                    <p class="font-sans text-gray-300 font-light leading-relaxed text-sm sm:text-base mb-6 text-left md:text-justify">
                        Sứ mệnh của TD Classic không dừng lại ở việc sản xuất thiết bị. Chúng tôi khao khát <strong>xóa
                            nhòa ranh giới</strong> giữa âm thanh tái tạo và âm thanh thực tế. Mỗi sản phẩm ra đời là
                        kết quả của hàng ngàn giờ nghiên cứu để mang lại rung cảm chân thật nhất cho người nghe.
                    </p>
                    <div class="flex items-center gap-3 sm:gap-4 text-gold text-xs sm:text-sm font-sans tracking-widest uppercase">
                        <span>Trung thực</span> <span class="w-1.5 h-1.5 bg-gold rounded-full"></span> <span>Cảm xúc</span>
                    </div>
                </div>
            </div>

            <!-- Block 2: Tầm Nhìn (Vision) - Flex Logic Reversed -->
            <div class="flex flex-col md:flex-row-reverse gap-8 md:gap-16 items-center mb-16 md:mb-32">
                <div class="w-full md:w-1/2 relative group">
                    <div class="absolute -bottom-4 -right-4 w-20 sm:w-24 h-20 sm:h-24 border-b border-r border-gold/30 pointer-events-none"></div>
                    <div class="aspect-[4/3] overflow-hidden rounded-lg transition-all duration-1000">
                        <img src="https://tdclassic.vn/wp-content/uploads/2026/01/tdclassic_cover_02-scaled.webp"
                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-1000"
                            alt="Tầm nhìn vươn xa của TD Classic" width="800" height="600" loading="lazy">
                    </div>
                </div>
                <div class="w-full md:w-1/2 lg:pr-12 relative text-left">
                    <span
                        class="text-4xl sm:text-6xl font-serif text-white/30 absolute -translate-y-8 sm:-translate-y-10 left-0 -translate-x-2 sm:-translate-x-4 select-none pointer-events-none" aria-hidden="true">Vision</span>
                    <h3 class="text-2xl sm:text-3xl font-sans font-bold text-white mb-4 sm:mb-6 relative z-10">Tầm Nhìn Vươn Xa</h3>
                    <p class="font-sans text-gray-300 font-light leading-relaxed text-sm sm:text-base mb-6 text-left md:text-justify">
                        Định vị trở thành biểu tượng <strong>số 1 về Pro Audio</strong> tại Việt Nam. TD Classic hướng
                        tới việc xây dựng một hệ sinh thái âm thanh toàn diện, nơi công nghệ phục vụ nghệ thuật, và chất
                        lượng Việt Nam vươn tầm quốc tế.
                    </p>
                    <div class="flex items-center gap-3 sm:gap-4 text-gold text-xs sm:text-sm font-sans tracking-widest uppercase">
                        <span>Đỉnh cao</span> <span class="w-1.5 h-1.5 bg-gold rounded-full"></span> <span>Bền vững</span> <span class="w-1.5 h-1.5 bg-gold rounded-full"></span> <span>Vươn xa</span>
                    </div>
                </div>
            </div>

            <!-- Block 3: Giá Trị Cốt Lõi -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-8">
                <div class="bg-[#111111] p-6 sm:p-8 rounded-xl border border-white/10 hover:border-gold/50 transition-all duration-300 group">
                    <i data-lucide="gem"
                        class="w-8 h-8 sm:w-10 sm:h-10 text-gold mb-4 sm:mb-6 stroke-1 group-hover:scale-110 transition-transform"></i>
                    <h3 class="font-sans font-bold text-lg sm:text-xl text-white mb-3 group-hover:text-gold transition-colors">Tinh Hoa (Craftsmanship)</h3>
                    <p class="font-sans text-gray-300 text-sm leading-relaxed">
                        Sự tỉ mỉ trong từng mối hàn, từng lớp sơn. Chúng tôi coi mỗi sản phẩm là một tác phẩm nghệ thuật
                        cần được hoàn thiện thủ công kết hợp công nghệ chính xác.
                    </p>
                </div>
                <div class="bg-[#111111] p-6 sm:p-8 rounded-xl border border-white/10 hover:border-gold/50 transition-all duration-300 group">
                    <i data-lucide="users"
                        class="w-8 h-8 sm:w-10 sm:h-10 text-gold mb-4 sm:mb-6 stroke-1 group-hover:scale-110 transition-transform"></i>
                    <h3 class="font-sans font-bold text-lg sm:text-xl text-white mb-3 group-hover:text-gold transition-colors">Con Người (People)</h3>
                    <p class="font-sans text-gray-300 text-sm leading-relaxed">
                        Đội ngũ kỹ sư R&D và kỹ thuật viên không chỉ giỏi chuyên môn mà còn có đôi tai thẩm âm tinh tế,
                        thấu hiểu nhu cầu khắt khe của khách hàng.
                    </p>
                </div>
                <div class="bg-[#111111] p-6 sm:p-8 rounded-xl border border-white/10 hover:border-gold/50 transition-all duration-300 group">
                    <i data-lucide="map"
                        class="w-8 h-8 sm:w-10 sm:h-10 text-gold mb-4 sm:mb-6 stroke-1 group-hover:scale-110 transition-transform"></i>
                    <h3 class="font-sans font-bold text-lg sm:text-xl text-white mb-3 group-hover:text-gold transition-colors">Quy Mô (Scale)</h3>
                    <p class="font-sans text-gray-300 text-sm leading-relaxed">
                        Mạng lưới phân phối trải rộng 3 miền. Hệ thống Showroom tiêu chuẩn Lab. Hàng ngàn dự án đã được
                        lắp đặt và vận hành ổn định.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. CATEGORY OVERVIEW (Dynamic from Admin Images) -->
    <?php
    // Define Category Sections & Fetch Dynamic Images via Mega Menu Logic
    // This ensures consistency: Homepage sections will match Header Menu categories exactly.
    
    $mega_categories = tdclassic_get_mega_menu_categories(10); // Fetch up to 10 categories
    $sections = [];
    $merge_slugs = ['quan-ly-nguon', 'phu-kien'];
    $merged_added = false;
    $display_index = 0; // Track visual index for alternating bg

    if (!empty($mega_categories)) {
        foreach ($mega_categories as $cat) {
            
            // Handle Merged Sections (Power & Accessories)
            if (in_array($cat['slug'], $merge_slugs)) {
                if ($merged_added) continue; // Skip if already added
                
                // Create Combined Section Data
                $cat['name'] = 'Q.Lý Nguồn & Phụ Kiện';
                $cat['description'] = 'Hệ thống quản lý nguồn điện an toàn và các phụ kiện kết nối chuyên dụng, đảm bảo sự ổn định tuyệt đối cho dàn âm thanh.';
                $cat['slug'] = 'quan-ly-nguon'; // Use Power Management as primary slug for products
                $merged_added = true;
            }

            $is_even = ($display_index % 2 == 0);
            
            // Build Section Data
            $sections[] = [
                'id' => $cat['slug'],
                'bg' => $is_even ? 'bg-metal' : 'bg-void',
                'cat_slug' => $cat['slug'],
                'cat_num' => sprintf('%02d', $display_index + 1),
                'short_title' => $cat['name'],
                'title' => $cat['name'],
                'desc' => !empty($cat['description']) ? wp_strip_all_tags($cat['description']) : 'Khám phá các sản phẩm ' . strtolower($cat['name']) . ' chất lượng cao từ TD Classic.',
                'specs' => ['• Chất lượng âm thanh chuyên nghiệp', '• Thiết kế bền bỉ, sang trọng', '• Bảo hành chính hãng'],
                'img' => !empty($cat['image_url']) ? $cat['image_url'] : 'https://placehold.co/600x400/1a1a1a/D4AF37?text=' . urlencode($cat['name']),
                'reverse' => !$is_even
            ];
            
            $display_index++;
        }
    } else {
        // Fallback or Empty State
        $sections = []; 
    }
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
                    aria-label="<?php echo esc_attr('Khám phá phân loại ' . $grid_item['short_title']); ?>"
                    class="group relative aspect-[3/4] bg-surface overflow-hidden border border-white/5 hover:border-gold/50 transition-all">
                    <img src="<?php echo esc_url($grid_item['img']); ?>"
                        alt=""
                        role="presentation"
                        width="300" height="400"
                        class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700"
                        loading="lazy"
                        decoding="async">
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
                            alt="<?php echo esc_attr($sec['title']); ?>"
                            width="600" height="400"
                            loading="lazy">
                    </div>

                    <!-- Text Wrapper (Always Second in DOM) -->
                    <div class="w-full md:w-1/2">
                        <span class="font-sans text-gold text-xs tracking-cinematic uppercase block mb-4">Category
                            <?php echo esc_html($sec['cat_num']); ?></span>
                        <h3 class="font-sans font-bold text-3xl md:text-5xl text-white mb-6 leading-tight">
                            <?php echo esc_html($sec['title']); ?>
                        </h3>
                        <p class="font-sans text-gray-300 font-light leading-relaxed mb-6 text-justify">
                            <?php echo esc_html($sec['desc']); ?>
                        </p>
                        <ul class="space-y-2 font-sans text-sm text-gray-300">
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
                        $transient_key = 'td_fp_cat_' . sanitize_key($sec['cat_slug']);
                        $cached_products = get_transient($transient_key);

                        if ($cached_products === false || !is_array($cached_products)) {
                            $args = array(
                                'post_type' => 'product',
                                'posts_per_page' => 6,
                                'no_found_rows' => true,
                                'update_post_term_cache' => true,
                                'update_post_meta_cache' => true,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field' => 'slug',
                                        'terms' => $sec['cat_slug']
                                    )
                                )
                            );
                            $query = new WP_Query($args);
                            $cached_products = array();

                            if ($query->have_posts()) {
                                while ($query->have_posts()) {
                                    $query->the_post();
                                    global $product;
                                    $thumb = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') : '';
                                    $cats = get_the_terms(get_the_ID(), 'product_cat');
                                    $cat_name = ($cats && !is_wp_error($cats)) ? $cats[0]->name : '';
                                    $price = $product ? $product->get_price_html() : 'Liên hệ';

                                    $cached_products[] = array(
                                        'id' => get_the_ID(),
                                        'title' => get_the_title(),
                                        'permalink' => get_permalink(),
                                        'thumb' => $thumb,
                                        'cat_name' => $cat_name,
                                        'price' => $price
                                    );
                                }
                                wp_reset_postdata();
                            }
                            set_transient($transient_key, $cached_products, DAY_IN_SECONDS);
                        }

                        if (!empty($cached_products)):
                            foreach ($cached_products as $p):
                                ?>
                                <!-- Item -->
                                <div
                                    class="min-w-[280px] md:min-w-[320px] snap-start bg-<?php echo ($sec['bg'] === 'bg-metal') ? 'void' : 'metal'; ?> p-4 border border-white/5 group hover:border-gold/50 transition-all">
                                    <div class="aspect-square bg-surface overflow-hidden mb-4 relative">
                                        <a href="<?php echo esc_url($p['permalink']); ?>" aria-label="<?php echo esc_attr($p['title']); ?>">
                                            <?php if (!empty($p['thumb'])): ?>
                                                <img src="<?php echo esc_url($p['thumb']); ?>"
                                                    class="w-full h-full object-cover zoom-img"
                                                    alt="<?php echo esc_attr($p['title']); ?>"
                                                    width="300" height="300"
                                                    loading="lazy">
                                            <?php else: ?>
                                                <div class="w-full h-full flex items-center justify-center bg-gray-800 text-gray-400">No
                                                    Image</div>
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <h4 class="text-white font-sans font-bold text-lg truncate"><a
                                            class="text-white hover:text-gold transition-colors"
                                            href="<?php echo esc_url($p['permalink']); ?>"><?php echo esc_html($p['title']); ?></a></h4>
                                    <p class="text-xs text-gray-400 mb-2 truncate">
                                        <?php echo esc_html($p['cat_name']); ?>
                                    </p>
                                    <p class="text-gold text-xs tracking-wider">
                                        <?php echo $p['price'] ? $p['price'] : 'Liên hệ'; ?>
                                    </p>
                                </div>
                                <?php
                            endforeach;
                        else:
                            ?>
                            <div class="p-8 text-gray-400 italic">Đang cập nhật sản phẩm cho danh mục này...</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endforeach; ?>

    <!-- 5. TECHNOLOGY & QUALITY -->
    <section class="py-32 bg-metal relative overflow-hidden border-y border-white/5">
        <div class="absolute inset-0 bg-[url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/noise.svg'); ?>')] opacity-10"></div>
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-16">
                <span class="font-sans text-gold text-xs tracking-cinematic uppercase">Technology</span>
                <h2 class="font-sans font-bold text-3xl md:text-5xl text-white mb-6">Công Nghệ & Chất Lượng</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="p-6 border border-white/5 hover:bg-void transition-colors">
                    <i data-lucide="cpu" class="w-10 h-10 text-gold mb-4"></i>
                    <h3 class="text-white font-sans font-bold text-xl mb-3 text-center">DSP 32-Bit</h3>
                    <p class="text-gray-300 text-xs leading-relaxed">Chip xử lý tín hiệu kỹ thuật số tiên tiến nhất, cho
                        độ phân giải âm thanh cao.</p>
                </div>
                <div class="p-6 border border-white/5 hover:bg-void transition-colors">
                    <i data-lucide="activity" class="w-10 h-10 text-gold mb-4"></i>
                    <h3 class="text-white font-sans font-bold text-xl mb-3 text-center">RTA Testing</h3>
                    <p class="text-gray-300 text-xs leading-relaxed">Đo đáp tuyến tần số thực tế (Real Time Analyzer)
                        đảm bảo độ phẳng tuyệt đối.</p>
                </div>
                <div class="p-6 border border-white/5 hover:bg-void transition-colors">
                    <i data-lucide="shield-check" class="w-10 h-10 text-gold mb-4"></i>
                    <h3 class="text-white font-sans font-bold text-xl mb-3 text-center">Burn-in 48h</h3>
                    <p class="text-gray-300 text-xs leading-relaxed">Quy trình chạy thử tải nặng liên tục 48 giờ trước
                        khi xuất xưởng.</p>
                </div>
                <div class="p-6 border border-white/5 hover:bg-void transition-colors">
                    <i data-lucide="layers" class="w-10 h-10 text-gold mb-4"></i>
                    <h3 class="text-white font-sans font-bold text-xl mb-3 text-center">Linh Kiện Nhập</h3>
                    <p class="text-gray-300 text-xs leading-relaxed">Tụ điện, trở, sò công suất nhập khẩu từ các thương
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
                <p class="text-gray-300 mt-4 max-w-2xl mx-auto font-light">Chúng tôi không áp dụng một công thức cho tất
                    cả. Mỗi không gian là một bài toán âm học riêng biệt cần lời giải chính xác.</p>
            </div>

            <div class="space-y-24">
                <!-- App 1: Bar & Lounge (Image Left) -->
                <!-- Use md:flex-row (Image-Text) -->
                <div class="flex flex-col md:flex-row gap-12 items-center">
                    <div class="w-full md:w-1/2 relative group">
                        <div class="absolute -top-4 -left-4 w-16 h-16 border-t border-l border-gold/50"></div>
                        <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/app/app-1.jpg'); ?>"
                            alt="Giải pháp âm thanh cho Bar và Lounge TD Classic"
                            width="800" height="533"
                            class="w-full transition-all duration-1000"
                            loading="lazy">
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="text-4xl font-serif text-white/35" aria-hidden="true">01</span>
                            <h3 class="text-white font-sans font-bold text-2xl">Bar & Lounge</h3>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-gold text-xs uppercase tracking-widest mb-2">Thách thức</h4>
                                <p class="text-gray-300 text-sm font-light">Không gian ồn ào, vật liệu tiêu âm kém
                                    (kính, đá). Cần áp lực âm thanh lớn (SPL cao) để kích thích không khí nhưng không
                                    được gây chói tai hay mệt mỏi cho khách hàng ngồi lâu.</p>
                            </div>
                            <div>
                                <h4 class="text-gold text-xs uppercase tracking-widest mb-2">Giải pháp TD Classic</h4>
                                <p class="text-gray-300 text-sm font-light">Sử dụng hệ thống Array phân tán đều hoặc loa
                                    Full công suất lớn. Tinh chỉnh DSP để cắt dải tần gây chói, tăng cường dải trầm sâu
                                    (Sub-bass) tạo độ "đầm".</p>
                            </div>
                            <div class="bg-metal p-4 border border-white/5">
                                <h4 class="text-white text-xs uppercase tracking-widest mb-2">Cấu hình đề xuất</h4>
                                <p class="text-gray-300 text-xs">Loa Array LA-210 • Subwoofer S-2180 • Cục đẩy 4 kênh
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
                            alt="Giải pháp âm thanh Karaoke Luxury TD Classic"
                            width="800" height="533"
                            class="w-full transition-all duration-1000"
                            loading="lazy">
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="text-4xl font-serif text-white/35" aria-hidden="true">02</span>
                            <h3 class="text-white font-sans font-bold text-2xl">Karaoke Luxury</h3>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-gold text-xs uppercase tracking-widest mb-2">Thách thức</h4>
                                <p class="text-gray-300 text-sm font-light">Khách hàng hát không chuyên nghiệp, dễ xảy
                                    ra hú rít. Yêu cầu hiệu ứng Vocal (Echo/Reverb) phải nịnh giọng, dễ hát, nhạc nền
                                    phải bốc.</p>
                            </div>
                            <div>
                                <h4 class="text-gold text-xs uppercase tracking-widest mb-2">Giải pháp TD Classic</h4>
                                <p class="text-gray-300 text-sm font-light">Micro độ nhạy cao kết hợp Vang số chống hú 4
                                    cấp độ. Setup chế độ Effect riêng biệt cho từng thể loại nhạc (Bolero/Remix). Loa
                                    chịu tải tốt trong phòng kín.</p>
                            </div>
                            <div class="bg-metal p-4 border border-white/5">
                                <h4 class="text-white text-xs uppercase tracking-widest mb-2">Cấu hình đề xuất</h4>
                                <p class="text-gray-300 text-xs">Loa Full TD-12 Pro • Sub S-1800 • Micro M-20 Gold •
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
                            alt="Giải pháp âm thanh Hội Trường và Sự Kiện TD Classic"
                            width="800" height="533"
                            class="w-full transition-all duration-1000"
                            loading="lazy">
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="text-4xl font-serif text-white/35" aria-hidden="true">03</span>
                            <h3 class="text-white font-sans font-bold text-2xl">Hội Trường & Sự Kiện</h3>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-gold text-xs uppercase tracking-widest mb-2">Thách thức</h4>
                                <p class="text-gray-300 text-sm font-light">Không gian rộng, trần cao, dễ bị vang vọng
                                    (Reverb tự nhiên) làm đục tiếng nói. Cần độ phủ âm đều cho cả hàng ghế đầu và cuối.
                                </p>
                            </div>
                            <div>
                                <h4 class="text-gold text-xs uppercase tracking-widest mb-2">Giải pháp TD Classic</h4>
                                <p class="text-gray-300 text-sm font-light">Sử dụng loa Column hoặc Array có tính định
                                    hướng cao. Tính toán góc phủ âm để giảm thiểu phản xạ trần/sàn. Tối ưu dải trung
                                    (Mid) cho giọng nói rõ nét.</p>
                            </div>
                            <div class="bg-metal p-4 border border-white/5">
                                <h4 class="text-white text-xs uppercase tracking-widest mb-2">Cấu hình đề xuất</h4>
                                <p class="text-gray-300 text-xs">Loa Column C-10s • Sub S-15 Compact • Micro W-1000</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

            </div>
        </div>
    </section>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined' && lucide.createIcons) {
            lucide.createIcons();
        }

        // Smooth Scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                var targetId = this.getAttribute('href');
                if (targetId && targetId !== '#') {
                    var target = document.querySelector(targetId);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
    });
</script>

<?php
get_footer();