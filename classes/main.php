<?php namespace ACF_Beautiful_Flexible;

class Main {
	use Singleton;

	private $flexible_keys = [];

	protected function init() {
		add_action( 'init', [ $this, 'init_translations' ] );

		// Assets
		add_action( 'acf/input/admin_enqueue_scripts', [ $this, 'register_assets' ], 1 );
		add_action( 'acf/input/admin_enqueue_scripts', [ $this, 'enqueue_assets' ] );

		// Images
		add_action( 'acf/input/admin_footer', [ $this, 'layouts_images_style' ] );

		add_action( 'acf/input/admin_head', [ $this, 'retrieve_flexible_keys' ] );
	}

	/**
	 * Display the flexible layouts images related css for backgrounds
	 *
	 * @author Maxime CULEA
	 * @since  1.0.0
	 */
	public function layouts_images_style() {
		$images = $this->get_layouts_images();
		if ( empty( $images ) ) {
			return;
		}

		$css = "\n\t /** ACF Beautiful Flexible : dynamic images */";
		foreach ( $images as $layout_key => $image_url ) {
			$css .= sprintf( "\n\t .acf-fc-popup ul li a[data-layout=\"%s\"]{ background-image: url(\"%s\"); }", esc_html( $layout_key ), esc_url( $image_url ) );
		}

		echo "\n<style>" . strip_tags( $css ) . "\n</style>\n";
	}

	/**
	 * Manage to retrieve flexible keys
	 *
	 * @author Maxime CULEA
	 * @since  1.0.0
	 *
	 * TODO : maybe add cache
	 */
	public function retrieve_flexible_keys() {
		$groups = acf_get_field_groups();
		if ( empty( $groups ) ) {
			return;
		}

		foreach ( $groups as $group ) {
			$fields = (array) acf_get_fields( $group );
			if ( empty( $fields ) ) {
				continue;
			}

			$this->retrieve_flexible_keys_from_fields( $fields );
		}
	}

	/**
	 * Manage to retrieve flexible keys recursively from repeater and flexible fields
	 *
	 * @param $fields
	 *
	 *
	 * @author Maxime CULEA
	 * @since  1.0.1
	 */
	private function retrieve_flexible_keys_from_fields( $fields ) {
		foreach ( $fields as $field ) {
			// Check if a Flexible or Repeater type which can store fields
			if ( ! in_array( $field['type'], [ 'flexible_content', 'repeater' ] ) ) {
				continue;
			}

			/**
			 * Flexibles and Repeaters have different fields storage
			 * layouts for flexibles and sub_fields for repeaters
			 */
			$key_type = 'flexible_content' === $field['type'] ? 'layouts' : 'sub_fields';

			foreach ( $field[ $key_type ] as $layout_field ) {
				// Flexible field is already registered
				if ( ! empty( $this->flexible_keys[ $layout_field['key'] ] ) ) {
					continue;
				}

				// Register the flexible key
				$this->flexible_keys[ $layout_field['key'] ] = $layout_field['name'];

				// Can have nested fields
				if ( empty( $layout_field['sub_fields'] ) ) {
					continue;
				}

				// Check nested fields recursively to check for flexible keys
				$this->retrieve_flexible_keys_from_fields( $layout_field['sub_fields'] );
			}
		}
	}

	/**
	 * Get for all flexible the associated images
	 *
	 * @return array
	 * @author Maxime CULEA
	 * @since  1.0.0
	 */
	public function get_layouts_images() {
		$layouts_images = [];
		if ( empty( $this->flexible_keys ) ) {
			return $layouts_images;
		}

		foreach ( $this->flexible_keys as $flexible ) {
			$layouts_images[ $flexible ] = $this->locate_image( $flexible );
		}

		/**
		 * Allow to add/remove/change a flexible layout key
		 *
		 * @params array $layouts_images Array of flexible layout's keys with associated image url
		 *
		 * @return array
		 * @author Maxime CULEA
		 * @since  1.0.0
		 */
		return apply_filters( 'acf_beautiful_flexible.images', $layouts_images );
	}

	/**
	 * Locate template in the theme or plugin if needed
	 *
	 * @param string $tpl The tpl name, add automatically .png at the end of the file
	 *
	 * @return false|string
	 * @author Maxime CULEA | Nicolas Lemoine
	 * @since  1.0.0
	 */
	public function locate_image( $tpl ) {
		if ( empty( $tpl ) ) {
			return false;
		}

		/**
		 * Allow to add/remove/change the path to images
		 *
		 * @params array $path Path to check
		 *
		 * @return array
		 * @author Maxime CULEA
		 * @since  1.0.0
		 */
		$path = apply_filters( 'acf_beautiful_flexible.images_path', 'assets/acf-beautiful-flexible' );

		// Rework the tpl
		$tpl = str_replace( '_', '-', $tpl );

		foreach ( [ 'jpg', 'jpeg', 'png', 'gif' ] as $extension ) {
			$image = sprintf( '%s/%s.%s', $path, $tpl, $extension );
			// Direct path to custom folder
			if ( is_file( $image ) ) {
				return $image;
			}
			// Partial path to check into themes
			if ( is_file( get_theme_file_path( $image ) ) ) {
				return get_theme_file_uri( $image );
			}
		}

		return sprintf( '%sassets/images/default-%d.jpg', ACF_BEAUTIFUL_FLEXIBLE_URL, rand( 1, 10 ) );
	}

	// Use default JS or for 5.7.0+ the 57 one
	public function register_assets() {
		$version = version_compare( acf()->version, '5.7.O', '>=' ) ? '-57' : '';
		wp_register_script( 'acf-beautiful-flexible', sprintf( '%sassets/js/acf-beautiful-flexible%s.js', ACF_BEAUTIFUL_FLEXIBLE_URL, $version ), [ 'jquery' ], ACF_BEAUTIFUL_FLEXIBLE_VERSION );
		wp_register_style( 'acf-beautiful-flexible', ACF_BEAUTIFUL_FLEXIBLE_URL . 'assets/css/acf-beautiful-flexible.css', [], ACF_BEAUTIFUL_FLEXIBLE_VERSION );
	}

	public function enqueue_assets() {
		wp_enqueue_script( 'acf-beautiful-flexible' );
		wp_enqueue_style( 'acf-beautiful-flexible' );
	}

	public function init_translations() {
		load_plugin_textdomain( 'acf-beautiful-flexible', false, ACF_BEAUTIFUL_FLEXIBLE_PLUGIN_DIRNAME . '/languages' );
	}
}
