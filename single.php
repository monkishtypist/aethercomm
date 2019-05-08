<?php
/**
 * The template for displaying the Pages.
 *
 * @package aethercomm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$container = get_theme_mod( 'understrap_container_type' );

global $post;

?>

<div class="wrapper" id="<?php echo $post->post_name; ?>_page-wrapper" class="single_page-wrapper">

    <main class="site-main" id="main">

        <?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'loop-templates/content', 'single' ); ?>

        <?php endwhile; // end of the loop. ?>

    </main><!-- #main -->

</div><!-- #page-wrapper -->

<?php get_footer(); ?>