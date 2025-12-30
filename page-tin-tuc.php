<?php
/**
 * Template Name: Tin tức - Luxury Dark Mode
 * The template for displaying the news/blog page
 */

get_header(); ?>

<style>
    /* Styling from blog.txt */
    body { background-color: #050505; color: #E5E5E5; }
    .noise {
        position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
        pointer-events: none; z-index: 50; opacity: 0.03;
        background: url('https://grainy-gradients.vercel.app/noise.svg');
    }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    /* Sticky Filter Bar Effect */
    .sticky-bar {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    /* Article Card Hover */
    .article-card .img-container img {
        transition: transform 0.8s cubic-bezier(0.2, 1, 0.3, 1);
    }
    .article-card:hover .img-container img {
        transform: scale(1.05);
    }
    
    /* Justified text for dense look */
    .dense-text {
        text-align: justify;
        text-justify: inter-word;
    }

    /* Loading Spinner */
    .loader {
        border: 2px solid rgba(197, 160, 89, 0.1);
        border-left-color: #C5A059;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    /* Hide elements for filtering/loading */
    .hidden-item { display: none !important; }
</style>

<div class="noise"></div>

<!-- PAGE HERO -->
<section class="relative pt-32 pb-20 bg-void overflow-hidden">
    <!-- Dynamic Background -->
    <div class="absolute top-0 right-0 w-3/4 h-full opacity-20">
            <img src="https://images.unsplash.com/photo-1481437642641-2f0ae875f836?q=80&w=1600&auto=format&fit=crop" class="w-full h-full object-cover grayscale mask-image-gradient">
            <div class="absolute inset-0 bg-gradient-to-l from-void via-void/50 to-void"></div>
    </div>

    <div class="container mx-auto px-6 md:px-12 relative z-10">
        <a href="<?php echo home_url('/'); ?>" class="inline-flex items-center gap-2 text-gray-500 hover:text-gold transition-colors font-sans text-xs font-bold uppercase tracking-widest mb-8">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Trang chủ
        </a>
        
        <h1 class="font-serif text-5xl md:text-7xl text-white mb-6">Tạp Chí Âm Thanh</h1>
        <p class="font-sans text-gray-400 text-sm md:text-base font-light leading-relaxed max-w-xl">
            Nơi chia sẻ kiến thức chuyên sâu, xu hướng công nghệ và những câu chuyện hậu trường từ các dự án âm thanh đẳng cấp của TD Classic.
        </p>
    </div>
</section>

<!-- STICKY FILTER BAR -->
<div class="sticky top-0 z-30 sticky-bar bg-void/90 transition-all duration-300 shadow-2xl shadow-black/50">
    <div class="container mx-auto px-6 md:px-12">
        <div class="flex items-center justify-between h-16">
            <!-- Filter Buttons -->
            <div class="flex overflow-x-auto no-scrollbar gap-6 w-full items-center" id="filter-container">
                <button class="filter-btn text-gold font-sans text-xs font-bold uppercase tracking-widest whitespace-nowrap border-b-2 border-gold pb-4 mt-4 transition-all" data-filter="all">Tất cả</button>
                <?php
                // Dynamic Categories based on existing terms
                $categories = get_categories(array('hide_empty' => true));
                foreach ($categories as $cat) {
                    // Create a slug for data-filter
                    $filter_slug = $cat->slug;
                    echo '<button class="filter-btn text-gray-500 hover:text-white font-sans text-xs font-bold uppercase tracking-widest whitespace-nowrap pb-4 mt-4 transition-colors border-b-2 border-transparent hover:border-white/20" data-filter="' . esc_attr($filter_slug) . '">' . esc_html($cat->name) . '</button>';
                }
                ?>
            </div>
            
            <!-- Search Icon -->
            <button class="text-gray-400 hover:text-gold transition-colors hidden md:block">
                <i data-lucide="search" class="w-5 h-5"></i>
            </button>
        </div>
    </div>
</div>

<!-- ARTICLES GRID -->
<section class="py-16 bg-metal min-h-screen">
    <div class="container mx-auto px-6 md:px-12">
        
        <!-- Grid Container -->
        <div id="article-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <?php
            // DATA FETCHING LOGIC (Preserved from old template)
            $paged          = (get_query_var('paged')) ? (int) get_query_var('paged') : 1;
            $posts_per_page = 9; // Reduce to 9 as requested

            // 1. Local Posts
            $local_query = new WP_Query(
                array(
                    'post_type'      => 'post',
                    'posts_per_page' => $posts_per_page,
                    'paged'          => $paged,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                )
            );

            $combined_posts = array();
            $total_pages_local = $local_query->max_num_pages;

            if ($local_query->have_posts()) {
                while ($local_query->have_posts()) {
                    $local_query->the_post();
                    
                    $categories = get_the_category();
                    $cat_slug = $categories ? $categories[0]->slug : 'uncategorized';
                    $cat_name = $categories ? $categories[0]->name : 'Tin tức';

                    $combined_posts[] = array(
                        'origin'        => 'local',
                        'title'         => get_the_title(),
                        'link'          => get_permalink(),
                        'image'         => get_the_post_thumbnail_url(get_the_ID(), 'large') ?: 'https://images.unsplash.com/photo-1516280440614-6697288d5d38?q=80&w=800&auto=format&fit=crop',
                        'date'          => get_the_date('d M Y'),
                        'raw_date'      => get_the_date('c'),
                        'excerpt'       => get_the_excerpt(),
                        'category_slug' => $cat_slug,
                        'category_name' => $cat_name,
                        'read_time'     => '5 min read' // Placeholder or calc
                    );
                }
                wp_reset_postdata();
            }

            // 2. Remote Posts (TavaLED) - Preserved
            $total_pages_remote = 1;
            if (function_exists('get_posts_from_main_site')) {
                 $remote_posts = get_posts_from_main_site($posts_per_page, $paged, $total_pages_remote);
                 if (!empty($remote_posts)) {
                    foreach ($remote_posts as $remote_post) {
                        $combined_posts[] = array(
                            'origin'        => 'remote',
                            'title'         => isset($remote_post['title']) ? $remote_post['title'] : '',
                            'link'          => isset($remote_post['link']) ? $remote_post['link'] : '#',
                            'image'         => isset($remote_post['image']) ? $remote_post['image'] : '',
                            'date'          => isset($remote_post['date']) ? $remote_post['date'] : '',
                            'raw_date'      => isset($remote_post['raw_date']) ? $remote_post['raw_date'] : '',
                            'excerpt'       => isset($remote_post['excerpt']) ? $remote_post['excerpt'] : '',
                            'category_slug' => 'tin-tuc', // Default for remote
                            'category_name' => 'TavaLED',
                            'read_time'     => '3 min read'
                        );
                    }
                 }
            }

            // Sort
            usort($combined_posts, function ($a, $b) {
                return strtotime($b['raw_date']) - strtotime($a['raw_date']);
            });

            // OUTPUT LOOP
            if (empty($combined_posts)) :
                echo '<div class="col-span-3 text-center text-gray-500">Chưa có bài viết nào.</div>';
            else :
                foreach ($combined_posts as $post) :
            ?>
                <!-- Article Card -->
                <article class="article-card group cursor-pointer flex flex-col h-full" data-category="<?php echo esc_attr($post['category_slug']); ?>">
                    <a href="<?php echo esc_url($post['link']); ?>" class="block flex flex-col h-full">
                        <div class="img-container aspect-[3/2] bg-surface overflow-hidden relative mb-6 border border-white/5">
                            <img src="<?php echo esc_url($post['image']); ?>" class="w-full h-full object-cover">
                            <div class="absolute top-4 left-4 bg-black/80 backdrop-blur text-gold text-[10px] font-bold uppercase px-3 py-1 tracking-widest border border-gold/20">
                                <?php echo esc_html($post['category_name']); ?>
                            </div>
                        </div>
                        <div class="flex-1 flex flex-col">
                            <div class="flex items-center gap-3 mb-3 text-[10px] text-gray-500 font-sans tracking-widest uppercase">
                                <span><?php echo esc_html($post['date']); ?></span>
                                <span class="w-1 h-1 bg-gold rounded-full"></span>
                                <span><?php echo esc_html($post['read_time']); ?></span>
                            </div>
                            <h3 class="font-serif text-xl text-white mb-3 group-hover:text-gold transition-colors leading-snug">
                                <?php echo esc_html($post['title']); ?>
                            </h3>
                            <p class="font-sans text-xs text-gray-400 font-light leading-relaxed mb-6 line-clamp-3">
                                <?php echo esc_html(wp_trim_words($post['excerpt'], 20)); ?>
                            </p>
                            <div class="mt-auto pt-4 border-t border-white/5">
                                <span class="text-gold text-[10px] font-bold uppercase tracking-widest group-hover:underline">Đọc tiếp</span>
                            </div>
                        </div>
                    </a>
                </article>
            <?php 
                endforeach;
            endif;
            ?>

        </div>
        
        <!-- Loading Sentinel -->
        <div id="loading-sentinel" class="py-12 flex justify-center items-center opacity-0 transition-opacity">
            <div class="flex flex-col items-center gap-3">
                <div class="loader"></div>
                <span class="text-[10px] text-gold uppercase tracking-widest font-sans">Đang tải thêm...</span>
            </div>
        </div>
        
        <!-- End of Content Message -->
        <div id="end-of-content" class="py-12 text-center hidden">
            <span class="text-[10px] text-gray-600 uppercase tracking-widest font-sans">Bạn đã xem hết danh sách</span>
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
            <p>Mã tài liệu: DOC-JOURNAL-2025 | Bản quyền © 2025 TD Classic Audio. Mọi quyền được bảo lưu.</p>
        </div>
    </div>
</section>

<!-- Include Scripts -->
<script>
    lucide.createIcons();

    // FILTER LOGIC
    const filterBtns = document.querySelectorAll('.filter-btn');
    const articles = document.querySelectorAll('.article-card');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Update Active State
            filterBtns.forEach(b => {
                b.classList.remove('text-gold', 'border-gold');
                b.classList.add('text-gray-500', 'border-transparent', 'hover:border-white/20');
            });
            btn.classList.remove('text-gray-500', 'border-transparent', 'hover:border-white/20');
            btn.classList.add('text-gold', 'border-gold');

            const filterValue = btn.getAttribute('data-filter');

            const allArticles = document.querySelectorAll('.article-card');
            allArticles.forEach(article => {
                if (filterValue === 'all' || article.getAttribute('data-category') === filterValue) {
                    article.style.display = 'flex'; 
                } else {
                    article.style.display = 'none';
                }
            });
        });
    });

    // INFINITE SCROLL LOGIC
    let page = 2; // Start from page 2 as page 1 is loaded by PHP
    let loading = false;
    let finished = false;
    const sentinel = document.getElementById('loading-sentinel');
    const grid = document.getElementById('article-grid');
    const endMessage = document.getElementById('end-of-content');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !loading && !finished) {
                loadMoreNews();
            }
        });
    }, { rootMargin: '200px' });

    observer.observe(sentinel);

    function loadMoreNews() {
        loading = true;
        sentinel.style.opacity = '1';

        const formData = new FormData();
        formData.append('action', 'tdclassic_load_more_news');
        formData.append('page', page);

        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === '') {
                finished = true;
                observer.unobserve(sentinel);
                sentinel.style.display = 'none';
                endMessage.classList.remove('hidden');
            } else {
                // Append new items
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data;
                
                Array.from(tempDiv.children).forEach(child => {
                    grid.appendChild(child);
                });
                
                page++;
                
                // Re-run filter logic on new items if a filter is active
                const activeFilter = document.querySelector('.filter-btn.text-gold').getAttribute('data-filter');
                if (activeFilter !== 'all') {
                    const newItems = document.querySelectorAll('.article-card:not([style])'); // Items just added
                     newItems.forEach(article => {
                        if (article.getAttribute('data-category') !== activeFilter) {
                            article.style.display = 'none';
                        }
                    });
                }
                
                // Re-init icons for new content if needed (Lucide handles auto but safe to check)
                lucide.createIcons();
            }
        })
        .catch(err => {
            console.error(err);
        })
        .finally(() => {
            loading = false;
            sentinel.style.opacity = '0';
        });
    }
</script>

<?php get_footer(); ?>