<?php
/**
 * TD Classic - LLMs.txt & Agentic Browsing Support
 * Adheres to https://llmstxt.org/ specification for AI search agents & Lighthouse 13.5+
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Auto-generate and cache physical static llms.txt and llms-full.txt in WordPress root
 * This allows LiteSpeed/Nginx to serve it directly in <10ms statically without booting PHP,
 * preventing Lighthouse fetch timeouts.
 */
function tdclassic_sync_physical_llms_files() {
    if (!defined('ABSPATH')) return;
    
    $llms_path = ABSPATH . 'llms.txt';
    $llms_full_path = ABSPATH . 'llms-full.txt';
    
    if (!file_exists($llms_path) || (time() - @filemtime($llms_path) > 86400)) {
        @file_put_contents($llms_path, tdclassic_generate_llms_content());
    }
    if (!file_exists($llms_full_path) || (time() - @filemtime($llms_full_path) > 86400)) {
        @file_put_contents($llms_full_path, tdclassic_generate_llms_full_content());
    }
}
add_action('init', 'tdclassic_sync_physical_llms_files', 0);

/**
 * Intercept /llms.txt and /llms-full.txt early on init
 */
add_action('init', 'tdclassic_handle_llms_txt_requests', 1);

function tdclassic_handle_llms_txt_requests() {
    $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    $path = parse_url($request_uri, PHP_URL_PATH);

    if ($path === '/llms.txt') {
        tdclassic_send_llms_txt_response(false);
    } elseif ($path === '/llms-full.txt') {
        tdclassic_send_llms_txt_response(true);
    }
}

/**
 * Send optimized plain text / markdown response with proper HTTP headers
 */
function tdclassic_send_llms_txt_response($is_full = false) {
    if (function_exists('header_remove')) {
        header_remove('X-Robots-Tag');
    }
    header('Content-Type: text/markdown; charset=utf-8');
    header('Cache-Control: public, max-age=86400, s-maxage=604800');
    header('X-LiteSpeed-Cache-Control: public, max-age=604800');
    header('Access-Control-Allow-Origin: *');
    header('X-Robots-Tag: index, follow');

    if ($is_full) {
        echo tdclassic_generate_llms_full_content();
    } else {
        echo tdclassic_generate_llms_content();
    }
    exit;
}

/**
 * Standard concise llms.txt content (<10KB)
 */
function tdclassic_generate_llms_content() {
    $site_url = home_url('/');
    $phone = function_exists('tdclassic_get_company_phone') ? tdclassic_get_company_phone() : '0904 433 799';
    $email = function_exists('tdclassic_get_company_email') ? tdclassic_get_company_email() : 'info@tdclassic.vn';

    $md = "# TD Classic - Hệ Thống Thiết Bị Âm Thanh Chuyên Nghiệp\n\n";
    $md .= "> TD Classic® là thương hiệu hàng đầu tại Việt Nam cung cấp giải pháp âm thanh chuyên nghiệp: Loa công suất lớn, Dàn karaoke cao cấp, Amply, Vang số (DSP), Bàn mixer và Thiết bị hội trường - rạp phim.\n\n";

    $md .= "## Danh Mục Chính\n";
    $md .= "- [Trang chủ]({$site_url}): Giới thiệu tổng quan thương hiệu và hệ sinh thái giải pháp âm thanh chuyên nghiệp.\n";
    $md .= "- [Giới thiệu]({$site_url}gioi-thieu/): Lịch sử phát triển, tầm nhìn, sứ mệnh và cam kết chất lượng của TD Classic.\n";
    $md .= "- [Sản phẩm]({$site_url}san-pham/): Toàn bộ sản phẩm: Loa chuyên nghiệp, Bàn trộn âm thanh, Amply, Micro, Bộ xử lý tín hiệu.\n";
    $md .= "- [Dự án tiêu biểu]({$site_url}du-an/): Các công trình âm thanh vũ trường, bar, hội trường, rạp phim và biệt thự cao cấp.\n";
    $md .= "- [Hồ sơ năng lực]({$site_url}ho-so-nang-luc/): Năng lực thiết kế, cung ứng thiết bị và thi công dự án âm thanh quy mô lớn.\n";
    $md .= "- [Hệ thống đại lý]({$site_url}dai-ly/): Danh sách đối tác phân phối chính hãng TD Classic trên toàn quốc.\n";
    $md .= "- [Liên hệ]({$site_url}lien-he/): Kênh tư vấn kỹ thuật, báo giá dự án và thông tin hệ thống showroom.\n\n";

    $md .= "## Danh Mục Sản Phẩm Nổi Bật\n";
    $md .= "- [Loa Chuyên Nghiệp]({$site_url}product-category/loa-chuyen-nghiep/): Hệ thống loa sân khấu, hội trường, phòng karaoke kinh doanh cao cấp.\n";
    $md .= "- [Bàn Trộn Âm Thanh]({$site_url}product-category/audio-mixer/): Mixer kỹ thuật số (Digital) và Analog từ các thương hiệu hàng đầu.\n";
    $md .= "- [Thiết Bị Khuếch Đại]({$site_url}product-category/thiet-bi-khuech-dai/): Cục đẩy công suất (Power Amplifier) độ bền cao, âm thanh uy lực.\n";
    $md .= "- [Bộ Xử Lý Tín Hiệu]({$site_url}product-category/bo-xu-ly-tin-hieu/): Vang số chuyên nghiệp (DSP), Crossover, Equalizer.\n";
    $md .= "- [Micro Không Dây]({$site_url}product-category/micro-khong-day/): Micro bắt sóng xa, chống hú rít tuyệt đối, tái hiện giọng hát trong trẻo.\n\n";

    $md .= "## Thông Tin Liên Hệ & Trụ Sở\n";
    $md .= "- Hotline / Zalo: {$phone}\n";
    $md .= "- Email: {$email}\n";
    $md .= "- Showroom Hải Phòng: Lô BT36-06 KĐT Tràng Duệ, Phường An Dương, TP Hải Phòng.\n";
    $md .= "- Văn phòng Hà Nội: Lô 5 - TT7 - Khu đấu giá Tứ Hiệp, Thanh Trì, Hà Nội.\n";
    $md .= "- Bản đầy đủ tài liệu: [llms-full.txt]({$site_url}llms-full.txt)\n";

    return $md;
}

/**
 * Full documentation catalog llms-full.txt
 */
function tdclassic_generate_llms_full_content() {
    $content = tdclassic_generate_llms_content();
    $content .= "\n## Cam Kết Chất Lượng & Dịch Vụ\n";
    $content .= "- 100% Sản phẩm chính hãng, đầy đủ CO/CQ chứng nhận xuất xứ.\n";
    $content .= "- Chính sách bảo hành tiêu chuẩn từ 12 - 36 tháng cho toàn bộ thiết bị.\n";
    $content .= "- Đội ngũ kỹ sư âm thanh trực tiếp khảo sát thực địa và demo âm học tận nơi.\n";
    return $content;
}

