<?php
class AnpsAdminMenu {
    function __construct() {
        add_action('init', array($this, 'add_filters'));        
    }    
    static function anps_wp_edit_nav_menu_walker() {
        return 'Anps_Walker_Nav_Menu_Edit';
    }
    function add_filters() {
        //edit menu walker
        add_filter('wp_edit_nav_menu_walker', array( 'AnpsAdminMenu', 'anps_wp_edit_nav_menu_walker'));
        add_action('save_post', array($this, 'save_data' ), 10, 2);
    }
    function save_data($post_id, $post) {
        if ($post->post_type !== 'nav_menu_item') {
            return $post_id; 
        }
        if(!empty($_POST['menu-item-anps-megamenu-label'])) {
            foreach($_POST['menu-item-anps-megamenu-label'] as $key=>$value) { 
                update_post_meta($key, 'anps-megamenu-label', $value);
            }
        }
    }
}
require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
class Anps_Walker_Nav_Menu_Edit extends Walker_Nav_Menu_Edit {
    function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
        $item_output = '';
        parent::start_el($item_output, $item, $depth, $args);
        //add custom field to admin menu
        $item_output = preg_replace('/(?=<div[^>]+class="[^"]*submitbox)/', $this->anps_field('Menu label', 'text', $item->ID, 'anps-megamenu-label'), $item_output);
        $output .= $item_output;
    }
    function anps_field($title, $input_type, $item_id, $post_meta_key) {
        $value = get_post_meta($item_id, $post_meta_key, true);
        $data = '';
        $data .= "<p class='anps-megamenu-label description description-wide'>";
        $data .= "<label for='edit-menu-item-anps-megamenu-label-$item_id'>";
        $data .= $title.'<br>';
        $data .= "<input type='$input_type' value='$value' class='widefat code edit-menu-item-anps-megamenu-label' id='edit-menu-item-anps-megamenu-label-$item_id' name='menu-item-anps-megamenu-label[$item_id]'>";
        $data .= '</label>';
        $data .= '</p>';
        return $data;
    }
}
$anps_admin_menu = new AnpsAdminMenu();