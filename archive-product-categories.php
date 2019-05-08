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

$cats = get_categories();

$queried_object = get_queried_object();

?>

<div class="wrapper" id="product-categories-wrapper" class="product-categories-wrapper">

    <main class="site-main" id="main">

        <?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'loop-templates/content', 'products' ); ?>

        <?php endwhile; // end of the loop. ?>

    </main><!-- #main -->

</div><!-- #products-wrapper -->

<?php get_footer(); ?>
