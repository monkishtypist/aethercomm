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

?>

<div class="wrapper" id="index-wrapper" class="archive-wrapper">

    <main class="site-main" id="main">

        <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

            <section id="index_header" class="section_header index_header section-header-overlay section-header-overlay_black">

                <div class="section-image-overlay-wrapper" <?php // echo $section_header_styles; ?>>
                    <div class="section-image-overlay-wrapper-inner">
                        <div class="overlay"></div>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/news-hero.png" class="section-overlay-image img-fluid" />
                    </div>
                </div>

                <div class="<?php echo esc_attr( $container ); ?>">

                    <header>
                        <h1 class="page-title"><?php echo( sprintf( '%1$s &amp; %2$s', __( 'News', 'aethercomm' ), __( 'Articles', 'aethercomm' ) ) ); ?></h1>
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

                            <?php if ( is_active_sidebar( 'blog' ) ) : ?>
                                <div class="posts-sidebar col-3">
                                    <?php dynamic_sidebar( 'blog' ); ?>
                                </div>
                            <?php endif; ?>

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

</div><!-- #index-wrapper -->

<?php get_footer(); ?>
