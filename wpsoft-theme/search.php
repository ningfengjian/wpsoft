<?php
/**
 * Search results template
 *
 * @package WPSoft
 */

get_header();
?>
<section class="wpsoft-card wpsoft-category-card search-results">
<header class="page-header">
<h1 class="page-title"><?php printf( esc_html__( 'Search results for "%s"', 'wpsoft' ), esc_html( get_search_query() ) ); ?></h1>
</header>

<?php if ( have_posts() ) : ?>
<div class="wpsoft-software-grid">
<?php
while ( have_posts() ) :
the_post();
$template = 'software-card';
if ( 'software' !== get_post_type() ) {
$template = 'search';
}
get_template_part( 'template-parts/content', $template );
endwhile;
?>
</div>
<?php the_posts_pagination(); ?>
<?php else : ?>
<div class="search-no-results">
<h1><?php esc_html_e( 'No results found', 'wpsoft' ); ?></h1>
<p><?php esc_html_e( 'Try different keywords or browse by platform.', 'wpsoft' ); ?></p>
</div>
<?php endif; ?>
</section>
<?php
get_footer();
