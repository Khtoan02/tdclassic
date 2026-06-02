<?php
/**
 * Header Top Bar - Premium Black & Gold Edition
 */
?>
<div class="top-bar-wrapper w-full hidden lg:block">
    <div class="flex justify-between items-center px-12 max-w-[1700px] mx-auto h-full">

        <!-- Left: Quick Contacts -->
        <div class="flex gap-8 items-center h-full">
            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', tdclassic_get_company_phone())); ?>"
                class="top-bar-link flex items-center gap-2.5 transition-all">
                <i class="fa-solid fa-phone text-[10px] text-gold"></i>
                <span><?php echo esc_html(tdclassic_get_company_phone()); ?></span>
            </a>

            <div class="h-3 w-px bg-white/10"></div>

            <a href="mailto:<?php echo esc_attr(tdclassic_get_company_email()); ?>"
                class="top-bar-link flex items-center gap-2.5 transition-all">
                <i class="fa-solid fa-envelope text-[10px] text-gold"></i>
                <span><?php echo esc_html(tdclassic_get_company_email()); ?></span>
            </a>
        </div>

        <!-- Right: Brand Message / Address (Luxury feel) -->
        <div class="text-[10px] uppercase tracking-[0.2em] text-gray-500 font-sans flex items-center gap-2">
            <span>TD Classic</span>
            <span class="w-1.5 h-1.5 rounded-full bg-gold opacity-50"></span>
            <span>Âm Thanh Đích Thực, Cảm Xúc Vẹn Nguyên</span>
        </div>

    </div>
</div>