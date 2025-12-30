<?php
/**
 * Single Product Template – matches design in single-product.txt
 * Professional Tailwind CSS layout with proper structure
 */
get_header();
?>

<!-- Noise Overlay -->
<div class="noise"
    style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; pointer-events: none; z-index: 50; opacity: 0.03; background: url('https://grainy-gradients.vercel.app/noise.svg');">
</div>

<main id="main" class="site-main" style="background-color: #050505;">
    <?php while (have_posts()):
        the_post(); ?>

        <!-- ========== PRODUCT HERO SECTION ========== -->
        <section class="pt-12 pb-20 md:py-0 md:min-h-screen relative flex items-center" style="background-color: #050505;">
            <div class="container mx-auto px-6 md:px-12">
                <div class="grid md:grid-cols-12 gap-12 items-center py-12 md:py-24">

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
                    <div class="md:col-span-5 flex flex-col justify-center">
                        <div class="mb-2">
                            <span class="font-sans text-xs tracking-[0.3em] uppercase" style="color: #C5A059;">Professional
                                Audio</span>
                        </div>
                        <h1 class="font-serif text-2xl md:text-3xl lg:text-4xl text-white mb-4 leading-tight">
                            <?php the_title(); ?>
                            <br>
                            <span class="text-lg md:text-xl lg:text-2xl"
                                style="color: #666666;"><?php echo esc_html(get_post_meta(get_the_ID(), '_product_edition', true) ?: 'Edition 2025'); ?></span>
                        </h1>

                        <!-- Quick Specs Row -->
                        <div class="flex gap-6 py-6 my-8"
                            style="border-top: 1px solid rgba(255,255,255,0.1); border-bottom: 1px solid rgba(255,255,255,0.1);">
                            <div>
                                <span class="block text-[10px] uppercase tracking-wider mb-1" style="color: #666666;">Power
                                    (RMS)</span>
                                <span
                                    class="font-serif text-white text-xl"><?php echo esc_html(get_post_meta(get_the_ID(), '_product_power', true) ?: '450W'); ?></span>
                            </div>
                            <div class="h-10" style="width: 1px; background: rgba(255,255,255,0.1);"></div>
                            <div>
                                <span class="block text-[10px] uppercase tracking-wider mb-1"
                                    style="color: #666666;">Sensitivity</span>
                                <span
                                    class="font-serif text-white text-xl"><?php echo esc_html(get_post_meta(get_the_ID(), '_product_sensitivity', true) ?: '98dB'); ?></span>
                            </div>
                            <div class="h-10" style="width: 1px; background: rgba(255,255,255,0.1);"></div>
                            <div>
                                <span class="block text-[10px] uppercase tracking-wider mb-1"
                                    style="color: #666666;">Response</span>
                                <span
                                    class="font-serif text-white text-xl"><?php echo esc_html(get_post_meta(get_the_ID(), '_product_response', true) ?: '50Hz-20kHz'); ?></span>
                            </div>
                        </div>

                        <!-- Description -->
                        <?php
                        $full_content = get_the_content();
                        $plain_content = wp_strip_all_tags($full_content);
                        $max_chars = 200;
                        $is_truncated = mb_strlen($plain_content) > $max_chars;
                        $short_content = $is_truncated ? mb_substr($plain_content, 0, $max_chars) . '...' : $plain_content;
                        if (empty($plain_content)) {
                            $short_content = 'Sự kết hợp hoàn hảo giữa sức mạnh và sự tinh tế. Sản phẩm được chế tác với các vật liệu cao cấp, mang đến chất lượng âm thanh vượt trội.';
                            $is_truncated = false;
                        }
                        ?>
                        <div class="mb-10">
                            <p id="shortDesc" class="font-sans text-sm leading-relaxed text-justify"
                                style="color: #999999;">
                                <?php echo esc_html($short_content); ?>
                            </p>
                            <?php if ($is_truncated): ?>
                                <div id="fullDesc" class="font-sans text-sm leading-relaxed text-justify"
                                    style="color: #999999; display: none;">
                                    <?php echo wp_kses_post($full_content); ?>
                                </div>
                                <button id="toggleDescBtn" onclick="toggleDescription()"
                                    class="mt-3 text-xs uppercase tracking-wider transition-colors" style="color: #C5A059;"
                                    onmouseover="this.style.color='#fff';" onmouseout="this.style.color='#C5A059';">
                                    Xem thêm <span class="toggle-icon">↓</span>
                                </button>
                            <?php endif; ?>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col gap-4">
                            <a href="tel:<?php echo esc_attr(str_replace(' ', '', tdclassic_get_company_phone())); ?>"
                                class="w-full text-center font-sans text-sm font-bold uppercase tracking-[0.2em] py-4 transition-all"
                                style="background-color: #C5A059; color: #000;">
                                Liên hệ báo giá
                            </a>
                            <button
                                class="w-full border font-sans text-sm font-bold uppercase tracking-[0.2em] py-4 transition-all flex items-center justify-center gap-2 text-white"
                                style="border-color: rgba(255,255,255,0.2);"
                                onmouseover="this.style.borderColor='#C5A059'; this.style.color='#C5A059';"
                                onmouseout="this.style.borderColor='rgba(255,255,255,0.2)'; this.style.color='#fff';">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                Tải Datasheet
                            </button>
                        </div>

                        <!-- Warranty Badge -->
                        <div class="mt-8 flex items-center gap-2 text-xs font-sans" style="color: #666666;">
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

        <!-- ========== FULL SPECS TABLE ========== -->
        <section class="py-24" style="background-color: #050505;">
            <div class="container mx-auto px-6 md:px-12 max-w-4xl">
                <div class="text-center mb-16">
                    <h2 class="font-serif text-3xl text-white">Thông Số Kỹ Thuật</h2>
                    <p class="font-sans text-xs mt-2 uppercase tracking-widest" style="color: #666666;">Technical
                        Specifications</p>
                </div>
                <div style="border-top: 1px solid rgba(255,255,255,0.1);">
                    <?php
                    $specs = [
                        'Model' => get_post_meta(get_the_ID(), '_product_model', true) ?: get_the_title(),
                        'System Type' => get_post_meta(get_the_ID(), '_product_system_type', true) ?: '12-inch, 2-way, bass-reflex',
                        'Frequency Range' => get_post_meta(get_the_ID(), '_product_frequency_range', true) ?: '50 Hz - 20 kHz (-10 dB)',
                        'Power Rating' => get_post_meta(get_the_ID(), '_product_power_rating', true) ?: '450W / 900W / 1800W (Continuous/Program/Peak)',
                        'Sensitivity' => get_post_meta(get_the_ID(), '_product_sensitivity', true) ?: '98 dB SPL (1W @ 1m)',
                        'Nominal Impedance' => get_post_meta(get_the_ID(), '_product_impedance', true) ?: '8 Ohms',
                        'Dimensions (HxWxD)' => get_post_meta(get_the_ID(), '_product_dimensions', true) ?: '600mm x 360mm x 382mm',
                        'Weight' => get_post_meta(get_the_ID(), '_product_weight', true) ?: '18.5 Kg (40.8 lbs)',
                    ];
                    foreach ($specs as $label => $value): ?>
                        <div class="grid grid-cols-2 md:grid-cols-4 py-4 px-4 hover:bg-white/5 transition-colors"
                            style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                            <div class="font-sans text-xs uppercase tracking-wide" style="color: #666666;">
                                <?php echo esc_html($label); ?>
                            </div>
                            <div class="text-white font-sans text-sm md:col-span-3"><?php echo esc_html($value); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- ========== RELATED PRODUCTS ========== -->
        <section class="py-24" style="background-color: #151515; border-top: 1px solid rgba(255,255,255,0.05);">
            <div class="container mx-auto px-6 md:px-12">
                <div class="flex justify-between items-end mb-12">
                    <h3 class="font-serif text-2xl text-white">Sản Phẩm Tương Tự</h3>
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
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                                    fill="none" stroke="#333" stroke-width="1">
                                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                    <polyline points="21 15 16 10 5 21"></polyline>
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow flex flex-col justify-between">
                                        <h4 class="text-white font-serif text-sm md:text-base line-clamp-2"
                                            style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                            <?php the_title(); ?>
                                        </h4>
                                        <?php $cats = get_the_terms(get_the_ID(), 'product_cat');
                                        if ($cats && !is_wp_error($cats)): ?>
                                            <p class="text-xs mt-2" style="color: #666666;"><?php echo esc_html($cats[0]->name); ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        <?php endwhile;
                        wp_reset_postdata();
                    endif; ?>
                </div>
            </div>
        </section>

        <!-- ========== DETAILED DOCUMENTATION ========== -->
        <section class="py-20 font-sans text-[10px] leading-relaxed"
            style="background-color: #050505; border-top: 1px solid rgba(255,255,255,0.05); color: #666666;">
            <div class="container mx-auto px-6 md:px-12 max-w-5xl">
                <div class="space-y-6 opacity-70" style="text-align: justify; text-justify: inter-word;">
                    <?php
                    $doc = get_post_meta(get_the_ID(), '_product_documentation', true);
                    if ($doc) {
                        echo wp_kses_post($doc);
                    } else {
                        ?>
                        <p>
                            Thông tin được cung cấp trong tài liệu này phản ánh các thông số kỹ thuật và đặc tính hiệu suất của
                            sản phẩm tại thời điểm xuất bản. TD Classic, tuân theo chính sách phát triển và cải tiến sản phẩm
                            liên tục, bảo lưu quyền thay đổi thiết kế, vật liệu và thông số kỹ thuật mà không cần thông báo
                            trước. Những thay đổi này có thể bao gồm, nhưng không giới hạn ở, việc nâng cấp linh kiện phân tần,
                            thay đổi cấu trúc thùng loa nhằm tối ưu hóa cộng hưởng âm học, hoặc điều chỉnh các thông số đáp
                            tuyến tần số dựa trên kết quả đo đạc mới nhất từ phòng thí nghiệm tiêu chuẩn Anechoic.
                        </p>
                        <p>
                            <strong>Đo lường và Kiểm định:</strong> Các thông số về độ nhạy (Sensitivity) và đáp tuyến tần số
                            (Frequency Response) được đo đạc trong môi trường phòng tiêu âm tiêu chuẩn (Free-field condition),
                            sử dụng thiết bị đo lường chuyên dụng Audio Precision và microphone đo lường được hiệu chuẩn Class
                            1. Công suất định mức (RMS Power Handling) được xác định thông qua quy trình kiểm tra IEC 60268-5,
                            sử dụng tín hiệu nhiễu hồng (Pink Noise) với hệ số đỉnh (Crest Factor) là 6dB trong thời gian liên
                            tục 2 giờ.
                        </p>
                        <p>
                            <strong>Chính sách Bảo hành và Hỗ trợ:</strong> Sản phẩm được bảo hành chính hãng 24 tháng đối với
                            các lỗi kỹ thuật do nhà sản xuất. Phạm vi bảo hành bao gồm củ loa (Driver) và mạch phân tần
                            (Crossover). Để nhận được hỗ trợ kỹ thuật và dịch vụ bảo hành, vui lòng liên hệ Trung tâm Dịch vụ
                            Khách hàng của TD Classic hoặc các đại lý ủy quyền chính thức kèm theo hóa đơn mua hàng hợp lệ.
                        </p>
                        <?php
                    }
                    ?>
                </div>
                <div class="mt-12 pt-8 text-center opacity-40" style="border-top: 1px solid rgba(255,255,255,0.05);">
                    <p>Mã tài liệu: DOC-GEN-2025-V2.1 | Bản quyền © <?php echo date('Y'); ?> TD Classic Audio. Mọi quyền
                        được bảo lưu.</p>
                </div>
            </div>
        </section>

    <?php endwhile; ?>
</main>

<!-- Image Gallery Script -->
<script>
    // Toggle description expand/collapse
    function toggleDescription() {
        const shortDesc = document.getElementById('shortDesc');
        const fullDesc = document.getElementById('fullDesc');
        const toggleBtn = document.getElementById('toggleDescBtn');
        const toggleIcon = toggleBtn.querySelector('.toggle-icon');

        if (fullDesc.style.display === 'none') {
            shortDesc.style.display = 'none';
            fullDesc.style.display = 'block';
            toggleBtn.innerHTML = 'Ẩn bớt <span class="toggle-icon">↑</span>';
        } else {
            shortDesc.style.display = 'block';
            fullDesc.style.display = 'none';
            toggleBtn.innerHTML = 'Xem thêm <span class="toggle-icon">↓</span>';
        }
    }

    // Image gallery logic with fade transition
    function changeImage(element, src) {
        const mainImg = document.getElementById('mainImage');
        if (!mainImg) return;

        // Fade out
        mainImg.style.opacity = '0';

        setTimeout(() => {
            mainImg.src = src;
            // Fade in
            mainImg.style.opacity = '1';
        }, 300);

        // Update active state for thumbnails
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