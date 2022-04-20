<?php
include_once get_template_directory() . '/anps-framework/classes/Options.php';
$anps_options_data = $options->get_page_data();
if (isset($_GET['save_modern'])) {
    $options->save_page_setup('modern_color_options');
}
?>
<div class="content">
    <form action="themes.php?page=theme_options&sub_page=modern_color_options&save_modern" method="post">
        <div class="content-top">
            <input type="submit" value="<?php esc_html_e("Save all changes", 'hairdresser'); ?>">
            <div class="clear"></div>
        </div>
        <div class="content-inner">
        <h3><?php esc_html_e("Modern colors", 'hairdresser'); ?></h3>
        <div class="input onequarter">
            <label for="anps_modern_accent_color"><?php esc_html_e("Accent color", 'hairdresser'); ?></label>
            <input data-value="<?php echo get_option('anps_modern_accent_color', '#e53935'); ?>"
                   data-bg="anps-modern-accent-color"
                   readonly
                   style="background: <?php echo get_option('anps_modern_accent_color', '#e53935'); ?>"
                   class="color-pick-color" />
            <input class="color-pick"
                   type="text"
                   name="anps_modern_accent_color"
                   value="<?php echo get_option('anps_modern_accent_color', '#e53935'); ?>"
                   id="anps_modern_accent_color" />
        </div>

        <div class="clear"></div>
        <h3><?php esc_html_e("Modern button styles", 'hairdresser'); ?></h3>
        <div class="input fullwidth">
            <h4>Modern button 1</h4>
            <a class="btn btn-sm modern-1 btn--modern-button-1" data-button="modern-button-1" href="#">Button</a>
        </div>
        <div class="input onequarter">
            <label for="anps_modern_button_1_bg_color"><?php esc_html_e("Button 1 background color", 'hairdresser'); ?></label>
            <input data-value="<?php echo esc_attr(get_option('anps_modern_button_1_bg_color', '#940855')); ?>" data-bg="modern-button-1" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_1_bg_color', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_1_bg_color" value="<?php echo esc_attr(get_option('anps_modern_button_1_bg_color', '#940855')); ?>" id="anps_modern_button_1_bg_color" />
        </div>
        <div class="input onequarter">
            <label for="anps_modern_button_1_color"><?php esc_html_e("Button 1 text color", 'hairdresser'); ?></label>
            <input data-value="<?php echo esc_attr(get_option('anps_modern_button_1_color', '#940855')); ?>" data-color="modern-button-1" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_1_color', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_1_color" value="<?php echo esc_attr(get_option('anps_modern_button_1_color', '#940855')); ?>" id="anps_modern_button_1_color" />
        </div>
        <div class="input onequarter">
            <label for="anps_modern_button_1_hover_bg"><?php esc_html_e("Button 1 hover background color", 'hairdresser'); ?></label>
            <input data-value="<?php echo esc_attr(get_option('anps_modern_button_1_hover_bg', '#940855')); ?>" data-bgHover="modern-button-1" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_1_hover_bg', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_1_hover_bg" value="<?php echo esc_attr(get_option('anps_modern_button_1_hover_bg', '#940855')); ?>" id="anps_modern_button_1_hover_bg" />
        </div>
        <div class="input onequarter">
            <label for="anps_modern_button_1_hover"><?php esc_html_e("Button 1 hover text color", 'hairdresser'); ?></label>
            <input data-value="<?php echo esc_attr(get_option('anps_modern_button_1_hover', '#940855')); ?>" data-colorHover="modern-button-1" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_1_hover', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_1_hover" value="<?php echo esc_attr(get_option('anps_modern_button_1_hover', '#940855')); ?>" id="anps_modern_button_1_hover" />
        </div>
        <div class="input onequarter">
            <label for="anps_modern_button_1_border"><?php esc_html_e("Button 1 border color", 'hairdresser'); ?></label>
            <input data-value="<?php echo esc_attr(get_option('anps_modern_button_1_border', '#940855')); ?>" data-border="modern-button-1" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_1_border', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_1_border" value="<?php echo esc_attr(get_option('anps_modern_button_1_border', '#940855')); ?>" id="anps_modern_button_1_border" />
        </div>
        <div class="input onequarter">
            <label for="anps_modern_button_1_hover_border"><?php esc_html_e("Button 1 hover border color", 'hairdresser'); ?></label>
            <input data-value="<?php echo esc_attr(get_option('anps_modern_button_1_hover_border', '#940855')); ?>" data-borderHover="modern-button-1" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_1_hover_border', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_1_hover_border" value="<?php echo esc_attr(get_option('anps_modern_button_1_hover_border', '#940855')); ?>" id="anps_modern_button_1_hover_border" />
        </div>
        <div class="input onequarter">
            <label for="anps_modern_button_1_border_radius"><?php esc_html_e("Button 1 border radius", 'hairdresser'); ?></label>
            <input type="text" name="anps_modern_button_1_border_radius" data-borderRadius="modern-button-1" value="<?php echo esc_attr(get_option('anps_modern_button_1_border_radius', '')); ?>" id="anps_modern_button_1_border_radius" />
        </div>
        <div class="clear"></div>
        <div class="input fullwidth">
            <div class="fullwidth">
                <h4>Modern button 2</h4>
                <a class="btn btn-sm modern-2 btn--modern-button-2" data-button="modern-button-2" href="#">Button</a>
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_2_bg_color"><?php esc_html_e("Button 2 background color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_2_bg_color', '#940855')); ?>" data-bg="modern-button-2" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_2_bg_color', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_2_bg_color" value="<?php echo esc_attr(get_option('anps_modern_button_2_bg_color', '#940855')); ?>" id="anps_modern_button_2_bg_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_2_color"><?php esc_html_e("Button 2 text color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_2_color', '#940855')); ?>" data-color="modern-button-2" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_2_color', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_2_color" value="<?php echo esc_attr(get_option('anps_modern_button_2_color', '#940855')); ?>" id="anps_modern_button_2_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_2_hover_bg"><?php esc_html_e("Button 2 hover background color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_2_hover_bg', '#940855')); ?>" data-bgHover="modern-button-2" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_2_hover_bg', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_2_hover_bg" value="<?php echo esc_attr(get_option('anps_modern_button_2_hover_bg', '#940855')); ?>" id="anps_modern_button_2_hover_bg" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_2_hover"><?php esc_html_e("Button 2 hover text color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_2_hover', '#940855')); ?>" data-colorHover="modern-button-2" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_2_hover', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_2_hover" value="<?php echo esc_attr(get_option('anps_modern_button_2_hover', '#940855')); ?>" id="anps_modern_button_2_hover" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_2_border"><?php esc_html_e("Button 2 border color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_2_border', '#940855')); ?>" data-border="modern-button-2" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_2_border', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_2_border" value="<?php echo esc_attr(get_option('anps_modern_button_2_border', '#940855')); ?>" id="anps_modern_button_2_border" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_2_hover_border"><?php esc_html_e("Button 2 hover border color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_2_hover_border', '#940855')); ?>" data-borderHover="modern-button-2" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_2_hover_border', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_2_hover_border" value="<?php echo esc_attr(get_option('anps_modern_button_2_hover_border', '#940855')); ?>" id="anps_modern_button_2_hover_border" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_2_border_radius"><?php esc_html_e("Button 2 border radius", 'hairdresser'); ?></label>
                <input type="text" name="anps_modern_button_2_border_radius" data-borderRadius="modern-button-2" value="<?php echo esc_attr(get_option('anps_modern_button_2_border_radius', '')); ?>" id="anps_modern_button_2_border_radius" />
            </div>
        </div>
        <div class="clear"></div>
        <div class="input fullwidth">
            <div class="fullwidth">
                <h4>Modern button 3</h4>
                <a class="btn btn-sm modern-3 btn--modern-button-3" data-button="modern-button-3" href="#">Button</a>
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_3_bg_color"><?php esc_html_e("Button 3 background color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_3_bg_color', '#940855')); ?>" data-bg="modern-button-3" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_3_bg_color', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_3_bg_color" value="<?php echo esc_attr(get_option('anps_modern_button_3_bg_color', '#940855')); ?>" id="anps_modern_button_3_bg_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_3_color"><?php esc_html_e("Button 3 text color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_3_color', '#940855')); ?>" data-color="modern-button-3" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_3_color', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_3_color" value="<?php echo esc_attr(get_option('anps_modern_button_3_color', '#940855')); ?>" id="anps_modern_button_3_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_3_hover_bg"><?php esc_html_e("Button 3 hover background color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_3_hover_bg', '#940855')); ?>" data-bgHover="modern-button-3" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_3_hover_bg', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_3_hover_bg" value="<?php echo esc_attr(get_option('anps_modern_button_3_hover_bg', '#940855')); ?>" id="anps_modern_button_3_hover_bg" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_3_hover"><?php esc_html_e("Button 3 hover text color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_3_hover', '#940855')); ?>" data-colorHover="modern-button-3" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_3_hover', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_3_hover" value="<?php echo esc_attr(get_option('anps_modern_button_3_hover', '#940855')); ?>" id="anps_modern_button_3_hover" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_3_border"><?php esc_html_e("Button 3 border color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_3_border', '#940855')); ?>" data-border="modern-button-3" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_3_border', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_3_border" value="<?php echo esc_attr(get_option('anps_modern_button_3_border', '#940855')); ?>" id="anps_modern_button_3_border" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_3_hover_border"><?php esc_html_e("Button 3 hover border color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_3_hover_border', '#940855')); ?>" data-borderHover="modern-button-3" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_3_hover_border', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_3_hover_border" value="<?php echo esc_attr(get_option('anps_modern_button_3_hover_border', '#940855')); ?>" id="anps_modern_button_3_hover_border" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_3_border_radius"><?php esc_html_e("Button 3 border radius", 'hairdresser'); ?></label>
                <input type="text" name="anps_modern_button_3_border_radius" data-borderRadius="modern-button-3" value="<?php echo esc_attr(get_option('anps_modern_button_3_border_radius', '')); ?>" id="anps_modern_button_3_border_radius" />
            </div>
        </div>
        <div class="clear"></div>
        <div class="input fullwidth">
            <div class="fullwidth">
                <h4>Modern button 4</h4>
                <a class="btn btn-sm modern-4 btn--modern-button-4" data-button="modern-button-4" href="#">Button</a>
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_4_bg_color"><?php esc_html_e("Button 4 background color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_4_bg_color', '#940855')); ?>" data-bg="modern-button-4" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_4_bg_color', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_4_bg_color" value="<?php echo esc_attr(get_option('anps_modern_button_4_bg_color', '#940855')); ?>" id="anps_modern_button_4_bg_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_4_color"><?php esc_html_e("Button 4 text color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_4_color', '#940855')); ?>" data-color="modern-button-4" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_4_color', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_4_color" value="<?php echo esc_attr(get_option('anps_modern_button_4_color', '#940855')); ?>" id="anps_modern_button_4_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_4_hover_bg"><?php esc_html_e("Button 4 hover background color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_4_hover_bg', '#940855')); ?>" data-bgHover="modern-button-4" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_4_hover_bg', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_4_hover_bg" value="<?php echo esc_attr(get_option('anps_modern_button_4_hover_bg', '#940855')); ?>" id="anps_modern_button_4_hover_bg" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_4_hover"><?php esc_html_e("Button 4 hover text color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_4_hover', '#940855')); ?>" data-colorHover="modern-button-4" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_4_hover', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_4_hover" value="<?php echo esc_attr(get_option('anps_modern_button_4_hover', '#940855')); ?>" id="anps_modern_button_4_hover" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_4_border"><?php esc_html_e("Button 4 border color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_4_border', '#940855')); ?>" data-border="modern-button-4" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_4_border', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_4_border" value="<?php echo esc_attr(get_option('anps_modern_button_4_border', '#940855')); ?>" id="anps_modern_button_4_border" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_4_hover_border"><?php esc_html_e("Button 4 hover border color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_4_hover_border', '#940855')); ?>" data-borderHover="modern-button-4" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_4_hover_border', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_4_hover_border" value="<?php echo esc_attr(get_option('anps_modern_button_4_hover_border', '#940855')); ?>" id="anps_modern_button_4_hover_border" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_4_border_radius"><?php esc_html_e("Button 4 border radius", 'hairdresser'); ?></label>
                <input type="text" name="anps_modern_button_4_border_radius" data-borderRadius="modern-button-4" value="<?php echo esc_attr(get_option('anps_modern_button_4_border_radius', '')); ?>" id="anps_modern_button_4_border_radius" />
            </div>
        </div>
        <div class="clear"></div>
        <div class="input fullwidth">
            <div class="fullwidth">
                <h4>Modern button 5</h4>
                <a class="btn btn-sm modern-5 btn--modern-button-5" data-button="modern-button-5" href="#">Button</a>
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_5_bg_color"><?php esc_html_e("Button 5 background color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_5_bg_color', '#940855')); ?>" data-bg="modern-button-5" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_5_bg_color', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_5_bg_color" value="<?php echo esc_attr(get_option('anps_modern_button_5_bg_color', '#940855')); ?>" id="anps_modern_button_5_bg_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_5_color"><?php esc_html_e("Button 5 text color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_5_color', '#940855')); ?>" data-color="modern-button-5" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_5_color', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_5_color" value="<?php echo esc_attr(get_option('anps_modern_button_5_color', '#940855')); ?>" id="anps_modern_button_5_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_5_hover_bg"><?php esc_html_e("Button 5 hover background color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_5_hover_bg', '#940855')); ?>" data-bghover="modern-button-5" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_5_hover_bg', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_5_hover_bg" value="<?php echo esc_attr(get_option('anps_modern_button_5_hover_bg', '#940855')); ?>" id="anps_modern_button_5_hover_bg" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_5_hover"><?php esc_html_e("Button 5 hover text color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_5_hover', '#940855')); ?>" data-colorHover="modern-button-5" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_5_hover', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_5_hover" value="<?php echo esc_attr(get_option('anps_modern_button_5_hover', '#940855')); ?>" id="anps_modern_button_5_hover" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_5_border"><?php esc_html_e("Button 5 border color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_5_border', '#940855')); ?>" data-border="modern-button-5" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_5_border', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_5_border" value="<?php echo esc_attr(get_option('anps_modern_button_5_border', '#940855')); ?>" id="anps_modern_button_5_border" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_5_hover_border"><?php esc_html_e("Button 5 hover border color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_5_hover_border', '#940855')); ?>" data-borderHover="modern-button-5" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_5_hover_border', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_5_hover_border" value="<?php echo esc_attr(get_option('anps_modern_button_5_hover_border', '#940855')); ?>" id="anps_modern_button_5_hover_border" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_5_border_radius"><?php esc_html_e("Button 5 border radius", 'hairdresser'); ?></label>
                <input type="text" name="anps_modern_button_5_border_radius" data-borderRadius="modern-button-5" value="<?php echo esc_attr(get_option('anps_modern_button_5_border_radius', '')); ?>" id="anps_modern_button_5_border_radius" />
            </div>
            <div class="clear"></div>
        </div>
        <div class="input fullwidth">
            <div class="fullwidth">
                <h4>Modern button 6</h4>
                <a class="btn btn-sm modern-6 btn--modern-button-6" data-button="modern-button-6" href="#">Button</a>
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_6_color"><?php esc_html_e("Button 6 text color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_6_color', '#940855')); ?>" data-color="modern-button-6" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_6_color', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_6_color" value="<?php echo esc_attr(get_option('anps_modern_button_6_color', '#940855')); ?>" id="anps_modern_button_6_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_modern_button_6_hover"><?php esc_html_e("Button 6 hover text color", 'hairdresser'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_modern_button_6_hover', '#940855')); ?>" data-colorHover="modern-button-6" readonly style="background: <?php echo esc_attr(get_option('anps_modern_button_6_hover', '#940855')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_modern_button_6_hover" value="<?php echo esc_attr(get_option('anps_modern_button_6_hover', '#940855')); ?>" id="anps_modern_button_6_hover" />
            </div>
        </div>
        <div class="clear"></div>
        <?php anps_admin_save_buttons(); ?>
    </form>
    <div class="clear"></div>
</div>
