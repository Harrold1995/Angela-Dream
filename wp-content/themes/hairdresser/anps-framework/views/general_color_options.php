<?php
include_once get_template_directory() . '/anps-framework/classes/Options.php';
$anps_options_data = $options->get_page_data();
if (isset($_GET['save_general'])) {
    $options->save_page_setup('general_color_options');
}
?>
<div class="content">
    <form action="themes.php?page=theme_options&sub_page=general_color_options&save_general" method="post">
        <div class="content-top">
            <input type="submit" value="<?php esc_html_e("Save all changes", 'hairdresser'); ?>">
            <div class="clear"></div>
        </div>
        <div class="content-inner">
            <h3><?php esc_html_e('Main theme colors', 'hairdresser'); ?></h3>
            <div class="input onequarter">
                <label for="anps_text_color"><?php esc_html_e('Text color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#727272', 'text_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#727272', 'text_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_text_color" value="<?php echo esc_attr(anps_get_option('', '#727272', 'text_color')); ?>" id="anps_text_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_headings_color"><?php esc_html_e('Headings color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#000', 'headings_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#000', 'headings_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_headings_color" value="<?php echo esc_attr(anps_get_option('', '#000', 'headings_color')); ?>" id="anps_headings_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_headings_color"><?php esc_html_e('Link color', 'hairdresser'); ?></label>
                <input data-value="<?php echo get_option('anps_link_color', '#000'); ?>" readonly style="background: <?php echo get_option('anps_link_color', '#000'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_link_color" value="<?php echo get_option('anps_link_color', '#000'); ?>" id="anps_link_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_link_hover_color"><?php esc_html_e('Link hover color', 'hairdresser'); ?></label>
                <input data-value="<?php echo get_option('anps_link_hover_color', '#999'); ?>" readonly style="background: <?php echo get_option('anps_link_hover_color', '#999'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_link_hover_color" value="<?php echo get_option('anps_link_hover_color', '#999'); ?>" id="anps_link_hover_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_breadcrumbs_link_color">
                    <?php esc_html_e('Breadcrumbs link color', 'hairdresser'); ?>
                </label>
                <input
                    data-value="<?php echo get_option('anps_breadcrumbs_link_color', '#000'); ?>"
                    readonly
                    style="background: <?php echo get_option('anps_breadcrumbs_link_color', '#000'); ?>"
                    class="color-pick-color"
                />
                <input
                    class="color-pick"
                    type="text"
                    name="anps_breadcrumbs_link_color"
                    value="<?php echo get_option('anps_breadcrumbs_link_color', '#000'); ?>"
                    id="anps_breadcrumbs_link_color"
                />
            </div>
            <div class="input onequarter">
                <label for="anps_breadcrumbs_link_hover_color">
                    <?php esc_html_e('Breadcrumbs link hover color', 'hairdresser'); ?>
                </label>
                <input
                    data-value="<?php echo get_option('anps_breadcrumbs_link_hover_color', '#999'); ?>"
                    readonly
                    style="background: <?php echo get_option('anps_breadcrumbs_link_hover_color', '#999'); ?>"
                    class="color-pick-color"
                />
                <input
                    class="color-pick"
                    type="text"
                    name="anps_breadcrumbs_link_hover_color"
                    value="<?php echo get_option('anps_breadcrumbs_link_hover_color', '#999'); ?>"
                    id="anps_breadcrumbs_link_hover_color"
                />
            </div>
            <div class="input onequarter">
                <label for="anps_breadcrumbs_text_color">
                    <?php esc_html_e('Breadcrumbs text color', 'hairdresser'); ?>
                </label>
                <input
                    data-value="<?php echo get_option('anps_breadcrumbs_text_color', '#c3c3c3'); ?>"
                    readonly
                    style="background: <?php echo get_option('anps_breadcrumbs_text_color', '#c3c3c3'); ?>"
                    class="color-pick-color"
                />
                <input
                    class="color-pick"
                    type="text"
                    name="anps_breadcrumbs_text_color"
                    value="<?php echo get_option('anps_breadcrumbs_text_color', '#c3c3c3'); ?>"
                    id="anps_breadcrumbs_text_color"
                />
            </div>
            <p>&nbsp;</p>
            <div class="clear"></div>
            <h3><?php esc_html_e('Header colors', 'hairdresser'); ?></h3>
            <div class="input onequarter">
                <label for="anps_menu_text_color"><?php esc_html_e('Menu text color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#000', 'menu_text_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#000', 'menu_text_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_menu_text_color" value="<?php echo esc_attr(anps_get_option('', '#000', 'menu_text_color')); ?>" id="anps_menu_text_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_top_bar_color"><?php esc_html_e('Top bar text color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#bf5a91', 'top_bar_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#bf5a91', 'top_bar_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_top_bar_color" value="<?php echo esc_attr(anps_get_option('', '#bf5a91', 'top_bar_color')); ?>" id="anps_top_bar_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_top_bar_bg_color"><?php esc_html_e('Top bar background color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#940855', 'top_bar_bg_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#940855', 'top_bar_bg_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_top_bar_bg_color" value="<?php echo esc_attr(anps_get_option('', '#940855', 'top_bar_bg_color')); ?>" id="anps_top_bar_bg_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_nav_background_color"><?php esc_html_e('Page header background color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'nav_background_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'nav_background_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_nav_background_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'nav_background_color')); ?>" id="anps_nav_background_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_submenu_background_color"><?php esc_html_e('Submenu background color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'submenu_background_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'submenu_background_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_submenu_background_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'submenu_background_color')); ?>" id="anps_submenu_background_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_submenu_divider_color"><?php esc_html_e('Submenu divider color', 'hairdresser'); ?></label>
                <input data-value="<?php echo get_option('anps_submenu_divider_color', '#ececec'); ?>" readonly style="background: <?php echo get_option('anps_submenu_divider_color', '#ececec'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_submenu_divider_color" value="<?php echo get_option('anps_submenu_divider_color', '#ececec'); ?>" id="anps_submenu_divider_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_curent_menu_color"><?php esc_html_e('Selected main menu color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_curent_menu_color', '#940855')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_curent_menu_color', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_curent_menu_color" value="<?php echo esc_attr(get_option('anps_curent_menu_color', '#940855')); ?>" id="anps_curent_menu_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_submenu_text_color"><?php esc_html_e('Submenu text color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#000', 'submenu_text_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#000', 'submenu_text_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_submenu_text_color" value="<?php echo esc_attr(anps_get_option('', '#000', 'submenu_text_color')); ?>" id="anps_submenu_text_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_woo_cart_items_number_bg_color"><?php esc_html_e('Cart number background color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_woo_cart_items_number_bg_color', '#940855')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_woo_cart_items_number_bg_color', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_woo_cart_items_number_bg_color" value="<?php echo esc_attr(get_option('anps_woo_cart_items_number_bg_color', '#940855')); ?>" id="anps_woo_cart_items_number_bg_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_woo_cart_items_number_color"><?php esc_html_e('Cart number text color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_woo_cart_items_number_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_woo_cart_items_number_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_woo_cart_items_number_color" value="<?php echo esc_attr(get_option('anps_woo_cart_items_number_color', '#fff')); ?>" id="anps_woo_cart_items_number_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_logo_bg_color"><?php esc_html_e('Logo background color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_logo_bg_color')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_logo_bg_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_logo_bg_color" value="<?php echo esc_attr(get_option('anps_logo_bg_color')); ?>" id="anps_logo_bg_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_above_menu_bg_color"><?php esc_html_e('Above menu background color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_above_menu_bg_color')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_above_menu_bg_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_above_menu_bg_color" value="<?php echo esc_attr(get_option('anps_above_menu_bg_color')); ?>" id="anps_above_menu_bg_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_page_heading_bg_color"><?php esc_html_e('Page heading background color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_page_heading_bg_color')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_page_heading_bg_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_page_heading_bg_color" value="<?php echo esc_attr(get_option('anps_page_heading_bg_color')); ?>" id="anps_page_heading_bg_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_page_heading_text_color"><?php esc_html_e('Page heading text color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_page_heading_text_color')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_page_heading_text_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_page_heading_text_color" value="<?php echo esc_attr(get_option('anps_page_heading_text_color')); ?>" id="anps_page_heading_text_color" />
            </div>
            <p>&nbsp;</p>
            <div class="clear"></div>

            <h3><?php esc_html_e('Footer colors', 'hairdresser'); ?></h3>
            <div class="input onequarter">
                <label for="anps_footer_bg_color"><?php esc_html_e('Footer background color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#141414', 'footer_bg_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#141414', 'footer_bg_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_footer_bg_color" value="<?php echo esc_attr(anps_get_option('', '#141414', 'footer_bg_color')); ?>" id="anps_footer_bg_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_footer_text_color"><?php esc_html_e('Footer text color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#adadad', 'footer_text_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#adadad', 'footer_text_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_footer_text_color" value="<?php echo esc_attr(anps_get_option('', '#adadad', 'footer_text_color')); ?>" id="anps_footer_text_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_footer_heading_text_color"><?php esc_html_e('Footer heading text color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_footer_heading_text_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_footer_heading_text_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_footer_heading_text_color" value="<?php echo esc_attr(get_option('anps_footer_heading_text_color', '#fff')); ?>" id="anps_footer_heading_text_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_footer_selected_color"><?php esc_html_e('Footer selected color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_footer_selected_color', '')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_footer_selected_color', '')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_footer_selected_color" value="<?php echo esc_attr(get_option('anps_footer_selected_color', '')); ?>" id="anps_footer_selected_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_footer_hover_color"><?php esc_html_e('Footer hover color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_footer_hover_color', '')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_footer_hover_color', '')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_footer_hover_color" value="<?php echo esc_attr(get_option('anps_footer_hover_color', '')); ?>" id="anps_footer_hover_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_footer_divider_color"><?php esc_html_e('Footer divider color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_footer_divider_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_footer_divider_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_footer_divider_color" value="<?php echo esc_attr(get_option('anps_footer_divider_color', '#fff')); ?>" id="anps_footer_divider_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_copyright_footer_text_color"><?php esc_html_e('Copyright footer text color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_copyright_footer_text_color', '#4a4a4a')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_copyright_footer_text_color', '#4a4a4a')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_copyright_footer_text_color" value="<?php echo esc_attr(get_option('anps_copyright_footer_text_color', '#4a4a4a')); ?>" id="anps_copyright_footer_text_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_copyright_footer_bg_color"><?php esc_html_e('Copyright footer background color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#0d0d0d', 'copyright_footer_bg_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#0d0d0d', 'copyright_footer_bg_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_copyright_footer_bg_color" value="<?php echo esc_attr(anps_get_option('', '#0d0d0d', 'copyright_footer_bg_color')); ?>" id="anps_copyright_footer_bg_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_footer_border_color"><?php esc_html_e('Footer border color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#5b5b5b', 'anps_footer_border_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#5b5b5b', 'anps_footer_border_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_footer_border_color" value="<?php echo esc_attr(anps_get_option('', '#5b5b5b', 'anps_footer_border_color')); ?>" id="anps_footer_border_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_footer_border_active_color"><?php esc_html_e('Footer border active color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'anps_footer_border_active_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'anps_footer_border_active_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_footer_border_active_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'anps_footer_border_active_color')); ?>" id="anps_footer_border_active_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_footer_active_bg_color"><?php esc_html_e('Footer active background color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#5b5b5b', 'anps_footer_active_bg_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#5b5b5b', 'anps_footer_active_bg_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_footer_active_bg_color" value="<?php echo esc_attr(anps_get_option('', '#5b5b5b', 'anps_footer_active_bg_color')); ?>" id="anps_footer_active_bg_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_footer_active_hover_bg_color"><?php esc_html_e('Footer active hover background color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#333', 'anps_footer_active_hover_bg_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#333', 'anps_footer_active_hover_bg_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_footer_active_hover_bg_color" value="<?php echo esc_attr(anps_get_option('', '#333', 'anps_footer_active_hover_bg_color')); ?>" id="anps_footer_active_hover_bg_color" />
            </div>
        </div>
        <div class="clear"></div>
        <?php anps_admin_save_buttons(); ?>
    </form>
    <div class="clear"></div>
</div>
