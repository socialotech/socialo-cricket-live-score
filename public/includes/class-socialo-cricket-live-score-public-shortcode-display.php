<?php
/**
 * Class to handle the public view for the plugin widget shortcode
 *
 * @link       https://socialo.tech
 * @since      1.0.0
 *
 * @package    Socialo_Cricket_Live_Score
 * @subpackage Socialo_Cricket_Live_Score/public/includes
 */

class Socialo_Cricket_Live_Score_Public_Shortcode_Display
{
    // Function to render the admin view
    public static function render()
    {
        ?>
        <div class="socialoCricketLiveScoreContainer">
            <div class="socialoCricketLiveScore swiper">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!--Dynamic Element Placeholder-->
                </div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>
            </div>
            <div class="socialoCricketLiveScoreInfoBox noMatchAvailable">
                <p>No Live Match Available</p>
            </div>
            <div class="socialoCricketLiveScoreInfoBox loadingUI">
                <img src="<?php echo plugin_dir_url(dirname(__FILE__, 2)) . 'assets/loader.gif'; ?>">
                <p>Loading Live Match Scores</p>
            </div>
        </div>
        <?php
    }
}

?>
