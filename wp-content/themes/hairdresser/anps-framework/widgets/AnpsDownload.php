<?php

class AnpsDownload extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'AnpsDownload', __('AnpsThemes - Download', 'hairdresser'), array('description' => __('Choose a image to show on page', 'hairdresser'),)
        );
        add_action( 'admin_enqueue_scripts', array( $this, 'anps_enqueue_scripts' ) );
        add_action( 'admin_footer-widgets.php', array( $this, 'anps_print_scripts' ), 9999 );
    }
    
    public static function anps_register_widget() {
        return register_widget("AnpsDownload");
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
        $instance = wp_parse_args((array) $instance, array('title' => '', 'file' => '', 'file_title' => '', 'icon'=>'', 'icon_color'=>'', 'bg_color'=>'', 'file_external'=>''));

        $file = $instance['file'];
        $file_external = $instance['file_external'];
        $title = $instance['title'];
        $file_title = $instance['file_title'];
        $icon = $instance['icon'];
        $icon_color = $instance['icon_color'];
        $bg_color = $instance['bg_color'];
        ?>
        <!-- Widget title -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e("Title", 'hairdresser'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" class="widefat" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>
        <!-- File title -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('file_title')); ?>"><?php _e("File title", 'hairdresser'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('file_title')); ?>" name="<?php echo esc_attr($this->get_field_name('file_title')); ?>" type="text" class="widefat" value="<?php echo esc_attr($instance['file_title']); ?>" />
        </p>
        <!-- File -->
        <p>
            <?php $files = get_children('post_type=attachment'); ?>
            <label for="<?php echo esc_attr($this->get_field_id('file')); ?>"><?php _e("File", 'hairdresser'); ?></label><br />
            <select id="<?php echo esc_attr($this->get_field_id('file')); ?>" name="<?php echo esc_attr($this->get_field_name('file')); ?>">
                <option value=""><?php _e("Select a file", 'hairdresser'); ?></option>
                <?php foreach ($files as $item) : ?>
                    <option <?php if ($item->guid == $file) {
                        echo 'selected="selected"';
                    } ?> value="<?php echo esc_attr($item->guid); ?>"><?php echo esc_html($item->post_title); ?></option>
            <?php endforeach; ?>
            </select>
        </p>
        <!-- Icon -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('icon')); ?>"><?php _e("Icon", 'hairdresser'); ?></label><br />
            <div class="anps-iconpicker">
                <i class="<?php echo esc_attr($icon); ?>"></i>
                <input type="text" value="<?php echo esc_attr($icon); ?>" id="<?php echo esc_attr($this->get_field_id('icon')); ?>" name="<?php echo esc_attr($this->get_field_name('icon')); ?>">
                <button type="button"><?php _e('Select icon', 'hairdresser'); ?></button>
            </div>
        </p>
        <!-- Icon color -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('icon_color')); ?>"><?php _e("Icon color", 'hairdresser'); ?></label><br />
            <input class="anps-color-picker" id="<?php echo esc_attr($this->get_field_id('icon_color')); ?>" name="<?php echo esc_attr($this->get_field_name('icon_color')); ?>" type="text" value="<?php echo esc_attr($instance['icon_color']); ?>" />
        </p>
        <!-- Background color -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('bg_color')); ?>"><?php _e("Background color", 'hairdresser'); ?></label><br />
            <input class="anps-color-picker" id="<?php echo esc_attr($this->get_field_id('bg_color')); ?>" name="<?php echo esc_attr($this->get_field_name('bg_color')); ?>" type="text" value="<?php echo esc_attr($instance['bg_color']); ?>" />
        </p>
        <!-- File external -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('file_external')); ?>"><?php _e("File external", 'hairdresser'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('file_external')); ?>" name="<?php echo esc_attr($this->get_field_name('file_external')); ?>" type="text" class="widefat" value="<?php echo esc_attr($instance['file_external']); ?>" />
        </p>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['file'] = $new_instance['file'];
        $instance['file_external'] = $new_instance['file_external'];
        $instance['title'] = $new_instance['title'];
        $instance['file_title'] = $new_instance['file_title'];
        $instance['icon'] = $new_instance['icon'];
        $instance['icon_color'] = $new_instance['icon_color'];
        $instance['bg_color'] = $new_instance['bg_color'];
        return $instance;
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $title = $instance['title'];
        $file_title = $instance['file_title'];
        $icon = $instance['icon'];
        if( strpos($icon, 'typcn-') === false &&
            strpos($icon, 'vc_') === false &&
            strpos($icon, 'vc-') === false ) {
            $icon = 'fa ' . $icon;
        }
        $icon_color = '';
        if(isset($instance['icon_color'])) {
            $icon_color = $instance['icon_color'];
        }
        $bg_color = '';
        if(isset($instance['bg_color'])) {
            $bg_color = $instance['bg_color'];
        }
        if(isset($instance['file'])) {
            $file_url = $instance['file'];
        } elseif(isset($instance['file_external'])) {
            $file_url = $instance['file_external'];
        } else {
            $file_url = "#";
        }

        echo $before_widget;
        ?>

        <?php if($title) : ?>
            <h3 class="widget-title"><?php echo esc_html($title); ?></h3>
        <?php endif; ?>
            <div class="anps_download">
                <a href="<?php echo esc_url($file_url); ?>" target="_blank">
                    <span class="anps_download_icon" style="background-color: <?php echo esc_attr($bg_color); ?>"><i class="<?php echo esc_attr($icon); ?>" style="color: <?php echo esc_attr($icon_color); ?>"></i></span>
                    <span class="download-title"><?php echo esc_html($file_title); ?></span>
                    <div class="clearfix"></div>
                </a>
            </div>
        <?php
        echo $after_widget;
    }
}

add_action( 'widgets_init', array('AnpsDownload', 'anps_register_widget'));
