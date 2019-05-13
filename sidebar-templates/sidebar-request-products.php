<?php
/**
 * Sidebar - request products form.
 *
 * @package aethercomm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$container = get_theme_mod( 'understrap_container_type' );

global $post;

?>

<?php if ( is_active_sidebar( 'request-product' ) ) : ?>

    <section id="<?php echo $post->post_name; ?>_request-product" class="section-blue-gradient section-request-product-form">

        <div class="<?php echo esc_attr( $container ); ?>">

            <?php dynamic_sidebar( 'request-product' ); ?>

            <span class="crosshairs-white crosshairs-top-left"></span>
            <span class="crosshairs-white crosshairs-top-right"></span>
            <span class="crosshairs-white crosshairs-bottom-left"></span>
            <span class="crosshairs-white crosshairs-bottom-right"></span>

        </div>

    </section>

<?php endif; ?>
