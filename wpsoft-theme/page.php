<?php
/**
 * The template for displaying pages
 *
 * @package WPSoft
 */

get_header();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'wpsoft-card wpsoft-category-card' ); ?>>
<header class="entry-header">
<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
</header>

<div class="entry-content">
<?php
while ( have_posts() ) :
the_post();
the_content();
endwhile;
?>
</div>
</article>
<?php
get_footer();
