<?php


if( !class_exists( 'KOTW_Custom_Tax' ) ):
/**
 * Class KOTW_Custom_Tax
 */
class KOTW_Custom_Tax extends DCP_Init {


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
	 * @var Array $support
	 * Supports Array
	 */
	public $supports;


	/**
	 * @var Boolean $hierarchical
	 *
	 */
	public $hierarchical;

	/**
	 * KOTW_Custom_Post constructor.
	 *
	 * @param $name
	 * @param $singular
	 * @param $plural
	 * @param $supports
	 * @param $hierarchical
	 */
	public function __construct( $name, $singular, $plural, $supports, $hierarchical = false ) {
		$this->name          = $name;
		$this->singular      = $singular;
		$this->plural        = $plural;
		$this->supports      = $supports;
		$this->hierarchical  = $hierarchical;

		$this->register_tax();

	}


	/**
	 * register_post_type.
	 */
	public function register_tax () {
		add_action (
			'init',
			function () {
				$labels = array(
					'name'                       => _x( $this->plural, 'Taxonomy General Name', $this->prefix ),
					'singular_name'              => _x( $this->singular, 'Taxonomy Singular Name', $this->prefix ),
					'menu_name'                  => __( $this->singular, $this->prefix ),
					'all_items'                  => __( 'All Items', $this->prefix ),
					'parent_item'                => __( 'Parent Item', $this->prefix ),
					'parent_item_colon'          => __( 'Parent Item:', $this->prefix ),
					'new_item_name'              => __( 'New Item Name', $this->prefix ),
					'add_new_item'               => __( 'Add New Item', $this->prefix ),
					'edit_item'                  => __( 'Edit Item', $this->prefix ),
					'update_item'                => __( 'Update Item', $this->prefix ),
					'view_item'                  => __( 'View Item', $this->prefix ),
					'separate_items_with_commas' => __( 'Separate items with commas', $this->prefix ),
					'add_or_remove_items'        => __( 'Add or remove items', $this->prefix ),
					'choose_from_most_used'      => __( 'Choose from the most used', $this->prefix ),
					'popular_items'              => __( 'Popular Items', $this->prefix ),
					'search_items'               => __( 'Search Items', $this->prefix ),
					'not_found'                  => __( 'Not Found', $this->prefix ),
					'no_terms'                   => __( 'No items', $this->prefix ),
					'items_list'                 => __( 'Items list', $this->prefix ),
					'items_list_navigation'      => __( 'Items list navigation', $this->prefix ),
				);
				$args = array(
					'labels'                     => $labels,
					'hierarchical'               => $this->hierarchical,
					'public'                     => true,
					'show_ui'                    => true,
					'show_admin_column'          => true,
					'show_in_nav_menus'          => true,
					'show_tagcloud'              => true,
				);
				register_taxonomy( $this->name, $this->supports, $args );

			},
			0
		);
	}
}
endif;