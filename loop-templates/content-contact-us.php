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

    <section id="<?php echo $post->post_name; ?>_header" class="section_header section-black">

        <div class="<?php echo esc_attr( $container ); ?>">

            <header>
                <?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
                <?php if ( get_acf_field( 'contact_us_page_settings_header_lede' ) ) { ?>
                    <div class="page-lede"><?php echo apply_filters( 'the_content', get_acf_field( 'contact_us_page_settings_header_lede', true ) ); ?></div>
                <?php } ?>

            </header>

            <div class="row">
                <?php if ( get_acf_field( 'contact_us_page_settings_header_copy' ) ) { ?>
                    <div class="col-12 col-lg-6">
                        <?php echo apply_filters( 'the_content', get_acf_field( 'contact_us_page_settings_header_copy', true ) ); ?>
                    </div>
                <?php } ?>
                <?php if ( get_acf_field( 'contact_us_page_settings_header_map' ) ) { ?>
                    <div class="col">
                        <?php echo apply_filters( 'the_content', get_acf_field( 'contact_us_page_settings_header_map', true ) ); ?>
                    </div>
                <?php } ?>
            </div>

            <span class="crosshairs-white crosshairs-top-left"></span>
            <span class="crosshairs-white crosshairs-top-right"></span>

        </div>

    </section>

    <section id="<?php echo $post->post_name; ?>_recommended_hotel" class="section-white">

        <div class="<?php echo esc_attr( $container ); ?>">

            <div class="row">
                <?php if ( get_acf_field( 'contact_us_page_settings_recommended_hotel_image' ) ) { ?>
                    <?php $contact_us_page_settings_recommended_hotel_image_id = get_acf_field( 'contact_us_page_settings_recommended_hotel_image' ); ?>
                    <?php if ( is_array( $contact_us_page_settings_recommended_hotel_image_id ) && isset( $contact_us_page_settings_recommended_hotel_image_id[0] ) ) { ?>
                        <div class="col-12 col-lg-6">
                            <?php echo wp_get_attachment_image( $contact_us_page_settings_recommended_hotel_image_id[0], 'large', false, array( 'class' => 'image-fluid' ) ); ?>
                        </div>
                    <?php } ?>
                <?php } ?>
                <div class="col">
                    <?php echo sprintf( '<h2 class="section-title">%1$s</h2>',
                        __( 'Recommended Hotel', 'aethercomm' )
                    ); ?>
                    <?php echo apply_filters( 'the_content', get_acf_field( 'contact_us_page_settings_recommended_hotel_copy', true ) ); ?>
                </div>
            </div>

        </div>

    </section>

</article>
