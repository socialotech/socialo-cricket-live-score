<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://socialo.tech
 * @since             1.0.0
 * @package           Socialo_Cricket_Live_Score
 *
 * @wordpress-plugin
 * Plugin Name:       Socialo Cricket Live Score
 * Plugin URI:        https://socialo.tech
 * Description:       Display real-time cricket match scores on your WordPress site using the SportMonks API. Engage your audience with live updates and team details in an elegant UI.
 * Version:           1.0.0
 * Developer:         Rohsin Al Razi (wEbCoAdEr)
 * Author:            Socialo Tech
 * Author URI:        https://socialo.tech/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       socialo-cricket-live-score
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
const SOCIALO_CRICKET_LIVE_SCORE_VERSION = '1.0.0';
const SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX = 'socialo_cricket_live_score_';


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-socialo-cricket-live-score-activator.php
 */
function activate_socialo_cricket_live_score() {
	require_once plugin_dir_path( __FILE__ ) .
        'includes/class-socialo-cricket-live-score-activator.php';
	Socialo_Cricket_Live_Score_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-socialo-cricket-live-score-deactivator.php
 */
function deactivate_socialo_cricket_live_score() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-socialo-cricket-live-score-deactivator.php';
	Socialo_Cricket_Live_Score_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_socialo_cricket_live_score' );
register_deactivation_hook( __FILE__, 'deactivate_socialo_cricket_live_score' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-socialo-cricket-live-score.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function run_socialo_cricket_live_score() {

	$plugin = new Socialo_Cricket_Live_Score();
	$plugin->run();

}
run_socialo_cricket_live_score();
