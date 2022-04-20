<?php
add_action('add_meta_boxes', 'anps_heading_add_custom_box');
add_action('save_post', 'anps_heading_save_postdata');

function anps_heading_add_custom_box() {
    $screens = array('page', 'post');
    foreach($screens as $screen) {
        if($screen=="product") {
            $anps_priority = "low";
        } else {
            $anps_priority = "high";
        }
        add_meta_box('anps_heading_meta', esc_html__('Page title and breadcrumbs', 'hairdresser'), 'anps_display_meta_box_heading', $screen, 'normal', $anps_priority);
    }
    add_meta_box('anps_heading_meta', esc_html__('Page title and breadcrumbs', 'hairdresser'), 'anps_display_meta_box_heading', 'portfolio', 'normal', 'core');
}

function anps_display_meta_box_heading( $post ) {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script("wp_colorpicker");
    wp_enqueue_script("wp_backend_js");

    $value2 = get_post_meta($post->ID, $key ='anps_disable_heading', $single = true );
    $value_breadcrumbs = get_post_meta($post->ID, $key ='anps_disable_breadcrumbs', $single = true );
    $heading_value = get_post_meta($post->ID, $key ='heading_bg', $single = true );
    $page_heading_full = get_post_meta($post->ID, $key ='anps_page_heading_full', $single = true );
    $full_header_style = get_post_meta($post->ID, $key ='anps_full_header_style', $single = true );
    $full_desc = get_post_meta($post->ID, $key ='anps_full_page_desc', $single = true );
    $full_color_top_bar = get_post_meta($post->ID, $key ='anps_full_color_top_bar', $single = true );
    $full_color_title = get_post_meta($post->ID, $key ='anps_full_color_title', $single = true );
    $full_hover_color = get_post_meta($post->ID, $key ='anps_full_hover_color', $single = true );
    $full_screen_logo = get_post_meta($post->ID, $key ='anps_full_screen_logo', $single = true );
    $full_button_text = get_post_meta($post->ID, $key ='anps_full_button_text', $single = true );
    $full_button_link = get_post_meta($post->ID, $key ='anps_full_button_link', $single = true );
    $full_button_style = get_post_meta($post->ID, $key ='anps_full_button_style', $single = true );
    $checked = '';
    if($value2=='1') {
        $checked = 'checked';
    }
    $checked_full_screen = "";
    if($page_heading_full=='on') {
        $checked_full_screen = 'checked';
    }
    $checked_breadcrumbs = '';
    if($value_breadcrumbs=='on') {
        $checked_breadcrumbs = 'checked';
    }
    ?>
   <p></p>
    <table class="page-title min300">
        <tr>
            <td><?php esc_html_e('Disable heading', 'hairdresser'); ?></td>
            <td>
                <input class="hideall-trigger" type='checkbox' name='anps_disable_heading' value='1' <?php echo esc_attr($checked); ?>/>
            </td>
        </tr>
        <tr>
            <td><?php esc_html_e('Disable breadcrumbs', 'hairdresser'); ?></td>
            <td>
                <input type='checkbox' name='anps_disable_breadcrumbs' <?php echo esc_attr($checked_breadcrumbs); ?>/>
            </td>
        </tr>
    </table>
    <table class="page-title hideall min300">
        <tr>
            <td>
                <label for="heading_bg"><?php esc_html_e("Page heading background", 'hairdresser'); ?></label>
            </td>
            <td>
                <input id="heading_bg" type="text" size="36" name="heading_bg" value="<?php echo esc_attr($heading_value); ?>" />
                <input id="_btn" class="upload_image_button button" type="button" value="Upload" />
            </td>
        </tr>
        <?php if (get_option('anps_menu_type', '2')!='5' && get_option('anps_menu_type', '2')!='6') : ?>
            <tr>
                <td>
                    <?php esc_html_e("Full screen heading", 'hairdresser'); ?>
                </td>
                <td>
                    <input class="showhide-trigger" type="checkbox" name="anps_page_heading_full" <?php echo esc_attr($checked_full_screen); ?>/>
                </td>
            </tr>
        <?php endif; ?>
    </table>
    <table class="page-title showhide hideall min300">
        <tr>
            <td>
                <label for="anps_header_style"><?php esc_html_e('Header style', 'hairdresser'); ?></label>
            </td>
            <td>
                <?php $header_style_arr = array(
                    esc_html__('Classic', 'hairdresser') => 'classic',
                    esc_html__('White', 'hairdresser') => 'white',
                    esc_html__('Dark', 'hairdresser') => 'dark',
                    esc_html__('Fancy', 'hairdresser') => 'fancy'
                ); ?>
                <select name="anps_full_header_style" id="anps_full_header_style">
                    <?php
                    foreach($header_style_arr as $label => $value) :
                        $selected = '';
                        if($value == $full_header_style) {
                            $selected = ' selected';
                        }
                    ?>
                        <option value="<?php echo esc_attr($value); ?>"<?php echo esc_attr($selected); ?>><?php echo esc_attr($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="anps_full_page_desc"><?php esc_html_e('Page description', 'hairdresser'); ?></label>
            </td>
            <td>
                <textarea class="anps-meta-textarea" name="anps_full_page_desc" id="anps_full_page_desc"><?php echo esc_attr($full_desc); ?></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <label for="anps_full_color_top_bar"><?php esc_html_e("Color top bar", 'hairdresser'); ?></label>
            </td>
            <td>
                <input class='color-field' type='text' id='anps_full_color_top_bar' value='<?php echo esc_attr($full_color_top_bar); ?>' name='anps_full_color_top_bar' data-default-color='#f4f3ee' />
            </td>
        </tr>
        <tr>
            <td>
                <label for="anps_full_color_title"><?php esc_html_e("Color menu, title and breadcrumbs", 'hairdresser'); ?></label>
            </td>
            <td>
                <input class='color-field' type='text' id='anps_full_color_title' value='<?php echo esc_attr($full_color_title); ?>' name='anps_full_color_title' data-default-color='#f4f3ee' />
            </td>
        </tr>
        <tr>
            <td>
                <label for="anps_full_hover_color"><?php esc_html_e("Hover color", 'hairdresser'); ?></label>
            </td>
            <td>
                <input class='color-field' type='text' id='anps_full_hover_color' name='anps_full_hover_color' value='<?php echo esc_attr($full_hover_color); ?>' data-default-color='#f4f3ee' />
            </td>
        </tr>
        <tr>
            <td>
                <?php $images = get_children('post_type=attachment&post_mime_type=image'); ?>
                <select id="anps_full_screen_logo" name="anps_full_screen_logo">
                    <option value="0">Select logo</option>
                    <?php foreach ($images as $item) : ?>
                        <option <?php if ($item->guid == $full_screen_logo) {
                            echo 'selected="selected"';
                        } ?> value="<?php echo esc_attr($item->guid); ?>"><?php echo esc_html($item->post_title); ?></option>
                <?php endforeach; ?>
                </select>
            </td>
            <td>

            </td>
        </tr>
    </table>
    <h4 class="showhide hideall"><?php esc_html_e('Button settings', 'hairdresser'); ?></h4>
    <table class="showhide hideall min300">
        <tr>
            <td>
                <label for="anps_full_button_text"><?php esc_html_e('Button text', 'hairdresser'); ?></label>
            </td>
            <td>
                <input type="text" id="anps_full_button_text" name="anps_full_button_text" value="<?php echo esc_attr($full_button_text); ?>" />
            </td>
        </tr>
        <tr>
            <td>
                <label for="anps_full_button_link"><?php esc_html_e('Button link', 'hairdresser'); ?></label>
            </td>
            <td>
                <input type="text" id="anps_full_button_link" name="anps_full_button_link" value="<?php echo esc_attr($full_button_link); ?>" />
            </td>
        </tr>
        <tr>
            <td>
                <label for="anps_full_button_style"><?php esc_html_e('Button style', 'hairdresser'); ?></label>
            </td>
            <td>
                <?php
                $button_style_arr = array(
                    'modern-1' => esc_html__('Modern 1', 'hairdresser'),
                    'modern-2' => esc_html__('Modern 2', 'hairdresser'),
                    'modern-3' => esc_html__('Modern 3', 'hairdresser'),
                    'modern-4' => esc_html__('Modern 4', 'hairdresser'),
                    'modern-5' => esc_html__('Modern 5', 'hairdresser'),
                    'modern-6' => esc_html__('Modern 6', 'hairdresser'),
                );
                ?>
                <select name="anps_full_button_style" id="anps_full_button_style">
                    <?php
                    foreach($button_style_arr as $key => $item) :
                        $selected = '';
                        if($key == $full_button_style) {
                            $selected = ' selected';
                        }
                    ?>
                    <option value="<?php echo esc_attr($key); ?>"<?php echo esc_attr($selected); ?>><?php echo esc_attr($item); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    </table>
    <script>
        jQuery(document).ready(function() {
    var formfield;
    jQuery('.upload_image_button').click(function() {
        jQuery('html').addClass('Image');
        formfield = jQuery(this).prev().attr('name');
        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
        return false;
    });
    window.original_send_to_editor = window.send_to_editor;
    window.send_to_editor = function(html){
        if (formfield) {
            fileurl = jQuery('img','<div>' + html + '</div>').attr('src');
            jQuery('#'+formfield).val(fileurl);
            tb_remove();
            jQuery('html').removeClass('Image');
            formfield = '';
        } else {
            window.original_send_to_editor(html);
        }
    };

    });
    </script>
<?php
}

function anps_heading_save_postdata($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (empty($_POST))
        return;

    $post_ID = $_POST['post_ID'];

    if (!isset($_POST['anps_disable_heading'])) {
        $_POST['anps_disable_heading'] = '0';
    }
    $mydata2 = $_POST['anps_disable_heading'];

    if (!isset($_POST['anps_disable_breadcrumbs'])) {
        $_POST['anps_disable_breadcrumbs'] = '0';
    }
    $disable_breadcrumbs = $_POST['anps_disable_breadcrumbs'];

    if (!isset($_POST['heading_bg'])) {
        $_POST['heading_bg'] = '';
    }
    $heading_data = $_POST['heading_bg'];

    if (!isset($_POST['anps_page_heading_full'])) {
        $_POST['anps_page_heading_full'] = '';
    }
    $page_heading_full = $_POST['anps_page_heading_full'];

    if (!isset($_POST['anps_full_header_style'])) {
        $_POST['anps_full_header_style'] = '';
    }
    $full_header_style = $_POST['anps_full_header_style'];

    if (!isset($_POST['anps_full_page_desc'])) {
        $_POST['anps_full_page_desc'] = '';
    }
    $full_desc = $_POST['anps_full_page_desc'];

    if (!isset($_POST['anps_full_color_top_bar'])) {
        $_POST['anps_full_color_top_bar'] = '';
    }
    $full_color_top_bar = $_POST['anps_full_color_top_bar'];

    if (!isset($_POST['anps_full_color_title'])) {
        $_POST['anps_full_color_title'] = '';
    }
    $full_color_title = $_POST['anps_full_color_title'];

    if (!isset($_POST['anps_full_hover_color'])) {
        $_POST['anps_full_hover_color'] = '';
    }
    $full_hover_color = $_POST['anps_full_hover_color'];

    if (!isset($_POST['anps_full_screen_logo'])) {
        $_POST['anps_full_screen_logo'] = '';
    }
    $full_screen_logo = $_POST['anps_full_screen_logo'];

    if (!isset($_POST['anps_full_button_text'])) {
        $_POST['anps_full_button_text'] = '';
    }
    $full_button_text = $_POST['anps_full_button_text'];

    if (!isset($_POST['anps_full_button_link'])) {
        $_POST['anps_full_button_link'] = '';
    }
    $full_button_link = $_POST['anps_full_button_link'];

    if (!isset($_POST['anps_full_button_style'])) {
        $_POST['anps_full_button_style'] = '';
    }
    $full_button_style = $_POST['anps_full_button_style'];

    add_post_meta($post_ID, 'anps_disable_heading', $mydata2, true) or update_post_meta($post_ID, 'anps_disable_heading', $mydata2);
    add_post_meta($post_ID, 'anps_disable_breadcrumbs', $disable_breadcrumbs, true) or update_post_meta($post_ID, 'anps_disable_breadcrumbs', $disable_breadcrumbs);
    add_post_meta($post_ID, 'heading_bg', $heading_data, true) or update_post_meta($post_ID, 'heading_bg', $heading_data);
    add_post_meta($post_ID, 'anps_page_heading_full', $page_heading_full, true) or update_post_meta($post_ID, 'anps_page_heading_full', $page_heading_full);
    add_post_meta($post_ID, 'anps_full_header_style', $full_header_style, true) or update_post_meta($post_ID, 'anps_full_header_style', $full_header_style);
    add_post_meta($post_ID, 'anps_full_page_desc', $full_desc, true) or update_post_meta($post_ID, 'anps_full_page_desc', $full_desc);
    add_post_meta($post_ID, 'anps_full_color_top_bar', $full_color_top_bar, true) or update_post_meta($post_ID, 'anps_full_color_top_bar', $full_color_top_bar);
    add_post_meta($post_ID, 'anps_full_color_title', $full_color_title, true) or update_post_meta($post_ID, 'anps_full_color_title', $full_color_title);
    add_post_meta($post_ID, 'anps_full_hover_color', $full_hover_color, true) or update_post_meta($post_ID, 'anps_full_hover_color', $full_hover_color);
    add_post_meta($post_ID, 'anps_full_screen_logo', $full_screen_logo, true) or update_post_meta($post_ID, 'anps_full_screen_logo', $full_screen_logo);
    add_post_meta($post_ID, 'anps_full_button_text', $full_button_text, true) or update_post_meta($post_ID, 'anps_full_button_text', $full_button_text);
    add_post_meta($post_ID, 'anps_full_button_link', $full_button_link, true) or update_post_meta($post_ID, 'anps_full_button_link', $full_button_link);
    add_post_meta($post_ID, 'anps_full_button_style', $full_button_style, true) or update_post_meta($post_ID, 'anps_full_button_style', $full_button_style);
}
