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

$terms = get_terms( 'timelines-categories', array(
    'hide_empty' => false,
) );
$args = array();
$query = array();
foreach ( $terms as $key => $term ) {
    echo '<pre>' . print_r($term) . '</pre>';
    $args[ $key ] = array(
        'post_type' => 'timelines',
        'tax_query' => array(
            array(
                'taxonomy' => 'timelines-categories',
                'field'    => 'slug',
                'terms'    => $term->slug,
            ),
        ),
        'posts_per_page' => -1
    );
    $query[ $key ] = new WP_Query( $args[ $key ] );
}

?>

<section id="timeline_section" class="section-timeline section-unpadded">

    <div class="container-fluid">
        <ul class="nav nav-tabs nav-fill" id="milestones-tabs" role="tablist">
            <?php foreach ( $terms as $key => $term ) { ?>
                <?php echo sprintf( '<li class="nav-item"><a class="nav-link %1$s" id="tab%2$s-tab" data-toggle="tab" href="#tab%3$s" role="tab" aria-controls="tab%4$s" aria-selected="%5$s"><span>%6$s</span></a></li>',
                    ( $key == 0 ? 'active' : '' ),
                    $key,
                    $key,
                    $key,
                    ( $key == 0 ? 'true' : 'false' ),
                    get_acf_field( 'who-we-are_page_settings_tabs_tab1_title', true )
                ); ?>
            <?php } ?>
        </ul>
    </div>

    <div class="<?php // echo esc_attr( $container ); ?>" id="milestones-tabs-content">
        <?php foreach ( $terms as $key => $term ) { ?>
            <div class="tab-pane fade show <?php echo ( $key == 0 ? 'active' : '' ); ?>" id="tab<?php echo $key; ?>" role="tabpanel" aria-labelledby="tab<?php echo $key; ?>-tab">
                <?php if ( $query[ $key ]->have_posts() ) : ?>
                    <?php while ( $query[ $key ]->have_posts() ) : $query[ $key ]->the_post(); ?>
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
            </div>
        <?php } ?>
    </div>

</section>
