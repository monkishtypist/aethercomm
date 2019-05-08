<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package aethercomm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$terms = get_terms( array(
    'taxonomy' => 'product-categories',
    'hide_empty' => false,
) );

?>

<tr>
    <td>
        <a href="#" class="btn btn-secondary">Request Details</a>
    </td>
    <td>
        <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'img-fluid' ) ); ?>
        <?php acf_field( 'product_specs_model_number'); ?>
    </td>
    <td><?php acf_field( 'product_specs_frequency_min'); ?></td>
    <td><?php acf_field( 'product_specs_frequency_max'); ?></td>
    <td><?php acf_field( 'product_specs_watts'); ?></td>
    <td><?php echo implode( ", ", $terms ); // Category ?></td>
    <td>
        <?php echo apply_filters( 'the_excerpt', get_acf_field( 'product_details_short_description', true ) ); ?>
        <a href="<?php echo get_permalink(); ?>" class="read-more-link"><?php _e( 'More', 'aethercomm' ); ?></a>
    </td>
</tr>
