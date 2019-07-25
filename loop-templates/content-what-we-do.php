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

$template_slug = $post->post_name;

$container = get_theme_mod( 'understrap_container_type' );

// Header image overlay
if ( has_acf_field( 'page_header_background' ) ) {
    $section_header_image_id = get_acf_field( 'page_header_background', true );
    $section_header_image = wp_get_attachment_image( $section_header_image_id, 'full', false, array( 'class' => 'section-overlay-image section-overlay-image-desktop img-fluid' ) );
} elseif ( has_post_thumbnail() ) {
    $section_header_image = get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'section-overlay-image section-overlay-image-desktop img-fluid' ) );
} else {
    $section_header_image = false;
}
if ( has_post_thumbnail() ) {
    $section_header_image_mobile = get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'section-overlay-image section-overlay-image-mobile img-fluid' ) );
}
$overlay_color = ( has_acf_field( 'page_header_overlay' ) ? get_acf_field( 'page_header_overlay', true ) : 'black' );

// Page Title & Lede
$page_title = false;
$page_lede = false;

if ( has_acf_field( 'page_header_lede' ) ) {
    $page_title = sprintf( '<h1 class="page-title" data-if="4-1">%1$s</h1>',
        get_the_title() );
    $page_lede = sprintf( '<div class="page-lede">%1$s</div>',
        apply_filters( 'the_content', get_acf_field( 'page_header_lede', true ) ) );
} else {
    $page_lede = sprintf( '<h1 class="page-lede" data-if="4-2">%1$s</h1>',
        get_the_title() );
}

// Page header Copy
$page_header_copy = false;
if ( get_acf_field( 'page_header_copy' ) ) :
    $page_header_copy = sprintf( '<div class="d-none d-md-block">%1$s</div>',
        apply_filters( 'the_content', get_acf_field( 'page_header_copy', true ) ) );
endif;

$section_header_classes = sprintf( 'section_header %1$s_header ',
    $template_slug );
$section_crosshairs = '<span class="crosshairs-gray crosshairs-sm-gray crosshairs-top-left"></span><span class="crosshairs-gray crosshairs-top-right"></span>';

if ( $section_header_image ) {
    $section_header_classes .= sprintf( 'section-header-overlay section-header-overlay_%1$s',
        $overlay_color );
    $section_crosshairs = '<span class="crosshairs-white crosshairs-sm-gray crosshairs-top-left"></span><span class="crosshairs-white crosshairs-top-right"></span>';
}

// Page header video
$video_embed_code = false;
if ( has_acf_field( 'what-we-do_page_settings_header_video' ) ) {
    $video_embed_code = get_acf_field( 'what-we-do_page_settings_header_video', true );
}

// section capabilities
$section_capabilities_background_image_url = '/wp-content/uploads/2019/04/what-we-do_capabilities-background.png'; // default
if ( get_acf_field( 'what-we-do_page_settings_capabilities_background' ) ) {
    $section_capabilities_background_img_id = get_acf_field( 'what-we-do_page_settings_capabilities_background' );
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

    <section id="<?php echo $post->post_name; ?>_header" class="<?php echo $section_header_classes; ?>">

        <?php if ( $section_header_image ) : ?>
            <div class="section-image-overlay-wrapper" <?php // echo $section_header_styles; ?>>
                <div class="section-image-overlay-wrapper-inner">
                    <div class="overlay"></div>
                    <?php echo $section_header_image; ?>
                    <?php echo $section_header_image_mobile; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="<?php echo esc_attr( $container ); ?>">

            <div class="row justify-content-between align-items-center">
                <header>
                    <?php echo $page_title; ?>
                    <?php echo $page_lede; ?>
                    <?php echo $page_header_copy; ?>
                </header>
                <div class="header-video-wrapper">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/aethercomm-logo-colorful_white.png" class="img-fluid aethercomm-logo" alt="Aethercomm Logo" />
                    <?php if ( $video_embed_code ) { ?>
                        <a href="#play-video" class="play-video-button" data-embed-code='<?php echo $video_embed_code; ?>'><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/play-video.png" alt="Play Video" /></a>
                    <?php } ?>
                </div>
            </div>

            <?php echo $section_crosshairs; ?>

        </div>

    </section>

    <section id="video-section-mobile" class="d-block d-md-none section-unpadded">
        <div class="row no-gutters">
            <?php if ( $video_embed_code ) { ?>
                <div class="col-12">
                    <a href="#play-video" class="play-video-button" data-embed-code='<?php echo $video_embed_code; ?>'><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/play-video.png" alt="Play Video" /></a>
                </div>
            <?php } ?>
            <div class="col-12">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/aethercomm-logo-colorful_white.png" class="img-fluid aethercomm-logo" alt="Aethercomm Logo" />
            </div>
        </div>
    </section>

    <section id="<?php echo $post->post_name; ?>_tabs" class="section-unpadded">

        <div class="container-fluid">

            <ul class="nav nav-tabs nav-fill" id="platforms-tabs" role="tablist">
                <?php echo sprintf( '<li class="nav-item"><a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true"><span>%1$s</span></a></li>',
                    get_acf_field( 'what-we-do_page_settings_tabs_tab1_title', true )
                ); ?>
                <?php echo sprintf( '<li class="nav-item"><a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false"><span>%1$s</span></a></li>',
                    get_acf_field( 'what-we-do_page_settings_tabs_tab2_title', true )
                ); ?>
                <?php echo sprintf( '<li class="nav-item"><a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false"><span>%1$s</span></a></li>',
                    get_acf_field( 'what-we-do_page_settings_tabs_tab3_title', true )
                ); ?>
                <?php echo sprintf( '<li class="nav-item"><a class="nav-link" id="tab4-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false"><span>%1$s</span></a></li>',
                    get_acf_field( 'what-we-do_page_settings_tabs_tab4_title', true )
                ); ?>
            </ul>

        </div>

        <div id="platforms-tabs-content-wrapper">
            <div class="<?php echo esc_attr( $container ); ?>" id="platforms-tabs-content">
                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                    <div class="row">
                        <div class="col">
                            <div class="tab-content-image-wrapper">
                                <?php
                                if ( get_acf_field( 'what-we-do_page_settings_tabs_tab1_image' ) ) {
                                    $page_settings_tabs_tab1_image_id = get_acf_field( 'what-we-do_page_settings_tabs_tab1_image' );
                                    if ( is_array( $page_settings_tabs_tab1_image_id ) && isset( $page_settings_tabs_tab1_image_id[0] ) ) {
                                        echo wp_get_attachment_image( $page_settings_tabs_tab1_image_id[0], 'large', false, array( 'class' => 'tab-image' ) );
                                    }
                                }
                                ?>
                            </div>
                            <h3 class="section-title"><?php acf_field( 'what-we-do_page_settings_tabs_tab1_title' ); ?></h3>
                            <?php echo apply_filters( 'the_content', get_acf_field( 'what-we-do_page_settings_tabs_tab1_content', true ) ); ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                    <div class="row">
                        <div class="col">
                            <div class="tab-content-image-wrapper">
                                <?php
                                if ( get_acf_field( 'what-we-do_page_settings_tabs_tab2_image' ) ) {
                                    $page_settings_tabs_tab2_image_id = get_acf_field( 'what-we-do_page_settings_tabs_tab2_image' );
                                    if ( is_array( $page_settings_tabs_tab2_image_id ) && isset( $page_settings_tabs_tab2_image_id[0] ) ) {
                                        echo wp_get_attachment_image( $page_settings_tabs_tab2_image_id[0], 'large', false, array( 'class' => 'tab-image img-fluid' ) );
                                    }
                                }
                                ?>
                            </div>
                            <h3 class="section-title"><?php acf_field( 'what-we-do_page_settings_tabs_tab2_title' ); ?></h3>
                            <?php echo apply_filters( 'the_content', get_acf_field( 'what-we-do_page_settings_tabs_tab2_content', true ) ); ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                    <div class="row">
                        <div class="col">
                            <div class="tab-content-image-wrapper">
                                <?php
                                if ( get_acf_field( 'what-we-do_page_settings_tabs_tab3_image' ) ) {
                                    $page_settings_tabs_tab3_image_id = get_acf_field( 'what-we-do_page_settings_tabs_tab3_image' );
                                    if ( is_array( $page_settings_tabs_tab3_image_id ) && isset( $page_settings_tabs_tab3_image_id[0] ) ) {
                                        echo wp_get_attachment_image( $page_settings_tabs_tab3_image_id[0], 'large', false, array( 'class' => 'tab-image img-fluid' ) );
                                    }
                                }
                                ?>
                            </div>
                            <h3 class="section-title"><?php acf_field( 'what-we-do_page_settings_tabs_tab3_title' ); ?></h3>
                            <?php echo apply_filters( 'the_content', get_acf_field( 'what-we-do_page_settings_tabs_tab3_content', true ) ); ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab3-tab">
                    <div class="row">
                        <div class="col">
                            <div class="tab-content-image-wrapper">
                                <?php
                                if ( get_acf_field( 'what-we-do_page_settings_tabs_tab4_image' ) ) {
                                    $page_settings_tabs_tab4_image_id = get_acf_field( 'what-we-do_page_settings_tabs_tab4_image' );
                                    if ( is_array( $page_settings_tabs_tab4_image_id ) && isset( $page_settings_tabs_tab4_image_id[0] ) ) {
                                        echo wp_get_attachment_image( $page_settings_tabs_tab4_image_id[0], 'large', false, array( 'class' => 'tab-image img-fluid' ) );
                                    }
                                }
                                ?>
                            </div>
                            <h3 class="section-title"><?php acf_field( 'what-we-do_page_settings_tabs_tab4_title' ); ?></h3>
                            <?php echo apply_filters( 'the_content', get_acf_field( 'what-we-do_page_settings_tabs_tab4_content', true ) ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section id="<?php echo $post->post_name; ?>_capabilities" class="section-black" <?php echo $section_capabilities_styles; ?> >

        <div class="<?php echo esc_attr( $container ); ?>">

            <?php echo sprintf( '<h2 class="section-title">%1$s</h2>',
                get_acf_field( 'what-we-do_page_settings_capabilities_title', true )
            ); ?>

            <div class="card-deck">

                <div class="card card-capabilities-card1">

                    <?php if ( get_acf_field( 'what-we-do_page_settings_capabilities_cards_card1_icon' ) ) { ?>
                        <div class="card-body">
                            <?php
                            $capabilities_cards_card1_icon = get_acf_field( 'what-we-do_page_settings_capabilities_cards_card1_icon' );
                            if ( is_array( $capabilities_cards_card1_icon ) && isset( $capabilities_cards_card1_icon[0] ) ) {
                                $capabilities_cards_card1_icon_url = wp_get_attachment_url( $capabilities_cards_card1_icon[0] );
                                echo sprintf( '<img class="card-icon" src="%1$s" alt="%2$s" />',
                                    $capabilities_cards_card1_icon_url,
                                    $post->$post_title
                                );
                            }
                            ?>
                        </div>
                    <?php } ?>

                    <div class="card-body">
                        <?php if ( get_acf_field( 'what-we-do_page_settings_capabilities_cards_card1_label' ) ) {
                            echo sprintf( '<h3 class="card-title">%1$s</h3>',
                                get_acf_field( 'what-we-do_page_settings_capabilities_cards_card1_label', true )
                            );
                         } ?>
                        <div class="card-text">
                        <?php
                        $capabilities_card1_link = get_acf_field( 'what-we-do_page_settings_capabilities_cards_card1_link' );
                        echo sprintf( '<a href="%1$s" class="btn btn-outline-white stretched-link" %2$s>%3$s</a>',
                            esc_url( $capabilities_card1_link[0]['url'] ),
                            sprintf( 'target="%1$s"',
                                $capabilities_card1_link[0]['target']
                            ),
                            esc_html__( $capabilities_card1_link[0]['title'], 'aethercomm' )
                        );
                        ?>
                        </div>
                    </div>

                </div>

                <div class="card card-capabilities-card2">

                    <?php if ( get_acf_field( 'what-we-do_page_settings_capabilities_cards_card2_icon' ) ) { ?>
                        <div class="card-body">
                            <?php
                            $capabilities_cards_card2_icon = get_acf_field( 'what-we-do_page_settings_capabilities_cards_card2_icon' );
                            if ( is_array( $capabilities_cards_card2_icon ) && isset( $capabilities_cards_card2_icon[0] ) ) {
                                $capabilities_cards_card2_icon_url = wp_get_attachment_url( $capabilities_cards_card2_icon[0] );
                                echo sprintf( '<img class="card-icon" src="%1$s" alt="%2$s" />',
                                    $capabilities_cards_card2_icon_url,
                                    $post->$post_title
                                );
                            }
                            ?>
                        </div>
                    <?php } ?>

                    <div class="card-body">
                        <?php if ( get_acf_field( 'what-we-do_page_settings_capabilities_cards_card2_label' ) ) {
                            echo sprintf( '<h3 class="card-title">%1$s</h3>',
                                get_acf_field( 'what-we-do_page_settings_capabilities_cards_card2_label', true )
                            );
                         } ?>
                        <div class="card-text">
                        <?php
                        $capabilities_card2_link = get_acf_field( 'what-we-do_page_settings_capabilities_cards_card2_link' );
                        echo sprintf( '<a href="%1$s" class="btn btn-outline-white stretched-link" %2$s>%3$s</a>',
                            esc_url( $capabilities_card2_link[0]['url'] ),
                            sprintf( 'target="%1$s"',
                                $capabilities_card2_link[0]['target']
                            ),
                            esc_html__( $capabilities_card2_link[0]['title'], 'aethercomm' )
                        );
                        ?>
                        </div>
                    </div>

                </div>

                <div class="card card-capabilities-card3">

                    <?php if ( get_acf_field( 'what-we-do_page_settings_capabilities_cards_card3_icon' ) ) { ?>
                        <div class="card-body">
                            <?php
                            $capabilities_cards_card3_icon = get_acf_field( 'what-we-do_page_settings_capabilities_cards_card3_icon' );
                            if ( is_array( $capabilities_cards_card3_icon ) && isset( $capabilities_cards_card3_icon[0] ) ) {
                                $capabilities_cards_card3_icon_url = wp_get_attachment_url( $capabilities_cards_card3_icon[0] );
                                echo sprintf( '<img class="card-icon" src="%1$s" alt="%2$s" />',
                                    $capabilities_cards_card3_icon_url,
                                    $post->$post_title
                                );
                            }
                            ?>
                        </div>
                    <?php } ?>

                    <div class="card-body">
                        <?php if ( get_acf_field( 'what-we-do_page_settings_capabilities_cards_card3_label' ) ) {
                            echo sprintf( '<h3 class="card-title">%1$s</h3>',
                                get_acf_field( 'what-we-do_page_settings_capabilities_cards_card3_label', true )
                            );
                         } ?>
                        <div class="card-text">
                        <?php
                        $capabilities_card3_link = get_acf_field( 'what-we-do_page_settings_capabilities_cards_card3_link' );
                        echo sprintf( '<a href="%1$s" class="btn btn-outline-white stretched-link" %2$s>%3$s</a>',
                            esc_url( $capabilities_card3_link[0]['url'] ),
                            sprintf( 'target="%1$s"',
                                $capabilities_card3_link[0]['target']
                            ),
                            esc_html__( $capabilities_card3_link[0]['title'], 'aethercomm' )
                        );
                        ?>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </section>

    <?php get_template_part( 'sidebar-templates/sidebar', 'contact' ); ?>

</article>
