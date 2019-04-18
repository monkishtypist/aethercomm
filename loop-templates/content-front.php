<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
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
            </div>
            <div id="intro-copy">
                <?php acf_field( 'front_page_settings_intro_copy' ); ?>
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
            <?php
            $args = array(
                'category_name' => 'featured'
            );
            $query = new WP_Query( $args );

            if ( $query->have_posts() ) :

                ob_start();

                while ( $query->have_posts() ) : $query->the_post();

                endwhile;

            endif;
            ?>
        </div>

    </section>

</article>
