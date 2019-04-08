<?php
/**
 * Add Team Members custom post type (CPT)
 */

if ( ! class_exists( 'AethercommTeamMembers' ) ) :

	class AethercommTeamMembers {

		private $textdomain = 'aethercomm';

		public function __construct() {

			/**
			 * Register team member post type
			 */
			add_action( 'init', array( $this, 'teammember_post_type') );

			/**
			 * Alter the query
			 */
			add_action( 'pre_get_posts', array( $this, 'modify_query' ), 1 );

		}

		/**
		 * Register post type
		 */
		public function teammember_post_type() {

			$labels = array(
				'name'                  => _x( 'Team Members', 'aethercomm_teammembers_post_type', $this->textdomain ),
				'singular_name'         => _x( 'Team Member', 'aethercomm_teammembers_post_type', $this->textdomain ),
				'menu_name'             => _x( 'Team Members', 'aethercomm_teammembers_post_type', $this->textdomain ),
				'name_admin_bar'        => _x( 'Team Members', 'aethercomm_teammembers_post_type', $this->textdomain ),
				'archives'              => __( 'Item Archives', $this->textdomain ),
				'parent_item_colon'     => __( 'Parent Item:', $this->textdomain ),
				'all_items'             => __( 'All Team Members', $this->textdomain ),
				'add_new_item'          => __( 'Add New Team Member', $this->textdomain ),
				'add_new'               => __( 'Add New', $this->textdomain ),
				'new_item'              => __( 'New Team Member', $this->textdomain ),
				'edit_item'             => __( 'Edit Team Member', $this->textdomain ),
				'update_item'           => __( 'Update Team Member', $this->textdomain ),
				'view_item'             => __( 'View Team Member', $this->textdomain ),
				'search_items'          => __( 'Search Team Members', $this->textdomain ),
				'not_found'             => __( 'Not found', $this->textdomain ),
				'not_found_in_trash'    => __( 'Not found in Trash', $this->textdomain ),
				'featured_image'        => __( 'Featured Image', $this->textdomain ),
				'set_featured_image'    => __( 'Set featured image', $this->textdomain ),
				'remove_featured_image' => __( 'Remove featured image', $this->textdomain ),
				'use_featured_image'    => __( 'Use as featured image', $this->textdomain ),
				'insert_into_item'      => __( 'Insert into item', $this->textdomain ),
				'uploaded_to_this_item' => __( 'Uploaded to this item', $this->textdomain ),
				'items_list'            => __( 'Items list', $this->textdomain ),
				'items_list_navigation' => __( 'Items list navigation', $this->textdomain ),
				'filter_items_list'     => __( 'Filter items list', $this->textdomain ),
			);
			$rewrite = array(
				'slug'                  => 'team-member',
				'with_front'            => false,
				'pages'                 => true,
				'feeds'                 => false,
			);
			$args = array(
				'label'                 => _x( 'Team Members', 'aethercomm_teammembers_post_type', $this->textdomain ),
				'description'           => __( 'Company Team Member Profile Page', $this->textdomain ),
				'labels'                => $labels,
				'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields' ),
				'taxonomies'            => array( 'aethercomm-team'),
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
			register_post_type( 'aethercomm-team', $args );
		}

		/**
		 * Modify the query
		 */
		public function modify_query( $query ) {
			if ( is_admin() || ! $query->is_main_query() )
				return;

			if ( is_tax( 'aethercomm-team' ) ) {
				// Display 8 posts for custom post type
				$query->set( 'posts_per_page', 16 );
				return;
			}
		}


	}

	$AethercommTeamMembers = new AethercommTeamMembers();

endif;
