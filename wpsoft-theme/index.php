<?php
/**
 * The main template file
 *
 * @package WPSoft
 */

get_header();
?>
<div class="wpsoft-card wpsoft-category-card">
<?php if ( have_posts() ) : ?>
<header class="page-header">
<h1 class="page-title"><?php single_post_title(); ?></h1>
</header>
<div class="wpsoft-software-grid">
<?php
while ( have_posts() ) :
the_post();
get_template_part( 'template-parts/content', get_post_type() === 'software' ? 'software-card' : get_post_format() );
endwhile;
?>
</div>
<?php the_posts_pagination(); ?>
<?php else : ?>
<?php get_template_part( 'template-parts/content', 'none' ); ?>
<?php endif; ?>
</div>
<?php
get_footer();
