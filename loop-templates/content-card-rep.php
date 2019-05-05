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

$card_text = apply_filters( 'the_content', get_the_content() );

?>

<div class="card card-<?php echo $post->post_type; ?>" data-post-type="<?php echo $post->post_type; ?>">

    <div class="card-body">
        <div class="card-meta"></div>
        <?php the_title( '<h3 class="card-title">', '</h3>' ); ?>
        <div class="card-text"><?php echo $card_text; ?></div>
    </div>

</div>
