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

$section_header_background_image_url = '/wp-content/uploads/2019/04/rep-listing-hero.png'; // default
if ( get_acf_field( 'rep-listing_page_settings_header_background' ) ) {
    $section_header_background_img_id = get_acf_field( 'rep-listing_page_settings_header_background' );
    if ( is_array( $section_header_background_img_id ) && isset( $section_header_background_img_id[0] ) ) {
        $section_header_background_image_url = wp_get_attachment_url( $section_header_background_img_id[0] );
    }
}
$section_header_styles = sprintf( 'style="%1$s"',
    sprintf( 'background-image:url(%1$s);',
        $section_header_background_image_url
    )
);

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

    <section id="<?php echo $post->post_name; ?>_header" class="section_header section-black" <?php // echo $section_header_styles; ?> >

        <?php get_template_part( 'global-templates/header', 'image' ); ?>

        <div class="<?php echo esc_attr( $container ); ?>">

            <header>
                <?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
                <?php if ( get_acf_field( 'rep-listing_page_settings_header_lede' ) ) { ?>
                    <div class="page-lede"><?php echo apply_filters( 'the_content', get_acf_field( 'rep-listing_page_settings_header_lede', true ) ); ?></div>
                <?php } ?>
                <?php if ( get_acf_field( 'rep-listing_page_settings_header_copy' ) ) { ?>
                    <?php echo apply_filters( 'the_content', get_acf_field( 'rep-listing_page_settings_header_copy', true ) ); ?>
                <?php } ?>
            </header>

            <span class="crosshairs-white crosshairs-top-left"></span>
            <span class="crosshairs-white crosshairs-top-right"></span>

        </div>

    </section>

    <section id="<?php echo $post->post_name; ?>_reps" class="section-dark">

        <div class="<?php echo esc_attr( $container ); ?>">

            <?php if ( get_acf_field( 'rep-listing_page_settings_reps_title' ) ) { ?>
                <?php echo sprintf( '<h2 class="section-title">%1$s</h2>',
                    get_acf_field( 'rep-listing_page_settings_reps_title', true )
                ); ?>
            <?php } ?>

            <div class="card-deck">

            </div>

        </div>

    </section>

    <?php get_template_part( 'sidebar-templates/sidebar', 'contact' ); ?>

</article>
