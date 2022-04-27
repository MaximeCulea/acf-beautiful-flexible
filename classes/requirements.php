<?php namespace ACF_Beautiful_Flexible;

class Requirements {

	use Singleton;

	/**
	 * All about requirements checks
	 *
	 * @return bool
	 */
	public function check_requirements() {
		if ( ! function_exists( 'acf' ) ) {
			$this->display_error( esc_html__( 'Advanced Custom Fields is a required plugin.', 'acf-beautiful-flexible' ) );

			return false;
		}

		if ( '5.6.0' < acf()->version ) {
			$this->display_error( esc_html__( 'Advanced Custom Fields should be on version 5.6.0 or above.', 'acf-beautiful-flexible' ) );

			return false;
		}

		return true;
	}

	// Display message and handle errors
	public function display_error( $message ) {
		trigger_error( $message );

		add_action( 'admin_notices', function () use ( $message ) {
			printf( '<div class="notice error is-dismissible"><p>%s</p></div>', $message );
		} );

		// Deactive self
		add_action( 'admin_init', function () {
			deactivate_plugins( ACF_BEAUTIFUL_FLEXIBLE_DIR );
			unset( $_GET['activate'] );
		} );
	}
}
