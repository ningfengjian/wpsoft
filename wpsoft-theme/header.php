<?php
/**
 * The header for our theme
 *
 * @package WPSoft
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
<div class="wpsoft-container">
<div class="wpsoft-topbar">
<div class="site-branding">
<?php
if ( has_custom_logo() ) {
the_custom_logo();
}
?>
<div>
<?php if ( is_front_page() && is_home() ) : ?>
<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
<?php else : ?>
<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
<?php endif; ?>
<?php
$description = get_bloginfo( 'description', 'display' );
if ( $description || is_customize_preview() ) :
?>
<p class="site-description"><?php echo esc_html( $description ); ?></p>
<?php endif; ?>
</div>
</div>
<div class="platform-links">
<?php
$platform_terms = get_terms(
array(
'taxonomy'   => 'platform',
'hide_empty' => false,
)
);

if ( ! is_wp_error( $platform_terms ) && ! empty( $platform_terms ) ) :
foreach ( $platform_terms as $platform ) :
$slug = strtolower( $platform->slug );
printf(
'<a class="platform-link %1$s" href="%2$s">%3$s</a>',
esc_attr( $slug ),
esc_url( get_term_link( $platform ) ),
esc_html( $platform->name )
);
endforeach;
else :
?>
<a class="platform-link windows" href="#"><?php esc_html_e( 'Windows Software', 'wpsoft' ); ?></a>
<a class="platform-link mac" href="#"><?php esc_html_e( 'Mac Software', 'wpsoft' ); ?></a>
<a class="platform-link android" href="#"><?php esc_html_e( 'Android Software', 'wpsoft' ); ?></a>
<?php endif; ?>
</div>
</div>
<div class="wpsoft-search">
<?php get_search_form(); ?>
</div>
</div>
</header>

<div id="content" class="site-content">
<div class="wpsoft-container">
<?php wpsoft_breadcrumbs(); ?>
