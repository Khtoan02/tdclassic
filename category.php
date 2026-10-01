<?php
/**
 * Template Link: Category Archive
 * Redirects to the main News page (Tin tức) with a pre-selected filter
 * to create a unified single-page experience.
 */

$category = get_queried_object();
$slug = ($category && isset($category->slug)) ? $category->slug : '';

if (!empty($slug)) {
    wp_redirect(home_url('/tin-tuc/?category=' . rawurlencode($slug)));
} else {
    wp_redirect(home_url('/tin-tuc/'));
}
exit;