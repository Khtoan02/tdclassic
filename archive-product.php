<?php
/**
 * Template Name: San Pham
 * The template for displaying the products page
 * MARKER: THIS IS ARCHIVE-PRODUCT.PHP - VERSION 2.4.1
 */

get_header(); ?>

<!-- Noise Texture Overlay -->
<div class="noise"></div>

<main id="main" class="site-main products-page antialiased selection:bg-gold selection:text-black"
    style="background-color: #050505;">

    <!-- PAGE HERO -->
    <section class="relative pt-24 md:pt-32 pb-16 md:pb-24 bg-void overflow-hidden">
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-[#151515] to-transparent opacity-30">
        </div>
        <div class="container mx-auto px-4 md:px-6 lg:px-12 relative z-10 text-center">
            <span class="font-sans text-[#C5A059] text-xs tracking-[0.3em] uppercase block mb-4 md:mb-6">Bộ sưu tập
                2025</span>
            <h1 class="font-sans font-bold text-4xl md:text-6xl lg:text-7xl text-white mb-4 md:mb-6"
                style="font-family: 'Manrope', sans-serif;">KHO TÀNG ÂM THANH</h1>
            <p class="font-sans text-gray-400 text-sm md:text-base font-light leading-relaxed max-w-2xl mx-auto"
                style="font-family: 'Manrope', sans-serif;">
                Khám phá hệ sinh thái thiết bị âm thanh chuyên nghiệp. Được thiết kế để đáp ứng mọi quy mô dự án từ
                phòng hát gia đình đến sân khấu biểu diễn hàng ngàn khán giả.
            </p>
        </div>
    </section>

    <!-- STICKY FILTER BAR -->
    <div class="sticky top-0 z-30 bg-[#050505]/80 transition-all duration-300"
        style="backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,0.05);">
        <div class="container mx-auto px-6 md:px-12">
            <div class="flex items-center justify-between h-16">
                <!-- Mobile Scrollable List -->
                <div class="flex overflow-x-auto gap-8 w-full md:justify-center items-center"
                    style="-ms-overflow-style: none; scrollbar-width: none;">
                    <?php
                    // Detect which taxonomy to use (same as main section)
                    $filter_taxonomy = 'product_category';
                    $test_terms = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => false, 'number' => 1));
                    if (!empty($test_terms) && !is_wp_error($test_terms)) {
                        $filter_taxonomy = 'product_cat';
                    }

                    // Get all product categories
                    $product_categories = get_terms(array(
                        'taxonomy' => $filter_taxonomy,
                        'hide_empty' => true, // Only show categories with products
                        'orderby' => 'menu_order',
                        'order' => 'ASC'
                    ));

                    // First link - "Tất cả" (All)
                    ?>
                    <a href="#all"
                        class="category-filter-link active font-sans text-xs font-bold uppercase tracking-widest whitespace-nowrap border-b-2 border-[#C5A059] pb-4 mt-4 hover:text-white transition-colors"
                        style="color: #C5A059;" data-category="all">Tất cả</a>

                    <?php
                    if ($product_categories && !is_wp_error($product_categories)):
                        foreach ($product_categories as $category):
                            ?>
                            <a href="#<?php echo $category->slug; ?>"
                                class="category-filter-link text-gray-500 hover:text-white font-sans text-xs font-bold uppercase tracking-widest whitespace-nowrap pb-4 mt-4 transition-colors"
                                data-category="<?php echo $category->slug; ?>"><?php echo $category->name; ?></a>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Detect which taxonomy to use (WooCommerce product_cat or custom product_category)
    $taxonomy = 'product_category';
    $test_terms = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => false, 'number' => 1));
    if (!empty($test_terms) && !is_wp_error($test_terms)) {
        $taxonomy = 'product_cat'; // WooCommerce is active, use product_cat
    }

    // Get all product categories for sections
    $categories = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => true, // Only show categories with products
        'orderby' => 'menu_order',
        'order' => 'ASC'
    ));

    if ($categories && !is_wp_error($categories)):
        $category_count = 0;
        foreach ($categories as $category):
            $category_count++;

            // Alternate background colors
            $bg_class = ($category_count % 2 == 0) ? 'bg-[#151515]' : 'bg-void';

            // Get products for this category
            $products_query = new WP_Query(array(
                'post_type' => 'product',
                'posts_per_page' => 5, // 1 spotlight + 4 grid
                'post_status' => 'publish',
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => 'term_id',
                        'terms' => $category->term_id,
                    ),
                ),
            ));

            // Only show section if there are products
            if ($products_query->have_posts()):
                $products_array = array();
                while ($products_query->have_posts()):
                    $products_query->the_post();
                    $products_array[] = array(
                        'id' => get_the_ID(),
                        'title' => get_the_title(),
                        'url' => get_permalink(),
                        'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'large'),
                    );
                endwhile;
                wp_reset_postdata();

                // Get spotlight product (first one)
                $spotlight = isset($products_array[0]) ? $products_array[0] : null;
                // Get grid products (rest)
                $grid_products = array_slice($products_array, 1, 4);
                ?>

                <!-- CATEGORY SECTION: <?php echo strtoupper($category->name); ?> -->
                <section id="<?php echo $category->slug; ?>" class="py-16 md:py-24 <?php echo $bg_class; ?> border-b border-white/5"
                    data-category="<?php echo $category->slug; ?>">
                    <div class="container mx-auto px-4 md:px-6 lg:px-12">
                        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 md:mb-12 gap-4 md:gap-6">
                            <div>
                                <h2 class="font-sans font-bold text-3xl text-white" style="font-family: 'Manrope', sans-serif;">
                                    <?php echo $category->name; ?></h2>
                                <p class="font-sans text-gray-500 text-xs mt-2 uppercase tracking-widest"
                                    style="font-family: 'Manrope', sans-serif;">
                                    <?php echo $category->description ? $category->description : 'Dòng sản phẩm chuyên nghiệp'; ?>
                                </p>
                            </div>
                        </div>

                        <?php if ($spotlight): ?>
                            <!-- Spotlight Item -->
                            <div
                                class="mb-8 md:mb-12 product-card group cursor-pointer relative bg-[#151515] border border-white/5 overflow-hidden h-[350px] md:h-[450px] lg:h-[500px]">
                                <a href="<?php echo $spotlight['url']; ?>" class="block w-full h-full">
                                    <div class="img-container w-full h-full">
                                        <?php if ($spotlight['thumbnail']): ?>
                                            <img src="<?php echo $spotlight['thumbnail']; ?>"
                                                class="w-full h-full object-cover transition-transform duration-[800ms] ease-[cubic-bezier(0.2,1,0.3,1)] group-hover:scale-[1.08]"
                                                alt="<?php echo $spotlight['title']; ?>"
                                                onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-[#1E1E1E] to-[#0A0A0A] flex items-center justify-center\'><svg class=\'w-24 h-24 text-[#C5A059] opacity-30\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3\'></path></svg></div>';">
                                        <?php else: ?>
                                            <div
                                                class="w-full h-full bg-gradient-to-br from-[#1E1E1E] to-[#0A0A0A] flex items-center justify-center">
                                                <svg class="w-24 h-24 text-[#C5A059] opacity-30" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                                                    </path>
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="overlay absolute inset-0 flex flex-col justify-end p-6 md:p-10 lg:p-12 opacity-0 group-hover:opacity-100 transition-opacity duration-400"
                                        style="background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, transparent 100%);">
                                        <span
                                            class="bg-[#C5A059] text-black text-[10px] font-bold uppercase tracking-wider px-3 py-1 inline-block w-fit mb-3">Signature
                                            Series</span>
                                        <h4 class="text-white font-sans font-bold text-lg mb-2">Củ Loa Neodymium</h4>
                                        <h3 class="font-sans font-bold text-2xl md:text-4xl lg:text-5xl text-white mb-2"
                                            style="font-family: 'Manrope', sans-serif;"><?php echo $spotlight['title']; ?></h3>
                                        <p class="font-sans text-gray-300 text-sm mb-6 max-w-lg hidden md:block"
                                            style="font-family: 'Manrope', sans-serif;">Sản phẩm chuyên nghiệp hàng đầu</p>
                                        <div class="flex items-center gap-4">
                                            <span
                                                class="bg-white text-black px-6 py-3 font-sans text-xs font-bold uppercase tracking-widest hover:bg-[#C5A059] transition-colors">Xem
                                                chi tiết</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($grid_products)): ?>
                            <!-- Grid Items -->
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                                <?php foreach ($grid_products as $product): ?>
                                    <a href="<?php echo $product['url']; ?>"
                                        class="product-card group cursor-pointer bg-[#151515] border border-white/5 p-4 hover:border-[#C5A059]/30 transition-all">
                                        <div class="img-container aspect-square bg-[#1E1E1E] overflow-hidden mb-4 relative">
                                            <?php if ($product['thumbnail']): ?>
                                                <img src="<?php echo $product['thumbnail']; ?>"
                                                    class="w-full h-full object-cover transition-transform duration-[800ms] ease-[cubic-bezier(0.2,1,0.3,1)] group-hover:scale-[1.08]"
                                                    alt="<?php echo $product['title']; ?>"
                                                    onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-[#1E1E1E] to-[#0A0A0A] flex items-center justify-center\'><svg class=\'w-16 h-16 text-[#C5A059] opacity-30\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3\'></path></svg></div>';">
                                            <?php else: ?>
                                                <div
                                                    class="w-full h-full bg-gradient-to-br from-[#1E1E1E] to-[#0A0A0A] flex items-center justify-center">
                                                    <svg class="w-16 h-16 text-[#C5A059] opacity-30" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                                                        </path>
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <h4 class="text-white font-sans font-bold text-lg mb-2">Thùng Gỗ Bạch Dương</h4>
                                        <h4 class="font-sans font-bold text-white text-sm md:text-base group-hover:text-[#C5A059] transition-colors"
                                            style="font-family: 'Manrope', sans-serif;"><?php echo $product['title']; ?></h4>
                                        <p class="font-sans text-gray-500 text-[10px] uppercase mt-1"
                                            style="font-family: 'Manrope', sans-serif;">Chuyên nghiệp</p>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($products_query->found_posts > 5): ?>
                            <div class="text-center mt-12">
                                <a href="<?php echo get_term_link($category); ?>"
                                    class="btn-load-more group inline-flex flex-col items-center gap-2 text-gray-400 hover:text-[#C5A059] transition-colors">
                                    <span class="font-sans text-xs font-bold uppercase tracking-widest">Xem tất cả
                                        <?php echo $products_query->found_posts; ?> sản phẩm</span>
                                    <i data-lucide="chevron-down" class="w-5 h-5 transition-transform duration-300"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

            <?php
            endif; // if products_query->have_posts()
    
            // Add promotional banner after every 2 categories
            if ($category_count % 2 == 0):
                ?>
                <!-- PROMOTIONAL BANNER -->
                <section class="py-16 md:py-20 bg-[#151515] relative overflow-hidden border-y border-white/5">
                    <div class="absolute inset-0 opacity-20">
                        <img src="https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=1600&auto=format&fit=crop"
                            class="w-full h-full object-cover grayscale">
                    </div>
                    <div class="container mx-auto px-6 text-center relative z-10">
                        <h2 class="font-sans font-bold text-2xl md:text-3xl lg:text-4xl text-white mb-3 md:mb-4"
                            style="font-family: 'Manrope', sans-serif;">Dự Án Của Bạn Cần Gì?</h2>
                        <p class="font-sans text-gray-400 text-xs md:text-sm max-w-xl mx-auto mb-6 md:mb-8"
                            style="font-family: 'Manrope', sans-serif;">
                            Hệ thống âm thanh Bar, Lounge, Karaoke hay Hội trường? Chúng tôi có giải pháp tối ưu cho từng không
                            gian.
                        </p>
                        <a href="<?php echo home_url('/lien-he'); ?>"
                            class="inline-block bg-transparent border border-[#C5A059] text-[#C5A059] hover:bg-[#C5A059] hover:text-black font-sans text-xs font-bold uppercase tracking-widest px-8 py-3 transition-all">
                            Nhận tư vấn kỹ thuật
                        </a>
                    </div>
                </section>
                <?php
            endif;
        endforeach; // categories loop
    endif; // if categories exist
    ?>

    <!-- DETAILED DOCUMENTATION (Combined & Dense) -->
    <section
        class="py-12 md:py-16 lg:py-20 bg-void border-t border-white/5 text-gray-600 font-sans text-[10px] leading-relaxed"
        style="font-family: 'Manrope', sans-serif;">
        <div class="container mx-auto px-6 md:px-12 max-w-5xl">
            <div class="space-y-6 opacity-70" style="text-align: justify; text-justify: inter-word;">
                <p>
                    Thông tin được cung cấp trong tài liệu này phản ánh các thông số kỹ thuật và đặc tính hiệu suất của
                    các dòng sản phẩm tại thời điểm xuất bản. TD Classic, tuân theo chính sách phát triển và cải tiến
                    sản phẩm liên tục, bảo lưu quyền thay đổi thiết kế, vật liệu và thông số kỹ thuật mà không cần thông
                    báo trước. Những thay đổi này có thể bao gồm, nhưng không giới hạn ở, việc nâng cấp linh kiện phân
                    tần, thay đổi cấu trúc thùng loa nhằm tối ưu hóa cộng hưởng âm học, hoặc điều chỉnh các thông số đáp
                    tuyến tần số dựa trên kết quả đo đạc mới nhất từ phòng thí nghiệm tiêu chuẩn Anechoic. Mọi nỗ lực đã
                    được thực hiện để đảm bảo tính chính xác của dữ liệu được trình bày; tuy nhiên, TD Classic không
                    chịu trách nhiệm cho các lỗi in ấn hoặc sự khác biệt nhỏ giữa sản phẩm thực tế và hình ảnh minh họa
                    do điều kiện ánh sáng hoặc quá trình in ấn/hiển thị kỹ thuật số.
                </p>
                <p>
                    <strong>Đo lường và Kiểm định:</strong> Các thông số về độ nhạy (Sensitivity) và đáp tuyến tần số
                    (Frequency Response) được đo đạc trong môi trường phòng tiêu âm tiêu chuẩn (Free-field condition),
                    sử dụng thiết bị đo lường chuyên dụng Audio Precision và microphone đo lường được hiệu chuẩn Class
                    1. Công suất định mức (RMS Power Handling) được xác định thông qua quy trình kiểm tra IEC 60268-5,
                    sử dụng tín hiệu nhiễu hồng (Pink Noise) với hệ số đỉnh (Crest Factor) là 6dB trong thời gian liên
                    tục 2 giờ, mô phỏng điều kiện hoạt động khắc nghiệt nhất. Công suất cực đại (Peak Power) là khả năng
                    chịu đựng tức thời của loa trong thời gian ngắn (dưới 10ms) và không được khuyến nghị duy trì liên
                    tục để đảm bảo tuổi thọ linh kiện. Việc sử dụng amply công suất không phù hợp (quá thấp gây clipping
                    hoặc quá cao gây quá tải nhiệt) có thể dẫn đến hư hỏng củ loa và sẽ không nằm trong phạm vi bảo hành
                    tiêu chuẩn.
                </p>
                <p>
                    <strong>Cơ sở chứng minh và Nguồn gốc:</strong> Các tuyên bố về "Linh kiện nhập khẩu" đề cập đến các
                    thành phần quan trọng như tụ điện, cuộn cảm trong bộ phân tần và vật liệu màng loa, được cung cấp
                    bởi các đối tác chiến lược tại Đức, Ý và Nhật Bản, có đầy đủ Chứng nhận xuất xứ (Certificate of
                    Origin - C/O) và Chứng nhận chất lượng (Certificate of Quality - C/Q) theo yêu cầu. Quy trình lắp
                    ráp và hoàn thiện thùng loa được thực hiện tại nhà máy của TD Classic tại Việt Nam, tuân thủ nghiêm
                    ngặt hệ thống quản lý chất lượng ISO 9001:2015. Vật liệu thùng loa là gỗ Bạch Dương Baltic (Baltic
                    Birch Plywood) loại 1, được xử lý chống mối mọt và phủ lớp sơn Polyurea công nghệ cao, đảm bảo khả
                    năng chống trầy xước và kháng nước theo tiêu chuẩn IP54 (đối với các dòng loa ngoài trời).
                </p>
                <p>
                    <strong>Tuyên bố miễn trừ trách nhiệm pháp lý:</strong> TD Classic từ chối mọi trách nhiệm đối với
                    các thiệt hại trực tiếp, gián tiếp, ngẫu nhiên hoặc là hệ quả của việc lắp đặt sai quy cách, sử dụng
                    sai mục đích, hoặc phối ghép thiết bị không tương thích. Người sử dụng có trách nhiệm đảm bảo hệ
                    thống treo lắp (Rigging/Mounting) tuân thủ các quy định an toàn xây dựng tại địa phương và được thực
                    hiện bởi nhân sự có chuyên môn. Mặc dù sản phẩm có khả năng hoạt động ở cường độ âm thanh lớn (High
                    SPL), việc tiếp xúc lâu dài với mức áp suất âm thanh trên 85dB có thể gây tổn thương thính giác vĩnh
                    viễn; người dùng cần tuân thủ các hướng dẫn an toàn lao động và sức khỏe liên quan. Logo TD Classic,
                    tên thương hiệu, tên dòng sản phẩm (Signature Series, Master Series) và các thiết kế công nghiệp
                    liên quan là tài sản trí tuệ độc quyền của Công ty Cổ phần Công nghệ TAVA Việt Nam và được bảo hộ
                    bởi pháp luật sở hữu trí tuệ hiện hành. Nghiêm cấm mọi hành vi sao chép, làm giả hoặc sử dụng trái
                    phép hình ảnh và thông tin sản phẩm dưới mọi hình thức.
                </p>
                <p>
                    <strong>Chính sách Bảo hành và Hỗ trợ:</strong> Sản phẩm được bảo hành chính hãng 24 tháng đối với
                    các lỗi kỹ thuật do nhà sản xuất. Phạm vi bảo hành bao gồm củ loa (Driver) và mạch phân tần
                    (Crossover). Bảo hành không áp dụng cho các trường hợp: (a) Hư hỏng do thiên tai, hỏa hoạn, ngập
                    nước; (b) Hư hỏng do vận chuyển hoặc va đập vật lý; (c) Cháy coil loa do sử dụng quá công suất hoặc
                    amply bị rò điện DC; (d) Tem bảo hành bị rách, tẩy xóa hoặc sản phẩm đã bị can thiệp bởi bên thứ ba
                    không được ủy quyền. Để nhận được hỗ trợ kỹ thuật và dịch vụ bảo hành, vui lòng liên hệ Trung tâm
                    Dịch vụ Khách hàng của TD Classic hoặc các đại lý ủy quyền chính thức kèm theo hóa đơn mua hàng hợp
                    lệ. Tài liệu này có hiệu lực từ ngày 01/01/2025 và thay thế cho mọi phiên bản tài liệu thông số kỹ
                    thuật trước đó.
                </p>
            </div>

            <div class="mt-12 pt-8 border-t border-white/5 text-center opacity-40">
                <p>Mã tài liệu: DOC-CAT-2025-V2.1 | Bản quyền © 2025 TD Classic Audio. Mọi quyền được bảo lưu.</p>
            </div>
        </div>
    </section>

</main>

<style>
    /* Noise texture overlay */
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

    /* No scrollbar for horizontal scroll */
    .overflow-x-auto::-webkit-scrollbar {
        display: none;
    }

    /* Product Card Hover Effects */
    .product-card .img-container img {
        transition: transform 0.8s cubic-bezier(0.2, 1, 0.3, 1);
    }

    .product-card:hover .img-container img {
        transform: scale(1.08);
    }

    .product-card .overlay {
        background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .product-card:hover .overlay {
        opacity: 1;
    }

    /* Load More Button Animation */
    .btn-load-more:hover [data-lucide="chevron-down"] {
        transform: translateY(4px);
    }

    /* Active filter link */
    .category-filter-link.active {
        color: #C5A059 !important;
        border-bottom-color: #C5A059 !important;
    }

    /* Custom scrollbar hide on filter bar */
    .sticky [class*="overflow-x-auto"]::-webkit-scrollbar {
        display: none;
    }
</style>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Lucide icons
        lucide.createIcons();

        // Smooth scroll for category filter links
        const filterLinks = document.querySelectorAll('.category-filter-link');
        const allSections = document.querySelectorAll('section[data-category]');
        const promotionalBanners = document.querySelectorAll('section.py-16.md\\:py-20, section.py-20');

        filterLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                // Remove active class from all links
                filterLinks.forEach(l => {
                    l.classList.remove('active', 'border-[#C5A059]', 'text-[#C5A059]');
                    l.classList.add('text-gray-500');
                    l.style.borderBottomColor = '';
                });

                // Add active class to clicked link
                this.classList.add('active');
                this.classList.remove('text-gray-500');
                this.style.color = '#C5A059';
                this.style.borderBottomColor = '#C5A059';

                // Get target category
                const category = this.getAttribute('data-category');

                // Show/hide sections based on category
                if (category === 'all') {
                    // Show all category sections
                    allSections.forEach(section => {
                        section.style.display = '';
                    });
                    // Show promotional banners
                    promotionalBanners.forEach(banner => {
                        if (!banner.hasAttribute('data-category')) {
                            banner.style.display = '';
                        }
                    });
                } else {
                    // Hide promotional banners when filtering
                    promotionalBanners.forEach(banner => {
                        if (!banner.hasAttribute('data-category')) {
                            banner.style.display = 'none';
                        }
                    });

                    // Show only selected category
                    let targetSection = null;
                    allSections.forEach(section => {
                        if (section.getAttribute('data-category') === category) {
                            section.style.display = '';
                            targetSection = section;
                        } else {
                            section.style.display = 'none';
                        }
                    });

                    // Smooth scroll to the target section
                    if (targetSection) {
                        setTimeout(() => {
                            targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }, 100);
                    }
                }
            });
        });
    });
</script>

<?php get_footer(); ?>