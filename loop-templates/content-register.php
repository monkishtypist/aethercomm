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

    <section id="<?php echo $post->post_name; ?>_header" class="section_header section-black">

        <div class="<?php echo esc_attr( $container ); ?>">

            <header>
                <?php the_title( '<h1 class="page-title text-center">', '</h1>' ); ?>
            </header>

            <div class="row justify-content-center">
                <div class="col-12 col-lg-6">
                    <?php the_content(); ?>
                </div>
            </div>

            <span class="crosshairs-gray crosshairs-top-left"></span>
            <span class="crosshairs-gray crosshairs-top-right"></span>

        </div>

    </section>

</article>
