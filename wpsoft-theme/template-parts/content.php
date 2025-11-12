<?php
/**
 * Template part for displaying standard posts
 *
 * @package WPSoft
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'wpsoft-software-item' ); ?>>
<header class="entry-header">
<?php the_title( '<h2 class="wpsoft-software-title">', '</h2>' ); ?>
</header>

<div class="entry-summary">
<?php the_excerpt(); ?>
</div>

<footer class="entry-footer">
<a class="wpsoft-button" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Continue Reading', 'wpsoft' ); ?></a>
</footer>
</article>
