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

$card_meta = false;

$cats = get_the_category();
if ( $cats ) {
    $card_meta = sprintf( '<div class="card-meta"><span class="post-category"><a href="%1$s">%2$s</a></span><span class="sep"> | </span><span class="entry-date">%3$s</span></div>',
        esc_url( get_category_link( $cats[0]->term_id ) ),
        esc_html( $cats[0]->name ),
        get_the_date()
    );
}

$card_img = ( has_post_thumbnail()
    ? get_the_post_thumbnail( 'card-img-top', array( 'class' => 'card-img-top' ) )
    : false );

$card_title = sprintf( '<h3 class="card-title">%1$s</h3>',
    wp_kses_post( get_the_title() )
);

$card_text = sprintf( '<div class="card-text">%1$s</div>',
    apply_filters( 'the_content', get_the_content() )
);

$card_footer = false;

switch ( $post->post_type ) { // modify the defaults
    case 'post':
        $card_text = sprintf( '<div class="card-text">%1$s</div>',
            apply_filters( 'the_excerpt', get_the_excerpt() )
        );
        break;
    case 'team-members':
        $card_img = ( has_post_thumbnail()
        ? get_the_post_thumbnail( 'card-img-top', array( 'class' => 'card-img-top' ) )
        : sprintf( '<img class="card-img-top" src="%1$s/images/team_default.png" alt="%2$s" />',
            get_stylesheet_directory_uri(),
            get_the_title()
        ) );
        $card_text = apply_filters( 'the_content', get_acf_field( 'team_member_position', true ) );
        break;
    case 'representatives':
        $card_img = false;
        $card_text .= sprintf( '<div class="card-text">%1$s<br><a href="mailto:%2$s">%3$s</a></div>',
            get_acf_field( 'cpt_rep_phone', true ),
            get_acf_field( 'cpt_rep_email', true ),
            get_acf_field( 'cpt_rep_email', true )
        );
        $card_footer = sprintf( '<div class="card-footer">%1$s</div>',
            sprintf( '<a href="mailto:%1$s" class="btn btn-gray">%2$s</a>',
                get_acf_field( 'cpt_rep_email', true ),
                __( 'Contact', 'aethercomm' )
            )
        );
        break;
    default:
        break;
}

?>

<div class="card card-<?php echo $post->post_type; ?>" data-post-type="<?php echo $post->post_type; ?>">

    <?php if ( $card_img ) { echo $card_img; } ?>

    <div class="card-body">
        <?php echo ( is_front_page() ? $card_meta : null ); ?>
        <?php echo $card_title; ?>
        <?php echo $card_text; ?>
    </div>

    <?php if ( $card_footer ) { echo $card_footer; } ?>

</div>
