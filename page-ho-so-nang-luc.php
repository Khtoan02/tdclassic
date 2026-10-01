<?php
/**
 * Template Name: Hồ sơ năng lực
 * Description: Hiển thị file PDF hồ sơ năng lực do admin cấu hình. Thiết kế Dark Luxury.
 *
 * @package TD_Classic
 */

get_header(); 
$pdf_url = function_exists('tdclassic_get_company_profile_pdf_url') ? tdclassic_get_company_profile_pdf_url() : '';
?>

<main id="primary" class="site-main bg-void text-gray-200 min-h-screen pb-20 page-header-clearance">
    <div class="max-w-6xl mx-auto px-6">
        
        <!-- Header Section -->
        <header class="mb-10 border-b border-white/10 pb-8">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-gold text-xs font-semibold uppercase tracking-widest mb-4">
                <i class="fa-solid fa-file-shield text-[10px]"></i>
                <span>Tài liệu chính thức</span>
            </div>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl text-white font-bold tracking-tight mb-3">
                        Hồ Sơ Năng Lực
                    </h1>
                    <p class="text-sm md:text-base text-gray-400 font-light max-w-2xl leading-relaxed">
                        Tài liệu giới thiệu năng lực kỹ thuật, quy trình sản xuất và các dự án âm thanh tiêu biểu của TD Classic.
                    </p>
                </div>

                <?php if (!empty($pdf_url)): ?>
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="<?php echo esc_url($pdf_url); ?>" target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-white/15 bg-white/5 hover:border-gold hover:text-gold text-white text-xs font-bold uppercase tracking-wider transition-all">
                            <i class="fa-solid fa-arrow-up-right-from-square text-[11px]"></i>
                            <span>Mở tab mới</span>
                        </a>
                        <a href="<?php echo esc_url($pdf_url); ?>" download
                           class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-gold hover:bg-goldDim text-black text-xs font-bold uppercase tracking-wider transition-all shadow-[0_4px_16px_rgba(197,160,89,0.3)]">
                            <i class="fa-solid fa-download text-[11px]"></i>
                            <span>Tải về PDF</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </header>

        <!-- PDF Viewer or Notice -->
        <?php if (!empty($pdf_url)): ?>
            <div class="rounded-2xl overflow-hidden border border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.8)] bg-surface aspect-[4/3] md:aspect-[16/10] w-full">
                <iframe src="<?php echo esc_url($pdf_url); ?>#view=fitH" 
                        class="w-full h-full border-0" 
                        loading="lazy" 
                        allowfullscreen 
                        title="Hồ sơ năng lực TD Classic">
                </iframe>
            </div>

            <div class="mt-6 flex flex-wrap items-center justify-between text-xs text-gray-400 gap-4">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-white/5 border border-white/10 text-white font-mono">
                        <i class="fa-solid fa-file-pdf text-red-400"></i> PDF Document
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-white/5 border border-white/10 text-gold font-mono">
                        <i class="fa-solid fa-shield-halved"></i> TD Classic Official
                    </span>
                </div>
                <p class="font-light">Nếu trình duyệt không tự mở được PDF, vui lòng nhấn <strong>Tải về PDF</strong> ở trên.</p>
            </div>
        <?php else: ?>
            <div class="text-center py-16 px-6 rounded-3xl bg-surface/40 border border-white/10 max-w-xl mx-auto">
                <div class="w-14 h-14 mx-auto mb-5 rounded-full bg-gold/10 border border-gold/30 flex items-center justify-center text-gold text-xl">
                    <i class="fa-solid fa-file-circle-exclamation"></i>
                </div>
                <h2 class="font-serif text-2xl text-white font-bold mb-3">Tài liệu đang được cập nhật</h2>
                <p class="text-sm text-gray-400 leading-relaxed font-light mb-6">
                    Hồ sơ năng lực đang được bộ phận chuyên môn hoàn thiện phiên bản mới nhất. Quý khách hàng vui lòng liên hệ trực tiếp để nhận tài liệu qua email.
                </p>
                <a href="<?php echo esc_url(home_url('/lien-he')); ?>" 
                   class="inline-flex items-center px-6 py-3 rounded-full bg-gold hover:bg-goldDim text-black text-xs font-bold uppercase tracking-widest transition-colors">
                    Liên hệ nhận tài liệu
                </a>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
