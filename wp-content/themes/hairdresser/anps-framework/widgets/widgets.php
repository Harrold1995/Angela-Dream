<?php
/* Get all widgets */
function anps_get_all_widgets() {
    $dir = get_template_directory() . '/anps-framework/widgets';
    if ($handle = opendir($dir)) {
        $arr = array();
        // Get all files and store it to array
        while (false !== ($entry = readdir($handle))) {
            $arr[] = $entry;
        }
        closedir($handle);

        /* Remove widgets, ., .. */
        unset($arr[anps_remove_widget('widgets.php', $arr)], $arr[anps_remove_widget('.', $arr)], $arr[anps_remove_widget('..', $arr)]);
        return $arr;
    }
}
/* Remove widget function */
function anps_remove_widget($name, $arr) {
    return array_search($name, $arr);
}
/* Include all widgets */
foreach(anps_get_all_widgets() as $item) {
    $item_file = get_template_directory() . '/anps-framework/widgets/'.$item;
    if( file_exists( $item_file ) ) {
        include_once $item_file;
    }
}
/** Register sidebars by running anps_widgets_init() on the widgets_init hook. */
add_action('widgets_init', 'anps_widgets_init');
function anps_widgets_init() {
    // Area 1, located at the top of the sidebar.
    register_sidebar(array(
        'name' => esc_html__('Sidebar', 'hairdresser'),
        'id' => 'primary-widget-area',
        'description' => esc_html__('The primary widget area', 'hairdresser'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Secondary Sidebar', 'hairdresser'),
        'id' => 'secondary-widget-area',
        'description' => esc_html__('Secondary widget area', 'hairdresser'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Top bar left', 'hairdresser'),
        'id' => 'top-bar-left',
        'description' => esc_html__('Can only contain Text, Search, Custom menu and WPML Languge selector widgets', 'hairdresser'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Top bar right', 'hairdresser'),
        'id' => 'top-bar-right',
        'description' => esc_html__('Can only contain Text, Search, Custom menu and WPML Languge selector widgets', 'hairdresser'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    $above_nav_bar = get_option('anps_above_nav_bar', '0');
    if ($above_nav_bar=='1') {
        register_sidebar(array(
            'name' => esc_html__('Above navigation bar', 'hairdresser'),
            'id' => 'above-navigation-bar',
            'description' => esc_html__('This is a bar above main navigation. Can only contain Text, Search, Custom menu and WPML Languge selector widgets', 'hairdresser'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }

    /* Large above menu */
    register_sidebar(array(
        'name' => esc_html__('Large above menu', 'hairdresser'),
        'id' => 'large-above-menu',
        'description' => esc_html__('Large above menu.', 'hairdresser'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    if (anps_get_option('', '', 'vertical_menu') != '') {
        register_sidebar(array(
            'name' => esc_html__('Vertical menu bottom widget', 'hairdresser'),
            'id' => 'vertical-bottom-widget',
            'description' => esc_html__('This widget displays only on desktop mode in vertical menu. Can only contain Text and Social Icons widgets.', 'hairdresser'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }

    $prefooter = get_option('prefooter');
    if($prefooter=="on") {
        $prefooter_columns = anps_get_option('', '4', 'prefooter_style');
        if($prefooter_columns=='2' || $prefooter_columns=='5' || $prefooter_columns=='6') {
            register_sidebar(array(
                'name' => esc_html__('Prefooter 1', 'hairdresser'),
                'id' => 'prefooter-1',
                'description' => esc_html__('Prefooter 1', 'hairdresser'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => esc_html__('Prefooter 2', 'hairdresser'),
                'id' => 'prefooter-2',
                'description' => esc_html__('Prefooter 2', 'hairdresser'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
        } elseif($prefooter_columns=='3') {
            register_sidebar(array(
                'name' => esc_html__('Prefooter 1', 'hairdresser'),
                'id' => 'prefooter-1',
                'description' => esc_html__('Prefooter 1', 'hairdresser'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => esc_html__('Prefooter 2', 'hairdresser'),
                'id' => 'prefooter-2',
                'description' => esc_html__('Prefooter 2', 'hairdresser'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => esc_html__('Prefooter 3', 'hairdresser'),
                'id' => 'prefooter-3',
                'description' => esc_html__('Prefooter 3', 'hairdresser'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
        } elseif($prefooter_columns=='4' || $prefooter_columns=='0') {
            register_sidebar(array(
                'name' => esc_html__('Prefooter 1', 'hairdresser'),
                'id' => 'prefooter-1',
                'description' => esc_html__('Prefooter 1', 'hairdresser'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => esc_html__('Prefooter 2', 'hairdresser'),
                'id' => 'prefooter-2',
                'description' => esc_html__('Prefooter 2', 'hairdresser'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => esc_html__('Prefooter 3', 'hairdresser'),
                'id' => 'prefooter-3',
                'description' => esc_html__('Prefooter 3', 'hairdresser'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => esc_html__('Prefooter 4', 'hairdresser'),
                'id' => 'prefooter-4',
                'description' => esc_html__('Prefooter 4', 'hairdresser'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
        }
    }
    $footer_columns = anps_get_option('', '4', 'footer_style');
    if($footer_columns=='1') {
        register_sidebar(array(
            'name' => __('Footer 1', 'hairdresser'),
            'id' => 'footer-1',
            'description' => __('Footer 1', 'hairdresser'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    } else if($footer_columns=='2') {
        register_sidebar(array(
            'name' => esc_html__('Footer 1', 'hairdresser'),
            'id' => 'footer-1',
            'description' => esc_html__('Footer 1', 'hairdresser'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer 2', 'hairdresser'),
            'id' => 'footer-2',
            'description' => esc_html__('Footer 2', 'hairdresser'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    } elseif($footer_columns=='3') {
        register_sidebar(array(
            'name' => esc_html__('Footer 1', 'hairdresser'),
            'id' => 'footer-1',
            'description' => esc_html__('Footer 1', 'hairdresser'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer 2', 'hairdresser'),
            'id' => 'footer-2',
            'description' => esc_html__('Footer 2', 'hairdresser'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer 3', 'hairdresser'),
            'id' => 'footer-3',
            'description' => esc_html__('Footer 3', 'hairdresser'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    } elseif($footer_columns=='4' || $footer_columns=='0') {
        register_sidebar(array(
            'name' => esc_html__('Footer 1', 'hairdresser'),
            'id' => 'footer-1',
            'description' => esc_html__('Footer 1', 'hairdresser'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer 2', 'hairdresser'),
            'id' => 'footer-2',
            'description' => esc_html__('Footer 2', 'hairdresser'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer 3', 'hairdresser'),
            'id' => 'footer-3',
            'description' => esc_html__('Footer 3', 'hairdresser'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer 4', 'hairdresser'),
            'id' => 'footer-4',
            'description' => esc_html__('Footer 4', 'hairdresser'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    } else if($footer_columns=='5' || $footer_columns=='6') {
        register_sidebar(array(
            'name' => __('Footer 1', 'hairdresser'),
            'id' => 'footer-1',
            'description' => __('Footer 1', 'hairdresser'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => __('Footer 2', 'hairdresser'),
            'id' => 'footer-2',
            'description' => __('Footer 2', 'hairdresser'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }
    $copyright_footer = anps_get_option('', '1', 'copyright_footer');
    if($copyright_footer=="1" || $copyright_footer=="0") {
        register_sidebar(array(
            'name' => esc_html__('Copyright footer 1', 'hairdresser'),
            'id' => 'copyright-1',
            'description' => esc_html__('Can only contain Text and Social Icons widgets', 'hairdresser'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    } elseif($copyright_footer=="2") {
        register_sidebar(array(
            'name' => esc_html__('Copyright footer 1', 'hairdresser'),
            'id' => 'copyright-1',
            'description' => esc_html__('Can only contain Text and Social Icons widgets', 'hairdresser'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Copyright footer 2', 'hairdresser'),
            'id' => 'copyright-2',
            'description' => esc_html__('Can only contain Text and Social Icons widgets', 'hairdresser'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }
    register_sidebar(array(
        'name' => esc_html__('Services Sidebar', 'hairdresser'),
        'id' => 'services',
        'description' => esc_html__('Services Sidebar', 'hairdresser'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
