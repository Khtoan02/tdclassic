<?php
/**
 * Template Name: Hồ sơ năng lực
 * Description: Hiển thị file PDF hồ sơ năng lực do admin cấu hình trong Settings → General.
 */

get_header(); ?>

<main id="main" class="site-main">
    <section class="company-profile-page py-5">
        <div class="container">
            <div class="company-profile-header">
                <div>
                    <h1 class="company-profile-title h2">Hồ sơ năng lực</h1>
                    <p class="company-profile-subtitle">Tài liệu giới thiệu năng lực và dự án tiêu biểu.</p>
                </div>
                <div class="company-profile-toolbar">
                    <?php $pdf_for_btn = function_exists('tdclassic_get_company_profile_pdf_url') ? tdclassic_get_company_profile_pdf_url() : ''; ?>
                    <?php if (!empty($pdf_for_btn)): ?>
                        <a class="cp-btn" href="<?php echo esc_url($pdf_for_btn); ?>" target="_blank" rel="noopener" title="Mở tab mới">
                            <i class="fas fa-external-link-alt"></i> Mở tab mới
                        </a>
                        <button class="cp-btn" type="button" onclick="window.print()" title="In tài liệu">
                            <i class="fas fa-print"></i> In
                        </button>
                        <a class="cp-btn" href="<?php echo esc_url($pdf_for_btn); ?>" download title="Tải về PDF">
                            <i class="fas fa-download"></i> Tải về
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <?php
            $pdf_url = function_exists('tdclassic_get_company_profile_pdf_url') ? tdclassic_get_company_profile_pdf_url() : '';
            if ($pdf_url): ?>
                <div class="company-profile-viewer ratio ratio-4x3">
                    <iframe src="<?php echo esc_url($pdf_url); ?>#view=fitH" style="border:0;" loading="lazy" allowfullscreen></iframe>
                </div>
                <div class="company-profile-actions mt-3">
                    <span class="cp-badge"><i class="fas fa-file-pdf"></i> PDF</span>
                    <span class="cp-badge"><i class="fas fa-shield-alt"></i> TD Classic</span>
                </div>
            <?php else: ?>
                <div class="alert alert-warning" role="alert">
                    Chưa cấu hình file PDF hồ sơ năng lực. Vui lòng vào Admin → Settings → General để tải lên hoặc chọn file PDF.
                </div>
            <?php endif; ?>
        </div>
    </section>
    <style>
    @media print {
      .site-header, .site-footer, .company-profile-toolbar { display: none !important; }
      .company-profile-viewer { border: none !important; box-shadow: none !important; }
    }
    </style>
</main>

<?php get_footer(); ?>


