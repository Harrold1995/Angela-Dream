<?php
/* Header image, video, gallery (blog, portfolio) */
function anps_header_media($id, $image_class="") {
    if(has_post_thumbnail($id)) {
        $header_media = get_the_post_thumbnail($id, $image_class);
    }
    elseif(get_post_meta($id, $key ='anps_featured_video', $single = true )) {
        $header_media = do_shortcode(get_post_meta($id, $key ='anps_featured_video', $single = true ));
    }
    else {
        $header_media = "";
    }
    return $header_media;
}
/* Header image, video, gallery (single blog/portfolio) */
function anps_header_media_single($id, $image_class="") {
    if(has_post_thumbnail($id) && !get_post_meta($id, $key ='gallery_images', $single = true )) {
        $header_media = get_the_post_thumbnail($id, $image_class);
    }
    elseif(get_post_meta($id, $key ='anps_featured_video', $single = true )) {
        $header_media = do_shortcode(get_post_meta($id, $key ='anps_featured_video', $single = true ));
    }
    elseif(get_post_meta($id, $key ='gallery_images', $single = true )) {
        $gallery_images = explode(",",get_post_meta($id, $key ='gallery_images', $single = true ));

        foreach($gallery_images as $key=>$item) {
            if($item == '') {
                unset($gallery_images[$key]);
            }
        }
        $number_images = count($gallery_images);
        $header_media = "";
        $header_media .= "<div id='carousel' class='carousel slide'>";
        if($number_images>"1") {
            $header_media .= "<ol class='carousel-indicators'>";
            for($i=0;$i<count($gallery_images);$i++) {
                if($i==0) {
                    $active_class = "active";
                } else {
                    $active_class = "";
                }
                $header_media .= "<li data-target='#carousel' data-slide-to='".$i."' class='".$active_class."'></li>";
            }
            $header_media .= "</ol>";
        }
        $header_media .= "<div class='carousel-inner'>";
        $j=0;
        foreach($gallery_images as $item) {
            $image_src = wp_get_attachment_image_src($item, $image_class);
            $image_title = get_the_title($item);
            if($j==0) {
                $active_class = " active";
            } else {
                $active_class = "";
            }
            $header_media .= "<div class='item$active_class'>";
            $header_media .= "<img alt='".$image_title."'  src='".$image_src[0]."'>";
            $header_media .= "</div>";
            $j++;
        }
        $header_media .= "</div>";
        if($number_images>"1") {
            $header_media .= "<a class='left carousel-control' href='#carousel' data-slide='prev'>
                                <span class='fa fa-chevron-left'></span>
                              </a>
                              <a class='right carousel-control' href='#carousel' data-slide='next'>
                                <span class='fa fa-chevron-right'></span>
                              </a>";

        }
        $header_media .= "</div>";
    }
    else {
        $header_media = "";
    }
    return $header_media;
}
if(!function_exists('anps_header_media_portfolio_single')) {
    function anps_header_media_portfolio_single($id, $style = 'style-1') {
        if(get_post_meta($id, $key ='gallery_images', $single = true )) {
            $gallery_images = explode(",",get_post_meta($id, $key ='gallery_images', $single = true ));

            foreach($gallery_images as $key=>$item) {
                if($item == '') {
                    unset($gallery_images[$key]);
                }
            }

            if($style == 'style-1') {
                $header_media = "<div class='gallery'>";
                $header_media .= "<div class='gallery-inner'>";
                $j=0;
                foreach($gallery_images as $item) {
                    $image_src = wp_get_attachment_image_src($item, "full");
                    $image_title = get_the_title($item);
                    $header_media .= "<div class='item'>";
                    $header_media .= "<a rel='lightbox' href='".$image_src[0]."'>";
                    $header_media .= "<img alt='".$image_title."'  src='".$image_src[0]."'>";
                    $header_media .= "</a>";
                    $header_media .= "</div>";
                    $j++;
                }
                $header_media .= "</div>";
                $header_media .= "</div>";
            } else {
                $header_media = "<div id='carousel' class='carousel slide'>";
                if(count($gallery_images) > 1) {
                    $header_media .= "<ol class='carousel-indicators'>";
                    for($i=0;$i<count($gallery_images);$i++) {
                        if($i==0) {
                            $active_class = "active";
                        } else {
                            $active_class = "";
                        }
                        $header_media .= "<li data-target='#carousel' data-slide-to='".$i."' class='".$active_class."'></li>";
                    }
                    $header_media .= "</ol>";
                }
                $header_media .= "<div class='carousel-inner'>";
                $j=0;
                foreach($gallery_images as $item) {
                    $image_src = wp_get_attachment_image_src($item, "blog-full");
                    $image_title = get_the_title($item);
                    if($j==0) {
                        $active_class = " active";
                    } else {
                        $active_class = "";
                    }
                    $header_media .= "<div class='item$active_class'>";
                    $header_media .= "<img alt='".$image_title."'  src='".$image_src[0]."'>";
                    $header_media .= "</div>";
                    $j++;
                }
                $header_media .= "</div>";
                if(count($gallery_images) > 1) {
                    $header_media .= "<a class='left carousel-control' href='#carousel' data-slide='prev'>
                        <div class='tp-leftarrow tparrows default round'></div>
                      </a>
                      <a class='right carousel-control' href='#carousel' data-slide='next'>
                        <div class='tp-rightarrow tparrows default round'></div>
                      </a>";

                }
                $header_media .= "</div>";
                $header_media .= "</div>";

            }

        }
        elseif(has_post_thumbnail($id)) {
            $header_media = get_the_post_thumbnail($id, "full");
        }
        elseif(get_post_meta($id, $key ='anps_featured_video', $single = true )) {
            $header_media = do_shortcode(get_post_meta($id, $key ='anps_featured_video', $single = true ));
        }
        else {
            $header_media = "";
        }
        return $header_media;
    }
}
if( !function_exists('anps_footer_banner') ) {
    function anps_footer_banner() {
        $footer_banner_page = get_post_meta(anps_get_id(), $key ='anps_footer_banner_page', $single = true );

        $data = '';
        if(get_option('anps_footer_banner_global', 1) == 1 && $footer_banner_page != 2) {
            //get all footer banner data
            $args = array(
                'post_type' => 'footer_banner',
                'showposts' => -1,
            );
            $banners_query = new WP_Query( $args );
            $banner_posts = $banners_query->posts;
            if (count($banner_posts) > 0) {
                $banner_id = array_rand($banner_posts);
                $i = 0;
                while($banners_query->have_posts()) {
                    $banners_query->the_post();
                    if($i == $banner_id) {
                        echo '<div class="container footer-banner">';
                        the_content();
                        $vc_style = get_post_meta(get_the_ID(), $key ='_wpb_shortcodes_custom_css', $single = true );
                        echo "<style id='foo'>$vc_style</style>";
                        echo '</div>';
                    }
                    $i++;
                }
                wp_reset_postdata();
            }
        }
    }
}
if( !function_exists('anps_get_header') ) {
    function anps_get_header() {
        global $anps_page_data, $anps_options_data;

        /* Get fullscreen page option */
        $page_heading_full = '';
        if (get_option('anps_menu_type', '2')!='5' && get_option('anps_menu_type', '2')!='6') {
            $page_heading_full = get_post_meta(anps_get_id(), $key ='anps_page_heading_full', $single = true );
        }
        if( is_404() ) {
            $page_heading_full = get_post_meta(anps_get_option($anps_page_data, 'error_page'), $key ='anps_page_heading_full', $single = true );
        }
        //Let's get menu type
        $anps_menu_type = '2';
        if (anps_get_option('', '0','vertical-menu')!= '0') {
            $anps_menu_type = "2";
        } else if (is_front_page()) {
            $anps_menu_type = get_option('anps_menu_type', '2');
        }

        $anps_full_screen = get_option('anps_full_screen', '');

        $menu_type_class = ' site-header-style-normal';
        $header_position_class = '';
        $header_bg_style_class = '';
        $absoluteheader = 'false';
        $breadcrumbs_page = get_post_meta(anps_get_id(), $key ='anps_disable_breadcrumbs', $single = true );

        $dropdown_style = ' site-header-dropdown-' . get_option('anps_dropdown_style', '1');

        //Header classes and variables
        if($anps_menu_type == "1" || (isset($page_heading_full)&&$page_heading_full=="on")) {
            $menu_type_class = "";
            $header_position_class = "";
            $header_bg_style_class = " site-header-style-transparent";
            $absoluteheader = "true";
        } elseif($anps_menu_type == "3") {
            $menu_type_class = "";
            $header_position_class = " site-header-position-bottom";
            $header_bg_style_class = " site-header-style-transparent";
            $absoluteheader = "true";
        } elseif($anps_menu_type == "4") {
            $menu_type_class = " site-header-style-normal";
            $header_position_class = "";
            $header_bg_style_class = "";
            $absoluteheader = "false";
        }

        if(get_option('anps_menu_type', '2')=='5') {
            $menu_type_class = " site-header-style-full-width";
            $header_position_class = "";
            $anps_menu_type = '5';
        }
        if(get_option('anps_menu_type', '2')=='6') {
            $menu_type_class = " site-header-style-boxed";
            $header_position_class = "";
            $anps_menu_type = '6';
        }
        if(get_option('anps_menu_type', '2')=='7' || (get_option('anps_menu_type', '2')=='8' && !is_front_page())) {
            $menu_type_class = " site-header-style-modern";
            $header_bg_style_class = " site-header-style-normal";
            $header_position_class = "";
            $anps_menu_type = '7';
        }

        if(get_option('anps_menu_type', '2')=='8' && is_front_page()) {
            $menu_type_class = " site-header-style-modern";
            $header_bg_style_class = " site-header-style-transparent";
            $header_position_class = "";
            $anps_menu_type = '8';
        }

        //Top menu style
        $topmenu_style = anps_get_option('', '1','topmenu_style');

        //left, right and center menu styles:
        $menu_center = anps_get_option('', '', 'menu_center');
        if ($menu_center != "" && ($anps_menu_type == "2" || $anps_menu_type == "4")) {
          $menu_type_class .= " site-header-layout-center";
        } else if($anps_menu_type == "5") {
          $menu_type_class .= "";
        } else {
          $menu_type_class .=" site-header-layout-normal";
        }

        //sticky menu
        $sticky_menu = anps_get_option('', '', 'sticky_menu');
        $sticky_menu_class = "";
        if ($sticky_menu=="1" || $sticky_menu=="on") {
            $sticky_menu_class = " site-header-sticky";
        }
        //if coming soon page is enabled
        $coming_soon = anps_get_option('', '0', 'coming_soon');
        if($coming_soon=="0"||is_super_admin()) :

        //check for topmenu_style and add class depends on that value (mobile/desktop on/off)
        $hide_topmenu = '';
        if($topmenu_style=='4') {
            $hide_topmenu = ' hidden-xs hidden-sm';
        } elseif($topmenu_style=='2') {
            $hide_topmenu .= ' hidden-md hidden-lg';
        }
        /* Single page top bar on/off */
        $top_bar_site = get_post_meta(anps_get_id(), $key ='anps_header_options_top_bar', $single = true );
        //added option for transparent top bar menu type 1 (24.2.2015)
        if (($anps_menu_type == '1' || (isset($page_heading_full) && $page_heading_full!=''))
                && ((anps_get_option('', '', 'topmenu_style') != '3' && isset($top_bar_site) && $top_bar_site != '1')
                    || (anps_get_option('', '', 'topmenu_style') == '3' && isset($top_bar_site) && $top_bar_site == '2'))
        ) :
            $top_bar_bg_color = get_option('anps_front_topbar_bg_color', '');
            $transparent_class = '';
            if ((!isset($top_bar_bg_color) || $top_bar_bg_color=='')
                    || (isset($page_heading_full) && $page_heading_full!='')
            ) {
                $transparent_class = 'transparent ';
            }
            if(get_option('anps_menu_type', '2')=='7') {
                $transparent_class = '';
            }

            $top_bar_class = 'top-bar';
            $top_bar_class .= ' ' . $transparent_class;
            $top_bar_class .= ' ' . $hide_topmenu;
            $top_bar_class .= get_option('anps_top_bar_divider', '') != '' ? ' top-bar-divider' : '';
            if (is_active_sidebar( 'top-bar-left') || is_active_sidebar( 'top-bar-right') ) : ?>
            <div class="<?php echo esc_attr($top_bar_class); ?>"><?php anps_get_top_bar(); ?></div>
            <?php endif; ?>
        <?php endif;
        //topmenu
        if ($anps_menu_type != '1'
                && ((anps_get_option('', '', 'topmenu_style') != '3' && isset($top_bar_site) && $top_bar_site != '1')
                    || (anps_get_option('', '', 'topmenu_style') == '3' && isset($top_bar_site) && $top_bar_site == '2'))
                && (!isset($page_heading_full) || $page_heading_full=='')
        ) : 
            $top_bar_class = 'top-bar';
            $top_bar_class .= ' ' . $hide_topmenu;
            $top_bar_class .= get_option('anps_top_bar_divider', '') != '' ? ' top-bar-divider' : '';

            if (is_active_sidebar( 'top-bar-left') || is_active_sidebar( 'top-bar-right') ) : ?>
            <div class="<?php echo esc_attr($top_bar_class); ?>"><?php anps_get_top_bar(); ?></div>
            <?php endif; ?>
        <?php endif;
        // load shortcode from theme options textarea if needed
        if ($anps_menu_type=='3' || $anps_menu_type=='4') {
            echo do_shortcode($anps_full_screen);
        }

        global $anps_media_data;
        $has_sticky_class= '';

        $anps_header_styles = esc_attr($sticky_menu_class) . esc_attr($menu_type_class) . esc_attr($header_position_class) . esc_attr($header_bg_style_class) . esc_attr($has_sticky_class) . esc_attr($dropdown_style);
        /* Check for vertical */
        $is_vertical = anps_get_option($anps_options_data, 'vertical_menu') == '1';
        $header_style = '';
        if ($is_vertical) {
            $anps_header_styles = ' site-header-vertical-menu';
        }
        $header_bg_image = '';
        if (anps_get_option($anps_options_data, 'custom-header-bg-vertical') != "")
            {
            $header_bg_image = esc_attr(anps_get_option($anps_options_data, 'custom-header-bg-vertical'));
            $header_style = ' style= "background: transparent url('. $header_bg_image .') no-repeat scroll center 0 / 100% auto;"';
            }
        ?>
        <header class="site-header<?php echo esc_attr($anps_header_styles); ?><?php if(get_option('anps_main_menu_selection', '0')=='0' && !$is_vertical) { echo ' site-header-divider'; } ?>"<?php echo wp_kses_post($header_style);?>>
            <?php if(get_option('anps_menu_type', '2')!='5' && get_option('anps_menu_type', '2')!='6' || $is_vertical) : ?>
            <div class="nav-wrap">
                <div class="container"><?php anps_get_site_header();?>
                </div>
            </div>
            <?php else : ?>
            <div class="container preheader-wrap">
                <div class="site-logo<?php if (get_option('anps_text_logo','') != '') { echo " site-logo-text"; } ?>"><?php anps_get_logo(); ?></div>
                <?php if((is_active_sidebar( 'large-above-menu')) && !$is_vertical) : ?>
                    <?php
                        $class = 'large-above-menu';

                        $class .= ' large-above-menu-style-' . get_option('anps_large_above_menu_style', '1');
                    ?>
                    <div class="<?php echo esc_attr($class); ?>"><?php do_shortcode(dynamic_sidebar( 'large-above-menu' ));?></div>
                <?php endif;
                    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                        $shopping_cart_header = anps_get_option('', 'shop_only', 'shopping_cart_header');
                        if (($shopping_cart_header == 'shop_only' &&  is_woocommerce() ) || $shopping_cart_header == 'always' ) {
                            echo "<div class='hidden-md hidden-lg cartwrap'>";
                            anps_woocommerce_header();
                            echo "</div>";
                        }
                    }
                ?>
            </div>
            <div class="header-wrap">
                <div class="container">
                    <?php echo anps_get_menu(); ?>
                </div>
            </div>
            <?php endif; ?>
            <?php
            if( ($is_vertical != '') && (is_active_sidebar( 'vertical-bottom-widget')) ) : ?>
                <div class="vertical-bottom-sidebar">
                    <div class="vertical-bottom">
                        <?php do_shortcode(dynamic_sidebar( 'vertical-bottom-widget' ));?>
                    </div>
                </div>
            <?php endif;?>
        </header>
        <?php
            $disable_single_page = get_post_meta(anps_get_id(), $key ='anps_disable_heading', $single = true );
            if(!$disable_single_page=="1" && (!isset($page_heading_full) || $page_heading_full=="")) :
                if(is_front_page()==false && anps_get_option($anps_options_data, 'disable_heading')!="1") :
                    global $anps_media_data;
                    $style = "";
                    $class = "";
                    $single_page_bg = get_post_meta(anps_get_id(), $key ='heading_bg', $single = true );

                    /* Single page BG color */
                    $single_page_bg_color = get_post_meta(anps_get_id(), $key ='anps_heading_bg_color', $single = true );
                    if( $single_page_bg_color != '' ) {
                        $single_page_bg_color = ' background-color: ' . $single_page_bg_color . ';';
                    }

                    /* Theme Options BG color */
                    $anps_heading_bg_color = get_option('anps_page_heading_bg_color', '');
                    if( $anps_heading_bg_color != '' ) {
                        $anps_heading_bg_color = ' background-color: ' . $anps_heading_bg_color . ';';
                    }

                    if(is_search()) {
                        if(anps_get_option($anps_media_data, 'search_heading_bg')) {
                            $style = ' style="background-image: url('.esc_url(anps_get_option($anps_media_data, 'search_heading_bg')).');' . $anps_heading_bg_color . '"';
                        } elseif( $anps_heading_bg_color != '' ) {
                            $style = ' style="' . $anps_heading_bg_color . '"';
                        } else {
                            $class = "style-2";
                        }
                    } else if( is_404() ) {
                        $error_page_bg = get_post_meta(anps_get_option($anps_page_data, 'error_page'), $key ='heading_bg', $single = true );
                        $error_page_bg_color = get_post_meta(anps_get_option($anps_page_data, 'error_page'), $key ='anps_heading_bg_color', $single = true );

                        if( $error_page_bg_color != '' ) {
                            $error_page_bg_color = ' background-color: ' . $error_page_bg_color . ';';
                        } else if( $anps_heading_bg_color != '' ) {
                            $error_page_bg_color = $anps_heading_bg_color;
                        }

                        $style = ' style="background-image: url('.esc_url($error_page_bg).');' . $error_page_bg_color . '"';
                    } else {
                        $anps_heading_bg = anps_get_option($anps_media_data, 'heading_bg');

                        if( $single_page_bg_color != '' ) {
                            $anps_heading_bg_color = $single_page_bg_color;
                        }

                        if($single_page_bg) {
                            $style = ' style="background-image: url('.esc_url($single_page_bg).');' . $anps_heading_bg_color . '"';
                        }
                        elseif($anps_heading_bg && isset($anps_heading_bg)) {
                            $style = ' style="background-image: url('.esc_url($anps_heading_bg).');' . $anps_heading_bg_color . '"';
                        } elseif( $anps_heading_bg_color != '' ) {
                            $style = ' style="' . $anps_heading_bg_color . '"';
                        } else {
                            $class = "style-2";
                        }
                    }

                    if(get_option('anps_title_breadcrumbs', '1') == '1') : ?>
                        <div class='page-header <?php echo esc_attr($class); ?>' <?php echo wp_kses_post($style); ?>>
                            <div class='container'>
                                <?php echo anps_site_title(); ?>
                                <?php                                
                                if(anps_get_option($anps_options_data, 'breadcrumbs') != '1' && $breadcrumbs_page != 'on') {
                                    echo anps_the_breadcrumb();
                                }
                                ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="page-header text-center page-header-sm" <?php echo wp_kses_post($style); ?>">
                            <?php echo anps_site_title(); ?>
                        </div>
                        <?php if(anps_get_option($anps_options_data, 'breadcrumbs') !='1' && $breadcrumbs_page != 'on') :?>
                            <?php
                            $breadcrumbs_style = 'classic';
                            if (get_option('anps_title_breadcrumbs', '1') == '3') {
                                $breadcrumbs_style = 'modern';
                            }
                            ?>
                            <div class="page-breadcrumbs page-breadcrumbs--<?php echo esc_attr($breadcrumbs_style); ?>">
                                <div class="container">
                                    <?php echo anps_the_breadcrumb(); ?>
                                </div>
                            </div>
                        <?php endif;?>
                    <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php if(isset($page_heading_full)&&$page_heading_full=='on') : ?>
        <?php
            $heading_value = get_post_meta(anps_get_id(), $key ='heading_bg', $single = true );

            if( is_404() ) {
                $heading_value = get_post_meta(anps_get_option($anps_page_data, 'error_page'), $key ='heading_bg', $single = true );
            }

            /* Page heading BG color */
            $anps_heading_bg_color = get_option('anps_page_heading_bg_color', '');

            if( is_404() ) {
                $anps_heading_meta_bg_color = get_post_meta(anps_get_option($anps_page_data, 'error_page'), $key ='heading_bg', $single = true );
            } else {
                $anps_heading_meta_bg_color = get_post_meta(anps_get_id(), $key ='anps_heading_bg_color', $single = true );
            }

            if( $anps_heading_meta_bg_color != '' ) {
                $anps_heading_bg_color = $anps_heading_meta_bg_color;
            }

            if( $anps_heading_bg_color != '' ) {
                $anps_heading_bg_color = ' background-color: ' . $anps_heading_bg_color . ';';
            }
        ?>

        <?php if( get_option('anps_menu_type', '2')=='5'|| get_option('anps_menu_type', '2')=='6' ): ?>
            <?php
                $height_value = get_post_meta(anps_get_id(), $key ='anps_full_height', $single = true );

                if( $height_value ) {
                    $height_value = 'height: ' . $height_value . 'px; ';
                }
                ?>

            <div class="paralax-header parallax-window" style="<?php echo esc_attr($height_value); ?>background-image: url(<?php echo esc_url($heading_value); ?>);<?php echo esc_attr($anps_heading_bg_color); ?>">
        <?php endif;
        //Code for header type 7 is in header.php
        if(get_option('anps_menu_type', '2')!='7' && get_option('anps_menu_type', '2')!='8') : ?>
            <div class='page-heading'>
                <div class='container'>
                    <?php echo anps_site_title(); ?>
                    <?php if(anps_get_option($anps_options_data, 'breadcrumbs')!='1' && $breadcrumbs_page != 'on') { echo anps_the_breadcrumb(); } ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php
    endif;
    }
}

/* Product categories */
function anps_get_all_product_categories() {
    /* Remove result count and catalog ordering */
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
    $args = array(
        'taxonomy' => 'product_cat',
        'orderby' => 'name',
        'order' => 'ASC'
    );
    $data = '';
    /*
     * enable woocommerce
     * enable category filter in theme options
     * shop page, single product page, is_product_category
     */
    if(in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' )))
            && get_option('anps_woo_category_filter', '') == 1
            && (is_shop() || is_product_category() || is_product())) {
        $item_class = 'shop-filter__item';
        if(is_shop() && !is_product_category()) {
            $item_class .= " shop-filter__item--active'";
        }
        $all_categories = get_categories($args);
        $data = '<ul class="shop-filter">';
        $data .= "<li class='$item_class'><a class='shop-filter__link' href='".get_permalink(wc_get_page_id('shop'))."'>".esc_html__("All products", 'hairdresser')."</a></li>";
        foreach($all_categories as $item) {
            $item_class = 'shop-filter__item';
            $item_class .= is_product_category($item->slug) ? ' shop-filter__item--active' : '';
            $data .= "<li class='$item_class'><a class='shop-filter__link' href='".get_term_link($item->slug, 'product_cat')."'>".$item->name."</a></li>";
        }
        $data .= '</ul>';
    }
    return $data;
}

function anps_page_full_screen_style() {
    $full_color_top_bar = get_post_meta(anps_get_id(), $key ='anps_full_color_top_bar', $single = true );
    $full_color_title = get_post_meta(anps_get_id(), $key ='anps_full_color_title', $single = true );
    $full_hover_color = get_post_meta(anps_get_id(), $key ='anps_full_hover_color', $single = true );
    if(!isset($full_color_top_bar) || $full_color_top_bar=="") {
        $top_bar_color = get_option("top_bar_color");
    } else {
        $top_bar_color = $full_color_top_bar;
    }
    if(!isset($full_color_title) || $full_color_title=="") {
        $title_color = get_option("menu_text_color");
    } else {
        $title_color = $full_color_title;
    }
    if(!isset($full_hover_color) || $full_hover_color=="") {
        $hover_color = get_option("hovers_color");
    } else {
        $hover_color = $full_hover_color;
    }
    ?>
<style>
.paralax-header > .page-heading .breadcrumbs li a::after,
.paralax-header > .page-heading h1,
.paralax-header .page-desc,
.paralax-header > .page-heading ul.breadcrumbs,
.paralax-header > .page-heading ul.breadcrumbs a
 {color:<?php echo esc_attr($title_color); ?>;}

</style>

<?php
}

function anps_site_title() {
    get_template_part( 'includes/site_title' );
}

/* Fullscreen site button new modern style */
function anps_site_button() {
    $text = get_post_meta(anps_get_id(), $key ='anps_full_button_text', $single = true );
    $link = get_post_meta(anps_get_id(), $key ='anps_full_button_link', $single = true );
    $style = get_post_meta(anps_get_id(), $key ='anps_full_button_style', $single = true );
    if ($text !== '') {
        echo do_shortcode('[button link="'.$link.'" style_button="'.$style.'" size="medium"]'.$text.'[/button]');
    }
}
/* Fullscreen site description new modern style */
function anps_site_description() {
    $desc = get_post_meta(anps_get_id(), $key ='anps_full_page_desc', $single = true );
    if ($desc !== '') {
        return "<div class='page-desc'>$desc</div>";
    }
}

if(!function_exists('anps_get_sticky_logo')) {
    function anps_get_sticky_logo() {
        global $anps_media_data;
        if (anps_get_option($anps_media_data, 'sticky_logo') != '') : ?>
            <img class="logo-sticky" alt="Site logo" src="<?php echo esc_url(anps_get_option($anps_media_data, 'sticky_logo')); ?>">
        <?php endif;
    }
}

/* Breadcrumbs */
function anps_the_breadcrumb() {
    global $anps_page_data, $post;
    $return_val = "<ul class='breadcrumbs'>";

    $return_val .= '<li><a href="' . esc_url(home_url("/")) .'">' . esc_html__("Home", 'hairdresser') . '</a></li>';
    if (is_home() && !is_front_page()) {
        $return_val .= "<li>".get_the_title(get_option('page_for_posts'))."</li>";
    } else {
        if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_woocommerce() ) {
            $return_val = "<ul class='breadcrumbs'>";
            ob_start();
            woocommerce_breadcrumb();
            $return_val .= ob_get_clean();
        } elseif (is_category() || is_single()) {
            if (is_single()) {
                if (get_post_type() != "portfolio" && get_post_type() != "post") {
                    $obj = get_post_type_object( get_post_type() );
                    if( $obj->has_archive ) {
                        $return_val .= '<li><a href="' . get_post_type_archive_link(get_post_type()) . '">' . $obj->labels->name . '</a></li>';
                    }
                    $return_val .= '<li>' . get_the_title() . '</li>';
                } else {
                    $custom_breadcrumbs = get_post_meta(anps_get_id(), $key = 'custom_breadcrumbs', $single = true );
                    if($custom_breadcrumbs!="" && $custom_breadcrumbs!="0") {
                        $return_val .= "<li><a href='".get_permalink($custom_breadcrumbs)."'>".get_the_title($custom_breadcrumbs)."</a></li>";
                    }
                    $return_val .= "<li>".get_the_title()."</li>";
                }
            }
        }
        elseif (is_page()) {
            if(isset($post->post_parent) && ($post->post_parent!=0 || $post->post_parent!="")) {
                $parent_id  = $post->post_parent;
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
                    $parent_id  = $page->post_parent;
                }
                for($i=count($breadcrumbs);$i>=0;$i--) {
                    $return_val .= isset($breadcrumbs[$i]) ? $breadcrumbs[$i] : null;
                }
                $return_val .= "<li>".get_the_title()."</li>";
            } else {
                $return_val .= "<li>".get_the_title()."</li>";
            }
        } elseif (is_archive()) {
            if (is_author()) {
                $author = get_the_author_meta('display_name', get_query_var("author"));
                $return_val .= "<li>" . $author ."</li>";
            } elseif(is_tag()) {
                $cat = get_tag(get_queried_object_id());
                $return_val .= "<li>".$cat->name . "</li>";
            } else {
                if( get_post_type() == 'post' ) {
                    $return_val .= "<li>" . esc_html__("Archives for", 'hairdresser') . " " . get_the_date('F') . ' ' . get_the_date('Y')."</li>";
                } else {
                    $obj = get_post_type_object( get_post_type() );
                    if( $obj->has_archive ) {
                        $return_val .= '<li><a href="' . get_post_type_archive_link(get_post_type()) . '">' . $obj->labels->name . '</a></li>';
                    }
                }

            }
        } else {
            if (get_search_query() != "") {
            } else {
                if( isset($anps_page_data['error_page']) && $anps_page_data['error_page'] != '' && $anps_page_data['error_page'] != '0' ) {
                    query_posts('post_type=page&p=' . $anps_page_data['error_page']);

                    while(have_posts()) { the_post();
                        $return_val .= "<li>" . get_the_title() . "</li>";
                    }

                    wp_reset_query();
                } else {
                    $return_val .= "<li>" . esc_html__("Error 404", 'hairdresser') . "</li>";
                }
            }
        }
    }
    if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_woocommerce() ) {
    } elseif (single_cat_title("", false) != "" && !is_tag()) {
        $return_val .= "<li>" . single_cat_title("", false)."</li>";
    }
    $return_val .= "</ul>";
    return $return_val;
}
/* search container */
function anps_get_search_minimal() {
?>
    <div class="site-search-minimal">
        <form role="search" method="get" class="site-search-minimal__form" action="<?php echo esc_url(home_url( '/' )); ?>">
            <input name="s" type="text" class="site-search-minimal__input" placeholder="<?php _e("type and press &#8216;enter&#8217;", 'hairdresser'); ?>">
        </form>
    </div>
<?php
}
function anps_get_search() {
    ?>
    <div class="container">
      <form role="search" method="get" class="site-search-form" action="<?php echo esc_url(home_url( '/' )); ?>">
          <input name="s" type="text" class="site-search-input" placeholder="<?php _e("type and press &#8216;enter&#8217;", 'hairdresser'); ?>">
      </form>
      <button class="site-search-close">&times;</button>
    </div>
<?php
}
/* top bar menu */
function anps_get_top_bar() {
    echo '<div class="container">';
        echo '<div class="top-bar-left">';
                do_shortcode(dynamic_sidebar( 'top-bar-left' ));
        echo '</div>';
        echo '<div class="top-bar-right">';
                do_shortcode(dynamic_sidebar( 'top-bar-right' ));
        echo '</div>';
    echo '</div>';
    ?>
    <button class="top-bar-close">
      <i class="fa fa-chevron-down"></i>
      <span class="sr-only"><?php _e('Close top bar', 'hairdresser'); ?></span>
    </button>
    <?php
}

/* Style attribute helper functions */
function anps_style_bg_color($color) {
    return anps_style_attr(array('background-color' => $color));
}
function anps_style_color($color) {
    return anps_style_attr(array('color' => $color));
}
function anps_style_attr($styles) {
    $return = '';

    foreach($styles as $property => $value) {
        if ($value !== '') {
            $return .= $property . ': ' . $value . '; ';
        }
    }

    if ($return !== '') {
        $return = ' style="' . $return . '"';
    }

    return $return;
}
function anps_body_style() {
    global $anps_options_data;

    if (anps_get_option($anps_options_data, 'pattern') == '0' && anps_get_option($anps_options_data, 'boxed') == '1') {
        if(anps_get_option($anps_options_data, 'type') == "custom color") {
            echo ' style="background-color: ' . esc_attr(anps_get_option($anps_options_data, 'bg_color')) . ';"';
        }else if (anps_get_option($anps_options_data, 'type') == "stretched") {
            echo ' style="background: url(' . esc_url(anps_get_option($anps_options_data, 'custom_pattern')) . ') center center fixed;background-size: cover;     -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;"';
        } else {
            echo ' style="background: url(' . esc_url(anps_get_option($anps_options_data, 'custom_pattern')) . ')"';
        }
    }
}
function anps_theme_after_styles() {
    if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );

    get_template_part("includes/shortcut_icon");
}
/* Return site logo */
if(!function_exists('anps_get_logo')) {
    function anps_get_logo() {
        global $anps_media_data, $anps_options_data;
        $first_page_logo = get_option('anps_front_logo', '');
        $menu_type = get_option('anps_menu_type');
        $page_heading_full = get_post_meta(anps_get_id(), $key ='anps_page_heading_full', $single = true );
        $full_screen_logo = get_post_meta(anps_get_id(), $key ='anps_full_screen_logo', $single = true );
        $text_logo = get_option('anps_text_logo','');
        $size_sticky = array(120, 120);
        if( ! $size_sticky ) {
            $size_sticky = array(120, 120);
        }
        $logo_width = 158;
        $logo_height = 33;
        if( anps_get_option($anps_media_data, 'logo-width') !='' ) {
            $logo_width = anps_get_option($anps_media_data, 'logo-width');
        }

        if( anps_get_option($anps_media_data, 'logo-height') != '' ) {
            $logo_height = anps_get_option($anps_media_data, 'logo-height');
        }
        if(get_option('auto_adjust_logo', 'on') !='' ) {
            $logo_height = 'auto';
            $logo_width = 'auto';
        }
        else { $logo_width .='px';
        }

        echo '<a href="' . esc_url(home_url("/")) . '">';
        if(anps_get_option($anps_options_data, 'vertical_menu') != '1' ) {
            anps_get_sticky_logo();
        }

        if(isset($page_heading_full) && $page_heading_full=="on" && isset($full_screen_logo) && $full_screen_logo!="0") : ?>
            <img style="width: <?php echo esc_attr($logo_width); ?>; height: <?php echo esc_attr($logo_height); ?>px" alt="Site logo" src="<?php echo esc_url($full_screen_logo); ?>">
        <?php else :
        if(($menu_type==1 || $menu_type==3) && $first_page_logo && (is_front_page())) : ?>
            <img style="width: <?php echo esc_attr($logo_width); ?>; height: <?php echo esc_attr($logo_height); ?>px" alt="Site logo" src="<?php echo esc_url($first_page_logo); ?>">
        <?php
        elseif (anps_get_option($anps_media_data, 'logo') != '') : ?>
            <img style="width: <?php echo esc_attr($logo_width); ?>; height: <?php echo esc_attr($logo_height); ?>px" alt="Site logo" src="<?php echo esc_url(anps_get_option($anps_media_data, 'logo')); ?>">
        <?php elseif(isset($text_logo) && $text_logo!='') : ?>
            <?php echo str_replace('\\"', '"', $text_logo); ?></a>
        <?php else: ?>
            <img style="width: <?php echo esc_attr($logo_width); ?>; height: <?php echo esc_attr($logo_height); ?>px" alt="Site logo" src="http://anpsthemes.com/hairdresser/wp-content/uploads/2015/10/main-logo-1.png">
        <?php endif;
        endif;
        echo '</a>';
    }
}
/* Tags and author */
function anps_tagsAndAuthor() {
    ?>
        <div class="tags-author">
    <?php echo __('posted by', 'hairdresser'); ?> <?php echo get_the_author(); ?>
    <?php
    $posttags = get_the_tags();
    if ($posttags) {
        echo " &nbsp;|&nbsp; ";
        echo __('Taged as', 'hairdresser') . " - ";
        $first_tag = true;
        foreach ($posttags as $tag) {
            if ( ! $first_tag) {
                echo ', ';
            }
            echo '<a href="' . esc_url(home_url('/')) . 'tag/' . esc_html($tag->slug) . '/">';
            echo esc_html($tag->name);
            echo '</a>';
            $first_tag = false;
        }
    }
    ?>
        </div>
    <?php
}
/* Gravatar */
add_filter('avatar_defaults', 'anps_newgravatar');
function anps_newgravatar($avatar_defaults) {
    $myavatar = get_template_directory_uri() . '/images/move_default_avatar.jpg';
    $avatar_defaults[$myavatar] = "Anps default avatar";
    return $avatar_defaults;
}
/* Get post thumbnail src */
function anps_get_the_post_thumbnail_src($img) {
    return (preg_match('~\bsrc="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}
if( !function_exists('anps_get_menu') ) {
    function anps_get_menu() {
        $menu_center = anps_get_option('', '', 'menu_center');
        if( isset($_GET['header']) && $_GET['header'] == 'type-3' ) {
            $menu_center = 'on';
        }

        $menu_description = '';
        $menu_style = anps_get_option('', '1', 'menu_style');
        if( isset($_GET['header']) && $_GET['header'] == 'type-2' ) {
            $menu_style = '2';
        }

        if( $menu_style == '2' ) {
            $menu_description = ' description';
        }
        global $anps_options_data;
        //above nav bar && single above nav bar
        $above_nav_bar = get_option('anps_above_nav_bar', '');
        $above_nav_bar_site = get_post_meta(anps_get_id(), $key ='anps_header_options_above_menu', $single = true );

        /* Max mega menu */
        $menu_class = 'site-navigation';
        if (class_exists('Mega_Menu')) {
            $menu_class = '';
        }
        /* END Max mega menu */

        ?>
        <div class="nav-bar-wrapper">
            <div class="nav-bar">
                <?php if ((($above_nav_bar == '1' && isset($above_nav_bar_site) && $above_nav_bar_site != '1') || ($above_nav_bar == '0' && isset($above_nav_bar_site) && $above_nav_bar_site == '2'))
                        && (is_active_sidebar('above-navigation-bar'))
                        && (anps_get_option($anps_options_data, 'vertical_menu') == '')
                        && (get_option('anps_menu_type', '2') != '5' && get_option('anps_menu_type', '2') != '6')
                    ) : ?>
                    <div class="above-nav-bar">
                        <?php do_shortcode(dynamic_sidebar('above-navigation-bar')); ?>
                    </div>
                <?php endif;?>
                <nav class="<?php echo esc_attr($menu_class); ?><?php echo esc_attr($menu_description); ?>">
                  <?php
                      $locations = get_theme_mod('nav_menu_locations');
                      /* Check if menu is selected */
                      $walker = '';
                      $menu = '';
                      $locations = get_theme_mod('nav_menu_locations');

                      if($locations && isset($locations['primary']) && $locations['primary']) {
                          $menu = $locations['primary'];
                          if( (isset($_GET['page']) && $_GET['page'] == 'one-page') ) {
                              $menu = 21;
                          }
                          if(get_option('anps_global_menu_walker', '1')!='') {
                            $walker = new anps_description_walker();
                          }
                      }
                      $check_for_menu = wp_get_nav_menu_items($menu);
                      if(empty($check_for_menu)) {
                          echo '<p class="nav-empty">'.esc_html__('No menu items found.', 'hairdresser').'</p>';
                      } else {
                        wp_nav_menu( array(
                            'container' => false,
                            'menu_class' => '',
                            'echo' => true,
                            'before' => '',
                            'after' => '',
                            'link_before' => '',
                            'link_after' => '',
                            'depth' => 0,
                            'walker' => $walker,
                            'menu'=>$menu,
                            'theme_location' => 'primary'
                        ));
                      }
                  ?>
                </nav>
                <?php if( anps_get_option('', '1', 'search_icon') != '' || anps_get_option('', '1', 'search_icon_mobile') != '' ):
                    $search_class = '';

                    if( anps_get_option('', '1', 'anps_search_icon') == '' ) {
                      $search_class = ' hidden-md hidden-lg';
                    }

                    if( anps_get_option('', '1', 'search_icon_mobile') == '' ) {
                      $search_class = ' hidden-xs hidden-sm';
                    }
                  ?>
                <div class="site-search-toggle<?php echo esc_attr($search_class); ?>">
                    <button class="fa fa-search"><span class="sr-only"><?php esc_html_e('Search', 'hairdresser'); ?></span></button>
                    <?php if (get_option('anps_search_style', 'default') == 'minimal'): ?>
                        <?php anps_get_search_minimal(); ?>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if( (get_option('anps_menu_type', '2') == '7' || get_option('anps_menu_type', '2') == '8') && get_option('anps_menu_button') == 1 && anps_get_option($anps_options_data, 'vertical_menu') != '1') : ?>
                        <a href="<?php echo get_option('anps_menu_button_url', '#'); ?>" class="menu-button">
                            <?php echo get_option('anps_menu_button_text', 'button'); ?>
                        </a>
                <?php endif; ?>

                <?php if (in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' )))) {
                    $shopping_cart_header = anps_get_option('', 'shop_only', 'shopping_cart_header');
                    if (($shopping_cart_header == 'shop_only' &&  is_woocommerce() ) || $shopping_cart_header == 'always' ) {
                        echo "<div class='show-md cartwrap'>";
                        anps_woocommerce_header();
                        echo "</div>";
                    }
                } ?>
                <button class="navbar-toggle" type="button">
                    <span class="sr-only"><?php _e('Toggle navigation', 'hairdresser'); ?></span>
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
            </div>
        <?php if( get_option('anps_menu_type', '2') == '6' && get_option('anps_menu_button') == 1 && anps_get_option($anps_options_data, 'vertical_menu') != '1') : ?>
                <a href="<?php echo get_option('anps_menu_button_url', '#'); ?>" class="menu-button">
                    <?php echo get_option('anps_menu_button_text', 'button'); ?>
                </a>
        <?php endif; ?>
    </div>
        <?php
    }
}
if( !function_exists('anps_get_site_header') ) {
    function anps_get_site_header() {
        $menu_center = anps_get_option('', '', 'menu_center');
        if( isset($_GET['header']) && $_GET['header'] == 'type-3' ) {
            $menu_center = 'on';
        }
        ?>

        <div class="site-logo<?php if (get_option('anps_text_logo','') != '') { echo " site-logo-text"; } ?>"><?php anps_get_logo(); ?></div>
        <?php anps_get_menu();
    }
}
add_filter("the_content", "anps_the_content_filter");
function anps_the_content_filter($content) {
    // array of custom shortcodes requiring the fix
    $block = join("|",array("recent_blog","section","contact", "form_item", "services", "service", "tabs", "tab", "accordion", "accordion_item", "progress", "quote", "statement", "color", "google_maps", "vimeo", "youtube", "contact_info", "contact_info_item","logos", "logo", "button", "error_404", "icon", "icon_group", "content_half", "content_third", "content_two_third", "content_quarter", "content_two_quarter", "content_three_quarter", "twitter", "social_icons", "social_icon", "data_tables", "data_thead", "data_tbody", "data_tfoot", "data_row", "data_th", "data_td", "testimonials", "testimonial"));
    // opening tag
    $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
    // closing tag
    $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);

    return $rep;

}
/* Post gallery */

// Add new image sizes
function anps_insert_custom_image_sizes( $image_sizes ) {
  // get the custom image sizes
  global $_wp_additional_image_sizes;
  // if there are none, just return the built-in sizes
  if ( empty( $_wp_additional_image_sizes ) )
    return $image_sizes;

  // add all the custom sizes to the built-in sizes
  foreach ( $_wp_additional_image_sizes as $id => $data ) {
    // take the size ID (e.g., 'my-name'), replace hyphens with spaces,
    // and capitalise the first letter of each word
    if ( !isset($image_sizes[$id]) )
      $image_sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
    }

  return $image_sizes;
}
add_filter( 'image_size_names_choose', 'anps_insert_custom_image_sizes' );
//get post_type
function anps_get_current_post_type() {
    if (is_admin()) {
        global $post, $typenow, $current_screen;
        //we have a post so we can just get the post type from that
        if ($post && $post->post_type)
            return $post->post_type;
        //check the global $typenow - set in admin.php
        elseif ($typenow)
            return $typenow;
        //check the global $current_screen object - set in sceen.php
        elseif ($current_screen && $current_screen->post_type)
            return $current_screen->post_type;
        //lastly check the post_type querystring
        elseif (isset($_REQUEST['post_type']))
            return sanitize_key($_REQUEST['post_type']);
        elseif (isset($_REQUEST['post']))
            return get_post_type($_REQUEST['post']);
        //we do not know the post type!
        return null;
    }
}
/* hide sidebar generator on testimonials and portfolio */
if (anps_get_current_post_type() != 'testimonials') {
    //add sidebar generator
    include_once(get_template_directory() . '/anps-framework/sidebar_generator.php');
}
/* Admin/backend styles */
add_action('admin_head', 'anps_backend_styles');
function anps_backend_styles() {
    echo '<style type="text/css">
        .mceListBoxMenu {
            height: auto !important;
        }
        .wp_themeSkin .mceListBoxMenu {
            overflow: visible;
            overflow-x: visible;
        }
    </style>';
}
add_action('admin_head', 'anps_show_hidden_customfields');
function anps_show_hidden_customfields() {
    echo "<input type='hidden' value='" . get_template_directory_uri() . "' id='hidden_url'/>";
}
if (!function_exists('anps_admin_header_style')) :
    /*
     * Styles the header image displayed on the Appearance > Header admin panel.
     * Referenced via add_custom_image_header() in anps_setup().
     */
    function anps_admin_header_style() {
        ?>
        <style type="text/css">
            /* Shows the same border as on front end */
            #headimg {
                border-bottom: 1px solid #000;
                border-top: 4px solid #000;
            }
        </style>
        <?php
    }
endif;
/* Filter wp title */
add_filter('wp_title', 'anps_filter_wp_title', 10, 2);
function anps_filter_wp_title($title, $separator) {
    // Don't affect wp_title() calls in feeds.
    if (is_feed())
        return $title;
    // The $paged global variable contains the page number of a listing of posts.
    // The $page global variable contains the page number of a single post that is paged.
    // We'll display whichever one applies, if we're not looking at the first page.
    global $paged, $page;
    if (is_search()) {
        // If we're a search, let's start over:
        $title = sprintf(esc_html__('Search results for %s', 'hairdresser'), '"' . get_search_query() . '"');
        // Add a page number if we're on page 2 or more:
        if ($paged >= 2)
            $title .= " $separator " . sprintf(esc_html__('Page %s', 'hairdresser'), $paged);
        // Add the site name to the end:
        $title .= " $separator " . get_bloginfo('name', 'display');
        // We're done. Let's send the new title back to wp_title():
        return $title;
    }
    // Otherwise, let's start by adding the site name to the end:
    $title .= get_bloginfo('name', 'display');
    // If we have a site description and we're on the home/front page, add the description:
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && ( is_home() || is_front_page() ))
        $title .= " $separator " . $site_description;

    // Add a page number if necessary:
    if ($paged >= 2 || $page >= 2)
        $title .= " $separator " . sprintf(esc_html__('Page %s', 'hairdresser'), max($paged, $page));
    // Return the new title to wp_title():
    return $title;
}
/* Page menu show home */
add_filter('wp_page_menu_args', 'anps_page_menu_args');
function anps_page_menu_args($args) {
    $args['show_home'] = true;
    return $args;
}
/* Sets the post excerpt length to 40 characters. */
add_filter('excerpt_length', 'anps_excerpt_length');
function anps_excerpt_length($length) {
    return get_option('anps_excerpt_length', '40');
}
/* Returns a "Continue Reading" link for excerpts */
if(!function_exists('anps_continue_reading_link')) {
  function anps_continue_reading_link() {
      return ' <a href="' . get_permalink() . '">' . esc_html__('Continue reading', 'hairdresser') . ' <span class="meta-nav">&rarr;</span></a>';
  }
}
/* Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and anps_continue_reading_link(). */
add_filter('excerpt_more', 'anps_auto_excerpt_more');
function anps_auto_excerpt_more($more) {
    return ' &hellip;' . anps_continue_reading_link();
}
/* Adds a pretty "Continue Reading" link to custom post excerpts. */
add_filter('get_the_excerpt', 'anps_custom_excerpt_more');
function anps_custom_excerpt_more($output) {
    if (has_excerpt() && !is_attachment()) {
        $output .= anps_continue_reading_link();
    }
    return $output;
}
/* Remove inline styles printed when the gallery shortcode is used. */
add_filter('gallery_style', 'anps_remove_gallery_css');
function anps_remove_gallery_css($css) {
    return preg_replace("#<style type='text/css'>(.*?)</style>#s", '', $css);
}
/* Prints HTML with meta information for the current post-date/time and author. */
if (!function_exists('anps_posted_on')) :
    function anps_posted_on() {
        printf(esc_html__('<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'hairdresser'), 'meta-prep meta-prep-author', sprintf('<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>', get_permalink(), esc_attr(get_the_time()), get_the_date()
                ), sprintf('<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>', get_author_posts_url(get_the_author_meta('ID')), sprintf(esc_attresc_html__('View all posts by %s', 'hairdresser'), get_the_author()), get_the_author()
                )
        );
    }
endif;
/* Prints HTML with meta information for the current post (category, tags and permalink).*/
if (!function_exists('anps_posted_in')) :
    function anps_posted_in() {
        // Retrieves tag list of current post, separated by commas.
        $tag_list = get_the_tag_list('', ', ');
        if ($tag_list) {
            $posted_in = esc_html__('This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'hairdresser');
        } elseif (is_object_in_taxonomy(get_post_type(), 'category')) {
            $posted_in = esc_html__('This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'hairdresser');
        } else {
            $posted_in = esc_html__('Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'hairdresser');
        }
        // Prints the string, replacing the placeholders.
        printf($posted_in, get_the_category_list(', '), $tag_list, get_permalink(), the_title_attribute('echo=0'));
    }
endif;
/* After setup theme */
add_action('after_setup_theme', 'anps_setup');
if (!function_exists('anps_setup')):
    function anps_setup() {
        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();
        // This theme uses post thumbnails
        add_theme_support('post-thumbnails');
        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');
        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => esc_html__('Primary Navigation', 'hairdresser'),
        ));
        // Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
        register_default_headers(array(
            'berries' => array(
                'url' => '%s/images/headers/logo.png',
                'thumbnail_url' => '%s/images/headers/logo.png',
                /* translators: header image description */
                'description' => esc_html__('Move default logo', 'hairdresser')
            )
        ));
        if (!isset($_GET['stylesheet']))
            $_GET['stylesheet'] = '';
        $theme = wp_get_theme($_GET['stylesheet']);
        if (!isset($_GET['activated']))
            $_GET['activated'] = '';
        if ($_GET['activated'] == 'true' && $theme->get_template() == 'widebox132') {

            $arr = array(
                    0=>array('label'=>'e-mail', 'input_type'=>'text', 'is_required'=>'on', 'placeholder'=>'email', 'validation'=>'email'),
                    1=>array('label'=>'subject', 'input_type'=>'text', 'is_required'=>'on', 'placeholder'=>'subject', 'validation'=>'none'),
                    2=>array('label'=>'contact number', 'input_type'=>'text', 'is_required'=>'', 'placeholder'=>'contact number', 'validation'=>'phone'),
                    3=>array('label'=>'lorem ipsum', 'input_type'=>'text', 'is_required'=>'', 'placeholder'=>'lorem ipsum', 'validation'=>'none'),
                    4=>array('label'=>'message', 'input_type'=>'textarea', 'is_required'=>'on', 'placeholder'=>'message', 'validation'=>'none'),
                );
            update_option('anps_contact', $arr);
        }
    }
endif;
/* theme options init */
add_action('admin_init', 'anps_theme_options_init');
function anps_theme_options_init() {
    register_setting('sample_options', 'sample_theme_options');
}
/* If user is admin, he will see theme options */
add_action('admin_menu', 'anps_theme_options_add_page');
function anps_theme_options_add_page() {
    global $current_user;
    if($current_user->user_level==10) {
        add_theme_page('Theme Options', 'Theme Options', 'read', 'theme_options', 'anps_theme_options_do_page');
    }
}
function anps_theme_options_do_page() {
    include_once(get_template_directory() . '/anps-framework/admin_view.php');
}
/* Comments */
function anps_comment($comment, $args, $depth) {
    $email = $comment->comment_author_email;
    $user_id = -1;
    if (email_exists($email)) {
        $user_id = email_exists($email);
    }
    $GLOBALS['comment'] = $comment;
    // time difference
    $today = new DateTime(date("Y-m-d H:i:s"));
    $pastDate = $today->diff(new DateTime(get_comment_date("Y-m-d H:i:s")));
    if($pastDate->y>0) {
        if($pastDate->y=="1") {
            $text = esc_html__("year ago", 'hairdresser');
        } else {
            $text = esc_html__("years ago", 'hairdresser');
        }
        $comment_date = $pastDate->y." ".$text;
    } elseif($pastDate->m>0) {
        if($pastDate->m=="1") {
            $text = esc_html__("month ago", 'hairdresser');
        } else {
            $text = esc_html__("months ago", 'hairdresser');
        }
        $comment_date = $pastDate->m." ".$text;
    } elseif($pastDate->d>0) {
        if($pastDate->d=="1") {
            $text = esc_html__("day ago", 'hairdresser');
        } else {
            $text = esc_html__("days ago", 'hairdresser');
        }
        $comment_date = $pastDate->d." ".$text;
    } elseif($pastDate->h>0) {
        if($pastDate->h=="1") {
            $text = esc_html__("hour ago", 'hairdresser');
        } else {
            $text = esc_html__("hours ago", 'hairdresser');
        }
        $comment_date = $pastDate->h." ".$text;
    } elseif($pastDate->i>0) {
        if($pastDate->i=="1") {
            $text = esc_html__("minute ago", 'hairdresser');
        } else {
            $text = esc_html__("minutes ago", 'hairdresser');
        }
        $comment_date = $pastDate->i." ".$text;
    } elseif($pastDate->s>0) {
        if($pastDate->s=="1") {
            $text = esc_html__("second ago", 'hairdresser');
        } else {
            $text = esc_html__("seconds ago", 'hairdresser');
        }
        $comment_date = $pastDate->s." ".$text;
    }
    ?>
    <li <?php comment_class(); ?>>
        <article id="comment-<?php comment_ID(); ?>">
            <div class="comment-avatar">
                <?php echo get_avatar( $comment, 55 ); ?>
            </div>
            <header>
                <span class="comment-author"><?php comment_author(); ?></span>
                <span class="date"><?php echo esc_html($comment_date);?></span>
                <?php
                    if (get_option('anps_post_single_style', 'classic') === 'classic') {
                        echo comment_reply_link(array('reply_text' => 'Reply', 'depth' => $depth, 'max_depth' => $args['max_depth']));
                    }
                ?>
            </header>
            <div class="comment-content"><?php comment_text(); ?></div>
                <?php
                    if (get_option('anps_post_single_style', 'classic') === 'modern') {
                        echo comment_reply_link(array('reply_text' => 'Reply', 'depth' => $depth, 'max_depth' => $args['max_depth']));
                    }
                ?>
        </article>
    </li>
<?php }
if (get_option('anps_post_single_style', 'classic') === 'classic') {
    add_filter('comment_reply_link', 'anps_replace_reply_link_class');
}
function anps_replace_reply_link_class($class){
    $class = str_replace("class='comment-reply-link", "class='comment-reply-link btn", $class);
    return $class;
}
/* Remove Excerpt text */
function anps_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'anps_excerpt_more', 20 );
function anps_getFooterTwitter() {
    $twitter_user = get_option('footer_twitter_acc', 'twitter');
    $settings = array(
        'oauth_access_token' => "1485322933-3Xfq0A59JkWizyboxRBwCMcnrIKWAmXOkqLG5Lm",
        'oauth_access_token_secret' => "aFuG3JCbHLzelXCGNmr4Tr054GY5wB6p1yLd84xdMuI",
        'consumer_key' => "D3xtlRxe9M909v3mrez3g",
        'consumer_secret' => "09FiAL70fZfvHtdOJViKaKVrPEfpGsVCy0zKK2SH8E"
    );
    $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
    $getfield = '?screen_name=' . $twitter_user . '&count=1';
    $requestMethod = 'GET';
    $twitter = new TwitterAPIExchange($settings);
    $twitter_json = $twitter->setGetfield($getfield)
                 ->buildOauth($url, $requestMethod)
                 ->performRequest();
    $twitter_json = json_decode($twitter_json, true);
    $twitter_user_url = "https://twitter.com/" . $twitter_user;
    $twitter_text = $twitter_json[0]["text"];
    $twitter_tweet_url = "https://twitter.com/" . $twitter_user . "/status/" . $twitter_json[0]["id_str"];
    ?>
    <div class="twitter-footer"><div class="container"><a href="<?php echo esc_url($twitter_user_url); ?>" target="_blank" class="tw-icon"></a><a href="<?php echo esc_url($twitter_user_url); ?>" target="_blank" class="tw-heading"><?php esc_html_e("twitter feed", 'hairdresser'); ?></a><a href="<?php echo esc_url($twitter_tweet_url); ?>" target="_blank" class="tw-content"><?php echo esc_html($twitter_text); ?></a></div></div>
    <?php
}
add_filter('widget_tag_cloud_args','set_cloud_tag_size');
function set_cloud_tag_size($args) {
    $args['smallest'] = 12;
    $args['largest'] = 12;
    return $args;
}
function anps_boxed() {
    global $anps_options_data;
    if (anps_get_option($anps_options_data, 'boxed') != '') {
        return ' boxed';
    }
}

function anps_boxed_or_vertical() {
    global $anps_options_data;
    $anps_classes = "";
    if (anps_get_option($anps_options_data, 'boxed') != '') {
        $anps_classes .= ' boxed';
    }
    if (anps_get_option($anps_options_data, 'vertical_menu') != '') {
        $anps_classes .= ' vertical-menu';
    }
    return $anps_classes;
}

/* Custom font extenstion */

function anps_getExtCustomFonts($font) {
    $dir = get_template_directory().'/fonts';
        if ($handle = opendir($dir)) {
            $arr = array();
            // Get all files and store it to array
            while(false !== ($entry = readdir($handle))) {
                $explode_font=explode('.',$entry);
                if(strtolower($font)==strtolower($explode_font[0]))
                    $arr[] = $entry;
            }
            closedir($handle);
            // Remove . and ..
            unset($arr['.'], $arr['..']);
            return $arr;
        }
}

/* Load custom font (CSS) */

function anps_custom_font($font) {
    $font_family = esc_attr($font);
    $font_src    = get_template_directory_uri() . '/fonts/' . $font_family . '.eot';
    $font_count  = count( anps_getExtCustomFonts($font) );
    $i           = 0;
    $prefix      = 'url("' . get_template_directory_uri() . '/fonts/';
    $font_srcs   = '';

    foreach(anps_getExtCustomFonts($font) as $item) {
        $explode_item = explode('.', $item);

        $name = $explode_item[0];
        $extension = $explode_item[1];
        $separator = ',';

        if( ++$i == $font_count ) {
            $separator = ';';
        }

        switch( $extension ) {
            case 'eot': $font_srcs .= $prefix . $name . '.eot?#iefix") format("embedded-opentype")' . $separator; break;
            case 'woff': $font_srcs .= $prefix . $name . '.woff") format("woff")' . $separator;  break;
            case 'otf': $font_srcs .= $prefix . $name . '.otf") format("opentype")' . $separator;  break;
            case 'ttf': $font_srcs .= $prefix . $name . '.ttf") format("ttf")' . $separator;  break;
            case 'woff2': $font_srcs .= $prefix . $name . '.woff2") format("woff2")' . $separator;  break;
        }
    } /* end foreach */
    ?>
    @font-face {
        font-family: "<?php echo esc_attr($font_family); ?>";
        src: url("<?php echo esc_url($font_src); ?>");
        src: <?php echo esc_url($font_srcs); ?>
    }
    <?php
}

if(!function_exists('anps_footer')) {
    function anps_footer() {
        $class = '';
        if(get_option('anps_footer_parallax', '') != '') {
            $class = ' footer-parallax';
        }

        return $class;
    }
}
/* Woocommerce style (add class to body) */
if(!function_exists('anps_woo_style')) {
    function anps_woo_style() {
        return ' woocommerce--' . get_option('anps_style_woo', 'classic');
    }
}
/* Contact form style (add class to body) */
if(!function_exists('anps_contact_form_style')) {
    function anps_contact_form_style() {
        $class = ' contact-form--classic';
        if(get_option('anps_contact_form_style', 'classic') == 'modern') {
            $class = ' contact-form--modern';
        }
        return $class;
    }
}

if(!function_exists('anps_header_margin')) {
    function anps_get_id() {
        $id = get_queried_object_id();
        if (function_exists('is_woocommerce') && is_woocommerce()) {
            $id = get_option('woocommerce_shop_page_id');
        }

        return $id;
    }
}

/* Check for header/footer margin */
if(!function_exists('anps_header_margin')) {
    function anps_header_margin() {
        $class = '';

        $header_margin = get_post_meta(anps_get_id(), $key ='anps_header_options_header_margin', $single = true);
        $footer_margin = get_post_meta(anps_get_id(), $key ='anps_header_options_footer_margin', $single = true);
        if(isset($header_margin) && $header_margin=='on') {
            $class .= ' header-spacing-off';
        }
        if(isset($footer_margin) && $footer_margin=='on') {
            $class .= ' footer-spacing-off';
        }
        return $class;
    }
}

function anps_admin_save_buttons() {
    ?>
    <div class="content-top" style="border-style: solid none; margin-top: 70px">
        <input type="submit" value="<?php esc_html_e("Save all changes", 'hairdresser'); ?>">
        <div class="clear"></div>
    </div>
    <div class="submit-right">
        <button type="submit" class="fixsave fixed fontawesome"><i class="fa fa-floppy-o"></i></button>
    <div class="clear"></div>
    <?php
}

/* Custom styles */
function anps_custom_styles() {
    /* Font Default Values */

    $font_1 = "Montserrat";
    $font_2 = 'PT Sans';
    $font_3 = "Montserrat";

    /* Font 1 */

    if( get_option('font_source_1') == 'System fonts' ||
        get_option('font_source_1') == 'Custom fonts' ||
        get_option('font_source_1') == 'Google fonts' ) {

        $font_1 = urldecode(get_option('font_type_1'));
    }

    if( get_option('font_source_1') == 'Custom fonts' ) {
        anps_custom_font($font_1);
    }

    /* Font 2 */

    if( get_option('font_source_2') == 'System fonts' ||
        get_option('font_source_2') == 'Custom fonts' ||
        get_option('font_source_2') == 'Google fonts' ) {

        $font_2 = urldecode(get_option('font_type_2'));
    }

    if( get_option('font_source_2') == 'Custom fonts' ) {
        anps_custom_font($font_2);
    }

    /* Font 3 (navigation) */

    if( get_option('font_source_navigation') == 'System fonts' ||
        get_option('font_source_navigation') == 'Custom fonts' ||
        get_option('font_source_navigation') == 'Google fonts' ) {

        $font_3 = urldecode(get_option('font_type_navigation'));
    }

    if( get_option('font_source_navigation') == 'Custom fonts' ) {
        anps_custom_font($font_3);
    }
    /* Logo font */
    $logo_font = urldecode(get_option('anps_text_logo_font'));

    if( get_option('anps_text_logo_source_1') == 'Custom fonts' ) {
        anps_custom_font($logo_font);
    }

    /* Main Theme Colors */

    $breadcrumbs_link_color = get_option('anps_breadcrumbs_link_color', '#000');
    $breadcrumbs_link_hover_color = get_option('anps_breadcrumbs_link_hover_color', '#999');
    $breadcrumbs_text_color = get_option('anps_breadcrumbs_text_color', '#c3c3c3');
    $text_color = anps_get_option('', '#727272', 'text_color');
    $link_color = get_option('anps_link_color', '#000');
    $link_hover_color = get_option('anps_link_hover_color', '#999');
    $anps_modern_accent_color = get_option('anps_modern_accent_color', '#e53935');
    $primary_color = anps_get_option('', '#940855', 'primary_color');
    $hovers_color = anps_get_option('', '#BD1470', 'hovers_color');
    $headings_color = anps_get_option('', '#000000', 'headings_color');
    $main_divider_color = get_option('anps_main_divider_color', '#940855');
    $side_submenu_background_color = anps_get_option('', '', 'side_submenu_background_color');
    $side_submenu_text_color = anps_get_option('', '', 'side_submenu_text_color');
    $side_submenu_text_hover_color = anps_get_option('', '', 'side_submenu_text_hover_color');

    /* Header Colors */

    $menu_text_color = anps_get_option('', '#000', 'menu_text_color');
    $top_bar_color = anps_get_option('', '#bf5a91', 'top_bar_color');
    $top_bar_bg_color = anps_get_option('', '#940855', 'top_bar_bg_color');
    $nav_background_color = anps_get_option('', '#fff', 'nav_background_color');
    $submenu_background_color = anps_get_option('', '#fff', 'submenu_background_color');
    $anps_submenu_divider_color = get_option('anps_submenu_divider_color', '#ececec');
    $curent_menu_color = get_option('anps_curent_menu_color', '#940855');
    $submenu_text_color = anps_get_option('', '#000', 'submenu_text_color');
    $anps_woo_cart_items_number_bg_color = get_option('anps_woo_cart_items_number_bg_color', $primary_color);
    $anps_woo_cart_items_number_color = get_option('anps_woo_cart_items_number_color', '#fff');
    $anps_logo_bg_color = get_option('anps_logo_bg_color', '');
    $anps_above_menu_bg_color = get_option('anps_above_menu_bg_color', '');
    $anps_heading_bg_color = get_option('anps_page_heading_bg_color', '');
    $page_heading_color = get_option('anps_page_heading_text_color', $headings_color);

    /* Footer Colors */

    $footer_bg_color = anps_get_option('', '#141414', 'footer_bg_color');
    $footer_text_color = anps_get_option('', '#adadad', 'footer_text_color');
    $footer_heading_text_color = get_option('anps_footer_heading_text_color', '#fff');
    $footer_selected_color = get_option('anps_footer_selected_color', '');
    $footer_hover_color = get_option('anps_footer_hover_color', '');
    $footer_divider_color = get_option('anps_footer_divider_color', '#fff');
    $copyright_footer_text_color = get_option('anps_copyright_footer_text_color', '#4a4a4a');
    $copyright_footer_bg_color = anps_get_option('', '#0d0d0d', 'copyright_footer_bg_color');
    $footer_border_color = get_option('anps_footer_border_color', '#5b5b5b');
    $footer_border_active_color = get_option('anps_footer_border_active_color', '#fff');
    $footer_active_bg_color = get_option('anps_footer_active_bg_color', '#5b5b5b');
    $footer_active_hover_bg_color = get_option('anps_footer_active_hover_bg_color', '#333');

    /* Home Page Colors*/

    $anps_front_text_color = get_option('anps_front_text_color', '');
    $anps_front_text_hover_color = get_option('anps_front_text_hover_color');
    $anps_front_curent_menu_color = get_option('anps_front_curent_menu_color');
    $anps_front_bg_color = get_option('anps_front_bg_color');
    $anps_front_topbar_color = get_option('anps_front_topbar_color', '#fff');
    $anps_front_topbar_hover_color = get_option('anps_front_topbar_hover_color', '#940855');
    $anps_front_topbar_bg_color = get_option('anps_front_topbar_bg_color', '');

    /* Font Size */

    $body_font_size = anps_get_option('', '14', 'body_font_size');
    $menu_font_size = anps_get_option('', '14', 'menu_font_size');
    $submenu_font_size = get_option('anps_submenu_font_size', '12');
    $h1_font_size = anps_get_option('', '31', 'h1_font_size');
    $h2_font_size = anps_get_option('', '24', 'h2_font_size');
    $h3_font_size = anps_get_option('', '21', 'h3_font_size');
    $h4_font_size = anps_get_option('', '18', 'h4_font_size');
    $h5_font_size = anps_get_option('', '16', 'h5_font_size');
    $page_heading_h1_font_size = anps_get_option('', '48', 'page_heading_h1_font_size');
    $blog_heading_h1_font_size = anps_get_option('', '28', 'blog_heading_h1_font_size');
    $top_bar_font_size = get_option('anps_top_bar_font_size', '14');
    $anps_portfolio_title_font_size = get_option('anps_portfolio_title_font_size', '16');

    $footer_font_size = get_option('anps_footer_font_size', '14');
    $footer_title_font_size = get_option('anps_footer_title_font_size', '17');
    $copyright_font_size = get_option('anps_copyright_font_size', '14');

    /* Container width */
    $container_width = get_option('anps_container_width', '1170');
?>
@media (min-width: 768px) {
    .site-footer {
        font-size: <?php echo esc_attr($footer_font_size); ?>px;
    }

    .site-footer .widget-title {
        font-size: <?php echo esc_attr($footer_title_font_size); ?>px;
    }

    .copyright-footer {
        font-size: <?php echo esc_attr($copyright_font_size); ?>px;
    }
}

/* White */

.recent-posts--white .recent-post__title,
.post-style-white .post-meta,
.pagination--white,
.portfolio-m--white .portfolio-m__link {
    font-family: <?php echo anps_wrap_font(esc_attr($font_1)); ?>;
}

.pricing--white .pricing-item__title,
.pricing--white .pricing-item__price,
.pricing--white .pricing__nav-link,
.pricing--white .pricing__subcategory,
.recent-posts--white .recent-post__excerpt,
.title--style-white,
.team--white .team__title,
.team--white .team__subtitle,
.ea-bootstrap *,
.award__title,
.post-style-white .post__title,
.post-style-white .post-content,
.featured-m--white .featured-m__title,
.featured-m--white .featured-m__text,
.page-header--white .page-title,
.page-header--white .page-desc,
.portfolio-m--white .portfolio-m__name,
.portfolio-fs--white .portfolio-fs__title,
.portfolio-fs--white .portfolio-fs__more,
.img-txt--white .img-txt__title,
.img-txt--white .img-txt__subtitle,
.img-txt--white .img-txt__text {
    font-family: <?php echo anps_wrap_font(esc_attr($font_2)); ?>;
    <?php if($font_2 === 'Montserrat Light'): ?>
        font-weight: 300;
    <?php endif; ?>
}

/* Dark */

.pricing--dark .pricing-item__title,
.pricing--dark .pricing-item__price,
.pricing--dark .pricing__subcategory,
.recent-posts--dark .recent-post__title,
.title--style-dark,
.team--dark .team__title,
.award__title,
.post-style-dark .post__title,
.featured-m--dark .featured-m__title,
.page-header--dark .page-title,
.portfolio-m--dark .portfolio-m__name,
.img-txt--dark .img-txt__title,
.img-txt--dark .img-txt__subtitle {
    font-family: <?php echo anps_wrap_font(esc_attr($font_2)); ?>;
}

.pricing--dark .pricing__nav-link,
.recent-posts--dark .recent-post__excerpt,
.team--dark .team__subtitle,
.post-style-dark .post-meta,
.post-style-dark .post-content,
.blog-single--modern .post-meta,
.featured-m--dark .featured-m__text,
.pagination--dark,
.page-header--dark .page-desc,
.portfolio-m--dark .portfolio-m__link,
.img-txt--dark .img-txt__text {
    font-family: <?php echo anps_wrap_font(esc_attr($font_1)); ?>;
}

/* Fancy */

.pricing--fancy .pricing-item__title,
.pricing--fancy .pricing-item__price,
.pricing--fancy .pricing__subcategory,
.recent-posts--fancy .recent-post__title,
.title--style-fancy,
.team--fancy .team__title,
.award__title,
.icon-modern--fancy .icon-modern__title,
.post-style-fancy .post__title,
.featured-m--fancy .featured-m__title,
.page-header--fancy .page-title,
.portfolio-m--fancy .portfolio-m__name,
.portfolio-fs--fancy .portfolio-fs__title,
.img-txt--fancy .img-txt__title,
.img-txt--fancy .img-txt__subtitle {
    font-family: <?php echo anps_wrap_font(esc_attr($font_1)); ?>;
}

.recent-posts--fancy .recent-post__excerpt,
.team--fancy .team__subtitle,
.post-style-fancy .post-meta,
.post-style-fancy .post-content,
.post-style-fancy .post-date,
.featured-m--fancy .featured-m__text,
.pagination--fancy,
.page-header--fancy .page-desc,
.portfolio-m--fancy .portfolio-m__link,
.portfolio-fs--fancy .portfolio-fs__more,
.recent-posts--fancy .recent-post__time,
.pricing--fancy .pricing__nav-link,
.img-txt--fancy .img-txt__text {
    font-family: <?php echo anps_wrap_font(esc_attr($font_2)); ?>;
}

.btn.modern-1,
.btn.modern-2,
.btn.modern-3,
.btn.modern-4,
.btn.modern-5,
.btn.modern-6,
.woocommerce--modern .mini-cart .btn,
.woocommerce--modern .btn.btn-woocommerce,
.woocommerce--modern .button.single_add_to_cart_button,
.woocommerce--modern .product_meta,
.woocommerce--modern .price,
.page-breadcrumbs.page-breadcrumbs--modern {
    font-family: <?php echo anps_wrap_font(esc_attr($font_2)); ?>;
}

body,
ol.list > li > *,
.product_meta span span,
.searchform,
.searchform input[type="text"], {
  color: <?php echo esc_attr($text_color); ?>;
}

@media (min-width: <?php echo esc_attr($container_width) + 30; ?>px) {
    .container {
        width: <?php echo esc_attr($container_width); ?>px;
    }
}

/* Header colors */

.top-bar, .top-bar a {
    font-size: <?php echo esc_attr($top_bar_font_size);?>px;
}

@media(min-width: 992px) {
    .site-header-style-boxed,
    .site-header-style-full-width {
        background-color: <?php echo esc_attr($anps_above_menu_bg_color); ?>;
    }

    .woo-header-cart .cart-contents > i,
    .nav-wrap .site-search-toggle button,
    .nav-bar .site-search-toggle button {
        color: <?php echo esc_attr($menu_text_color); ?>;
    }

    .site-navigation a,
    .site-header-style-modern .menu-button,
    .home .site-header-sticky-active .site-navigation .menu-item-depth-0 > a:not(:hover):not(:focus),
    .paralax-header .site-header-style-transparent.site-header-sticky-active .site-navigation .menu-item-depth-0 > a:not(:hover):not(:focus),
    .nav-empty {
      color: <?php echo esc_attr($menu_text_color); ?>;
    }
}

.site-header-style-normal .nav-wrap,
.site-header-style-modern .nav-wrap {
  background-color: <?php echo esc_attr($nav_background_color); ?>;
}

@media(min-width: 992px) {
  .site-navigation .sub-menu {
    background-color: <?php echo esc_attr($submenu_background_color); ?>;
  }

  .site-navigation .sub-menu a {
    color: <?php echo esc_attr($submenu_text_color); ?>;
  }
  .site-navigation .current-menu-item > a:not(:focus):not(:hover),
  .home .site-navigation .current-menu-item > a:not(:focus):not(:hover),
  .home .site-header.site-header-sticky-active .menu-item-depth-0.current-menu-item > a:not(:focus):not(:hover) {
     color: <?php echo esc_attr($curent_menu_color); ?> !important;
  }
}

@media(min-width: 992px) {
    .site-search-toggle button:hover,
    .site-search-toggle button:focus,
    .site-header-style-modern .menu-button:hover,
    .site-header-style-modern .menu-button:focus,
    .site-navigation ul:not(.sub-menu) > li > a:hover,
    .site-navigation ul:not(.sub-menu) > li > a:focus {
        color: <?php echo esc_attr($hovers_color); ?>;
    }

  /* Boxed header style background color */
  .site-header-style-boxed .nav-bar-wrapper {
    background-color: <?php echo esc_attr($anps_front_bg_color); ?>;
  }
}

@media(max-width: 991px) {
  .site-search-toggle button:hover, .site-search-toggle button:focus,
  .navbar-toggle:hover, .navbar-toggle:focus {
    background-color: <?php echo esc_attr($hovers_color); ?>;
  }

  .site-search-toggle button,
  .navbar-toggle {
    background-color: <?php echo esc_attr($primary_color); ?>;
  }
}

<?php if( get_option('anps_menu_type', '2') == 1 || get_option('anps_menu_type', '2') == 3 ): ?>
/* Front Colors (transparent menus) */

@media(min-width: 992px) {
  .home .site-navigation .menu-item-depth-0 > a, .home header:not(.site-header-sticky-active) .site-search-toggle button:not(:hover):not(:focus),
  .nav-empty {
    color: <?php echo esc_attr($anps_front_text_color); ?>;
  }

  .home .site-navigation ul:not(.sub-menu) > li > a,
  .home .site-header-style-modern .menu-button,
  .home .nav-empty,
  .home header:not(.site-header-sticky-active) .woo-header-cart .cart-contents > i,
  .home header:not(.site-header-sticky-active) .site-search-toggle button {
      color: <?php echo esc_attr($anps_front_text_color); ?>;
    }

    .home .site-header .menu-item-depth-0.current-menu-item > a {
        color: <?php echo esc_attr($anps_front_curent_menu_color); ?> !important;
    }

    .home .site-search-toggle button:focus,
    .home .site-search-toggle button:hover {
        color: <?php echo esc_attr($anps_front_text_hover_color); ?>;
    }
}

.home .site-header .menu-item-depth-0 > a:hover,
.home .site-header .menu-item-depth-0 > a:focus {
  color: <?php echo esc_attr($anps_front_text_hover_color); ?>;
}

.site-navigation a:hover,
.site-navigation a:focus,
.site-header-style-modern .menu-button:hover,
.site-header-style-modern .menu-button:focus,
.site-navigation .current-menu-item > a,
.home .site-navigation ul:not(.sub-menu) > li > a:hover,
.home .site-navigation ul:not(.sub-menu) > li > a:focus,
.home header:not(.site-header-sticky-active) .site-search-toggle button:hover {
  color: <?php echo esc_attr($anps_front_text_hover_color); ?>;
}
<?php else: ?>
/* Front-Global Colors */

.site-header-style-normal .nav-wrap,
.site-header-style-modern .nav-wrap {
  background-color: <?php echo esc_attr($anps_front_bg_color); ?>;
}

@media(min-width: 992px) {
  .site-header-style-full-width.site-header-sticky-active .header-wrap,
  .site-header-style-full-width .header-wrap {
    background-color: <?php echo esc_attr($anps_front_bg_color); ?>;
  }
}
<?php endif; ?>

/* Top bar colors */

.top-bar {
  background-color: <?php echo esc_attr($top_bar_bg_color); ?>;
  color: <?php echo esc_attr($top_bar_color); ?>;
}
<?php if( is_front_page() && $anps_front_topbar_color != '' && (get_option('anps_menu_type', '2') == 1 || get_option('anps_menu_type', '2') == 3) ): ?>
    .top-bar a:not(:hover) {
        color: <?php echo esc_attr($anps_front_topbar_color); ?>;
    }
<?php else: ?>
    .top-bar a:not(:hover) {
        color: <?php echo esc_attr($top_bar_color); ?>;
    }
<?php endif; ?>
<?php if( is_front_page() && $anps_front_topbar_hover_color != '' && (get_option('anps_menu_type', '2') == 1 || get_option('anps_menu_type', '2') == 3) ): ?>
  .top-bar a:hover,
  .top-bar a:focus {
    color: <?php echo esc_attr($anps_front_topbar_hover_color); ?> !important;
  }

  .top-bar {
    color: <?php echo esc_attr($anps_front_topbar_color); ?>;
  }

  .top-bar {
    background-color: <?php echo esc_attr($anps_front_topbar_bg_color); ?>;
  }
<?php endif; ?>

<?php //top bar font size ?>
.top-bar, .top-bar a {
    font-size: <?php echo esc_attr(get_option('anps_top_bar_font_size', '14'));?>px;
}

/* Top bar height */
<?php
$anps_top_bar_height = get_option('anps_top_bar_height', '60');
if ($anps_top_bar_height == '') {
   $anps_top_bar_height = 60;
}
?>
@media(min-width: 992px) {
    .top-bar > .container {
        height: <?php echo esc_attr($anps_top_bar_height);?>px;
    }

    /* Menu divider */

    .site-header:not(.site-header-vertical-menu) .site-navigation > ul > li:after {
        <?php
            if(get_option('anps_menu_dividers', '1') == '') {
                echo 'display: none';
            }
        ?>
    }
}

/* Main menu height */

<?php
$anps_menu_height = get_option('anps_main_menu_height', '');
$anps_above_menu_height = get_option('anps_above_menu_height', '');

if($anps_menu_height != '') : ?>
    @media(min-width: 992px) {
        <?php // header type 1  ?>
        .transparent.top-bar + .site-header-style-transparent:not(.site-header-sticky-active) .nav-wrap {
            height: <?php echo esc_attr($anps_menu_height, 'auto');?>px;
            max-height: <?php echo esc_attr($anps_menu_height, 'auto');?>px;
        }
        <?php // header type 2, 3, 4  ?>
        .site-header-style-normal:not(.site-header-sticky-active) .nav-wrap,
        .site-header-style-modern:not(.site-header-sticky-active) .nav-wrap,
        .site-header-style-transparent:not(.site-header-sticky-active) .nav-wrap {
            height: <?php echo esc_attr($anps_menu_height, 'auto');?>px;
            max-height: <?php echo esc_attr($anps_menu_height, 'auto');?>px;
            transition: height .3s ease-out;
        }

        <?php // header type 5, 6  ?>
        .site-header-style-full-width .nav-bar-wrapper,
        .site-header-style-boxed .nav-bar,
        .site-header-style-full-width .cartwrap {
            height: <?php echo esc_attr($anps_menu_height, 'auto');?>px;
        }

        .site-header-style-full-width .menu-item-depth-0 > a,
        .site-header-style-boxed .menu-item-depth-0 > a,
        .site-header-style-full-width .site-search-toggle button,
        .site-header-style-boxed .site-search-toggle button,
        .site-header-style-full-width .cart-contents {
            line-height: <?php echo esc_attr($anps_menu_height, 'auto');?>px;
        }

        <?php // above menu  ?>
        .site-header-style-full-width .preheader-wrap, .site-header-style-boxed .preheader-wrap {
            height: <?php echo esc_attr($anps_above_menu_height, 'auto');?>px;
        }
        .site-header-style-full-width .site-logo:after, .site-header-style-boxed .site-logo:after {
            border-top: <?php echo esc_attr($anps_above_menu_height, 'auto');?>px solid currentColor;
        }

        .site-header-style-boxed .site-logo,
        .site-header-style-boxed .large-above-menu {
            padding-bottom: <?php echo esc_attr($anps_menu_height, 'auto') / 2;?>px;
        }
    }
<?php endif; ?>

/* logo bg color */
<?php if (isset($anps_logo_bg_color) && $anps_logo_bg_color != "" && get_option('anps_logo_background') == '1') :?>
    @media(min-width: 992px) {
        .site-header .site-logo {
            color: <?php echo esc_attr($anps_logo_bg_color);?>
        }
    }
<?php endif;?>

@media (min-width: 992px) {
    .site-header-dropdown-2 .sub-menu .menu-item + .menu-item > a::before,
    .site-header-dropdown-3 .sub-menu .menu-item + .menu-item > a::before {
        background-color: <?php echo esc_attr($anps_submenu_divider_color);?>;
    }
}
a {
    color: <?php echo esc_attr($link_color); ?>;
}

a:hover,
a:focus {
    color: <?php echo esc_attr($link_hover_color); ?>;
}

.ea-bootstrap .ui-state-default:hover,
.ea-bootstrap .ui-state-default:focus,
.ea-bootstrap .anps-step__button,
.contact-form--modern .wpcf7-text:focus,
.contact-form--modern .wpcf7-number:focus,
.contact-form--modern .wpcf7-textarea:focus,
.pricing--fancy .pricing__nav .active .pricing__nav-link {
    border-color: <?php echo esc_attr($anps_modern_accent_color); ?>;
}

.woocommerce--modern.woocommerce-page .button:not(.wc-forward):hover,
.woocommerce--modern.woocommerce-page .button:not(.wc-forward):focus,
.btn.btn-woocommerce:hover,
.btn.btn-woocommerce:focus,
.ea-bootstrap .anps-step__button:hover,
.ea-bootstrap .anps-step__button:focus,
.ea-bootstrap .ui-state-highlight,
.woocommerce--modern .onsale {
    background-color: <?php echo esc_attr($anps_modern_accent_color); ?>;
}

.page-breadcrumbs .breadcrumbs {
    color: <?php echo esc_attr($breadcrumbs_text_color); ?>;
}

.page-breadcrumbs a {
    color: <?php echo esc_attr($breadcrumbs_link_color); ?>;
}

.page-breadcrumbs a:hover,
.page-breadcrumbs a:focus {
    color: <?php echo esc_attr($breadcrumbs_link_hover_color); ?>;
}

.btn-link,
.icon.style-2 .fa,
.error-404 h2,
.page-heading,
.statement .style-3,
.dropcaps.style-2:first-letter,
.list li:before,
ol.list,
.post.style-2 header > span,
.post.style-2 header .fa,
.page-numbers span,
.team .socialize a,
blockquote.style-2:before,
.panel-group.style-2 .panel-title a:before,
.contact-info .fa,
blockquote.style-1:before,
.comments--classic .comment-author,
.faq .panel-title a.collapsed:before,
.faq .panel-title a:after,
.faq .panel-title a,
.filter button.selected,
.filter:before,
.primary,
.search-posts i,
.counter .counter-number,
.sidebar--classic #wp-calendar th,
.sidebar--classic #wp-calendar caption,
.site-footer--default #wp-calendar th,
.site-footer--default #wp-calendar caption,
.testimonials blockquote p:before,
.testimonials blockquote p:after,
.price,
.widget-price,
.star-rating,
.sidebar--classic .widget_shopping_cart .quantity,
.tab-pane .commentlist .meta strong, .woocommerce-tabs .commentlist .meta strong,
.widget_recent_comments .recentcomments a,
.pricing--classic .pricing-item__price,
.pricing--classic .pricing__nav-link {
  color: <?php echo esc_attr($primary_color); ?>;
}

.pricing-item__divider {
  border-bottom: 1px dashed <?php echo esc_attr($primary_color); ?>;
}

.pricing--classic .active .pricing__nav-link {
  background: none !important;
  border-color: <?php echo esc_attr($primary_color); ?> !important;
  color: <?php echo esc_attr($primary_color); ?>;
}

.testimonials.white blockquote p:before,
.testimonials.white blockquote p:after {
  color: #fff;
}

.site-footer,
.site-footer .copyright-footer,
.site-footer .searchform input[type="text"],
.searchform button[type="submit"],
footer.site-footer .copyright-footer a {
  color: <?php echo esc_attr($footer_text_color); ?>;
}

.counter .wrapbox,
.icon .fa:after {
  border-color:<?php echo esc_attr($primary_color); ?>;
}

body .tp-bullets.simplebullets.round .bullet.selected {
  border-color: <?php echo esc_attr($primary_color); ?>;
}

.carousel-indicators li.active,
.ls-michell .ls-bottom-slidebuttons a.ls-nav-active {
  border-color: <?php echo esc_attr($primary_color); ?> !important;
}

.icon .fa,
.posts div a,
.progress-bar,
.nav-tabs > li.active:after,
.vc_tta-style-anps_tabs .vc_tta-tabs-list > li.vc_active:after,
.sidebar--classic .menu li.current-menu-ancestor a,
.pricing-table header,
.table thead th,
.mark,
.post .post-meta button,
blockquote.style-2:after,
.panel-title a:before,
.carousel-indicators li,
.carousel-indicators .active,
.ls-michell .ls-bottom-slidebuttons a,
.twitter .carousel-indicators li,
.twitter .carousel-indicators li.active,
#wp-calendar td a,
body .tp-bullets.simplebullets.round .bullet,
.onsale,
.woocommerce--classic .quantity__button,
.widget_price_filter .ui-slider .ui-slider-range,
.woo-header-cart .cart-contents > span,
.form-submit #submit,
.testimonials blockquote header:before,
div.woocommerce-tabs ul.tabs li.active:before,
mark,
.woocommerce-product-gallery__trigger,
.menu-item-label,
.contact-form--modern .wpcf7-submit
{
  background-color: <?php echo esc_attr($primary_color); ?>;
}

.testimonials.white blockquote header:before {
   background-color: #fff;
}

h1, h2, h3, h4, h5, h6,
.nav-tabs > li > a,
.nav-tabs > li.active > a,
.vc_tta-tabs-list > li > a span,
.statement,
.page-heading a,
.page-heading a:after,
p strong,
.dropcaps:first-letter,
.page-numbers a,
.socialize a,
.widget_rss .rss-date,
.widget_rss cite,
.panel-title,
.panel-group.style-2 .panel-title a.collapsed:before,
blockquote.style-1,
.faq .panel-title a:before,
.faq .panel-title a.collapsed,
.filter button,
.carousel .carousel-control,
#wp-calendar #today,
.woocommerce-result-count,
input.qty,
.product_meta,
.woocommerce-review-link,
.woocommerce-before-loop .woocommerce-ordering:after,
.widget_price_filter .price_slider_amount .button,
.widget_price_filter .price_label,
.sidebar--classic .product_list_widget li h4 a,
.shop_table.table thead th,
.shop_table.table tfoot,
.product-single-header .variations label,
.tab-pane .commentlist .meta, .woocommerce-tabs .commentlist .meta,
.title,
.pricing__subcategory,
.pricing__nav-link,
.comments--modern .comment-author {
  color: <?php echo esc_attr($headings_color); ?>;
}

.ls-michell .ls-nav-next,
.ls-michell .ls-nav-prev {
color:#fff;
}

.contact-form input[type="text"]:focus,
.contact-form textarea:focus,
.woocommerce .input-text:focus {
  border-color: <?php echo esc_attr($headings_color); ?> !important;
}

.select2-container-active.select2-drop-active,
.select2-container-active.select2-container .select2-choice,
.select2-drop-active .select2-results,
.select2-drop-active {
  border-color: <?php echo esc_attr($headings_color); ?> !important;
}

.pricing-table header h2,
.mark.style-2,
.btn.dark,
.twitter .carousel-indicators li,
.added_to_cart {
  background-color: <?php echo esc_attr($headings_color); ?>;
}

body,
.alert .close,
.post header,
#lang_sel_list a.lang_sel_sel, #lang_sel_list ul a, #lang_sel_list_list ul a:visited,
.widget_icl_lang_sel_widget #lang_sel ul li ul li a, .widget_icl_lang_sel_widget #lang_sel a {
   font-family: <?php echo anps_wrap_font(esc_attr($font_2));?>;

   <?php if($font_2 === 'Montserrat Light'): ?>
    font-weight: 300;
   <?php endif; ?>
}



<?php if( $logo_font ): ?>
.site-logo {
    font-family: <?php echo anps_wrap_font(esc_attr($logo_font)); ?>;
}
<?php endif; ?>

h1, h2, h3, h4, h5, h6,
.btn,
.page-heading,
.team--classic .team__title,
.team--classic .team__subtitle,
blockquote.style-1,
.onsale,
.added_to_cart,
.price,
.widget-price,
.woocommerce-review-link,
.product_meta,
.tab-pane .commentlist .meta, .woocommerce-tabs .commentlist .meta,
.wpcf7-submit,
button.single_add_to_cart_button,
p.form-row input.button,
.page-breadcrumbs,
.recent-post__time,
.comment-list .comment .comment-author,
.menu-notice,
.pricing__nav-link
 {
  font-family: <?php echo anps_wrap_font(esc_attr($font_1)); ?>;
  <?php if($font_1 === 'Montserrat'): ?>
    font-weight: 500;
  <?php endif; ?>
  <?php if($font_1 === 'Montserrat Light'): ?>
    font-weight: 300;
  <?php endif; ?>
}

.nav-tabs > li > a,
.vc_tta-tabs-list > li > a,
.tp-arr-titleholder,
.site-navigation {
    font-family: <?php echo anps_wrap_font(esc_attr($font_3));?>;
    <?php if($font_3 === 'Montserrat Light'): ?>
      font-weight: 300;
    <?php endif; ?>
}

.pricing-table header h2,
.pricing-table header .price,
.pricing-table header .currency,
.table thead,
h1.style-3,
h2.style-3,
h3.style-3,
h4.style-3,
h5.style-3,
h6.style-3,
.page-numbers a,
.page-numbers span,
.alert,
.comment-list .comment header,
.woocommerce-result-count,
.product_list_widget li > a,
.product_list_widget li p.total strong,
.cart_list + .total,
.shop_table.table tfoot,
.product-single-header .variations label {
  font-family: <?php echo anps_wrap_font(esc_attr($font_1));?>;
  <?php if($font_1 === 'Montserrat'): ?>
    font-weight: 500;
  <?php endif; ?>
  <?php if($font_1 === 'Montserrat Light'): ?>
    font-weight: 300;
  <?php endif; ?>
}

/*testimonials*/

.testimonials blockquote p {
  border-bottom: 1px solid <?php echo esc_attr($primary_color); ?>;
}
.testimonials.white blockquote p {
  border-bottom: 1px solid #fff;
}

div.testimonials blockquote.item.active p,
.testimonials blockquote cite {
color: <?php echo esc_attr($primary_color); ?>;
}

div.testimonials.white blockquote.item.active p,
div.testimonials.white blockquote.item.active cite a,
div.testimonials.white blockquote.item.active cite, .wpb_content_element .widget .tagcloud a {
    color: #fff;
}

.a:hover,
.icon a:hover h2,
.page-heading a:hover,
.table tbody .cart_item:hover td,
.page-numbers a:hover,
.widget-categories a:hover,
.product-categories a:hover,
.widget_archive a:hover,
.widget_categories a:hover,
.widget_recent_entries a:hover,
.socialize a:hover,
.faq .panel-title a.collapsed:hover,
.carousel .carousel-control:hover,
a:hover h1, a:hover h2, a:hover h3, a:hover h4, a:hover h5,
.site-footer a:not([class*="btn"]):hover,
.highlited,
.ls-michell .ls-nav-next:hover,
.ls-michell .ls-nav-prev:hover,
body .tp-leftarrow.default:hover,
body .tp-rightarrow.default:hover,
.product_list_widget li h4 a:hover,
.cart-contents:hover i,
.icon.style-2 a:hover .fa,
.team .socialize a:hover,
.recentblog header a:hover h2,
.scroll-top--style-1:hover,
.scroll-top--style-1:focus,
.hovercolor, i.hovercolor, .post.style-2 header i.hovercolor.fa,
article.post-sticky header:before,
.wpb_content_element .widget a:hover,
.star-rating,
footer.site-footer .copyright-footer a:hover,
.page-numbers.current,
.widget_layered_nav a:hover,
.widget_layered_nav a:focus,
.widget_layered_nav .chosen a,
.widget_layered_nav_filters a:hover,
.widget_layered_nav_filters a:focus,
.widget_rating_filter .star-rating:hover,
.widget_rating_filter .star-rating:focus {
  color: <?php echo esc_attr($hovers_color); ?>;
}

.filter button.selected {
  color: <?php echo esc_attr($hovers_color); ?>!important;
}

.scrollup a:hover {
  border-color: <?php echo esc_attr($hovers_color); ?>;
}

.tagcloud a:hover,
.twitter .carousel-indicators li:hover,
.added_to_cart:hover,
.icon a:hover .fa,
.posts div a:hover,
#wp-calendar td a:hover,
.woocommerce--classic .quantity__button:hover,
.woocommerce--classic .quantity__button:focus,
.widget_price_filter .price_slider_amount .button:hover,
.form-submit #submit:hover,
.anps_download > a span.anps_download_icon,
.onsale,
.woo-header-cart .cart-contents > span,
.sidebar--classic .menu .current_page_item > a,
aside.sidebar--classic ul.menu ul.sub-menu > li.current-menu-item > a,
.woocommerce-product-gallery__trigger:hover,
.woocommerce-product-gallery__trigger:focus
{
  background-color: <?php echo esc_attr($hovers_color); ?>;
}

body, html {
  font-size: <?php echo esc_attr($body_font_size); ?>px;
}

h1, .h1 {
  font-size: <?php echo esc_attr($h1_font_size); ?>px;
}
h2, .h2 {
  font-size: <?php echo esc_attr($h2_font_size); ?>px;
}
h3, .h3 {
  font-size: <?php echo esc_attr($h3_font_size); ?>px;
}
h4, .h4 {
  font-size: <?php echo esc_attr($h4_font_size); ?>px;
}
h5, .h5 {
  font-size: <?php echo esc_attr($h5_font_size); ?>px;
}
@media (min-width: 992px) {
    .site-navigation,
    .site-navigation ul li a,
    .site-header-style-modern .menu-button {
        font-size: <?php echo esc_attr($menu_font_size); ?>px;
    }
    .menu-item-label {
        font-size: <?php echo esc_attr($menu_font_size-3); ?>px;
    }
    .sub-menu .menu-item-label {
        font-size: <?php echo esc_attr($submenu_font_size-3); ?>px;
    }
}
@media (min-width: 992px) {
    .site-header-dropdown-3 #menu-main-menu > .menu-item:not(.megamenu) .sub-menu a:hover,
    .site-header-dropdown-3 #menu-main-menu > .menu-item:not(.megamenu) .sub-menu a:focus {
      background-color: <?php echo esc_attr($hovers_color); ?>;
    }
}
@media (min-width: 1200px) {
    .site-navigation .sub-menu a,
    .site-navigation .main-menu .megamenu {
        font-size: <?php echo esc_attr($submenu_font_size); ?>px;
    }
}

.page-heading h1 {
  font-size: <?php echo esc_attr($page_heading_h1_font_size); ?>px;
}

article.post-sticky header .stickymark i.nav_background_color {
  color: <?php echo esc_attr($nav_background_color); ?>;
}

.triangle-topleft.hovercolor {
  border-top: 60px solid <?php echo esc_attr($hovers_color); ?>;
}

h1.single-blog, article.post h1.single-blog {
  font-size: <?php echo esc_attr($blog_heading_h1_font_size); ?>px;
}

aside.sidebar--classic ul.menu ul.sub-menu > li > a,
aside.sidebar--classic ul.menu > li.current-menu-ancestor > a {
  background: <?php echo esc_attr($side_submenu_background_color); ?>;
  color: <?php echo esc_attr($side_submenu_text_color); ?>;
}

aside.sidebar--classic ul.menu ul.sub-menu > li > a:hover,
aside.sidebar--classic ul.menu ul.sub-menu > li.current_page_item > a,
aside.sidebar--classic ul.menu > li.current-menu-ancestor > a:hover {
  color: <?php echo esc_attr($side_submenu_text_hover_color); ?>;
}

<?php
  global $anps_options_data;
  if( isset($anps_options_data['hide_slider_on_mobile']) && $anps_options_data['hide_slider_on_mobile'] == 'on' ):
?>

@media (max-width: 786px) {
    .wpb_layerslider_element, .wpb_revslider_element {
        display: none;
    }
}

<?php endif; ?>

/* footer */

.site-footer h2,
.site-footer h3,
.site-footer h3.widget-title,
.site-footer h4,
.site-footer .menu .current_page_item > a,
.site-footer.site-footer--default strong {
    color: <?php echo esc_attr($footer_heading_text_color); ?>;
}

.site-footer .highlited,
.site-footer #wp-calendar #today {
    color: <?php echo esc_attr($footer_selected_color); ?>;
}

.site-footer .copyright-footer {
    border-top-color: <?php echo esc_attr($footer_divider_color); ?>;
    color: <?php echo esc_attr($copyright_footer_text_color); ?>;
}

.site-footer {
  background: <?php echo esc_attr($footer_bg_color); ?>;
  color: <?php echo esc_attr($footer_text_color); ?>;
}

.site-footer a:not([class*="btn"]):hover,
.site-footer a:not([class*="btn"]):focus {
  color: <?php echo esc_attr($footer_hover_color); ?>;
}

.site-footer .copyright-footer,
.tagcloud a  {
  background: <?php echo esc_attr($copyright_footer_bg_color); ?>;
}

.site-footer .tagcloud a {
    background-color: <?php echo esc_attr($footer_active_bg_color); ?>;
}

.site-footer .tagcloud a:hover,
.site-footer .tagcloud a:focus {
    background-color: <?php echo esc_attr($footer_active_hover_bg_color); ?>;
}

.site-footer.site-footer--modern .search-field,
.site-footer.site-footer--modern .opening-time,
.site-footer #wp-calendar tbody tr {
    border-color: <?php echo esc_attr($footer_border_color); ?>;
}

.site-footer.site-footer--modern .search-field:focus {
    border-color: <?php echo esc_attr($footer_border_active_color); ?>;
}

/*Selection / Hover*/

.contact-form--classic .wpcf7-text:focus,
.contact-form--classic .wpcf7-number:focus,
.contact-form--classic .wpcf7-textarea:focus, {
    border-color: <?php echo esc_attr($primary_color); ?>;
}

.site-wrapper *::-moz-selection {
    background-color: <?php echo esc_attr($primary_color); ?>;
    color: #fff;
}

.site-wrapper *::selection {
    background-color: <?php echo esc_attr($primary_color); ?>;
    color: #fff;
}

<?php
echo get_option("anps_custom_css", "");
}

/* Custom styles for buttons */

function anps_custom_styles_buttons() {
   /*buttons*/
    $default_button_bg = anps_get_option('', '#940855', 'default_button_bg');
    $default_button_color = anps_get_option('', '#fff', 'default_button_color');
    $default_button_hover_bg = anps_get_option('', '#BD1470', 'default_button_hover_bg');
    $default_button_hover_color = anps_get_option('', '#fff', 'default_button_hover_color');

    $style_1_button_bg = anps_get_option('', '#940855', 'style_1_button_bg');
    $style_1_button_color = anps_get_option('', '#fff', 'style_1_button_color');
    $style_1_button_hover_bg = anps_get_option('', '#BD1470', 'style_1_button_hover_bg');
    $style_1_button_hover_color = get_option('', '#fff', 'style_1_button_hover_color');

    $modern_1_button_bg = get_option('anps_modern_button_1_bg_color', '');
    $modern_1_button_color = get_option('anps_modern_button_1_color', '');
    $modern_1_button_border = get_option('anps_modern_button_1_border', '');
    $modern_1_button_hover_bg = get_option('anps_modern_button_1_hover_bg', '');
    $modern_1_button_hover_color = get_option('anps_modern_button_1_hover', '');
    $modern_1_button_hover_border = get_option('anps_modern_button_1_hover_border', '');
    $modern_1_button_border_radius = get_option('anps_modern_button_1_border_radius', '');

    $modern_2_button_bg = get_option('anps_modern_button_2_bg_color', '');
    $modern_2_button_color = get_option('anps_modern_button_2_color', '');
    $modern_2_button_border = get_option('anps_modern_button_2_border', '');
    $modern_2_button_hover_bg = get_option('anps_modern_button_2_hover_bg', '');
    $modern_2_button_hover_color = get_option('anps_modern_button_2_hover', '');
    $modern_2_button_hover_border = get_option('anps_modern_button_2_hover_border', '');
    $modern_2_button_border_radius = get_option('anps_modern_button_2_border_radius', '');

    $modern_3_button_bg = get_option('anps_modern_button_3_bg_color', '');
    $modern_3_button_color = get_option('anps_modern_button_3_color', '');
    $modern_3_button_border = get_option('anps_modern_button_3_border', '');
    $modern_3_button_hover_bg = get_option('anps_modern_button_3_hover_bg', '');
    $modern_3_button_hover_color = get_option('anps_modern_button_3_hover', '');
    $modern_3_button_hover_border = get_option('anps_modern_button_3_hover_border', '');
    $modern_3_button_border_radius = get_option('anps_modern_button_3_border_radius', '');

    $modern_4_button_bg = get_option('anps_modern_button_4_bg_color', '');
    $modern_4_button_color = get_option('anps_modern_button_4_color', '');
    $modern_4_button_border = get_option('anps_modern_button_4_border', '');
    $modern_4_button_hover_bg = get_option('anps_modern_button_4_hover_bg', '');
    $modern_4_button_hover_color = get_option('anps_modern_button_4_hover', '');
    $modern_4_button_hover_border = get_option('anps_modern_button_4_hover_border', '');
    $modern_4_button_border_radius = get_option('anps_modern_button_4_border_radius', '');

    $modern_5_button_bg = get_option('anps_modern_button_5_bg_color', '');
    $modern_5_button_color = get_option('anps_modern_button_5_color', '');
    $modern_5_button_border = get_option('anps_modern_button_5_border', '');
    $modern_5_button_hover_bg = get_option('anps_modern_button_5_hover_bg', '');
    $modern_5_button_hover_color = get_option('anps_modern_button_5_hover', '');
    $modern_5_button_hover_border = get_option('anps_modern_button_5_hover_border', '');
    $modern_5_button_border_radius = get_option('anps_modern_button_5_border_radius', '');

    $modern_6_button_color = get_option('anps_modern_button_6_color', '');
    $modern_6_button_hover_color = get_option('anps_modern_button_6_hover', '');

    $style_2_button_bg = anps_get_option('', '#940855', 'style_2_button_bg');
    $style_2_button_color = anps_get_option('', '#fff', 'style_2_button_color');
    $style_2_button_hover_bg = anps_get_option('', '#BD1470', 'style_2_button_hover_bg');
    $style_2_button_hover_color = anps_get_option('', '#fff', 'style_2_button_hover_color');

    $style_3_button_color = anps_get_option('', '#940855', 'style_3_button_color');
    $style_3_button_hover_bg = anps_get_option('', '#940855', 'style_3_button_hover_bg');
    $style_3_button_hover_color = anps_get_option('', '#ffffff', 'style_3_button_hover_color');
    $style_3_button_border_color = anps_get_option('', '#940855', 'style_3_button_border_color');

    $style_4_button_color = anps_get_option('', '#940855', 'style_4_button_color');
    $style_4_button_hover_color = anps_get_option('', '#000', 'style_4_button_hover_color');

    $style_slider_button_bg = anps_get_option('', '#292929', 'style_slider_button_bg');
    $style_slider_button_color = anps_get_option('', '#fff', 'style_slider_button_color');
    $style_slider_button_hover_bg = anps_get_option('', '#d54900', 'style_slider_button_hover_bg');
    $style_slider_button_hover_color = anps_get_option('', '#fff', 'style_slider_button_hover_color');

    $style_style_5_button_bg = anps_get_option('', '#c3c3c3', 'style_style_5_button_bg');
    $style_style_5_button_color = anps_get_option('', '#fff', 'style_style_5_button_color');
    $style_style_5_button_hover_bg = anps_get_option('', '#292929', 'style_style_5_button_hover_bg');
    $style_style_5_button_hover_color = anps_get_option('', '#fff', 'style_style_5_button_hover_color'); ?>

    /*buttons*/

    input#place_order {
         background-color: <?php echo esc_attr($default_button_bg); ?>;
    }

    input#place_order:hover,
    input#place_order:focus {
         background-color: <?php echo esc_attr($default_button_hover_bg); ?>;
    }

    .btn,
    .contact-form--classic .wpcf7-submit,
    button.single_add_to_cart_button,
    p.form-row input.button,
    .woocommerce-page .button:not(.wc-forward) {
        -moz-user-select: none;
        background-image: none;
        border: 0;
        color: #fff;
        cursor: pointer;
        display: inline-block;
        line-height: 1.5;
        margin-bottom: 0;
        text-align: center;
        text-transform: uppercase;
        text-decoration:none;
        transition: background-color 0.2s ease 0s;
        vertical-align: middle;
        white-space: nowrap;
    }

    .btn.btn-sm,
    .contact-form--classic .wpcf7-submit {
        padding: 11px 17px;
        font-size: 14px;
    }

    .btn,
    .contact-form--classic .wpcf7-submit,
    button.single_add_to_cart_button,
    p.form-row input.button,
    .woocommerce-page .button {
      border-radius: 0;
      border-radius: 4px;
      background-color: <?php echo esc_attr($default_button_bg); ?>;
      color: <?php echo esc_attr($default_button_color); ?>;
    }
    .btn:hover,
    .btn:active,
    .btn:focus,
    .contact-form--classic .wpcf7-submit:hover,
    .contact-form--classic .wpcf7-submit:active,
    .contact-form--classic .wpcf7-submit:focus,
    button.single_add_to_cart_button:hover, button.single_add_to_cart_button:active, button.single_add_to_cart_button:focus,
     p.form-row input.button:hover, p.form-row input.button:focus, .woocommerce-page .button:hover, .woocommerce-page .button:focus {
      background-color: <?php echo esc_attr($default_button_hover_bg); ?>;
      color: <?php echo esc_attr($default_button_hover_color); ?>;
      border:0;
    }

    .btn.style-1, .vc_btn.style-1   {
      border-radius: 4px;
      background-color: <?php echo esc_attr($style_1_button_bg); ?>;
      color: <?php echo esc_attr($style_1_button_color); ?>!important;
    }
    .btn.style-1:hover, .btn.style-1:active, .btn.style-1:focus, .vc_btn.style-1:hover, .vc_btn.style-1:active, .vc_btn.style-1:focus  {
      background-color: <?php echo esc_attr($style_1_button_hover_bg); ?>;
      color: <?php echo esc_attr($style_1_button_hover_color); ?>!important;
    }

    <?php for ($i=1; $i<=5; $i++):

        $bg_color = ${"modern_${i}_button_bg"};
        $border_color = ${"modern_${i}_button_border"};
        $border_hover = ${"modern_${i}_button_hover_border"};

        if ($bg_color === '') {
            $bg_color = 'rgba(0, 0, 0, 0)';
        }

        if ($border_color === '') {
            $border_color = 'rgba(0, 0, 0, 0)';
        }

        if ($border_hover === '') {
            $border_hover = 'rgba(0, 0, 0, 0)';
        }
        ?>
        .btn.modern-<?php echo esc_attr($i); ?> {
          background-color: <?php echo esc_attr($bg_color); ?>;
          color: <?php echo esc_attr(${"modern_${i}_button_color"}); ?>;
          border-radius: <?php echo esc_attr(${"modern_${i}_button_border_radius"}); ?>px;
          border: 1px solid <?php echo esc_attr($border_color); ?>;
        }

        .btn.modern-<?php echo esc_attr($i); ?>:hover,
        .btn.modern-<?php echo esc_attr($i); ?>:active,
        .btn.modern-<?php echo esc_attr($i); ?>:focus {
          background-color: <?php echo esc_attr(${"modern_${i}_button_hover_bg"}); ?>;
          color: <?php echo esc_attr(${"modern_${i}_button_hover_color"}); ?>;
          border: 1px solid <?php echo esc_attr($border_hover); ?>;
        }
    <?php endfor; ?>

    .btn.modern-6 {
      background: none;
      color: <?php echo esc_attr($modern_6_button_color); ?>;
      border: none;
    }

    .btn.modern-6:hover,
    .btn.modern-6:active,
    .btn.modern-6:focus {
      background: none;
      color: <?php echo esc_attr($modern_6_button_hover_color); ?>;
      border: none;
    }

    .btn.slider  {
      border-radius: 4px;
      background-color: <?php echo esc_attr($style_slider_button_bg); ?>;
      color: <?php echo esc_attr($style_slider_button_color); ?>;
    }
    .btn.slider:hover, .btn.slider:active, .btn.slider:focus  {
      background-color: <?php echo esc_attr($style_slider_button_hover_bg); ?>;
      color: <?php echo esc_attr($style_slider_button_hover_color); ?>;
    }

    .btn.style-2, .vc_btn.style-2  {
      border-radius: 4px;
      background-color: <?php echo esc_attr($style_2_button_bg); ?>;
      color: <?php echo esc_attr($style_2_button_color); ?>!important;
      border: none;
    }

    .btn.style-2:hover, .btn.style-2:active, .btn.style-2:focus, .vc_btn.style-2:hover, .vc_btn.style-2:active, .vc_btn.style-2:focus   {
      background-color: <?php echo esc_attr($style_2_button_hover_bg); ?>;
      color: <?php echo esc_attr($style_2_button_hover_color); ?>!important;
      border: none;
    }

    .btn.style-3, .vc_btn.style-3  {
      border: 2px solid <?php echo esc_attr($style_3_button_border_color); ?>;;
      border-radius: 4px;
      background-color: transparent;
      color: <?php echo esc_attr($style_3_button_color); ?>!important;
    }
    .btn.style-3:hover, .btn.style-3:active, .btn.style-3:focus, .vc_btn.style-3:hover, .vc_btn.style-3:active, .vc_btn.style-3:focus  {
      border: 2px solid <?php echo esc_attr($style_3_button_border_color); ?>;
      background-color: <?php echo esc_attr($style_3_button_hover_bg); ?>;
      color: <?php echo esc_attr($style_3_button_hover_color); ?>!important;
    }

    .btn.style-4, .vc_btn.style-4   {
      padding-left: 0;
      background-color: transparent;
      color: <?php echo esc_attr($style_4_button_color); ?>!important;
      border: none;
    }

    .btn.style-4:hover, .btn.style-4:active, .btn.style-4:focus, .vc_btn.style-4:hover, .vc_btn.style-4:active, .vc_btn.style-4:focus   {
      padding-left: 0;
      background: none;
      color: <?php echo esc_attr($style_4_button_hover_color); ?>!important;
      border: none;
      border-color: transparent;
      outline: none;
    }

    .btn.style-5, .vc_btn.style-5   {
      background-color: <?php echo esc_attr($style_style_5_button_bg); ?>!important;
      color: <?php echo esc_attr($style_style_5_button_color); ?>!important;
      border: none;
    }

    .btn.style-5:hover, .btn.style-5:active, .btn.style-5:focus, .vc_btn.style-5:hover, .vc_btn.style-5:active, .vc_btn.style-5:focus   {
      background-color: <?php echo esc_attr($style_style_5_button_hover_bg); ?>!important;
      color: <?php echo esc_attr($style_style_5_button_hover_color); ?>!important;
    }
    <?php
}

/* Woocommerce Breadcrumbs settings (remove nav wrapper) */

add_filter( 'woocommerce_breadcrumb_defaults', 'anps_woocommerce_breadcrumbs' );
function anps_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => ' &#47; ',
        'wrap_before' => '',
        'wrap_after'  => '',
        'before'      => '',
        'after'       => '',
        'home'        => esc_html__( 'Home', 'hairdresser' ),
    );
}

/* Wrap font with quotes */
if (!function_exists('anps_wrap_font')) {
    function anps_wrap_font($font) {
        $temp = explode(', ', $font);
        $return = '';

        if (count($temp) > 1) {
            foreach ($temp as $name) {
                if ($return === '') {
                    $return .= "'$name'";
                } else {
                    $return .= ", $name";
                }
            }
        } else {
            $return = "'$font'";
        }

        $return = str_replace('Montserrat Light', 'Montserrat', $return);

        return $return;
    }
}

/* Social icons (left side) */

function anps_social_bar() {
    $icons_option = get_option('anps_global_social_icons', '');
    if ($icons_option != '') {
        $icons = explode('|', $icons_option);

        echo '<div class="social-bar-wrapper">';
            echo '<div class="social-bar">';
                foreach ($icons as $icon) {
                    $icon_data = explode(';', $icon);

                    echo "<a class='social-bar__item' title='$icon_data[2]' href='$icon_data[1]'>";
                        echo "<i class='social-bar__icon $icon_data[0]'></i>";
                        echo "<span class='sr-only'>$icon_data[2]</span>";
                    echo "</a>";
                }
            echo '</div>';
        echo '</div>';
    }
}

/* Scroll top */

function anps_scroll_top($style, $fixed) {
    $class_name = 'scroll-top scroll-top--style-' . $style;
    $id = '';

    if ($fixed) {
        $class_name .= ' scroll-top--fixed';
    }

    ?>
    <button class="<?php echo esc_attr($class_name); ?>" title="<?php _e('Scroll to top', 'hairdresser'); ?>">
        <span class="sr-only"><?php _e('Scroll to top', 'hairdresser'); ?></span>

        <?php if ($style === '3'): ?>
            <?php echo anps_svg('arrow-on-top'); ?>
        <?php endif; ?>
    </button>
    <?php
}

function anps_portfolio_footer() {
    $portfolio_footer = anps_get_option('', '', 'portfolio_single_footer');

    if ($portfolio_footer != '') {
        echo '<p>&nbsp;</p><p>&nbsp;</p>';
    }

    echo do_shortcode(stripslashes($portfolio_footer));
}
