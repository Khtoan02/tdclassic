<?php
/**
 * The template for displaying product category archive pages
 * Luxury Dark Mode Design
 *
 * @package TD_Classic
 */

get_header();

// Get current category
$queried_object = get_queried_object();
$current_category = $queried_object;
$term_description = term_description();

// Get child categories (subcategories)
$child_categories = get_terms(array(
    'taxonomy' => 'product_category',
    'parent' => $current_category->term_id,
    'hide_empty' => false,
    'orderby' => 'name',
    'order' => 'ASC'
));

// Get category thumbnail
$thumbnail_id = get_term_meta($current_category->term_id, 'thumbnail_id', true);
$category_image = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : 'https://images.unsplash.com/photo-1543508282-6319a3e2621f?q=80&w=1600&auto=format&fit=crop';

// Get products count
$products_query = new WP_Query(array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_category',
            'field' => 'term_id',
            'terms' => $current_category->term_id,
        )
    )
));
$total_products = $products_query->found_posts;
wp_reset_postdata();

// Get featured/flagship product (most recent or featured)
$flagship_product_query = new WP_Query(array(
    'post_type' => 'product',
    'posts_per_page' => 1,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_category',
            'field' => 'term_id',
            'terms' => $current_category->term_id,
        )
    ),
    'orderby' => 'date',
    'order' => 'DESC'
));
?>

<!-- Noise texture overlay -->
<div class="noise"></div>

<!-- CATEGORY HERO -->
<section class="relative pt-32 pb-20 bg-void overflow-hidden">
    <!-- Dynamic Background for Category -->
    <div class="absolute top-0 right-0 w-2/3 h-full opacity-20">
        <img src="<?php echo esc_url($category_image); ?>" class="w-full h-full object-cover grayscale" style="mask-image: linear-gradient(to left, transparent, black);">
        <div class="absolute inset-0 bg-gradient-to-l from-void via-void/50 to-void"></div>
    </div>

    <div class="container mx-auto px-6 md:px-12 relative z-10">
        <a href="<?php echo home_url('/san-pham'); ?>" class="inline-flex items-center gap-2 text-gray-500 hover:text-gold transition-colors font-sans text-xs font-bold uppercase tracking-widest mb-8">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Quay lại danh sách
        </a>
        
        <h1 class="font-serif text-5xl md:text-7xl text-white mb-6"><?php echo single_term_title('', false); ?></h1>
        <?php if (!empty($term_description)) : ?>
            <div class="font-sans text-gray-400 text-sm md:text-base font-light leading-relaxed max-w-xl">
                <?php echo wpautop($term_description); ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- STICKY SUB-CATEGORY FILTER -->
<?php if (!empty($child_categories)) : ?>
<div class="sticky top-0 z-30 sticky-bar bg-void/80 transition-all duration-300" style="backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,0.05);">
    <div class="container mx-auto px-6 md:px-12">
        <div class="flex items-center justify-between h-16">
            <!-- Mobile Scrollable List -->
            <div class="flex overflow-x-auto no-scrollbar gap-4 md:gap-8 w-full items-center">
                <a href="<?php echo get_term_link($current_category); ?>" class="text-gold font-sans text-xs font-bold uppercase tracking-widest whitespace-nowrap border-b-2 border-gold pb-4 mt-4">Tất cả</a>
                <?php foreach ($child_categories as $child_cat) : ?>
                    <a href="<?php echo get_term_link($child_cat); ?>" class="text-gray-500 hover:text-white font-sans text-xs font-bold uppercase tracking-widest whitespace-nowrap pb-4 mt-4 transition-colors"><?php echo $child_cat->name; ?></a>
                <?php endforeach; ?>
            </div>
            
            <!-- Count -->
            <span class="hidden md:block text-gray-600 font-sans text-xs tracking-widest"><?php echo $total_products; ?> Sản phẩm</span>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- SPOTLIGHT PRODUCT (Flagship of the Category) -->
<?php if ($flagship_product_query->have_posts()) : ?>
    <?php while ($flagship_product_query->have_posts()) : $flagship_product_query->the_post(); ?>
        <?php 
        $product_specs = get_post_meta(get_the_ID(), '_product_specs', true);
        ?>
        <section class="py-16 md:py-24 bg-void border-b border-white/5">
            <div class="container mx-auto px-6 md:px-12">
                <div class="product-card group cursor-pointer relative bg-metal border border-white/5 overflow-hidden h-[400px] md:h-[600px]">
                    <div class="img-container w-full h-full">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('full'); ?>" class="w-full h-full object-cover" alt="<?php the_title(); ?>">
                        <?php else : ?>
                            <img src="https://images.unsplash.com/photo-1543508282-6319a3e2621f?q=80&w=1200&auto=format&fit=crop" class="w-full h-full object-cover" alt="Flagship">
                        <?php endif; ?>
                    </div>
                    <div class="overlay absolute inset-0 flex flex-col justify-end p-8 md:p-16" style="background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, transparent 100%); opacity: 0; transition: opacity 0.4s ease;">
                        <span class="bg-gold text-black text-[10px] font-bold uppercase px-2 py-1 inline-block w-fit mb-4">Sản phẩm nổi bật</span>
                        <h2 class="font-serif text-3xl md:text-6xl text-white mb-4"><?php the_title(); ?></h2>
                        <p class="font-sans text-gray-300 text-sm md:text-base mb-8 max-w-lg hidden md:block">
                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                        </p>
                        <div class="flex items-center gap-8">
                            <a href="<?php the_permalink(); ?>" class="bg-white text-black px-8 py-4 font-sans text-xs font-bold uppercase tracking-widest hover:bg-gold transition-colors">Xem chi tiết</a>
                            <?php if ($product_specs) : ?>
                                <span class="text-gold font-sans text-xs uppercase tracking-widest hidden md:inline-block"><?php echo esc_html($product_specs); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
<?php endif; ?>

<!-- PRODUCT GRID (Comprehensive List) -->
<section class="py-24 bg-metal">
    <div class="container mx-auto px-6 md:px-12">
        <?php if (have_posts()) : ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-8">
                <?php while (have_posts()) : the_post(); ?>
                    <?php 
                    $product_specs = get_post_meta(get_the_ID(), '_product_specs', true);
                    $product_badge = get_post_meta(get_the_ID(), '_product_badge', true);
                    ?>
                    <div class="product-card group cursor-pointer bg-void border border-white/5 p-4 hover:border-gold/30 transition-all">
                        <a href="<?php the_permalink(); ?>">
                            <div class="img-container aspect-square bg-surface overflow-hidden mb-4 relative">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php the_post_thumbnail_url('medium_large'); ?>" class="w-full h-full object-cover" alt="<?php the_title(); ?>" loading="lazy">
                                <?php else : ?>
                                    <img src="https://images.unsplash.com/photo-1520697830682-bbb6e88e2516?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover" alt="<?php the_title(); ?>">
                                <?php endif; ?>
                                
                                <?php if ($product_badge) : ?>
                                    <div class="absolute top-2 right-2 bg-gold text-black text-[10px] font-bold px-2 py-1"><?php echo esc_html($product_badge); ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <h4 class="font-serif text-white text-sm md:text-base group-hover:text-gold transition-colors"><?php the_title(); ?></h4>
                            <p class="font-sans text-gray-500 text-[10px] uppercase mt-1">
                                <?php 
                                $categories = get_the_terms(get_the_ID(), 'product_category');
                                if ($categories && !is_wp_error($categories)) {
                                    echo esc_html($categories[0]->name);
                                }
                                ?>
                            </p>
                            <?php if ($product_specs) : ?>
                                <p class="text-gold text-xs mt-2"><?php echo esc_html($product_specs); ?></p>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Pagination / Load More -->
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $total_pages = $GLOBALS['wp_query']->max_num_pages;
            
            if ($total_pages > 1) :
            ?>
                <div class="text-center mt-16">
                    <nav aria-label="Products pagination" class="flex justify-center gap-2">
                        <?php
                        echo paginate_links(array(
                            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                            'format' => '?paged=%#%',
                            'current' => max(1, $paged),
                            'total' => $total_pages,
                            'prev_text' => '<i data-lucide="chevron-left" class="w-5 h-5"></i>',
                            'next_text' => '<i data-lucide="chevron-right" class="w-5 h-5"></i>',
                            'type' => 'plain',
                            'end_size' => 1,
                            'mid_size' => 1,
                            'before_page_number' => '<span class="inline-flex items-center justify-center w-10 h-10 border border-white/5 hover:border-gold/30 transition-colors text-gray-400 hover:text-gold text-xs">',
                            'after_page_number' => '</span>'
                        ));
                        ?>
                    </nav>
                </div>
            <?php endif; ?>

        <?php else : ?>
            <div class="text-center py-20">
                <i data-lucide="package-x" class="w-16 h-16 text-gray-600 mx-auto mb-4"></i>
                <h3 class="font-serif text-2xl text-white mb-2">Không tìm thấy sản phẩm nào</h3>
                <p class="text-gray-500 text-sm">Hiện tại chưa có sản phẩm nào trong danh mục này.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- TECHNOLOGY HIGHLIGHT (Specific to Category) -->
<section class="py-20 bg-void border-y border-white/5">
    <div class="container mx-auto px-6 md:px-12 text-center">
        <h2 class="font-serif text-3xl text-white mb-12">Công Nghệ Chế Tác</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-6 border border-white/5 hover:border-gold/30 transition-colors">
                <i data-lucide="layers" class="w-10 h-10 text-gold mx-auto mb-4 stroke-1"></i>
                <h4 class="text-white font-serif text-lg mb-2">Thùng Gỗ Bạch Dương</h4>
                <p class="text-gray-500 text-xs leading-relaxed">Sử dụng gỗ Birch Plywood 15mm-18mm nhập khẩu, triệt tiêu cộng hưởng thùng tối đa.</p>
            </div>
            <div class="p-6 border border-white/5 hover:border-gold/30 transition-colors">
                <i data-lucide="zap" class="w-10 h-10 text-gold mx-auto mb-4 stroke-1"></i>
                <h4 class="text-white font-serif text-lg mb-2">Củ Loa Neodymium</h4>
                <p class="text-gray-500 text-xs leading-relaxed">Nam châm đất hiếm cho từ lực mạnh, độ nhạy cao và trọng lượng nhẹ.</p>
            </div>
            <div class="p-6 border border-white/5 hover:border-gold/30 transition-colors">
                <i data-lucide="shield" class="w-10 h-10 text-gold mx-auto mb-4 stroke-1"></i>
                <h4 class="text-white font-serif text-lg mb-2">Sơn Polyurea</h4>
                <p class="text-gray-500 text-xs leading-relaxed">Công nghệ sơn siêu bền, chống nước, chống trầy xước, chịu va đập cực tốt.</p>
            </div>
        </div>
    </div>
</section>

<!-- DETAILED DOCUMENTATION (Combined & Dense) -->
<section class="py-20 bg-void border-t border-white/5 text-gray-600 font-sans text-[10px] leading-relaxed">
    <div class="container mx-auto px-6 md:px-12 max-w-5xl">
        <div class="dense-text space-y-6 opacity-70" style="text-align: justify; text-justify: inter-word;">
            <p>
                Thông tin được cung cấp trong tài liệu này phản ánh các thông số kỹ thuật và đặc tính hiệu suất của các dòng sản phẩm Loa Chuyên Nghiệp (Professional Speakers) tại thời điểm xuất bản. TD Classic, tuân theo chính sách phát triển và cải tiến sản phẩm liên tục, bảo lưu quyền thay đổi thiết kế, vật liệu và thông số kỹ thuật mà không cần thông báo trước. Những thay đổi này có thể bao gồm, nhưng không giới hạn ở, việc nâng cấp linh kiện phân tần, thay đổi cấu trúc thùng loa nhằm tối ưu hóa cộng hưởng âm học, hoặc điều chỉnh các thông số đáp tuyến tần số dựa trên kết quả đo đạc mới nhất từ phòng thí nghiệm tiêu chuẩn Anechoic. Mọi nỗ lực đã được thực hiện để đảm bảo tính chính xác của dữ liệu được trình bày; tuy nhiên, TD Classic không chịu trách nhiệm cho các lỗi in ấn hoặc sự khác biệt nhỏ giữa sản phẩm thực tế và hình ảnh minh họa do điều kiện ánh sáng hoặc quá trình in ấn/hiển thị kỹ thuật số.
            </p>
            <p>
                <strong>Đo lường và Kiểm định:</strong> Các thông số về độ nhạy (Sensitivity) và đáp tuyến tần số (Frequency Response) được đo đạc trong môi trường phòng tiêu âm tiêu chuẩn (Free-field condition), sử dụng thiết bị đo lường chuyên dụng Audio Precision và microphone đo lường được hiệu chuẩn Class 1. Công suất định mức (RMS Power Handling) được xác định thông qua quy trình kiểm tra IEC 60268-5, sử dụng tín hiệu nhiễu hồng (Pink Noise) với hệ số đỉnh (Crest Factor) là 6dB trong thời gian liên tục 2 giờ, mô phỏng điều kiện hoạt động khắc nghiệt nhất. Công suất cực đại (Peak Power) là khả năng chịu đựng tức thời của loa trong thời gian ngắn (dưới 10ms) và không được khuyến nghị duy trì liên tục để đảm bảo tuổi thọ linh kiện. Việc sử dụng amply công suất không phù hợp (quá thấp gây clipping hoặc quá cao gây quá tải nhiệt) có thể dẫn đến hư hỏng củ loa và sẽ không nằm trong phạm vi bảo hành tiêu chuẩn.
            </p>
            <p>
                <strong>Cơ sở chứng minh và Nguồn gốc:</strong> Các tuyên bố về "Linh kiện nhập khẩu" đề cập đến các thành phần quan trọng như tụ điện, cuộn cảm trong bộ phân tần và vật liệu màng loa, được cung cấp bởi các đối tác chiến lược tại Đức, Ý và Nhật Bản, có đầy đủ Chứng nhận xuất xứ (Certificate of Origin - C/O) và Chứng nhận chất lượng (Certificate of Quality - C/Q) theo yêu cầu. Quy trình lắp ráp và hoàn thiện thùng loa được thực hiện tại nhà máy của TD Classic tại Việt Nam, tuân thủ nghiêm ngặt hệ thống quản lý chất lượng ISO 9001:2015. Vật liệu thùng loa là gỗ Bạch Dương Baltic (Baltic Birch Plywood) loại 1, được xử lý chống mối mọt và phủ lớp sơn Polyurea công nghệ cao, đảm bảo khả năng chống trầy xước và kháng nước theo tiêu chuẩn IP54 (đối với các dòng loa ngoài trời).
            </p>
            <p>
                <strong>Tuyên bố miễn trừ trách nhiệm pháp lý:</strong> TD Classic từ chối mọi trách nhiệm đối với các thiệt hại trực tiếp, gián tiếp, ngẫu nhiên hoặc là hệ quả của việc lắp đặt sai quy cách, sử dụng sai mục đích, hoặc phối ghép thiết bị không tương thích. Người sử dụng có trách nhiệm đảm bảo hệ thống treo lắp (Rigging/Mounting) tuân thủ các quy định an toàn xây dựng tại địa phương và được thực hiện bởi nhân sự có chuyên môn. Mặc dù sản phẩm có khả năng hoạt động ở cường độ âm thanh lớn (High SPL), việc tiếp xúc lâu dài với mức áp suất âm thanh trên 85dB có thể gây tổn thương thính giác vĩnh viễn; người dùng cần tuân thủ các hướng dẫn an toàn lao động và sức khỏe liên quan. Logo TD Classic, tên thương hiệu, tên dòng sản phẩm (Signature Series, Master Series) và các thiết kế công nghiệp liên quan là tài sản trí tuệ độc quyền của Công ty Cổ phần Công nghệ TAVA Việt Nam và được bảo hộ bởi pháp luật sở hữu trí tuệ hiện hành. Nghiêm cấm mọi hành vi sao chép, làm giả hoặc sử dụng trái phép hình ảnh và thông tin sản phẩm dưới mọi hình thức.
            </p>
            <p>
                <strong>Chính sách Bảo hành và Hỗ trợ:</strong> Sản phẩm được bảo hành chính hãng 24 tháng đối với các lỗi kỹ thuật do nhà sản xuất. Phạm vi bảo hành bao gồm củ loa (Driver) và mạch phân tần (Crossover). Bảo hành không áp dụng cho các trường hợp: (a) Hư hỏng do thiên tai, hỏa hoạn, ngập nước; (b) Hư hỏng do vận chuyển hoặc va đập vật lý; (c) Cháy coil loa do sử dụng quá công suất hoặc amply bị rò điện DC; (d) Tem bảo hành bị rách, tẩy xóa hoặc sản phẩm đã bị can thiệp bởi bên thứ ba không được ủy quyền. Để nhận được hỗ trợ kỹ thuật và dịch vụ bảo hành, vui lòng liên hệ Trung tâm Dịch vụ Khách hàng của TD Classic hoặc các đại lý ủy quyền chính thức kèm theo hóa đơn mua hàng hợp lệ. Tài liệu này có hiệu lực từ ngày 01/01/2025 và thay thế cho mọi phiên bản tài liệu thông số kỹ thuật trước đó.
            </p>
        </div>
        
        <div class="mt-12 pt-8 border-t border-white/5 text-center opacity-40">
            <p>Mã tài liệu: DOC-CAT-SPEAKERS-2025 | Bản quyền © 2025 TD Classic Audio. Mọi quyền được bảo lưu.</p>
        </div>
    </div>
</section>

<style>
/* Product Card Hover Effects */
.product-card .img-container img {
    transition: transform 0.8s cubic-bezier(0.2, 1, 0.3, 1);
}
.product-card:hover .img-container img {
    transform: scale(1.08);
}
.product-card .overlay {
    transition: opacity 0.4s ease;
}
.product-card:hover .overlay {
    opacity: 1 !important;
}

/* No scrollbar */
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>

<script>
// Initialize Lucide icons
if (typeof lucide !== 'undefined') {
    lucide.createIcons();
}
</script>

<?php
get_footer();