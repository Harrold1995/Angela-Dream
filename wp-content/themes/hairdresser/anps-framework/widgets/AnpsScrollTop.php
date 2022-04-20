<?php
class AnpsScrollTop extends WP_Widget {
    public function __construct() {
        parent::__construct(
                'AnpsScrollTop', __('AnpsThemes - Scroll to top button', 'hairdresser'), array('description' => __('Button that scrolls the user to the top of the page', 'hairdresser'),)
        );
    }
    
    public static function anps_register_widget() {
        return register_widget("AnpsScrollTop");
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array(
            'style'=>''
        ));
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('style')); ?>"><?php _e("Style", 'hairdresser'); ?></label>
            <?php
            $style_array = array(
                'Style 1' => '1',
                'Style 2' => '2',
                'Style 3' => '3',
            );
            ?>
            <select id="<?php echo esc_attr($this->get_field_id('style')); ?>" name="<?php echo esc_attr($this->get_field_name('style')); ?>">
                <?php foreach($style_array as $label => $value) : ?>
                <option <?php if ($value == $instance['style']) {
                        echo 'selected="selected"';
                    } ?> value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['style'] = $new_instance['style'];
        return $instance;
    }
    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $style = "1";
        if(isset($instance['style'])) {
            $style = $instance['style'];
        }
        echo $before_widget;
        echo anps_scroll_top($style, false);
        echo $after_widget;
    }
}
add_action( 'widgets_init', array('AnpsScrollTop', 'anps_register_widget'));
