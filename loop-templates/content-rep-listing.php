<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package aethercomm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

$container = get_theme_mod( 'understrap_container_type' );

$section_capabilities_background_image_url = '/wp-content/uploads/2019/04/rep-listing_capabilities-background.png'; // default
if ( get_acf_field( 'rep-listing_page_settings_capabilities_background' ) ) {
    $section_capabilities_background_img_id = get_acf_field( 'rep-listing_page_settings_capabilities_background' );
    if ( is_array( $section_capabilities_background_img_id ) && isset( $section_capabilities_background_img_id[0] ) ) {
        $section_capabilities_background_image_url = wp_get_attachment_url( $section_capabilities_background_img_id[0] );
    }
}
$section_capabilities_styles = sprintf( 'style="%1$s"',
    sprintf( 'background-image:url(%1$s);',
        $section_capabilities_background_image_url
    )
);

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <?php get_template_part( 'global-templates/header' ); ?>

    <section id="<?php echo $post->post_name; ?>_reps" class="section-dark">

        <div class="<?php echo esc_attr( $container ); ?>">

            <?php if ( get_acf_field( 'rep-listing_page_settings_reps_title' ) ) { ?>
                <?php echo sprintf( '<h2 class="section-title">%1$s</h2>',
                    get_acf_field( 'rep-listing_page_settings_reps_title', true )
                ); ?>
            <?php } ?>

            <form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="reps-filter" class="form-inline reps-filter-form">
                <div class="form-group">
                    <label for="rep-filter-input" class="sr-only"><?php _e( 'Search Representatives', 'aethercomm' ); ?></label>
                    <input type="text" class="form-control" id="rep-filter-input" value="" placeholder="<?php _e( 'Search Representatives', 'aethercomm' ); ?>">
                </div>
                <button type="submit" class="btn btn-primary"><?php _e( 'Search', 'aethercomm' ); ?></button>
            </form>

            <?php
            $args = array(
                'post_type' => 'representatives',
                'post_status' => 'publish',
                'posts_per_page' => 9
            );
            $query = new WP_Query( $args );
            ?>

            <?php if ( $query->have_posts() ) : ?>

                <?php ob_start(); ?>

                <div class="card-deck">

                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>

                        <?php get_template_part( 'loop-templates/content', 'card' ); ?>

                    <?php endwhile; ?>

                </div>

                <?php echo ob_get_clean(); ?>

            <?php endif; wp_reset_query(); ?>

        </div>

    </section>

    <?php get_template_part( 'sidebar-templates/sidebar', 'contact' ); ?>

</article>
