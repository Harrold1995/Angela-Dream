<?php
class Anps_Customizer {
    public static function customizer_register($wp_customize) {
        /* Include custom controls */
        include_once 'customizer_controls/anps_divider_control.php';
        include_once 'customizer_controls/anps_desc_control.php';
        include_once 'customizer_controls/anps_sidebar_control.php';
        /* Add theme options panel */
        $wp_customize->add_panel('anps_customizer', array('title' =>esc_html__('Theme options', 'hairdresser'), 'description' => esc_html__('Theme options', 'hairdresser')));
        /* Theme options sections (categories) */
        $wp_customize->add_section('anps_colors', array('title' =>esc_html__('Main theme colors', 'hairdresser'), 'description' => esc_html__('Not satisfied with the premade color schemes? Here you can set your custom colors.', 'hairdresser'), 'panel'=>'anps_customizer'));
        $wp_customize->add_section('anps_button_colors', array('title' =>esc_html__('Button colors', 'hairdresser'), 'description' => esc_html__('Button colors', 'hairdresser'), 'panel'=>'anps_customizer'));
        $wp_customize->add_section('anps_typography', array('title' =>esc_html__('Typography', 'hairdresser'), 'description' => esc_html__('Typography', 'hairdresser'), 'panel'=>'anps_customizer'));
        $wp_customize->add_section('anps_page_layout', array('title' =>esc_html__('Page layout', 'hairdresser'), 'description' => esc_html__('Page layout', 'hairdresser'), 'panel'=>'anps_customizer'));
        $wp_customize->add_section('anps_page_setup', array('title' =>esc_html__('Page setup', 'hairdresser'), 'description' => esc_html__('Page setup', 'hairdresser'), 'panel'=>'anps_customizer'));
        $wp_customize->add_section('anps_header', array('title' =>esc_html__('Header options', 'hairdresser'), 'description' => esc_html__('Header options', 'hairdresser'), 'panel'=>'anps_customizer'));
        $wp_customize->add_section('anps_footer', array('title' =>esc_html__('Footer options', 'hairdresser'), 'description' => esc_html__('Footer options', 'hairdresser'), 'panel'=>'anps_customizer'));
        $wp_customize->add_section('anps_woocommerce', array('title' =>esc_html__('Woocommerce', 'hairdresser'), 'description' => esc_html__('Woocommerce', 'hairdresser'), 'panel'=>'anps_customizer'));
        $wp_customize->add_section('anps_logos', array('title' =>esc_html__('Logos', 'hairdresser'), 'description' => esc_html__('If you would like to use your logo and favicon, upload them to your theme here', 'hairdresser'), 'panel'=>'anps_customizer'));
        /* END Theme options sections (categories) */
        //Color management (main theme and buttons) settings
        Anps_Customizer::color_management($wp_customize);
        //Typography settings
        Anps_Customizer::typography($wp_customize);
        //Page layout settings
        Anps_Customizer::page_layout($wp_customize);
        //Page layout settings
        Anps_Customizer::page_setup($wp_customize);
        //Header options
        Anps_Customizer::header_options($wp_customize);
        //Footer options
        Anps_Customizer::footer_options($wp_customize);
        //Woocommerce
        Anps_Customizer::woocommerce($wp_customize);
        //Logos
        Anps_Customizer::logos($wp_customize);
    }
    /* Color management settings */
    private static function color_management($wp_customize) {
        /* Main theme colors */
        //text color
        $wp_customize->add_setting('anps_text_color', array('default'=>anps_get_option('', '#727272', 'text_color'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_text_color', array('label' => esc_html__('Text color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_text_color')));
        //primary color
        $wp_customize->add_setting('anps_primary_color', array('default'=>anps_get_option('', '#940855', 'primary_color'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_primary_color', array('label' => esc_html__('Primary color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_primary_color')));
        //hovers color
        $wp_customize->add_setting('anps_hovers_color', array('default'=>anps_get_option('', '#BD1470', 'hovers_color'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_hovers_color', array('label' => esc_html__('Hovers color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_hovers_color')));
        //menu text color
        $wp_customize->add_setting('anps_menu_text_color', array('default'=>anps_get_option('', '#000', 'menu_text_color'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_menu_text_color', array('label' => esc_html__('Menu text color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_menu_text_color')));
        //headings color
        $wp_customize->add_setting('anps_headings_color', array('default'=>anps_get_option('', '#000', 'headings_color'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_headings_color', array('label' => esc_html__('Headings color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_headings_color')));
        //Top bar text color
        $wp_customize->add_setting('anps_top_bar_color', array('default'=>anps_get_option('', '#bf5a91', 'top_bar_color'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_top_bar_color', array('label' => esc_html__('Top bar color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_top_bar_color')));
        //Top bar background color
        $wp_customize->add_setting('anps_top_bar_bg_color', array('default'=>anps_get_option('', '#940855', 'top_bar_bg_color'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_top_bar_bg_color', array('label' => esc_html__('Top bar background color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_top_bar_bg_color')));
        //Footer background color
        $wp_customize->add_setting('anps_footer_bg_color', array('default'=>anps_get_option('', '#141414', 'footer_bg_color'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_footer_bg_color', array('label' => esc_html__('Footer background color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_footer_bg_color')));
        //Copyright footer text color
        $wp_customize->add_setting('anps_copyright_footer_text_color', array('default'=>get_option('anps_copyright_footer_text_color', '#4a4a4a'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_copyright_footer_text_color', array('label' => esc_html__('Copyright footer text color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_copyright_footer_text_color')));
        //Copyright footer background color
        $wp_customize->add_setting('anps_copyright_footer_bg_color', array('default'=>anps_get_option('', '#0d0d0d', 'copyright_footer_bg_color'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_copyright_footer_bg_color', array('label' => esc_html__('Copyright footer background color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_copyright_footer_bg_color')));
        //Footer text color
        $wp_customize->add_setting('anps_footer_text_color', array('default'=>anps_get_option('', '#adadad', 'footer_text_color'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_footer_text_color', array('label' => esc_html__('Footer text color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_footer_text_color')));
        //Footer heading text color
        $wp_customize->add_setting('anps_heading_text_color', array('default'=>get_option('anps_heading_text_color', '#fff'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_heading_text_color', array('label' => esc_html__('Footer heading text color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_heading_text_color')));
        //Footer selected color
        $wp_customize->add_setting('anps_footer_selected_color', array('default'=>get_option('anps_footer_selected_color', ''), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_footer_selected_color', array('label' => esc_html__('Footer selected color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_footer_selected_color')));
        //Footer hover color
        $wp_customize->add_setting('anps_footer_hover_color', array('default'=>get_option('anps_footer_hover_color', ''), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_footer_hover_color', array('label' => esc_html__('Footer hover color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_footer_hover_color')));
        //Footer divider color
        $wp_customize->add_setting('anps_footer_divider_color', array('default'=>get_option('anps_footer_divider_color', '#fff'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_footer_divider_color', array('label' => esc_html__('Footer divider color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_footer_divider_color')));
        //Page header background color
        $wp_customize->add_setting('anps_nav_background_color', array('default'=>anps_get_option('', '#fff', 'nav_background_color'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_nav_background_color', array('label' => esc_html__('Page header background color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_nav_background_color')));
        //Submenu background color
        $wp_customize->add_setting('anps_submenu_background_color', array('default'=>anps_get_option('', '#fff', 'submenu_background_color'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_submenu_background_color', array('label' => esc_html__('Submenu background color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_submenu_background_color')));
        //Selected main menu color
        $wp_customize->add_setting('anps_curent_menu_color', array('default'=>get_option('anps_curent_menu_color', '#d54900'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_curent_menu_color', array('label' => esc_html__('Selected main menu color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_curent_menu_color')));
        //Submenu text color
        $wp_customize->add_setting('anps_submenu_text_color', array('default'=>anps_get_option('', '#000', 'submenu_text_color'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_submenu_text_color', array('label' => esc_html__('Submenu text color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_submenu_text_color')));
        //Side submenu background color
        $wp_customize->add_setting('anps_side_submenu_background_color', array('default'=>anps_get_option('', '', 'side_submenu_background_color'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_side_submenu_background_color', array('label' => esc_html__('Side submenu background color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_side_submenu_background_color')));
        //Side submenu text color
        $wp_customize->add_setting('anps_side_submenu_text_color', array('default'=>anps_get_option('', '', 'side_submenu_text_color'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_side_submenu_text_color', array('label' => esc_html__('Side submenu text color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_side_submenu_text_color')));
        //Side submenu text hover color
        $wp_customize->add_setting('anps_side_submenu_text_hover_color', array('default'=>anps_get_option('', '', 'side_submenu_text_hover_color'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_side_submenu_text_hover_color', array('label' => esc_html__('Side submenu text hover color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_side_submenu_text_hover_color')));
        //Logo bg color
        $wp_customize->add_setting('anps_logo_bg_color', array('default'=>get_option('anps_logo_bg_color'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_logo_bg_color', array('label' => esc_html__('Logo background color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_logo_bg_color')));
        //Above menu background color
        $wp_customize->add_setting('anps_above_menu_bg_color', array('default'=>get_option('anps_above_menu_bg_color'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_above_menu_bg_color', array('label' => esc_html__('Above menu background color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_above_menu_bg_color')));
        //Shopping cart item number background color
        $wp_customize->add_setting('anps_woo_cart_items_number_bg_color', array('default'=>get_option('anps_woo_cart_items_number_bg_color', '#d54900'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_woo_cart_items_number_bg_color', array('label' => esc_html__('Shopping cart item number background color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_woo_cart_items_number_bg_color')));
        //Shoping cart item number text color
        $wp_customize->add_setting('anps_woo_cart_items_number_color', array('default'=>get_option('anps_woo_cart_items_number_color', '#fff'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_woo_cart_items_number_color', array('label' => esc_html__('Shoping cart item number text color', 'hairdresser'), 'section' => 'anps_colors', 'settings'=>'anps_woo_cart_items_number_color')));

        /* END Main theme colors */
        /* Button colors */
        /* Modern button 1 */
        $wp_customize->add_setting('anps_modern_button_1_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_modern_button_1_desc', array('section' => 'anps_button_colors', 'settings'=>'anps_modern_button_1_desc', 'label'=>esc_html__('Modern button 1', 'hairdresser'), 'description'=>'')));
        //Button 1 background color
        $wp_customize->add_setting('anps_modern_button_1_bg_color', array('default'=>get_option('anps_modern_button_1_bg_color', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_1_bg_color', array('label' => esc_html__('Button 1 background color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_1_bg_color')));
        //Button 1 text color
        $wp_customize->add_setting('anps_modern_button_1_color', array('default'=>get_option('anps_modern_button_1_color', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_1_color', array('label' => esc_html__('Button 1 text color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_1_color')));
        //Button 1 hover background color
        $wp_customize->add_setting('anps_modern_button_1_hover_bg', array('default'=>get_option('anps_modern_button_1_hover_bg', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_1_hover_bg', array('label' => esc_html__('Button 1 hover background color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_1_hover_bg')));
        //Button 1 hover text color
        $wp_customize->add_setting('anps_modern_button_1_hover', array('default'=>get_option('anps_modern_button_1_hover', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_1_hover', array('label' => esc_html__('Button 1 hover text color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_1_hover')));
        //Button 1 border color
        $wp_customize->add_setting('anps_modern_button_1_border', array('default'=>get_option('anps_modern_button_1_border', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_1_border', array('label' => esc_html__('Button 1 border color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_1_border')));
        //Button 1 hover border color
        $wp_customize->add_setting('anps_modern_button_1_hover_border', array('default'=>get_option('anps_modern_button_1_hover_border', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_1_hover_border', array('label' => esc_html__('Button 1 hover border color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_1_hover_border')));
        //Button 1 border radius
        $wp_customize->add_setting('anps_modern_button_1_border_radius', array('default'=>get_option('anps_modern_button_1_border_radius', ''), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_modern_button_1_border_radius', array('label'=>esc_html__('Button 1 border radius', 'hairdresser'), 'settings' => 'anps_modern_button_1_border_radius', 'section' => 'anps_button_colors'));
        /* END Modern button 1 */
        /* Modern button 2 */
        $wp_customize->add_setting('anps_modern_button_2_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_modern_button_2_desc', array('section' => 'anps_button_colors', 'settings'=>'anps_modern_button_2_desc', 'label'=>esc_html__('Modern button 2', 'hairdresser'), 'description'=>'')));
        //Button 2 background color
        $wp_customize->add_setting('anps_modern_button_2_bg_color', array('default'=>get_option('anps_modern_button_2_bg_color', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_2_bg_color', array('label' => esc_html__('Button 2 background color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_2_bg_color')));
        //Button 2 text color
        $wp_customize->add_setting('anps_modern_button_2_color', array('default'=>get_option('anps_modern_button_2_color', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_2_color', array('label' => esc_html__('Button 2 text color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_2_color')));
        //Button 2 hover background color
        $wp_customize->add_setting('anps_modern_button_2_hover_bg', array('default'=>get_option('anps_modern_button_2_hover_bg', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_2_hover_bg', array('label' => esc_html__('Button 2 hover background color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_2_hover_bg')));
        //Button 2 hover text color
        $wp_customize->add_setting('anps_modern_button_2_hover', array('default'=>get_option('anps_modern_button_2_hover', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_2_hover', array('label' => esc_html__('Button 2 hover text color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_2_hover')));
        //Button 2 border color
        $wp_customize->add_setting('anps_modern_button_2_border', array('default'=>get_option('anps_modern_button_2_border', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_2_border', array('label' => esc_html__('Button 2 border color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_2_border')));
        //Button 2 hover border color
        $wp_customize->add_setting('anps_modern_button_2_hover_border', array('default'=>get_option('anps_modern_button_2_hover_border', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_2_hover_border', array('label' => esc_html__('Button 2 hover border color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_2_hover_border')));
        //Button 2 border radius
        $wp_customize->add_setting('anps_modern_button_2_border_radius', array('default'=>get_option('anps_modern_button_2_border_radius', ''), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_modern_button_2_border_radius', array('label'=>esc_html__('Button 2 border radius', 'hairdresser'), 'settings' => 'anps_modern_button_2_border_radius', 'section' => 'anps_button_colors'));
        /* END Modern button 2 */
        /* Modern button 3 */
        $wp_customize->add_setting('anps_modern_button_3_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_modern_button_3_desc', array('section' => 'anps_button_colors', 'settings'=>'anps_modern_button_3_desc', 'label'=>esc_html__('Modern button 3', 'hairdresser'), 'description'=>'')));
        //Button 3 background color
        $wp_customize->add_setting('anps_modern_button_3_bg_color', array('default'=>get_option('anps_modern_button_3_bg_color', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_3_bg_color', array('label' => esc_html__('Button 3 background color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_3_bg_color')));
        //Button 3 text color
        $wp_customize->add_setting('anps_modern_button_3_color', array('default'=>get_option('anps_modern_button_3_color', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_3_color', array('label' => esc_html__('Button 3 text color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_3_color')));
        //Button 3 hover background color
        $wp_customize->add_setting('anps_modern_button_3_hover_bg', array('default'=>get_option('anps_modern_button_3_hover_bg', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_3_hover_bg', array('label' => esc_html__('Button 3 hover background color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_3_hover_bg')));
        //Button 3 hover text color
        $wp_customize->add_setting('anps_modern_button_3_hover', array('default'=>get_option('anps_modern_button_3_hover', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_3_hover', array('label' => esc_html__('Button 3 hover text color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_3_hover')));
        //Button 3 border color
        $wp_customize->add_setting('anps_modern_button_3_border', array('default'=>get_option('anps_modern_button_3_border', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_3_border', array('label' => esc_html__('Button 3 border color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_3_border')));
        //Button 3 hover border color
        $wp_customize->add_setting('anps_modern_button_3_hover_border', array('default'=>get_option('anps_modern_button_3_hover_border', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_3_hover_border', array('label' => esc_html__('Button 3 hover border color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_3_hover_border')));
        //Button 3 border radius
        $wp_customize->add_setting('anps_modern_button_3_border_radius', array('default'=>get_option('anps_modern_button_3_border_radius', ''), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_modern_button_3_border_radius', array('label'=>esc_html__('Button 3 border radius', 'hairdresser'), 'settings' => 'anps_modern_button_3_border_radius', 'section' => 'anps_button_colors'));
        /* END Modern button 3 */
        /* Modern button 4 */
        $wp_customize->add_setting('anps_modern_button_4_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_modern_button_4_desc', array('section' => 'anps_button_colors', 'settings'=>'anps_modern_button_4_desc', 'label'=>esc_html__('Modern button 4', 'hairdresser'), 'description'=>'')));
        //Button 4 background color
        $wp_customize->add_setting('anps_modern_button_4_bg_color', array('default'=>get_option('anps_modern_button_4_bg_color', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_4_bg_color', array('label' => esc_html__('Button 4 background color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_4_bg_color')));
        //Button 4 text color
        $wp_customize->add_setting('anps_modern_button_4_color', array('default'=>get_option('anps_modern_button_4_color', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_4_color', array('label' => esc_html__('Button 4 text color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_4_color')));
        //Button 4 hover background color
        $wp_customize->add_setting('anps_modern_button_4_hover_bg', array('default'=>get_option('anps_modern_button_4_hover_bg', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_4_hover_bg', array('label' => esc_html__('Button 4 hover background color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_4_hover_bg')));
        //Button 4 hover text color
        $wp_customize->add_setting('anps_modern_button_4_hover', array('default'=>get_option('anps_modern_button_4_hover', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_4_hover', array('label' => esc_html__('Button 4 hover text color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_4_hover')));
        //Button 4 border color
        $wp_customize->add_setting('anps_modern_button_4_border', array('default'=>get_option('anps_modern_button_4_border', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_4_border', array('label' => esc_html__('Button 4 border color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_4_border')));
        //Button 4 hover border color
        $wp_customize->add_setting('anps_modern_button_4_hover_border', array('default'=>get_option('anps_modern_button_4_hover_border', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_4_hover_border', array('label' => esc_html__('Button 4 hover border color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_4_hover_border')));
        //Button 4 border radius
        $wp_customize->add_setting('anps_modern_button_4_border_radius', array('default'=>get_option('anps_modern_button_4_border_radius', ''), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_modern_button_4_border_radius', array('label'=>esc_html__('Button 4 border radius', 'hairdresser'), 'settings' => 'anps_modern_button_4_border_radius', 'section' => 'anps_button_colors'));
        /* END Modern button 4 */
        /* Modern button 5 */
        $wp_customize->add_setting('anps_modern_button_5_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_modern_button_5_desc', array('section' => 'anps_button_colors', 'settings'=>'anps_modern_button_5_desc', 'label'=>esc_html__('Modern button 5', 'hairdresser'), 'description'=>'')));
        //Button 5 background color
        $wp_customize->add_setting('anps_modern_button_5_bg_color', array('default'=>get_option('anps_modern_button_5_bg_color', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_5_bg_color', array('label' => esc_html__('Button 5 background color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_5_bg_color')));
        //Button 5 text color
        $wp_customize->add_setting('anps_modern_button_5_color', array('default'=>get_option('anps_modern_button_5_color', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_5_color', array('label' => esc_html__('Button 5 text color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_5_color')));
        //Button 5 hover background color
        $wp_customize->add_setting('anps_modern_button_5_hover_bg', array('default'=>get_option('anps_modern_button_5_hover_bg', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_5_hover_bg', array('label' => esc_html__('Button 5 hover background color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_5_hover_bg')));
        //Button 5 hover text color
        $wp_customize->add_setting('anps_modern_button_5_hover', array('default'=>get_option('anps_modern_button_5_hover', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_5_hover', array('label' => esc_html__('Button 5 hover text color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_5_hover')));
        //Button 5 border color
        $wp_customize->add_setting('anps_modern_button_5_border', array('default'=>get_option('anps_modern_button_5_border', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_5_border', array('label' => esc_html__('Button 5 border color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_5_border')));
        //Button 5 hover border color
        $wp_customize->add_setting('anps_modern_button_5_hover_border', array('default'=>get_option('anps_modern_button_5_hover_border', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_5_hover_border', array('label' => esc_html__('Button 5 hover border color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_5_hover_border')));
        //Button 5 border radius
        $wp_customize->add_setting('anps_modern_button_5_border_radius', array('default'=>get_option('anps_modern_button_5_border_radius', ''), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_modern_button_5_border_radius', array('label'=>esc_html__('Button 5 border radius', 'hairdresser'), 'settings' => 'anps_modern_button_5_border_radius', 'section' => 'anps_button_colors'));
        /* END Modern button 5 */
        /* Modern button 6 */
        $wp_customize->add_setting('anps_modern_button_6_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_modern_button_6_desc', array('section' => 'anps_button_colors', 'settings'=>'anps_modern_button_6_desc', 'label'=>esc_html__('Modern button 6', 'hairdresser'), 'description'=>'')));
        //Button 6 text color
        $wp_customize->add_setting('anps_modern_button_6_color', array('default'=>get_option('anps_modern_button_6_color', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_6_color', array('label' => esc_html__('Button 6 text color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_6_color')));
        //Button 6 hover text color
        $wp_customize->add_setting('anps_modern_button_6_hover', array('default'=>get_option('anps_modern_button_6_hover', '#940855'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_modern_button_6_hover', array('label' => esc_html__('Button 6 hover text color', 'hairdresser'), 'section' => 'anps_button_colors', 'settings'=>'anps_modern_button_6_hover')));
        /* END Modern button 6 */
        /* END Button colors */
    }
    /* Typography settings */
    private static function typography($wp_customize) {
        /* še manjka za izbiranje fontov */
        //Body font size
        $wp_customize->add_setting('anps_body_font_size', array('default'=>anps_get_option('', '14', 'body_font_size'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_body_font_size', array('label'=>esc_html__('Body font size', 'hairdresser'), 'settings' => 'anps_body_font_size', 'section' => 'anps_typography'));
        //Menu font size
        $wp_customize->add_setting('anps_menu_font_size', array('default'=>anps_get_option('', '14', 'menu_font_size'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_menu_font_size', array('label'=>esc_html__('Menu font size', 'hairdresser'), 'settings' => 'anps_menu_font_size', 'section' => 'anps_typography'));
        //Content heading 1 font size
        $wp_customize->add_setting('anps_h1_font_size', array('default'=>anps_get_option('', '31', 'h1_font_size'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_h1_font_size', array('label'=>esc_html__('Content heading 1 font size', 'hairdresser'), 'settings' => 'anps_h1_font_size', 'section' => 'anps_typography'));
        //Content heading 2 font size
        $wp_customize->add_setting('anps_h2_font_size', array('default'=>anps_get_option('', '24', 'h2_font_size'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_h2_font_size', array('label'=>esc_html__('Content heading 2 font size', 'hairdresser'), 'settings' => 'anps_h2_font_size', 'section' => 'anps_typography'));
        //Content heading 3 font size
        $wp_customize->add_setting('anps_h3_font_size', array('default'=>anps_get_option('', '21', 'h3_font_size'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_h3_font_size', array('label'=>esc_html__('Content heading 3 font size', 'hairdresser'), 'settings' => 'anps_h3_font_size', 'section' => 'anps_typography'));
        //Content heading 4 font size
        $wp_customize->add_setting('anps_h4_font_size', array('default'=>anps_get_option('', '18', 'h4_font_size'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_h4_font_size', array('label'=>esc_html__('Content heading 4 font size', 'hairdresser'), 'settings' => 'anps_h4_font_size', 'section' => 'anps_typography'));
        //Content heading 5 font size
        $wp_customize->add_setting('anps_h5_font_size', array('default'=>anps_get_option('', '16', 'h5_font_size'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_h5_font_size', array('label'=>esc_html__('Content heading 5 font size', 'hairdresser'), 'settings' => 'anps_h5_font_size', 'section' => 'anps_typography'));
        //Page heading 1 font size
        $wp_customize->add_setting('anps_page_heading_h1_font_size', array('default'=>anps_get_option('', '48', 'page_heading_h1_font_size'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_page_heading_h1_font_size', array('label'=>esc_html__('Page heading 1 font size', 'hairdresser'), 'settings' => 'anps_page_heading_h1_font_size', 'section' => 'anps_typography'));
        //Single blog page heading 1 font size
        $wp_customize->add_setting('anps_blog_heading_h1_font_size', array('default'=>anps_get_option('', '28', 'blog_heading_h1_font_size'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_blog_heading_h1_font_size', array('label'=>esc_html__('Single blog page heading 1 font size', 'hairdresser'), 'settings' => 'anps_blog_heading_h1_font_size', 'section' => 'anps_typography'));
        //Top bar font size font size
        $wp_customize->add_setting('anps_top_bar_font_size', array('default'=>get_option('anps_top_bar_font_size', '28'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_top_bar_font_size', array('label'=>esc_html__('Top bar font size font size', 'hairdresser'), 'settings' => 'anps_top_bar_font_size', 'section' => 'anps_typography'));      
    }
    /* Page layout settings */
    private static function page_layout($wp_customize) {
        $anps_data = get_option('anps_acc_info');
        //woocommerce style
        $wp_customize->add_setting('anps_contact_form_style', array('default'=>get_option('anps_contact_form_style', 'classic'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_contact_form_style', array(
            'label' => esc_html__('Style', 'hairdresser'),
            'section' => 'anps_page_layout',
            'type' => 'select',
            'choices' => array(
                'classic' => esc_html__('Classic', 'hairdresser'),
                'modern' => esc_html__('Modern', 'hairdresser')
            )
        ));
        //Page sidebar description
        $wp_customize->add_setting('anps_page_sidebar_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_page_sidebar_desc', array('section' => 'anps_page_layout', 'settings'=>'anps_page_sidebar_desc', 'label'=>esc_html__('Page Sidebars', 'hairdresser'), 'description'=>esc_html__('This will change the default sidebar value on all pages. It can be changed on each page individually.', 'hairdresser'))));
        //Page left sidebar
        $wp_customize->add_setting('anps_page_sidebar_left', array('type'=>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control(new Anps_Sidebar_Control($wp_customize, 'anps_page_sidebar_left', array('section' => 'anps_page_layout', 'settings'=>'anps_page_sidebar_left', 'label'=>esc_html__('Page sidebar left', 'hairdresser'))));
        //Page right sidebar
        $wp_customize->add_setting('anps_page_sidebar_right', array('type'=>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control(new Anps_Sidebar_Control($wp_customize, 'anps_page_sidebar_right', array('section' => 'anps_page_layout', 'settings'=>'anps_page_sidebar_right', 'label'=>esc_html__('Page sidebar right', 'hairdresser'))));
        //Post sidebar description
        $wp_customize->add_setting('anps_post_sidebar_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_post_sidebar_desc', array('section' => 'anps_page_layout', 'settings'=>'anps_post_sidebar_desc', 'label'=>esc_html__('Post Sidebars', 'hairdresser'), 'description'=>esc_html__('This will change the default sidebar value on all posts. It can be changed on each post individually.', 'hairdresser'))));
        //Post left sidebar
        $wp_customize->add_setting('anps_post_sidebar_left', array('type'=>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control(new Anps_Sidebar_Control($wp_customize, 'anps_post_sidebar_left', array('section' => 'anps_page_layout', 'settings'=>'anps_post_sidebar_left', 'label'=>esc_html__('Post sidebar left', 'hairdresser'))));
        //Post right sidebar
        $wp_customize->add_setting('anps_post_sidebar_right', array('type'=>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control(new Anps_Sidebar_Control($wp_customize, 'anps_post_sidebar_right', array('section' => 'anps_page_layout', 'settings'=>'anps_post_sidebar_right', 'label'=>esc_html__('Post sidebar right', 'hairdresser'))));
        //Disable page title, breadcrumbs and background
        $wp_customize->add_setting('anps_disable_heading', array('default'=>anps_get_option($anps_data, 'disable_heading'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_disable_heading', array('section'=>'anps_page_layout', 'type'=>'checkbox', 'label'=>esc_html__('Disable page title, breadcrumbs and background', 'hairdresser'), 'settings'=>'anps_disable_heading'));
        //divider heading
        $wp_customize->add_setting('anps_heading_divider', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Divider_Control($wp_customize, 'anps_heading_divider', array('section' => 'anps_page_layout', 'settings'=>'anps_heading_divider')));
        //Breadcrumbs
        $wp_customize->add_setting('anps_breadcrumbs', array('default'=>anps_get_option($anps_data, 'breadcrumbs'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_breadcrumbs', array('section'=>'anps_page_layout', 'type'=>'checkbox', 'label'=>esc_html__('Enable Bredcrumbs', 'hairdresser'), 'settings'=>'anps_breadcrumbs'));
        //To top button
        $wp_customize->add_setting('anps_to_top_button', array('default'=>get_option('anps_to_top_button', ''), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_to_top_button', array('section'=>'anps_page_layout', 'type'=>'checkbox', 'label'=>esc_html__('Enable to top button', 'hairdresser'), 'settings'=>'anps_to_top_button'));
        //To top button style
        $wp_customize->add_setting('anps_to_top_button_style', array('default'=>get_option('anps_to_top_button_style', '1'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_to_top_button_style', array(
            'label' => esc_html__('Style to top button', 'hairdresser'),
            'section' => 'anps_page_layout',
            'type' => 'select',
            'choices' => array(
                '1' => esc_html__('Style 1', 'hairdresser'),
                '2' => esc_html__('Style 2', 'hairdresser'),
            )
        ));
    }
    /* Page setup */
    private static function page_setup($wp_customize) {
        //Excerpt length
        $wp_customize->add_setting('anps_coming_soon', array('default'=>get_option('anps_coming_soon'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_coming_soon', array('label'=>esc_html__('Coming soon page', 'hairdresser'), 'type'=>'dropdown-pages', 'settings' => 'anps_coming_soon', 'section' => 'anps_page_setup'));
        //404 error page
        $wp_customize->add_setting('anps_error_page', array('default'=>get_option('anps_error_page'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_error_page', array('label'=>esc_html__('404 error page', 'hairdresser'), 'type'=>'dropdown-pages', 'settings' => 'anps_error_page', 'section' => 'anps_page_setup'));

        /* Portfolio */
        $wp_customize->add_setting('anps_portfolio_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_portfolio_desc', array('section' => 'anps_page_setup', 'settings'=>'anps_portfolio_desc', 'label'=>esc_html__('Portfolio settings', 'hairdresser'), 'description'=>esc_html__('Here you can select single portfolio style.', 'hairdresser'))));
        //Portfolio single style
        $wp_customize->add_setting('anps_portfolio_single', array('default'=>anps_get_option('', '', 'portfolio_single'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_portfolio_single', array(
            'label'=>esc_html__('Portfolio single style', 'hairdresser'),
            'type'=>'select',
            'settings' =>'anps_portfolio_single',
            'section' =>'anps_page_setup',
            'choices' =>array(
                'style-1'=>esc_html__('Style 1', 'hairdresser'),
                'style-2'=>esc_html__('Style 2', 'hairdresser')
            )
        ));
        /* END Portfolio*/

        //Post meta title and description
        $wp_customize->add_setting('anps_post_meta_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_post_meta_desc', array('section' => 'anps_page_setup', 'settings'=>'anps_post_meta_desc', 'label'=>esc_html__('Disable Post meta elements', 'hairdresser'), 'description'=>esc_html__('This allows you to disable post meta on all blog elements and pages. By default no field is checked, so that all meta elements are displayed.', 'hairdresser'))));
        //comments checkbox
        $wp_customize->add_setting('anps_post_meta_comments', array('default'=>get_option('anps_post_meta_comments', '1'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_post_meta_comments', array('section'=>'anps_page_setup', 'type'=>'checkbox', 'label'=>esc_html__('Comments', 'hairdresser'), 'settings'=>'anps_post_meta_comments'));
        //categories checkbox
        $wp_customize->add_setting('anps_post_meta_categories', array('default'=>get_option('anps_post_meta_categories', '1'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_post_meta_categories', array('section'=>'anps_page_setup', 'type'=>'checkbox', 'label'=>esc_html__('Categories', 'hairdresser'), 'settings'=>'anps_post_meta_categories'));
        //author checkbox
        $wp_customize->add_setting('anps_post_meta_author', array('default'=>get_option('anps_post_meta_author', '1'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_post_meta_author', array('section'=>'anps_page_setup', 'type'=>'checkbox', 'label'=>esc_html__('Author', 'hairdresser'), 'settings'=>'anps_post_meta_author'));
        //date checkbox
        $wp_customize->add_setting('anps_post_meta_date', array('default'=>get_option('anps_post_meta_date', '1'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_post_meta_date', array('section'=>'anps_page_setup', 'type'=>'checkbox', 'label'=>esc_html__('Date', 'hairdresser'), 'settings'=>'anps_post_meta_date'));
    }
    /* Header options */
    private static function header_options($wp_customize) {
        /* General top menu settings */
        $wp_customize->add_setting('anps_general_top_menu_settings', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_general_top_menu_settings', array('section' => 'anps_header', 'settings'=>'anps_general_top_menu_settings', 'label'=>esc_html__('General Top Menu Settings', 'hairdresser'), 'description'=>esc_html__('Here you can set top bar, above menu bar, sticky menu and other settings.', 'hairdresser'))));
        //Display top bar?
        $wp_customize->add_setting('anps_topmenu_style', array('default'=>anps_get_option('', '', 'topmenu_style'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_topmenu_style', array(
            'label' => esc_html__('Display top bar?', 'hairdresser'),
            'section' => 'anps_header',
            'type' => 'select',
            'choices' => array(
                '1' => esc_html__('Yes', 'hairdresser'),
                '2' => esc_html__('Only on tablet/mobile', 'hairdresser'),
                '4' => esc_html__('Only on desktop', 'hairdresser'),
                '3' => esc_html__('No', 'hairdresser')
            )
        ));
        //Top bar height in pixels
        $wp_customize->add_setting('anps_top_bar_height', array('default'=>get_option('anps_top_bar_height', '60'), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_top_bar_height', array('label'=>esc_html__('Top bar height in pixels', 'hairdresser'), 'settings' => 'anps_top_bar_height', 'section' => 'anps_header'));
        //Above nav bar
        $wp_customize->add_setting('anps_above_nav_bar', array('default'=>get_option('anps_above_nav_bar'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_above_nav_bar', array(
            'label' => esc_html__('Display above menu bar?', 'hairdresser'),
            'section' => 'anps_header',
            'type' => 'select',
            'choices' => array(
                '1' => esc_html__('Yes', 'hairdresser'),
                '0' => esc_html__('No', 'hairdresser')
            )
        ));
        //Menu
        $wp_customize->add_setting('anps_menu_style', array('default'=>anps_get_option('', '', 'menu_style'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_menu_style', array(
            'label' => esc_html__('Menu', 'hairdresser'),
            'section' => 'anps_header',
            'type' => 'select',
            'choices' => array(
                '1' => esc_html__('Normal', 'hairdresser'),
                '2' => esc_html__('Description', 'hairdresser')
            )
        ));
        //Menu center
        $wp_customize->add_setting('anps_menu_center', array('default'=>anps_get_option('', '', 'menu_center'), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_menu_center', array('section'=>'anps_header', 'type'=>'checkbox', 'label'=>esc_html__('Menu center', 'hairdresser'), 'settings'=>'anps_menu_center'));
        //Sticky menu
        $wp_customize->add_setting('anps_sticky_menu', array('default'=>anps_get_option('', '', 'sticky_menu'), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_sticky_menu', array('section'=>'anps_header', 'type'=>'checkbox', 'label'=>esc_html__('Sticky menu', 'hairdresser'), 'settings'=>'anps_sticky_menu'));
        //Display search icon in menu (desktop)?
        $wp_customize->add_setting('anps_search_icon', array('default'=>anps_get_option('', '1', 'search_icon'), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_search_icon', array('section'=>'anps_header', 'type'=>'checkbox', 'label'=>esc_html__('Display search icon in menu (desktop)?', 'hairdresser'), 'settings'=>'anps_search_icon'));
        //Display search on mobile and tablets?
        $wp_customize->add_setting('anps_search_icon_mobile', array('default'=>anps_get_option('', '1', 'search_icon_mobile'), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_search_icon_mobile', array('section'=>'anps_header', 'type'=>'checkbox', 'label'=>esc_html__('Display search on mobile and tablets?', 'hairdresser'), 'settings'=>'anps_search_icon_mobile'));
        //Enable menu walker (mega menu)
        $wp_customize->add_setting('anps_global_menu_walker', array('default'=>get_option('anps_global_menu_walker', '1'), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_global_menu_walker', array('section'=>'anps_header', 'type'=>'checkbox', 'label'=>esc_html__('Enable menu walker (mega menu)', 'hairdresser'), 'settings'=>'anps_global_menu_walker'));
        //Display background color behind logo
        $wp_customize->add_setting('anps_logo_background', array('default'=>get_option('anps_logo_background', '1'), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_logo_background', array('section'=>'anps_header', 'type'=>'checkbox', 'label'=>esc_html__('Display background color behind logo', 'hairdresser'), 'settings'=>'anps_logo_background'));
        /* Main menu settings */
        //Main menu height in pixels
        $wp_customize->add_setting('anps_main_menu_height', array('default'=>get_option('anps_main_menu_height'), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_main_menu_height', array('label'=>esc_html__('Main menu height in pixels', 'hairdresser'), 'settings' => 'anps_main_menu_height', 'section' => 'anps_header'));
        //Dropdown selection states
        $wp_customize->add_setting('anps_main_menu_selection', array('default'=>get_option('anps_main_menu_selection', '0'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_main_menu_selection', array(
            'label' => esc_html__('Dropdown selection states', 'hairdresser'),
            'section' => 'anps_header',
            'type' => 'select',
            'choices' => array(
                '0' => esc_html__('Hover color & bottom border', 'hairdresser'),
                '1' => esc_html__('Hover color', 'hairdresser')
            )
        ));
        /* END Main menu settings */
        /* END General top menu settings */
    }
    /* Footer options */
    private static function footer_options($wp_customize) {        
        /* Prefooter description */
        $wp_customize->add_setting('anps_prefooter_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_prefooter_desc', array('section' => 'anps_footer', 'settings'=>'anps_prefooter_desc', 'label'=>esc_html__('Prefooter options', 'hairdresser'), 'description'=>'')));
        //enable prefooter
        $wp_customize->add_setting('anps_prefooter', array('default'=>anps_get_option('', '', 'prefooter'), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_prefooter', array('section'=>'anps_footer', 'type'=>'checkbox', 'label'=>esc_html__('Enable prefooter', 'hairdresser'), 'settings'=>'anps_prefooter'));
        //PreFooter columns
        $wp_customize->add_setting('anps_prefooter_style', array('default'=>anps_get_option('', '', 'prefooter_style'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_prefooter_style', array(
            'label' => esc_html__('PreFooter columns', 'hairdresser'),
            'section' => 'anps_footer',
            'type' => 'select',
            'choices' => array(
                '0' => esc_html__('*** Select ***', 'hairdresser'),
                '5' => esc_html__('2/3 + 1/3', 'hairdresser'),
                '6' => esc_html__('1/3 + 2/3', 'hairdresser'),
                '2' => esc_html__('2 columns', 'hairdresser'),
                '3' => esc_html__('3 columns', 'hairdresser'),
                '4' => esc_html__('4 columns', 'hairdresser')
            )
        ));
        /* END Prefooter description */
        /* Footer banner */
        $wp_customize->add_setting('anps_footer_banner_global', array('default'=>get_option('anps_footer_banner_global', 1),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_footer_banner_global', array(
            'label' => esc_html__('Footer banner', 'hairdresser'),
            'section' => 'anps_footer',
            'type' => 'select',
            'choices' => array(
                1 => esc_html__('Enable', 'hairdresser'),
                2 => esc_html__('Disable', 'hairdresser'),
            )
        ));
        /* END Footer banner */

        /* Footer description */
        $wp_customize->add_setting('anps_footer_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_footer_desc', array('section' => 'anps_footer', 'settings'=>'anps_footer_desc', 'label'=>esc_html__('Footer options', 'hairdresser'), 'description'=>'')));
        //disable footer
        $wp_customize->add_setting('anps_footer_disable', array('default'=>anps_get_option('', '', 'footer_disable'), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_footer_disable', array('section'=>'anps_footer', 'type'=>'checkbox', 'label'=>esc_html__('Disable footer', 'hairdresser'), 'settings'=>'anps_footer_disable'));
        //Footer columns
        $wp_customize->add_setting('anps_footer_style', array('default'=>anps_get_option('', '4', 'footer_style'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_footer_style', array(
            'label' => esc_html__('Footer columns', 'hairdresser'),
            'section' => 'anps_footer',
            'type' => 'select',
            'choices' => array(
                '1' => esc_html__('1 column', 'hairdresser'),
                '2' => esc_html__('2 columns', 'hairdresser'),
                '3' => esc_html__('3 columns', 'hairdresser'),
                '4' => esc_html__('4 columns', 'hairdresser'),
                '5' => esc_html__('1/4 + 3/4', 'hairdresser'),
                '6' => esc_html__('3/4 + 1/4', 'hairdresser'),
            )
        ));
        //Footer style
        $wp_customize->add_setting('anps_footer_widget_style', array('default'=>get_option('anps_footer_widget_style'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_footer_widget_style', array(
            'label' => esc_html__('Footer style', 'hairdresser'),
            'section' => 'anps_footer',
            'type' => 'select',
            'choices' => array(
                '1' => esc_html__('style 1', 'hairdresser'),
                '2' => esc_html__('style 2', 'hairdresser'),
                '3' => esc_html__('style 3', 'hairdresser')
            )
        ));
        //Copyright footer
        $wp_customize->add_setting('anps_copyright_footer', array('default'=>anps_get_option('', '', 'copyright_footer'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_copyright_footer', array(
            'label' => esc_html__('Copyright footer', 'hairdresser'),
            'section' => 'anps_footer',
            'type' => 'select',
            'choices' => array(
                '0' => esc_html__('*** Select ***', 'hairdresser'),
                '1' => esc_html__('1 columns', 'hairdresser'),
                '2' => esc_html__('2 columns', 'hairdresser')
            )
        ));
        //Parallax footer
        $wp_customize->add_setting('anps_footer_parallax', array('default'=>get_option('anps_footer_parallax', ''), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_footer_parallax', array('section'=>'anps_footer', 'type'=>'checkbox', 'label'=>esc_html__('Parallax footer', 'hairdresser'), 'settings'=>'anps_footer_parallax'));
        //Mobile layout
        $wp_customize->add_setting('anps_footer_columns', array('default'=>anps_get_option('', '', 'footer_columns'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_footer_columns', array(
            'label' => esc_html__('Mobile layout', 'hairdresser'),
            'section' => 'anps_footer',
            'type' => 'select',
            'choices' => array(
                '0' => esc_html__('*** Select ***', 'hairdresser'),
                '1' => esc_html__('1 columns', 'hairdresser'),
                '2' => esc_html__('2 columns', 'hairdresser')
            )
        ));
    }
        /* Woocommerce */
    private static function woocommerce($wp_customize) {
        //display shopping cart icon in header
        $wp_customize->add_setting('anps_shopping_cart_header', array('default'=>anps_get_option('', 'shop_only', 'shopping_cart_header'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_shopping_cart_header', array(
            'label' => esc_html__('Display shopping cart icon in header?', 'hairdresser'),
            'section' => 'anps_woocommerce',
            'type' => 'select',
            'choices' => array(
                'hide' => esc_html__('Never display', 'hairdresser'),
                'shop_only' => esc_html__('Only on Woo pages', 'hairdresser'),
                'always' => esc_html__('Display everywhere', 'hairdresser')
            )
        ));
        //display shop pages product columns
        $wp_customize->add_setting('anps_products_columns', array('default'=>get_option('anps_woo_columns', '4'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_products_columns', array(
            'label' => esc_html__('Shop pages product columns', 'hairdresser'),
            'section' => 'anps_woocommerce',
            'type' => 'select',
            'choices' => array(
                '3' => esc_html__('3 columns', 'hairdresser'),
                '4' => esc_html__('4 columns', 'hairdresser')
            )
        ));
        //WooCommerce products per page
        $wp_customize->add_setting('anps_products_per_page', array('default'=>get_option('anps_products_per_page', '12'), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_products_per_page', array('label'=>esc_html__('Products per page', 'hairdresser'), 'settings' => 'anps_products_per_page', 'section' => 'anps_woocommerce'));
        //Product image zoom
        $wp_customize->add_setting('anps_product_zoom', array('default'=>get_option('anps_product_zoom', '1'), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_product_zoom', array('section'=>'anps_woocommerce', 'type'=>'checkbox', 'label'=>esc_html__('Product image zoom', 'hairdresser'), 'settings'=>'anps_product_zoom'));
        //Product image lightbox
        $wp_customize->add_setting('anps_product_lightbox', array('default'=>get_option('anps_product_lightbox', '1'), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_product_lightbox', array('section'=>'anps_woocommerce', 'type'=>'checkbox', 'label'=>esc_html__('Product image lightbox', 'hairdresser'), 'settings'=>'anps_product_lightbox'));
        //woocommerce style
        $wp_customize->add_setting('anps_style_woo', array('default'=>get_option('anps_style_woo', 'classic'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_style_woo', array(
            'label' => esc_html__('Style', 'hairdresser'),
            'section' => 'anps_woocommerce',
            'type' => 'select',
            'choices' => array(
                'classic' => esc_html__('Classic', 'hairdresser'),
                'modern' => esc_html__('Modern', 'hairdresser')
            )
        ));
    }
    /* Logos */
    private static function logos($wp_customize) {
        /* Get old data */
        $anps_media_data = get_option('anps_media_info');

        /* Heading background */
        $wp_customize->add_setting('anps_heading_bg_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_heading_bg_desc', array('section' => 'anps_logos', 'settings'=>'anps_heading_bg_desc', 'label'=>esc_html__('Heading background', 'hairdresser'), 'description'=>esc_html__('Heading background on page and search page.', 'hairdresser'))));
        //Page heading bg
        $wp_customize->add_setting('anps_heading_bg', array('default'=>anps_get_option($anps_media_data, 'heading_bg'), 'type' =>'option', 'sanitize_callback' => 'esc_url_raw', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'anps_heading_bg', array('label'=>esc_html__('Page heading background', 'hairdresser'), 'section'=>'anps_logos', 'settings'=>'anps_heading_bg')));
        //Search page heading bg
        $wp_customize->add_setting('anps_search_heading_bg', array('default'=>anps_get_option($anps_media_data, 'search_heading_bg'), 'type' =>'option', 'sanitize_callback' => 'esc_url_raw', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'anps_search_heading_bg', array('label'=>esc_html__('Search page heading background', 'hairdresser'), 'section'=>'anps_logos', 'settings'=>'anps_search_heading_bg')));
        /* END Heading background */

        /* Favicon and logos */
        $wp_customize->add_setting('anps_logos_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_logos_desc', array('section' => 'anps_logos', 'settings'=>'anps_logos_desc', 'label'=>esc_html__('Favicon and logos', 'hairdresser'), 'description'=>esc_html__('If you would like to use your logo and favicon, upload them to your theme here.', 'hairdresser'))));
        //Logo
        $wp_customize->add_setting('anps_logo', array('default'=>anps_get_option($anps_media_data, 'logo'), 'type' =>'option', 'sanitize_callback' => 'esc_url_raw', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'anps_logo', array('label'=>esc_html__('Logo', 'hairdresser'), 'section'=>'anps_logos', 'settings'=>'anps_logo')));
        //Sticky logo
        $wp_customize->add_setting('anps_sticky_logo', array('default'=>anps_get_option($anps_media_data, 'sticky_logo'), 'type' =>'option', 'sanitize_callback' => 'esc_url_raw', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'anps_sticky_logo', array('label'=>esc_html__('Sticky logo', 'hairdresser'), 'section'=>'anps_logos', 'settings'=>'anps_sticky_logo')));
        //Favicon
        $wp_customize->add_setting('anps_favicon', array('default'=>anps_get_option($anps_media_data, 'favicon'), 'type' =>'option', 'sanitize_callback' => 'esc_url_raw', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'anps_favicon', array('label'=>esc_html__('Favicon', 'hairdresser'), 'section'=>'anps_logos', 'settings'=>'anps_favicon')));
        /* END Favicon and logos */
    }
}
add_action('customize_register', array('Anps_Customizer', 'customizer_register'));
