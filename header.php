<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$container = get_theme_mod( 'understrap_container_type' );

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="site" id="page">

	<!-- ******************* The Navbar Area ******************* -->
	<div id="wrapper-navbar" class="" itemscope itemtype="http://schema.org/WebSite">

		<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'aethercomm' ); ?></a>

		<nav class="navbar navbar-expand-md navbar-dark">

            <?php if ( 'container' == $container ) : ?>
                <div class="container">
            <?php endif; ?>

                <!-- Your site title as branding in the menu -->
                <?php if ( ! has_custom_logo() ) { ?>

                    <?php if ( is_front_page() && is_home() ) : ?>

                        <h1 class="navbar-brand mb-0"><a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>

                    <?php else : ?>

                        <a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a>

                    <?php endif; ?>

                <?php } else {
                    the_custom_logo();
                } ?><!-- end custom logo -->

                <a href="<?php echo get_permalink( 27 ); ?>" class="navbar-icon-reps"><i class="far fa-comment-alt-dots"></i></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#container-main-menu-mobile" aria-controls="container-main-menu-mobile" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'aethercomm' ); ?>">
					<span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
				</button>

				<!-- The WordPress Menu goes here -->
				<?php wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'container_class' => '',
						'container_id'    => 'container-main-menu',
						'menu_class'      => 'navbar-nav ml-auto',
						'fallback_cb'     => '',
						'menu_id'         => 'main-menu',
						'depth'           => 2,
						'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
					)
				); ?>
				<!-- The WordPress Mobile Menu goes here -->
				<?php wp_nav_menu(
					array(
						'theme_location'  => 'primary-mobile',
						'container_class' => 'collapse navbar-collapse',
						'container_id'    => 'container-main-menu-mobile',
						'menu_class'      => 'navbar-nav ml-auto',
						'fallback_cb'     => '',
						'menu_id'         => 'main-menu-mobile',
						'depth'           => 2,
						'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
					)
				); ?>
			<?php if ( 'container' == $container ) : ?>
    			</div><!-- .container -->
			<?php endif; ?>

        </nav><!-- .site-navigation -->
        <div class="sub-navbar">
            <div class="sub-navbar-inner">
                <ul class="nav">
                    <li class="nav-item"><a href="<?php echo get_permalink( 27 ); ?>" class="nav-link"><i class="far fa-comment-alt-dots"></i><?php echo sprintf( ' &nbsp; %1$s', __( 'Rep Listings', 'aethercomm' ) ); ?></a></li>
					<li class="nav-item"><?php get_search_form(); ?></li>
                </ul>
            </div>
        </div>

	</div><!-- #wrapper-navbar end -->
