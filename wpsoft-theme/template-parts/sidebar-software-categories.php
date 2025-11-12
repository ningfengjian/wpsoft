<?php
/**
 * Sidebar navigation for software categories.
 *
 * @package WPSoft
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$defaults = array(
    'active_term_id' => 0,
    'title'          => __( '软件分类', 'wpsoft' ),
);

$args = isset( $args ) && is_array( $args ) ? $args : array();
$context = wp_parse_args( $args, $defaults );

$active_term_id = (int) $context['active_term_id'];
$active_ancestors = array();

if ( $active_term_id ) {
    $active_ancestors = get_ancestors( $active_term_id, 'software_category' );
}

$top_level_terms = get_terms(
    array(
        'taxonomy'   => 'software_category',
        'hide_empty' => false,
        'parent'     => 0,
        'orderby'    => 'name',
        'order'      => 'ASC',
    )
);

if ( is_wp_error( $top_level_terms ) || empty( $top_level_terms ) ) {
    return;
}
?>
<aside class="wpsoft-category-sidebar" aria-label="<?php echo esc_attr( $context['title'] ); ?>">
    <div class="sidebar-inner">
        <h2 class="sidebar-title"><?php echo esc_html( $context['title'] ); ?></h2>
        <nav class="category-nav">
            <?php foreach ( $top_level_terms as $parent_term ) :
                $is_parent_active = ( $parent_term->term_id === $active_term_id ) || in_array( $parent_term->term_id, $active_ancestors, true );
                $child_terms       = get_terms(
                    array(
                        'taxonomy'   => 'software_category',
                        'hide_empty' => false,
                        'parent'     => $parent_term->term_id,
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                    )
                );
                ?>
                <div class="category-group">
                    <a class="category-parent<?php echo $is_parent_active ? ' is-active' : ''; ?>" href="<?php echo esc_url( get_term_link( $parent_term ) ); ?>">
                        <?php echo esc_html( $parent_term->name ); ?>
                    </a>
                    <?php if ( ! empty( $child_terms ) && ! is_wp_error( $child_terms ) ) : ?>
                        <div class="category-children">
                            <?php foreach ( $child_terms as $child_term ) :
                                $is_child_active = ( $child_term->term_id === $active_term_id );
                                ?>
                                <a class="category-child<?php echo $is_child_active ? ' is-active' : ''; ?>" href="<?php echo esc_url( get_term_link( $child_term ) ); ?>">
                                    <?php echo esc_html( $child_term->name ); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </nav>
    </div>
</aside>
