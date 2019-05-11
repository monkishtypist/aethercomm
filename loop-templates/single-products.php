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

    <section id="<?php echo $post->post_name; ?>_header" class="section_header <?php echo $template_slug; ?>_header section-header-overlay section-header-overlay_<?php echo $overlay_color; ?>">

        <div class="<?php echo esc_attr( $container ); ?>">

            <div class="row">

                <div class="col">

                    <header>
                        <?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
                        <?php // data sheet ?>
                        <?php the_content(); ?>
                    </header>

                </div>

            </div>

            <span class="crosshairs-gray crosshairs-top-left"></span>
            <span class="crosshairs-gray crosshairs-top-right"></span>

        </div>

    </section>

    <section id="<?php echo $post->post_name; ?>_specifications" class="single-products-specifications section-white">

        <div class="<?php echo esc_attr( $container ); ?>">

            <div class="row">
                <div class="col">
                    <?php echo apply_filters( 'the_content', get_acf_field( 'product_details_long-description', true ) ); ?>
                </div>

                <?php get_template_part( 'global-templates/products', 'specifications' ); ?>

            </div>

            <span class="crosshairs-gray crosshairs-bottom-left"></span>
            <span class="crosshairs-gray crosshairs-bottom-right"></span>

        </div>

    </section>

    <?php get_template_part( 'sidebar-templates/sidebar', 'contact' ); ?>

</article>
