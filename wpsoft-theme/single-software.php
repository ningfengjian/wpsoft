<?php
/**
 * The template for displaying single software
 *
 * @package WPSoft
 */

global $post;
get_header();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-software' ); ?>>
<div class="wpsoft-hero">
<h1><?php the_title(); ?></h1>
<?php
$version      = get_post_meta( get_the_ID(), '_wpsoft_version', true );
$tutorial_url = get_post_meta( get_the_ID(), '_wpsoft_tutorial_url', true );
$platforms    = get_the_term_list( get_the_ID(), 'platform', '', ', ' );
$categories   = get_the_term_list( get_the_ID(), 'software_category', '', ', ' );
?>
<ul class="wpsoft-meta-list">
<?php if ( $version ) : ?>
<li><?php printf( esc_html__( 'Version: %s', 'wpsoft' ), esc_html( $version ) ); ?></li>
<?php endif; ?>
<?php if ( $platforms ) : ?>
<li><?php echo wp_kses_post( $platforms ); ?></li>
<?php endif; ?>
<?php if ( $categories ) : ?>
<li><?php echo wp_kses_post( $categories ); ?></li>
<?php endif; ?>
</ul>

<div class="download-buttons">
<?php
$download_links = wpsoft_get_download_links();
if ( ! empty( $download_links ) ) :
foreach ( $download_links as $link ) :
printf(
'<a class="download-button" href="%1$s" target="_blank" rel="nofollow noopener">%2$s<span>⇩</span></a>',
esc_url( $link['url'] ),
esc_html( $link['label'] )
);
endforeach;
else :
?><p><?php esc_html_e( 'Download links will be added soon.', 'wpsoft' ); ?></p><?php
endif;
?>
</div>

<?php if ( $tutorial_url ) : ?>
<a class="tutorial-link" href="<?php echo esc_url( $tutorial_url ); ?>" target="_blank" rel="noopener">
<?php esc_html_e( 'View Installation Tutorial', 'wpsoft' ); ?>
</a>
<?php endif; ?>
</div>

<div class="wpsoft-card wpsoft-category-card" style="margin-top: 2rem;">
<div class="entry-content">
<?php
the_content();
wp_link_pages(
array(
'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wpsoft' ),
'after'  => '</div>',
)
);
?>
</div>
</div>

<?php
$related_versions = new WP_Query(
array(
'post_type'      => 'software',
'posts_per_page' => 6,
'post__not_in'   => array( get_the_ID() ),
'tax_query'      => array(
array(
'taxonomy' => 'software_category',
'field'    => 'term_id',
'terms'    => wp_get_post_terms( get_the_ID(), 'software_category', array( 'fields' => 'ids' ) ),
),
),
)
);
if ( $related_versions->have_posts() ) :
?>
<section class="wpsoft-card wpsoft-category-card" style="margin-top: 2rem;">
<h2><?php esc_html_e( 'Related Versions', 'wpsoft' ); ?></h2>
<div class="wpsoft-software-grid">
<?php
while ( $related_versions->have_posts() ) :
$related_versions->the_post();
get_template_part( 'template-parts/content', 'software-card' );
endwhile;
?>
</div>
</section>
<?php
wp_reset_postdata();
endif;
?>
</article>
<?php
get_footer();
