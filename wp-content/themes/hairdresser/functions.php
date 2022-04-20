<?php
/* Title tag theme support */
add_theme_support('title-tag');

/* Custom header theme support */
add_theme_support('custom-header');

/* Custom background theme support */
add_theme_support('custom-background');

/* Image sizes */
add_theme_support('post-thumbnails');

/* team */
add_image_size('anps-team-3', 370, 360, false);
// Blog views
add_image_size('anps-blog-grid', 720, 412, true);
add_image_size('anps-blog-full', 1200);
add_image_size('anps-blog-masonry-3-columns', 360, 0, false);
// Recent blog, portfolio
add_image_size('anps-post-thumb', 360, 267, true);
// Portfolio random grid
add_image_size('anps-portfolio-random-width-2', 554, 202, true);
add_image_size('anps-portfolio-random-height-2', 262, 433, true);
add_image_size('anps-portfolio-random-width-2-height-2', 554, 433, true);
//featured
add_image_size('anps-featured', 720, 470, true);

if(!is_admin()) {
    include_once get_template_directory().'/anps-framework/classes/Options.php';
    $anps_page_data = $options->get_page_setup_data();
    $anps_options_data = $options->get_page_data();
    $anps_media_data = $options->get_media();
    $anps_social_data = $options->get_social();
    $anps_shop_data = $options->get_shop_setup_data();
}

function anps_get_option($class, $value, $name='') {
    if($name=='') {
        if(isset($class[$value])) {
            return get_option('anps_'.$value, $class[$value]);
        } else {
            return get_option('anps_'.$value, '');
        }
    } else {
        return get_option('anps_'.$name, get_option($name, $value));
    }
}

if(is_admin()) {
    /* Checking google fonts subsets for each font in admin */
    include_once get_template_directory() . '/anps-framework/classes/gfonts_ajax.php';
    /* Add custom fields to menus */
    include_once(get_template_directory() . '/anps-framework/classes/AnpsAdminMenu.php');
}
/* Include Customizer class */
include_once(get_template_directory() . '/anps-framework/classes/Customizer.php');
/* Include helper.php */
include_once get_template_directory().'/anps-framework/helpers.php';
if (!isset($content_width)) {
    $content_width = 967;
}
add_filter('widget_text', 'do_shortcode');
/* Shortcodes */
if (function_exists('anps_portfolio')) {
    include_once WP_PLUGIN_DIR . '/anps_theme_plugin/shortcodes_func.php';
}
/* Widgets */
include_once(get_template_directory() . '/anps-framework/widgets/widgets.php');
if (is_admin()) {
    include_once(get_template_directory() . '/shortcodes/shortcodes_init.php');
}
/* On setup theme */
add_action('after_setup_theme', 'anps_register_custom_fonts');
function anps_register_custom_fonts() {
    if (!isset($_GET['stylesheet'])) {
        $_GET['stylesheet'] = '';
    }
    $theme = wp_get_theme($_GET['stylesheet']);
    if (!isset($_GET['activated'])) {
        $_GET['activated'] = '';
    }
    if ($_GET['activated'] == 'true' && $theme->get_template() == "hairdresser") {
        include_once get_template_directory().'/anps-framework/classes/Options.php';
        include_once get_template_directory().'/anps-framework/classes/Style.php';
        /* Add google fonts*/
        if(get_option('anps_google_fonts', '')=='') {
            $style->update_gfonts_install();
        }
        /* Add custom fonts to options */
        $style->get_custom_fonts();
        /* Add default fonts */
        if(get_option('font_type_1', '')=='') {
            update_option("font_type_1", "Montserrat");
        }
        if(get_option('font_type_2', '')=='') {
            update_option("font_type_2", "PT+Sans");
        }
    }
    $fonts_installed = get_option('fonts_intalled');

    if($fonts_installed==1)
        return;

    /* Get custom font */
    include_once get_template_directory().'/anps-framework/classes/Style.php';
    $fonts = $style->get_custom_fonts();
    /* Update custom font */
    foreach($fonts as $name=>$value) {
        $arr_save[] = array('value'=>$value, 'name'=>$name);
    }
    update_option('anps_custom_fonts', $arr_save);
    update_option('fonts_intalled', 1);
}
/* Team metaboxes */
include_once(get_template_directory() . '/anps-framework/team_meta.php');
/* Portfolio metaboxes */
include_once(get_template_directory() . '/anps-framework/portfolio_meta.php');
/* Portfolio metaboxes */
include_once(get_template_directory() . '/anps-framework/metaboxes.php');
/* Menu metaboxes */
include_once(get_template_directory() . '/anps-framework/menu_meta.php');
/* Heading metaboxes */
include_once(get_template_directory() . '/anps-framework/heading_meta.php');
/* Featured video metabox */
include_once(get_template_directory() . '/anps-framework/featured_video_meta.php');
/* Footer banner page meta box */
include_once get_template_directory() . '/anps-framework/footer_banner_options_meta.php';
/* Header options page meta box */
include_once get_template_directory() . '/anps-framework/header_options_meta.php';

//install paralax slider
include_once(get_template_directory() . '/anps-framework/install_plugins.php');
/* Admin bar theme options menu */
include_once(get_template_directory() . '/anps-framework/classes/adminBar.php');
/* PHP header() NO ERRORS */
if (is_admin())
    add_action('init', 'anps_do_output_buffer');
function anps_do_output_buffer() {
    ob_start();
}
/* Infinite scroll 08.07.2013 */
function anps_infinite_scroll_init() {
    add_theme_support( 'infinite-scroll', array(
        'type'       => 'click',
        'footer_widgets' => true,
        'container'  => 'section-content',
        'footer'     => 'site-footer',
    ) );
}
add_action( 'init', 'anps_infinite_scroll_init' );
/* MegaMenu */
class anps_description_walker extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
        $append = "";
        $prepend = "";
        if(get_post_meta($item->ID, 'anps-megamenu', true)=='1') {
            $megamenu_wrapper_class = ' megamenu-wrapper';
            unset($item->classes[0]);
        } else {
            $megamenu_wrapper_class = '';
        }

        /* new menu label */
        $menu_label_value = get_post_meta($item->ID, 'anps-megamenu-label', true);
        /* END new menu label */

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $class_names = $value = '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="'. esc_attr( $class_names.$megamenu_wrapper_class ) . ' menu-item-depth-'.$depth.'"';

        $output .= $indent . '<li' . $value . $class_names .'>';
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url       ) .'"' : '';

        $children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));

        /* Description */
        $description  = ! empty( $item->description ) ? '<span class="menu-item-desc">'.esc_attr( $item->description ).'</span>' : '';
        $description = do_shortcode($description);
        if($depth>0) {
            $description = "";
        }
        /* END Description */
        $locations = get_theme_mod('nav_menu_locations');
        if($locations['primary']) {
            $item_output = "";
            $item_output = $args->before;
            $item_output .= '<a'. $attributes . '>';

            $item_output .= '<span class="menu-item-wrap">' . $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append . '</span>';
            if ($menu_label_value != '') {
                $item_output .= '<span class="menu-item-label">' . $menu_label_value . '</span>';
            }
            $item_output .= '</a>';
            $item_output .= $description.$args->link_after;
            $item_output .= $args->after;
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth = 0, $args, $args, $current_object_id = 0 );
        }
    }
}
function anps_custom_colors() {
    echo '<style type="text/css">
        #gallery_images .image {width: 23%;margin:0 1%;float: left}
        #gallery_images ul:after {content: "";display: table;clear: both;}
        #gallery_images .image img {max-width: 100%;height: 50px;}
    </style>';
}
add_action('admin_head', 'anps_custom_colors');
/* Post/Page gallery images */
include_once(get_template_directory() . '/anps-framework/gallery_images.php');

function anps_scripts_and_styles() {
    wp_enqueue_style("owl-css", get_template_directory_uri() . "/js/owl//assets/owl.carousel.css");

    global $is_IE, $anps_options_data;

    if ( $is_IE ) {
        wp_enqueue_style("anps-ie-fix", get_template_directory_uri() . '/css/ie-fix.css');
        wp_enqueue_script( "anps-iefix", get_template_directory_uri()  . "/js/ie-fix.js", '', '', true );
    }

    wp_register_script( "anps-isotope", get_template_directory_uri()  . "/js/jquery.isotope.min.js", '', '', true );
    wp_enqueue_script( "background-check", get_template_directory_uri()  . "/js/background-check.min.js", '', '', true );

    wp_enqueue_script( "bootstrap", get_template_directory_uri()  . "/js/bootstrap/bootstrap.min.js", '', '', true );

    $google_maps_api = get_option('anps_google_maps', '');

    if( $google_maps_api != '' ) {
        $google_maps_api = '?key=' . $google_maps_api;
    }

    wp_deregister_style('ea-frontend-bootstrap');
    wp_deregister_style('ea-bootstrap');
    wp_deregister_script('ea-front-bootstrap');
    wp_register_script(
        'ea-front-bootstrap',
        get_template_directory_uri() . '/js/frontend-bootstrap.js',
        array('jquery', 'jquery-ui-datepicker', 'ea-datepicker-localization', 'ea-momentjs'),
        false,
        true
    );

    if (function_exists('vc_iconpicker_base_register_css')) {
        vc_iconpicker_base_register_css();

        vc_icon_element_fonts_enqueue("fontawesome");
    }

    wp_register_script( "gmap3_link", "https://maps.google.com/maps/api/js" . $google_maps_api, '', '', true );
    wp_register_script( "gmap3", get_template_directory_uri()  . "/js/gmap3.min.js", array('jquery'), '', true );
    wp_register_script( "countto", get_template_directory_uri()  . "/js/countto.js", '', '', true );
    wp_enqueue_script( "colourbrightness", get_template_directory_uri()  . "/js/jquery.colourbrightness.min.js", '', '', true );
    wp_enqueue_script( "waypoints", get_template_directory_uri()  . "/js/waypoints.js", '', '', true );
    wp_enqueue_script( "anps-functions", get_template_directory_uri()  . "/js/functions.js", array('jquery'), '', true );
    wp_localize_script( 'anps-functions', 'anps', array(
        'search_placeholder' => __( 'Search...', 'hairdresser' ),
        'appointment_text' => __( 'Available appointment on', 'hairdresser' ),
        'confirm_text' => __( 'Appointment confirmation', 'hairdresser' ),
        'success_text' => __( 'Success', 'hairdresser' ),
        'book_text' => __( 'Book a visit', 'hairdresser' ),
        'home_url' => esc_url( home_url( '/' ) ),
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'theme_url' => get_template_directory_uri(),
        'calendar_icon' => anps_svg('calendar'),
        'view_icon' => anps_svg('view-cart'),
        'add_to_cart_icon' => anps_svg('add-to-cart'),
        'clock_icon' => anps_svg('clock'),
        'magnifier_icon' => anps_svg('magnifier'),
        'available_text' => esc_html__('Available', 'hairdresser'),
    ));
    wp_enqueue_script( "imagesloaded", get_template_directory_uri()  . "/js/imagesloaded.js", array('jquery'), '', true );
    wp_enqueue_script( "doubletap", get_template_directory_uri()  . "/js/doubletaptogo.js", array('jquery'), '', true );
    wp_enqueue_script("owl", get_template_directory_uri() . "/js/owl/owl.carousel.js",array("jquery"), "", true);

    if (get_option('font_source_1', "Google fonts")=='Google fonts') {
        $font1_subset = get_option("font_type_1_subsets", array("latin", "latin-ext"));
        $font1_implode_subset = implode(",", $font1_subset);
        $font_name = get_option('font_type_1', 'Montserrat');
        if(get_option('font_type_1', 'Montserrat') == 'Montserrat+Light') {
            $font_name = 'Montserrat';
        }
        wp_enqueue_style( "anps-font_type_1",  'https://fonts.googleapis.com/css?family=' .$font_name. ':400italic,400,500,600,700,300&subset='.$font1_implode_subset);
    } else {
        wp_enqueue_style( "anps-font_type_1",  'https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700,300&subset=latin,latin-ext');
    }

    if (get_option('font_source_2', "Google fonts")=='Google fonts' && get_option('font_type_1', 'Montserrat')!=get_option('font_type_2', 'PT+Sans')) {
        $font2_subset = get_option("font_type_2_subsets", array("latin", "latin-ext"));
        $font2_implode_subset = implode(",", $font2_subset);
        $font_name = get_option('font_type_2', 'PT+Sans');
        if(get_option('font_type_2', 'PT+Sans') == 'Montserrat+Light') {
            $font_name = 'Montserrat';
        }
        wp_enqueue_style( "anps-font_type_2",  'https://fonts.googleapis.com/css?family=' .$font_name. ':400italic,400,500,600,700,300&subset='.$font2_implode_subset);
    }

    if (get_option('font_source_navigation', "Google fonts")=='Google fonts' && get_option('font_type_1', 'Montserrat')!=get_option('font_type_navigation', "Montserrat")) {
        $font3_subset = get_option("font_type_navigation_subsets", array("latin", "latin-ext"));
        $font3_implode_subset = implode(",", $font3_subset);
        $font_name = get_option('font_type_navigation', 'Montserrat');
        if(get_option('font_type_navigation', 'Montserrat') == 'Montserrat+Light') {
            $font_name = 'Montserrat';
        }
        wp_enqueue_style( "anps-font_type_navigation",  'https://fonts.googleapis.com/css?family=' .$font_name. ':400italic,400,500,600,700,300&subset='.$font3_implode_subset);
    }

    if (get_option('anps_text_logo_source_1', "Google fonts")=='Google fonts' && get_option('font_type_1', 'Montserrat')!=get_option('anps_text_logo_font', 'Montserrat')) {
        $font_name = get_option('anps_text_logo_font', '');
        if(get_option('anps_text_logo_font', '') == 'Montserrat+Light') {
            $font_name = 'Montserrat';
        }
        if (get_option('anps_text_logo_font', '') !== '') {
            wp_enqueue_style( "anps_text_logo_font",  'https://fonts.googleapis.com/css?family=' . $font_name . ':400italic,400,500,600,700,300');
        }
    }

    wp_enqueue_style( "theme_main_style", get_bloginfo( 'stylesheet_url' ) );
    wp_enqueue_style( "anps_core", get_template_directory_uri() . "/css/core.css" );
    wp_enqueue_style( "theme_wordpress_style", get_template_directory_uri() . "/css/wordpress.css" );

    ob_start();
    anps_custom_styles();
    anps_custom_styles_buttons();
    $custom_css = ob_get_clean();

    $custom_css = trim(preg_replace('/\s+/', ' ', $custom_css));
    wp_add_inline_style( 'theme_wordpress_style', $custom_css );

    wp_enqueue_style( "anps-custom", get_template_directory_uri() . '/custom.css' );
    $responsive = "";
    if (isset($anps_options_data['responsive'])) {
        $responsive = $anps_options_data['responsive'];
    }
}
add_action( 'wp_enqueue_scripts', 'anps_scripts_and_styles', 999 );

load_theme_textdomain( "hairdresser", get_template_directory() . '/languages' );

/* Admin only scripts */

function anps_load_custom_wp_admin_scripts($hook) {
    /* Overwrite VC styling */
    wp_enqueue_style( "anps-vc_custom", get_template_directory_uri() . '/css/vc_custom.css' );
    if (function_exists('vc_iconpicker_base_register_css')) {
        vc_iconpicker_base_register_css();

        vc_icon_element_fonts_enqueue("fontawesome");
        vc_icon_element_fonts_enqueue("openiconic");
        vc_icon_element_fonts_enqueue("typicons");
        vc_icon_element_fonts_enqueue("entypo");
        vc_icon_element_fonts_enqueue("linecons");
        vc_icon_element_fonts_enqueue("monosocial");
        vc_icon_element_fonts_enqueue("material");
    }
    wp_enqueue_style( "anps-wp-backend", get_template_directory_uri() . "/anps-framework/css/wp-backend.css" );

    wp_enqueue_style( "selectize", get_template_directory_uri() . '/css/selectize.css' );
    wp_enqueue_script('selectize', get_template_directory_uri() . "/js/selectize.min.js", array( 'jquery' ), false, true);

    wp_register_script('ace-editor', get_template_directory_uri()  . '/js/ace.min.js', array('jquery'), '', true );

    ob_start();
    anps_custom_styles_buttons();
    $custom_css = ob_get_clean();

    wp_add_inline_style( 'anps-wp-backend', $custom_css );

    wp_enqueue_script('hideseek_js', get_template_directory_uri() . "/anps-framework/js/jquery.hideseek.min.js", array( 'jquery' ), false, true);
    wp_enqueue_script('anps-wp_backend_js', get_template_directory_uri() . "/anps-framework/js/wp_backend.js", array( 'jquery' ), false, true);
    wp_localize_script( 'anps-wp_backend_js', 'anps', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'theme_url' => get_template_directory_uri(),
    ));

    wp_register_script('wp_colorpicker', get_template_directory_uri() . "/anps-framework/js/wp_colorpicker.js", array( 'wp-color-picker' ), false, true);
    if( 'appearance_page_theme_options' != $hook ) {
        return;
    }
    /* Theme Options Style */
    wp_enqueue_style( "anps-admin-style", get_template_directory_uri() . '/anps-framework/css/admin-style.css' );
    if(!isset($_GET['sub_page']) ||
        $_GET['sub_page'] == "general_color_options" ||
        $_GET['sub_page'] == "modern_color_options" ||
        $_GET['sub_page'] == "classic_color_options" ||
        $_GET['sub_page'] == "header_options" ||
        $_GET['sub_page'] == "options" ||
        $_GET['sub_page'] == "options_page_setup") {
        wp_enqueue_style( "anps-colorpicker", get_template_directory_uri() . '/anps-framework/css/colorpicker.css' );
    }
    if (isset($_GET['sub_page']) &&
        ($_GET['sub_page'] == "options" ||
        $_GET['sub_page'] == "options_page")) {
        wp_enqueue_script( "anps-pattern", get_template_directory_uri() . "/anps-framework/js/pattern.js" );
    }
    if(!isset($_GET['sub_page']) ||
        $_GET['sub_page'] == "general_color_options" ||
        $_GET['sub_page'] == "modern_color_options" ||
        $_GET['sub_page'] == "classic_color_options" ||
        $_GET['sub_page'] == "options" ||
        $_GET['sub_page'] == "header_options" ||
        $_GET['sub_page'] == "options_page_setup") {
        wp_enqueue_script( "anps-colorpicker_theme", get_template_directory_uri() . "/anps-framework/js/colorpicker.js" );
        wp_enqueue_script( "anps-colorpicker_custom", get_template_directory_uri() . "/anps-framework/js/colorpicker_custom.js" );
    }
    wp_enqueue_script( "anps-theme-options", get_template_directory_uri() . "/anps-framework/js/theme-options.js" );
}
add_action( 'admin_enqueue_scripts', 'anps_load_custom_wp_admin_scripts' );


/*************************/
/*WOOCOMMERCE*/
/*************************/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    add_theme_support( 'woocommerce' );
    if (get_option('anps_product_zoom', '1') == '1') {
        add_theme_support( 'wc-product-gallery-zoom' );
    }
    if (get_option('anps_product_lightbox', '1') == '1') {
        add_theme_support( 'wc-product-gallery-lightbox' );
    }
        /* Number of related products */
    add_filter( 'woocommerce_output_related_products_args', 'anps_related_products' );
    function anps_related_products($args) {
        $shop_columns = get_option('anps_products_columns', 4);
        $args['posts_per_page'] = $shop_columns;
        return $args;
    }
    add_theme_support( 'wc-product-gallery-slider' );
    include_once(get_template_directory() . '/anps-framework/woocommerce/functions.php');
    add_filter( 'woocommerce_enqueue_styles', '__return_false' );

    function anps_products_per_page() {
        return get_option('anps_products_per_page', '12');
    }
    add_filter( 'loop_shop_per_page', 'anps_products_per_page', 20 );


    function anps_loop_columns() {
        return get_option('anps_products_columns', '4');
    }
    add_filter('loop_shop_columns', 'anps_loop_columns');

    function anps_woocommerce_header() {
        global $woocommerce;

        global $anps_shop_data;

        if( isset($anps_shop_data['shop_hide_cart']) && $anps_shop_data['shop_hide_cart'] == "on" ) {
            return false;
        }

        ?>
        <div class="woo-header-cart">
            <a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_html_e('View your shopping cart', 'hairdresser'); ?>">
                <span><?php echo esc_html($woocommerce->cart->cart_contents_count);?></span>
                <i class="fa fa-shopping-cart"></i>
            </a>
        </div>
        <?php
    }

    /* Load legacy files */
    function anps_wc_override_template_path(){
        return 'woocommerce-legacy/';
    }

    if( function_exists('WC') && WC()->version < '3.0.0' ) {
        add_filter( 'woocommerce_template_path', 'anps_wc_override_template_path' );
    }

    // Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
    add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

    function woocommerce_header_add_to_cart_fragment( $fragments ) {
        global $woocommerce;

        ob_start();

        ?>
        <a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_html_e('View your shopping cart', 'hairdresser'); ?>">
            <span><?php echo esc_html($woocommerce->cart->cart_contents_count);?></span>
            <i class="fa fa-shopping-cart"></i>
        </a>
        <div class="mini-cart">
            <?php woocommerce_mini_cart(); ?>
        </div>
        <?php

        $fragments['a.cart-contents'] = ob_get_clean();

        return $fragments;
    }

    /* Support for WooCommerce */
    add_theme_support("woocommerce");

    define("WOOCOMMERCE_USE_CSS", false );

    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

    function anps_before_loop_open() {
        echo '<div class="woocommerce-before-loop">';
    }
    add_action( 'woocommerce_before_shop_loop', 'anps_before_loop_open', 15 );
    
    function anps_before_loop_close() {
        echo '</div>';
    }
    add_action( 'woocommerce_before_shop_loop', 'anps_before_loop_close', 40 );
    
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
    remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );

    function anps_myaccount_sidebar($page) { ?>

            <div class="col-md-3 sidebar">

                <ul class="myaccount-menu">
                    <li class="widget-container widget_nav_menu">
                        <div class="menu-main-menu-container">
                            <ul class="menu">
                                <li class="menu-item<?php if($page == "myaccount"){ echo " current-menu-item page_item current_page_item current_page_parent"; } ?>"><a href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>"><?php esc_html_e("My Orders", 'hairdresser'); ?></a></li>
                                <?php if ( in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ): ?>
                                    <li class="menu-item<?php if($page == "wishlist"){ echo " current-menu-item page_item current_page_item current_page_parent"; } ?>"><a href="<?php echo get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) ); ?>"><?php esc_html_e("My Wishlist", 'hairdresser'); ?></a></li>
                                <?php endif; ?>
                                <li class="menu-item<?php if($page == "billing"){ echo " current-menu-item page_item current_page_item current_page_parent"; } ?>"><a href="<?php echo wc_get_endpoint_url( 'edit-address', 'billing' ); ?>"><?php esc_html_e("Edit Billing Address", 'hairdresser'); ?></a></li>
                                <li class="menu-item<?php if($page == "shipping"){ echo " current-menu-item page_item current_page_item current_page_parent"; } ?>"><a href="<?php echo wc_get_endpoint_url( 'edit-address', 'shipping' ); ?>"><?php esc_html_e("Edit Shipping Address", 'hairdresser'); ?></a></li>
                                <li class="menu-item<?php if($page == "change_account"){ echo " current-menu-item page_item current_page_item current_page_parent"; } ?>"><a href="<?php echo wc_customer_edit_account_url(); ?>"><?php esc_html_e("Change Account", 'hairdresser'); ?></a></li>
                                <?php
                                    if (is_user_logged_in()) {
                                        echo '<li><a href="'. wp_logout_url( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) ) .'">' . esc_html__("Logout", 'hairdresser') . '</a></li>';
                                    }
                                ?>
                            </ul>
                        </div>
                    </li>
                </ul>

            </div>
        <?php
    }
}
/*************************/
/*END WOOCOMMERCE*/
/*************************/
/* Set Revolution Slider as Theme */
if(function_exists( 'set_revslider_as_theme' )){
    add_action( 'init', 'anps_set_rev_as_theme' );
    function anps_set_rev_as_theme() {
        set_revslider_as_theme();
    }
}

/* Change comment form position (WordPress 4.4) */
function anps_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}
add_filter( 'comment_form_fields', 'anps_comment_field_to_bottom' );

/* WooCommerce 2.5 remove link around products */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

function anps_get_icons_list() {
    $icons = array();
    $font_awesome = vc_iconpicker_type_fontawesome(array());
    $font_awesome_new = array();

    foreach($font_awesome as $category => $icons_temp) {
        $font_awesome_new = array_merge($font_awesome_new, $icons_temp);
    }

    $icons['Font Awesome'] = $font_awesome_new;
    $icons['Open Iconic'] = vc_iconpicker_type_openiconic(array());
    $icons['Typicons'] = vc_iconpicker_type_typicons(array());
    $icons['Entypo'] = vc_iconpicker_type_entypo(array());
    $icons['Linecons'] = vc_iconpicker_type_linecons(array());
    $icons['Mono Social'] = vc_iconpicker_type_monosocial(array());
    $icons['Material'] = vc_iconpicker_type_material(array());

    $icons_anps = array(
        'Blow dryer 1',
        'Blow dryer 2',
        'Clean pores',
        'Cream 1',
        'Cream 2',
        'Electric razor',
        'Eyebrow',
        'Eyelash 1',
        'Eyelash 2',
        'Eyelash 3',
        'Hairbrush',
        'Hair coloring 1',
        'Hair coloring 2',
        'Hair comb 1',
        'Hair comb 2',
        'Hair treatment',
        'Make-up',
        'Make-up brush',
        'Manicure 1',
        'Manicure 2',
        'Manicure 3',
        'Nail polish',
        'Product',
        'Razor',
        'Scissors',
        'Shampoo 1',
        'Shampoo 2',
        'Spa 1',
        'Spa 2',
    );
    $construction_icons = array();

    foreach($icons_anps as $icon) {
        $construction_icons[] = array('anps-icon-' . sanitize_title($icon) => $icon);
    }

    $icons['Construction icons'] = $construction_icons;

    exit(json_encode($icons));
}

add_action( 'wp_ajax_anps_get_icons_list', 'anps_get_icons_list' );
add_action( 'wp_ajax_nopriv_anps_get_icons_list', 'anps_get_icons_list' );

function anps_load_vc_icons($icon) {
    $icon_type = explode(' ', $icon);

    if (function_exists('vc_icon_element_fonts_enqueue')) {
        switch($icon_type[0]) {
            case 'vc-oi': vc_icon_element_fonts_enqueue("openiconic"); break;
            case 'typcn': vc_icon_element_fonts_enqueue("typicons"); break;
            case 'entypo-icon': vc_icon_element_fonts_enqueue("entypo"); break;
            case 'vc_li': vc_icon_element_fonts_enqueue("linecons"); break;
            case 'vc-mono': vc_icon_element_fonts_enqueue("monosocial"); break;
            case 'vc-material': vc_icon_element_fonts_enqueue("material"); break;
            default: vc_icon_element_fonts_enqueue("fontawesome"); break;
        }
    }
}

function anps_svg($name) {
    $icon = wp_remote_get(get_template_directory_uri() . '/images/svgs/' . $name . '.svg');
    if(!is_wp_error($icon)) {
        return $icon['body'];
    }
}

/* Remove Newsletter styling */

add_filter('newsletter_enqueue_style', '__return_false');
