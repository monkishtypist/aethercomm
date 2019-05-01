<?php
/**
 * Sidebar - contact form.
 *
 * @package aethercomm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$container = get_theme_mod( 'understrap_container_type' );

global $post;

?>

<?php if ( is_active_sidebar( 'contact' ) ) : ?>

    <section id="<?php echo $post->post_name; ?>_contact" class="section-blue-gradient section-contact-form">

        <div class="<?php echo esc_attr( $container ); ?>">

            <h2 class="section-header">Contact <strong>Us</strong></h2>

            <?php dynamic_sidebar( 'contact' ); ?>

            <span class="crosshairs-white crosshairs-top-left"></span>
            <span class="crosshairs-white crosshairs-top-right"></span>
            <span class="crosshairs-white crosshairs-bottom-left"></span>
            <span class="crosshairs-white crosshairs-bottom-right"></span>

        </div>

    </section>

<?php endif; ?>
