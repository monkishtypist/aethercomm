<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<footer class="wrapper" id="wrapper-footer">

    <div class="<?php echo esc_attr( $container ); ?>">

        <?php
        /**
         * FOOTER: Footer Menu
         */
        ?>
        <div class="row">
            <div class="col">
                <?php wp_nav_menu(
					array(
						'theme_location'  => 'footer',
						'container_class' => '',
						'container_id'    => 'footer-menu-wrapper',
						'menu_class'      => 'nav',
						'fallback_cb'     => '',
						'menu_id'         => 'footer-menu',
						'depth'           => 2,
						'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
					)
				); ?>
            </div>
        </div>

        <?php
        /**
         * FOOTER: Footer Widgets and Social
         */
        ?>
		<div class="row justify-content-between">
			<div class="col">
            </div>
            <div class="col">
                <div id="footer-social"></div>
            </div>
        </div>

        <?php
        /**
         * FOOTER: Colophon and Legal Menu
         */
        ?>
        <div class="row">
            <div class="col">
                <div id="colophon">
                    <?php aethercomm_site_info(); ?>
                </div>
            </div>
            <div class="col">
                <!-- legal menu -->
            </div>
        </div>

	</div><!-- container end -->

</footer><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>

