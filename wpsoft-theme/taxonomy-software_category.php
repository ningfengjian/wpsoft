<?php
/**
 * Template for software category taxonomy
 *
 * @package WPSoft
 */

get_header();
$term = get_queried_object();
?>
<section class="wpsoft-card wpsoft-category-card">
<header class="page-header">
<h1 class="page-title"><?php echo esc_html( $term->name ); ?></h1>
<?php if ( ! empty( $term->description ) ) : ?>
<p><?php echo esc_html( $term->description ); ?></p>
<?php endif; ?>
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
