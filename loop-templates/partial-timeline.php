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

$args = array(
    'post_type' => 'timelines',
    'posts_per_page' => -1
);
$query = new WP_Query( $args );

?>

<section id="timeline_section" class="section-timeline section-white">

    <?php if ( $query->have_posts() ) : ?>
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <div class="timeline-element">
                <?php if ( has_post_thumbnail() ) { ?>
                    <?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid timeline-image' ) ); ?>
                <?php } ?>
                <div class="timeline-content">
                    <?php the_content(); ?>
                </div>
                <div class="timeline-date">
                    <?php the_date( 'Y' ); ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; wp_reset_query(); ?>

    <div class="tp-leftarrow tparrows uranus noSwipe"></div>
    <div class="tp-rightarrow tparrows uranus noSwipe"></div>

</section>
