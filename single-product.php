<?php
/**
 * Single Product Template – TD Classic 3.0.0
 * Professional Tailwind CSS layout with proper structure
 */
get_header();
?>

<!-- Noise Overlay -->
<div class="noise"
    style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; pointer-events: none; z-index: 50; opacity: 0.03; background: url('https://grainy-gradients.vercel.app/noise.svg');">
</div>

<style>
    /* Header Offset & Responsive Hero Spacing */
    .td-single-hero {
        background-color: #050505 !important;
        background: #050505 !important;
        background-image: none !important;
        padding-top: 140px !important;
        padding-bottom: 3.5rem !important;
        color: #ffffff !important;
    }
    @media (min-width: 768px) {
        .td-single-hero {
            padding-top: 180px !important;
            padding-bottom: 4rem !important;
        }
    }
    @media (min-width: 1024px) {
        .td-single-hero {
            /* Desktop header: Top bar 40px + Main nav ~80px + Category bar ~45px = ~165px */
            padding-top: 220px !important; /* Clean, generous clearance below fixed header */
            padding-bottom: 5rem !important;
        }
    }
    /* WordPress Admin Bar Compatibility */
    .admin-bar .td-single-hero {
        padding-top: 186px !important;
    }
    @media (min-width: 783px) {
        .admin-bar .td-single-hero {
            padding-top: 252px !important; /* 220px + 32px admin bar */
        }
    }

    /* Short description formatting in Hero */
    .td-short-desc {
        color: #d1d5db !important;
        font-size: 14px;
        line-height: 1.8;
    }
    .td-short-desc p {
        margin-bottom: 0.75rem;
        color: #d1d5db !important;
        line-height: 1.7;
    }
    .td-short-desc ul,
    .td-short-desc ol {
        margin: 0.75rem 0;
        padding-left: 1.25rem;
    }
    .td-short-desc ul li {
        list-style-type: disc;
        margin-bottom: 0.4rem;
        color: #9ca3af !important;
        font-size: 0.875rem;
    }
    .td-short-desc ol li {
        list-style-type: decimal;
        margin-bottom: 0.4rem;
        color: #9ca3af !important;
        font-size: 0.875rem;
    }

    /* Product Detailed Content Typography */
    .product-entry-content {
        font-size: 15px;
        line-height: 1.85;
        color: #d1d5db;
    }
    .product-entry-content h2,
    .product-entry-content h3,
    .product-entry-content h4 {
        color: #ffffff;
        font-weight: 700;
        margin-top: 2.5rem;
        margin-bottom: 1.25rem;
    }
    .product-entry-content h2 {
        font-size: 1.75rem;
        border-left: 3px solid #C5A059;
        padding-left: 1rem;
    }
    .product-entry-content h3 {
        font-size: 1.35rem;
        color: #f3f4f6;
    }
    .product-entry-content p {
        margin-bottom: 1.5rem;
        text-align: justify;
    }
    .product-entry-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        margin: 2rem auto;
        display: block;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }
    .product-entry-content ul,
    .product-entry-content ol {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }
    .product-entry-content ul li {
        list-style-type: disc;
        margin-bottom: 0.5rem;
    }
    .product-entry-content ol li {
        list-style-type: decimal;
        margin-bottom: 0.5rem;
    }
    .product-entry-content blockquote {
        border-left: 3px solid #C5A059;
        padding: 1rem 1.5rem;
        margin: 2rem 0;
        background: rgba(255, 255, 255, 0.02);
        font-style: italic;
        color: #e5e5e5;
    }
    .product-entry-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 2rem 0;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .product-entry-content table th,
    .product-entry-content table td {
        padding: 10px 14px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .product-entry-content table th {
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
    }
</style>

<main id="main" class="site-main" style="background-color: #050505 !important; color: #ffffff !important; min-height: 100vh;">
    <?php while (have_posts()):
        the_post(); 
        
        // Fetch technical specifications
        $custom_specs_json = get_post_meta(get_the_ID(), '_custom_specifications', true);
        $product_specs = $custom_specs_json ? json_decode($custom_specs_json, true) : [];
        if (!is_array($product_specs)) {
            $product_specs = [];
        }
        $valid_specs = array_values(array_filter($product_specs, function($item) {
            return !empty($item['label']) || !empty($item['value']);
        }));
    ?>

        <!-- ========== PRODUCT HERO SECTION ========== -->
        <section class="td-single-hero relative" style="background-color: #050505 !important; background: #050505 !important; background-image: none !important;">
            <div class="container mx-auto px-6 md:px-12">
                <div class="grid md:grid-cols-12 gap-12 items-start">

                    <!-- Left: Visual Gallery (7 columns) -->
                    <div class="md:col-span-7 flex flex-col justify-center relative group">
                        <!-- Main Image Area -->
                        <?php if (has_post_thumbnail()): ?>
                            <div class="relative aspect-[4/5] md:aspect-square w-full overflow-hidden border border-white/5"
                                style="background-color: #151515;">
                                <img id="mainImage" src="<?php the_post_thumbnail_url('large'); ?>"
                                    class="w-full h-full object-cover p-8 md:p-16 transition-all duration-700 group-hover:scale-105"
                                    style="opacity: 1; transition: opacity 0.3s ease, transform 0.7s ease;"
                                    alt="<?php the_title_attribute(); ?>" />
                                <!-- Floating Badge -->
                                <div class="absolute top-6 left-6 border px-3 py-1 backdrop-blur"
                                    style="border-color: #C5A059; background: rgba(0,0,0,0.5);">
                                    <span class="font-sans text-[10px] tracking-[0.2em] uppercase"
                                        style="color: #C5A059;">Signature Series</span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Thumbnails Rail -->
                        <div class="flex gap-4 mt-6 overflow-x-auto pb-2"
                            style="-ms-overflow-style: none; scrollbar-width: none;">
                            <?php
                            $thumb_urls = [];
                            $thumb_urls[] = get_the_post_thumbnail_url(get_the_ID(), 'large');
                            $gallery_meta = get_post_meta(get_the_ID(), '_product_image_gallery', true);
                            if (!empty($gallery_meta)) {
                                $ids = array_filter(array_map('trim', explode(',', $gallery_meta)));
                                foreach ($ids as $gid) {
                                    $u = wp_get_attachment_image_url($gid, 'large');
                                    if ($u) {
                                        $thumb_urls[] = $u;
                                    }
                                }
                            } else {
                                $imgs = get_attached_media('image', get_the_ID());
                                foreach ($imgs as $att) {
                                    $u = wp_get_attachment_image_url($att->ID, 'large');
                                    if ($u && !in_array($u, $thumb_urls, true)) {
                                        $thumb_urls[] = $u;
                                    }
                                }
                            }
                            foreach ($thumb_urls as $i => $u): ?>
                                <div class="thumb<?php echo $i === 0 ? ' active' : ''; ?> w-20 h-20 border flex-shrink-0 cursor-pointer"
                                    style="border-color: <?php echo $i === 0 ? '#C5A059' : 'rgba(255,255,255,0.2)'; ?>; background-color: #151515; opacity: <?php echo $i === 0 ? '1' : '0.5'; ?>; transition: all 0.3s;"
                                    onclick="changeImage(this, '<?php echo esc_url($u); ?>')">
                                    <img src="<?php echo esc_url($u); ?>" class="w-full h-full object-cover p-2"
                                        alt="Thumbnail <?php echo $i + 1; ?>" />
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Right: Information (5 columns) -->
                    <div class="md:col-span-5 flex flex-col justify-start">
                        <div class="mb-3 flex items-center gap-2 text-xs">
                            <span class="font-sans text-xs tracking-[0.25em] uppercase font-semibold" style="color: #C5A059;">
                                <?php
                                $product_cats = get_the_terms(get_the_ID(), 'product_cat');
                                if (!empty($product_cats) && !is_wp_error($product_cats)) {
                                    echo esc_html($product_cats[0]->name);
                                } else {
                                    echo 'Professional Audio';
                                }
                                ?>
                            </span>
                            <span class="text-white/20">•</span>
                            <span class="font-sans text-[11px] tracking-wider uppercase text-gray-500">TD Classic</span>
                        </div>

                        <h1 class="font-sans font-bold text-2xl md:text-3xl lg:text-4xl text-white mb-5 leading-tight" style="color: #ffffff !important;">
                            <?php the_title(); ?>
                            <?php 
                            $edition = get_post_meta(get_the_ID(), '_product_edition', true);
                            if (!empty($edition)): ?>
                                <br>
                                <span class="text-lg md:text-xl lg:text-2xl" style="color: #888888;"><?php echo esc_html($edition); ?></span>
                            <?php endif; ?>
                        </h1>

                        <!-- Short Description (Mô tả ngắn của sản phẩm) -->
                        <?php
                        $short_desc = '';
                        if (function_exists('wc_get_product')) {
                            $wc_prod = wc_get_product(get_the_ID());
                            if ($wc_prod && !empty($wc_prod->get_short_description())) {
                                $short_desc = $wc_prod->get_short_description();
                            }
                        }
                        if (empty($short_desc) && has_excerpt()) {
                            $short_desc = get_the_excerpt();
                        }
                        if (empty($short_desc)) {
                            $raw_content = wp_strip_all_tags(get_the_content());
                            if (!empty($raw_content)) {
                                $short_desc = wp_trim_words($raw_content, 35, '...');
                            } else {
                                $short_desc = 'Sản phẩm âm thanh cao cấp chính hãng từ TD Classic, thiết kế chuẩn mực và chất lượng âm thanh vượt trội.';
                            }
                        }
                        ?>
                        <div class="td-short-desc mb-8 font-sans leading-relaxed border-l-2 border-[#C5A059]/60 pl-4 py-1">
                            <?php echo wpautop(wp_kses_post($short_desc)); ?>
                        </div>

                        <!-- CTA Button: Liên hệ báo giá duy nhất -->
                        <div class="mt-2">
                            <a href="tel:<?php echo esc_attr(str_replace(' ', '', tdclassic_get_company_phone())); ?>"
                                class="w-full block text-center font-sans text-sm font-bold uppercase tracking-[0.2em] py-4 rounded-none transition-all shadow-lg hover:shadow-[0_0_25px_rgba(197,160,89,0.4)] hover:brightness-110"
                                style="background-color: #C5A059; color: #050505;">
                                <i class="fa-solid fa-phone mr-2 text-xs"></i> Liên hệ báo giá
                            </a>
                        </div>

                        <!-- Warranty Badge -->
                        <div class="mt-8 flex items-center gap-2 text-xs font-sans" style="color: #888888;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="#C5A059" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                <polyline points="9 12 11 14 15 10"></polyline>
                            </svg>
                            Bảo hành chính hãng 24 tháng
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========== 1. THÔNG SỐ KỸ THUẬT (1 BẢNG DUY NHẤT) ========== -->
        <?php if (!empty($valid_specs)): ?>
        <section class="py-16 md:py-20" style="background-color: #050505; border-top: 1px solid rgba(255,255,255,0.05);">
            <div class="container mx-auto px-6 md:px-12 max-w-4xl">
                <div class="text-center mb-12">
                    <h2 class="font-sans font-bold text-2xl md:text-3xl lg:text-4xl text-white">Thông Số Kỹ Thuật</h2>
                    <p class="font-sans text-xs mt-2 uppercase tracking-widest" style="color: #C5A059;">Technical Specifications</p>
                </div>
                <div style="border-top: 1px solid rgba(255,255,255,0.1);">
                    <?php foreach ($valid_specs as $spec_item): 
                        if (empty($spec_item['label']) && empty($spec_item['value'])) continue;
                    ?>
                        <div class="grid grid-cols-2 md:grid-cols-4 py-4 px-4 hover:bg-white/5 transition-colors"
                            style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                            <div class="font-sans text-xs uppercase tracking-wide font-medium" style="color: #888888;">
                                <?php echo esc_html($spec_item['label']); ?>
                            </div>
                            <div class="text-white font-sans text-sm md:col-span-3 font-light">
                                <?php echo esc_html($spec_item['value']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ========== 2. MÔ TẢ SẢN PHẨM (BÀI VIẾT CHI TIẾT) ========== -->
        <?php
        $full_article = get_the_content();
        if (!empty(trim($full_article))): ?>
        <section class="py-16 md:py-24" style="background-color: #080808; border-top: 1px solid rgba(255,255,255,0.05);">
            <div class="container mx-auto px-6 md:px-12 max-w-4xl">
                <div class="text-center mb-14">
                    <h2 class="font-sans font-bold text-2xl md:text-3xl lg:text-4xl text-white">Mô Tả Sản Phẩm</h2>
                    <p class="font-sans text-xs mt-2 uppercase tracking-widest" style="color: #C5A059;">Detailed Overview & Review</p>
                </div>
                <div class="product-entry-content">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- ========== RELATED PRODUCTS ========== -->
        <section class="py-24" style="background-color: #151515; border-top: 1px solid rgba(255,255,255,0.05);">
            <div class="container mx-auto px-6 md:px-12">
                <div class="flex justify-between items-end mb-12">
                    <h3 class="font-sans font-bold text-2xl text-white">Sản Phẩm Tương Tự</h3>
                    <a href="<?php echo esc_url(home_url('/san-pham/')); ?>"
                        class="text-xs uppercase tracking-widest transition-colors" style="color: #C5A059;"
                        onmouseover="this.style.color='#fff';" onmouseout="this.style.color='#C5A059';">Xem tất cả</a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                    <?php
                    $current_id = get_the_ID();
                    $terms = wp_get_post_terms($current_id, 'product_cat');
                    $cat_ids = wp_list_pluck($terms, 'term_id');
                    $related_args = [
                        'post_type' => 'product',
                        'posts_per_page' => 4,
                        'post__not_in' => [$current_id],
                    ];
                    if (!empty($cat_ids)) {
                        $related_args['tax_query'] = [
                            [
                                'taxonomy' => 'product_cat',
                                'field' => 'term_id',
                                'terms' => $cat_ids,
                            ],
                        ];
                    }
                    $related = new WP_Query($related_args);
                    if ($related->have_posts()):
                        while ($related->have_posts()):
                            $related->the_post(); ?>
                            <a href="<?php the_permalink(); ?>" class="block group">
                                <div class="h-full p-4 border transition-all cursor-pointer flex flex-col"
                                    style="background-color: #050505; border-color: rgba(255,255,255,0.05);"
                                    onmouseover="this.style.borderColor='rgba(197,160,89,0.5)';"
                                    onmouseout="this.style.borderColor='rgba(255,255,255,0.05)';">
                                    <div class="aspect-square overflow-hidden mb-4 relative flex-shrink-0"
                                        style="background-color: #1E1E1E;">
                                        <?php if (has_post_thumbnail()): ?>
                                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>"
                                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" />
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center text-xs"
                                                style="color: #666666;">No Image</div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow flex flex-col justify-between">
                                        <div>
                                            <span class="text-[10px] tracking-widest uppercase block mb-1"
                                                style="color: #666666;">
                                                <?php
                                                $cats = get_the_terms(get_the_ID(), 'product_cat');
                                                echo ($cats && !is_wp_error($cats)) ? esc_html($cats[0]->name) : 'Audio';
                                                ?>
                                            </span>
                                            <h4 class="font-sans font-bold text-sm text-white group-hover:text-[#C5A059] transition-colors line-clamp-2">
                                                <?php the_title(); ?>
                                            </h4>
                                        </div>
                                        <div class="mt-4 pt-3 flex justify-between items-center"
                                            style="border-top: 1px solid rgba(255,255,255,0.05);">
                                            <span class="text-xs font-sans" style="color: #C5A059;">Xem chi tiết</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                                fill="none" stroke="#C5A059" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="transform group-hover:translate-x-1 transition-transform">
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                                <polyline points="12 5 19 12 12 19"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endwhile;
                        wp_reset_postdata();
                    endif; ?>
                </div>
            </div>
        </section>

        <!-- Document Footer Note -->
        <section class="py-12 border-t" style="background-color: #000; border-color: rgba(255,255,255,0.05);">
            <div class="container mx-auto px-6 md:px-12 text-center">
                <div class="font-sans text-[11px] uppercase tracking-widest" style="color: #444444;">
                    <p>Mã tài liệu: DOC-GEN-2025-V2.1 | Bản quyền © <?php echo date('Y'); ?> TD Classic Audio. Mọi quyền
                        được bảo lưu.</p>
                </div>
            </div>
        </section>

    <?php endwhile; ?>
</main>

<!-- Image Gallery Script -->
<script>
    // Image gallery logic with fade transition
    function changeImage(element, src) {
        const mainImg = document.getElementById('mainImage');
        if (!mainImg) return;

        mainImg.style.opacity = '0';

        setTimeout(() => {
            mainImg.src = src;
            mainImg.style.opacity = '1';
        }, 300);

        document.querySelectorAll('.thumb').forEach(el => {
            el.classList.remove('active');
            el.style.borderColor = 'rgba(255,255,255,0.2)';
            el.style.opacity = '0.5';
        });
        element.classList.add('active');
        element.style.borderColor = '#C5A059';
        element.style.opacity = '1';
    }
</script>

<?php get_footer(); ?>