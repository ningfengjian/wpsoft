<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package WPSoft
 */
?>
<section class="no-results not-found">
<header class="page-header">
<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'wpsoft' ); ?></h1>
</header>

<div class="page-content">
<p><?php esc_html_e( 'It seems we can’t find what you’re looking for. Try searching or browsing categories.', 'wpsoft' ); ?></p>
<?php get_search_form(); ?>
</div>
</section>
