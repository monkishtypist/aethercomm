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

$section_benefits_styles = sprintf( 'style="%1$s"',
    sprintf( 'background-image:url(%1$s);',
        '/wp-content/uploads/2019/04/benefits-bg.png'
    )
);
if ( get_acf_field( 'careers_page_settings_benefits_background' ) ) {
    $section_benefits_background_img_id = get_acf_field( 'careers_page_settings_benefits_background' );
    if ( is_array( $section_benefits_background_img_id ) && isset( $section_benefits_background_img_id[0] ) ) {
        $section_benefits_background_image_url = wp_get_attachment_url( $section_benefits_background_img_id[0] );
        $section_benefits_styles = sprintf( 'style="%1$s"',
            sprintf( 'background-image:url(%1$s);',
                $section_benefits_background_image_url
            )
        );
    }
}

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <?php get_template_part( 'global-templates/header' ); ?>

    <section id="<?php echo $post->post_name; ?>_benefits" class="section-blue" <?php echo $section_benefits_styles; ?> >

        <div class="<?php echo esc_attr( $container ); ?>">

            <div class="row">
                <div class="col">
                    <?php echo sprintf( '<h2 class="section-title">%1$s</h2>',
                        get_acf_field( 'careers_page_settings_benefits_title', true )
                    ); ?>
                    <?php echo apply_filters( 'the_content', get_acf_field( 'careers_page_settings_benefits_copy', true ) ); ?>
                </div>
            </div>

        </div>

    </section>

    <section id="<?php echo $post->post_name; ?>_open_positions" class="section-white section-banner-wide" <?php echo $section_open_positions_styles; ?> >

        <div class="<?php echo esc_attr( $container ); ?>">

            <div class="row">
                <div class="col-12">
                    <?php echo sprintf( '<h2 class="section-title">%1$s</h2>',
                        get_acf_field( 'careers_page_settings_open_positions_title', true )
                    ); ?>
                    <?php echo apply_filters( 'the_content', get_acf_field( 'careers_page_settings_open_positions_content', true ) ); ?>
                </div>
            </div>

        </div>

    </section>

    <?php if ( class_exists( 'RevSlider' ) ) : ?>

        <section id="<?php echo $post->post_name; ?>_slider" class="section-unpadded">

            <div class="container-fluid">
                <?php putRevSlider("careers"); ?>
            </div>

        </section>

    <?php endif; ?>

    <?php get_template_part( 'sidebar-templates/sidebar', 'contact' ); ?>

</article>
