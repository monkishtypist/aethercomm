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

$container = get_theme_mod( 'understrap_container_type' );

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <?php get_template_part( 'global-templates/header' ); ?>

    <section id="<?php echo $post->post_name; ?>_search" class="section-white">

        <div class="<?php echo esc_attr( $container ); ?>">

            <?php echo sprintf( '<h2 class="section-title">%1$s</h2>',
                __( 'Search Products', 'aethercomm' )
            ); ?>

        </div>

    </section>

    <?php if ( class_exists( 'RevSlider' ) ) : ?>

        <section id="product-page-slider" class="section-unpadded">

            <div class="container-fluid">
                <?php putRevSlider("products"); ?>
            </div>

        </section>

    <?php endif; ?>

    <?php get_template_part( 'sidebar-templates/sidebar', 'contact' ); ?>

</article>
