<?php
class AnpsOpeningTime extends WP_Widget {
    public function __construct() {
        parent::__construct('AnpsOpeningTime', 'AnpsThemes - Opening time', array('description' => esc_html__('Enter opening time.', 'hairdresser')));

        add_action( 'admin_enqueue_scripts', array( $this, 'anps_enqueue_scripts' ) );
        add_action( 'admin_footer-widgets.php', array( $this, 'anps_print_scripts' ), 9999 );
    }
    
    public static function anps_register_widget() {
        return register_widget("AnpsOpeningTime");
    }

    function anps_enqueue_scripts( $hook_suffix ) {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
    }

    function anps_print_scripts() {
        ?>
        <script>
            ( function( $ ){
                function initColorPicker( widget ) {
                    widget.find( '.anps-color-picker' ).wpColorPicker();
                }

                function onFormUpdate( event, widget ) {
                    initColorPicker( widget );
                }

                $( document ).on( 'widget-added widget-updated', onFormUpdate );
                $( document ).ready( function() {
                    $( '#widgets-right .widget:has(.anps-color-picker)' ).each( function () {
                        initColorPicker( $( this ) );
                    } );
                } );
            }( jQuery ) );
        </script>
        <?php
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array(
            'title' => '',
            'day_1'=>'',
            'day_2'=>'',
            'day_3'=>'',
            'day_4'=>'',
            'day_5'=>'',
            'day_6'=>'',
            'day_7'=>'',
            'opening_time_1'=>'',
            'opening_time_2'=>'',
            'opening_time_3'=>'',
            'opening_time_4'=>'',
            'opening_time_5'=>'',
            'opening_time_6'=>'',
            'opening_time_7'=>'',
            'exposed_1'=>'',
            'exposed_2'=>'',
            'exposed_3'=>'',
            'exposed_4'=>'',
            'exposed_5'=>'',
            'exposed_6'=>'',
            'exposed_7'=>'',
            'border_style' => '',
            'title_position' => '',
            'border_color' => '',
        ));

        $border_style_options = array(
            esc_html__('Double border', 'hairdresser') => 'double',
            esc_html__('Thin border', 'hairdresser') => 'thin',
            esc_html__('Strong border', 'hairdresser') => 'strong',
        );

        $title_position_options = array(
            esc_html__('Inside', 'hairdresser') => 'inside',
            esc_html__('Outside', 'hairdresser') => 'outside',
        );
        ?>

        <!-- Title -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e("Title", 'hairdresser'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" class="widefat" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>

        <!-- Border style -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('border_style')); ?>"><?php esc_html_e("Border style", 'hairdresser'); ?></label>

            <select id="<?php echo esc_attr($this->get_field_id('border_style')); ?>" name="<?php echo esc_attr($this->get_field_name('border_style')); ?>">
                <?php foreach ($border_style_options as $label => $value) : ?>
                    <option <?php if (isset($instance['border_style']) && $value == $instance['border_style']) {
                        echo 'selected="selected"';
                    } ?> value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
            <?php endforeach; ?>
            </select>
        </p>

        <!-- Title position -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title_position')); ?>"><?php esc_html_e("Title position", 'hairdresser'); ?></label>

            <select id="<?php echo esc_attr($this->get_field_id('title_position')); ?>" name="<?php echo esc_attr($this->get_field_name('title_position')); ?>">
                <?php foreach ($title_position_options as $label => $value) : ?>
                    <option <?php if (isset($instance['title_position']) && $value == $instance['title_position']) {
                        echo 'selected="selected"';
                    } ?> value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
            <?php endforeach; ?>
            </select>
        </p>

        <!-- Border color -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('border_color')); ?>"><?php _e("Border color", 'hairdresser'); ?></label><br />
            <input class="anps-color-picker" id="<?php echo esc_attr($this->get_field_id('border_color')); ?>" name="<?php echo esc_attr($this->get_field_name('border_color')); ?>" type="text" value="<?php echo esc_attr($instance['border_color']); ?>" />
        </p>

    <?php for($i=1;$i<8;$i++) : ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('day_'.$i)); ?>"><?php echo esc_html__('Day', 'hairdresser')." $i"; ?></label>
                <input id="<?php echo esc_attr($this->get_field_id('day_'.$i)); ?>" name="<?php echo esc_attr($this->get_field_name('day_'.$i)); ?>" type="text" class="widefat" value="<?php echo esc_attr($instance['day_'.$i]); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('opening_time_'.$i)); ?>"><?php echo esc_html__('Opening time Day', 'hairdresser')." $i"; ?></label>
                <input id="<?php echo esc_attr($this->get_field_id('opening_time_'.$i)); ?>" name="<?php echo esc_attr($this->get_field_name('opening_time_'.$i)); ?>" type="text" class="widefat" value="<?php echo esc_attr($instance['opening_time_'.$i]); ?>" />
            </p>
            <?php
            $checked = '';
            if($instance['exposed_'.$i]=="on") {
                $checked = "checked";
            }
            ?>
            <p>
                <input id="<?php echo esc_attr($this->get_field_id('exposed_'.$i)); ?>" name="<?php echo esc_attr($this->get_field_name('exposed_'.$i)); ?>" type="checkbox" <?php echo esc_attr($checked); ?>/>
                <label for="<?php echo esc_attr($this->get_field_id('exposed_'.$i)); ?>"><?php echo esc_html__('Exposed Day', 'hairdresser')." $i"; ?></label>
            </p>
    <?php endfor;
    }
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['border_style'] = $new_instance['border_style'];
        $instance['title_position'] = $new_instance['title_position'];
        $instance['border_color'] = $new_instance['border_color'];
        for($i=1; $i<8; $i++) {
            $instance['day_'.$i] = $new_instance['day_'.$i];
            $instance['opening_time_'.$i] = $new_instance['opening_time_'.$i];
            $instance['exposed_'.$i] = $new_instance['exposed_'.$i];
        }
        return $instance;
    }
    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        echo $before_widget;

        $class = 'opening-time';
        $class .= isset($instance['border_style']) ? ' opening-time-border-' . $instance['border_style'] : ' opening-time-border-double';

        $border_style_attr = '';

        if (isset($instance['border_color'])) {
            $border_style_attr = 'border-color: ' . $instance['border_color'] . ';';
        }

        if(isset($instance['title'])&&$instance['title']!="") : ?>
            <?php if(isset($instance['title_position']) && $instance['title_position'] == 'outside') : ?>
                <h3 class="widget-title"><?php echo esc_html($instance['title']); ?></h3>
            <?php endif; ?>

            <div class="<?php echo esc_attr($class); ?>" style="<?php echo esc_attr($border_style_attr); ?>">
                <?php if(!isset($instance['title_position']) || $instance['title_position'] == 'inside') : ?>
                    <h3 class="widget-title"><?php echo esc_html($instance['title']); ?></h3>
                <?php endif; ?>
                <ul>
                    <?php for($i=1;$i<8;$i++) : ?>
                    <?php if(isset($instance['day_'.$i]) && $instance['day_'.$i]!="") : ?>
                    <li class="opening-time-item<?php if(isset($instance['exposed_'.$i]) && $instance['exposed_'.$i]!=""){ echo " highlited";}?>">
                        <strong><?php echo esc_html($instance['day_'.$i]); ?></strong>
                        <?php if(isset($instance['opening_time_'.$i]) && $instance['opening_time_'.$i]!="") : ?>
                        <?php echo esc_html($instance['opening_time_'.$i]); ?>
                        <?php endif; ?>
                    </li>
                    <?php endif; ?>
                    <?php endfor; ?>
                </ul>
            </div>
        <?php endif;
        echo $after_widget;
    }
}
add_action('widgets_init', array('AnpsOpeningTime', 'anps_register_widget'));
