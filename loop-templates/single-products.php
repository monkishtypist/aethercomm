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

    <section id="single_products-header" class="section_header">

        <div class="<?php echo esc_attr( $container ); ?>">

            <div class="row">

                <?php if ( has_post_thumbnail() ) { ?>

                    <div class="col">
                        <?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid' ) ); ?>
                    </div>

                <?php } ?>

                <div class="col">

                    <header>
                        <?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
                        <?php echo sprintf( '<a href="%1$s" class="btn-link pdf-link" target="_blank">%2$s</a>',
                            wp_get_attachment_url( get_acf_field( 'product_details_data_sheet', true ) ),
                            __( 'Data Sheet', 'aethercomm' )
                        ); ?>
                        <?php the_content(); ?>
                    </header>

                </div>

            </div>

            <span class="crosshairs-gray crosshairs-top-left"></span>
            <span class="crosshairs-gray crosshairs-top-right"></span>

        </div>

    </section>

    <section id="single-products_specifications" class="single-products_specifications section-white">

        <div class="<?php echo esc_attr( $container ); ?>">

            <div class="row">
                <div class="col">
                    <h2 class="section-title"><?php _e( 'Specs', 'aethercomm' ); ?></h2>
                    <h3 class="section-lede"><?php _e( 'Product Specifications', 'aethercomm' ); ?></h3>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php echo apply_filters( 'the_content', get_acf_field( 'product_details_long_description', true ) ); ?>
                </div>
                <div class="col">

                    <?php get_template_part( 'global-templates/products', 'specifications-table' ); ?>

                </div>
            </div>

            <span class="crosshairs-gray crosshairs-bottom-left"></span>
            <span class="crosshairs-gray crosshairs-bottom-right"></span>

        </div>

    </section>

    <?php get_template_part( 'sidebar-templates/sidebar', 'contact' ); ?>

</article>
