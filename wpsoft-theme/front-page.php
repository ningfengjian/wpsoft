<?php
/**
 * Template for displaying the front page
 *
 * @package WPSoft
 */

global $wp_query;
get_header();
?>
<div class="wpsoft-layout">
    <?php get_template_part( 'template-parts/sidebar', 'software-categories' ); ?>
    <main class="wpsoft-main">
        <div class="wpsoft-categories">
        <?php
        $categories = get_terms(
            array(
                'taxonomy'   => 'software_category',
                'hide_empty' => false,
                'parent'     => 0,
            )
        );

        if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) :
            foreach ( $categories as $category ) :
                $child_terms = get_terms(
                    array(
                        'taxonomy'   => 'software_category',
                        'parent'     => $category->term_id,
                        'hide_empty' => false,
                    )
                );
                ?>
                <section class="wpsoft-card wpsoft-category-card" id="category-<?php echo esc_attr( $category->term_id ); ?>">
                    <div class="wpsoft-category-heading">
                        <h2><?php echo esc_html( $category->name ); ?></h2>
                        <?php if ( ! empty( $child_terms ) && ! is_wp_error( $child_terms ) ) : ?>
                            <div class="subcategories">
                                <?php foreach ( $child_terms as $child ) : ?>
                                    <a class="wpsoft-badge" href="<?php echo esc_url( get_term_link( $child ) ); ?>"><?php echo esc_html( $child->name ); ?></a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php
                    $software_query = new WP_Query(
                        array(
                            'post_type'      => 'software',
                            'posts_per_page' => 8,
                            'tax_query'      => array(
                                array(
                                    'taxonomy' => 'software_category',
                                    'field'    => 'term_id',
                                    'terms'    => $category->term_id,
                                ),
                            ),
                        )
                    );

                    if ( $software_query->have_posts() ) :
                        ?>
                        <div class="wpsoft-software-grid">
                            <?php
                            while ( $software_query->have_posts() ) :
                                $software_query->the_post();
                                get_template_part( 'template-parts/content', 'software-card' );
                            endwhile;
                            ?>
                        </div>
                    <?php else : ?>
                        <p><?php esc_html_e( 'No software found in this category yet.', 'wpsoft' ); ?></p>
                    <?php endif; ?>

                    <?php wp_reset_postdata(); ?>
                </section>
            <?php endforeach; ?>
        <?php else : ?>
            <p><?php esc_html_e( 'Add software categories to populate the homepage.', 'wpsoft' ); ?></p>
        <?php endif; ?>
        </div>
    </main>
</div>
<?php
get_footer();
