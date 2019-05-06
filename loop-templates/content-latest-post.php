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

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

    <?php the_content(); ?>

    <?php if ( has_post_thumbnail() ) { ?>
        <?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid' ) ); ?>
    <?php } ?>

</article>
