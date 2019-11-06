<?php


/**
 * Class KOTW_Custom_Post
 */
class KOTW_Custom_Post extends KotwSetup_Init {


	/**
	 * @var String $name
	 * Post type name
	 */
	public $name;

	/**
	 * @var String $singular
	 * Singular label
	 */
	public $singular;

	/**
	 * @var String $plural
	 * Plural Label
	 */
	public $plural;

	/**
	 * @var Array $tax_array
	 * Taxonomy array
	 */
	public $tax_array;

	/**
	 * @var Array $support
	 * Supports Array
	 */
	public $supports;

	/**
	 * KOTW_Custom_Post constructor.
	 *
	 * @param $name
	 * @param $singular
	 * @param $plural
	 * @param $tax_array
	 * @param $supports
	 */
	public function __construct( $name, $singular, $plural, $tax_array, $supports ) {
		$this->name      = $name;
		$this->singular  = $singular;
		$this->plural    = $plural;
		$this->tax_array = $tax_array;
		$this->supports  = $supports;

		$this->register_post_type();

	}


	/**
	 * register_post_type.
	 */
	public function register_post_type () {
		add_action (
			'init',
			function () {
				$labels = array(
					'name'                  => _x( $this->singular, $this->singular, $this->prefix ),
					'singular_name'         => _x( $this->singular, $this->singular, $this->prefix ),
					'menu_name'             => __( $this->plural, $this->prefix ),
					'name_admin_bar'        => __( $this->singular, $this->prefix ),
					'archives'              => $this->singular . __(' Archives', $this->prefix ),
					'attributes'            => $this->singular . __(' Attributes', $this->prefix ),
					'parent_item_colon'     => __( 'Parent ', $this->prefix ) . $this->singular . ':',
					'all_items'             => __( 'All ', $this->prefix ) . $this->plural,
					'add_new_item'          => __( 'Add New ', $this->prefix ) . $this->singular,
					'add_new'               => __( 'Add New', $this->prefix ),
					'new_item'              => __( 'New Item', $this->prefix ),
					'edit_item'             => __( 'Edit Item', $this->prefix ),
					'update_item'           => __( 'Update Item', $this->prefix ),
					'view_item'             => __( 'View Item', $this->prefix ),
					'view_items'            => __( 'View Items', $this->prefix ),
					'search_items'          => __( 'Search Item', $this->prefix ),
					'not_found'             => __( 'Not found', $this->prefix ),
					'not_found_in_trash'    => __( 'Not found in Trash', $this->prefix ),
					'featured_image'        => __( 'Featured Image', $this->prefix ),
					'set_featured_image'    => __( 'Set featured image', $this->prefix ),
					'remove_featured_image' => __( 'Remove featured image', $this->prefix ),
					'use_featured_image'    => __( 'Use as featured image', $this->prefix ),
					'insert_into_item'      => __( 'Insert into item', $this->prefix ),
					'uploaded_to_this_item' => __( 'Uploaded to this item', $this->prefix ),
					'items_list'            => $this->plural . __(' list', $this->prefix ),
					'items_list_navigation' => $this->plural . __(' list navigation', $this->prefix ),
					'filter_items_list'     => __( 'Filter items list', $this->prefix ),
				);
				$args = array(
					'label'                 => __( $this->singular, $this->prefix ),
					'description'           => $this->singular . __( ' Description', $this->prefix ),
					'labels'                => $labels,
					'supports'              => $this->supports,
					'taxonomies'            => $this->tax_array,
					'hierarchical'          => false,
					'public'                => true,
					'show_ui'               => true,
					'show_in_menu'          => true,
					'menu_position'         => 5,
					'show_in_admin_bar'     => true,
					'show_in_nav_menus'     => true,
					'can_export'            => true,
					'has_archive'           => true,
					'exclude_from_search'   => false,
					'publicly_queryable'    => true,
					'capability_type'       => 'page',
				);
				register_post_type( $this->name, $args );
			},
			0
		);
	}
}
