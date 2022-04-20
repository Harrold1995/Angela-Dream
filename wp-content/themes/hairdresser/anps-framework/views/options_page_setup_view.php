<?php
include_once(get_template_directory() . '/anps-framework/classes/Options.php');
$anps_page_data = $options->get_page_setup_data();
if (isset($_GET['save_page_setup'])) {
    $options->save_page_setup('options_page_setup');
}
?>
<form action="themes.php?page=theme_options&sub_page=options_page_setup&save_page_setup" method="post">
    <div class="content-top">
        <input type="submit" value="<?php esc_html_e("Save all changes", 'hairdresser'); ?>" />
        <div class="clear"></div>
    </div>
    <div class="content-inner">
    <!-- Page setup -->
    <h3><?php esc_html_e("Page setup", 'hairdresser'); ?></h3>
    <!-- Coming soon page -->
    <div class="input onehalf">
        <label for="anps_coming_soon"><?php esc_html_e("Coming soon page", 'hairdresser'); ?></label>
        <select name="anps_coming_soon" id="anps_coming_soon">
            <option value="0">*** Select ***</option>
            <?php
                $pages = get_pages();
                foreach ($pages as $item) :
                    $selected = '';
                    if (anps_get_option($anps_page_data, 'coming_soon') == $item->ID) {
                            $selected = ' selected';
                    } ?>      
                    <option value="<?php echo esc_attr($item->ID); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_html($item->post_title); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <!-- Error page -->
    <div class="input onehalf">
        <label for="anps_error_page"><?php esc_html_e("404 error page", 'hairdresser'); ?></label>
        <select name="anps_error_page" id="anps_error_page">
            <option value="0">*** Select ***</option>
            <?php
            $pages = get_pages();
            foreach ($pages as $item) :
                $selected = '';
                if (anps_get_option($anps_page_data, 'error_page') == $item->ID) {
                        $selected = ' selected';
                } ?>      
            <option value="<?php echo esc_attr($item->ID); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_html($item->post_title); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <!-- Portfolio single style -->
    <div class='input fullwidth'>
        <label for='anps_excerpt_length'><?php esc_html_e("Excerpt length", 'hairdresser'); ?></label>
        <input type='text' value='<?php echo get_option('anps_excerpt_length', 40); ?>' name='anps_excerpt_length' id='anps_excerpt_length' />
    </div>
    <div class="clear"></div>
    <h3><?php esc_html_e("Portfolio", 'hairdresser'); ?></h3>
    <!-- Portfolio single style -->
    <div class='input fullwidth'>
        <label for='anps_portfolio_slug'><?php esc_html_e("Portfolio slug", 'hairdresser'); ?></label>
        <input type='text' value='<?php echo get_option('anps_portfolio_slug'); ?>' name='anps_portfolio_slug' id='anps_portfolio_slug' />
    </div>
    <div class="input onethird">
        <label for="anps_portfolio_single"><?php esc_html_e("Portfolio single style", 'hairdresser'); ?></label>
        <select name="anps_portfolio_single" id="anps_portfolio_single">
            <?php 
            $pages = array('style-1' => 'Style 1', 'style-2' => 'Style 2', 'style-3' => 'Style 3');
            foreach ($pages as $key => $item) :
                $selected = '';
                if (anps_get_option('', '', 'portfolio_single') == $key) {
                    $selected = ' selected';
                } ?>
            <option value="<?php echo esc_attr($key); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_attr($item); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <!-- Portfolio single footer -->
    <div class="input twothird">
    <label for="anps_portfolio_single_footer"><?php esc_html_e("Portfolio single footer", 'hairdresser'); ?></label>
    <?php 
    $value2 = anps_get_option('', '', 'portfolio_single_footer');
    wp_editor(str_replace('\\"', '"', $value2), 'anps_portfolio_single_footer', array(
        'wpautop' => true,
        'media_buttons' => false,
        'textarea_name' => 'anps_portfolio_single_footer',
        'textarea_rows' => 10,
        'teeny' => true )); ?>
    </div>
    <div class="clear"></div>
    <h3><?php esc_html_e('Social icons', 'hairdresser'); ?></h3>
    <?php
        $socials = get_option('anps_global_social_icons', '');
        $socials_array = explode('|', $socials);
    ?>

    <div class="anps-menu-social">
        <div data-anps-repeat>
            <!-- Social Icons field (hidden) -->
            <input data-anps-repeat-field type="hidden" name="anps_global_social_icons" value="<?php echo esc_attr($socials); ?>">

            <!-- Repeater items wrapper -->
            <div class="anps-repeat-items" data-anps-repeat-items>
                <?php foreach($socials_array as $social) : ?>
                <div class="anps-repeat-item" data-anps-repeat-item>
                    <!-- Fields -->
                    <?php
                        $social = explode(';', $social);
                        $social_icon = '';
                        $social_url = '';
                        $social_title = '';

                        if( isset($social[0]) ) {
                             $social_icon = $social[0];
                        }

                        if( isset($social[1]) ) {
                             $social_url = $social[1];
                        }

                        if( isset($social[2]) ) {
                             $social_title = $social[2];
                        }
                    ?>
                    <div class="anps-repeat-fgroup anps-repeat-fgroup-icon">
                        <label><?php _e('Icon', 'hairdresser'); ?></label>
                        <div class="anps-iconpicker">
                            <i class="fa <?php echo esc_attr($social_icon); ?>"></i>
                            <input type="text" value="<?php echo esc_attr($social_icon); ?>">
                            <button type="button"><?php esc_html_e('Select icon', 'hairdresser'); ?></button>
                        </div>
                    </div>
                    <div class="anps-repeat-fgroup">
                        <label><?php _e('URL', 'hairdresser'); ?></label>
                        <input type="text" class="widefat" value="<?php echo esc_attr($social_url); ?>" />
                    </div>
                    <div class="anps-repeat-fgroup">
                        <label><?php _e('Title', 'hairdresser'); ?></label>
                        <input type="text" class="widefat" value="<?php echo esc_attr($social_title); ?>" />
                    </div>

                    <!-- Repeater buttons -->
                    <div class="anps-repeat-buttons">
                        <button class="anps-repeat-remove" type="button" data-anps-repeat-remove>-</button>
                        <button class="anps-repeat-add" type="button" data-anps-repeat-add>+</button>
                    </div>
                </div>
                <?php endforeach; ?>
             </div>
        </div>
    </div>
    <div class="clear"></div>
    <!-- Post meta enable/disable -->
    <h3><?php esc_html_e("Disable Post meta elements", 'hairdresser'); ?></h3>
    <p><?php esc_html_e('This allows you to disable post meta on all blog elements and pages. By default no field is checked, so that all meta elements are displayed.', 'hairdresser'); ?></p>
    <?php
        $post_meta_arr = array(
            "anps_post_meta_comments"   => "Comments",
            "anps_post_meta_categories" => "Categories",
            "anps_post_meta_author"     => "Author",
            "anps_post_meta_date"       => "Date"
        );
    ?>
    <?php foreach($post_meta_arr as $key=>$item) : ?>
    <div class="input onequarter">
        <label for="<?php echo esc_attr($key); ?>"><?php echo esc_attr($item); ?></label>
        <input type='hidden' value='' name='<?php echo esc_attr($key); ?>'/>
        <input style="margin-left: 37px;" type="checkbox" value="1" name="<?php echo esc_attr($key); ?>" id="<?php echo esc_attr($key); ?>" <?php checked(get_option($key), "1") ?>/>
    </div>
    <?php endforeach; ?>
    <div class="clear"></div>
    </div>
    <div class="content-top" style="border-style: solid none; margin-top: 70px">
        <input type="submit" value="<?php esc_html_e("Save all changes", 'hairdresser'); ?>">
        <div class="clear"></div>
    </div>
</form>
