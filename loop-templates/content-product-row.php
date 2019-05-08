<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package aethercomm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$terms = get_the_terms( get_the_ID(), 'product-categories' );
$terms_array = array();
foreach ( $terms as $term ) {
    $terms_array[] = $term->slug;
}
?>

<tr>
    <td>
        <a href="#" class="btn btn-secondary btn-sm"><?php echo sprintf( '%1$s<br />%2$s', __( 'Request', 'aethercomm' ), __( 'Details', 'aethercomm' ) ); ?></a>
    </td>
    <td>
        <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'img-fluid' ) ); ?>
        <?php echo sprintf( '<a href="%1$s" class="btn-link product-link">%2$s</a>',
            get_permalink(),
            get_acf_field( 'product_specs_model_number', true )
        ); ?>
        <?php echo sprintf( '<a href="%1$s" class="btn-link pdf-link">%2$s</a>',
            get_acf_field( 'product_details_data_sheet', true ),
            __( 'PDF', 'aethercomm' )
        ); ?>
    </td>
    <td><?php acf_field( 'product_specs_frequency_min'); ?></td>
    <td><?php acf_field( 'product_specs_frequency_max'); ?></td>
    <td><?php acf_field( 'product_specs_watts'); ?></td>
    <td><?php echo implode( ", ", $terms_array ); // Category ?></td>
    <td>
        <?php echo apply_filters( 'the_excerpt', get_acf_field( 'product_details_short_description', true ) ); ?>
        <a href="<?php echo get_permalink(); ?>" class="read-more-link"><?php _e( 'More', 'aethercomm' ); ?></a>
    </td>
</tr>
