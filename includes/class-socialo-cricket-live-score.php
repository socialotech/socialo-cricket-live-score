<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://socialo.tech
 * @since      1.0.0
 *
 * @package    Socialo_Cricket_Live_Score
 * @subpackage Socialo_Cricket_Live_Score/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Socialo_Cricket_Live_Score
 * @subpackage Socialo_Cricket_Live_Score/includes
 * @author     Socialo Tech <support@socialo.tech>
 */
class Socialo_Cricket_Live_Score
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Socialo_Cricket_Live_Score_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * The identifier of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_id The id of the plugin.
     */
    protected $plugin_id;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if (defined('SOCIALO_CRICKET_LIVE_SCORE_VERSION')) {
            $this->version = SOCIALO_CRICKET_LIVE_SCORE_VERSION;
        } else {
            $this->version = '1.0.0';
        }

        $this->plugin_name = 'socialo-cricket-live-score';
        $this->plugin_id = 'socialo_cricket_live_score';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_general_hooks();
        $this->define_admin_hooks();
        $this->define_public_hooks();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Socialo_Cricket_Live_Score_Loader. Orchestrates the hooks of the plugin.
     * - Socialo_Cricket_Live_Score_i18n. Defines internationalization functionality.
     * - Socialo_Cricket_Live_Score_Widget. Defines plugin widget functionality.
     * - Socialo_Cricket_Live_Score_Admin. Defines all hooks for the admin area.
     * - Socialo_Cricket_Live_Score_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) .
            'includes/class-socialo-cricket-live-score-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) .
            'includes/class-socialo-cricket-live-score-i18n.php';

        /**
         * The class responsible for register wordpress widget for the plugin
         */
        require_once plugin_dir_path(dirname(__FILE__)) .
            'includes/class-socialo-cricket-live-score-widget.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) .
            'admin/class-socialo-cricket-live-score-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) .
            'public/class-socialo-cricket-live-score-public.php';

        $this->loader = new Socialo_Cricket_Live_Score_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Socialo_Cricket_Live_Score_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {

        $plugin_i18n = new Socialo_Cricket_Live_Score_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

    }

    /**
     * Register all of the hooks related to general and common functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_general_hooks()
    {
        $plugin_widget = new Socialo_Cricket_Live_Score_Widget();

        $this->loader->add_action('widgets_init', $plugin_widget, 'register_socialo_cricket_live_score_widget');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {

        $plugin_admin = new Socialo_Cricket_Live_Score_Admin(
            $this->get_plugin_name(), $this->get_plugin_id(), $this->get_version()
        );

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_admin_menu');
        $this->loader->add_action('wp_ajax_socialo_cricket_live_score_update_settings', $plugin_admin, 'handle_settings_update');

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {

        $plugin_public = new Socialo_Cricket_Live_Score_Public(
            $this->get_plugin_name(), $this->get_plugin_id(), $this->get_version()
        );

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_action(
            'wp_ajax_nopriv_socialo_cricket_live_score_get_scores', $plugin_public, 'get_live_scores'
        );
        $this->loader->add_action(
            'wp_ajax_socialo_cricket_live_score_get_scores', $plugin_public, 'get_live_scores'
        );

        //Add shortcode integration
        add_shortcode('socialo_cricket_live_score', [$plugin_public, 'load_shortcode_view']);

    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     * @since     1.0.0
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The id of the plugin used to uniquely identify it within the context of
     * WordPress and to define functionality where this can also be used as a variable
     *
     * @return    string    The identification of the plugin.
     * @since     1.0.0
     */
    public function get_plugin_id()
    {
        return $this->plugin_id;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Socialo_Cricket_Live_Score_Loader    Orchestrates the hooks of the plugin.
     * @since     1.0.0
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     * @since     1.0.0
     */
    public function get_version()
    {
        return $this->version;
    }

}
