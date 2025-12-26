<?php
/**
 * The front page template file
 *
 * @package TD Classic
 */

get_header();
?>

<!-- Tailwind CSS & Config -->
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Manrope:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    serif: ['"Cinzel"', 'serif'],
                    sans: ['"Manrope"', 'sans-serif'],
                },
                colors: {
                    void: '#050505',       
                    metal: '#151515',      
                    surface: '#1E1E1E',
                    gold: '#C5A059',       
                    goldDim: '#8A703E',
                    dust: '#666666'        
                },
                letterSpacing: {
                    'cinematic': '0.3em',
                },
                backgroundImage: {
                    'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                }
            }
        }
    }
</script>

<style>
    /* BASE STYLES */
    .td-redesign-wrapper {
        background-color: #050505;
        color: #E5E5E5;
        font-family: 'Manrope', sans-serif;
    }

    /* Force Sans-Serif for Headings by default for cleaner look */
    .td-redesign-wrapper h1:not(.font-serif),
    .td-redesign-wrapper h2:not(.font-serif),
    .td-redesign-wrapper h3:not(.font-serif),
    .td-redesign-wrapper h4:not(.font-serif) {
        font-family: 'Manrope', sans-serif;
        letter-spacing: -0.01em; 
    }

    /* NOISE TEXTURE */
    .noise {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        pointer-events: none;
        z-index: 50;
        opacity: 0.03;
        background: url('https://grainy-gradients.vercel.app/noise.svg');
    }

    /* Hide scrollbar */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    /* Hover Effects */
    .zoom-img {
        transition: transform 0.7s ease;
    }
    .group:hover .zoom-img {
        transform: scale(1.05);
    }
</style>

<div class="td-redesign-wrapper antialiased selection:bg-gold selection:text-black">
    
    <!-- Noise Overlay -->
    <div class="noise"></div>

    <!-- 1. HERO SECTION -->
    <section class="relative h-screen w-full flex items-center justify-center overflow-hidden bg-void border-b border-white/5">
        <div class="absolute inset-0 opacity-40">
             <img src="https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?q=80&w=1600&auto=format&fit=crop" class="w-full h-full object-cover">
             <div class="absolute inset-0 bg-gradient-to-t from-void via-void/80 to-transparent"></div>
        </div>
        
        <div class="relative z-10 text-center px-4 max-w-5xl mx-auto">
            <div class="flex justify-center mb-8">
                 <div class="border border-gold/30 px-6 py-2 rounded-full bg-black/50 backdrop-blur-sm">
                    <span class="font-sans text-gold text-xs tracking-[0.3em] uppercase">Vietnam Professional Audio</span>
                 </div>
            </div>
            
            <h1 class="font-serif text-6xl md:text-8xl lg:text-9xl text-white leading-none mb-8 tracking-wide">
                TD CLASSIC
            </h1>
            
            <p class="font-sans text-gray-400 text-base md:text-xl font-light leading-relaxed max-w-3xl mx-auto mb-12">
                Kiến tạo chuẩn mực âm thanh chuyên nghiệp. Sự kết hợp hoàn hảo giữa kỹ thuật chính xác Châu Âu và sự thấu hiểu thị hiếu người Việt.
            </p>

            <a href="#dna" class="inline-flex items-center gap-2 text-gold font-sans text-xs font-bold uppercase tracking-widest border-b border-gold pb-1 hover:text-white hover:border-white transition-all">
                Khám phá hành trình <i data-lucide="arrow-down" class="w-4 h-4"></i>
            </a>
        </div>
    </section>

    <!-- 2. BRAND DNA -->
    <section id="dna" class="py-32 bg-metal relative overflow-hidden">
        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-24">
                <span class="font-sans text-gold text-xs tracking-cinematic uppercase block mb-4">Câu chuyện thương hiệu</span>
                <h2 class="font-sans font-bold text-4xl md:text-5xl text-white">Linh Hồn Của Âm Thanh</h2>
                <div class="w-24 h-[1px] bg-gold mx-auto mt-8 opacity-50"></div>
            </div>

            <!-- Block 1: Sứ Mệnh (Mission) - Flex Logic -->
            <div class="flex flex-col md:flex-row gap-16 items-center mb-32">
                <div class="w-full md:w-1/2 relative group">
                    <div class="absolute -top-4 -left-4 w-24 h-24 border-t border-l border-gold/30"></div>
                    <div class="aspect-[4/3] overflow-hidden filter grayscale hover:grayscale-0 transition-all duration-1000">
                        <img src="https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=1200&auto=format&fit=crop" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-1000" alt="Sứ mệnh âm thanh">
                    </div>
                </div>
                <div class="w-full md:w-1/2 lg:pl-12">
                    <span class="text-6xl font-serif text-white/5 absolute -translate-y-10 -translate-x-4">Mission</span>
                    <h3 class="text-3xl font-sans font-bold text-white mb-6 relative z-10">Sứ Mệnh Kiến Tạo</h3>
                    <p class="font-sans text-gray-400 font-light leading-relaxed text-lg mb-6 text-justify">
                        Sứ mệnh của TD Classic không dừng lại ở việc sản xuất thiết bị. Chúng tôi khao khát <strong>xóa nhòa ranh giới</strong> giữa âm thanh tái tạo và âm thanh thực tế. Mỗi sản phẩm ra đời là kết quả của hàng ngàn giờ nghiên cứu để mang lại rung cảm chân thật nhất cho người nghe.
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
                    <div class="aspect-[4/3] overflow-hidden filter grayscale hover:grayscale-0 transition-all duration-1000">
                        <img src="https://images.unsplash.com/photo-1478737270239-2f02b77ac6d5?q=80&w=1200&auto=format&fit=crop" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-1000" alt="Tầm nhìn">
                    </div>
                </div>
                <div class="w-full md:w-1/2 lg:pr-12 text-left md:text-right">
                    <span class="text-6xl font-serif text-white/5 absolute -translate-y-10 right-auto md:right-0 md:left-auto left-0 translate-x-0 md:translate-x-12">Vision</span>
                    <h3 class="text-3xl font-sans font-bold text-white mb-6 relative z-10">Tầm Nhìn Vươn Xa</h3>
                    <p class="font-sans text-gray-400 font-light leading-relaxed text-lg mb-6 text-justify md:text-right" dir="auto">
                        Định vị trở thành biểu tượng <strong>số 1 về Pro Audio</strong> tại Việt Nam. TD Classic hướng tới việc xây dựng một hệ sinh thái âm thanh toàn diện, nơi công nghệ phục vụ nghệ thuật, và chất lượng Việt Nam vươn tầm quốc tế.
                    </p>
                </div>
            </div>

            <!-- Block 3: Giá Trị Cốt Lõi -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-void p-8 border border-white/5 hover:border-gold/50 transition-colors group">
                    <i data-lucide="gem" class="w-10 h-10 text-gold mb-6 stroke-1 group-hover:scale-110 transition-transform"></i>
                    <h4 class="font-sans font-bold text-xl text-white mb-4">Tinh Hoa (Craftsmanship)</h4>
                    <p class="font-sans text-gray-500 text-sm leading-relaxed">
                        Sự tỉ mỉ trong từng mối hàn, từng lớp sơn. Chúng tôi coi mỗi sản phẩm là một tác phẩm nghệ thuật cần được hoàn thiện thủ công kết hợp công nghệ chính xác.
                    </p>
                </div>
                <div class="bg-void p-8 border border-white/5 hover:border-gold/50 transition-colors group">
                    <i data-lucide="users" class="w-10 h-10 text-gold mb-6 stroke-1 group-hover:scale-110 transition-transform"></i>
                    <h4 class="font-sans font-bold text-xl text-white mb-4">Con Người (People)</h4>
                    <p class="font-sans text-gray-500 text-sm leading-relaxed">
                        Đội ngũ kỹ sư R&D và kỹ thuật viên không chỉ giỏi chuyên môn mà còn có đôi tai thẩm âm tinh tế, thấu hiểu nhu cầu khắt khe của khách hàng.
                    </p>
                </div>
                <div class="bg-void p-8 border border-white/5 hover:border-gold/50 transition-colors group">
                    <i data-lucide="map" class="w-10 h-10 text-gold mb-6 stroke-1 group-hover:scale-110 transition-transform"></i>
                    <h4 class="font-sans font-bold text-xl text-white mb-4">Quy Mô (Scale)</h4>
                    <p class="font-sans text-gray-500 text-sm leading-relaxed">
                        Mạng lưới phân phối trải rộng 3 miền. Hệ thống Showroom tiêu chuẩn Lab. Hàng ngàn dự án đã được lắp đặt và vận hành ổn định.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. CATEGORY OVERVIEW -->
    <section id="overview" class="py-24 bg-void">
        <div class="container mx-auto px-6 md:px-12">
            <div class="text-center mb-16">
                <span class="font-sans text-gold text-xs tracking-cinematic uppercase">Tổng quan danh mục</span>
                <h2 class="font-sans font-bold text-3xl text-white mt-4">Hệ Sinh Thái Sản Phẩm</h2>
            </div>
             <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <a href="#speakers" class="group relative aspect-[3/4] bg-surface overflow-hidden border border-white/5 hover:border-gold/50 transition-all">
                    <img src="https://images.unsplash.com/photo-1595433211516-795325883d6e?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700">
                    <div class="absolute bottom-4 left-0 w-full text-center">
                        <p class="font-sans font-bold text-white text-lg group-hover:text-gold transition-colors">Speakers</p>
                    </div>
                </a>
                <a href="#subs" class="group relative aspect-[3/4] bg-surface overflow-hidden border border-white/5 hover:border-gold/50 transition-all">
                    <img src="https://images.unsplash.com/photo-1564510714747-69c3bc1fab41?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700">
                    <div class="absolute bottom-4 left-0 w-full text-center">
                        <p class="font-sans font-bold text-white text-lg group-hover:text-gold transition-colors">Subwoofers</p>
                    </div>
                </a>
                <a href="#mics" class="group relative aspect-[3/4] bg-surface overflow-hidden border border-white/5 hover:border-gold/50 transition-all">
                    <img src="https://images.unsplash.com/photo-1558507652-2d9626c4e67a?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700">
                    <div class="absolute bottom-4 left-0 w-full text-center">
                        <p class="font-sans font-bold text-white text-lg group-hover:text-gold transition-colors">Microphones</p>
                    </div>
                </a>
                <a href="#amps" class="group relative aspect-[3/4] bg-surface overflow-hidden border border-white/5 hover:border-gold/50 transition-all">
                    <img src="https://images.unsplash.com/photo-1629822601704-58a36f455138?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700">
                    <div class="absolute bottom-4 left-0 w-full text-center">
                        <p class="font-sans font-bold text-white text-lg group-hover:text-gold transition-colors">Amplifiers</p>
                    </div>
                </a>
                <a href="#mixer" class="group relative aspect-[3/4] bg-surface overflow-hidden border border-white/5 hover:border-gold/50 transition-all">
                    <img src="https://images.unsplash.com/photo-1598653222000-6b7b7a552625?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700">
                    <div class="absolute bottom-4 left-0 w-full text-center">
                        <p class="font-sans font-bold text-white text-lg group-hover:text-gold transition-colors">Processors</p>
                    </div>
                </a>
                <a href="#accessories" class="group relative aspect-[3/4] bg-surface overflow-hidden border border-white/5 hover:border-gold/50 transition-all">
                    <img src="https://images.unsplash.com/photo-1599558231221-a47734185123?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700">
                    <div class="absolute bottom-4 left-0 w-full text-center">
                        <p class="font-sans font-bold text-white text-lg group-hover:text-gold transition-colors">Accessories</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- 4. PRODUCT SECTIONS (DYNAMIC & CHECKED ZIGZAG) -->
    
    <?php
    // Helper function to render component (optional, but using inline for simplicity)
    $sections = [
        [
            'id' => 'speakers',
            'bg' => 'bg-metal',
            'cat_slug' => 'professional-speaker',
            'cat_num' => '01',
            'title' => 'Loa Full Range & Array',
            'desc' => 'Dòng loa biểu diễn chuyên nghiệp. Củ loa Neodymium tái tạo trung âm dày, treble tơi nhuyễn. Thùng gỗ Bạch Dương Baltic chịu lực cao, phù hợp cho các sự kiện ngoài trời lẫn không gian Bar/Lounge sang trọng.',
            'specs' => ['• Công suất cực đại lên tới 2400W','• Góc phủ âm rộng 100° x 70°','• Phân tần linh kiện Đức'],
            'img' => 'https://images.unsplash.com/photo-1595433211516-795325883d6e?q=80&w=1200&auto=format&fit=crop',
            'reverse' => false // Text Left, Image Right
        ],
        [
            'id' => 'subs',
            'bg' => 'bg-void',
            'cat_slug' => 'subwoofer',
            'cat_num' => '02',
            'title' => 'Siêu Trầm Subwoofers',
            'desc' => 'Uy lực và sâu lắng. Dải trầm xuống tới 30Hz, tái tạo tiếng Kick Drum chắc gọn và tiếng Bass Synth rung chuyển không gian.',
            'specs' => ['• Củ loa Bass 18" - 21" Coil lớn','• Thiết kế hầm hố cộng hưởng','• Áp lực âm thanh (SPL) cực đại 138dB'],
            'img' => 'https://images.unsplash.com/photo-1564510714747-69c3bc1fab41?q=80&w=1200&auto=format&fit=crop',
            'reverse' => true // Image Left, Text Right
        ],
        [
            'id' => 'mics',
            'bg' => 'bg-metal',
            'cat_slug' => 'microphone',
            'cat_num' => '03',
            'title' => 'Microphones Không Dây',
            'desc' => 'Cầu nối của cảm xúc. Micro TD Classic sở hữu độ nhạy cao, khả năng bắt giọng chi tiết và công nghệ sóng UHF True Diversity ổn định tuyệt đối.',
            'specs' => ['• 200 kênh tần số lựa chọn','• Tự ngắt khi không sử dụng (Auto-Mute)','• Phạm vi hoạt động 100m'],
            'img' => 'https://images.unsplash.com/photo-1558507652-2d9626c4e67a?q=80&w=1200&auto=format&fit=crop',
            'reverse' => false // Text Left, Image Right
        ],
        [
            'id' => 'amps',
            'bg' => 'bg-void',
            'cat_slug' => 'amplifier',
            'cat_num' => '04',
            'title' => 'Cục Đẩy Công Suất',
            'desc' => 'Trái tim của hệ thống. Dòng cục đẩy (Amplifier) TD Classic được thiết kế để hoạt động liên tục với hiệu suất cao.',
            'specs' => ['• Mạch công suất Class D / Class H tiên tiến','• Biến áp xuyến đồng nguyên chất 100%','• Hệ thống bảo vệ quá nhiệt, quá tải thông minh'],
            'img' => 'https://images.unsplash.com/photo-1629822601704-58a36f455138?q=80&w=1200&auto=format&fit=crop',
            'reverse' => true // Image Left, Text Right
        ],
        [
            'id' => 'mixer',
            'bg' => 'bg-metal',
            'cat_slug' => 'mixer',
            'cat_num' => '05',
            'title' => 'Vang Số & Mixer',
            'desc' => 'Bộ não xử lý trung tâm. Các thiết bị xử lý tín hiệu (DSP) của TD Classic sử dụng chip 32-bit cho khả năng xử lý âm thanh chi tiết, mượt mà.',
            'specs' => ['• Chip xử lý DSP Analog Devices / Yamaha','• Điều chỉnh chi tiết qua phần mềm máy tính','• Tích hợp Bluetooth chuẩn AptX HD'],
            'img' => 'https://images.unsplash.com/photo-1598653222000-6b7b7a552625?q=80&w=1200&auto=format&fit=crop',
            'reverse' => false // Text Left, Image Right
        ],
        [
            'id' => 'accessories',
            'bg' => 'bg-void',
            'cat_slug' => 'accessory',
            'cat_num' => '06',
            'title' => 'Phụ Kiện Âm Thanh',
            'desc' => 'Sự hoàn hảo nằm trong chi tiết. Hệ thống dây dẫn tín hiệu, giắc kết nối, tủ máy và chân loa của TD Classic đều đạt chuẩn Pro Audio.',
            'specs' => ['• Dây dẫn lõi đồng tinh khiết 99.99%','• Đầu giắc mạ vàng chống oxy hóa','• Tủ máy ABS chống sốc, bảo vệ thiết bị'],
            'img' => 'https://images.unsplash.com/photo-1599558231221-a47734185123?q=80&w=1200&auto=format&fit=crop',
            'reverse' => true // Image Left, Text Right
        ],
    ];

    foreach ($sections as $sec) :
        // Using FLEX ROW REVERSE for Robust Zigzag (Compatible with Tailwind CDN)
        // If Reverse=True (Image Left, Text Right) -> Use flex-row
        // If Reverse=False (Text Left, Image Right) -> Use flex-row-reverse
        // Note: DOM order is Image First, Text Second.
        // flex-row: Image - Text
        // flex-row-reverse: Text - Image
        $flex_class = $sec['reverse'] ? 'md:flex-row' : 'md:flex-row-reverse';
    ?>
    <section id="<?php echo esc_attr($sec['id']); ?>" class="<?php echo esc_attr($sec['bg']); ?> py-24 border-t border-white/5">
        <div class="container mx-auto px-6 md:px-12">
            <!-- Intro Block -->
            <!-- Flex Container with Zigzag Logic -->
            <div class="flex flex-col <?php echo $flex_class; ?> gap-16 items-center mb-12">
                
                <!-- Image Wrapper (Always First in DOM for Mobile Stack Image-Top) -->
                <div class="w-full md:w-1/2 relative h-[400px] bg-void overflow-hidden group border border-white/5">
                    <img src="<?php echo esc_url($sec['img']); ?>" class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-700" alt="Cover">
                </div>

                <!-- Text Wrapper (Always Second in DOM) -->
                <div class="w-full md:w-1/2">
                    <span class="font-sans text-gold text-xs tracking-cinematic uppercase block mb-4">Category <?php echo esc_html($sec['cat_num']); ?></span>
                    <h2 class="font-sans font-bold text-4xl text-white mb-6"><?php echo esc_html($sec['title']); ?></h2>
                    <p class="font-sans text-gray-400 font-light leading-relaxed mb-6 text-justify">
                        <?php echo esc_html($sec['desc']); ?>
                    </p>
                    <ul class="space-y-2 font-sans text-sm text-gray-500">
                        <?php foreach($sec['specs'] as $spec): ?>
                        <li><?php echo esc_html($spec); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
            </div>

            <!-- Product Slider (Dynamic) -->
            <div class="relative">
                <h3 class="font-sans text-white text-sm uppercase tracking-widest mb-6 border-l-2 border-gold pl-4">Sản phẩm nổi bật (Vuốt để xem)</h3>
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
                    
                    if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post();
                            global $product;
                            $price = $product ? $product->get_price_html() : '';
                    ?>
                    <!-- Item -->
                    <div class="min-w-[280px] md:min-w-[320px] snap-start bg-<?php echo ($sec['bg'] === 'bg-metal') ? 'void' : 'metal'; ?> p-4 border border-white/5 group hover:border-gold/50 transition-all">
                        <div class="aspect-square bg-surface overflow-hidden mb-4 relative">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php the_post_thumbnail_url('medium_large'); ?>" class="w-full h-full object-cover zoom-img grayscale hover:grayscale-0">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center bg-gray-800 text-gray-600">No Image</div>
                                <?php endif; ?>
                            </a>
                        </div>
                        <h4 class="text-white font-sans font-bold text-lg truncate"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <p class="text-xs text-gray-500 mb-2 truncate">
                            <?php 
                            $cats = get_the_terms( get_the_ID(), 'product_cat' );
                            if ( $cats && ! is_wp_error( $cats ) ) {
                                echo esc_html( $cats[0]->name );
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
                <h2 class="font-sans font-bold text-4xl text-white mt-4">Công Nghệ & Chất Lượng</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="p-6 border border-white/5 hover:bg-void transition-colors">
                    <i data-lucide="cpu" class="w-10 h-10 text-gold mb-4"></i>
                    <h4 class="text-white font-sans font-bold text-lg mb-2">DSP 32-Bit</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">Chip xử lý tín hiệu kỹ thuật số tiên tiến nhất, cho độ phân giải âm thanh cao.</p>
                </div>
                <div class="p-6 border border-white/5 hover:bg-void transition-colors">
                    <i data-lucide="activity" class="w-10 h-10 text-gold mb-4"></i>
                    <h4 class="text-white font-sans font-bold text-lg mb-2">RTA Testing</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">Đo đáp tuyến tần số thực tế (Real Time Analyzer) đảm bảo độ phẳng tuyệt đối.</p>
                </div>
                <div class="p-6 border border-white/5 hover:bg-void transition-colors">
                    <i data-lucide="shield-check" class="w-10 h-10 text-gold mb-4"></i>
                    <h4 class="text-white font-sans font-bold text-lg mb-2">Burn-in 48h</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">Quy trình chạy thử tải nặng liên tục 48 giờ trước khi xuất xưởng.</p>
                </div>
                <div class="p-6 border border-white/5 hover:bg-void transition-colors">
                    <i data-lucide="layers" class="w-10 h-10 text-gold mb-4"></i>
                    <h4 class="text-white font-sans font-bold text-lg mb-2">Linh Kiện Nhập</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">Tụ điện, trở, sò công suất nhập khẩu từ các thương hiệu hàng đầu.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. APPLICATIONS -->
    <section class="py-32 bg-void">
        <div class="container mx-auto px-6 md:px-12">
            <div class="text-center mb-24">
                <span class="font-sans text-gold text-xs tracking-cinematic uppercase">Giải pháp chuyên sâu</span>
                <h2 class="font-sans font-bold text-4xl text-white mt-4">Ứng Dụng Thực Tế</h2>
                <p class="text-gray-400 mt-4 max-w-2xl mx-auto font-light">Chúng tôi không áp dụng một công thức cho tất cả. Mỗi không gian là một bài toán âm học riêng biệt cần lời giải chính xác.</p>
            </div>
            
            <div class="space-y-24">
                <!-- App 1: Bar & Lounge (Image Left) -->
                <!-- Use md:flex-row (Image-Text) -->
                <div class="flex flex-col md:flex-row gap-12 items-center">
                    <div class="w-full md:w-1/2 relative group">
                         <div class="absolute -top-4 -left-4 w-16 h-16 border-t border-l border-gold/50"></div>
                        <img src="https://images.unsplash.com/photo-1570752321219-41822a21a761?q=80&w=800&auto=format&fit=crop" class="w-full grayscale group-hover:grayscale-0 transition-all duration-1000">
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="text-4xl font-serif text-white/10">01</span>
                            <h3 class="text-white font-sans font-bold text-2xl">Bar & Lounge</h3>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-gold text-xs uppercase tracking-widest mb-2">Thách thức</h4>
                                <p class="text-gray-400 text-sm font-light">Không gian ồn ào, vật liệu tiêu âm kém (kính, đá). Cần áp lực âm thanh lớn (SPL cao) để kích thích không khí nhưng không được gây chói tai hay mệt mỏi cho khách hàng ngồi lâu.</p>
                            </div>
                            <div>
                                <h4 class="text-gold text-xs uppercase tracking-widest mb-2">Giải pháp TD Classic</h4>
                                <p class="text-gray-400 text-sm font-light">Sử dụng hệ thống Array phân tán đều hoặc loa Full công suất lớn. Tinh chỉnh DSP để cắt dải tần gây chói, tăng cường dải trầm sâu (Sub-bass) tạo độ "đầm".</p>
                            </div>
                            <div class="bg-metal p-4 border border-white/5">
                                <h4 class="text-white text-xs uppercase tracking-widest mb-2">Cấu hình đề xuất</h4>
                                <p class="text-gray-500 text-xs">Loa Array LA-210 • Subwoofer S-2180 • Cục đẩy 4 kênh D-4800</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- App 2: Karaoke VIP (Text Left) -->
                <!-- Use md:flex-row-reverse (Text-Image) -->
                <div class="flex flex-col md:flex-row-reverse gap-12 items-center">
                    <div class="w-full md:w-1/2 relative group">
                        <div class="absolute -bottom-4 -right-4 w-16 h-16 border-b border-r border-gold/50"></div>
                        <img src="https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?q=80&w=800&auto=format&fit=crop" class="w-full grayscale group-hover:grayscale-0 transition-all duration-1000">
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="text-4xl font-serif text-white/10">02</span>
                            <h3 class="text-white font-sans font-bold text-2xl">Karaoke Luxury</h3>
                        </div>
                         <div class="space-y-6">
                            <div>
                                <h4 class="text-gold text-xs uppercase tracking-widest mb-2">Thách thức</h4>
                                <p class="text-gray-400 text-sm font-light">Khách hàng hát không chuyên nghiệp, dễ xảy ra hú rít. Yêu cầu hiệu ứng Vocal (Echo/Reverb) phải nịnh giọng, dễ hát, nhạc nền phải bốc.</p>
                            </div>
                            <div>
                                <h4 class="text-gold text-xs uppercase tracking-widest mb-2">Giải pháp TD Classic</h4>
                                <p class="text-gray-400 text-sm font-light">Micro độ nhạy cao kết hợp Vang số chống hú 4 cấp độ. Setup chế độ Effect riêng biệt cho từng thể loại nhạc (Bolero/Remix). Loa chịu tải tốt trong phòng kín.</p>
                            </div>
                            <div class="bg-metal p-4 border border-white/5">
                                <h4 class="text-white text-xs uppercase tracking-widest mb-2">Cấu hình đề xuất</h4>
                                <p class="text-gray-500 text-xs">Loa Full TD-12 Pro • Sub S-1800 • Micro M-20 Gold • Vang X-6 Pro</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- App 3: Hội Trường (Image Left) -->
                <!-- Use md:flex-row (Image-Text) -->
                <div class="flex flex-col md:flex-row gap-12 items-center">
                    <div class="w-full md:w-1/2 relative group">
                         <div class="absolute -top-4 -left-4 w-16 h-16 border-t border-l border-gold/50"></div>
                        <img src="https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=800&auto=format&fit=crop" class="w-full grayscale group-hover:grayscale-0 transition-all duration-1000">
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="text-4xl font-serif text-white/10">03</span>
                            <h3 class="text-white font-sans font-bold text-2xl">Hội Trường & Sự Kiện</h3>
                        </div>
                         <div class="space-y-6">
                            <div>
                                <h4 class="text-gold text-xs uppercase tracking-widest mb-2">Thách thức</h4>
                                <p class="text-gray-400 text-sm font-light">Không gian rộng, trần cao, dễ bị vang vọng (Reverb tự nhiên) làm đục tiếng nói. Cần độ phủ âm đều cho cả hàng ghế đầu và cuối.</p>
                            </div>
                            <div>
                                <h4 class="text-gold text-xs uppercase tracking-widest mb-2">Giải pháp TD Classic</h4>
                                <p class="text-gray-400 text-sm font-light">Sử dụng loa Column hoặc Array có tính định hướng cao. Tính toán góc phủ âm để giảm thiểu phản xạ trần/sàn. Tối ưu dải trung (Mid) cho giọng nói rõ nét.</p>
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