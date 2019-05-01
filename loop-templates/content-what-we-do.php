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
        '/wp-content/uploads/2019/04/what-we-do-hero.png' // default background image
    )
);
if ( get_acf_field( 'what-we-do_page_settings_header_background' ) ) {
    $section_header_background_img_id = get_acf_field( 'what-we-do_page_settings_header_background' );
    if ( is_array( $section_header_background_img_id ) && isset( $section_header_background_img_id[0] ) ) {
        $section_header_background_image_url = wp_get_attachment_url( $section_header_background_img_id[0] );
        $section_header_styles = sprintf( 'style="%1$s"',
            sprintf( 'background-image:url(%1$s);',
                $section_header_background_image_url
            )
        );
    }
}

$section_capabilities_styles = sprintf( 'style="%1$s"',
    sprintf( 'background-image:url(%1$s);',
        '/wp-content/uploads/2019/04/what-we-do_capabilities-background.png'
    )
);
if ( get_acf_field( 'what-we-do_page_settings_capabilities_background' ) ) {
    $section_capabilities_background_img_id = get_acf_field( 'what-we-do_page_settings_capabilities_background' );
    if ( is_array( $section_capabilities_background_img_id ) && isset( $section_capabilities_background_img_id[0] ) ) {
        $section_capabilities_background_image_url = wp_get_attachment_url( $section_capabilities_background_img_id[0] );
        $section_capabilities_styles = sprintf( 'style="%1$s"',
            sprintf( 'background-image:url(%1$s);',
                $section_capabilities_background_image_url
            )
        );
    }
}

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <section id="<?php echo $post->post_name; ?>_header" class="section-black" <?php echo $section_header_styles; ?> >

        <div class="<?php echo esc_attr( $container ); ?>">

            <header>
                <?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
                <?php if ( get_acf_field( 'what-we-do_page_settings_header_lede' ) ) { ?>
                    <div class="page-lede"><?php echo apply_filters( 'the_content', get_acf_field( 'what-we-do_page_settings_header_lede', true ) ); ?></div>
                <?php } ?>
                <?php if ( get_acf_field( 'what-we-do_page_settings_header_copy' ) ) { ?>
                    <?php echo apply_filters( 'the_content', get_acf_field( 'what-we-do_page_settings_header_copy', true ) ); ?>
                <?php } ?>
            </header>

            <span class="crosshairs-white crosshairs-top-left"></span>
            <span class="crosshairs-white crosshairs-top-right"></span>

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
                        <div class="col-6">
                            <h3 class="section-title"><?php acf_field( 'what-we-do_page_settings_tabs_tab1_title' ); ?></h3>
                            <?php echo apply_filters( 'the_content', get_acf_field( 'what-we-do_page_settings_tabs_tab1_content', true ) ); ?>
                        </div>
                        <div class="col-6">
                            <?php
                            if ( get_acf_field( 'what-we-do_page_settings_tabs_tab1_image' ) ) {
                                $page_settings_tabs_tab1_image_id = get_acf_field( 'what-we-do_page_settings_tabs_tab1_image' );
                                if ( is_array( $page_settings_tabs_tab1_image_id ) && isset( $page_settings_tabs_tab1_image_id[0] ) ) {
                                    echo wp_get_attachment_image( $page_settings_tabs_tab1_image_id[0], 'large', false, array( 'class' => 'tab-image' ) );
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="section-title"><?php acf_field( 'what-we-do_page_settings_tabs_tab2_title' ); ?></h3>
                            <?php echo apply_filters( 'the_content', get_acf_field( 'what-we-do_page_settings_tabs_tab2_content', true ) ); ?>
                        </div>
                        <div class="col-6">
                            <?php
                            if ( get_acf_field( 'what-we-do_page_settings_tabs_tab2_image' ) ) {
                                $page_settings_tabs_tab2_image_id = get_acf_field( 'what-we-do_page_settings_tabs_tab2_image' );
                                if ( is_array( $page_settings_tabs_tab2_image_id ) && isset( $page_settings_tabs_tab2_image_id[0] ) ) {
                                    echo wp_get_attachment_image( $page_settings_tabs_tab2_image_id[0], 'large', false, array( 'class' => 'tab-image' ) );
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="section-title"><?php acf_field( 'what-we-do_page_settings_tabs_tab3_title' ); ?></h3>
                            <?php echo apply_filters( 'the_content', get_acf_field( 'what-we-do_page_settings_tabs_tab3_content', true ) ); ?>
                        </div>
                        <div class="col-6">
                            <?php
                            if ( get_acf_field( 'what-we-do_page_settings_tabs_tab3_image' ) ) {
                                $page_settings_tabs_tab3_image_id = get_acf_field( 'what-we-do_page_settings_tabs_tab3_image' );
                                if ( is_array( $page_settings_tabs_tab3_image_id ) && isset( $page_settings_tabs_tab3_image_id[0] ) ) {
                                    echo wp_get_attachment_image( $page_settings_tabs_tab3_image_id[0], 'large', false, array( 'class' => 'tab-image' ) );
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab3-tab">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="section-title"><?php acf_field( 'what-we-do_page_settings_tabs_tab4_title' ); ?></h3>
                            <?php echo apply_filters( 'the_content', get_acf_field( 'what-we-do_page_settings_tabs_tab4_content', true ) ); ?>
                        </div>
                        <div class="col-6">
                            <?php
                            if ( get_acf_field( 'what-we-do_page_settings_tabs_tab4_image' ) ) {
                                $page_settings_tabs_tab4_image_id = get_acf_field( 'what-we-do_page_settings_tabs_tab4_image' );
                                if ( is_array( $page_settings_tabs_tab4_image_id ) && isset( $page_settings_tabs_tab4_image_id[0] ) ) {
                                    echo wp_get_attachment_image( $page_settings_tabs_tab4_image_id[0], 'large', false, array( 'class' => 'tab-image' ) );
                                }
                            }
                            ?>
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
