<?php
/**
 * The main template file for taxonomies.
 *
 * @package aethercomm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$container = get_theme_mod( 'understrap_container_type' );

$queried_object = get_queried_object();

?>

<div class="wrapper" id="<?php echo $queried_object->taxonomy; ?>_tax-wrapper" class="<?php echo $queried_object->taxonomy; ?>_tax-wrapper">

    <main class="site-main" id="main">

        <?php get_template_part( 'loop-templates/content', 'products' ); ?>

    </main><!-- #main -->

</div><!-- #products-wrapper -->

<?php get_footer(); ?>
