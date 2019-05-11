<?php
/**
 * The global template for the page header backgrounds
 */

global $post;

$queried_object = get_queried_object();

?>

<table class="table">
    <tbody>
        <?php if ( get_acf_field( 'product_specs_frequency_min', true ) ) { ?>
            <tr>
                <td><?php _e( 'Low Frequency', 'aethercomm' ); ?></td>
                <td class="text-right"><?php echo get_acf_field( 'product_specs_frequency_min', true ); ?> <?php _e( 'MHz', 'aethercomm' ); ?></td>
            </tr>
        <?php } ?>
        <?php if ( get_acf_field( 'product_specs_frequency_max', true ) ) { ?>
            <tr>
                <td><?php _e( 'High Frequency', 'aethercomm' ); ?></td>
                <td class="text-right"><?php echo get_acf_field( 'product_specs_frequency_max', true ); ?> <?php _e( 'MHz', 'aethercomm' ); ?></td>
            </tr>
        <?php } ?>
        <?php if ( get_acf_field( 'product_specs_watts', true ) ) { ?>
            <tr>
                <td><?php _e( 'Output Power', 'aethercomm' ); ?></td>
                <td class="text-right"><?php echo get_acf_field( 'product_specs_watts', true ); ?> <?php _e( 'watts', 'aethercomm' ); ?></td>
            </tr>
        <?php } ?>
        <?php if ( get_acf_field( 'product_specs_applied_voltage', true ) ) { ?>
            <tr>
                <td><?php _e( 'Applied Voltage', 'aethercomm' ); ?></td>
                <td class="text-right"><?php echo get_acf_field( 'product_specs_applied_voltage', true ); ?> <?php _e( 'Vdc', 'aethercomm' ); ?></td>
            </tr>
        <?php } ?>
        <?php if ( get_acf_field( 'product_specs_short_protection', true ) ) { ?>
            <tr>
                <td><?php _e( 'Short Protection', 'aethercomm' ); ?></td>
                <td class="text-right"><?php _e( 'Yes', 'aethercomm' ); ?></td>
            </tr>
        <?php } ?>
        <?php if ( get_acf_field( 'product_specs_over_protection', true ) ) { ?>
            <tr>
                <td><?php _e( 'Over Protection', 'aethercomm' ); ?></td>
                <td class="text-right"><?php echo get_acf_field( 'product_specs_over_protection', true ); ?> <?php _e( 'MHz', 'aethercomm' ); ?></td>
            </tr>
        <?php } ?>
        <?php if ( get_acf_field( 'product_specs_baseplate_temp', true ) ) { ?>
            <tr>
                <td><?php _e( 'Baseplate Temp', 'aethercomm' ); ?></td>
                <td class="text-right"><?php echo get_acf_field( 'product_specs_baseplate_temp', true ); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
