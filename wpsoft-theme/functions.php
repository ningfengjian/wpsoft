<?php
/**
 * WPSoft Library Theme functions and definitions
 *
 * @package WPSoft
 */

if ( ! defined( 'WPSOFT_VERSION' ) ) {
define( 'WPSOFT_VERSION', '1.0.0' );
}

if ( ! function_exists( 'wpsoft_setup' ) ) {
/**
 * Set up theme defaults and registers support for various WordPress features.
 */
function wpsoft_setup() {
load_theme_textdomain( 'wpsoft', get_template_directory() . '/languages' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 280, 180, true );

register_nav_menus(
array(
'primary' => __( 'Primary Menu', 'wpsoft' ),
'footer'  => __( 'Footer Menu', 'wpsoft' ),
)
);

add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
add_theme_support( 'custom-logo', array( 'height' => 56, 'width' => 200, 'flex-width' => true, 'flex-height' => true ) );
}
}
add_action( 'after_setup_theme', 'wpsoft_setup' );

/**
 * Enqueue styles and scripts.
 */
function wpsoft_enqueue_assets() {
$theme_version = wp_get_theme()->get( 'Version' );

wp_enqueue_style( 'wpsoft-style', get_stylesheet_uri(), array(), $theme_version );
wp_enqueue_style( 'wpsoft-main', get_template_directory_uri() . '/assets/css/main.css', array( 'wpsoft-style' ), $theme_version );

wp_enqueue_script( 'wpsoft-navigation', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), $theme_version, true );
wp_localize_script(
'wpsoft-navigation',
'wpsoftData',
array(
'expand'       => __( 'Expand child menu', 'wpsoft' ),
'collapse'     => __( 'Collapse child menu', 'wpsoft' ),
'ajaxEndpoint' => esc_url( rest_url( 'wpsoft/v1/search' ) ),
)
);
}
add_action( 'wp_enqueue_scripts', 'wpsoft_enqueue_assets' );

/**
 * Register custom post types and taxonomies.
 */
function wpsoft_register_content_types() {
$labels = array(
'name'               => _x( 'Software', 'post type general name', 'wpsoft' ),
'singular_name'      => _x( 'Software', 'post type singular name', 'wpsoft' ),
'menu_name'          => _x( 'Software Library', 'admin menu', 'wpsoft' ),
'name_admin_bar'     => _x( 'Software', 'add new on admin bar', 'wpsoft' ),
'add_new'            => _x( 'Add New', 'software', 'wpsoft' ),
'add_new_item'       => __( 'Add New Software', 'wpsoft' ),
'new_item'           => __( 'New Software', 'wpsoft' ),
'edit_item'          => __( 'Edit Software', 'wpsoft' ),
'view_item'          => __( 'View Software', 'wpsoft' ),
'all_items'          => __( 'All Software', 'wpsoft' ),
'search_items'       => __( 'Search Software', 'wpsoft' ),
'parent_item_colon'  => __( 'Parent Software:', 'wpsoft' ),
'not_found'          => __( 'No software found.', 'wpsoft' ),
'not_found_in_trash' => __( 'No software found in Trash.', 'wpsoft' ),
);

$args = array(
'labels'             => $labels,
'public'             => true,
'has_archive'        => true,
'rewrite'            => array( 'slug' => 'software' ),
'show_in_rest'       => true,
'menu_icon'          => 'dashicons-desktop',
'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
);

register_post_type( 'software', $args );

register_taxonomy(
'platform',
'software',
array(
'label'        => __( 'Platform', 'wpsoft' ),
'labels'       => array(
'name'          => __( 'Platforms', 'wpsoft' ),
'singular_name' => __( 'Platform', 'wpsoft' ),
),
'public'       => true,
'hierarchical' => false,
'show_in_rest' => true,
'rewrite'      => array( 'slug' => 'platform' ),
)
);

register_taxonomy(
'software_category',
'software',
array(
'label'        => __( 'Software Category', 'wpsoft' ),
'labels'       => array(
'name'          => __( 'Software Categories', 'wpsoft' ),
'singular_name' => __( 'Software Category', 'wpsoft' ),
),
'public'       => true,
'hierarchical' => true,
'show_in_rest' => true,
'rewrite'      => array( 'slug' => 'software-category' ),
)
);
}
add_action( 'init', 'wpsoft_register_content_types' );

/**
 * Register software meta boxes.
 */
function wpsoft_register_meta_boxes() {
add_meta_box( 'wpsoft_software_meta', __( 'Software Details', 'wpsoft' ), 'wpsoft_render_meta_box', 'software', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'wpsoft_register_meta_boxes' );

/**
 * Render software meta box fields.
 *
 * @param WP_Post $post Current post object.
 */
function wpsoft_render_meta_box( $post ) {
wp_nonce_field( 'wpsoft_save_meta', 'wpsoft_meta_nonce' );

$version        = get_post_meta( $post->ID, '_wpsoft_version', true );
$tutorial_url   = get_post_meta( $post->ID, '_wpsoft_tutorial_url', true );
$download_links = get_post_meta( $post->ID, '_wpsoft_download_links', true );
$download_links = is_array( $download_links ) ? $download_links : array();
$keywords       = get_post_meta( $post->ID, '_wpsoft_keywords', true );
?>
<div class="wpsoft-field">
<label for="wpsoft_version"><strong><?php esc_html_e( 'Current Version', 'wpsoft' ); ?></strong></label>
<input type="text" id="wpsoft_version" name="wpsoft_version" value="<?php echo esc_attr( $version ); ?>" class="widefat" />
</div>

<div class="wpsoft-field">
<label for="wpsoft_tutorial_url"><strong><?php esc_html_e( 'Tutorial URL', 'wpsoft' ); ?></strong></label>
<input type="url" id="wpsoft_tutorial_url" name="wpsoft_tutorial_url" value="<?php echo esc_attr( $tutorial_url ); ?>" class="widefat" placeholder="https://" />
</div>

<div class="wpsoft-field">
<label><strong><?php esc_html_e( 'Download Links', 'wpsoft' ); ?></strong></label>
<p class="description"><?php esc_html_e( 'Add one download link per row. Use the format "Label|https://example.com".', 'wpsoft' ); ?></p>
<textarea name="wpsoft_download_links" rows="4" class="widefat"><?php echo esc_textarea( wpsoft_implode_links( $download_links ) ); ?></textarea>
</div>

<div class="wpsoft-field">
<label for="wpsoft_keywords"><strong><?php esc_html_e( 'Search Keywords', 'wpsoft' ); ?></strong></label>
<input type="text" id="wpsoft_keywords" name="wpsoft_keywords" value="<?php echo esc_attr( $keywords ); ?>" class="widefat" placeholder="photoshop, premiere, adobe" />
<p class="description"><?php esc_html_e( 'Comma separated keywords to improve search results.', 'wpsoft' ); ?></p>
</div>
<?php
}

/**
 * Save meta box data.
 *
 * @param int $post_id Post ID.
 */
function wpsoft_save_meta( $post_id ) {
if ( ! isset( $_POST['wpsoft_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wpsoft_meta_nonce'] ) ), 'wpsoft_save_meta' ) ) {
return;
}

if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
return;
}

if ( isset( $_POST['post_type'] ) && 'software' === $_POST['post_type'] ) {
if ( ! current_user_can( 'edit_post', $post_id ) ) {
return;
}
}

$version      = isset( $_POST['wpsoft_version'] ) ? sanitize_text_field( wp_unslash( $_POST['wpsoft_version'] ) ) : '';
$tutorial_url = isset( $_POST['wpsoft_tutorial_url'] ) ? esc_url_raw( wp_unslash( $_POST['wpsoft_tutorial_url'] ) ) : '';
$keywords     = isset( $_POST['wpsoft_keywords'] ) ? sanitize_text_field( wp_unslash( $_POST['wpsoft_keywords'] ) ) : '';

update_post_meta( $post_id, '_wpsoft_version', $version );
update_post_meta( $post_id, '_wpsoft_tutorial_url', $tutorial_url );
update_post_meta( $post_id, '_wpsoft_keywords', $keywords );

if ( isset( $_POST['wpsoft_download_links'] ) ) {
$raw_links = explode( "\n", wp_unslash( $_POST['wpsoft_download_links'] ) );
$links     = array();

foreach ( $raw_links as $raw_link ) {
$raw_link = trim( $raw_link );
if ( empty( $raw_link ) ) {
continue;
}

$parts = array_map( 'trim', explode( '|', $raw_link ) );

if ( count( $parts ) >= 2 ) {
$label = sanitize_text_field( $parts[0] );
$url   = esc_url_raw( $parts[1] );
if ( ! empty( $label ) && ! empty( $url ) ) {
$links[] = array(
'label' => $label,
'url'   => $url,
);
}
}
}

update_post_meta( $post_id, '_wpsoft_download_links', $links );
}
}
add_action( 'save_post', 'wpsoft_save_meta' );

/**
 * Helper to join download links into textarea string.
 *
 * @param array $links Download links array.
 * @return string
 */
function wpsoft_implode_links( $links ) {
if ( empty( $links ) ) {
return '';
}

return implode(
"\n",
array_map(
function( $link ) {
return sprintf( '%s|%s', $link['label'], $link['url'] );
},
$links
)
);
}

/**
 * Retrieve structured download links for display.
 *
 * @param int $post_id Post ID.
 * @return array
 */
function wpsoft_get_download_links( $post_id = 0 ) {
$post_id = $post_id ? $post_id : get_the_ID();
$links   = get_post_meta( $post_id, '_wpsoft_download_links', true );

return is_array( $links ) ? $links : array();
}

/**
 * Modify search to include software meta fields.
 *
 * @param WP_Query $query The WP_Query instance (passed by reference).
 */
function wpsoft_adjust_search_query( $query ) {
if ( is_admin() || ! $query->is_main_query() ) {
return;
}

if ( $query->is_search() ) {
$query->set( 'post_type', array( 'post', 'software', 'page' ) );
$search_term = $query->get( 's' );

if ( $search_term ) {
$meta_query = array(
'relation' => 'OR',
array(
'key'     => '_wpsoft_version',
'value'   => $search_term,
'compare' => 'LIKE',
),
array(
'key'     => '_wpsoft_keywords',
'value'   => $search_term,
'compare' => 'LIKE',
),
);

$query->set( 'meta_query', $meta_query );
}
}
}
add_action( 'pre_get_posts', 'wpsoft_adjust_search_query' );

/**
 * Register widget areas.
 */
function wpsoft_widgets_init() {
register_sidebar(
array(
'name'          => __( 'Sidebar', 'wpsoft' ),
'id'            => 'sidebar-1',
'description'   => __( 'Add widgets here.', 'wpsoft' ),
'before_widget' => '<section id="%1$s" class="widget %2$s">',
'after_widget'  => '</section>',
'before_title'  => '<h2 class="widget-title">',
'after_title'   => '</h2>',
)
);
}
add_action( 'widgets_init', 'wpsoft_widgets_init' );

/**
 * Register REST route for instant search suggestions.
 */
function wpsoft_register_rest_routes() {
register_rest_route(
'wpsoft/v1',
'/search',
array(
'permission_callback' => '__return_true',
'args'                => array(
'q' => array(
'required'          => true,
'sanitize_callback' => 'sanitize_text_field',
),
),
'callback'            => function( WP_REST_Request $request ) {
$term   = $request->get_param( 'q' );
$posts  = get_posts(
array(
'post_type'      => array( 'software', 'post', 'page' ),
's'              => $term,
'posts_per_page' => 6,
)
);
$results = array();
foreach ( $posts as $post ) {
$results[] = array(
'id'    => $post->ID,
'title' => get_the_title( $post ),
'link'  => get_permalink( $post ),
'type'  => get_post_type( $post ),
);
}

return rest_ensure_response( $results );
},
)
);
}
add_action( 'rest_api_init', 'wpsoft_register_rest_routes' );

/**
 * Simple breadcrumb generator.
 */
function wpsoft_breadcrumbs() {
if ( is_front_page() ) {
return;
}

echo '<nav class="wpsoft-breadcrumb" aria-label="Breadcrumb">';
echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'wpsoft' ) . '</a>';

if ( is_singular( 'software' ) ) {
$terms = get_the_terms( get_the_ID(), 'software_category' );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
$primary = array_shift( $terms );
echo ' <span class="sep">/</span> <a href="' . esc_url( get_term_link( $primary ) ) . '">' . esc_html( $primary->name ) . '</a>';
}
}

if ( is_archive() ) {
echo ' <span class="sep">/</span> <span>' . esc_html( get_the_archive_title() ) . '</span>';
} elseif ( is_singular() ) {
echo ' <span class="sep">/</span> <span>' . esc_html( get_the_title() ) . '</span>';
} elseif ( is_search() ) {
echo ' <span class="sep">/</span> <span>' . sprintf( esc_html__( 'Search: %s', 'wpsoft' ), esc_html( get_search_query() ) ) . '</span>';
}

echo '</nav>';
}

/**
 * Filter document title parts for better SEO defaults.
 *
 * @param array $title Existing title parts.
 * @return array
 */
function wpsoft_filter_document_title( $title ) {
if ( is_search() && empty( $title['title'] ) ) {
$title['title'] = sprintf( __( 'Search results for "%s"', 'wpsoft' ), get_search_query() );
}

return $title;
}
add_filter( 'document_title_parts', 'wpsoft_filter_document_title' );

/**
 * Add sitemap and updates links to footer menu if not assigned.
 */
function wpsoft_footer_links() {
$links = array(
array(
'label' => __( 'Website Map', 'wpsoft' ),
'url'   => home_url( '/site-map/' ),
),
array(
'label' => __( 'XML Sitemap', 'wpsoft' ),
'url'   => home_url( '/sitemap.xml' ),
),
array(
'label' => __( 'Latest Updates', 'wpsoft' ),
'url'   => home_url( '/latest-updates/' ),
),
);

echo '<div class="wpsoft-footer-links">';
foreach ( $links as $link ) {
echo '<a href="' . esc_url( $link['url'] ) . '">' . esc_html( $link['label'] ) . '</a>';
}
echo '</div>';
}
