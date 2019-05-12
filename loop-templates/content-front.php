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

    <section id="front-page-intro" class="section_header section-black">

        <div class="<?php echo esc_attr( $container ); ?>">
            <header id="front-page-header">
                <h1><?php acf_field( 'front_page_settings_intro_header' ); ?></h1>
                <?php
                $link1 = get_acf_field( 'front_page_settings_intro_header_cta' );
                echo sprintf( '<a href="%1$s" class="btn btn-primary btn-lg" %2$s>%3$s</a>',
                    esc_url( $link1[0]['url'] ),
                    sprintf( 'target="%1$s"',
                        $link1[0]['target']
                    ),
                    esc_html__( $link1[0]['title'], 'aethercomm' )
                );
                ?>
            </header>
            <div class="row">
                <div id="intro-copy" class="col-12 col-md-10 offset-md-1 col-lg-6 offset-lg-0">
                    <div class="page-lede"><?php acf_field( 'front_page_settings_intro_lede' ); ?></div>
                    <?php echo apply_filters( 'the_content', get_acf_field( 'front_page_settings_intro_copy', true ) ); ?>
                    <?php
                    $link2 = get_acf_field( 'front_page_settings_intro_copy_cta' );
                    echo sprintf( '<a href="%1$s" class="btn btn-outline-white" %2$s>%3$s</a>',
                        esc_url( $link2[0]['url'] ),
                        sprintf( 'target="%1$s"',
                            $link2[0]['target']
                        ),
                        esc_html__( $link2[0]['title'], 'aethercomm' )
                    );
                    ?>
                </div>
            </div>
        </div>

    </section>

    <?php
    if ( get_acf_field( 'front_page_settings_banner_copy' ) ) :
        $banner_image_array  = get_acf_field( 'front_page_settings_banner_background' );
        $banner_image_id     = (int) $banner_image_array[0];
        $banner_image_styles = null;
        if ( $banner_image_id ) {
            $banner_image_styles = sprintf( 'style="background-image: %1$s, url(%2$s);"',
                'linear-gradient(0deg, rgba(74, 99, 174, .9) 0, rgba(74, 99, 174, .9) 100%)',
                wp_get_attachment_url( $banner_image_id )
            );
        }
        ?>

        <section id="front-page-banner" class="section-banner section-blue" <?php echo $banner_image_styles; ?> >

            <div class="<?php echo esc_attr( $container ); ?>">
                <div id="banner-copy">
                    <div><?php acf_field( 'front_page_settings_banner_copy' ); ?></div>
                </div>
            </div>

        </section>

    <?php endif; ?>

    <?php if ( class_exists( 'RevSlider' ) ) : ?>

        <section id="front-page-slider" class="section-unpadded">

            <div class="container-fluid">
                <?php putRevSlider("home"); ?>
            </div>

        </section>

    <?php endif; ?>

    <section id="front-page-posts" class="section-black section-path1">

        <div class="<?php echo esc_attr( $container ); ?>">

            <div id="posts-title">
                <?php acf_field( 'front_page_settings_posts_title' ); ?>
            </div>

        </div>

        <div class="<?php echo esc_attr( $container ); ?>">

            <?php
            $args = array(
                'post_type' => 'post'
            );
            $query = new WP_Query( $args );
            ?>

            <?php if ( $query->have_posts() ) : ?>

                <?php ob_start(); ?>

                <div class="card-deck">

                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>

                        <?php get_template_part( 'loop-templates/content', 'card' ); ?>

                    <?php endwhile; ?>

                </div>

                <?php echo ob_get_clean(); ?>

            <?php endif; wp_reset_query(); ?>

            <span class="crosshairs-600 crosshairs-top-left"></span>
            <span class="crosshairs-600 crosshairs-top-right"></span>
            <span class="crosshairs-600 crosshairs-bottom-left"></span>
            <span class="crosshairs-600 crosshairs-bottom-right"></span>

        </div>

    </section>

</article>
