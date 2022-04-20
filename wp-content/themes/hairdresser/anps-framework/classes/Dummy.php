<?php 
include_once(get_template_directory() . '/anps-framework/classes/Framework.php');
class AnpsDummy extends AnpsFramework {
        
    public function select() {
        return get_option('anps_dummy');
    }
    
    public function save() { 
        include_once(get_template_directory() . '/anps-framework/classes/AnpsImport.php');
        remove_image_size('anps-team-3');
        remove_image_size('anps-blog-grid');
        remove_image_size('anps-blog-full');
        remove_image_size('anps-blog-masonry-3-columns');
        remove_image_size('anps-post-thumb');
        remove_image_size('anps-portfolio-random-width-2');
        remove_image_size('anps-portfolio-random-height-2');
        remove_image_size('anps-portfolio-random-width-2-height-2');
        remove_image_size('anps-featured');
        remove_image_size('thumbnail');
        remove_image_size('medium');
        remove_image_size('large');

        update_option('font_source_1', 'Google fonts');
        update_option('font_source_2', 'Google fonts');
        update_option('font_source_navigation', 'Google fonts');

        $dummy_xml = '';
        if(isset($_POST['dummy1'])) {
            $dummy_xml = "dummy1";
            update_option("font_type_navigation", "Montserrat");
        } elseif(isset($_POST['dummy2'])) {
            $dummy_xml = "dummy2";
            update_option("font_type_navigation", "Montserrat");
        } elseif(isset($_POST['dummy3'])) {
            $dummy_xml = "dummy3";
            update_option("font_type_navigation", "Montserrat");
            update_option('anps_h2_font_size', '18');
        } elseif(isset($_POST['dummy4'])) {
            $dummy_xml = "dummy4";
            update_option("font_type_1", "Montserrat+Light");
            update_option("font_type_2", "Montserrat+Light");
            update_option("font_type_navigation", "Montserrat+Light");
        } elseif(isset($_POST['dummy5'])) {
            $dummy_xml = "dummy5";
            update_option("font_type_1", "Montserrat+Light");
            update_option("font_type_2", "Montserrat+Light");
            update_option("font_type_navigation", "Montserrat+Light");
        } elseif(isset($_POST['dummy6'])) {
            $dummy_xml = "dummy6";
            update_option("font_type_1", "Playfair+Display");
            update_option("font_type_2", "Montserrat");
            update_option("font_type_navigation", "Montserrat");
        }
        /* Import theme options */
        $anps_import_export->import_theme_options(get_template_directory() . '/anps-framework/classes/importer/' . $dummy_xml . '/anps-theme-options.json');

        /* Import dummy xml */
        include_once WP_PLUGIN_DIR . '/anps_theme_plugin/importer/wordpress-importer.php';
        $parse = new WP_Import();
        $parse->import(get_template_directory() . "/anps-framework/classes/importer/$dummy_xml/dummy.xml");
        global $wp_rewrite;
        $blog_id = get_page_by_title("Blog")->ID;
        $error_id = get_page_by_title("404 Page")->ID;
        $first_id = get_page_by_title("Home")->ID;
        $arr = array(
            'error_page'=>$error_id,
        );
        
        /* Post meta on blog */
        update_option('anps_post_meta_categories', '');
        update_option('anps_post_meta_author', '');

        update_option($this->prefix.'page_setup', $arr); 
        if($dummy_xml == 'dummy1' || $dummy_xml == 'dummy2' || $dummy_xml == 'dummy3') {
            update_option('page_for_posts', $blog_id);
        }
        update_option('page_on_front', $first_id);                                
        update_option('show_on_front', 'page'); 
        update_option('permalink_structure', '/%postname%/'); 
        $wp_rewrite->set_permalink_structure('/%postname%/');    
        $wp_rewrite->flush_rules();
        
        /* Set menu as primary */
        $menu_id = wp_get_nav_menus();
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id[0]->term_id;
        set_theme_mod('nav_menu_locations', $locations);
        update_option('menu_check', true);
        
        /* Install all widgets */
        $anps_import_export->import_widgets_data(get_template_directory() . "/anps-framework/classes/importer/$dummy_xml/anps-widgets.txt");
        
        /* Add easy appointments settings */
        $this->__add_easy_appointments();

        /* Add revolution slider demo data */
        $this->__add_revslider($dummy_xml);
    }

    protected function __add_easy_appointments() {
        if (class_exists('EasyAppointment')) {
            global $wpdb;

            /* Connections */

            $wpdb->query("INSERT IGNORE INTO `wp_ea_connections` (`id`, `group_id`, `location`, `service`, `worker`, `day_of_week`, `time_from`, `time_to`, `day_from`, `day_to`, `is_working`) VALUES
            (1, NULL, 1, 1, 1, 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday', '08:00:00', '20:00:00', '2017-01-01', '2020-01-01', 1),
            (2, 2, 2, 4, 1, 'Monday,Tuesday,Wednesday,Thursday,Friday', '08:00:00', '18:00:00', '2017-01-01', '2020-01-01', 1),
            (3, 2, 2, 3, 1, 'Monday,Tuesday,Wednesday,Thursday,Friday', '08:00:00', '18:00:00', '2017-01-01', '2020-01-01', 1),
            (4, 2, 2, 2, 1, 'Monday,Tuesday,Wednesday,Thursday,Friday', '08:00:00', '18:00:00', '2017-01-01', '2020-01-01', 1),
            (5, 2, 2, 1, 1, 'Monday,Tuesday,Wednesday,Thursday,Friday', '08:00:00', '18:00:00', '2017-01-01', '2020-01-01', 1),
            (6, 2, 1, 4, 1, 'Monday,Tuesday,Wednesday,Thursday,Friday', '08:00:00', '18:00:00', '2017-01-01', '2020-01-01', 1),
            (7, 2, 1, 3, 1, 'Monday,Tuesday,Wednesday,Thursday,Friday', '08:00:00', '18:00:00', '2017-01-01', '2020-01-01', 1),
            (8, 2, 1, 2, 1, 'Monday,Tuesday,Wednesday,Thursday,Friday', '08:00:00', '18:00:00', '2017-01-01', '2020-01-01', 1),
            (9, 2, 1, 1, 1, 'Monday,Tuesday,Wednesday,Thursday,Friday', '08:00:00', '18:00:00', '2017-01-01', '2020-01-01', 1);");

            /* Staff */

            $wpdb->query("INSERT IGNORE INTO `wp_ea_staff` (`id`, `name`, `description`, `email`, `phone`) VALUES
            (1, 'Tanya', 'Stylist', 'tanya@sample.com', '+386 40 222 455');");

            /* Services */

            $wpdb->query("INSERT IGNORE INTO `wp_ea_services` (`id`, `name`, `duration`, `slot_step`, `price`) VALUES
            (1, 'Haircare', 60, 60, '40.00'),
            (2, 'Manicure & pedicure', 60, 60, '25.00'),
            (3, 'Beauty therapy', 60, 60, '35.00'),
            (4, 'Makeup', 60, 60, '20.00');");

            /* Locations */
            $wpdb->query("INSERT IGNORE INTO `wp_ea_locations` (`id`, `name`, `address`, `location`, `cord`) VALUES
            (1, 'Washington', '300 Pennyslvania Ave', 'Washington', NULL),
            (2, 'New York', '300 6th Ave', 'New York', NULL);");

            /* Hide  */
            $wpdb->query("UPDATE wp_ea_options SET ea_value = '1' WHERE ea_key = 'price.hide'");
        }
    }
    
    protected function __add_revslider($dummy_xml) {
        /* Check if slider is installed */
        if(function_exists('set_revslider_as_theme')) {
            $slider = new RevSlider();
            if($dummy_xml=='dummy1') {
                $slider_name = "main-slider";
            } elseif($dummy_xml=='dummy2') {
                $slider_name = "main-slider";
            } elseif($dummy_xml=='dummy3') {
                $slider_name = "main-slider";
            } elseif($dummy_xml=='dummy4') {
                $slider_name = "demo-4-slider";
            } elseif($dummy_xml=='dummy5') {
                $slider_name = "home-slider";
            } elseif($dummy_xml=='dummy6') {
                $slider_name = "home-slider";
            }
            $slider->importSliderFromPost('', '', get_template_directory() . "/anps-framework/classes/importer/$dummy_xml/$slider_name.zip");
        } else {
            echo "Revolution slider is not active. Demo data for revolution slider can't be inserted.";
        }
    }  
}
$anps_dummy = new AnpsDummy();