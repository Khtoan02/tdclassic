<?php
/**
 * The template for displaying project archive pages
 */

get_header(); ?>

<style>
.projects-page .projects-hero {
    padding-top: 190px !important;
    padding-bottom: 40px !important;
    background-color: #050505 !important;
}
@media (max-width: 768px) {
    .projects-page .projects-hero {
        padding-top: 140px !important;
        padding-bottom: 24px !important;
    }
}
.projects-page .projects-hero .hero-content {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
    text-align: center !important;
    width: 100% !important;
    margin: 0 auto !important;
}
.projects-page .projects-hero .hero-content span {
    display: block !important;
    text-align: center !important;
    margin: 0 auto 12px !important;
}
.projects-page .projects-hero .hero-title {
    color: #ffffff !important;
    font-size: 3rem !important;
    font-weight: 700 !important;
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    text-align: center !important;
    margin: 0 auto 16px !important;
    width: 100% !important;
}
@media (max-width: 768px) {
    .projects-page .projects-hero .hero-title {
        font-size: 2rem !important;
    }
    .projects-page .filter-wrapper {
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 12px !important;
    }
    .projects-page .filter-tabs {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        scrollbar-width: none !important;
        -webkit-overflow-scrolling: touch !important;
        padding-bottom: 6px !important;
        gap: 8px !important;
        width: 100% !important;
    }
    .projects-page .filter-tabs::-webkit-scrollbar {
        display: none !important;
    }
    .projects-page .filter-tab {
        white-space: nowrap !important;
        flex-shrink: 0 !important;
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        color: #d1d5db !important;
    }
    .projects-page .filter-tab.active {
        background: #C5A059 !important;
        border-color: #C5A059 !important;
        color: #000000 !important;
        font-weight: 700 !important;
    }
    .projects-page .filter-search {
        width: 100% !important;
    }
    .projects-page input#project-search {
        width: 100% !important;
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        color: #ffffff !important;
    }
}
</style>

<div id="primary" class="projects-page bg-void min-h-screen">
    <!-- Hero Section -->
    <section class="projects-hero text-center pb-10 bg-void">
        <div class="container mx-auto px-6">
            <div class="hero-content max-w-3xl mx-auto flex flex-col items-center justify-center text-center">
                <span class="block font-sans text-xs tracking-[0.3em] uppercase mb-3" style="color: #C5A059 !important;">Portfolio & Showcase</span>
                <h1 class="hero-title font-sans font-bold text-3xl sm:text-5xl md:text-6xl mb-4" style="color: #ffffff !important; width: 100%;">Dự Án Tiêu Biểu</h1>
                <p class="hero-subtitle text-gray-400 text-sm sm:text-base font-light max-w-2xl mx-auto">Khám phá các công trình và giải pháp âm thanh chuyên nghiệp hàng đầu được thực hiện bởi TD Classic</p>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="projects-filter">
        <div class="container">
            <div class="filter-wrapper">
                <div class="filter-tabs" role="tablist" aria-label="Lọc theo danh mục dự án">
                    <button class="filter-tab active" data-filter="all" role="tab" aria-selected="true">Tất cả</button>
                    <?php
                    $project_categories = get_terms(array(
                        'taxonomy' => 'project_category',
                        'hide_empty' => true,
                    ));
                    if ($project_categories && !is_wp_error($project_categories)) :
                        foreach ($project_categories as $category) :
                    ?>
                        <button class="filter-tab" data-filter="<?php echo esc_attr($category->slug); ?>" role="tab" aria-selected="false" aria-label="<?php echo esc_attr($category->name); ?>">
                            <?php echo esc_html($category->name); ?>
                        </button>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
                <div class="filter-search">
                    <input type="text" id="project-search" placeholder="Tìm kiếm dự án..." aria-label="Tìm kiếm dự án theo tiêu đề">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Grid -->
    <section class="projects-grid">
        <div class="container mx-auto px-6">
            <?php 
            global $wp_query;
            $project_query = $wp_query;
            if (!have_posts() || get_query_var('post_type') !== 'project') {
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $project_query = new WP_Query(array(
                    'post_type' => 'project',
                    'posts_per_page' => 12,
                    'paged' => $paged,
                    'post_status' => 'publish'
                ));
            }
            if ($project_query->have_posts()) : 
                $proj_idx = 0;
            ?>
                <div class="projects-container" id="projects-container">
                    <?php while ($project_query->have_posts()) : $project_query->the_post();
                        $proj_idx++;
                        $cats = get_the_terms(get_the_ID(), 'project_category');
                        $category_classes = '';
                        $category_name = '';
                        if ($cats && !is_wp_error($cats)) {
                            foreach ($cats as $cat) {
                                $category_classes .= ' category-' . $cat->slug;
                            }
                            $category_name = $cats[0]->name;
                        }
                    ?>
                        <article class="project-card<?php echo esc_attr($category_classes); ?>" data-title="<?php echo esc_attr(strtolower(get_the_title())); ?>">
                            <div class="project-image">
                                <a href="<?php the_permalink(); ?>" class="ratio ratio-1x1 overflow-hidden d-block" aria-label="<?php the_title_attribute(); ?>">
                                    <?php $thumb = function_exists('tdclassic_get_project_thumb_url') ? tdclassic_get_project_thumb_url(get_the_ID()) : '';
                                    if ($thumb): ?>
                                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title(); ?>" width="600" height="600" class="object-fit-cover" <?php echo ($proj_idx === 1) ? 'fetchpriority="high" loading="eager"' : 'loading="lazy" decoding="async"'; ?>>
                                    <?php else: ?>
                                        <div class="project-placeholder d-flex align-items-center justify-content-center">
                                            <span class="placeholder-text"><?php the_title(); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </a>

                                <div class="project-description-overlay">
                                    <div class="description-content">
                                        <p class="h6 fw-bold text-white mb-2">Thông tin dự án</p>
                                        <div class="description-text">
                                            <?php echo get_the_excerpt(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="project-content">
                                <h2 class="project-title h4">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div class="project-meta text-muted small">
                                    <span class="me-2"><i class="fas fa-calendar-alt me-1" aria-hidden="true"></i><?php echo get_the_date(); ?></span>
                                </div>
                                <?php if ($cats && !is_wp_error($cats)) : ?>
                                <div class="project-category-highlight project-badges" aria-label="Danh mục dự án">
                                    <?php foreach ($cats as $cat_item): ?>
                                        <span class="badge badge-tag"><?php echo esc_html($cat_item->name); ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                                <p class="project-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 16, '...'); ?></p>
                                <div class="project-actions">
                                    <a href="<?php the_permalink(); ?>" class="btn-view-details">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>

                <!-- Pagination -->
                <div class="projects-pagination">
                    <?php tdclassic_pagination(); ?>
                </div>
            <?php else : ?>
                <div class="no-projects text-center py-12">
                    <h2 class="h3 text-white">Chưa có dự án nào</h2>
                    <p class="text-gray-400">Danh mục dự án sẽ được cập nhật trong thời gian sớm nhất.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Woo Featured Products Section: 3 sản phẩm Loa chuyên nghiệp -->
    <section id="projects-woo-featured" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="h2 fw-bold mb-2 text-white">Sản Phẩm Tiêu Biểu</h2>
                <p class="text-gray-400 fs-6">Khám phá các sản phẩm và giải pháp nổi bật của TD Classic.</p>
            </div>
            <div class="row g-4">
                <?php
                $term = get_term_by('slug', 'loa-chuyen-nghiep', 'product_cat');
                if (!$term) {
                    $maybe = get_terms(array('taxonomy' => 'product_cat','name' => 'Loa chuyên nghiệp','number' => 1));
                    if ($maybe && !is_wp_error($maybe)) { $term = $maybe[0]; }
                }
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 4,
                    'post_status' => 'publish',
                );
                if ($term && !is_wp_error($term)) {
                    $args['tax_query'] = array(array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $term->term_id,
                    ));
                }
                $woo_q = new WP_Query($args);
                if ($woo_q->have_posts()) :
                    while ($woo_q->have_posts()) : $woo_q->the_post(); ?>
                        <div class="col-6 col-lg-3">
                            <div class="card bg-dark border-0 rounded-3 shadow-sm overflow-hidden h-100">
                                <a href="<?php the_permalink(); ?>" class="d-block ratio ratio-4x3" aria-label="<?php the_title_attribute(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img src="<?php the_post_thumbnail_url('large'); ?>" width="400" height="300" class="w-100 h-100 object-fit-cover" alt="<?php the_title(); ?>" loading="lazy" decoding="async">
                                    <?php else: ?>
                                        <div class="bg-secondary w-100 h-100 d-flex align-items-center justify-content-center text-white-50"><span class="small"><?php the_title(); ?></span></div>
                                    <?php endif; ?>
                                </a>
                                <div class="card-body p-4 d-flex flex-column">
                                    <h3 class="h5 fw-bold mb-2 text-white"><?php the_title(); ?></h3>
                                    <p class="text-gray-400 fs-6 mb-2"><?php echo wp_trim_words(get_the_excerpt(), 12, '…'); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="mt-auto d-inline-block text-white text-decoration-none">Tìm hiểu thêm →</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata();
                else: ?>
                    <div class="col-12"><p class="text-center text-muted">Đang cập nhật sản phẩm nổi bật…</p></div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="projects-features" class="py-5 bg-dark">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="h2 fw-bold mb-2 text-white">Đặc Điểm Vượt Trội</h2>
                <p class="text-gray-400 fs-6">Sự khác biệt tạo nên đẳng cấp.</p>
            </div>
            <div class="row g-4">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="d-flex flex-column align-items-center text-center p-4 rounded-3 bg-secondary bg-opacity-10 h-100">
                        <svg class="mb-4" style="width: 4rem; height: 4rem; color: #fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m-6 0v2a2 2 0 002 2h2a2 2 0 002-2v-2m-2-6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path></svg>
                        <h3 class="h5 fw-bold mb-2 text-white">Âm thanh chất lượng cao</h3>
                        <p class="text-gray-400 fs-6 mb-0">Độ trung thực cao, tái tạo mọi sắc thái âm nhạc.</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="d-flex flex-column align-items-center text-center p-4 rounded-3 bg-secondary bg-opacity-10 h-100">
                        <svg class="mb-4" style="width: 4rem; height: 4rem; color: #fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                        <h3 class="h5 fw-bold mb-2 text-white">Thiết kế tinh tế</h3>
                        <p class="text-gray-400 fs-6 mb-0">Kết hợp công nghệ và thiết kế, hợp mọi không gian.</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="d-flex flex-column align-items-center text-center p-4 rounded-3 bg-secondary bg-opacity-10 h-100">
                        <svg class="mb-4" style="width: 4rem; height: 4rem; color: #fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9h-6m-9 9a9 9 0 01-9-9m9 9a9 9 0 00-9-9m9 9v-6m-9 9a9 9 0 01-9-9m9 9a9 9 0 00-9-9m9 9h-6m-9 9a9 9 0 01-9-9m9 9a9 9 0 00-9-9m9 9v-6"></path></svg>
                        <h3 class="h5 fw-bold mb-2 text-white">Giải pháp tùy chỉnh</h3>
                        <p class="text-gray-400 fs-6 mb-0">Thiết kế chuyên biệt theo yêu cầu từng dự án.</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="d-flex flex-column align-items-center text-center p-4 rounded-3 bg-secondary bg-opacity-10 h-100">
                        <svg class="mb-4" style="width: 4rem; height: 4rem; color: #fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <h3 class="h5 fw-bold mb-2 text-white">Tiết kiệm năng lượng</h3>
                        <p class="text-gray-400 fs-6 mb-0">Thiết bị tối ưu hiệu suất và tiết kiệm điện.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section: 3 bài viết mới nhất -->
    <section id="projects-news" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="h2 fw-bold mb-2 text-white">Tin Tức TD Classic</h2>
                <p class="text-gray-400 fs-6">Cập nhật các tin tức và sự kiện mới nhất.</p>
            </div>
            <div class="row g-4">
                <?php $news = new WP_Query(array('post_type' => 'post','posts_per_page' => 4,'post_status' => 'publish')); if ($news->have_posts()) : while ($news->have_posts()) : $news->the_post(); ?>
                    <div class="col-6 col-lg-3">
                        <div class="card bg-black border-0 rounded-3 shadow-sm overflow-hidden h-100">
                            <a href="<?php the_permalink(); ?>" class="d-block ratio ratio-4x3" aria-label="<?php the_title_attribute(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php the_post_thumbnail_url('large'); ?>" width="400" height="300" class="w-100 h-100 object-fit-cover" alt="<?php the_title(); ?>" loading="lazy" decoding="async">
                                <?php else: ?>
                                    <div class="bg-secondary w-100 h-100 d-flex align-items-center justify-content-center text-white-50"><span class="small"><?php the_title(); ?></span></div>
                                <?php endif; ?>
                            </a>
                            <div class="card-body p-4 d-flex flex-column">
                                <p class="text-muted small mb-2"><?php echo get_the_date('d/m/Y'); ?></p>
                                <h3 class="h6 fw-bold mb-2 text-white"><?php the_title(); ?></h3>
                                <p class="text-gray-400 fs-6 mb-2"><?php echo wp_trim_words(get_the_excerpt(), 12, '…'); ?></p>
                                <a href="<?php the_permalink(); ?>" class="mt-auto d-inline-block text-white text-decoration-none">Đọc thêm →</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); else: ?>
                    <div class="col-12"><p class="text-center text-muted">Đang cập nhật tin tức…</p></div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<script>
// Project filtering and search functionality (similar to products page)
document.addEventListener('DOMContentLoaded', function() {
    const filterTabs = document.querySelectorAll('.projects-filter .filter-tab');
    const projectCards = document.querySelectorAll('.project-card');
    const searchInput = document.getElementById('project-search');

    // Filter by category
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const filter = this.dataset.filter;
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            projectCards.forEach(card => {
                if (filter === 'all' || card.classList.contains('category-' + filter)) {
                    card.style.display = 'block';
                    setTimeout(() => card.style.opacity = '1', 10);
                } else {
                    card.style.opacity = '0';
                    setTimeout(() => card.style.display = 'none', 300);
                }
            });
        });
    });

    // Search by title
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            projectCards.forEach(card => {
                const title = card.dataset.title || '';
                if (title.includes(searchTerm)) {
                    card.style.display = 'block';
                    setTimeout(() => card.style.opacity = '1', 10);
                } else {
                    card.style.opacity = '0';
                    setTimeout(() => card.style.display = 'none', 300);
                }
            });
        });
    }
});
</script>

</div><!-- #primary -->
<?php get_footer(); ?> 

