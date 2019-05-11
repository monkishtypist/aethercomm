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

    <section id="<?php echo $post->post_name; ?>_content" class="single-page-content section-white section-banner">

        <div class="<?php echo esc_attr( $container ); ?>">

            <div class="row">
                <div class="col">
                    <?php the_content(); ?>
                </div>
            </div>

        </div>

    </section>

    <?php get_template_part( 'sidebar-templates/sidebar', 'contact' ); ?>

</article>
