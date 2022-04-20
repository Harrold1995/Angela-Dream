<?php
    global $anps_options_data;
    $page_heading_full = get_post_meta(anps_get_id(), $key ='anps_page_heading_full', $single = true );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php anps_theme_after_styles(); ?>
        <?php if(isset($page_heading_full)&&$page_heading_full=="on") { add_action("wp_head", 'anps_page_full_screen_style', 1000); } ?>
        <?php wp_head(); ?>
</head>
<body <?php body_class(anps_boxed_or_vertical().anps_header_margin().anps_footer().anps_woo_style().anps_contact_form_style());?><?php anps_body_style();?>>
    <div class="site-wrap">
<?php
    $coming_soon = anps_get_option('', '0', 'coming_soon');
    if($coming_soon=="0"||is_super_admin()) : ?>
        <div class="site-wrapper <?php if(get_option('anps_vc_legacy', "0")=="on") {echo "legacy";} ?>">
            <?php $anps_menu_type = get_option('anps_menu_type', '2'); ?>
            <?php if (get_option('anps_search_style', 'default') == 'default'): ?>
                <div class="site-search" id="site-search"><?php anps_get_search(); ?></div>
            <?php endif; ?>
            <?php if(get_option('anps_menu_type', '2')=='7' || get_option('anps_menu_type', '2')=='8') :
                anps_get_header();
            endif; ?>
                <?php
                if(isset($page_heading_full)&&$page_heading_full=="on") :
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
                    if( get_option('anps_menu_type', '2')!='5' && get_option('anps_menu_type', '2')!='6' ):
                        $height_value = get_post_meta(anps_get_id(), $key ='anps_full_height', $single = true );
                        if( $height_value ) {
                            $height_value = 'height: ' . $height_value . 'px; ';
                        }

                ?>
                <div class="paralax-header parallax-window" data-type="background" data-speed="5" style="<?php echo esc_attr($height_value); ?>background-image: url(<?php echo esc_url($heading_value); ?>);<?php echo esc_attr($anps_heading_bg_color); ?>">
                <?php if(get_option('anps_menu_type', '2')=='7' || get_option('anps_menu_type', '2')=='8') : ?>
                    <?php
                        $page_heading_full_style = get_post_meta(anps_get_id(), $key ='anps_full_header_style', $single = true);
                    ?>
                    <?php if(function_exists('is_shop') && is_shop() || !is_woocommerce()): ?>
                    <div class='page-heading page-header--<?php echo esc_attr($page_heading_full_style); ?>'>
                        <div class='container'>
                            <?php
                            /* Site tile */
                            echo anps_site_title();
                            /* Description */
                            echo anps_site_description();
                            /* Button */
                            echo anps_site_button();
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php
                $breadcrumbs_page = get_post_meta(anps_get_id(), $key ='anps_disable_breadcrumbs', $single = true );

                if(anps_get_option($anps_options_data, 'breadcrumbs') != '1' && $breadcrumbs_page != 'on') {
                    $breadcrumbs_style = 'classic';
                    if (get_option('anps_title_breadcrumbs', '1') == '3') {
                        $breadcrumbs_style = 'modern';
                    }

                    echo '<div class="page-breadcrumbs page-breadcrumbs--' . esc_attr($breadcrumbs_style) . '"><div class="container">' . anps_the_breadcrumb() . '</div></div>';
                }
                ?>
                <?php endif; ?>
          <?php endif;
      endif;
    endif;
    if(get_option('anps_menu_type', '2')!='7' && get_option('anps_menu_type', '2')!='8') :
        anps_get_header();
    endif;
