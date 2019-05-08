<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package aethercomm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

$container = get_theme_mod( 'understrap_container_type' );

$product_cats_args = array(
    'taxonomy'   => 'product-categories',
    'orderby'    => 'name',
    'order'      => 'ASC',
    'hide_empty' => false
);

$product_cats = get_categories( $product_cats_args );

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <?php get_template_part( 'global-templates/header' ); ?>

    <section id="products_search" class="section-white">

        <div class="<?php echo esc_attr( $container ); ?>">

            <?php echo sprintf( '<h2 class="section-title">%1$s</h2>',
                __( 'Search Products', 'aethercomm' )
            ); ?>

        </div>

    </section>

    <?php if ( $product_cats ) : ?>

        <section id="<?php echo $post->post_name; ?>_categories" class="section-black">

            <div class="<?php echo esc_attr( $container ); ?>">

                <nav class="nav">
                    <?php foreach ( $product_cats as $product_cat ) : ?>
                        <?php echo sprintf( '<a class="nav-link" href="%1$s" data-cat-count="%2$s">%3$s</a>',
                            get_category_link( $product_cat ),
                            $product_cat->category_count,
                            sprintf( '%1$s%2$s',
                                esc_html( $product_cat->name ),
                                ( $product_cat->category_count > 0 ? sprintf( ' (%1$s)', $product_cat->category_count ) : '' )
                            ) ); ?>
                    <?php endforeach; ?>
                </nav>

            </div>

        </section>

    <?php endif; ?>

    <section id="products_loop" class="section-white">

        <div class="<?php echo esc_attr( $container ); ?>">

            <?php
            $args = array(
                'post_type' => 'products',
                'posts_per_page' => 9
            );
            $query = new WP_Query( $args );
            ?>

            <?php if ( $query->have_posts() ) : ?>

                <?php ob_start(); ?>

                <table id="products-table" class="products-table table ">

                    <thead></thead>

                    <tbody>

                        <?php while ( $query->have_posts() ) : $query->the_post(); ?>

                            <?php get_template_part( 'loop-templates/content', 'product-row' ); ?>

                        <?php endwhile; ?>

                    </tbody>

                </table>

                <?php echo ob_get_clean(); ?>

            <?php endif; wp_reset_query(); ?>

            <span class="crosshairs-blue crosshairs-bottom-left"></span>
            <span class="crosshairs-blue crosshairs-bottom-right"></span>

        </div>

    </section>

    <?php if ( class_exists( 'RevSlider' ) ) : ?>

        <section id="product-page-slider" class="section-unpadded">

            <div class="container-fluid">
                <?php putRevSlider("products"); ?>
            </div>

        </section>

    <?php endif; ?>

    <?php get_template_part( 'sidebar-templates/sidebar', 'contact' ); ?>

</article>
