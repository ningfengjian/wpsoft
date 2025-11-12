<?php
/**
 * The template for displaying 404 pages
 *
 * @package WPSoft
 */

get_header();
?>
<section class="wpsoft-card wpsoft-category-card">
<header class="page-header">
<h1 class="page-title"><?php esc_html_e( 'Oops! That page can’t be found.', 'wpsoft' ); ?></h1>
</header>
<div class="page-content">
<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'wpsoft' ); ?></p>
<?php get_search_form(); ?>
</div>
</section>
<?php
get_footer();
