<?php
/**
 * The global template for the page header backgrounds
 */

global $post;

$queried_object = get_queried_object();

?>

<table class="table">
    <tbody>
        <?php if ( get_acf_field( 'products_specs_frequency_min' ) ) { ?>
            <tr>
                <td><?php _e( 'Low Frequency', 'aethercomm' ); ?></td>
                <td><?php echo get_acf_field( 'products_specs_frequency_min', true ); ?></td>
            </tr>
        <?php } ?>
        <?php if ( get_acf_field( 'products_specs_frequency_max' ) ) { ?>
            <tr>
                <td><?php _e( 'High Frequency', 'aethercomm' ); ?></td>
                <td><?php echo get_acf_field( 'products_specs_frequency_max', true ); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
