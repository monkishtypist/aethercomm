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

$card_text = null;
$card_img = false;
switch ( $post->post_type ) {
    case 'team-members':
        $card_text = apply_filters( 'the_content', get_acf_field( 'team_member_position', true ) );
        $card_img = true;
        break;
    case 'representatives':
        $card_text = apply_filters( 'the_content', get_the_content() );
        $card_img = false;
        break;
    default:
        $card_text = apply_filters( 'the_excerpt', get_the_excerpt() );
        $card_img = true;
        break;
}

?>

<div class="card card-<?php echo $post->post_type; ?>" data-post-type="<?php echo $post->post_type; ?>">

    <?php if ( has_post_thumbnail() && $card_img ) {
        the_post_thumbnail( 'card-img-top', array( 'class' => 'card-img-top' ) );
    } else { ?>
        <img class="card-img-top" src="<?php echo get_stylesheet_directory_uri(); ?>/images/team_default.png" alt="<?php the_title(); ?>" />
    <?php } ?>

    <div class="card-body">
        <div class="card-meta"></div>
        <?php the_title( '<h3 class="card-title">', '</h3>' ); ?>
        <div class="card-text"><?php echo $card_text; ?></div>
    </div>

</div>
