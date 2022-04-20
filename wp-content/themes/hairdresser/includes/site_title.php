<?php
	global $anps_page_data;

    $id = get_queried_object_id();
    if (function_exists('is_woocommerce') && is_woocommerce()) {
        $id = get_option('woocommerce_shop_page_id');
    }

    if (is_home() && !is_front_page()) {
        $title = get_the_title(get_option('page_for_posts'));
    } else if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_shop() ) {
        $title = get_the_title(get_option('woocommerce_shop_page_id'));
    } else if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_product_category() ) {
        $title = single_cat_title("", false);
    } else if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_product_tag() ) {
        $title = single_cat_title("", false);
    } else if( is_archive() ) {
        if( is_category() ) {
            $cat = get_category($id);
            $title = esc_html__("Archives for", 'hairdresser') . ' ' . $cat->name;
        }
        else if(is_author()) {
            $author = get_the_author_meta('display_name', get_query_var("author"));
            $title = esc_html__("Posts by", 'hairdresser') . ' ' . $author;
        } elseif(is_tag()) {
            $cat = get_tag($id);
            $title = $cat->name;
        }
        else {
            if( get_post_type() == 'post' ) {
                $title = esc_html__("Archives for", 'hairdresser') . " " . get_the_date('F') . ' ' . get_the_date('Y');
            } else {
                $obj = get_post_type_object( get_post_type() );
                if( $obj->has_archive ) {
                    $title = $obj->labels->name;
                }
            }
        }
    } elseif(is_search()) {
        $title = esc_html__("Search results", 'hairdresser');
    } elseif( is_404() ) {
        if( isset($anps_page_data['error_page']) && $anps_page_data['error_page'] != '0' ) {
            $title = get_the_title($anps_page_data['error_page']);
        } else {
            $title =  esc_html__("Error 404", 'hairdresser');
        }
    } else { ?>
    <?php if(get_the_title()) { $title = get_the_title(); } else { $title = get_the_title($anps_page_data['error_page']); } ?>
    <?php }

    echo '<h1 class="page-title">' . esc_html($title) . '</h1>';
?>
