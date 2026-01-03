<?php
/**
 * Template Link: Category Archive
 * Redirects to the main News page (Tin tức) with a pre-selected filter
 * to create a unified "single-page-application" feel.
 */

$category = get_queried_object();
$slug = $category->slug;

// Redirect to /tin-tuc/?category=slug
// Use 302 for now (temporary) or 301 if this is a permanent structural change.
// Given the user wants "speed", a client-side feel is best via the main page.
wp_redirect(home_url('/tin-tuc/?category=' . $slug));
exit;
?>

// For now just show all posts since we don't have filter data
// You can implement actual filtering logic here
postCards.forEach(card => {
card.style.display = 'block';
});
});
});
});
</script>

<?php get_footer(); ?>