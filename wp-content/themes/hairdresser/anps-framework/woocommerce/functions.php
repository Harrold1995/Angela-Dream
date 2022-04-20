<?php
/* Number of upsells */

if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
        function woocommerce_output_upsells() {
            woocommerce_upsell_display( 5,5 );
        }
}

/* Producsts per page */

global $anps_shop_data;

if( isset($anps_shop_data['shop_per_page']) ) {
        add_filter( 'loop_shop_per_page', create_function( '$cols', 'return ' . $anps_shop_data['shop_per_page'] . ';' ), 20 );
}