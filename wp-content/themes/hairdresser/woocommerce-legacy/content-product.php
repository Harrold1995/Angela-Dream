<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Extra post classes
$classes = array();

switch( get_option('anps_products_columns', '4') ) {
    case '3': $classes[] = 'col-sm-4'; break;
    case '4': $classes[] = 'col-sm-3'; break;
}
?>
<li <?php post_class( $classes ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

		<div class="product-header">
			<?php
				/**
				 * woocommerce_before_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_show_product_loop_sale_flash - 10
				 * @hooked woocommerce_template_loop_product_thumbnail - 10
				 */
				do_action( 'woocommerce_before_shop_loop_item_title' );
            
				echo '<div class="add-to-cart-wrapper">';
				echo apply_filters( 'woocommerce_loop_add_to_cart_link',
					sprintf( '<a href="%s" rel="nofollow" data-quantity="1" data-product_id="%s" data-product_sku="%s" class="btn btn-md %s %s product_type_%s">%s</a>',
						esc_url( $product->add_to_cart_url() ),
						esc_attr( $product->id ),
						esc_attr( $product->get_sku() ),
						('yes' === get_option( 'woocommerce_enable_ajax_add_to_cart' ) && $product->product_type === 'simple' ) ? 'ajax_add_to_cart' : '',
						$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
						esc_attr( $product->product_type ),
						esc_html( $product->add_to_cart_text() )
					),
				$product );
				echo '</div>';
			?>
		</div>

		<a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>

		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>

	

	<?php
 
        /**
         * woocommerce_after_shop_loop_item hook
         *
         * @hooked woocommerce_template_loop_add_to_cart - 10
         */
        do_action( 'woocommerce_after_shop_loop_item' );
 
        ?>

</li>