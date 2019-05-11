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
        <a href="#" class="product-queue-link"><?php _e( 'Add to queue', 'aethercomm' ); ?></a>
    </td>
    <td data-order="<?php echo get_acf_field( 'product_specs_model_number', true ); ?>">
        <div class="row no-gutters">
            <?php if ( has_post_thumbnail() ) { ?>
                <div class="col-12 col-md-3 pr-md-1">
                    <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'img-fluid' ) ); ?>
                </div>
            <?php } ?>
            <div class="col">
                <?php echo sprintf( '<a href="%1$s" class="btn-link product-link">%2$s</a>',
                    get_permalink(),
                    get_acf_field( 'product_specs_model_number', true )
                ); ?>
                <?php echo sprintf( '<a href="%1$s" class="btn-link pdf-link">%2$s</a>',
                    get_acf_field( 'product_details_data_sheet', true ),
                    __( 'PDF', 'aethercomm' )
                ); ?>
            </div>
        </div>
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
