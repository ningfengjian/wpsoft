<?php
/**
 * The template for displaying the footer
 *
 * @package WPSoft
 */
?>
</div><!-- .wpsoft-container -->
</div><!-- #content -->

<footer class="site-footer">
<div class="wpsoft-container">
<div class="footer-branding">
<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'wpsoft' ); ?></p>
</div>
<?php
if ( has_nav_menu( 'footer' ) ) {
wp_nav_menu(
array(
'theme_location' => 'footer',
'menu_class'     => 'footer-menu',
'container'      => 'nav',
)
);
} else {
wpsoft_footer_links();
}
?>
</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
