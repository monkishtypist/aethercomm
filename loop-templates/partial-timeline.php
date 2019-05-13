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

$terms = get_terms( array(
    'taxonomy' => 'timeline-categories',
    'hide_empty' => false,
) );

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
                    $term->name
                ); ?>
            <?php } ?>
        </ul>
    </div>

    <div class="container-fluid" id="milestones-tabs-content">
        <?php foreach ( $terms as $key => $term ) { ?>
            <div class="tab-pane fade show <?php echo ( $key == 0 ? 'active' : '' ); ?>" id="tab<?php echo $key; ?>" role="tabpanel" aria-labelledby="tab<?php echo $key; ?>-tab">
                <?php
                $args = array(
                    'post_type'        => 'timelines',
                    'tax_query'        => array(
                        array(
                            'taxonomy' => 'timeline-categories',
                            'field'    => 'slug',
                            'terms'    => $term->slug,
                        ),
                    ),
                    'posts_per_page'   => -1,
                    'orderby'          => 'date',
                    'order'            => 'ASC'
                );
                $query = new WP_Query( $args );
                ?>
                <?php if ( $query->have_posts() ) : $i = 0; ?>
                    <div class="timeline-wrapper">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/timeline-bg.png" class="timeline-wrapper-dial-image" />
                        <div class="timeline-dial">
                            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                <div class="timeline-element" data-focus="<?php echo ( $i == 0 ? 'focus' : ( $i == 1 ? 'near' : 'false' ) ); ?>">
                                    <?php if ( has_post_thumbnail() ) { ?>
                                        <?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid timeline-image' ) ); ?>
                                    <?php } ?>
                                    <div class="timeline-date">
                                        <?php the_date( 'Y' ); ?>
                                    </div>
                                    <div class="timeline-content">
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                            <?php $i++; endwhile; ?>
                        </div>
                    </div>
                <?php endif; wp_reset_query(); unset( $args, $query ); ?>
            </div>
        <?php } ?>
    </div>

</section>
