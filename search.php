<?php
/**
 * The template for displaying the Search results page.
 *
 * @package aethercomm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$container = get_theme_mod( 'understrap_container_type' );

global $post;

if ( $post->post_parent ) {
    $template_slug = 'child';
} else {
    $template_slug = $post->post_name;
}

?>

<div class="wrapper" id="search-wrapper">

    <main class="site-main" id="main">

        <?php if ( have_posts() ) : ?>

            <?php while ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'loop-templates/content', 'search' ); ?>

            <?php endwhile; // end of the loop. ?>

        <?php endif; ?>

    </main><!-- #main -->

</div><!-- #page-wrapper -->

<?php get_footer(); ?>
