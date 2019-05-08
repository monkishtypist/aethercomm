<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$container = get_theme_mod( 'understrap_container_type' );

global $post;

?>

<div class="wrapper" id="<?php echo $post->post_name; ?>_wrapper" class="<?php echo $post->post_name; ?>-wrapper">

    <main class="site-main" id="main">

        <?php get_template_part( 'loop-templates/content', 'products' ); ?>
        <?php while ( have_posts() ) : the_post(); ?>


        <?php endwhile; // end of the loop. ?>

    </main><!-- #main -->

</div><!-- #products-wrapper -->

<?php get_footer(); ?>
