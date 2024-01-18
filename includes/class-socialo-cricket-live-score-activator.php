<?php
/**
 * Fired during plugin activation.
 *
 * @link       https://socialo.tech
 * @since      1.0.0
 *
 * @package    Socialo_Cricket_Live_Score
 * @subpackage Socialo_Cricket_Live_Score/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Socialo_Cricket_Live_Score
 * @subpackage Socialo_Cricket_Live_Score/includes
 * @author     Socialo Tech <support@socialo.tech>
 */
class Socialo_Cricket_Live_Score_Activator
{

    /**
     * Activate the plugin.
     *
     * This method is called when the plugin is activated.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        // Add default options on plugin activation
        self::add_default_options();
    }

    /**
     * Add default options on plugin activation if not set.
     *
     * @since    1.0.0
     */
    public static function add_default_options()
    {
        $activator = new self();

        // Check if options exist, if not, set default values
        if (!get_option(SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX . 'sportmonks_api_key')) {
            update_option(SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX . 'sportmonks_api_key', '');
        }

        if (!get_option(SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX . 'max_slides_to_show')) {
            update_option(SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX . 'max_slides_to_show', 5);
        }

        if (!get_option(SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX . 'refresh_time_seconds')) {
            update_option(SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX . 'refresh_time_seconds', 60);
        }
    }
}
