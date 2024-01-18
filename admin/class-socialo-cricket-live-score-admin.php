<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://socialo.tech
 * @since      1.0.0
 *
 * @package    Socialo_Cricket_Live_Score
 * @subpackage Socialo_Cricket_Live_Score/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Socialo_Cricket_Live_Score
 * @subpackage Socialo_Cricket_Live_Score/admin
 * @author     Socialo Tech <support@socialo.tech>
 */
class Socialo_Cricket_Live_Score_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * The identifier of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_id The id of the plugin.
     */
    protected $plugin_id;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $plugin_id The identifier of the plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $plugin_id, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->plugin_id = $plugin_id;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Socialo_Cricket_Live_Score_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Socialo_Cricket_Live_Score_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        if (get_current_screen()->id === "toplevel_page_socialo-cricket-live-score") {
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) .
                'css/socialo-cricket-live-score-admin.css', array(), $this->version, 'all');
        }

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Socialo_Cricket_Live_Score_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Socialo_Cricket_Live_Score_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        if (get_current_screen()->id === "toplevel_page_socialo-cricket-live-score") {
            wp_enqueue_script(
                $this->plugin_name, plugin_dir_url(__FILE__) .
                'js/socialo-cricket-live-score-admin.js', array('jquery'), $this->version, false);

            wp_localize_script($this->plugin_name, $this->plugin_id . '_object', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce($this->plugin_name . '-admin-nonce')
            ));
        }

    }

    /**
     * Add admin menu and settings page.
     *
     * @since    1.0.0
     */
    public function add_admin_menu()
    {
        add_menu_page(
            __('Cricket Live Score Settings', $this->plugin_name),
            __('Cricket Live Score', $this->plugin_name),
            'manage_options',
            $this->plugin_name,
            [$this, 'load_admin_page'],
            plugin_dir_url(dirname(__FILE__)) . 'assets/socialo-cricket-live-score-admin-icon.png'
        );
    }

    /**
     * Render the admin settings page.
     *
     * @since    1.0.0
     */
    public function load_admin_page()
    {
        // Include the admin view class
        include('includes/class-socialo-cricket-live-score-admin-display.php');
        Socialo_Cricket_Live_Score_Admin_Display::render();
    }

    /**
     * Handles plugins options update request.
     *
     * This method is hooked into the 'wp_ajax_socialo_cricket_live_score_update_settings' action.
     * It processes the AJAX request and updates the plugin options.
     *
     * @since 1.0.0
     */
    public function handle_settings_update()
    {
        // Check if the request is from a valid user and has a valid nonce
        if (!current_user_can('manage_options') || !isset($_POST['_wpnonce']) ||
            !wp_verify_nonce($_POST['_wpnonce'], $this->plugin_name . '-admin-nonce')) {
            wp_send_json_error(__('Unauthorized access! Settings update failed.', $this->plugin_name));
        }

        // Validate and sanitize the received data
        $sportmonks_api_key = isset($_POST['api-key']) ? sanitize_text_field($_POST['api-key']) : '';
        $max_slides_to_show = isset($_POST['max-slides']) ? absint($_POST['max-slides']) : 5;
        $refresh_time_seconds = isset($_POST['refresh-time']) ? absint($_POST['refresh-time']) : 60;

        // Update the plugin options
        update_option(SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX . 'sportmonks_api_key', $sportmonks_api_key);
        update_option(SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX . 'max_slides_to_show', $max_slides_to_show);
        update_option(SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX . 'refresh_time_seconds', $refresh_time_seconds);

        // Send a success response
        wp_send_json_success(__('Settings updated successfully', $this->plugin_name));
    }


}
