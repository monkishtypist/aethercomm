<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package aethercomm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<tr>
    <td></td>
    <td><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'img-fluid' ) ); ?><?php acf_field( 'product_specs_model_number'); ?></td>
    <td><?php acf_field( 'product_specs_frequency_min'); ?></td>
    <td><?php acf_field( 'product_specs_frequency_max'); ?></td>
    <td><?php acf_field( 'product_specs_watts'); ?></td>
    <td><?php the_excerpt(); ?></td>
</tr>
