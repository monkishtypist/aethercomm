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

    <section class="section-black">

        <div class="<?php echo esc_attr( $container ); ?>">
        </div>

    </section>

    <section class="section-banner">

        <div class="<?php echo esc_attr( $container ); ?>">
            <h2>Our corporate headquarters are located in a state-of-the-art, 50,000 square foot facility just north of San Diego in Carlsbad, California.</h2>
        </div>

    </section>

    <section class="section-full">

        <div class="container-fluid">
        </div>

    </section>

    <section class="section-black">

        <div class="<?php echo esc_attr( $container ); ?>">
        </div>

    </section>

</article>
