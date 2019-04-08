<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Table of contents
 *
 * 0. Requires...
 * 1. Child theme Scripts and Styles
 * 2. After Setup Theme
 *      Textdomain
 *      Nav Menu Location(s)
 * 3. Bootstrap Image classes
 * 4. Advanced Custom Fields setup
 * 5. Excerpts
 * 6. Hooks
 * 7. Custom Post Types
 * 8. Modify the Query
 */

/* 0. Requires... */
// require get_stylesheet_directory_uri() . '/inc/class-team-members.php';

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

/* 7. Custom Post Types */
add_action( 'init', 'aethercomm_teammember_post_type' );
if ( ! function_exists( 'aethercomm_teammember_post_type' ) ) {
    function aethercomm_teammember_post_type() {
        $labels = array(
            'name'                  => _x( 'Team Members', 'aethercomm_teammembers_post_type', 'aethercomm' ),
            'singular_name'         => _x( 'Team Member', 'aethercomm_teammembers_post_type', 'aethercomm' ),
            'menu_name'             => _x( 'Team Members', 'aethercomm_teammembers_post_type', 'aethercomm' ),
            'name_admin_bar'        => _x( 'Team Members', 'aethercomm_teammembers_post_type', 'aethercomm' ),
            'archives'              => __( 'Item Archives', 'aethercomm' ),
            'parent_item_colon'     => __( 'Parent Item:', 'aethercomm' ),
            'all_items'             => __( 'All Team Members', 'aethercomm' ),
            'add_new_item'          => __( 'Add New Team Member', 'aethercomm' ),
            'add_new'               => __( 'Add New', 'aethercomm' ),
            'new_item'              => __( 'New Team Member', 'aethercomm' ),
            'edit_item'             => __( 'Edit Team Member', 'aethercomm' ),
            'update_item'           => __( 'Update Team Member', 'aethercomm' ),
            'view_item'             => __( 'View Team Member', 'aethercomm' ),
            'search_items'          => __( 'Search Team Members', 'aethercomm' ),
            'not_found'             => __( 'Not found', 'aethercomm' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'aethercomm' ),
            'featured_image'        => __( 'Featured Image', 'aethercomm' ),
            'set_featured_image'    => __( 'Set featured image', 'aethercomm' ),
            'remove_featured_image' => __( 'Remove featured image', 'aethercomm' ),
            'use_featured_image'    => __( 'Use as featured image', 'aethercomm' ),
            'insert_into_item'      => __( 'Insert into item', 'aethercomm' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'aethercomm' ),
            'items_list'            => __( 'Items list', 'aethercomm' ),
            'items_list_navigation' => __( 'Items list navigation', 'aethercomm' ),
            'filter_items_list'     => __( 'Filter items list', 'aethercomm' ),
        );
        $rewrite = array(
            'slug'                  => 'team-member',
            'with_front'            => false,
            'pages'                 => true,
            'feeds'                 => false,
        );
        $args = array(
            'label'                 => _x( 'Team Members', 'aethercomm_teammembers_post_type', 'aethercomm' ),
            'description'           => __( 'Company Team Member Profile Page', 'aethercomm' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
            'taxonomies'            => array( '' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-nametag',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'rewrite'               => $rewrite,
            'capability_type'       => 'page',
        );
        register_post_type( 'team-members', $args );
    }
}

/* 8. Modify the Query */
if ( ! function_exists( 'modify_query' ) ) {
    function modify_query( $query ) {
        if ( is_admin() || ! $query->is_main_query() )
            return;

        if ( is_tax( 'team-members' ) ) {
            // Display 20 posts for custom post type
            $query->set( 'posts_per_page', 20 );
            return;
        }
    }
}
