<?php
/**
 * ACF Beautiful Flexible
 *
 * @author            Maxime Culea
 * @package           ACFBeautifulFlexible
 * @copyright         2022 Maxime Culea
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       ACF Beautiful Flexible
 * Plugin URI:        https://wordpress.org/plugins/acf-beautiful-flexible
 * Description:       Transform ACF's flexible layouts list into a beautiful popup.
 * Version:           1.0.4
 * Requires at least: 4.7
 * Requires PHP:      5.6
 * Author:            Maxime Culea
 * Author URI:        https://profiles.wordpress.org/MaximeCulea
 * Text Domain:       acf-beautiful-flexible
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Contributors:      maximeculea
 * Donate link:       https://www.paypal.com/paypalme/MaximeCulea
 */

/*
ACF Beautiful Flexible is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
ACF Beautiful Flexible is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with ACF Beautiful Flexible. If not, see https://github.com/MaximeCulea/acf-beautiful-flexible/blob/master/LICENSE.md.
*/

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Plugin constants
define( 'ACF_BEAUTIFUL_FLEXIBLE_VERSION', '1.0.3' );
define( 'ACF_BEAUTIFUL_FLEXIBLE_MIN_PHP_VERSION', '5.6' );

// Plugin URL and PATH
define( 'ACF_BEAUTIFUL_FLEXIBLE_URL', plugin_dir_url( __FILE__ ) );
define( 'ACF_BEAUTIFUL_FLEXIBLE_DIR', plugin_dir_path( __FILE__ ) );
define( 'ACF_BEAUTIFUL_FLEXIBLE_PLUGIN_DIRNAME', basename( rtrim( dirname( __FILE__ ), '/' ) ) );

// Check PHP min version
if ( version_compare( PHP_VERSION, ACF_BEAUTIFUL_FLEXIBLE_MIN_PHP_VERSION, '<' ) ) {
	require_once( ACF_BEAUTIFUL_FLEXIBLE_DIR . 'compat.php' );

	// possibly display a notice, trigger error
	add_action( 'admin_init', array( 'ACF_Beautiful_Flexible\Compatibility', 'admin_init' ) );

	// stop execution of this file
	return;
}

// Autoload
require_once ACF_BEAUTIFUL_FLEXIBLE_DIR . 'autoload.php';

// Init the plugin
add_action( 'plugins_loaded', 'plugins_loaded_acf_beautiful_flexible_plugin' );
function plugins_loaded_acf_beautiful_flexible_plugin() {
	$requirements = ACF_Beautiful_Flexible\Requirements::get_instance();
	if ( ! $requirements->check_requirements() ) {
		return;
	}

	// Client
	ACF_Beautiful_Flexible\Main::get_instance();
}
