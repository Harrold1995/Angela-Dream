<?php
include_once get_template_directory() . '/anps-framework/classes/Options.php';
if (isset($_GET['save_woocommerce'])) {
    $options->save_page_setup('woocommerce');
}
?>
<form action="themes.php?page=theme_options&sub_page=woocommerce&save_woocommerce" method="post">
    <div class="content-top">
        <input type="submit" value="<?php esc_html_e("Save all changes", 'hairdresser'); ?>" />
        <div class="clear"></div>
    </div>
    <div class="content-inner">
        <h3><?php esc_html_e("WooCommerce", 'hairdresser'); ?></h3>
        <div class="input onethird">
            <label for="anps_shopping_cart_header"><?php esc_html_e("Display shopping cart icon in header?", 'hairdresser'); ?></label>
            <select name="anps_shopping_cart_header" id="anps_shopping_cart_header">
                    <?php $pages = array("hide"=>esc_html__('Never display', 'hairdresser'), "shop_only"=>esc_html__('only on Woo pages', 'hairdresser'), "always"=>esc_html__('Display everywhere', 'hairdresser'));
                    foreach ($pages as $key => $item) :
                        $selected = '';
                        if (anps_get_option('', 'shop_only', 'shopping_cart_header') == $key) {
                            $selected = ' selected';
                        }
                        ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_attr($item); ?></option>
                    <?php endforeach; ?>
            </select>
        </div>
        <!-- WooCommerce columns -->
        <div class="input onethird">
            <label for="anps_products_columns"><?php esc_html_e('How many products in row?', 'hairdresser'); ?></label>
            <select name="anps_products_columns">
                    <?php $pages = array('4'=>esc_html__('4 products', 'hairdresser'), '3'=>esc_html__('3 products', 'hairdresser'));
                    foreach ($pages as $key => $item) :
                        $selected = '';
                        if (get_option('anps_products_columns', '4') == $key) {
                            $selected = ' selected';
                        }
                        ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_attr($item); ?></option>
                    <?php endforeach; ?>
            </select>
        </div>
        <!-- Woocommerce category filter on/off -->
        <div class="input onethird">
            <label for="anps_woo_category_filter"><?php esc_html_e('Enable category filter', 'hairdresser'); ?></label>
            <input type='hidden' value='' name='anps_woo_category_filter'/>
            <input id="anps_woo_category_filter" class="small_input" value="1" style="margin-left: 25px" type="checkbox" name="anps_woo_category_filter" <?php if(get_option('anps_woo_category_filter', '')=="1") {echo esc_attr('checked');} else {echo '';} ?> />
        </div>
        <div class="clear"></div>
        <!-- WooCommerce products per page -->
        <div class='input onethird'>
            <label for='anps_products_per_page'><?php esc_html_e("Products per page", 'hairdresser'); ?></label>
            <input type='text' value='<?php echo get_option('anps_products_per_page', '12'); ?>' name='anps_products_per_page' id='anps_products_per_page' />
        </div>      
        <!-- WooCommerce Product Zoom -->
        <div class="input onethird">
            <label for="anps_product_zoom"><?php esc_html_e('Product image zoom', 'hairdresser'); ?></label>
            <input type='hidden' value='' name='anps_product_zoom'/>
            <input id="anps_product_zoom" class="small_input" value="1" style="margin-left: 25px" type="checkbox" name="anps_product_zoom" <?php if(get_option('anps_product_zoom', '1')=="1") {echo esc_attr('checked');} else {echo '';} ?> />
        </div>
        <!-- WooCommerce Product image lightbox -->
        <div class="input onethird">
            <label for="anps_product_lightbox"><?php esc_html_e('Product image lightbox', 'hairdresser'); ?></label>
            <input type='hidden' value='' name='anps_product_lightbox'/>
            <input id="anps_product_lightbox" class="small_input" value="1" style="margin-left: 25px" type="checkbox" name="anps_product_lightbox" <?php if(get_option('anps_product_lightbox', '1')=="1") {echo esc_attr('checked');} else {echo '';} ?> />
        </div>
        <div class="clear"></div>
        <!-- WooCommerce columns -->
        <div class="input onethird">
            <label for="anps_style_woo"><?php esc_html_e('Style', 'hairdresser'); ?></label>
            <select name="anps_style_woo" ide="anps_style_woo">
                    <?php $styles = array('classic' => esc_html__('Classic', 'hairdresser'), 'modern' => esc_html__('Modern', 'hairdresser'));
                    foreach ($styles as $key => $item) :
                        $selected = '';
                        if (get_option('anps_style_woo', 'classic') == $key) {
                            $selected = ' selected';
                        }
                        ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_attr($item); ?></option>
                    <?php endforeach; ?>
            </select>
        </div>
        <div class="clear"></div>
    </div>
    <?php anps_admin_save_buttons(); ?>
</form>
