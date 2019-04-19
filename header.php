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
	<div id="wrapper-navbar" class="nav-transparency" itemscope itemtype="http://schema.org/WebSite">

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

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#container-main-menu" aria-controls="container-main-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'aethercomm' ); ?>">
					<span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
				</button>

				<!-- The WordPress Menu goes here -->
				<?php wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'container_class' => 'collapse navbar-collapse',
						'container_id'    => 'container-main-menu',
						'menu_class'      => 'navbar-nav ml-auto',
						'fallback_cb'     => '',
						'menu_id'         => 'main-menu',
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
                    <li class="nav-item"><a class ="nav-link"><i class="far fa-comment-alt"></i><?php echo sprintf( ' &nbsp; %1$s', __( 'Rep Listings', 'aethercomm' ) ); ?></a></li>
                    <li class="nav-item"><a class ="nav-link"><i class="fas fa-search"></i><?php echo sprintf( '<span class="sr-only">%1$s</span>', __( 'Search', 'aethercomm' ) ); ?></a></li>
                </ul>
            </div>
        </div>

	</div><!-- #wrapper-navbar end -->
