<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://socialo.tech
 * @since      1.0.0
 *
 * @package    Socialo_Cricket_Live_Score
 * @subpackage Socialo_Cricket_Live_Score/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Socialo_Cricket_Live_Score
 * @subpackage Socialo_Cricket_Live_Score/includes
 * @author     Socialo Tech <support@socialo.tech>
 */
class Socialo_Cricket_Live_Score_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'socialo-cricket-live-score',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
