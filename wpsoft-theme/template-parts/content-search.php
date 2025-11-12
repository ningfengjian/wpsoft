<?php
/**
 * Template part for displaying posts in search results (non-software)
 *
 * @package WPSoft
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'wpsoft-software-item' ); ?>>
<header class="entry-header">
<h3 class="wpsoft-software-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
</header>

<div class="entry-summary">
<?php the_excerpt(); ?>
</div>

<footer class="entry-footer">
<a class="wpsoft-button" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'wpsoft' ); ?></a>
</footer>
</article>
