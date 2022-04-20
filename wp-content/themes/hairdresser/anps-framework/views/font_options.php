<?php
include_once get_template_directory() . '/anps-framework/classes/Style.php';
wp_enqueue_script('font_subsets');
/* Save form */
if(isset($_GET['save_font'])) {
    $style->save();
}
/* get all fonts */
$fonts = $style->all_fonts();
?>
<div class="content">
    <form action="themes.php?page=theme_options&sub_page=font_options&save_font" method="post">
        <div class="content-top">
            <input type="submit" value="<?php esc_html_e("Save all changes", 'hairdresser'); ?>">
            <div class="clear"></div>
        </div>
        <div class="content-inner">
            <h3><?php esc_html_e("Font family", 'hairdresser'); ?></h3>
            <h4>Custom font styles</h4>
            <p>If subsets are not active please update google fonts <a href="themes.php?page=theme_options&sub_page=theme_style_google_font">here</a>.</p>
            <div class="input onethird">
                <label for="font_type_1">Font type 1</label>
                <select name="font_type_1" id="font_type_1">
                    <?php foreach($fonts as $name=>$value) : ?>
                    <optgroup label="<?php echo esc_attr($name); ?>">
                    <?php foreach ($value as $font) :
                            $selected = '';
                            if ($font['value'] == get_option('font_type_1', 'Montserrat')) {
                                $selected = 'selected';
                                $subsets = $name == 'Google fonts' ? $font['subsets'] : '';
                            }
                            ?>
                            <option value="<?php echo esc_attr($font['value'])."|".esc_attr($name); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_attr($font['name']); ?></option>
                    <?php endforeach; ?>
                    </optgroup>
                    <?php endforeach; ?>
                </select>
                <div id="font_subsets_1" class="font_subsets">
                    <?php if($subsets) :
                        $i=0;
                        foreach($subsets as $item) :
                            $checked = "";

                            if(is_array(get_option("font_type_1_subsets"))&&in_array($item, get_option("font_type_1_subsets"))) {
                                $checked = " checked";
                            }
                            ?>
                        <input type="checkbox" name="font_type_1_subsets[]" value="<?php echo esc_attr($item); ?>" <?php echo esc_attr($checked);?> /><?php echo esc_html($item); ?><br />
                        <?php $i++;
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
            <div class="input onethird">
                <label for="font_type_2"><?php esc_html_e("Font type 2", 'hairdresser'); ?></label>
                <select name="font_type_2" id="font_type_2">
                    <?php foreach($fonts as $name=>$value) : ?>
                    <optgroup label="<?php echo esc_attr($name); ?>">
                    <?php foreach ($value as $font) :
                            $selected = '';
                            if ($font['value'] == get_option('font_type_2', "PT+Sans")) {
                                $selected = 'selected';
                                $subsets2 = $name == 'Google fonts' ? $font['subsets'] : '';
                            }
                            ?>
                            <option value="<?php echo esc_attr($font['value'])."|".esc_attr($name); ?>" <?php echo esc_attr($selected); ?> <?php if(esc_attr($name=="Google fonts")) {echo "data-font='gfonts'";} ?>><?php echo esc_attr($font['name']); ?></option>
                    <?php endforeach; ?>
                    </optgroup>
                    <?php endforeach; ?>
                </select>
                <div id="font_subsets_2" class="font_subsets">
                    <?php if($subsets2) :
                        $i=0;
                        foreach($subsets2 as $item) :
                            $checked = "";
                            if(is_array(get_option("font_type_2_subsets"))&&in_array($item, get_option("font_type_2_subsets"))) {
                                $checked = " checked";
                            }
                            ?>
                        <input type="checkbox" name="font_type_2_subsets[]" value="<?php echo esc_attr($item); ?>" <?php echo esc_attr($checked);?> /><?php echo esc_html($item); ?><br />
                        <?php $i++;
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
            <div class="input onethird">
                <label for="font_type_navigation"><?php esc_html_e("Navigation font type", 'hairdresser'); ?></label>
                <select name="font_type_navigation" id="font_type_navigation">
                    <?php foreach($fonts as $name=>$value) : ?>
                    <optgroup label="<?php echo esc_attr($name); ?>">
                    <?php foreach ($value as $font) :
                            $selected = '';
                            if ($font['value'] == get_option('font_type_navigation', 'Montserrat')) {
                                $selected = 'selected';
                                $subsets3 = $name == 'Google fonts' ? $font['subsets'] : '';
                            }
                            ?>
                            <option value="<?php echo esc_attr($font['value'])."|".esc_attr($name); ?>" <?php echo esc_attr($selected); ?> <?php if(esc_attr($name=="Google fonts")) {echo "data-font='gfonts'";} ?>><?php echo esc_attr($font['name']); ?></option>
                    <?php endforeach; ?>
                    </optgroup>
                    <?php endforeach; ?>
                </select>
                <div id="font_subsets_navigation" class="font_subsets">
                    <?php if($subsets3) :
                        $i=0;
                        foreach($subsets3 as $item) :
                            $checked = "";
                            if(is_array(get_option("font_type_navigation_subsets"))&&in_array($item, get_option("font_type_navigation_subsets"))) {
                                $checked = " checked";
                            }
                            ?>
                        <input type="checkbox" name="font_type_navigation_subsets[]" value="<?php echo esc_attr($item); ?>" <?php echo esc_attr($checked);?> /><?php echo esc_html($item); ?><br />
                        <?php $i++;
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
            <div class="clear"></div>

            <h3><?php esc_html_e("Font sizes", 'hairdresser'); ?></h3>
            <div class="input onequarter">
                <label for="anps_body_font_size"><?php esc_html_e("Body Font Size", 'hairdresser'); ?></label>
                <input class="size" type="text" name="anps_body_font_size" value="<?php echo esc_attr(anps_get_option('', '14', 'body_font_size')); ?>" id="anps_body_font_size" placeholder="14"/><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="anps_menu_font_size"><?php esc_html_e("Menu Font Size", 'hairdresser'); ?></label>
                <input class="size" type="text" name="anps_menu_font_size" value="<?php echo esc_attr(anps_get_option('', '14', 'menu_font_size')); ?>" id="anps_menu_font_size" placeholder="14"/><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="anps_h1_font_size"><?php esc_html_e("Content Heading 1 Font Size", 'hairdresser'); ?></label>
                <input class="size" type="text" name="anps_h1_font_size" value="<?php echo esc_attr(anps_get_option('', '31', 'h1_font_size')); ?>" id="anps_h1_font_size" placeholder="31"/><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="anps_h2_font_size"><?php esc_html_e("Content Heading 2 Font Size", 'hairdresser'); ?></label>
                <input class="size" type="text" name="anps_h2_font_size" value="<?php echo esc_attr(anps_get_option('', '24', 'h2_font_size')); ?>" id="anps_h2_font_size" placeholder="24"/><span>px</span>
            </div>
            <div class="clear"></div>
            <div class="input onequarter">
                <label for="anps_h3_font_size"><?php esc_html_e("Content Heading 3 Font Size", 'hairdresser'); ?></label>
                <input class="size" type="text" name="anps_h3_font_size" value="<?php echo esc_attr(anps_get_option('', '21', 'h3_font_size')); ?>" id="anps_h3_font_size" placeholder="21" /><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="anps_h4_font_size"><?php esc_html_e("Content Heading 4 Font Size", 'hairdresser'); ?></label>
                <input class="size" type="text" name="anps_h4_font_size" value="<?php echo esc_attr(anps_get_option('', '18', 'h4_font_size')); ?>" id="anps_h4_font_size" placeholder="18"/><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="anps_h5_font_size"><?php esc_html_e("Content Heading 5 Font Size", 'hairdresser'); ?></label>
                <input class="size" type="text" name="anps_h5_font_size" value="<?php echo esc_attr(anps_get_option('', '16', 'h5_font_size')); ?>" id="anps_h5_font_size" placeholder="16"/><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="anps_page_heading_h1_font_size"><?php esc_html_e("Page Heading 1 Font Size", 'hairdresser'); ?></label>
                <input class="size" type="text" name="anps_page_heading_h1_font_size" value="<?php echo esc_attr(anps_get_option('', '24', 'page_heading_h1_font_size')); ?>" id="anps_page_heading_h1_font_size" placeholder="24"/><span>px</span>
            </div>
            <div class="clear"></div>
            <div class="input onequarter">
                <label for="anps_blog_heading_h1_font_size"><?php esc_html_e("Single blog title font size", 'hairdresser'); ?></label>
                <input class="size" type="text" name="anps_blog_heading_h1_font_size" value="<?php echo esc_attr(anps_get_option('', '28', 'blog_heading_h1_font_size')); ?>" id="anps_blog_heading_h1_font_size" placeholder="28"/><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="anps_top_bar_font_size"><?php esc_html_e('Top bar font size', 'hairdresser'); ?></label>
                <input class="size" type="text" name="anps_top_bar_font_size" value="<?php echo esc_attr(get_option('anps_top_bar_font_size', '14')); ?>" id="anps_top_bar_font_size" placeholder="14"/><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="anps_portfolio_title_font_size"><?php esc_html_e('Portfolio title font size', 'hairdresser'); ?></label>
                <input class="size" type="text" name="anps_portfolio_title_font_size" value="<?php echo esc_attr(get_option('anps_portfolio_title_font_size', '16')); ?>" id="anps_portfolio_title_font_size" placeholder="16"/><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="anps_footer_font_size"><?php esc_html_e('Footer font size', 'hairdresser'); ?></label>
                <input class="size" type="text" name="anps_footer_font_size" value="<?php echo esc_attr(get_option('anps_footer_font_size', '14')); ?>" id="anps_footer_font_size" placeholder="14"/><span>px</span>
            </div>
            <div class="clear"></div>
            <div class="input onequarter">
                <label for="anps_footer_title_font_size"><?php esc_html_e('Footer title font size', 'hairdresser'); ?></label>
                <input class="size" type="text" name="anps_footer_title_font_size" value="<?php echo esc_attr(get_option('anps_footer_title_font_size', '17')); ?>" id="anps_footer_title_font_size" placeholder="17"/><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="anps_copyright_font_size"><?php esc_html_e('Copyright footer font size', 'hairdresser'); ?></label>
                <input class="size" type="text" name="anps_copyright_font_size" value="<?php echo esc_attr(get_option('anps_copyright_font_size', '14')); ?>" id="anps_copyright_font_size" placeholder="14"/><span>px</span>
            </div>
        </div>
        <div class="clear"></div>
        <?php anps_admin_save_buttons(); ?>
    </form>
    <div class="clear"></div>
</div>