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

<div class="wrapper" id="search-wrapper" class="search-wrapper">

    <main class="site-main" id="main">

        <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

            <section id="search_header" class="section_header search_header section-header-overlay section-header-overlay_black">

                <div class="section-image-overlay-wrapper" <?php // echo $section_header_styles; ?>>
                    <div class="section-image-overlay-wrapper-inner">
                        <div class="overlay"></div>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/news-hero.png" class="section-overlay-image img-fluid" />
                    </div>
                </div>

                <div class="<?php echo esc_attr( $container ); ?>">

                    <header>
                        <h1 class="page-title"><?php echo( sprintf( '%1$s', __( 'Search', 'aethercomm' ) ) ); ?></h1>
                        <div class="page-lede"><?php _e( 'Lorem ipsum that <strong>saves lives.</strong>', 'aethercomm' ); ?></div>
                    </header>

                    <span class="crosshairs-white crosshairs-sm-gray crosshairs-top-left"></span>
                    <span class="crosshairs-white crosshairs-top-right"></span>

                </div>

            </section>

            <?php if ( have_posts() ) : ?>

                <section id="the-posts_section" class="section-white section-banner-wide">

                    <div class="<?php echo esc_attr( $container ); ?>">

                        <div class="row no-gutters">

                            <div class="posts-articles col">

                                <?php while ( have_posts() ) : the_post(); ?>

                                    <?php get_template_part( 'loop-templates/content', 'posts' ); ?>

                                <?php endwhile; // end of the loop. ?>

                                <!-- The pagination component -->
                                <?php understrap_pagination(); ?>

                            </div>

                        </div>

                        <span class="crosshairs-gray crosshairs-top-left"></span>
                        <span class="crosshairs-gray crosshairs-top-right"></span>

                    </div>

                </section>

            <?php endif; ?>

        </article>

    </main><!-- #main -->

</div><!-- #search-wrapper -->

<?php get_footer(); ?>
