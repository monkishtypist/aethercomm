<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package aethercomm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$container = get_theme_mod( 'understrap_container_type' );

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <section id="who-page-intro" class="section-black">

        <div class="<?php echo esc_attr( $container ); ?>">

            <header>
                <?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
                <?php if ( get_acf_field( 'who-we-are_page_settings_header_lede' ) ) { ?>
                    <div class="page-lede"><?php echo apply_filters( 'the_content', get_acf_field( 'who-we-are_page_settings_header_lede', true ) ); ?></div>
                <?php } ?>
                <?php if ( get_acf_field( 'who-we-are_page_settings_header_copy' ) ) { ?>
                    <?php echo apply_filters( 'the_content', get_acf_field( 'who-we-are_page_settings_header_copy', true ) ); ?>
                <?php } ?>
            </header>

            <span class="crosshairs-white crosshairs-top-left"></span>
            <span class="crosshairs-white crosshairs-top-right"></span>

        </div>

    </section>

    <section id="who-page-tabs" class="section-unpadded">

        <div class="container-fluid">
        </div>

    </section>

    <section id="who-page-mission" class="section-black section-path1">

        <div class="<?php echo esc_attr( $container ); ?>">

            <div class="row">
                <div class="col-12 col-lg-6">
                    <?php echo sprintf( '<h2 class="">%1$s</h2>',
                        get_acf_field( 'who-we-are_page_settings_mission_title', true )
                    ); ?>
                    <?php echo apply_filters( 'the_content', get_acf_field( 'who-we-are_page_settings_mission_copy', true ) ); ?>
                </div>
            </div>

        </div>

    </section>

</article>
