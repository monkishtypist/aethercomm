<?php
/**
 * The main template file for taxonomies.
 *
 * @package aethercomm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$container = get_theme_mod( 'understrap_container_type' );

global $post;

$queried_object = get_queried_object();

?>

<div class="wrapper" id="<?php echo $queried_object->taxonomy; ?>_wrapper" class="<?php echo $queried_object->taxonomy; ?>-wrapper">

    <main class="site-main" id="main">

    <pre><?php print_r( $queried_object ); ?></pre>

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'loop-templates/content', 'card' ); ?>

        <?php endwhile; ?><?php else : ?>

            <?php get_template_part( 'loop-templates/content', $queried_object->taxonomy ); ?>

        <?php endif; ?>

    </main><!-- #main -->

</div><!-- #products-wrapper -->

<?php get_footer(); ?>
