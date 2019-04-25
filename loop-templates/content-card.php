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

<div class="card" data-post-type="<?php echo $post->post_type; ?>">

    <?php if ( has_post_thumbnail() ) {
        the_post_thumbnail( 'card-img-top', array( 'class' => 'card-img-top' ) );
    } else { ?>
        <img class="card-img-top" width="245" height="221" src="<?php echo get_stylesheet_directory_uri(); ?>/images/team_default.png" alt="<?php the_title(); ?>" />
    <?php } ?>

    <div class="card-body">
        <div class="card-meta"></div>
        <?php the_title( '<h3 class="card-title">', '</h3>' ); ?>
        <div class="card-text"><?php the_excerpt(); ?></div>
    </div>

</div>
