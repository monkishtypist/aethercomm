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

            <div class="row">

                <div class="col-12 col-md-6">
                    <?php echo sprintf( '<h2 class="section-title">%1$s</h2>',
                        __( 'Search Products', 'aethercomm' )
                    ); ?>

                    <form method="get" id="productsearchform" action="/" role="search" class="show" _lpchecked="1">
                        <label class="sr-only" for="productsearch">Search Products</label>
                        <div class="input-group">
                            <input class="field form-control" id="productsearch" name="productsearch" type="text" placeholder="" value="">
                            <span class="input-group-append">
                                <button type="submit" id="productsearchsubmit" class="">
                                    <i class="fas fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </section>

    <?php if ( $product_cats ) : ?>

        <section id="<?php echo $post->post_name; ?>_categories" class="section-black">

            <div class="<?php echo esc_attr( $container ); ?>">

                <nav id="product-cats-nav" class="nav">
                    <?php foreach ( $product_cats as $product_cat ) : ?>
                        <?php echo sprintf( '<a class="nav-link" href="%1$s" data-cat-slug="%2$s" data-cat-count="%3$s">%4$s</a>',
                            '#', // get_category_link( $product_cat ),
                            $product_cat->slug,
                            $product_cat->category_count,
                            sprintf( '<strong>%1$s</strong>%2$s',
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
                'posts_per_page' => -1
            );
            $query = new WP_Query( $args );
            ?>

            <table id="products-table" class="products-table table tablehover table-responsive">

                <thead>
                    <tr>
                        <th>Filters</th>
                        <th>Part Number</th>
                        <th>Frequency Min</th>
                        <th>Frequency Max</th>
                        <th>Watts</th>
                        <th class="col-hidden">Category</th>
                        <th>Description</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if ( $query->have_posts() ) : ?>

                        <?php ob_start(); ?>

                            <?php while ( $query->have_posts() ) : $query->the_post(); ?>

                                <?php get_template_part( 'loop-templates/content', 'product-row' ); ?>

                            <?php endwhile; ?>

                        <?php echo ob_get_clean(); ?>

                    <?php endif; wp_reset_query(); ?>

                </tbody>

            </table>

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
