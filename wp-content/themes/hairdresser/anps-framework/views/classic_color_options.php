<?php
include_once get_template_directory() . '/anps-framework/classes/Options.php';
$anps_options_data = $options->get_page_data();
if (isset($_GET['save_classic'])) {
    $options->save_page_setup('classic_color_options');
}
?>
<div class="content">
    <form action="themes.php?page=theme_options&sub_page=classic_color_options&save_classic" method="post">
        <div class="content-top">
            <input type="submit" value="<?php esc_html_e("Save all changes", 'hairdresser'); ?>">
            <div class="clear"></div>
        </div>
        <div class="content-inner">
            <h3><?php esc_html_e('Main theme colors', 'hairdresser'); ?></h3>
            <div class="input onequarter">
                <label for="anps_primary_color"><?php esc_html_e('Primary color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#940855', 'primary_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#940855', 'primary_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_primary_color" value="<?php echo esc_attr(anps_get_option('', '#940855', 'primary_color')); ?>" id="anps_primary_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_hovers_color"><?php esc_html_e('Hovers color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#BD1470', 'hovers_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#BD1470', 'hovers_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_hovers_color" value="<?php echo esc_attr(anps_get_option('', '#BD1470', 'hovers_color')); ?>" id="anps_hovers_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_main_divider_color"><?php esc_html_e('Main divider color', 'hairdresser'); ?></label>
                <input data-value="<?php echo get_option('anps_main_divider_color', '#940855'); ?>" readonly style="background: <?php echo get_option('anps_main_divider_color', '#940855'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_main_divider_color" value="<?php echo get_option('anps_main_divider_color', '#940855'); ?>" id="anps_main_divider_color" />
            </div>

            <div class="input onequarter">
                <label for="anps_side_submenu_background_color"><?php esc_html_e('Side submenu background color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '', 'side_submenu_background_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '', 'side_submenu_background_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_side_submenu_background_color" value="<?php echo esc_attr(anps_get_option('', '', 'side_submenu_background_color')); ?>" id="anps_side_submenu_background_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_side_submenu_text_color"><?php esc_html_e('Side submenu text color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '', 'side_submenu_text_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '', 'side_submenu_text_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_side_submenu_text_color" value="<?php echo esc_attr(anps_get_option('', '', 'side_submenu_text_color')); ?>" id="anps_side_submenu_text_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_side_submenu_text_hover_color"><?php esc_html_e('Side submenu text hover color', 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '', 'side_submenu_text_hover_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '', 'side_submenu_text_hover_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_side_submenu_text_hover_color" value="<?php echo esc_attr(anps_get_option('', '', 'side_submenu_text_hover_color')); ?>" id="anps_side_submenu_text_hover_color" />
            </div>
            <p>&nbsp;</p>
            <div class="clear"></div>

            <h3><?php esc_html_e("Classic button styles", 'hairdresser'); ?></h3>
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4>Default button</h4>
                    <a class="btn btn-sm btn--default" data-button="default" href="#">Button</a>
                </div>
                <div class="input onequarter">
                    <label for="anps_default_button_bg"><?php esc_html_e("Default button background", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#940855', 'default_button_bg')); ?>" data-bg="default" readonly style="background: <?php echo esc_attr(anps_get_option('', '#940855', 'default_button_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_default_button_bg" value="<?php echo esc_attr(anps_get_option('', '#940855', 'default_button_bg')); ?>" id="anps_default_button_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_default_button_color"><?php esc_html_e("Default button color", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'default_button_color')); ?>" data-color="default" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'default_button_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_default_button_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'default_button_color')); ?>" id="anps_default_button_color" />
                </div>
                <div class="input onequarter">
                    <label for="anps_default_button_hover_bg"><?php esc_html_e("Default button hover background", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#BD1470', 'default_button_hover_bg')); ?>" data-bgHover="default" readonly style="background: <?php echo esc_attr(anps_get_option('', '#BD1470', 'default_button_hover_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_default_button_hover_bg" value="<?php echo esc_attr(anps_get_option('', '#BD1470', 'default_button_hover_bg')); ?>" id="anps_default_button_hover_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_default_button_hover_color"><?php esc_html_e("Default button hover color", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'default_button_hover_color')); ?>" data-colorHover="default" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'default_button_hover_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_default_button_hover_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'default_button_hover_color')); ?>" id="anps_default_button_hover_color" />
                </div>
                <div class="clear"></div>
                <hr>
            </div>
            <div class="clear"></div>
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php esc_html_e("Button style-1", 'hairdresser');?></h4>
                    <a class="btn btn-sm style-1 btn--style-1" data-button="style-1" href="#">Button</a>
                </div>
                <div class="input onequarter">
                    <label for="anps_style_1_button_bg"><?php esc_html_e("button background", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#940855', 'style_1_button_bg')); ?>" data-bg="style-1" readonly style="background: <?php echo esc_attr(anps_get_option('', '#940855', 'style_1_button_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_1_button_bg" value="<?php echo esc_attr(anps_get_option('', '#940855', 'style_1_button_bg')); ?>" id="anps_style_1_button_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_1_button_color"><?php esc_html_e("button color", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_1_button_color')); ?>" data-color="style-1" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_1_button_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_1_button_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_1_button_color')); ?>" id="anps_style_1_button_color" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_1_button_hover_bg"><?php esc_html_e("button hover background", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#BD1470', 'style_1_button_hover_bg')); ?>" data-bgHover="style-1" readonly style="background: <?php echo esc_attr(anps_get_option('', '#BD1470', 'style_1_button_hover_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_1_button_hover_bg" value="<?php echo esc_attr(anps_get_option('', '#BD1470', 'style_1_button_hover_bg')); ?>" id="anps_style_1_button_hover_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_1_button_hover_color"><?php esc_html_e("button hover color", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_1_button_hover_color')); ?>" data-colorHover="style-1" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_1_button_hover_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_1_button_hover_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_1_button_hover_color')); ?>" id="anps_style_1_button_hover_color" />
                </div>
                <div class="clear"></div>
                <hr>
            </div>
            <div class="clear"></div>
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php esc_html_e("Button style-2", 'hairdresser');?></h4>
                    <a class="btn btn-sm style-2 btn--style-2" data-button="style-2" href="#">Button</a>
                </div>
                <div class="input onequarter">
                    <label for="anps_style_2_button_bg"><?php esc_html_e("button background", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#940855', 'style_2_button_bg')); ?>" data-bg="style-2" data-border="style-2" readonly style="background: <?php echo esc_attr(anps_get_option('', '#940855', 'style_2_button_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_2_button_bg" value="<?php echo esc_attr(anps_get_option('', '#940855', 'style_2_button_bg')); ?>" id="anps_style_2_button_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_2_button_color"><?php esc_html_e("button color", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_2_button_color')); ?>" data-color="style-2" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_2_button_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_2_button_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_2_button_color')); ?>" id="anps_style_2_button_color" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_2_button_hover_bg"><?php esc_html_e("button hover background", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#BD1470', 'style_2_button_hover_bg')); ?>" data-bgHover="style-2" readonly style="background: <?php echo esc_attr(anps_get_option('', '#BD1470', 'style_2_button_hover_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_2_button_hover_bg" value="<?php echo esc_attr(anps_get_option('', '#BD1470', 'style_2_button_hover_bg')); ?>" id="anps_style_2_button_hover_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_2_button_hover_color"><?php esc_html_e("button hover color", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_2_button_hover_color')); ?>" data-colorHover="style-2" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_2_button_hover_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_2_button_hover_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_2_button_hover_color')); ?>" id="anps_style_2_button_hover_color" />
                </div>
                <div class="clear"></div>
                <hr>
            </div>
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php esc_html_e("Button style-3", 'hairdresser');?></h4>
                    <a class="btn btn-sm style-3 btn--style-3" data-button="style-3" href="#">Button</a>
                </div>
                <div class="input onequarter">
                    <label for="anps_style_3_button_color"><?php esc_html_e("button color", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#940855', 'style_3_button_color')); ?>" data-color="style-3" readonly style="background: <?php echo esc_attr(anps_get_option('', '#940855', 'style_3_button_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_3_button_color" value="<?php echo esc_attr(anps_get_option('', '#940855', 'style_3_button_color')); ?>" id="anps_style_3_button_color" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_3_button_hover_bg"><?php esc_html_e("button hover background", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#940855', 'style_3_button_hover_bg')); ?>" data-bgHover="style-3" readonly style="background: <?php echo esc_attr(anps_get_option('', '#940855', 'style_3_button_hover_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_3_button_hover_bg" value="<?php echo esc_attr(anps_get_option('', '#940855', 'style_3_button_hover_bg')); ?>" id="anps_style_3_button_hover_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_3_button_hover_color"><?php esc_html_e("button hover color", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#ffffff', 'style_3_button_hover_color')); ?>" data-colorHover="style-3" readonly style="background: <?php echo esc_attr(anps_get_option('', '#ffffff', 'style_3_button_hover_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_3_button_hover_color" value="<?php echo esc_attr(anps_get_option('', '#ffffff', 'style_3_button_hover_color')); ?>" id="anps_style_3_button_hover_color" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_3_button_border_color"><?php esc_html_e("button border color", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#940855', 'style_3_button_border_color')); ?>" data-border="style-3" readonly style="background: <?php echo esc_attr(anps_get_option('', '#940855', 'style_3_button_border_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_3_button_border_color" value="<?php echo esc_attr(anps_get_option('', '#940855', 'style_3_button_border_color')); ?>" id="anps_style_3_button_border_color" />
                </div>
                <div class="clear"></div>
                <hr>
            </div>
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php esc_html_e("Button style-4", 'hairdresser');?></h4>
                    <a class="btn btn-sm style-4 btn--style-4" data-button="style-4" href="#">Button</a>
                </div>
                <div class="input onequarter">
                    <label for="anps_style_4_button_color"><?php esc_html_e("button color", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#940855', 'style_4_button_color')); ?>" data-color="style-4" readonly style="background: <?php echo esc_attr(anps_get_option('', '#940855', 'style_4_button_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_4_button_color" value="<?php echo esc_attr(anps_get_option('', '#940855', 'style_4_button_color')); ?>" id="anps_style_4_button_color" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_4_button_hover_color"><?php esc_html_e("button hover color", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#BD1470', 'style_4_button_hover_color')); ?>" data-colorHover="style-4" readonly style="background: <?php echo esc_attr(anps_get_option('', '#BD1470', 'style_4_button_hover_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_4_button_hover_color" value="<?php echo esc_attr(anps_get_option('', '#BD1470', 'style_4_button_hover_color')); ?>" id="anps_style_4_button_hover_color" />
                </div>
                <div class="clear"></div>
                <hr>
            </div>
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php esc_html_e("Button slider", 'hairdresser');?></h4>
                    <a class="btn btn-sm slider btn--slider" data-button="slider" href="#">Button</a>
                </div>
                <div class="input onequarter">
                    <label for="anps_style_slider_button_bg"><?php esc_html_e("button background", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#940855', 'style_slider_button_bg')); ?>" data-bg="slider" readonly style="background: <?php echo esc_attr(anps_get_option('', '#940855', 'style_slider_button_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_slider_button_bg" value="<?php echo esc_attr(anps_get_option('', '#940855', 'style_slider_button_bg')); ?>" id="anps_style_slider_button_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_slider_button_color"><?php esc_html_e("button color", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_slider_button_color')); ?>" data-color="slider" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_slider_button_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_slider_button_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_slider_button_color')); ?>" id="anps_style_slider_button_color" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_slider_button_hover_bg"><?php esc_html_e("button hover background", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#BD1470', 'style_slider_button_hover_bg')); ?>" data-bgHover="slider" readonly style="background: <?php echo esc_attr(anps_get_option('', '#BD1470', 'style_slider_button_hover_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_slider_button_hover_bg" value="<?php echo esc_attr(anps_get_option('', '#BD1470', 'style_slider_button_hover_bg')); ?>" id="anps_style_slider_button_hover_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_slider_button_hover_color"><?php esc_html_e("button hover color", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_slider_button_hover_color')); ?>" data-colorHover="slider" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_slider_button_hover_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_slider_button_hover_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_slider_button_hover_color')); ?>" id="anps_style_slider_button_hover_color" />
                </div>
                <div class="clear"></div>
                <hr>
            </div>
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php esc_html_e("Button style-5", 'hairdresser');?></h4>
                    <a class="btn btn-sm style-5 btn--style-5" data-button="style-5" href="#">Button</a>
                </div>
                <div class="input onequarter">
                    <label for="anps_style_style_5_button_bg"><?php esc_html_e("button background", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#c3c3c3', 'style_style_5_button_bg')); ?>" data-bg="style-5" readonly style="background: <?php echo esc_attr(anps_get_option('', '#c3c3c3', 'style_style_5_button_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_style_5_button_bg" value="<?php echo esc_attr(anps_get_option('', '#c3c3c3', 'style_style_5_button_bg')); ?>" id="anps_style_style_5_button_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_style_5_button_color"><?php esc_html_e("button color", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_style_5_button_color')); ?>" data-color="style-5" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_style_5_button_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_style_5_button_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_style_5_button_color')); ?>" id="anps_style_style_5_button_color" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_style_5_button_hover_bg"><?php esc_html_e("button hover background", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#737373', 'style_style_5_button_hover_bg')); ?>" data-bgHover="style-5" readonly style="background: <?php echo esc_attr(anps_get_option('', '#737373', 'style_style_5_button_hover_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_style_5_button_hover_bg" value="<?php echo esc_attr(anps_get_option('', '#737373', 'style_style_5_button_hover_bg')); ?>" id="anps_style_style_5_button_hover_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_style_5_button_hover_color"><?php esc_html_e("button hover color", 'hairdresser'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_style_5_button_hover_color')); ?>" data-colorHover="style-5" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_style_5_button_hover_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_style_5_button_hover_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_style_5_button_hover_color')); ?>" id="anps_style_style_5_button_hover_color" />
                </div>
                <div class="clear"></div>
                <hr>
            </div>
        </div>
        <div class="clear"></div>
        <?php anps_admin_save_buttons(); ?>
    </form>
    <div class="clear"></div>
</div>
