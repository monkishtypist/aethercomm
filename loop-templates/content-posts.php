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

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <?php if ( has_post_thumbnail() ) { ?>
        <div class="post-image-wrapper"><?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid' ) ); ?></div>
    <?php } ?>

    <div class="post-content-wrapper">

        <?php the_title( '<h1 class="entry-title h3">', '</h1>' ); ?>

        <?php the_excerpt(); ?>

    </div>

</article>
