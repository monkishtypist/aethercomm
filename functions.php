<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Table of contents
 *
 * 0. Requires...
 * 1. Child theme Scripts and Styles
 * 2. Theme Setup
 *      Textdomain
 *      Nav Menu Location(s)
 *      Remove Understrap Widgets
 * 3. Bootstrap Image classes
 * 4. Advanced Custom Fields setup
 * 5. Excerpts
 * 6. Hooks
 * 7. Custom Post Types
 * 8. Modify the Query
 * Widgets
 */

/* 0. Requires... */

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

/* 2. Theme Setup */
add_action( 'after_setup_theme', 'aethercomm_after_setup_theme' );
if ( ! function_exists( 'aethercomm_after_setup_theme' ) ) {
    function aethercomm_after_setup_theme() {
        // Load child theme text-domain
        load_child_theme_textdomain( 'aethercomm', get_stylesheet_directory() . '/languages' );
        // Add custom wp_nav_menu() locations.
        register_nav_menus( array(
            'footer' => __( 'Footer Menu', 'aethercomm' ),
            'legal' => __( 'Legal Menu', 'aethercomm' ),
        ) );
        // custom image sizes
        add_image_size( 'card-img-top', 400, 300, true );
    }
}
// add_action( 'wp_loaded', 'aethercomm_wp_loaded' );
if ( ! function_exists( 'aethercomm_wp_loaded' ) ) {
    function aethercomm_wp_loaded() {
    }
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
	function get_acf_field( $field, $single = false, $esc = false ) {

        $term = get_queried_object();

        $id = isset( $term->taxonomy )
            ? $term->term_id
            : get_the_ID();

        $value = get_post_meta( $id, $field, $single );

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
	function acf_field( $field, $single = true, $esc = false ) {
		$value = get_acf_field( $field, $single, $esc );
		if ( $value ) {
            echo ( $single
                ? wpautop( $value )
                : $value
            );
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
			$post_excerpt = $post_excerpt . '<a class="btn btn-read-more aethercomm-read-more-link read-more-link" href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . __( 'Read More', 'aethercomm' ) . '</a>';
		}
		return $post_excerpt;
	}
}

/* 6. Hooks */
if ( ! function_exists( 'aethercomm_site_info' ) ) {
	function aethercomm_site_info() {
		do_action( 'aethercomm_site_info' );
	}
}
add_action( 'aethercomm_site_info', 'aethercomm_add_site_info' );
if ( ! function_exists( 'aethercomm_add_site_info' ) ) {
	function aethercomm_add_site_info() {
		$site_info = sprintf(
            '%1$s &copy; %2$d %3$s. %4$s.',
            esc_html__( 'Copyright', 'aethercomm' ),
            date( 'Y' ),
            esc_html__( 'Aethercomm', 'aethercomm' ),
            esc_html__( 'All Rights Reserved', 'aethercomm' )
		);
		echo apply_filters( 'aethercomm_site_info_content', $site_info ); // WPCS: XSS ok.
	}
}

/* 7. Custom Post Types */
add_action( 'init', 'aethercomm_products_post_type' );
if ( ! function_exists( 'aethercomm_products_post_type' ) ) {
    function aethercomm_products_post_type() {
        $labels = array(
            'name'                  => _x( 'Products', 'aethercomm_products_post_type', 'aethercomm' ),
            'singular_name'         => _x( 'Product', 'aethercomm_products_post_type', 'aethercomm' ),
            'menu_name'             => _x( 'Products', 'aethercomm_products_post_type', 'aethercomm' ),
            'name_admin_bar'        => _x( 'Products', 'aethercomm_products_post_type', 'aethercomm' ),
            'archives'              => __( 'Item Archives', 'aethercomm' ),
            'parent_item_colon'     => __( 'Parent Item:', 'aethercomm' ),
            'all_items'             => __( 'All Products', 'aethercomm' ),
            'add_new_item'          => __( 'Add New Product', 'aethercomm' ),
            'add_new'               => __( 'Add New', 'aethercomm' ),
            'new_item'              => __( 'New Product', 'aethercomm' ),
            'edit_item'             => __( 'Edit Product', 'aethercomm' ),
            'update_item'           => __( 'Update Product', 'aethercomm' ),
            'view_item'             => __( 'View Product', 'aethercomm' ),
            'search_items'          => __( 'Search Products', 'aethercomm' ),
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
            'slug'                  => 'product',
            'with_front'            => false,
            'pages'                 => true,
            'feeds'                 => false,
        );
        $args = array(
            'label'                 => _x( 'Products', 'aethercomm_products_post_type', 'aethercomm' ),
            'description'           => __( 'Company Product Page', 'aethercomm' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
            'taxonomies'            => array( 'product-categories' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-cart',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'rewrite'               => $rewrite,
            'capability_type'       => 'page',
        );
        register_post_type( 'products', $args );
    }
}

add_action( 'init', 'aethercomm_product_cats_tax_init' );
if ( ! function_exists( 'aethercomm_product_cats_tax_init' ) ) {
    function aethercomm_product_cats_tax_init() {

        $labels = array(
            'name'                       => _x( 'Product Categories', 'far_productmembers_post_type', 'aethercomm' ),
            'singular_name'              => _x( 'Product Category', 'far_productmembers_post_type', 'aethercomm' ),
            'search_items'               => __( 'Search Product Categories', 'aethercomm' ),
            'popular_items'              => __( 'Popular Product Categories', 'aethercomm' ),
            'all_items'                  => __( 'All Product Categories', 'aethercomm' ),
            'parent_item'                => __( 'Parent Product Category', 'aethercomm' ),
            'parent_item_colon'          => __( 'Parent Product Category:', 'aethercomm' ),
            'edit_item'                  => __( 'Edit Product Category', 'aethercomm' ),
            'view_item'                  => __( 'View Product Category', 'aethercomm' ),
            'update_item'                => __( 'Update Product Category', 'aethercomm' ),
            'add_new_item'               => __( 'Add New Product Category', 'aethercomm' ),
            'new_item_name'              => __( 'New Position', 'aethercomm' ),
            'separate_items_with_commas' => __( 'Separate product categories with commas', 'aethercomm' ),
            'add_or_remove_items'        => __( 'Add or remove product categories', 'aethercomm' ),
            'choose_from_most_used'      => __( 'Choose from the most used product categories', 'aethercomm' ),
            'not_found'                  => __( 'No product categories found', 'aethercomm' ),
            'no_terms'                   => __( 'No product categories', 'aethercomm' ),
            'items_list_navigation'      => __( 'Items list navigation', 'aethercomm' ),
            'items_list'                 => __( 'Items list', 'aethercomm' ),
            'most_used'                  => __( 'Most Used', 'aethercomm' ),
            'back_to_terms'              => __( 'Back to product categories', 'aethercomm' ),
        );
        $rewrite = array(
            'slug'                       => 'product-categories',
            'with_front'                 => false,
            'hierarchical'               => true
        );
        $args = array(
            'labels'                     => $labels,
            'description'                => __( 'Product categories', 'aethercomm' ),
            'public'                     => true,
            'publicly_queryable'         => true,
            'hierarchical'               => true,
            'show_ui'                    => true,
            'show_in_menu'               => true,
            'show_in_nav_menus'          => true,
            'show_admin_column'          => true,
            'rewrite'                    => $rewrite
        );

        register_taxonomy( 'product-categories', 'products', $args );
    }
}

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
            'menu_icon'             => 'dashicons-businessman',
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

add_action( 'init', 'aethercomm_representative_post_type' );
if ( ! function_exists( 'aethercomm_representative_post_type' ) ) {
    function aethercomm_representative_post_type() {
        $labels = array(
            'name'                  => _x( 'Representatives', 'aethercomm_representatives_post_type', 'aethercomm' ),
            'singular_name'         => _x( 'Representative', 'aethercomm_representatives_post_type', 'aethercomm' ),
            'menu_name'             => _x( 'Representatives', 'aethercomm_representatives_post_type', 'aethercomm' ),
            'name_admin_bar'        => _x( 'Representatives', 'aethercomm_representatives_post_type', 'aethercomm' ),
            'archives'              => __( 'Item Archives', 'aethercomm' ),
            'parent_item_colon'     => __( 'Parent Item:', 'aethercomm' ),
            'all_items'             => __( 'All Representatives', 'aethercomm' ),
            'add_new_item'          => __( 'Add New Representative', 'aethercomm' ),
            'add_new'               => __( 'Add New', 'aethercomm' ),
            'new_item'              => __( 'New Representative', 'aethercomm' ),
            'edit_item'             => __( 'Edit Representative', 'aethercomm' ),
            'update_item'           => __( 'Update Representative', 'aethercomm' ),
            'view_item'             => __( 'View Representative', 'aethercomm' ),
            'search_items'          => __( 'Search Representatives', 'aethercomm' ),
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
            'slug'                  => 'representative',
            'with_front'            => false,
            'pages'                 => true,
            'feeds'                 => false,
        );
        $args = array(
            'label'                 => _x( 'Representatives', 'aethercomm_representatives_post_type', 'aethercomm' ),
            'description'           => __( 'Company Representative Profile Page', 'aethercomm' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
            'taxonomies'            => array( '' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-groups',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'rewrite'               => $rewrite,
            'capability_type'       => 'page',
        );
        register_post_type( 'representatives', $args );
    }
}

/* 8. Modify the Query */
add_action( 'pre_get_posts', 'aethercomm_modify_query', 1 );
if ( ! function_exists( 'aethercomm_modify_query' ) ) {
    function aethercomm_modify_query( $query ) {
        if ( is_admin() || ! $query->is_main_query() )
            return;

        if ( is_tax( 'team-members' ) ) {
            // Display 20 posts for custom post type
            $query->set( 'posts_per_page', 20 );
            return;
        }

        if ( $query->is_home() && $query->is_main_query() ) {
            // Offset the main query by one
            $query->set( 'offset', 1 );
        }
    }
}

/* Widgets */
add_action( 'widgets_init', 'understrap_widgets_init' );
if ( ! function_exists( 'understrap_widgets_init' ) ) {
    // Overwrite parent theme widgets function
	function understrap_widgets_init() {
		register_sidebar(
			array(
				'name'          => __( 'Blog Sidebar', 'aethercomm' ),
				'id'            => 'blog-sidebar',
				'description'   => __( 'Blog left sidebar widget area', 'aethercomm' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Footer Content', 'aethercomm' ),
				'id'            => 'footer-content',
				'description'   => __( 'Content below footer menu', 'aethercomm' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
				'after_widget'  => '</div><!-- .footer-widget -->',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Social Icons', 'aethercomm' ),
				'id'            => 'social-icons',
				'description'   => __( 'Various social icon placements', 'aethercomm' ),
				'before_widget' => '<div id="%1$s" class="social-icons-widget %2$s">',
				'after_widget'  => '</div><!-- .social-icons-widget -->',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Contact Form', 'aethercomm' ),
				'id'            => 'contact',
				'description'   => __( 'Contact form section', 'aethercomm' ),
				'before_widget' => '<div id="%1$s" class="contact-widget %2$s">',
				'after_widget'  => '</div><!-- .contact-widget -->',
				'before_title'  => '<h3 class="widget-title sr-only">',
				'after_title'   => '</h3>',
			)
		);

	}
}
