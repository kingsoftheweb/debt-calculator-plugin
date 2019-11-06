<?php
/**
 * Class DCP_Meta_Boxes
 */
if( !class_exists( 'DCP_Meta_Boxes' ) ):
class DCP_Meta_Boxes extends DCP_Init {

	/**
	 * DCP_Meta_Boxes constructor.
	 */
	public function __construct() {
		parent::__construct();

		//add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		//add_action( 'save_post', array( $this, 'save_meta_boxes' ) );
	}

	public function add_meta_boxes () {
		add_meta_box(
			$this->prefix . '-breaking-news',
			'Breaking News',
			array( $this, 'breaking_news_callback' ),
			'post',
			'normal'
		);
	}


	// Callbacks.
	public function breaking_news_callback () {
		include $this->plugin_path . '/admin/partials/meta-boxes/breaking-news.php';
	}



	public function save_meta_boxes ( $post_id ) {
		//if ( get_post_type( $post_id ) !== 'post' ) return;

		// Saving non text inputs.
		$meta_non_text_values = [
			'is_breaking_news'
		];
		foreach ( $meta_non_text_values as $meta ) {
			if ( isset( $_POST[$meta] ) ) {
				$meta_value = $_POST[$meta];
				update_post_meta( $post_id, $meta, $meta_value );
			}
		}

		// Saving text inputs.
		$meta_text_values = [
			'DCP_custom_title'
		];
		foreach ( $meta_text_values as $meta ) {
			if ( isset( $_POST[$meta] ) ) {
				$meta_value = sanitize_text_field( $_POST[$meta] );
				update_post_meta( $post_id, $meta, $meta_value );
			}
		}
	}
}

new DCP_Meta_Boxes();
endif;