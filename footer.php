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

        <?php
        /**
         * FOOTER: Widgets and Social
         */
        ?>
		<div class="footer-widgets">
            <?php if ( is_active_sidebar( 'footer-content' ) ) : ?>
                <?php dynamic_sidebar( 'footer-content' ); ?>
            <?php endif; ?>
            <?php if ( is_active_sidebar( 'social-icons' ) ) : ?>
                <?php dynamic_sidebar( 'social-icons' ); ?>
            <?php endif; ?>
        </div>

        <?php
        /**
         * FOOTER: Colophon and Legal Menu
         */
        ?>
        <div class="footer-siteinfo">
            <!-- legal menu -->
            <?php wp_nav_menu(
                array(
                    'theme_location'  => 'legal',
                    'container_class' => '',
                    'container_id'    => 'legal-menu-wrapper',
                    'menu_class'      => 'nav',
                    'fallback_cb'     => '',
                    'menu_id'         => 'legal-menu',
                    'depth'           => 2,
                    'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
                    )
                ); ?>
            <div id="colophon">
                <?php aethercomm_site_info(); ?>
            </div>
        </div>

	</div><!-- container end -->

</footer><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>

