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

<div class="wrapper" id="index-wrapper" class="index-wrapper">

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
                    <span class="crosshairs-gray crosshairs-top-right"></span>

                </div>

            </section>

            <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 1
            );
            $query = new WP_Query( $args );
            ?>

            <?php if ( $query->have_posts() ) : ?>

                <?php ob_start(); ?>

                <section id="<?php echo $post->post_name; ?>_content" class="child-page-content section-dark section-banner">

                    <div class="<?php echo esc_attr( $container ); ?>">

                    <pre><?php print_r($cats); ?></pre>

                        <?php while ( $query->have_posts() ) : $query->the_post(); ?>

                            <?php get_template_part( 'loop-templates/content', 'card' ); ?>

                        <?php endwhile; ?>

                    </div>

                </section>

                <?php echo ob_get_clean(); ?>

            <?php endif; wp_reset_query(); ?>

            <?php if ( have_posts() ) : ?>

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'loop-templates/content', 'posts' ); ?>

                <?php endwhile; // end of the loop. ?>

                <!-- The pagination component -->
                <?php understrap_pagination(); ?>

            <?php endif; ?>

        </article>

    </main><!-- #main -->

</div><!-- #index-wrapper -->

<?php get_footer(); ?>
