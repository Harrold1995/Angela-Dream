<?php
include_once get_template_directory() . '/anps-framework/classes/Options.php';
include_once get_template_directory() . '/anps-framework/classes/Style.php';
wp_enqueue_script('font_subsets');
$anps_media_data = $options->get_media();
if (isset($_GET['save_media'])) {
    if(!isset($_POST['auto_adjust_logo'])) {
        $_POST['auto_adjust_logo'] = '';
    }
    $options->save_media();
}
/* get all fonts */
$fonts = $style->all_fonts();
?>
<form action="themes.php?page=theme_options&sub_page=options_media&save_media" method="post">
    <div class="content-top"><input type="submit" value="<?php esc_html_e("Save all changes", 'hairdresser'); ?>" /><div class="clear"></div></div>
    <div class="content-inner">
        <h3><?php esc_html_e("Heading background:", 'hairdresser'); ?></h3>
        <!-- Heading background -->
        <div class="input floatleft onehalf anps_upload">
            <label for="anps_heading_bg"><?php esc_html_e("Page heading background", 'hairdresser'); ?></label>
            <input id="anps_heading_bg" type="text" size="36" name="anps_heading_bg" value="<?php echo anps_get_option($anps_media_data, 'heading_bg'); ?>" />
            <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            <p class="fullwidth"><?php esc_html_e("Enter an URL or upload an image for the page heading background.", 'hairdresser'); ?></p>
            <div class="clear"></div>
        </div>
        <!-- Search heading background -->
        <div class="input onehalf anps_upload">
            <label for="anps_search_heading_bg"><?php esc_html_e("Search page heading background", 'hairdresser'); ?></label>
            <input id="anps_search_heading_bg" type="text" size="36" name="anps_search_heading_bg" value="<?php echo anps_get_option($anps_media_data, 'search_heading_bg'); ?>" />
            <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            <p class="fullwidth"><?php esc_html_e("Enter an URL or upload an image for the search page heading background.", 'hairdresser'); ?></p>
            <div class="clear"></div>
        </div>
        <hr>
        <h3><?php esc_html_e("Favicon and logo:", 'hairdresser'); ?></h3>
        <p><?php esc_html_e("If you would like to use your logo and favicon, upload them to your theme here.", 'hairdresser'); ?></p>

        <!-- Logo -->
        <div class="input onehalf floatleft anps_upload">
            <label for="anps_logo"><?php esc_html_e("Logo", 'hairdresser'); ?></label>
            <?php
                $logo_width = 157;
                $logo_height = 18;

                $anps_logo_width = anps_get_option($anps_media_data, 'logo-width');
                $anps_logo_height = anps_get_option($anps_media_data, 'logo-height');
                if(isset($anps_logo_width) && $anps_logo_width!='') {
                    $logo_width = anps_get_option($anps_media_data, 'logo-width');
                }
                if(isset($anps_logo_height) && $anps_logo_height!='') {
                    $logo_height = anps_get_option($anps_media_data, 'logo-height');
                }

                $hasMedia = anps_get_option($anps_media_data, 'logo')!='';
            ?>
            <div class="preview <?php if(!$hasMedia) { echo 'hidden'; } ?>" data-preview="anps_logo">
                <?php if($hasMedia): ?>
                    <img width="<?php echo esc_attr($logo_width); ?>" height="<?php echo esc_attr($logo_height); ?>" src="<?php echo anps_get_option($anps_media_data, 'logo'); ?>">
                <?php endif; ?>
            </div>
            <input id="anps_logo" class="has-preview" type="text" size="36" name="anps_logo" value="<?php echo anps_get_option($anps_media_data, 'logo'); ?>" />
            <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            <p class="fullwidth"><?php esc_html_e("Enter an URL or upload an image for the logo.", 'hairdresser'); ?></p>

            <div class="input fullwidth" style="min-height:0;">
                <?php
                if(get_option('auto_adjust_logo', 'on') == "on") {
                    $checked='checked';
                } else {
                    $checked = '';
                }
                ?>
                <label class="onehalf floatleft" for="auto_adjust_logo"><?php esc_html_e("Auto adjust logo size?", 'hairdresser'); ?></label>
                <div class="onehalf floatleft last" style="text-align:left; margin-top: 3px;">
                    <input id="auto_adjust_logo" class="small_input" style="margin-left: 0px; margin-top: 10px;" type="checkbox" name="auto_adjust_logo" <?php echo $checked; ?> />
                </div>
            </div>

            <div class="input onehalf floatleft first addspace onoff">
                <label for="logo-width"><?php esc_html_e("Logo width", 'hairdresser'); ?></label>
                <input style="width: 100px;" id="logo-width" type="text" name="anps_logo-width" value="<?php echo esc_attr($logo_width); ?>" /> px
            </div>

            <div class="input onehalf floatleft last addspace onoff">
                <label for="logo-height"><?php esc_html_e("Logo height", 'hairdresser'); ?></label>
                <input style="width: 100px;" id="logo-height" type="text" name="anps_logo-height" value="<?php echo esc_attr($logo_height); ?>" /> px
            </div>
        </div>
        <!-- Sticky logo -->
        <div class="input onehalf stickylogo anps_upload">
            <label for="anps_sticky_logo"><?php esc_html_e("Sticky logo", 'hairdresser'); ?></label>

            <?php
                $hasMedia = anps_get_option($anps_media_data, 'sticky_logo') != '';
            ?>

            <div class="preview onehalf<?php if(!$hasMedia) { echo ' hidden'; } ?>" data-preview="anps_sticky_logo">
                <?php if($hasMedia): ?>
                    <img width="<?php echo esc_attr($logo_width); ?>" height="<?php echo esc_attr($logo_height); ?>" src="<?php echo anps_get_option($anps_media_data, 'sticky_logo'); ?>">
                <?php endif; ?>
            </div>

            <input class="wninety has-preview" id="anps_sticky_logo" type="text" size="36" name="anps_sticky_logo" value="<?php echo anps_get_option($anps_media_data, 'sticky_logo'); ?>" />
            <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            <p clasS="fullwidth"><?php esc_html_e("Enter an URL or upload an image for the logo.", 'hairdresser'); ?></p>
        </div>
        <div class="clear"></div>
        <hr>
        <!-- Favicon -->
        <div class="input onehalf anps_upload">
            <label for="anps_favicon"><?php esc_html_e("Favicon", 'hairdresser'); ?></label>

            <?php $hasMedia = anps_get_option($anps_media_data, 'favicon') != ''; ?>

            <div class="preview<?php if(!$hasMedia) { echo ' hidden'; } ?>" data-preview="anps_favicon">
                <?php if($hasMedia): ?>
                    <img src="<?php echo anps_get_option($anps_media_data, 'favicon'); ?>">
                <?php endif; ?>
            </div>

            <input id="anps_favicon" class="has-preview" type="text" size="36" name="anps_favicon" value="<?php echo anps_get_option($anps_media_data, 'favicon'); ?>" />
            <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            <p class="fullwidth"><?php esc_html_e("Enter an URL or upload an image for the favicon.", 'hairdresser'); ?></p>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <h3><?php esc_html_e("Text based logo", 'hairdresser'); ?></h3>
        <div class="input twothirds">
        <label for="anps_text_logo"><?php esc_html_e('Text based logo', 'hairdresser'); ?></label>
        <?php $value2 = get_option('anps_text_logo', '');
                wp_editor(str_replace('\\"', '"', $value2), 'anps_text_logo', array(
                            'wpautop' => true,
                            'media_buttons' => false,
                            'quicktags' => false,
                            'textarea_name' => 'anps_text_logo',
                            'tinymce' => array(
                                'toolbar1' => 'bold, italic, underline, forecolor, fontsizeselect',
                                'toolbar2' => ''
                            )
                            )); ?>
        </div>
        <div class="input onethird">
            <label for="anps_text_logo_font"><?php esc_html_e('Logo font', 'hairdresser'); ?></label>
            <select name="anps_text_logo_font" id="anps_text_logo_font">
                <?php foreach($fonts as $name=>$value) : ?>
                <optgroup label="<?php echo esc_attr($name); ?>">
                <?php foreach ($value as $font) :
                        $selected = '';
                        if ($font['value'] == get_option('anps_text_logo_font')) {
                            $selected = 'selected="selected"';
                            if($name=="Google fonts") {
                                $subsets = $font['subsets'];
                            } else {
                                $subsets = "";
                            }
                        }
                        ?>
                        <option value="<?php echo esc_attr($font['value'])."|".esc_attr($name); ?>" <?php echo $selected; ?>><?php echo esc_attr($font['name']); ?></option>
                <?php endforeach; ?>
                </optgroup>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="clear"></div>
    </div>
    <?php anps_admin_save_buttons(); ?>
</form>
<?php wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_register_script('my-upload', get_template_directory_uri() . 'anps-framework/upload_image.js', array('jquery', 'media-upload', 'thickbox'));
    wp_enqueue_script('my-upload');
    wp_enqueue_style('thickbox');
