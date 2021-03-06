<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Table of contents
 *
 * 0. Defines...
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
 * 9. Pagination
 * 10. Widgets
 * 11. Gravity Forms
 */

/* 0. Defines... */
define( 'PRODUCTS_PAGE_PARENT_ID', '19' );
define( 'NEWS_PAGE_PARENT_ID', '21' );

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
    wp_localize_script( 'aethercomm-scripts', 'aethercomm_ajax_obj', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    // wp_enqueue_script( 'datatables-scripts', get_stylesheet_directory_uri() . '/datatables/datatables.min.js', array(), $the_theme->get( 'Version' ), true );
    // wp_enqueue_style( 'datatables-styles', get_stylesheet_directory_uri() . '/datatables/datatables.min.css', array(), $the_theme->get( 'Version' ) );
}

/* 2. Theme Setup */
add_action( 'after_setup_theme', 'aethercomm_after_setup_theme' );
if ( ! function_exists( 'aethercomm_after_setup_theme' ) ) {
    function aethercomm_after_setup_theme() {
        // Load child theme text-domain
        load_child_theme_textdomain( 'aethercomm', get_stylesheet_directory() . '/languages' );
        // Add custom wp_nav_menu() locations.
        register_nav_menus( array(
            'primary-mobile' => __( 'Mobile Main Menu', 'aethercomm' ),
            'footer' => __( 'Footer Menu', 'aethercomm' ),
            'legal' => __( 'Legal Menu', 'aethercomm' ),
        ) );
        // custom image sizes
        add_image_size( 'card-img-top', 400, 300, true );
        add_image_size( 'posts-archive', 532, 334, true );
    }
}
// add_action( 'wp_loaded', 'aethercomm_wp_loaded' );
if ( ! function_exists( 'aethercomm_wp_loaded' ) ) {
    function aethercomm_wp_loaded() {
    }
}

// REMOVE EMOJI ICONS
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/**
 * Custom Button
 *
 * Add an inline button to content, with customizeable CSS classes, and
 * link to a page by `page-id` or URL.
 *
 * [button class="btn-primary"]My Button Text[/button]
 *
 * @param array $atts Button attributes
 * @param string $content Button text content
 *
 * @return string Button HTML
 */
add_shortcode( 'button', 'aethercomm_button_shortcode', 10, 2 );
if ( ! function_exists( 'aethercomm_button_shortcode' ) ) {
    function aethercomm_button_shortcode( $atts, $content ) {

        if ( function_exists( 'openssl_random_pseudo_bytes' ) && function_exists( 'bin2hex' ) ) {
            $rand = bin2hex( openssl_random_pseudo_bytes( 8 ) );;
        } else {
            $rand = rand( 1000, 9999 );
        }

        $a = shortcode_atts( array(
            'attr'      => false,                   // Additional attributes as Key:Value pairs, comma separated
            'class'     => 'btn-primary d-block',   // CSS classes for button element
            'hash'      => false,                   // #string
            'icon'      => false,                   // not used
            'icon-url'  => false,                   // not used
            'id'        => 'button-' . $rand,       // button id
            'logged-in' => false,                   // is user logged in?
            'modal'     => false,                   // Bootstrap modal target
            'page-id'   => false,                   // Page ID of linked page
            'query'     => false,                   // URL query params
            'target'    => '',                      // Attr: target="_blank"
            'url'       => '#'                      // Linked page URL
        ), $atts );

        $attributes_array = array();
        if ( $a['attr'] ) {
            $attribs = explode( ",", $a['attr'] );
            foreach ($attribs as $attrib) {
                if ( strpos( $attrib, ':' ) !== false ) {
                    $arr = explode( ":", $attrib );
                    $attributes_array[ $arr[0] ] = $arr[1];
                }
            }
        }
        $attributes_string = null;
        foreach ($attributes_array as $key => $value) {
            $attributes_string .= sprintf( '%1$s="%2$s" ', $key, $value );
        }

        $target = null;
        if ( in_array( $a['target'], array( 'blank', '_blank' ) ) )
            $target = 'target="_blank"';

        if ( $a['modal'] )
            $target = 'data-toggle="modal" data-target="' . $a['modal'] . '"';

        // if page-id attribute is set, use that instead of link, otherwise, use link attribute.
        $url = ( $a['page-id'] && 'publish' === get_post_status( $a['page-id'] ) ? get_permalink( $a['page-id'] ) : esc_html( $a['url'] ) );

        $hash = null;
        if ( $a['hash'] ) {
            $hash .= '#' . rawurlencode( $a['hash'] );
        }

        $query = null;
        if ( $a['query'] ) {
            $query .= '?' . rawurlencode( $a['query'] );
        }

        // Build the button HTML

        $button_html = sprintf( '<a href="%1$s" id="%2$s" class="btn %3$s" %4$s>%5$s</a>',
            $url . $hash . $query,                                // build the URL
            esc_html( $a['id'] ),
            esc_html( $a['class'] ),
            $attributes_string . ' ' . $target,                   // build attributes
            sprintf( '<span>%1$s</span>', esc_html( $content ) )
        );

        return $button_html;
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
if ( ! function_exists( 'has_acf_field' ) ) {
    // Check if ACF field exists using WP core functions
	function has_acf_field( $field ) {

        $term = get_queried_object();

        $id = isset( $term->taxonomy )
            ? $term->term_id
            : get_the_ID();

        $value = get_post_meta( $id, $field );

        if ( is_array( $value ) )
            $value = array_filter( $value );

		if ( isset( $value ) && ! empty( $value ) )
			return true;

        return false;
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
            $read_more_link = sprintf( ' <a class="aethercomm-read-more-link read-more-link" href="%1$s">%2$s</a>',
                esc_url( get_permalink( get_the_ID() ) ),
                sprintf( '<span class="readmore-read">%1$s </span><span class="readmore-more">%2$s</span>',
                    __( 'Read', 'aethercomm' ),
                    __( 'More', 'aethercomm' )
                )
            );
			$post_excerpt = $post_excerpt . $read_more_link;
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

if ( ! function_exists( 'get_representative_by_keyword' ) ) {
    function get_representative_by_keyword( $search_string = false ) {

        if ( ! $search_string ) return false;

        // Q1: Search by keyword
        $args = array(
            'post_type' => 'representatives',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            's' => $search_string
        );

        $query = new WP_Query( $args );

        // echo( '<pre style="color: #fff;">' );
        // print_r( $query->query );
        // print_r( $query->posts );
        // echo( '</pre>' );

        return $query;
    }
}

if ( ! function_exists( 'get_representative_by_postal_code' ) ) {
    function get_representative_by_postal_code( $search_string = false ) {

        $args = array(
            'post_type' => 'representatives',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'cpt_rep_coverage_area_postal_code_start',
                    'value' => $search_string,
                    'compare' => '<=',
                    'type' => 'NUMERIC'
                ),
                array(
                    'key' => 'cpt_rep_coverage_area_postal_code_end',
                    'value' => $search_string,
                    'compare' => '>=',
                    'type' => 'NUMERIC'
                )
            )
        );

        $query = new WP_Query( $args );

        // echo( '<pre style="color: #fff;">' );
        // print_r( $query->query );
        // print_r( $query->posts );
        // echo( '</pre>' );

        return $query;
    }
}

if ( ! function_exists( 'get_representative_by_email' ) ) {
    function get_representative_by_email( $search_string = false ) {

        $args = array(
            'post_type' => 'representatives',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'cpt_rep_email',
                    'value' => $search_string,
                    'compare' => 'LIKE'
                )
            )
        );

        $query = new WP_Query( $args );

        // echo( '<pre style="color: #fff;">' );
        // print_r( $query->query );
        // print_r( $query->posts );
        // echo( '</pre>' );

        return $query;
    }
}

add_action('wp_ajax_filter_representatives', 'aethercomm_filter_representatives_function'); // wp_ajax_{ACTION HERE}
add_action('wp_ajax_nopriv_filter_representatives', 'aethercomm_filter_representatives_function');
if ( ! function_exists( 'aethercomm_filter_representatives_function' ) ) {
    function aethercomm_filter_representatives_function() {

        if ( isset( $_POST['rep-filter-input'] ) && ! empty( $_POST['rep-filter-input'] ) ) {

            $query1 = get_representative_by_keyword( $_POST['rep-filter-input'] );
            $query2 = get_representative_by_postal_code( $_POST['rep-filter-input'] );
            $query3 = get_representative_by_email( $_POST['rep-filter-input'] );

            $merged_query = new WP_Query();
            $merged_query->posts = array_unique( array_merge( $query1->posts, $query2->posts, $query3->posts ), SORT_REGULAR );
            $merged_query->post_count = count( $merged_query->posts );

            if( $merged_query->have_posts() ) :
                while( $merged_query->have_posts() ): $merged_query->the_post();
                    get_template_part( 'loop-templates/content', 'card' );
                endwhile;
                wp_reset_postdata();
            endif;
        } else {
            return new HttpStatusCodeResult(410, "Search returned no result.");
        }

        die();
    }
}

/* 7. Custom Post Types */
// CPT products
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
            'slug'                  => _x( 'products', 'aethercomm_products_post_type', 'aethercomm' ),
            'with_front'            => false,
            'pages'                 => true,
            'feeds'                 => false,
        );
        $args = array(
            'label'                 => _x( 'Products', 'aethercomm_products_post_type', 'aethercomm' ),
            'description'           => __( 'Company Product Page', 'aethercomm' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes' ),
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

// Set the Products post type parent page
add_action( 'wp_insert_post_data', 'aethercomm_products_cpt_parent_page', '99', 2  );
if ( ! function_exists( 'aethercomm_products_cpt_parent_page' ) ) {
    function aethercomm_products_cpt_parent_page( $data, $postarr ) {
        global $post;

        // verify if this is an auto save routine.
        // If it is our form has not been submitted, so we dont want to do anything
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return $data;

        if ( $post->post_type == 'products' ){
            $data['post_parent'] = PRODUCTS_PAGE_PARENT_ID ;
        }

        return $data;
    }
}

// Add ancestor menu classes
add_filter( 'nav_menu_css_class' , 'aethercomm_nav_menu_css_class', 10, 2 );
if ( ! function_exists( 'aethercomm_nav_menu_css_class' ) ) {
    function aethercomm_nav_menu_css_class( $classes, $item ){

        $post = get_post();
        if ( !$post )
            return $classes;

        // if on a Products CPT, add ancestor class to the 'products' page menu items
        if ( $item->object_id == $post->post_parent && get_post_type() == 'products' ) {
            $classes[] = 'current_page_parent';
            $classes[] = 'current_page_ancestor';
            $classes[] = 'current-page-ancestor';
            $classes[] = 'current-menu-ancestor';
        }

        // if on a Products CPT, remove parent class from the 'news' page menu items
        if ( ( is_post_type_archive( 'products' ) || is_singular( 'products' ) ) && $item->object_id == NEWS_PAGE_PARENT_ID ) {
            $classes = array_diff( $classes, array( 'current_page_parent' ) );
        }

        return $classes;
    }
}

// Add the custom columns to the Products post type:
add_filter( 'manage_products_posts_columns', 'aethercomm_set_custom_edit_products_columns' );
if ( ! function_exists( 'aethercomm_set_custom_edit_products_columns' ) ) {
    function aethercomm_set_custom_edit_products_columns($columns) {
        $columns['model_number'] = __( 'Part Number', 'aethercomm' );
        return $columns;
    }
}

// Add the data to the custom columns for the Products post type:
add_action( 'manage_products_posts_custom_column' , 'aethercomm_custom_products_column', 10, 2 );
if ( ! function_exists( 'aethercomm_custom_products_column' ) ) {
    function aethercomm_custom_products_column( $column, $post_id ) {
        switch ( $column ) {
            case 'model_number' :
                echo get_acf_field( 'product_specs_model_number', true );
                break;

        }
    }
}

// CPT products tax
add_action( 'init', 'aethercomm_product_cats_tax_init' );
if ( ! function_exists( 'aethercomm_product_cats_tax_init' ) ) {
    function aethercomm_product_cats_tax_init() {

        $labels = array(
            'name'                       => _x( 'Product Categories', 'far_products_post_type', 'aethercomm' ),
            'singular_name'              => _x( 'Product Category', 'far_products_post_type', 'aethercomm' ),
            'search_items'               => __( 'Search Product Categories', 'aethercomm' ),
            'popular_items'              => __( 'Popular Product Categories', 'aethercomm' ),
            'all_items'                  => __( 'All Product Categories', 'aethercomm' ),
            'parent_item'                => __( 'Parent Product Category', 'aethercomm' ),
            'parent_item_colon'          => __( 'Parent Product Category:', 'aethercomm' ),
            'edit_item'                  => __( 'Edit Product Category', 'aethercomm' ),
            'view_item'                  => __( 'View Product Category', 'aethercomm' ),
            'update_item'                => __( 'Update Product Category', 'aethercomm' ),
            'add_new_item'               => __( 'Add New Product Category', 'aethercomm' ),
            'new_item_name'              => __( 'New Product', 'aethercomm' ),
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
            'slug'                       => 'products',
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

// CPT team members
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

// CPT representative
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

// CPT timeline
add_action( 'init', 'aethercomm_timeline_post_type' );
if ( ! function_exists( 'aethercomm_timeline_post_type' ) ) {
    function aethercomm_timeline_post_type() {
        $labels = array(
            'name'                  => _x( 'Timelines', 'aethercomm_timelines_post_type', 'aethercomm' ),
            'singular_name'         => _x( 'timeline', 'aethercomm_timelines_post_type', 'aethercomm' ),
            'menu_name'             => _x( 'Timelines', 'aethercomm_timelines_post_type', 'aethercomm' ),
            'name_admin_bar'        => _x( 'Timelines', 'aethercomm_timelines_post_type', 'aethercomm' ),
            'archives'              => __( 'Item Archives', 'aethercomm' ),
            'parent_item_colon'     => __( 'Parent Item:', 'aethercomm' ),
            'all_items'             => __( 'All Timelines', 'aethercomm' ),
            'add_new_item'          => __( 'Add New timeline', 'aethercomm' ),
            'add_new'               => __( 'Add New', 'aethercomm' ),
            'new_item'              => __( 'New timeline', 'aethercomm' ),
            'edit_item'             => __( 'Edit timeline', 'aethercomm' ),
            'update_item'           => __( 'Update timeline', 'aethercomm' ),
            'view_item'             => __( 'View timeline', 'aethercomm' ),
            'search_items'          => __( 'Search Timelines', 'aethercomm' ),
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
            'slug'                  => 'timeline',
            'with_front'            => false,
            'pages'                 => true,
            'feeds'                 => false,
        );
        $args = array(
            'label'                 => _x( 'Timelines', 'aethercomm_timelines_post_type', 'aethercomm' ),
            'description'           => __( 'Company timeline Profile Page', 'aethercomm' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
            'taxonomies'            => array( '' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-performance',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'rewrite'               => $rewrite,
            'capability_type'       => 'page',
        );
        register_post_type( 'timelines', $args );
    }
}

// CPT timline tax
add_action( 'init', 'aethercomm_timline_cats_tax_init' );
if ( ! function_exists( 'aethercomm_timline_cats_tax_init' ) ) {
    function aethercomm_timline_cats_tax_init() {

        $labels = array(
            'name'                       => _x( 'Timeline Categories', 'far_timeline_post_type', 'aethercomm' ),
            'singular_name'              => _x( 'Timeline Category', 'far_timeline_post_type', 'aethercomm' ),
            'search_items'               => __( 'Search Timeline Categories', 'aethercomm' ),
            'popular_items'              => __( 'Popular Timeline Categories', 'aethercomm' ),
            'all_items'                  => __( 'All Timeline Categories', 'aethercomm' ),
            'parent_item'                => __( 'Parent Timeline Category', 'aethercomm' ),
            'parent_item_colon'          => __( 'Parent Timeline Category:', 'aethercomm' ),
            'edit_item'                  => __( 'Edit Timeline Category', 'aethercomm' ),
            'view_item'                  => __( 'View Timeline Category', 'aethercomm' ),
            'update_item'                => __( 'Update Timeline Category', 'aethercomm' ),
            'add_new_item'               => __( 'Add New Timeline Category', 'aethercomm' ),
            'new_item_name'              => __( 'New Timeline', 'aethercomm' ),
            'separate_items_with_commas' => __( 'Separate timeline categories with commas', 'aethercomm' ),
            'add_or_remove_items'        => __( 'Add or remove timeline categories', 'aethercomm' ),
            'choose_from_most_used'      => __( 'Choose from the most used timeline categories', 'aethercomm' ),
            'not_found'                  => __( 'No timeline categories found', 'aethercomm' ),
            'no_terms'                   => __( 'No timeline categories', 'aethercomm' ),
            'items_list_navigation'      => __( 'Items list navigation', 'aethercomm' ),
            'items_list'                 => __( 'Items list', 'aethercomm' ),
            'most_used'                  => __( 'Most Used', 'aethercomm' ),
            'back_to_terms'              => __( 'Back to timeline categories', 'aethercomm' ),
        );
        $rewrite = array(
            'slug'                       => 'timelines',
            'with_front'                 => false,
            'hierarchical'               => false
        );
        $args = array(
            'labels'                     => $labels,
            'description'                => __( 'Timeline categories', 'aethercomm' ),
            'public'                     => true,
            'publicly_queryable'         => true,
            'hierarchical'               => false,
            'show_ui'                    => true,
            'show_in_menu'               => true,
            'show_in_nav_menus'          => true,
            'show_admin_column'          => true,
            'rewrite'                    => $rewrite
        );

        register_taxonomy( 'timeline-categories', 'timelines', $args );
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
            $offset = 1;
            $ppp = get_option('posts_per_page');
            if ( $query->is_paged ) {
                //Manually determine page query offset (offset + current page (minus one) x posts per page)
                $page_offset = $offset + ( ($query->query_vars['paged']-1) * $ppp );
                //Apply adjust page offset
                $query->set('offset', $page_offset );
            }
            else {
                //This is the first page. Just use the offset...
                $query->set('offset',$offset);
            }
        }
    }
}

// add custom query variables
add_filter( 'query_vars', 'aethercomm_add_query_vars_filter' );
if ( ! function_exists( 'aethercomm_add_query_vars_filter' ) ) {
    function aethercomm_add_query_vars_filter( $vars ) {
        $vars[] = "productsearch";
        return $vars;
    }
}

/* 9. Pagination */
add_filter('found_posts', 'aethercomm_adjust_offset_pagination', 1, 2 );
function aethercomm_adjust_offset_pagination( $found_posts, $query ) {
    $offset = 1;
    if ( $query->is_home() ) {
        return $found_posts - $offset;
    }
    return $found_posts;
}

/* 10. Widgets */
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

		register_sidebar(
			array(
				'name'          => __( 'Request Product Form', 'aethercomm' ),
				'id'            => 'request-product',
				'description'   => __( 'Request Product form section', 'aethercomm' ),
				'before_widget' => '<div id="%1$s" class="request-product-widget %2$s">',
				'after_widget'  => '</div><!-- .request-product-widget -->',
				'before_title'  => '<h3 class="widget-title sr-only">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Blog Sidebar', 'aethercomm' ),
				'id'            => 'blog',
				'description'   => __( 'Left sidebar on blog pages', 'aethercomm' ),
				'before_widget' => '<div id="%1$s" class="blog-widget %2$s">',
				'after_widget'  => '</div><!-- .blog-widget -->',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

	}
}

/* 11. Gravity Forms */
add_filter( 'gform_confirmation_anchor', '__return_true' );

// Allow the Gravity form to stay on the page when confirmation displays.
add_filter( 'gform_pre_submission_filter', 'aethercomm_show_confirmation_and_form' );
if ( ! function_exists( 'aethercomm_show_confirmation_and_form' ) ) {
    function aethercomm_show_confirmation_and_form( $form ) {
        $shortcode = '[gravityform id="' . $form['id'] . '" title="false" description="false" ajax="true"]';

        if ( array_key_exists( 'confirmations', $form ) ) {
            foreach ( $form['confirmations'] as $key => $confirmation ) {
                $form['confirmations'][ $key ]['message'] = sprintf( '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">%1$s<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>%2$s',
                    $form['confirmations'][ $key ]['message'],
                    $shortcode );
            }
        }

        return $form;
    }
}
