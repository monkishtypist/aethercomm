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

<div class="card">

    <?php the_post_thumbnail( 'card-img-top', array( 'class' => 'card-img-top' ) ); ?>

    <div class="card-body">
        <div class="card-meta"></div>
        <?php the_title( '<h5 class="card-title">', '</h5>' ); ?>
        <div class="card-text"><?php the_excerpt(); ?></div>
    </div>

</div>
