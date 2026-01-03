<?php
/**
 * Template Name: Blog
 * Description: Trang Blog hiển thị danh sách bài viết - redirect/alias cho page-tin-tuc.php
 * 
 * Trang này sử dụng cùng logic và giao diện với trang Tin tức
 * để đảm bảo tính nhất quán về nội dung
 */

// Include template tin-tuc để sử dụng lại code
// Hoặc redirect đến trang tin-tuc
include(get_template_directory() . '/page-tin-tuc.php');
