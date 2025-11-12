<?php
/**
 * Template for software archive
 *
 * @package WPSoft
 */

get_header();
?>
<section class="wpsoft-card wpsoft-category-card">
<header class="page-header">
<h1 class="page-title"><?php post_type_archive_title(); ?></h1>
</header>

<div class="wpsoft-software-grid">
<?php if ( have_posts() ) : ?>
<?php
while ( have_posts() ) :
the_post();
get_template_part( 'template-parts/content', 'software-card' );
endwhile;
?>
<?php else : ?>
<?php get_template_part( 'template-parts/content', 'none' ); ?>
<?php endif; ?>
</div>

<?php the_posts_pagination(); ?>
</section>
<?php
get_footer();
