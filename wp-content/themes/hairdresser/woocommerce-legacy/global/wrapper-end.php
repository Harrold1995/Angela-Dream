<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-end.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/* Get sidebars */
$id = get_the_ID();

if (is_archive()) {
    $id = get_option('woocommerce_shop_page_id');
}

$meta = get_post_meta($id);
$left_sidebar = false;
$right_sidebar = false;
$num_of_sidebars = 0;

if (isset($meta['sbg_selected_sidebar']) && isset($meta['sbg_selected_sidebar'][0]) && $meta['sbg_selected_sidebar'][0] != '0' && $meta['sbg_selected_sidebar'][0] != '-1' ) {
    $left_sidebar = $meta['sbg_selected_sidebar'][0];
    $num_of_sidebars++;
}

if (isset($meta['sbg_selected_sidebar_replacement']) && isset($meta['sbg_selected_sidebar_replacement'][0]) && $meta['sbg_selected_sidebar_replacement'][0] != '0' && $meta['sbg_selected_sidebar_replacement'][0] != '-1' ) {
    $right_sidebar = $meta['sbg_selected_sidebar_replacement'][0];
    $num_of_sidebars++;
}

?>

</section>

<?php if( $right_sidebar ): ?>
    <aside class="sidebar sidebar--<?php echo get_option('anps_sidebar_style', 'classic'); ?> col-md-3">
        <ul>
            <?php dynamic_sidebar($right_sidebar); wp_reset_query(); ?>
        </ul>
    </aside>
<?php endif; ?>
</div></div>
