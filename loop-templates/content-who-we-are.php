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

$section_header_styles = null;
if ( get_acf_field( 'who-we-are_page_settings_header_background' ) ) {
    $section_header_background_img_id = get_acf_field( 'who-we-are_page_settings_header_background' );
    if ( is_array( $section_header_background_img_id ) && isset( $section_header_background_img_id[0] ) ) {
        $section_header_background_image_url = wp_get_attachment_url( $section_header_background_img_id[0] );
        $section_header_styles = sprintf( 'styles="%1$s"',
            sprintf( 'background-image:url(%1$s);',
                $section_header_background_image_url
            )
        );
    }
}

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <section id="who-page-intro" class="section-blue" <?php echo $section_header_styles; ?> >

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

            <ul class="nav nav-tabs" id="milestones-tabs" role="tablist">
                <?php echo sprintf( '<li class="nav-item"><a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">%1$s</a></li>',
                    get_acf_field( 'who-we-are_page_settings_tabs_tab1_title', true )
                ); ?>
                <?php echo sprintf( '<li class="nav-item"><a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">%1$s</a></li>',
                    get_acf_field( 'who-we-are_page_settings_tabs_tab2_title', true )
                ); ?>
                <?php echo sprintf( '<li class="nav-item"><a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">%1$s</a></li>',
                    get_acf_field( 'who-we-are_page_settings_tabs_tab3_title', true )
                ); ?>
            </ul>

        </div>

        <div class="tab-content" id="myTabContent">
            <div class="<?php echo esc_attr( $container ); ?>">
                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">...tab1</div>
                <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">...tab2</div>
                <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">...tab3</div>
            </div>
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
