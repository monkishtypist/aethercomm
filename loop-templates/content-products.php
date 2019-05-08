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

    <section id="<?php echo $post->post_name; ?>_search" class="section-white">

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
                    <?php
                    foreach ( $product_cats as $product_cat ) :
                        $cat_object = get_category( $product_cat );
                        var_dump($product_cat);
                    ?>
                        <a class="nav-link" href="<?php echo get_category_link( $product_cat ); ?>"><?php echo $product_cat->name; ?></a>
                    <?php endforeach; ?>
                </nav>

            </div>

        </section>

    <?php endif; ?>

    <section id="<?php echo $post->post_name; ?>_loop" class="section-white">

        <div class="<?php echo esc_attr( $container ); ?>">

            <?php
            $args = array(
                'post_type' => 'products',
                'posts_per_page' => 20
            );
            $query = new WP_Query( $args );
            ?>

            <?php if ( $query->have_posts() ) : ?>

                <?php ob_start(); ?>

                <div id="team-members-cards" class="card-deck">

                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>

                        <?php get_template_part( 'loop-templates/content', 'card' ); ?>

                    <?php endwhile; ?>

                </div>

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
