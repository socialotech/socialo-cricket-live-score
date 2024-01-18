<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future versions of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://socialo.tech
 * @since      1.0.0
 *
 * @package    Socialo_Cricket_Live_Score
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Include the main plugin file to access its constants
include_once WP_PLUGIN_DIR . '/socialo-cricket-live-score/socialo-cricket-live-score.php';

// Clear options on plugin uninstall
delete_option(SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX . 'sportmonks_api_key');
delete_option(SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX . 'max_slides_to_show');
delete_option(SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX . 'refresh_time_seconds');