<?php
/**
 * The template for displaying all single posts
 *
 * @package TD_Classic
 */

get_header(); ?>

<style>
    /* Styling from single-blog.txt */
    body { background-color: #050505; color: #E5E5E5; }
    .noise {
        position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
        pointer-events: none; z-index: 50; opacity: 0.03;
        background: url('https://grainy-gradients.vercel.app/noise.svg');
    }
    
    /* Reading Progress Bar */
    #progress-bar {
        position: fixed;
        top: 0;
        left: 0;
        height: 2px;
        background: #C5A059;
        z-index: 100;
        width: 0%;
        transition: width 0.1s;
    }

    /* Typography Enhancements */
    /* Ensure only applies to entry content to avoid breaking other parts */
    .entry-content p:first-of-type::first-letter {
        float: left;
        font-family: 'Cinzel', serif;
        font-size: 4rem;
        line-height: 0.8;
        padding-right: 0.5rem;
        padding-top: 0.1rem;
        color: #C5A059;
    }
    
    .entry-content h2 {
        margin-top: 3rem;
        margin-bottom: 1.5rem;
        font-family: 'Cinzel', serif;
        font-size: 1.8rem;
        color: #fff;
        border-left: 2px solid #C5A059;
        padding-left: 1.5rem;
    }
    
    .entry-content p {
        margin-bottom: 1.5rem;
        line-height: 1.8;
        font-weight: 300;
        color: #ccc;
        font-family: 'Manrope', sans-serif;
    }

    .entry-content ul {
        margin-bottom: 1.5rem;
        list-style: none;
    }
    
    .entry-content li {
        position: relative;
        padding-left: 1.5rem;
        margin-bottom: 0.5rem;
        color: #ccc;
        font-family: 'Manrope', sans-serif;
    }
    
    .entry-content li::before {
        content: "•";
        color: #C5A059;
        position: absolute;
        left: 0;
        font-weight: bold;
    }

    .entry-content blockquote {
        border-top: 1px solid rgba(197, 160, 89, 0.3);
        border-bottom: 1px solid rgba(197, 160, 89, 0.3);
        padding: 2rem;
        margin: 3rem 0;
        text-align: center;
        font-family: 'Cinzel', serif;
        font-style: italic;
        font-size: 1.25rem;
        color: #C5A059;
        background: transparent;
    }
</style>

<div class="noise"></div>
<div id="progress-bar"></div>

<main id="main" class="site-main">

<?php
while (have_posts()) :
    the_post();
    
    // Get Categories
    $categories = get_the_category();
    $cat_name = $categories ? $categories[0]->name : 'Tin tức';
    
    // Get Featured Image
    $feat_img = get_the_post_thumbnail_url(get_the_ID(), 'full');
    if (!$feat_img) {
        $feat_img = 'https://images.unsplash.com/photo-1516280440614-6697288d5d38?q=80&w=1600&auto=format&fit=crop';
    }
?>

    <!-- ARTICLE HERO -->
    <section class="pt-32 pb-16 bg-void relative">
        <div class="container mx-auto px-6 md:px-12 max-w-4xl text-center">
            <div class="inline-flex items-center gap-3 mb-6">
                <!-- Back Link (Custom) -->
                <a href="<?php echo home_url('/tin-tuc'); ?>" class="absolute top-32 left-6 md:left-12 inline-flex items-center gap-2 text-gray-500 hover:text-gold transition-colors font-sans text-xs font-bold uppercase tracking-widest">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Quay lại
                </a>

                <span class="bg-gold/10 text-gold text-[10px] font-bold uppercase px-3 py-1 tracking-widest border border-gold/20 rounded-full"><?php echo esc_html($cat_name); ?></span>
                <span class="text-gray-500 text-[10px] font-sans uppercase tracking-widest"><?php echo get_the_date('d M Y'); ?> • <?php echo '5 min read'; // Placeholder ?></span>
            </div>
            
            <h1 class="font-serif text-3xl md:text-5xl lg:text-6xl text-white mb-8 leading-tight">
                <?php the_title(); ?>
            </h1>
            
            <?php if (has_excerpt()) : ?>
            <p class="font-sans text-gray-400 text-sm md:text-lg font-light leading-relaxed max-w-2xl mx-auto mb-12 italic">
                "<?php echo get_the_excerpt(); ?>"
            </p>
            <?php endif; ?>

            <div class="flex items-center justify-center gap-4">
                <div class="w-10 h-10 rounded-full bg-surface border border-white/10 overflow-hidden">
                    <?php echo get_avatar(get_the_author_meta('ID'), 40, '', '', array('class' => 'w-full h-full object-cover')); ?>
                </div>
                <div class="text-left">
                    <p class="text-white text-xs font-bold font-serif"><?php the_author(); ?></p>
                    <p class="text-gold text-[10px] uppercase tracking-widest">TD Classic Expert</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURED IMAGE -->
    <div class="container mx-auto px-4 md:px-12 max-w-6xl mb-16">
        <div class="aspect-video w-full overflow-hidden relative border border-white/5 group">
            <img src="<?php echo esc_url($feat_img); ?>" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000">
            <?php if (get_post_meta(get_the_ID(), '_thumbnail_caption', true)) : ?>
            <div class="absolute bottom-0 left-0 w-full p-4 bg-gradient-to-t from-black/80 to-transparent">
                <p class="text-gray-400 text-[10px] text-center italic"><?php echo get_post_meta(get_the_ID(), '_thumbnail_caption', true); ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ARTICLE CONTENT -->
    <article class="bg-void pb-24">
        <div class="container mx-auto px-6 md:px-12 max-w-3xl article-content font-sans text-base md:text-lg entry-content">
            <?php the_content(); ?>
        </div>
    </article>

    <!-- RELATED ARTICLES (Read Next) -->
    <section class="py-24 bg-metal border-t border-white/5">
        <div class="container mx-auto px-6 md:px-12">
            <div class="text-center mb-16">
                <span class="font-sans text-gold text-xs tracking-cinematic uppercase">Đừng bỏ lỡ</span>
                <h2 class="font-serif text-3xl text-white mt-4">Bài Viết Liên Quan</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php
                $related_query = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'post__not_in' => array(get_the_ID()),
                    'orderby' => 'rand' // Random for discovery or 'date'
                ));
                
                if ($related_query->have_posts()) :
                    while ($related_query->have_posts()) : $related_query->the_post();
                        $rel_cats = get_the_category();
                        $rel_cat = $rel_cats ? $rel_cats[0]->name : 'Tin tức';
                        $rel_img = get_the_post_thumbnail_url(get_the_ID(), 'medium_large') ?: 'https://images.unsplash.com/photo-1598653222000-6b7b7a552625?q=80&w=600&auto=format&fit=crop';
                ?>
                <!-- Related Item -->
                <article class="group cursor-pointer">
                    <a href="<?php the_permalink(); ?>">
                        <div class="aspect-[3/2] bg-surface overflow-hidden mb-4 relative border border-white/5">
                            <img src="<?php echo esc_url($rel_img); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </div>
                        <div class="text-gold text-[10px] font-bold uppercase tracking-widest mb-2"><?php echo esc_html($rel_cat); ?></div>
                        <h3 class="font-serif text-lg text-white group-hover:text-gold transition-colors leading-snug"><?php the_title(); ?></h3>
                    </a>
                </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </section>


    <!-- FOOTNOTES & LEGAL (Standardized) -->
    <section class="py-20 bg-void border-t border-white/5 text-gray-600 font-sans text-[10px] leading-relaxed">

        <div class="container mx-auto px-6 md:px-12 max-w-5xl">
            <div class="dense-text space-y-6 opacity-70">
                <p>
                    Thông tin được cung cấp trong trang Tạp chí này nhằm mục đích chia sẻ kiến thức và kinh nghiệm chung về lĩnh vực âm thanh. TD Classic không chịu trách nhiệm pháp lý cho việc áp dụng các kỹ thuật hoặc hướng dẫn này vào các trường hợp cụ thể mà không có sự tư vấn trực tiếp từ chuyên gia. Các thông số kỹ thuật và phương pháp được đề cập dựa trên các thử nghiệm và kinh nghiệm thực tế của đội ngũ kỹ thuật TD Classic tại thời điểm viết bài và có thể thay đổi tùy thuộc vào điều kiện môi trường, thiết bị cụ thể và các yếu tố ngoại cảnh khác.
                </p>
                <p>
                    <strong>Bản quyền nội dung:</strong> Toàn bộ nội dung bài viết, hình ảnh (trừ các hình ảnh minh họa từ nguồn mở được trích dẫn) và video trên trang này thuộc bản quyền của Công ty Cổ phần Công nghệ TAVA Việt Nam. Nghiêm cấm mọi hành vi sao chép, phát hành lại hoặc sử dụng cho mục đích thương mại mà không có sự đồng ý bằng văn bản của TD Classic. Việc trích dẫn nội dung phải ghi rõ nguồn và dẫn đường link gốc.
                </p>
                <p>
                    <strong>Tuyên bố miễn trừ:</strong> Các bài viết về dự án mang tính chất tham khảo (Case Study). Hiệu quả âm thanh thực tế của các giải pháp tương tự có thể khác biệt tùy thuộc vào kiến trúc, vật liệu tiêu âm và quy mô của từng công trình. TD Classic khuyến nghị khách hàng liên hệ trực tiếp để được khảo sát và tư vấn giải pháp "may đo" chính xác nhất. Chúng tôi bảo lưu quyền chỉnh sửa hoặc gỡ bỏ các nội dung đã đăng tải mà không cần thông báo trước.
                </p>
            </div>
            
            <div class="mt-12 pt-8 border-t border-white/5 text-center opacity-40">
                <p>Mã tài liệu: DOC-JOURNAL-DETAIL-2025 | Bản quyền © 2025 TD Classic Audio. Mọi quyền được bảo lưu.</p>
            </div>
        </div>
    </section>

<?php endwhile; ?>

</main>

<script>
    lucide.createIcons();

    // Scroll Progress Bar
    window.onscroll = function() {
        let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        let scrolled = (winScroll / height) * 100;
        let bar = document.getElementById("progress-bar");
        if (bar) bar.style.width = scrolled + "%";
    };
</script>

<?php
get_footer();