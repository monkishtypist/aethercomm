<?php
/**
 * Sidebar - contact form.
 *
 * @package aethercomm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

?>

<?php if ( is_active_sidebar( 'contact' ) ) : ?>

    <section id="<?php echo $post->post_name; ?>_contact" class="section-blue-gradient section-contact-form">

    </section>

<?php endif; ?>
