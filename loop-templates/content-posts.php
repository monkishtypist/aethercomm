<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package aethercomm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// global $post;

?>

<article <?php post_class( 'row no-gutters' ); ?> id="post-<?php the_ID(); ?>">

    <?php if ( has_post_thumbnail() ) { ?>
        <div class="post-image-wrapper col-12 col-md order-md-last"><?php the_post_thumbnail( 'posts-archive', array( 'class' => 'img-fluid' ) ); ?></div>
    <?php } ?>

    <div class="post-content-wrapper col-12 col-md-5 order-md-first">

        <?php the_title( '<h1 class="entry-title h3">', '</h1>' ); ?>

        <?php the_excerpt(); ?>

    </div>

</article>
