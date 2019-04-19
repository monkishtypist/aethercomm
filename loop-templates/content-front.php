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

    <section id="front-page-intro" class="section-black">

        <div class="<?php echo esc_attr( $container ); ?>">
            <div id="intro-header">
                <?php acf_field( 'front_page_settings_intro_header' ); ?>
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
            </div>
            <div class="row">
                <div id="intro-copy" class="col-12 col-md-6">
                    <?php acf_field( 'front_page_settings_intro_copy' ); ?>
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

    <section id="front-page-banner" class="section-banner section-blue" style="background-image: url(<?php acf_field( 'front_page_settings_banner_copy' ); ?>);">

        <div class="<?php echo esc_attr( $container ); ?>">
            <div id="banner-copy">
                <?php acf_field( 'front_page_settings_banner_copy' ); ?>
            </div>
        </div>

    </section>

    <section id="front-page-slider" class="section-unpadded">

        <div class="container-fluid">
        </div>

    </section>

    <section id="front-page-posts" class="section-black">

        <div class="<?php echo esc_attr( $container ); ?>">

            <div id="posts-title">
                <?php acf_field( 'front_page_settings_posts_title' ); ?>
            </div>

        </div>

        <div class="<?php echo esc_attr( $container ); ?>">

            <?php
            $args = array(
                'category_name' => 'featured'
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

            <span class="crosshair-600 crosshairs-top-left"></span>
            <span class="crosshair-600 crosshairs-top-right"></span>
            <span class="crosshair-600 crosshairs-bottom-left"></span>
            <span class="crosshair-600 crosshairs-bottom-right"></span>

        </div>

    </section>

</article>
