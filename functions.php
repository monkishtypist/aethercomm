<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Table of contents
 *
 * 1. Child theme Scripts and Styles
 * 2. After Setup Theme
 *      Textdomain
 *      Nav Menu Location(s)
 * 3. Bootstrap Image classes
 * 4. Advanced Custom Fields setup
 * 5. Excerpts
 * 6. Hooks
 */

/* 1. Child theme Scripts and Styles */
add_action( 'wp_enqueue_scripts', 'aethercomm_remove_parent_scripts', 20 );
function aethercomm_remove_parent_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );
    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}

add_action( 'wp_enqueue_scripts', 'aethercomm_theme_enqueue_styles' );
function aethercomm_theme_enqueue_styles() {
	// Get the theme data
	$the_theme = wp_get_theme();
    wp_enqueue_style( 'aethercomm-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_script( 'jquery');
    wp_enqueue_script( 'aethercomm-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

/* 2. After Setup Theme */
add_action( 'after_setup_theme', 'aethercomm_add_child_theme_textdomain' );
function aethercomm_add_child_theme_textdomain() {
    // Load child theme text-domain
    load_child_theme_textdomain( 'aethercomm', get_stylesheet_directory() . '/languages' );
    // Add custom wp_nav_menu() locations.
    register_nav_menus( array(
        'footer' => __( 'Footer Menu', 'aethercomm' ),
        'legal' => __( 'Legal Menu', 'aethercomm' ),
    ) );
}

/* 3. Bootstrap Image classes */
add_filter( 'image_send_to_editor', 'aethercomm_add_bootstrap_class_to_images', 10, 3 );
if ( ! function_exists( 'aethercomm_add_bootstrap_class_to_images' ) ) {
	function aethercomm_add_bootstrap_class_to_images( $html, $attachment_id, $attachment ) {
		$img_element = "/<img[^>]*>/";
		$found = preg_match( $img_element, $html, $image );

		// If no image, do nothing
		if ( $found <= 0)
			return $html;

		$image = $image[0];

		if ( strstr( $image, "class=\"" ) !== FALSE ) { // If image already has class defined inject it to attribute
			$image_new = str_replace("class=\"", "class=\"img-fluid ", $image);
			$html = str_replace($image, $image_new, $html);
		} else { // If no class defined, just add class attribute
			$html = str_replace("<img ", "<img class=\"img-fluid\"", $html);
		}
		return $html;
	}
}

/* 4. Advanced Custom Fields setup */
add_filter( 'option_active_plugins',  'disable_acf_on_frontend', 10, 1 );
if ( ! function_exists( 'disable_acf_on_frontend' ) ) {
    // Disables ACF plugin on frontend reducing load time
	function disable_acf_on_frontend( $plugins ) {
		if ( is_admin() ) {
			return $plugins;
		}
		foreach ( $plugins as $i => $plugin ) {
			if ( 'advanced-custom-fields-pro/acf.php' == $plugin || 'advanced-custom-fields/acf.php' == $plugin ) {
				unset( $plugins[$i] );
			}
		}
		return $plugins;
	}
}

if ( ! function_exists( 'get_acf_field' ) ) {
    // Accesses ACF fields with WP core functions
	function get_acf_field( $field, $bool = false, $esc = false ) {

		$term = get_queried_object();

		if ( isset( $term->taxonomy ) ) {
			$value = get_term_meta( $term->term_id, $field, $bool );
		}
		else {
			$value = get_post_meta( get_the_ID(), $field, $bool );
		}

		if ( $esc ) {
			$value = esc_html( $value );
		}

		if ( $value ) {
			return $value;
		}
		return false;
	}
}

if ( ! function_exists( 'acf_field' ) ) {
	function acf_field( $field, $bool = false, $esc = false ) {
		$value = get_acf_field( $field, $bool, $esc );
		if ( $value ) {
			echo $value;
		}
	}
}

/* 5. Excerpts */
add_filter( 'excerpt_more', 'understrap_custom_excerpt_more' );
if ( ! function_exists( 'understrap_custom_excerpt_more' ) ) {
	// Removes the ... from the excerpt read more link
	function understrap_custom_excerpt_more( $more ) {
		if ( ! is_admin() ) {
			$more = '';
		}
		return $more;
	}
}
add_filter( 'wp_trim_excerpt', 'understrap_all_excerpts_get_more_link' );
if ( ! function_exists( 'understrap_all_excerpts_get_more_link' ) ) {
	// Adds a custom read more link to all excerpts, manually or automatically generated
	function understrap_all_excerpts_get_more_link( $post_excerpt ) {
		if ( ! is_admin() ) {
			$post_excerpt = $post_excerpt . '<p class=""><a class="btn-link understrap-read-more-link read-more-link" href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . __( 'Read More', 'understrap' ) . '</a></p>';
		}
		return $post_excerpt;
	}
}

/* 6. Hooks */
add_action( 'understrap_site_info', 'understrap_add_site_info' );
if ( ! function_exists( 'understrap_add_site_info' ) ) {
	// Add site info content. Overwrites parent 'understrap_add_site_info' function.
	function understrap_add_site_info() {
		$site_info = sprintf(
            '%1$s &copy; %2$d %3$s. %4$s.',
            esc_html__( 'Copyright', 'aethercomm' ),
            date( 'Y' ),
            esc_html__( 'Aethercomm', 'aethercomm' ),
            esc_html__( 'All Rights Reserved', 'aethercomm' )
		);
		echo apply_filters( 'understrap_site_info_content', $site_info ); // WPCS: XSS ok.
	}
}
