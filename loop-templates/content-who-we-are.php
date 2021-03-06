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

$section_mission_background_image_url = '/wp-content/uploads/2019/04/who-we-are_mission-statement.png'; // default
if ( get_acf_field( 'who-we-are_page_settings_mission_background' ) ) {
    $section_mission_background_img_id = get_acf_field( 'who-we-are_page_settings_mission_background' );
    if ( is_array( $section_mission_background_img_id ) && isset( $section_mission_background_img_id[0] ) ) {
        $section_mission_background_image_url = wp_get_attachment_url( $section_mission_background_img_id[0] );
    }
}
$section_mission_styles = sprintf( 'style="%1$s"',
    sprintf( 'background-image:url(%1$s),url(%2$s);',
        get_stylesheet_directory_uri() . '/images/path1.png',
        $section_mission_background_image_url
    )
);

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <?php get_template_part( 'global-templates/header' ); ?>

    <?php // get_template_part( 'loop-templates/partial', 'timeline' ); ?>

    <section id="timeline_section" class="section-timeline section-unpadded">
        <div class="container">
            <h2 class="section-title"><?php _e( 'Milestones', 'aethercomm' ); ?></h2>
            <?php
            echo do_shortcode( '[cool-timeline layout="horizontal" category="timeline-milestones" designs="design-6" order="ASC" show-posts="99" icons="YES" date-format="Y" story-content="full" autoplay="false" start-on="0"]' );
            ?>
        </div>
    </section>

    <section id="<?php echo $post->post_name; ?>_mission" class="section-black section-path1" <?php // echo $section_mission_styles; ?> >

        <div class="section-image-overlay-wrapper">
            <div class="section-image-overlay-wrapper-inner">
                <div class="overlay"></div>
                <img class="path path1" src="<?php echo get_stylesheet_directory_uri(); ?>/images/path1.png" />
                <img class="section-overlay-image" src="<?php echo $section_mission_background_image_url; ?>" width="100%" />
            </div>
        </div>

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

    <section id="<?php echo $post->post_name; ?>_team" class="section-white">

        <div class="<?php echo esc_attr( $container ); ?>">

            <div id="team-members-title">
                <?php echo sprintf( '<h2 class="">%1$s</h2>',
                    __( 'Team', 'aethercomm' )
                ); ?>
            </div>

            <?php
            $args = array(
                'post_type' => 'team-members',
                'posts_per_page' => 20
            );
            $query = new WP_Query( $args );
            ?>

            <?php if ( $query->have_posts() ) : ?>

                <?php ob_start(); ?>

                <div id="team-members-cards" class="card-deck">

                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>

                        <?php get_template_part( 'loop-templates/content', 'card' ); ?>

                    <?php endwhile; ?>

                </div>

                <?php echo ob_get_clean(); ?>

            <?php endif; wp_reset_query(); ?>

            <span class="crosshairs-blue crosshairs-bottom-left"></span>
            <span class="crosshairs-blue crosshairs-bottom-right"></span>

        </div>

    </section>

    <?php get_template_part( 'sidebar-templates/sidebar', 'contact' ); ?>

</article>
