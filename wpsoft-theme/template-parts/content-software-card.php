<?php
/**
 * Template part for displaying software cards
 *
 * @package WPSoft
 */

$version        = get_post_meta( get_the_ID(), '_wpsoft_version', true );
$download_links = wpsoft_get_download_links();
$platforms      = get_the_terms( get_the_ID(), 'platform' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'wpsoft-software-item' ); ?>>
<header class="entry-header">
<h3 class="wpsoft-software-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
<?php if ( $version ) : ?>
<span class="wpsoft-badge"><?php printf( esc_html__( 'Version %s', 'wpsoft' ), esc_html( $version ) ); ?></span>
<?php endif; ?>
</header>

<div class="wpsoft-version-list">
<a href="<?php the_permalink(); ?>" class="version-link">
<?php esc_html_e( 'Download & Details', 'wpsoft' ); ?>
<?php if ( $version ) : ?>
<span><?php echo esc_html( $version ); ?></span>
<?php endif; ?>
</a>
<?php if ( ! empty( $download_links ) ) : ?>
<?php foreach ( $download_links as $link ) : ?>
<a href="<?php echo esc_url( $link['url'] ); ?>" class="version-link" target="_blank" rel="nofollow noopener">
<?php echo esc_html( $link['label'] ); ?>
</a>
<?php endforeach; ?>
<?php endif; ?>
</div>

<footer class="entry-footer">
<?php if ( ! empty( $platforms ) && ! is_wp_error( $platforms ) ) : ?>
<div class="wpsoft-meta-list">
<?php foreach ( $platforms as $platform ) : ?>
<span><?php echo esc_html( $platform->name ); ?></span>
<?php endforeach; ?>
</div>
<?php endif; ?>
</footer>
</article>
