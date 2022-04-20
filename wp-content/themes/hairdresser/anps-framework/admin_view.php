<?php
    global $anps_current_page;
    $anps_current_page = isset($_GET['sub_page']) ? $_GET['sub_page'] : '';

    function anps_admin_link($data) {
        global $anps_current_page;
        $attrs = ' href="themes.php?page=theme_options&sub_page=' . $data['slug'] . '"';
        if (isset($data['default']) && $data['default'] === true) {
            if ($anps_current_page === '' || $anps_current_page === $data['slug']) {
                $attrs .= ' id="selected-menu-subitem"';
            }
        } else {
            if ($anps_current_page === $data['slug']) {
                $attrs .= ' id="selected-menu-subitem"';
            }
        }

        echo '<li><a' . $attrs . '><i class="fa fa-' . $data['icon'] . '"></i>' . $data['label'] . '</a></li>';
    }
?>

<div class="envoo-admin">
<?php $themever = wp_get_theme(get_template()); ?>
    <ul class="envoo-admin-menu">
        <li>
            <a id="anpslogo" href="https://anpsthemes.com" target="_blank"></a>
            <h2 class="small_lh">
                <?php esc_html_e("Theme Options", 'hairdresser'); ?><br/>
                <span id="version"><?php echo esc_html__('Version', 'hairdresser') . ': ' . esc_attr($themever["Version"]); ?></span>
            </h2>
        </li>
        <?php
            $links = array(
                array(
                    'label' => esc_html__('General color options', 'hairdresser'),
                    'slug'  => 'general_color_options',
                    'icon'  => 'tint',
                    'default' => true,
                ),
                array(
                    'label' => esc_html__('Classic color options', 'hairdresser'),
                    'slug'  => 'classic_color_options',
                    'icon'  => 'tint',
                ),
                array(
                    'label' => esc_html__('Modern color options', 'hairdresser'),
                    'slug'  => 'modern_color_options',
                    'icon'  => 'tint',
                ),
                array(
                    'label' => esc_html__('Font options', 'hairdresser'),
                    'slug'  => 'font_options',
                    'icon'  => 'font',
                ),
                array(
                    'label' => esc_html__('Update Google Fonts', 'hairdresser'),
                    'slug'  => 'theme_style_google_font',
                    'icon'  => 'google',
                ),
                array(
                    'label' => esc_html__('Custom Fonts', 'hairdresser'),
                    'slug'  => 'theme_style_custom_font',
                    'icon'  => 'text-height',
                ),
                array(
                    'label' => esc_html__('Custom CSS', 'hairdresser'),
                    'slug'  => 'theme_style_custom_css',
                    'icon'  => 'code',
                ),
                array(
                    'label' => esc_html__('Page Layout', 'hairdresser'),
                    'slug'  => 'options',
                    'icon'  => 'columns',
                ),
                array(
                    'label' => esc_html__('Page Setup', 'hairdresser'),
                    'slug'  => 'options_page_setup',
                    'icon'  => 'cog',
                ),
                array(
                    'label' => esc_html__('Header Options', 'hairdresser'),
                    'slug'  => 'header_options',
                    'icon'  => 'bars',
                ),
                array(
                    'label' => esc_html__('Footer Options', 'hairdresser'),
                    'slug'  => 'footer_options',
                    'icon'  => 'level-down',
                ),
                array(
                    'label' => esc_html__('WooCommerce', 'hairdresser'),
                    'slug'  => 'woocommerce',
                    'icon'  => 'shopping-basket',
                ),
                array(
                    'label' => esc_html__('Logos & Media', 'hairdresser'),
                    'slug'  => 'options_media',
                    'icon'  => 'picture-o',
                ),
                array(
                    'label' => esc_html__('Google Maps', 'hairdresser'),
                    'slug'  => 'google_maps',
                    'icon'  => 'map',
                ),
                array(
                    'label' => esc_html__('Dummy Content', 'hairdresser'),
                    'slug'  => 'dummy_content',
                    'icon'  => 'dropbox',
                ),
                array(
                    'label' => esc_html__('Theme Update', 'hairdresser'),
                    'slug'  => 'theme_upgrade',
                    'icon'  => 'cloud-download',
                ),
                array(
                    'label' => esc_html__('Import/Export', 'hairdresser'),
                    'slug'  => 'import_export',
                    'icon'  => 'file-code-o',
                ),
                array(
                    'label' => esc_html__('Import/Export Widgets', 'hairdresser'),
                    'slug'  => 'import_export_widgets',
                    'icon'  => 'file-code-o',
                ),
                array(
                    'label' => esc_html__('System Requirements', 'hairdresser'),
                    'slug'  => 'system_req',
                    'icon'  => 'cogs',
                ),
            );

            foreach ($links as $link) {
                anps_admin_link($link);
            }
        ?>
    </ul>
    <div class="envoo-admin-content <?php echo esc_attr($anps_current_page);?>">
        <?php
        switch($anps_current_page) {
            case 'font_options': include_once 'views/font_options.php'; break;
            case 'general_color_options': include_once 'views/general_color_options.php'; break;
            case 'classic_color_options': include_once 'views/classic_color_options.php'; break;
            case 'modern_color_options': include_once 'views/modern_color_options.php'; break;
            case 'options': include_once 'views/options_page_view.php'; break;
            case 'options_page': include_once 'views/options_page_view.php'; break;
            case 'header_options': include_once 'views/header_options_view.php'; break;
            case 'footer_options': include_once 'views/footer_options_view.php'; break;
            case 'options_page_setup': include_once 'views/options_page_setup_view.php'; break;
            case 'options_media': include_once 'views/options_media_view.php'; break;
            case 'google_maps': include_once 'views/google_maps_view.php'; break;
            case 'dummy_content': include_once 'views/dummy_view.php'; break;
            case 'theme_upgrade': include_once 'views/theme_upgrade_view.php'; break;
            case 'theme_style_google_font': include_once 'views/update_google_font_view.php'; break;
            case 'theme_style_custom_font': include_once 'views/update_custom_font_view.php'; break;
            case 'theme_style_custom_css': include_once 'views/custom_css_view.php'; break;
            case 'import_export': include_once 'views/import_export_view.php'; break;
            case 'import_export_widgets': include_once 'views/import_export_widgets_view.php'; break;
            case 'system_req': include_once 'views/system_req_view.php'; break;
            case 'woocommerce': include_once 'views/woocommerce_view.php'; break;
            default: include_once 'views/general_color_options.php';
        }
        ?>
    </div>
</div>
