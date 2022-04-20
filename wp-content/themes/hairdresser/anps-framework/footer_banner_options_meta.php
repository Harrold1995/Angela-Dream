<?php
add_action('add_meta_boxes', 'anps_footer_banner_add_custom_box');
add_action('save_post', 'anps_footer_banner_save_postdata');

function anps_footer_banner_add_custom_box() {
    $screens = array('post', 'page', 'portfolio', 'product', 'team');
    foreach ($screens as $screen) {
        add_meta_box('anps_footer_banner_meta', esc_html__('Footer banner', 'hairdresser'), 'anps_display_meta_box_footer_banner', $screen, 'side', 'core');     
    }
}
/* Topa bar, above nav menu */
function anps_display_meta_box_footer_banner($post) {
    $footer_banner_value = get_post_meta($post->ID, $key ='anps_footer_banner_page', $single = true ); 
    $data = '';
    $data .= '<div class="inside">';
    $arr = array(1 => esc_html__('Enable', 'hairdresser'), 2 => esc_html__('Disable', 'hairdresser'));
    $data .= '<select name="anps_footer_banner_page">';
    foreach($arr as $key => $item) {
        $selected = '';
        if($footer_banner_value == $key) {
            $selected = ' selected';
        }
        $data .= "<option value='$key'$selected>$item</option>";
    }
    $data .= '</select>';
    $data .= '</div>';
    echo $data;
}
function anps_footer_banner_save_postdata($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (empty($_POST)) {
        return;
    }
    if(!$_POST['post_ID']) {
        if(!$post_id) {
            return;
        } else {
            $_POST['post_ID'] = $post_id;
        }
    }
    $post_ID = $_POST['post_ID'];
    //header
    if (!isset($_POST['anps_footer_banner_page'])) {
        $_POST['anps_footer_banner_page'] = '';
    }
    //save data
    $footer_banner = $_POST['anps_footer_banner_page']; 
    add_post_meta($post_ID, 'anps_footer_banner_page', $footer_banner, true) or update_post_meta($post_ID, 'anps_footer_banner_page', $footer_banner);
}