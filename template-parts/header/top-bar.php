<?php
/**
 * Header Top Bar - Luxury Upgrade (Black & Gold Edition)
 */
?>
<!-- Wrapper: Full width background để không bị chặn 2 đầu -->
<div class="top-bar-wrapper w-full border-b border-white/[0.06] bg-white/[0.01] backdrop-blur-[2px] h-[40px] hidden md:block">
    <!-- Inner: Content container giới hạn chiều rộng -->
    <div class="flex justify-between items-center px-4 md:px-8 max-w-[1700px] mx-auto h-full text-[11px] uppercase tracking-[0.15em] text-gray-400">
        
        <!-- Left: Contact Info -->
        <div class="flex gap-8">
            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', tdclassic_get_company_phone())); ?>" class="group flex items-center gap-3 h-full transition-all duration-300 hover:text-white">
                <!-- Icon với hiệu ứng Glow Vàng kim -->
                <span class="flex items-center justify-center w-5 h-5 rounded-full bg-white/5 border border-white/10 group-hover:border-[#D4AF37]/50 group-hover:bg-[#D4AF37]/10 transition-all duration-300 group-hover:shadow-[0_0_10px_rgba(212,175,55,0.4)]">
                    <i class="fa-solid fa-phone text-[9px] group-hover:text-[#D4AF37] transition-colors"></i> 
                </span>
                <span class="relative">
                    <?php echo esc_html(tdclassic_get_company_phone()); ?>
                </span>
            </a>
            
            <a href="mailto:<?php echo esc_attr(tdclassic_get_company_email()); ?>" class="group flex items-center gap-3 h-full transition-all duration-300 hover:text-white">
                <span class="flex items-center justify-center w-5 h-5 rounded-full bg-white/5 border border-white/10 group-hover:border-[#D4AF37]/50 group-hover:bg-[#D4AF37]/10 transition-all duration-300 group-hover:shadow-[0_0_10px_rgba(212,175,55,0.4)]">
                    <i class="fa-solid fa-envelope text-[9px] group-hover:text-[#D4AF37] transition-colors"></i>
                </span>
                <span><?php echo esc_html(tdclassic_get_company_email()); ?></span>
            </a>
        </div>

        <!-- Right: Quick Links -->
        <div class="flex items-center gap-6">
            <!-- Divider: Màu vàng kim (Gold) gradient -->
            <div class="w-px h-3 bg-gradient-to-b from-transparent via-[#D4AF37] to-transparent opacity-70"></div>
            
            <?php
            $profile_page = get_page_by_path('ho-so-nang-luc');
            $profile_url = $profile_page ? get_permalink($profile_page->ID) : home_url('/ho-so-nang-luc');
            ?>
            
            <a href="<?php echo esc_url($profile_url); ?>" class="group relative py-2 hover:text-white transition-colors overflow-hidden">
                <span class="relative z-10">Hồ sơ năng lực</span>
                <!-- Underline: Màu vàng kim -->
                <span class="absolute bottom-0 left-0 w-full h-[1px] bg-[#D4AF37] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left shadow-[0_0_8px_rgba(212,175,55,0.6)]"></span>
            </a>
            
            <a href="<?php echo esc_url(home_url('/dai-ly')); ?>" class="group relative py-2 hover:text-white transition-colors overflow-hidden">
                <span class="relative z-10">Đại lý</span>
                <!-- Underline: Màu vàng kim -->
                <span class="absolute bottom-0 left-0 w-full h-[1px] bg-[#D4AF37] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left shadow-[0_0_8px_rgba(212,175,55,0.6)]"></span>
            </a>
        </div>
    </div>
</div>
