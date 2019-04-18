<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$container = get_theme_mod( 'understrap_container_type' );

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <section id="front-page-intro" class="section-black">

        <div class="<?php echo esc_attr( $container ); ?>">
        </div>

    </section>

    <section id="front-page-banner" class="section-banner section-blue">

        <div class="<?php echo esc_attr( $container ); ?>">
            <h2>Our corporate headquarters are located in a state-of-the-art, 50,000 square foot facility just north of San Diego in Carlsbad, California.</h2>
        </div>

    </section>

    <section id="front-page-slider" class="section-full">

        <div class="container-fluid">
        </div>

    </section>

    <section id="front-page-posts" class="section-black">

        <div class="<?php echo esc_attr( $container ); ?>">
            <h2><?php acf_field( 'front_page_settings_posts_title', true ); ?></h2>
        </div>

    </section>

</article>
