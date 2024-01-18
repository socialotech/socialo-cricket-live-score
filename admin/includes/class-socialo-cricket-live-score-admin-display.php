<?php
/**
 * Class to handle the admin view for the plugin.
 *
 * @link       https://socialo.tech
 * @since      1.0.0
 *
 * @package    Socialo_Cricket_Live_Score
 * @subpackage Socialo_Cricket_Live_Score/admin/includes
 */

class Socialo_Cricket_Live_Score_Admin_Display
{

    /**
     * SportMonks API key.
     *
     * @var string Holds the SportMonks API key.
     */
    private $sportmonks_api_key;

    /**
     * Maximum number of slides to show.
     *
     * @var int Holds the maximum number of slides to show.
     */
    private $max_slides_to_show;

    /**
     * Score refresh time in seconds.
     *
     * @var int Holds the score refresh time in seconds.
     */
    private $refresh_time_seconds;

    /**
     * Socialo_Cricket_Live_Score_Admin_View constructor.
     *
     * Initializes option values by retrieving them from WordPress options.
     * Uses default values if options are not set.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->sportmonks_api_key = get_option(SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX . 'sportmonks_api_key', '');
        $this->max_slides_to_show = get_option(SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX . 'max_slides_to_show', 5);
        $this->refresh_time_seconds = get_option(SOCIALO_CRICKET_LIVE_SCORE_OPTIONS_PREFIX . 'refresh_time_seconds', 60);
    }

    // Function to render the admin view
    public static function render()
    {
        $admin_display = new self();
        ?>
        <div class="socialo-cricket-live-score">
            <div class="wrap">
                <div class="jumbotron">
                    <img src="<?php echo plugin_dir_url(dirname(__FILE__, 2)) . 'assets/socialo-cricket-live-score-admin-logo.png'; ?>">
                </div>
                <div class="container">

                    <div class="guide-section">
                        <div>
                            <h2>How to Use Cricket Live Score Plugin</h2>
                            <p>Follow these steps to get started:</p>

                            <ol>
                                <li>Sign up on <a target="_blank"
                                                  href="https://my.sportmonks.com/register">SportMonks</a> and
                                    obtain your API key.
                                </li>
                                <li>Enter and save your SportMonks API key in the plugin settings.</li>
                                <li>Use the shortcode in your posts or pages to display live cricket scores.</li>
                                <li>You can also use the <b>Socialo Cricket Live Score</b> widget.</li>
                            </ol>

                            <div class="shortcode-container">
                                <p>Click the button below to copy the shortcode:</p>
                                <div class="copy-shortcode">
                                    <input type="text" class="shortcode-input" readonly
                                           value="[socialo_cricket_live_score]">
                                    <button class="copy-button">Copy</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="settings-form">
                        <form id="socialo_cricket_live_score_settings_form">
                            <div class="admin-form-group">
                                <label for="api-key">SportMonks API Key</label>
                                <input type="text" name="api-key" placeholder="Enter your API Key"
                                       value="<?php echo esc_attr($admin_display->sportmonks_api_key); ?>" required>
                            </div>

                            <div class="admin-form-group">
                                <label for="max-slides">Max Slides to Show</label>
                                <input type="number" name="max-slides" placeholder="Enter max slides"
                                       value="<?php echo esc_attr($admin_display->max_slides_to_show); ?>" required>
                            </div>

                            <div class="admin-form-group">
                                <label for="refresh-time">Score Refresh Time (seconds)</label>
                                <input type="number" name="refresh-time"
                                       placeholder="Enter refresh time"
                                       value="<?php echo esc_attr($admin_display->refresh_time_seconds); ?>" min="30"
                                       required>
                            </div>
                            <div class="admin-form-group hide">
                                <div class="response-message bg-danger"></div>
                            </div>
                            <button type="submit">Save Settings</button>
                        </form>
                    </div>
                </div>
                <div class="footer">
                    <span>By <a href="https://socialo.tech/" target="_blank">Socialo Tech</a></span>
                </div>
            </div>
        </div>
        <?php
    }
}

?>
