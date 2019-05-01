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

$section_header_styles = sprintf( 'style="%1$s"',
    sprintf( 'background-image:url(%1$s);',
        '/wp-content/uploads/2019/04/custom-design-hero.png' // default background image
    )
);
if ( get_acf_field( 'child_page_settings_header_background' ) ) {
    $section_header_background_img_id = get_acf_field( 'child_page_settings_header_background' );
    if ( is_array( $section_header_background_img_id ) && isset( $section_header_background_img_id[0] ) ) {
        $section_header_background_image_url = wp_get_attachment_url( $section_header_background_img_id[0] );
        $section_header_styles = sprintf( 'style="%1$s"',
            sprintf( 'background-image:url(%1$s);',
                $section_header_background_image_url
            )
        );
    }
}

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <section id="<?php echo $post->post_name; ?>_header" class="section_header child-page-header section-black" <?php echo $section_header_styles; ?> >

        <div class="<?php echo esc_attr( $container ); ?>">

            <header>
                <?php if ( $post->post_parent ) { ?>
                    <div class="page-title"><?php echo get_the_title( $post->post_parent ); ?></div>
                <?php } ?>
                <?php the_title( '<h1 class="page-lede">', '</h1>' ); ?>
            </header>

            <span class="crosshairs-gray crosshairs-top-left"></span>
            <span class="crosshairs-gray crosshairs-top-right"></span>

        </div>

    </section>

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