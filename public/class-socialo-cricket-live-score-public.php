<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://socialo.tech
 * @since      1.0.0
 *
 * @package    Socialo_Cricket_Live_Score
 * @subpackage Socialo_Cricket_Live_Score/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Socialo_Cricket_Live_Score
 * @subpackage Socialo_Cricket_Live_Score/public
 * @author     Socialo Tech <support@socialo.tech>
 */
class Socialo_Cricket_Live_Score_Public
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
     * @param string $plugin_name The name of the plugin.
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
     * Register the stylesheets for the public-facing side of the site.
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

        // Enqueue Swiper CSS
        wp_enqueue_style(
            $this->plugin_name . '-swiper-style', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
            array(), $this->version, 'all'
        );

        // Enqueue Core Public CSS
        wp_enqueue_style(
            $this->plugin_name . '-style', plugin_dir_url(__FILE__) . 'css/socialo-cricket-live-score-public.css',
            array($this->plugin_name . '-swiper-style'), $this->version, 'all'
        );

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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

        // Enqueue Swiper JavaScript
        wp_enqueue_script($this->plugin_name . '-swiper-script', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array('jquery'), $this->version, true);

        // Enqueue Core Public JavaScript
        wp_enqueue_script(
            $this->plugin_name . '-script', plugin_dir_url(__FILE__) . 'js/socialo-cricket-live-score-public.js',
            array('jquery', $this->plugin_name . '-swiper-script'), $this->version, false
        );

        //Localize the script dependency object
        wp_localize_script($this->plugin_name . '-script', $this->plugin_id . '_object', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce($this->plugin_name . '-public-nonce'),
            'refresh_interval' => get_option(SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX . 'refresh_time_seconds'),
            'max_slides' => get_option(SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX . 'max_slides_to_show')
        ));

    }

    /**
     * Render the cricket live score widget shortcode view
     *
     * @since    1.0.0
     */
    public function load_shortcode_view()
    {
        // Include the admin view class
        ob_start();
        include('includes/class-socialo-cricket-live-score-public-shortcode-display.php');
        Socialo_Cricket_Live_Score_Public_Shortcode_Display::render();
        return ob_get_clean();
    }

    /**
     * Handles the AJAX request to fetch live cricket scores.
     *
     * This method is hooked into the 'wp_ajax_socialo_cricket_live_score_update_settings' action.
     * It processes the AJAX request and retrieves live scores from the SportMonks API.
     *
     * @since 1.0.0
     */
    public function get_live_scores()
    {
        // Check if the request is from a valid user and has a valid nonce
        if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], $this->plugin_name . '-public-nonce')) {
            wp_send_json_error(__('Unauthorized access! Fetching live score failed', $this->plugin_name));
        }

        // Retrieve API key from plugin options
        $api_key = get_option(SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX . 'sportmonks_api_key');

        // Check if API key is present
        if (empty($api_key)) {
            wp_send_json_error(__('SportMonks API key is missing', $this->plugin_name));
        }

        // Prepare API URL
        $includes = 'localteam,visitorteam,scoreboards,league';
        $api_url = 'https://cricket.sportmonks.com/api/v2.0/livescores?api_token=' . $api_key . '&include=' . $includes;

        // Fetch live scores using wp_remote_get
        $response = wp_remote_get($api_url);

        // Check for errors
        if (is_wp_error($response)) {
            wp_send_json_error(__('Error fetching data from the API', $this->plugin_name));
        }

        // Get the response body
        $body = wp_remote_retrieve_body($response);

        // Decode the JSON response
        $data = json_decode($body, true);

        // Check if JSON decoding was successful
        if ($data === null || json_last_error() !== JSON_ERROR_NONE) {
            wp_send_json_error(__('Error decoding JSON response', $this->plugin_name));
        }

        // Send a success response
        wp_send_json_success($data);
    }


}
