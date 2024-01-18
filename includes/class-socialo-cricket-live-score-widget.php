<?php

class Socialo_Cricket_Live_Score_Widget extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        parent::__construct(
            'socialo_cricket_live_score_widget',
            'Socialo Cricket Live Score Widget',
            [
                'description' => __('Display live cricket scores', 'socialo-cricket-live-score')
            ]
        );
    }

    /**
     * Back-end widget form.
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Cricket Live Scores', 'socialo-cricket-live-score');

        $show_title = !empty($instance['show_title']) ? $instance['show_title'] : esc_html__('no', 'socialo-cricket-live-score');


        ?>

        <?php // Widget Title
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'socialo-cricket-live-score'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>

        <?php // Widget Show Title Option
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('show_title'); ?>"><?php esc_html_e('Show Title:', 'socialo-cricket-live-score'); ?></label>
            <select name="<?php echo $this->get_field_name('show_title'); ?>"
                    id="<?php echo $this->get_field_id('show_title'); ?>" class="widefat">
                <?php
                $options = array(
                    'yes' => __('Yes', 'socialo-cricket-live-score'),
                    'no' => __('No', 'socialo-cricket-live-score'),
                );

                // Loop through options and add each one to the select dropdown
                foreach ($options as $key => $name) {
                    echo '<option value="' . esc_attr($key) . '" ' . selected($show_title, $key, false) . '>' . $name . '</option>';

                } ?>
            </select>
        </p>

        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['show_title'] = !empty($new_instance['show_title']) ? sanitize_text_field($new_instance['show_title']) : '';

        return $instance;
    }

    /**
     * Front-end display of widget.
     *
     * @param array $args Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {

        extract($args);

        // Get the show title value
        $show_title = $instance['show_title'] ?? '';

        // WordPress core before_widget hook (always include )
        echo $before_widget;

        // Display the widget
        echo '<div>';

        // Display widget title if defined
        if ($show_title === "yes") {
            $title = isset($instance['title']) ? apply_filters('widget_title', $instance['title']) : '';
            echo $before_title . $title . $after_title;
        }

        echo do_shortcode('[socialo_cricket_live_score]');

        echo '</div>';

        // WordPress core after_widget hook (always include )
        echo $after_widget;

    }

    public function register_socialo_cricket_live_score_widget()
    {
        register_widget('socialo_cricket_live_score_widget');
    }
}

?>
