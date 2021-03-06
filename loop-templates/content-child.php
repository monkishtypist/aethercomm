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

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <?php get_template_part( 'global-templates/header' ); ?>

    <section id="<?php echo $post->post_name; ?>_content" class="child-page-content section-dark section-banner">

        <div class="<?php echo esc_attr( $container ); ?>">

            <div class="row">
                <div class="col">
                    <?php if ( get_acf_field( 'child_page_settings_content_slider' ) && class_exists( 'RevSlider' ) ) : ?>
                        <div class="rev-slider-outer">
                            <?php putRevSlider( get_acf_field( 'child_page_settings_content_slider', true ) ); ?>
                        </div>
                    <?php endif; ?>
                    <?php the_content(); ?>
                </div>
            </div>

            <span class="crosshairs-gray crosshairs-bottom-left"></span>
            <span class="crosshairs-gray crosshairs-bottom-right"></span>

        </div>

    </section>

    <?php get_template_part( 'sidebar-templates/sidebar', 'contact' ); ?>

</article>
