<?php
//include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( function_exists('display_instagram') ) {
    /* Instagram shortcodes */
    if (!function_exists('anps_instagram_func')) {
        function anps_instagram_func($atts, $content) {
            extract( shortcode_atts( array(
                'style' => 'default',
                'title' => '',
            ), $atts ) );

            $return = "<div class='anps-instagram anps-instagram--$style'>";
                if ($title !== '') {
                    $title_style = 'white';

                    if ($style === 'fancy') {
                        $title_style = 'fancy';
                    }

                    $return .= '<div class="title title--middle title--style-' . $title_style . ' title--md anps-instagram__title">';
                    $return .= $title;
                    $return .= anps_svg('instagram-2');
                    $return .= '</div>';
                }
                $return .= '<div class="anps-instagram__wrap">';
                    $return .= do_shortcode("[instagram-feed num='15' cols='5' showheader=false showbutton=false showfollow=false imagepadding=0]");
                    $return .= '<div class="owl-nav">';
                        $return .= '<div class="owl-prev"><span class="sr-only">' . esc_html__('Previous', 'hairdresser') . '</span>' . anps_svg('arrow3-l') . '</div>';
                        $return .= '<div class="owl-next"><span class="sr-only">' . esc_html__('Next', 'hairdresser') . '</span>' . anps_svg('arrow3-r') . '</div>';
                    $return .= '</div>';
                $return .= "</div>";
            $return .= "</div>";

            return $return;
        }
    }
}
/* Blog shortcode */
function anps_blog_func($atts, $content) {
    extract( shortcode_atts( array(
        'category' => '',
        'orderby' => '',
        'order' => '',
        'type' => '',
        'columns' => '',
        'style' => 'classic'
    ), $atts ) );
    global $wp_rewrite;

    wp_enqueue_script('anps-isotope');

    if(get_query_var('paged')>1) {
        $current = get_query_var('paged');
    } elseif(get_query_var('page')>1) {
        $current = get_query_var('page');
    } else {
        $current = 1;
    }
    $args = array(
        'posts_per_page'   => $content,
        'category_name'    => $category,
        'orderby'          => $orderby,
        'order'            => $order,
        'post_type'        => 'post',
        'post_status'      => 'publish',
        'paged'            => $current
    );

    $posts = new WP_Query( $args );

    $pagination = array(
        'base' => @esc_url(add_query_arg('page','%#%')),
        'format' => '',
        'total' => $posts->max_num_pages,
        'current' => $current,
        'show_all' => false,
        'prev_text'    => '',
        'next_text'    => '',
        'type' => '',
    );

    global $blog_columns, $anps_blog_style, $anps_blog_type;
    $anps_blog_style = $style;
    $anps_blog_type = $type;

    $blog_columns = 'col-md-12';

    if ($type!= '') {
        switch($columns) {
            case '2': $blog_columns = 'col-sm-6'; break;
            case '3': $blog_columns = 'col-md-4 col-sm-6'; break;
            case '4': $blog_columns = 'col-md-3 col-sm-6'; break;
        }
    }
    $post_text = "";
    if($posts->have_posts()) :
        if($type=="masonry") {
            $post_text .= "<div class='row blog-masonry'>";
        } else {
            $post_text .= "<div class='row blog-row'>";
        }

        global $counter_blog;
        $counter_blog = 1;
        while($posts->have_posts()) :
            $posts->the_post();
            ob_start();
            get_template_part('content', get_post_format());
            $counter_blog++;
            $post_text .= ob_get_clean();
        endwhile;
        if( $wp_rewrite->using_permalinks() ) {
            $pagination['base'] = user_trailingslashit( trailingslashit( esc_url(remove_query_arg('s',get_pagenum_link(1)) ) ) . 'page/%#%/', 'paged');
        }
        if( !empty($wp_query->query_vars['s']) ) {
            $pagination['add_args'] = array('s'=>get_query_var('s'));
        }
        $post_text .= "</div>";
        if (paginate_links($pagination) !== null) {
            $post_text .= '<div class="pagination pagination--' . $style . '">';
                $post_text .= '<button class="pagination-nav pagination-nav--prev">' . anps_svg('arrow1-l') . '</button>';
                $post_text .= paginate_links( $pagination );
                $post_text .= '<button class="pagination-nav pagination-nav--next">' . anps_svg('arrow1-r') . '</button>';
            $post_text .= '</div>';
        }
        wp_reset_postdata();
    else :
        $post_text .= "<h2>".__('Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'hairdresser')."</h2>";
    endif;
    return $post_text;
}
/* Recent portfolio slider shortcode */
function anps_recent_portfolio_slider_func($atts, $content) {
    extract( shortcode_atts( array(
        'recent_title' => "",
        'title_color' => "#fff",
        'nex_prev_color' => "#c1c1c1",
        'nex_prev_bg_color' => "transparent",
        'number' => '',
        'number_in_row' => "4",
        'category'=> '',
        'orderby' => 'post_date',
        'order' => 'DESC'
    ), $atts ) );
    $tax_query='';
    if($category && $category!='0') {
        $tax_query = array(
            array(
                'taxonomy' => 'portfolio_category',
                'field' => 'id',
                'terms' => (int)$category
            )
       );
    }

    $args = array(
        'post_type' => 'portfolio',
        'orderby' => $orderby,
        'order' => $order,
        'showposts' => $number,
        'tax_query' => $tax_query
    );
    $portfolio_posts = new WP_Query( $args );

    wp_enqueue_script('anps-isotope');

    $portfolio_data = '<div class="projects">';

    $filters = get_terms('portfolio_category', "orderby=none&hide_empty=true");

    $portfolio_data .= '<div class="projects-header clearfix">
        <h2 class="title projects-title visible-lg pull-left" style="color: ' . $title_color . ';">' . $recent_title . '</h2>
        <ul class="projects-filter pull-right">
            <li><button data-filter="*" class="selected" style="color: ' . $title_color . ';">' . esc_html__( 'All projects', 'hairdresser' ) . '</button></li>';
    foreach ($filters as $filter) {
        $portfolio_data .= '<li><button style="color: ' . $title_color . ';" data-filter="' . $filter->slug . '">' . $filter->name . '</button></li>';
    }
    $portfolio_data .= '
        </ul>
    </div>';
    $portfolio_data .= '<div class="row projects-content" data-col="' . $number_in_row . '">';
    while($portfolio_posts->have_posts()) :
        $portfolio_posts->the_post();
        $portfolio_cat = "";
        if (get_the_terms(get_the_ID(), 'portfolio_category')) {
            $first_item = false;
            foreach (get_the_terms(get_the_ID(), 'portfolio_category') as $cat) {
                if($first_item) {
                    $portfolio_cat .= " ";
                }
                $first_item = true;
                $portfolio_cat .= strtolower(str_replace(" ", "-", $cat->slug));
            }
        }
        if(has_post_thumbnail(get_the_ID())) {
            $image = get_the_post_thumbnail(get_the_ID(), 'post-thumb');
        }
        elseif(get_post_meta(get_the_ID(), $key ='gallery_images', $single = true )) {
            $exploded_images = explode(',',get_post_meta(get_the_ID(), $key ='gallery_images', $single = true ));
            $image_url = wp_get_attachment_image_src($exploded_images[0], array(360, 267));
            $image = "<img src='".$image_url[0]."' />";
        }

        $portfolio_data .= ' <div class="projects-item ' . $portfolio_cat . '">';
            $portfolio_data .= $image;

            $portfolio_data .= '<div class="project-hover">';
                $portfolio_data .= '<h3 class="project-title text-uppercase">' . get_the_title() . '</h3>';
                //$portfolio_data .= '<p class="project-desc"></p>';
                $portfolio_data .= ' <a class="btn btn-md" href="' . get_permalink() . '">' . esc_html__('Read More', 'hairdresser') . '</a>';
            $portfolio_data .= '</div>';
        $portfolio_data .= '</div>';
    endwhile;
    wp_reset_postdata();
    $portfolio_data .= "</div>";
    $portfolio_data .= '<div class="projects-pagination">
        <button class="prev" style="color: ' . $nex_prev_color . ';"><i class="fa fa-angle-left"></i></button>
        <button class="next" style="color: ' . $nex_prev_color . ';"><i class="fa fa-angle-right"></i></button>
    </div>';

    $portfolio_data .= '</div>';
    return $portfolio_data;
}
/* Recent portfolio shortcode */
function anps_recent_portfolio_func($atts, $content) {
    extract( shortcode_atts( array(
        'number' => '5',
        'category'=> '',
        'orderby' => 'post_date',
        'order' => 'DESC',
        'mobile_class' => '2'
    ), $atts ) );
    $tax_query='';
    if($category && $category!='0') {
        $tax_query = array(
            array(
                'taxonomy' => 'portfolio_category',
                'field' => 'id',
                'terms' => (int)$category
            )
       );
    }

    $args = array(
        'post_type' => 'portfolio',
        'orderby' => $orderby,
        'order' => $order,
        'showposts' => $number,
        'tax_query' => $tax_query
    );
    $portfolio_posts = new WP_Query( $args );

    if($mobile_class=="2") {
        $m_class = " col-xs-6";
    } else {
        $m_class = " col-xs-12";
    }
    $portfolio_data = "";
    $portfolio_data .= "<ul class='recentportfolio clearfix'>";
    while($portfolio_posts->have_posts()) :
        $portfolio_posts->the_post();
        $portfolio_cat = "";
        if (get_the_terms(get_the_ID(), 'portfolio_category')) {
            $first_item = false;
            foreach (get_the_terms(get_the_ID(), 'portfolio_category') as $cat) {
                if($first_item) {
                    $portfolio_cat .= " ";
                }
                $first_item = true;
                $portfolio_cat .= strtolower(str_replace(" ", "-", $cat->name));
            }
        }
        $image = '';
        if(has_post_thumbnail(get_the_ID())) {
            $image = get_the_post_thumbnail(get_the_ID(), 'anps-post-thumb');
        }
        elseif(get_post_meta(get_the_ID(), $key ='gallery_images', $single = true )) {
            $exploded_images = explode(',',get_post_meta(get_the_ID(), $key ='gallery_images', $single = true ));
            $image_url = wp_get_attachment_image_src($exploded_images[0], array(360, 267));
            $image = "<img src='".$image_url[0]."' />";
        }
        $portfolio_data .= "<li class='item item-type-line$m_class'>";
        $portfolio_data .= "<a class='item-hover' href=".get_permalink().">";
        $portfolio_data .= "<div class='mask'></div>";
        $portfolio_data .= "<div class='item-info'>";
        $portfolio_data .= "<div class='headline'><h2>".get_the_title()."</h2></div>";
        $portfolio_data .= "</div></a>";
        $portfolio_data .=  "<div class='item-img'>".$image."</div>";
        $portfolio_data .= "</li>";
    endwhile;
    wp_reset_postdata();
    $portfolio_data .= "</ul>";
    return $portfolio_data;
}
/* Portfolio shortcode */
function anps_portfolio_func($atts, $content) {
    extract( shortcode_atts( array(
            'filter' => 'on',
            'filter_orderby' => '',
            'filter_order' => '',
            'pagination' => 'off',
            'columns' => '4',
            'category'=> '',
            'orderby' => '',
            'order' => '',
            'wrapper' => 'on',
            'type' => 'classic',
            'style' => 'style-1',
            'per_page' => -1,
            'page' => '1',
            'mobile_class' => '2',
            'filter_color' => '#000000',
            'hide_all' => false,
	), $atts ) );

    wp_enqueue_script('anps-isotope');

    $type_class = "";
    if($type=="classic") {
        $type_class = " classic";
    } elseif($type=="random") {
        $type_class = " random";
    } else {
        $type_class = " classic";
    }
    $tax_query='';
    $parent_cat = "";

    /* Pagination */
    $pagination_attr = '';
    $filter_category = false;

    if($pagination == 'on') {
        /* URL category filter */
        if($category !== '' && $category !== 'All' && $category !== '0' && $category !== '*' && !is_numeric($category)) {
            $filter_category = $category;
        } else if(isset($_GET['filter']) && $_GET['filter'] !== '*') {
            $filter_category = esc_html($_GET['filter']);
        }
    }

    if($filter_category && $filter_category!='All') {
        $parent_cat = $category;
        $tax_query = array(
            array(
                'taxonomy' => 'portfolio_category',
                'field' => 'slug',
                'terms' => $filter_category,
            )
       );
   } else if ($category) {
       $parent_cat = $category;
       $tax_query = array(
           array(
               'taxonomy' => 'portfolio_category',
               'field' => 'id',
               'terms' => (int)$category,
           )
      );
   }

    $args = array(
        'post_type' => 'portfolio',
        'orderby' => $orderby,
        'order' => $order,
        'showposts' => $per_page,
        'paged' => $page,
        'tax_query' => $tax_query
    );
    $portfolio_posts = new WP_Query( $args );

    /* Pagination */
    $pagination_attr = '';

    if($pagination == 'on') {
        $number = $portfolio_posts->found_posts;
        $pagination_attr = " data-page='$page' data-per-page='$per_page' data-number='$number' data-mobile-class='mobile_class' data-type='$type' data-columns='$columns' data-order='$order' data-orderby='$orderby'";

        if(is_numeric($category)) {
            $pagination_attr .= " data-category='" . $category . "'";
        }
    }

    /*desktop-class*/
    if($type!="random") {
        $mdclass = " col-md-3";
        if ($columns=="3") {
            $mdclass = " col-md-4";
        } elseif ($columns=="6") {
            $mdclass = " col-md-2";
        } elseif($columns=="2") {
            $mdclass = " col-md-6";
        } elseif($columns=="4") {
            $mdclass = " col-md-3";
        }
    } else {
        $mdclass = "";
    }

    /* Mobile class */
    if($mobile_class=="2") {
        $m_class = " col-xs-6";
    } else {
        $m_class = " col-xs-12";
    }

    /* Modern filter */

    if($type == "modern-1" || $type == "modern-2" || $type == "modern-3") {
        $style = ' filter-modern';
    }

    /* Portfolio isotope filter */
    $filter_style = '';
    if(isset($filter) && $filter!="on") {
        $filter_style = " style='display: none'";
    }
    $portfolio_data = "";
    $portfolio_data .= "<ul class='filter ".$style."'$filter_style>";
    $portfolio_data .= '<i style="color: '.$filter_color.';" class="fa fa-filter"></i>';
    if (!$hide_all) {
        $portfolio_data .= '<li><button style="color: '.$filter_color.';" data-filter="*">'.__("All", 'hairdresser')."</button></li>";
    }
    $filters = get_terms('portfolio_category', "orderby=$filter_orderby&order=$filter_order&hide_empty=true&parent=$parent_cat");
    foreach ($filters as $item) {
        $portfolio_data .= '<span style="color: '.$filter_color.';">/</span>';
        $portfolio_data .= '<li><button style="color: '.$filter_color.';" data-filter="' . $item->slug . '">' . $item->name . '</button></li>';
    }
    $portfolio_data .= "</ul>";
    if($type=="random") {
        $i=1;
    }

    /* Portfolio isotope filter enabled posts */
    if($type!="random") {
        $portfolio_data .= "<ul class='portfolio isotope".$type_class."'$pagination_attr>";
    } else {
        $portfolio_data .= "<ul class='isotope".$type_class."'$pagination_attr>";
    }

    while($portfolio_posts->have_posts()) :
        $portfolio_posts->the_post();
        $portfolio_cat = "";

        $skip = false;

        if($filter_category) {
            $skip = true;
        }

        if (get_the_terms(get_the_ID(), 'portfolio_category')) {
            $first_item = false;
            foreach (get_the_terms(get_the_ID(), 'portfolio_category') as $cat) {
                if($first_item) {
                    $portfolio_cat .= " ";
                }
                $first_item = true;
                $portfolio_cat .= $cat->slug;

                if($cat->slug === $filter_category) {
                    $skip = false;
                }
            }
        }

        if($skip) {
            continue;
        }

        $portfolio_subtitle = get_post_meta( get_the_ID(), $key = 'anps_subtitle', $single = true );

        $rand_class="";
        $image_class = "post-thumb";
        if($type=="random") {
            switch($i) {
                case 1 :
                    $rand_class = " width-2";
                    $image_class = "portfolio-random-width-2-height-2";
                    break;
                case 4 :
                    $rand_class = " height-2";
                    $image_class = "portfolio-random-width-2-height-1";
                    break;
                case 5 :
                    $rand_class = " width-2 height-2";
                    $image_class = "portfolio-random-width-4-height-4";
                    break;
                case 10 :
                    $rand_class = " width-2";
                    $image_class = "portfolio-random-width-2-height-2";
                    break;
            }
        }
        if(has_post_thumbnail(get_the_ID())) {
            $image = get_the_post_thumbnail(get_the_ID(), 'post-thumb');
            $image = str_replace( 'class="', 'class="attachment-' . $image_class . ' ', $image );
        }
        elseif(get_post_meta(get_the_ID(), $key ='gallery_images', $single = true )) {
            $exploded_images = explode(',',get_post_meta(get_the_ID(), $key ='gallery_images', $single = true ));
            $image_url = wp_get_attachment_image_src($exploded_images[0], $image_class);
            $image = "<img src='".$image_url[0]."' />";
        }


        if($type == "modern-1") {
            $portfolio_data .= "<li class='isotope-item portfolio-modern portfolio-modern--style-1 ".$portfolio_cat.$rand_class.$m_class.$mdclass."'>";
                $portfolio_data .= '<a href="' . get_permalink() . '" class="portfolio-modern__link">';
                    $portfolio_data .= '<div class="portfolio-modern__image">' . $image . '</div>';
                    $portfolio_data .= '<div class="portfolio-modern__wrap">';
                        $portfolio_data .= '<h2 class="portfolio-modern__title">' . get_the_title() . '</h2>';
                        $portfolio_data .= '<div class="portfolio-modern__excerpt">' . get_the_excerpt() . '</div>';
                    $portfolio_data .= "</div>";
                $portfolio_data .= "</a>";
            $portfolio_data .= "</li>";
        } else if($type == "modern-2") {
                $portfolio_data .= "<li class='isotope-item portfolio-modern portfolio-modern--style-2 ".$portfolio_cat.$rand_class.$m_class.$mdclass."'>";
                    $portfolio_data .= '<div class="portfolio-modern__image">' . $image . '</div>';
                    $portfolio_data .= '<div class="portfolio-modern__wrap">';
                        $portfolio_data .= '<h2 class="portfolio-modern__title">' . get_the_title() . '</h2>';
                        $portfolio_data .= '<a href="' . get_permalink() . '" class="portfolio-modern__link btn style-1">' . esc_html__('View project', 'hairdresser') . '</a>';
                    $portfolio_data .= "</div>";
                $portfolio_data .= "</li>";
        } else if($type == "modern-3") {
            $portfolio_data .= "<li class='isotope-item portfolio-modern portfolio-modern--style-3 ".$portfolio_cat.$rand_class.$m_class.$mdclass."'>";
                $portfolio_data .= '<div class="portfolio-modern__image">' . $image . '</div>';
                $portfolio_data .= '<div class="portfolio-modern__wrap">';
                    $portfolio_data .= '<h2 class="portfolio-modern__title">' . get_the_title() . '</h2>';
                    $portfolio_data .= '<a href="' . get_permalink() . '" class="portfolio-modern__link btn style-1">' . esc_html__('View project', 'hairdresser') . '</a>';
                $portfolio_data .= "</div>";
            $portfolio_data .= "</li>";
        } else if($type!="random") {
            $portfolio_data .= "<li class='isotope-item ".$portfolio_cat.$rand_class.$m_class.$mdclass."'><article class='inner'>";
            $portfolio_data .= "<a class='item-hover' href='".get_permalink()."'>";
            $portfolio_data .= "<div class='mask'></div>";
            $portfolio_data .= "<div class='item-info'>";

            if($type=="default") {
                $portfolio_data .= "<div class='headline'><h2><i class='fa fa-link'></i></h2></div>";
            }
            else {
                $portfolio_data .= "<div class='headline'><h2>".get_the_title()."</h2></div>";
            }

            $portfolio_data .= "</div></a>";
            $portfolio_data .=  "<div class='item-img'>".$image."</div>";
            $portfolio_data .= "</article>";

            if($type=="default") {
                $portfolio_data .= "<a class='portfolio-title' href='".get_permalink()."'><h2 class='text-center'>".get_the_title()."</h2></a>";
                $portfolio_data .= "<div class='subtitle text-center'>".$portfolio_subtitle."</div>";
            }
            $portfolio_data .= "</li>";
        } else {
            $portfolio_data .= "<li class='isotope-item ".$portfolio_cat.$rand_class.$mdclass."'>";
            $portfolio_data .= "<article class='inner'>";
            $portfolio_data .= "<a class='item-hover' href='".get_permalink()."'>";
            $portfolio_data .= "<div class='mask'></div>";
            $portfolio_data .= "<div class='item-info'>";
            $portfolio_data .= "<div class='headline'><h2>".get_the_title()."</h2></div>";
            $portfolio_data .= "<div class='line'></div>";
            $portfolio_data .= "<div class='fa fa-search'></div>";
            $portfolio_data .= "</div></a>";
            $portfolio_data .=  "<div class='item-img'>".$image."</div>";
            $portfolio_data .= "</article>";
            $portfolio_data .= "</li>";
        }

        if($type=="random") {
            $i++;
        }
    endwhile;
    wp_reset_postdata();
    $portfolio_data .= "</ul>";
    if($wrapper == 'on') {
        $portfolio_data .= "<div class='portfolio-pagination'></div>";
    }
    return $portfolio_data;
}
/* Portfolio shortcode */
add_action("wp_ajax_anps_portfolio_m_ajax", "anps_portfolio_m_ajax");
add_action("wp_ajax_nopriv_anps_portfolio_m_ajax", "anps_portfolio_m_ajax");

function anps_portfolio_m_ajax() {
    $args = array(
        'post_type' => 'portfolio',
        'orderby' => $_POST['orderby'],
        'order' => $_POST['order'],
        'posts_per_page' => $_POST['per_page'],
        'paged' => $_POST['page'],
    );
    $category = $_POST['category'];

    if ($category != '') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'portfolio_category',
                'field' => 'slug',
                'terms' => explode(',', $category),
            )
       );
    }

    $portfolio_posts = new WP_Query($args);

    echo anps_portfolio_m_posts($portfolio_posts, $_POST['link_type']);

    exit;
}

add_action("wp_ajax_anps_portfolio_m_pagination_ajax", "anps_portfolio_m_pagination_ajax");
add_action("wp_ajax_nopriv_anps_portfolio_m_pagination_ajax", "anps_portfolio_m_pagination_ajax");

function anps_portfolio_m_pagination_ajax() {
    $args = array(
        'post_type' => 'portfolio',
        'posts_per_page' => $_POST['per_page'],
    );
    $category = $_POST['category'];

    if ($category != '') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'portfolio_category',
                'field' => 'slug',
                'terms' => explode(',', $category),
            )
       );
    }

    $portfolio_posts = new WP_Query($args);

    echo esc_html($portfolio_posts->max_num_pages);

    exit;
}

if (!function_exists('anps_portfolio_modern_posts_func')) {
    function anps_portfolio_m_posts($portfolio_posts, $link_type) {
        ob_start();
        $rand = rand(10000, 999999);
        while($portfolio_posts->have_posts()) :
            $portfolio_posts->the_post();
            $categories_query = get_the_terms(get_the_ID(), 'portfolio_category');
            $categories = '';

            if (count($categories_query) > 0) {
                foreach ($categories_query as $category) {
                    $categories .= ' ' . $category->slug;
                }
            }

            $el_tag = 'div';
            $el_attr = ' class="portfolio-m__item ' . $categories .'"';

            if ($link_type === 'image') {
                $el_tag = 'a';
                $el_attr = ' href="' . get_the_post_thumbnail_url(get_the_ID(), 'full') . '" data-rel="prettyPhoto[portfolio' . $rand . ']" rel="prettyPhoto[portfolio' . $rand . ']" class="portfolio-m__item prettyphoto ' . $categories .'"';

                wp_enqueue_script('prettyphoto');
                wp_enqueue_style('prettyphoto');
            }
            ?>
            <<?php echo esc_attr($el_tag) . $el_attr; ?>>
                <div class="portfolio-m__wrap">
                    <div class="portfolio-m__image">
                        <?php the_post_thumbnail('anps-portfolio-random-width-2-height-2'); ?>
                    </div>

                    <?php if ($link_type === 'image'): ?>
                        <div class="portfolio-m__enlarge"><?php echo anps_svg('enlarge'); ?></div>
                    <?php endif; ?>

                    <div class="portfolio-m__content">
                        <h3 class="portfolio-m__name"><?php the_title(); ?></h3>
                        <?php if ($link_type === 'post'): ?>
                            <a class="portfolio-m__link" href="<?php echo get_permalink(); ?>"><?php esc_html_e('Read more', 'hairdresser'); ?><?php echo anps_svg('arrow2-r'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </<?php echo esc_attr($el_tag); ?>>
            <?php
        endwhile;
        wp_reset_postdata();
        return ob_get_clean();
    }
}
if (!function_exists('anps_portfolio_modern_func')) {
    function anps_portfolio_modern_func($atts, $content) {
        extract(shortcode_atts( array(
            'title'             => '',
            'per_page'          => '3',
            'style'             => 'white',
            'category'          => '',
            'filter'            => 'on',
            'pagination_style'  => 'numbers',
            'orderby'           => 'date',
            'order'             => 'DESC',
            'title_color'       => '',
            'filter_text_color' => '',
            'link_type'         => 'post',
    	), $atts));

        wp_enqueue_script('anps-isotope');

        $args = array(
            'post_type' => 'portfolio',
            'orderby' => $orderby,
            'order' => $order,
            'posts_per_page' => $per_page,
        );

        if ($category != '' && $category != '0') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'portfolio_category',
                    'field' => 'slug',
                    'terms' => explode(',', $category),
                )
           );
        }

        $portfolio_posts = new WP_Query($args);

        if ($category !== '') {
            $filter_posts = get_terms('portfolio_category', array(
                'hide_empty' => true,
                'slug' => explode(',', $category),
            ));
        } else {
            $filter_posts = get_terms('portfolio_category', array(
                'hide_empty' => true,
            ));   
        }

        $portfolio_data = '';

        /* Main element */
        $portfolio_data .= '<div class="portfolio-m portfolio-m--' . esc_attr($style) . '">';
            if ($title !== '' || $filter === 'on') {
                $portfolio_data .= '<div class="portfolio-m__header">';
                    /* Title */
                    if ($title !== '') {
                        $portfolio_data .= '<h3 class="portfolio-m__title"' . anps_style_color($title_color) . '><span>' . $title . '</span></h3>';
                    }
                    /* END Title */

                    /* Filter */
                    if ($filter === 'on') {
                        $portfolio_data .= '<ul' . anps_style_color($filter_text_color) . ' class="filter-m filter-m--' . esc_attr($style) . '">';
                            $portfolio_data .= '<li class="filter-m__item"><button class="filter-m__button filter-m__button--active" data-filter="*"><span class="filter-m__text">'. esc_html__('All projects', 'hairdresser') . '</span><span class="filter-m__loader"><i class="fa fa-circle-o-notch" aria-hidden="true"></i></span></button></li>';
                            foreach ($filter_posts as $filter_post) {
                                $portfolio_data .= '<li class="filter-m__item"><button class="filter-m__button" data-filter="' . esc_attr($filter_post->slug) . '"><span class="filter-m__text">' . esc_html($filter_post->name) . '</span><span class="filter-m__loader"><i class="fa fa-circle-o-notch" aria-hidden="true"></i></span></button></li>';
                            }
                        $portfolio_data .= '</ul>';
                    }
                    /* END Filter */
                $portfolio_data .= '</div>';
            }

            /* Items */
            $portfolio_data .= '<div class="portfolio-m__items" data-orderby="' . $orderby . '" data-order="' . $order . '" data-per-page="' . $per_page . '" data-category="' . $category . '">';
                $portfolio_data .= anps_portfolio_m_posts($portfolio_posts, $link_type);
            $portfolio_data .= '</div>';
            /* END Items */

            /* Pagination */
            $number = ceil($portfolio_posts->found_posts / $per_page);

            if ($pagination_style === 'numbers') {

                $portfolio_data .= '<div class="pagination-m pagination-m--' . $style . '" data-max-page="' . $number . '">';
                    for ($i=0; $i < $number; $i++) {
                        $class = 'pagination-m__button';

                        if ($i === 0) {
                            $class .= ' pagination-m__button--active';
                        }

                        $portfolio_data .= '<button class="' . $class . '">' . ($i + 1) . '</button>';
                    }
                $portfolio_data .= '</div>';
            } else {
                $arrow_prev = anps_svg('arrow2-l');
                $arrow_next = anps_svg('arrow2-r');

                if ($style === 'fancy') {
                    $arrow_prev = anps_svg('arrow3-l');
                    $arrow_next = anps_svg('arrow3-r');
                }

                $portfolio_data .= '<div data-max-page="' . $number . '" class="next-prev-m next-prev-m--' . esc_attr($style) . '">';
                    $portfolio_data .= '<button class="next-prev-m__button next-prev-m__button--prev">' . $arrow_prev . '</button>';
                    $portfolio_data .= '<button class="next-prev-m__button next-prev-m__button--next">' . $arrow_next . '</button>';
                $portfolio_data .= '</div>';
            }
            /* END Pagination */
        $portfolio_data .= '</div>';
        /* END Main element */

        return $portfolio_data;
    }
}
if (!function_exists('anps_appointments')) {
    function anps_appointments_func($atts, $content) {
        extract(shortcode_atts( array(
            'filter_color'   => '',
            'arrows_color'   => '',
            'divider_color'  => '',
            'location_color' => '',
        ), $atts));

        $return = '';
        $style = '';

        if ($filter_color !== '') {
            $style .= ".anps-appointments .calendar-service__item { color: ${filter_color}; }";
        }

        if ($arrows_color !== '') {
            $style .= " .anps-appointments .calendar-location__nav { color: ${arrows_color}; }";
        }

        if ($divider_color !== '') {
            $style .= " .anps-appointments .calendar-location::after { background-color: ${divider_color}; }";
        }

        if ($location_color !== '') {
            $style .= " .anps-appointments .calendar-location__val { color: ${location_color}; }";
        }

        if ($style !== '') {
            $return .= '<style>' . $style . '</style>';
        }
        $return .= '<div class="anps-appointments">[ea_bootstrap]</div>';
        
        return do_shortcode($return);
    }
}
if (!function_exists('anps_portfolio_fs_func')) {
    function anps_portfolio_fs_func($atts, $content) {
        extract(shortcode_atts( array(
            'category'    => '',
            'orderby'     => 'date',
            'order'       => 'DESC',
            'title_color' => '',
            'more_color'  => '',
            'style'       => 'white',
    	), $atts));

        $args = array(
            'post_type' => 'portfolio',
            'orderby' => $orderby,
            'order' => $order,
        );

        if ($category != '' && $category != '0') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'portfolio_category',
                    'field' => 'id',
                    'terms' => (int)$category
                )
           );
        }

        $portfolio_posts = new WP_Query($args);

        $portfolio_data = '';

        wp_enqueue_script( 'vc_jquery_skrollr_js' );

        /* Main element */
        $portfolio_data .= '<div class="portfolio-fs portfolio-fs--' . $style . '">';
            /* Items */
            ob_start();
            while($portfolio_posts->have_posts()) :
                $portfolio_posts->the_post();
                ?>
                <a
                    class="portfolio-fs__item vc_parallax"
                    href="<?php echo get_permalink(); ?>"
                    style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>')"
                    data-vc-parallax="1.5"
                >
                    <div class="portfolio-fs__container container">
                        <div class="portfolio-fs__content">
                            <h3 class="portfolio-fs__title"<?php echo anps_style_color($title_color); ?>><?php the_title(); ?></h3>
                            <span class="portfolio-fs__more"<?php echo anps_style_color($more_color); ?>><?php esc_html_e('Read more', 'hairdresser'); ?><?php echo anps_svg('arrow2-r'); ?></span>
                        </div>
                    </div>
                </a>
                <?php
            endwhile;
            wp_reset_postdata();
            $portfolio_data .= ob_get_clean();
            /* END Items */
        $portfolio_data .= '</div>';
        /* END Main element */

        return $portfolio_data;
    }
}
/* Image */
function anps_image_func($atts, $content) {
    extract( shortcode_atts( array(
        'alt' => '',
        'url' => '',
        'target' => '_blank'
    ), $atts ) );

    $url = str_replace("&quot;", "", $url);
    $alt = str_replace("&quot;", "", $alt);
    $target = str_replace("&quot;", "", $target);
    $img_data = "";
    if($url) {
        $img_data .= "<a href='".esc_url($url)."' target='".$target."'>";
    }
    $img_data .= "<img alt='" . $alt . "' src='".esc_url($content)."' />";
    if($url) {
        $img_data .= "</a>";
    }
    return $img_data;
}
/* END Image */
function anps_featured_content( $atts,  $content ) {
    extract( shortcode_atts( array(
            'title' => '',
            'image_u' => '',
            'link' => '',
            'button_text' => 'Read more',
            'absolute_img' =>''
    ), $atts ) );

$image = '';
if($image_u) {
    $image = wp_get_attachment_image_src($image_u, 'anps-featured');
    $image = $image[0];
}

$img_class = "relative";
if($absolute_img!="") {
    $img_class = " absolute-top";
}

$output = "<div class='anps-featured'>";
$output .= "<header>";
$output .= "<img alt='" . $title . "' class='".$img_class."' src='".$image."'/>";
$output .= "</header>";
$output .= "<div class='content-wrap'>";
$output .= "<h3>".$title."</h3>";
if($content!="") {
$output .= "<p>".$content ."</p>";
}
$output .= "</div>";
if($link!="") {
    $output .= "<footer>";
    $output .= "<a class='btn btn-sm slider' href='".$link."'>$button_text</a>";
    $output .= "</footer>";
}
$output .= "</div>";

return $output;
}
/* Team shortcode */
function anps_team_func($atts, $content) {
    extract( shortcode_atts( array(
        'columns' => '4',
        'category'=> '',
        'ids' => '',
        'number_items' => '-1',
        'style' => 'classic'
    ), $atts ) );

    $tax_query='';
    if($category && $category!='All' && $category!='0') {
        $tax_query = array(
            array(
                'taxonomy' => 'team_category',
                'field' => 'id',
                'terms' => (int)$category
            )
       );
    }
    /* Select team by member id */
    $array_ids = "";
    $order_by = "date";
    if($ids) {
        $array_ids = explode(",", $ids);
        $array_ids = array_map("trim", $array_ids);
        $order_by = "post__in";
    }


    $args = array(
        'post_type' => 'team',
        'showposts' => $number_items,
        'columns' => $columns,
        'post__in' => $array_ids,
        'tax_query' => $tax_query,
        'orderby' => $order_by
    );
    global $text_only;
    $class = "6";
    $class_lg = "3";
    $image_class = "anps-team-3";

    if ($columns=="3") {
        $class = "4";
        $class_lg = "4";
        $image_class = "anps-team-3";
    } elseif ($columns=="6") {
        $class = "4";
        $class_lg = "2";
        $image_class = "anps-team-3";
    } elseif($columns=="2") {
        $class = "6";
        $class_lg = "6";
        $image_class = "team-2";
    }

    $team_posts = new WP_Query( $args );
    $team_data = "<div class='row team-row'>";
    $text_only = true;
    while($team_posts->have_posts()) :
        $team_posts->the_post();

        $icons = '';
        if (get_post_meta(get_the_ID(), $key = 'anps_team_social', $single = true)) {
            $icons = explode('|', get_post_meta(get_the_ID(), $key = 'anps_team_social', $single = true));
        }

        $team_class = 'team';

        if( (get_the_content() != '' && $style === 'classic') ||
            ($icons && $style !== 'classic') ) {
            $team_class .= ' team--hover';
        }

        $team_class .= ' team--' . $style;

        $subtitle = get_post_meta( get_the_ID(), $key = 'anps_team_subtitle', $single = true );

        $team_data .= "<div class='col-lg-".$class_lg." col-sm-".$class."'><div class='" . $team_class . "'>";
        $team_data .= "<header class='team__header'>";
        $team_data .= get_the_post_thumbnail(get_the_ID(), $image_class);
        if( get_the_content() != '' && $style === 'classic' ) {
            $team_data .= "<div class='team__desc'>".do_shortcode(get_the_content())."</div>";
        } else if ($style !== 'classic') {
            $team_data .= '<div class="team-social">';
            if($icons) {
                foreach($icons as $item) {
                    $icon_item = explode(';', $item);

                    $icon = $icon_item[0];
                    $icon_url = $icon_item[1];

                    if (strpos($icon, 'anps-') !== false) {
                        $team_data .= '<a class="team-social__item" href="'.$icon_url.'">' . file_get_contents(get_template_directory_uri() . '/images/svgs/' . str_replace('anps-icon-', '', $icon) . '.svg') . '</a>';
                    } else {
                        anps_load_vc_icons($icon);
                        $team_data .= '<a class="team-social__item" href="'.$icon_url.'"><i class="'.$icon.'"></i></a>';
                    }
                }
            }
            $team_data .= '</div>';
        }
        $team_data .= "</header>";
        $team_data .= "<h2 class='team__title'>".get_the_title()."</h2>";
        $team_data .= "<em class='team__subtitle'>".$subtitle."</em>";
        $team_data .= "</div></div>";
    endwhile;
    wp_reset_postdata();
    $text_only = false;
    $team_data .= "</div>";
    return $team_data;
}
/* Recent blog posts */
function anps_recent_blog_func($atts, $content) {
    extract( shortcode_atts( array(
		'number'     => '4',
        'categories' => '',
        'col_number' => '',
        'style'      => 'classic',
	), $atts ) );
    switch($col_number) {
        case "2": $blog_columns = " col-lg-6 col-md-6 col-sm-6 col-xs-12"; break;
        case "3": $blog_columns = " col-lg-4 col-md-6 col-sm-6 col-xs-12"; break;
        case "4": $blog_columns = " col-lg-3 col-md-6 col-sm-6 col-xs-12"; break;
        case "6": $blog_columns = " col-lg-2 col-md-6 col-sm-6 col-xs-12"; break;
        default : $blog_columns = " col-lg-4 col-md-6 col-sm-6 col-xs-12"; break;
    }
    $args = array(
        'posts_per_page'   => $number,
        'orderby'          => "date",
        'order'            => "DESC",
        'post_type'        => 'post',
        'post_status'      => 'publish',
        'cat'              => $categories
    );
    $posts = new WP_Query( $args );

    if ($style === 'classic') {
        echo '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: none;">
            <symbol id="blog-icon" viewBox="0 0 31.643 41.243">
                <polygon points="2,0.042 0,2.042 2,2.042 "/>
                <polygon fill="' . get_option('anps_hovers_color', '#BD1470') . '" points="1.977,41.243 1.977,0 31.643,0 31.643,41.243 16.813,33.625 "/>
            </symbol>
        </svg>';
    }

     $recent_post_text ="";
     if($posts->have_posts()) :
        $recent_post_text .= '<div class="recent-posts recent-posts--' . $style . ' row">';
        while($posts->have_posts()) :
            $posts->the_post();
            global $more;
            $more = 0;
            $recent_post_text .= "<article class='recent-post".$blog_columns."'>";
                if(get_the_post_thumbnail(get_the_ID())!="") {
                    $recent_post_text .= '<header class="recent-post__header">';
                        $recent_post_text .= "<a class='recent-post__hover' href='".get_permalink()."'>";
                        $recent_post_text .= "</a>";
                        if ($style === 'classic') {
                            $recent_post_text .= '<time class="recent-post__time" datetime="'. get_the_date("Y-m-d H:i") . '">'.get_the_date("j").'<span>'.get_the_date("M").'</span></time>';
                            $recent_post_text .= '<svg class="recent-post__icon"><use xlink:href="#blog-icon"></use></svg>';
                        } else {
                            $recent_post_text .= '<time class="recent-post__time" datetime="'. get_the_date("Y-m-d H:i") . '">' . get_the_date("M") . ' ' . get_the_date("j").'</time>';
                        }
                        $recent_post_text .= "<div class='recent-post__img'>".get_the_post_thumbnail(get_the_ID(), 'anps-post-thumb')."</div>";
                    $recent_post_text .= "</header>";
                }
                $recent_post_text .= "<a class='recent-post__title' href='".get_permalink()."'>";
                    $recent_post_text .= "<h2>".get_the_title()."</h2>";
                $recent_post_text .= "</a>";
                $recent_post_text .= "<div class='recent-post__excerpt'>".apply_filters('the_excerpt', get_the_excerpt())."</div>";
            $recent_post_text .= "</article>";
        endwhile;
        $recent_post_text .= "</div>";
     endif;
     wp_reset_postdata();
     return $recent_post_text;
}
/* Progress */
function anps_progress_func($atts, $content) {
    extract( shortcode_atts( array(
		'procent' => "0",
        'striped' => "",
        'active' => "",
        'color_class' => 'progress-bar-success'
        ), $atts ) );

    if($striped) {
        if($active) {
            $active = " active";
        }
        $striped = " progress-striped".$active;
    }
    $progress_data = "";

    if( $content ) {
        $progress_data .= "<h4>" . $content . "</h4>";
    }

    $progress_data .= "<div class='progress".$striped."'>";
    $progress_data .= "<div class='progress-bar ".$color_class."' role='progressbar' aria-valuenow='".$procent."' aria-valuemin='0' aria-valuemax='100' style='width: ".$procent."%;'></div>";
    $progress_data .= "</div>";
    return $progress_data;
}
/* Counter */
function anps_counter_func($atts, $content) {
    extract( shortcode_atts( array(
		'icon' => "",
                'max' => "",
                'min' => "0",
                "icon_color" => "",
                "number_color" => "",
                "subtitle_color" => "",
                "border_color" => ""
        ), $atts ) );
    wp_enqueue_script( 'countto' );
    $icon_style = "";
    $number_style = "";
    $subtitle_style = "";
    $border_style = "";
    if($icon_color) {
        $icon_style = " style='color:".$icon_color."'";
    }
    if($number_color) {
        $number_style = " style='color:".$number_color."'";
    }
    if($subtitle_color) {
        $subtitle_style = " style='color:".$subtitle_color."'";
    }
    if($border_color) {
        $border_style = " style='border-color:".$border_color."'";
    }
    return "<div class='counter'>
            <div class='wrapbox'$border_style>
                <i class='fa fa-".$icon."'$icon_style></i>
                <h2 class='counter-number' data-to='".$max."'$number_style>".$min."</h2>
                <h3$subtitle_style>".$content."</h3>
            </div>

            </div>";
}
/* Newsletter widget */
function anps_newsletter_widget_func($atts) {
    global $wp_widget_factory;
    extract(shortcode_atts(array(
        'widget_name' => "NewsletterWidget"
    ), $atts));

    $widget_name = esc_html($widget_name);

    if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')):
        $wp_class = 'WP_Widget_'.ucwords(strtolower($class));

        if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')):
            return '<p>'.sprintf(esc_html__("%s: Widget class not found. Make sure this widget exists and the class name is correct", 'hairdresser'),'<strong>'.$class.'</strong>').'</p>';
        else:
            $class = $wp_class;
        endif;
    endif;

    ob_start();
    the_widget($widget_name, $instance=array(), array(
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
    ));
    $output = ob_get_contents();
    ob_end_clean();
    return $output;

}
/* Coming soon */
function anps_coming_soon_func($atts, $content) {
    extract( shortcode_atts( array(
        'image_u' => "",
        'image' => "",
        'title' => "",
        'subtitle'=>"",
        'date' => ""
    ), $atts ) );

    $img_bg = '';

    if($image_u) {
        $image = wp_get_attachment_image_src($image_u, 'full');
        $image = $image[0];
    }
    if($image) {
        $img_bg = " style='background-image: url(".$image.");'";
    }
    return '<div class="coming-soon"'.$img_bg.'>
		<h1>'.$title.'</h1>
		<h2 class="primary">'.$subtitle.'</h2>
		<ul class="countdown primary"></ul>'.
                do_shortcode($content)
	.'</div>
	<script src="'.get_template_directory_uri()  . "/js/countdown.js".'"></script>
        <script>
		jQuery(".countdown").countdown("'.$date.'", function(event) {
		     jQuery(this).html(event.strftime("<li>%D<label>days</label></li><li>%H<label>hours</label></li><li>%M <label>minutes</label></li><li>%S<label>seconds</label></li>"));
		});
	</script>';
}
/*************************************
****** Column layout shortcodes ******
**************************************/
function anps_content_half_func( $atts,  $content ) {
	extract( shortcode_atts( array(
		'id' => '',
        'class' => ''
	), $atts ) );
    $content = do_shortcode( shortcode_unautop( $content ) );
    if ( '</p>' == substr( $content, 0, 4 )
    and '<p>' == substr( $content, strlen( $content ) - 3 ) )
    $content = substr( $content, 4, strlen( $content ) - 7 );

    if ( $id == "first" ) {
        return '<div class="row">
                <div class="col-md-6 ' . $class . '">' . $content . '</div>';
    }
    elseif ( $id == "last" ) {
        return '<div class="col-md-6 ' . $class . '">' . $content . '</div>
                </div>';
    }
    else {
        return '<div class="col-md-6 ' . $class . '">' . $content . '</div>';
    }
}
function anps_content_third_func( $atts,  $content ) {
	extract( shortcode_atts( array(
		'id' => '',
        'class' => ''
	), $atts ) );
    $content = do_shortcode( shortcode_unautop( $content ) );
    if ( '</p>' == substr( $content, 0, 4 )
    and '<p>' == substr( $content, strlen( $content ) - 3 ) )
    $content = substr( $content, 4, strlen( $content ) - 7 );
    if ( $id == "first" ) {
        return '<div class="row">
                <div class="col-sm-4 ' . $class . '">' . $content . '</div>';
    }
    elseif ( $id == "last" ) {
        return '<div class="col-sm-4 ' . $class . '">' . $content . '</div>
                </div>';
    }
    else {
        return '<div class="col-sm-4 ' . $class . '">' . $content . '</div>';
    }
}
function anps_content_two_third_func( $atts,  $content ) {
	extract( shortcode_atts( array(
		'id' => '',
        'class' => ''
	), $atts ) );
    $content = do_shortcode( shortcode_unautop( $content ) );
    if ( '</p>' == substr( $content, 0, 4 )
    and '<p>' == substr( $content, strlen( $content ) - 3 ) )
    $content = substr( $content, 4, strlen( $content ) - 7 );
    if ( $id == "first" ) {
        return '<div class="row">
                <div class="col-sm-8 ' . $class . '">' . $content . '</div>';
    }
    elseif ( $id == "last" ) {
        return '<div class="col-sm-8 ' . $class . '">' . $content . '</div>
                </div>';
    }
    else {
        return '<div class="col-sm-8 ' . $class . '">' . $content . '</div>';
    }
}
function anps_content_quarter_func( $atts,  $content ) {
	extract( shortcode_atts( array(
		'id' => '',
        'class' => ''
	), $atts ) );
    $content = do_shortcode( shortcode_unautop( $content ) );
    if ( '</p>' == substr( $content, 0, 4 )
    and '<p>' == substr( $content, strlen( $content ) - 3 ) )
    $content = substr( $content, 4, strlen( $content ) - 7 );
    if ( $id == "first" ) {
        return '<div class="row">
                <div class="col-md-3 ' . $class . '">' . $content . '</div>';
    }
    elseif ( $id == "last" ) {
        return '<div class="col-md-3 ' . $class . '">' . $content . '</div>
                </div>';
    }
    else {
        return '<div class="col-md-3 ' . $class . '">' . $content . '</div>';
    }
}
function anps_content_two_quarter_func( $atts,  $content ) {
	extract( shortcode_atts( array(
		'id' => '',
        'class' => ''
	), $atts ) );
    $content = do_shortcode( shortcode_unautop( $content ) );
    if ( '</p>' == substr( $content, 0, 4 )
    and '<p>' == substr( $content, strlen( $content ) - 3 ) )
    $content = substr( $content, 4, strlen( $content ) - 7 );
    if ( $id == "first" ) {
        return '<div class="row">
                <div class="col-md-6 ' . $class . '">' . $content . '</div>';
    }
    elseif ( $id == "last" ) {
        return '<div class="col-md-6 ' . $class . '">' . $content . '</div>
                </div>';
    }
    else {
        return '<div class="col-md-6 ' . $class . '">' . $content . '</div>';
    }
}
function anps_content_three_quarter_func( $atts,  $content ) {
	extract( shortcode_atts( array(
		'id' => '',
        'class' => ''
	), $atts ) );
    $content = do_shortcode( shortcode_unautop( $content ) );
    if ( '</p>' == substr( $content, 0, 4 )
    and '<p>' == substr( $content, strlen( $content ) - 3 ) )
    $content = substr( $content, 4, strlen( $content ) - 7 );
    if ( $id == "first" ) {
        return '<div class="row">
                <div class="col-md-9 ' . $class . '">' . $content . '</div>';
    }
    elseif ( $id == "last" ) {
        return '<div class="col-md-9 ' . $class . '">' . $content . '</div>
                </div>';
    }
    else {
        return '<div class="col-md-9 ' . $class . '">' . $content . '</div>';
    }
}
/*************************************
**** END Column layout shortcodes ****
**************************************/
/* Icon shortcode */
function anps_icon_func( $atts,  $content ) {
	extract( shortcode_atts( array(
            'url' => '',
            'target' => '_self',
            'icon' => '',
            'title' => '',
            'subtitle' => '',
            'position' => '',
            'class' => ''
        ), $atts ) );

    if($class=="style-2") {
        switch($position) {
            case "": $position = "icon-left"; break;
            case "left": $position = "icon-left"; break;
            case "right": $position = "icon-right"; break;
        }
    } else {
        $position = "";
    }

    if( $subtitle ) {
        $subtitle = '<h3 class="style-2">' . $subtitle . '</h3>';
    }

    if($url) {
        return '<div class="icon '.$class.' '.$position.'">
                    <a href="'.esc_url($url).'" target="'.$target.'">
                        <span class="fa fa-'.$icon.'"></span>
                        <h2>'.$title.'</h2>
                        '.$subtitle.'
                    </a>
                    <p>'.$content.'</p>
                </div>';
    } else {
        return '<div class="icon '.$class.' '.$position.'">
                    <div>
                        <span class="fa fa-'.$icon.'"></span>
                        <h2>'.$title.'</h2>
                        '.$subtitle.'
                    </div>
                    <p>'.$content.'</p>
                </div>';
    }

}
/* Quote */
function anps_quote_func( $atts,  $content ) {
    extract( shortcode_atts( array(
        'style' => "style-1"
    ), $atts ) );
    return '<blockquote class="'.$style.'"><p>' . $content . '</p></blockquote>';
}
/* Color (mark) */
function anps_color_func( $atts,  $content ) {
    extract( shortcode_atts( array(
            'style' => '',
            'custom' => ''
        ), $atts ) );
    $custom = ' style="color: ' . $custom . '"';
    if( $style && $style != "" ) {
        return '<span' . $custom . ' class="mark ' . $style . '">' . do_shortcode($content) . '</span>';
    } else {
        return '<span' . $custom . ' class="mark">' . do_shortcode($content) . '</span>';
    }
}
/* Google maps */
$google_maps_counter = 0;
function anps_google_maps_func( $atts,  $content ) {
    global $google_maps_counter;
    $google_maps_counter++;
    extract( shortcode_atts( array(
        'zoom'     => '15',
        'scroll'   => '',
        'height'   => '550',
        'map_type' => 'ROADMAP',
    ), $atts ) );
    $scroll_option = "true";
    if($scroll==true) {
        $scroll_option = "false";
    }
    wp_enqueue_script('gmap3_link');
    wp_enqueue_script('gmap3');
    return "<div class='map' id='map$google_maps_counter' style='height: {$height}px;' data-type='$map_type' data-zoom='$zoom' data-scroll='{$scroll_option}' data-icon='" . get_template_directory_uri() . "/images/gmap/map-pin.png" . "' data-address='" . $content .  "'></div>";
}
/* Vimeo */
function anps_vimeo_func( $atts,  $content ) {
    return '<div class="video-wrapper"><iframe src="https://player.vimeo.com/video/' . $content . '" width="320" height="240" style="border: none !important"></iframe></div>';
}
/* Youtube */
function anps_youtube_func( $atts,  $content ) {
    return '<div class="video-wrapper"><iframe src="https://www.youtube.com/embed/' . $content . '?wmode=transparent" width="560" height="315" style="border: none !important"></iframe></div>';
}
/* Button */
global $button_counter;
$button_counter = 0;
function anps_button_func( $atts,  $content ) {
    extract( shortcode_atts( array(
        'link'       => '',
        'target'     => '_self',
        'size'       => 'small',
        'style_button'      => 'style-1',
        'color'      => '',
        'background' => '',
        'color_hover' => '',
        'background_hover' => '',
        'icon'=>''
    ), $atts ) );
    global $button_counter;

    $style_attr = "";
    if($color != '') {
        $style_attr .= "color: " . $color . "; border-color: " . $color . ";";
    }
    if($background) {
        $style_attr .= "background-color: " . $background . ";";
        if( $style_button == 'style-3' ) {
            $style_attr .= "border-color: " . $background . ";";
        }
    }
    if ( $target != '' ) {
        $target = ' target="' . $target . '"';
    }

    switch($size) {
        case "large": $size = "btn-lg"; break;
        case "medium": $size = "btn-md"; break;
        case "small": $size = "btn-sm"; break;
    }

    $icon_class = "";
    if($icon) {
        $icon_class = "<span class='fa fa-".$icon."'></span>";
    }

    $style_id = "custom-id-".$button_counter;
    $button_counter++;
    $style_css='';
    if( !$link ) {
        $style_css .= '<button class="btn ' . $size . ' ' . $style_button . '" id="'.$style_id.'" style="'.$style_attr.'">' .$icon_class.$content . '</button>';
    } else {
        $style_css .= '<a' . $target . ' href="' . esc_url($link) . '" class="btn ' . $size . ' ' . $style_button . '" id="'.$style_id.'" style="'.$style_attr.'">' . $icon_class.$content . '</a>';
    }
    return $style_css;
}
/* Error 404 */
function anps_error_404_func( $atts,  $content ) {
	extract( shortcode_atts( array(
            'title' => '',
            'sub_title' => ''
    ), $atts ) );

	return '<div class="error-404">
                    <h1>'.$title.'</h1>
                    <h2>'.$sub_title.'</h2>
                    <a href="javascript:javascript:history.go(-1)" class="btn btn-wide">'.$content.'</a>
                </div>';
}
/* Alert */
function anps_alert_func($atts, $content) {
    extract( shortcode_atts( array(
        'type' => ''
    ), $atts ) );
    wp_enqueue_script('alert');
    switch($type) {
        case "":
            $type_class = "";
            $icon = "bell-o";
            break;
        case "warning":
            $type_class = " alert-warning";
            $icon = "exclamation";
            break;
        case "info":
            $type_class = " alert-info";
            $icon = "info";
            break;
        case "success":
            $type_class = " alert-success";
            $icon = "check";
            break;
        case "useful":
            $type_class = " alert-useful";
            $icon = "lightbulb-o";
            break;
        case "normal":
            $type_class = " alert-normal";
            $icon = "hand-o-right";
            break;
    }
    return '<div class="alert'.$type_class.'" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<i class="fa fa-'.$icon.'"></i> '.$content.'
            </div>';
}
/* Dropcaps */
function anps_dropcaps_func($atts, $content) {
    extract( shortcode_atts( array(
                'style' => ''
        ), $atts ) );
    $style_class = "";
    if($style) {
        $style_class = " style-2";
    }
    return '<p class="dropcaps'.$style_class.'">'.$content.'</p>';
}
/* Load VC shortcodes support */
function remove_wpautop($content, $autop = false) {
  if($autop) { // Possible to use !preg_match('('.WPBMap::getTagsRegexp().')', $content)
      $content = wpautop(preg_replace('/<\/?p\>/', "\n", $content)."\n");
  }
  return do_shortcode( shortcode_unautop($content) );
}
/* Google maps */
$google_maps_counter = 0;
function anps_google_maps_advanced_func( $atts,  $content ) {
    global $google_maps_counter;
    $google_maps_counter++;
    extract( shortcode_atts( array(
        'zoom'     => '15',
        'scroll'   => '',
        'height'   => '550',
        'map_type' => 'ROADMAP',
        'style'   => ''
    ), $atts ) );
    if(isset($style) && $style!='') {
        $style = str_replace('``', '"', $style);
        $style = str_replace('`{`', '[', $style);
        $style = str_replace('`}`', ']', $style);
        $style = str_replace('`', '', $style);
        $style = str_replace('<br />', '', $style);
    } else {
        $style = '[{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]';
    }
    $scroll_option = "true";
    if($scroll==true) {
        $scroll_option = "false";
    }
    preg_match_all( '#\](.*?)\[/google_maps_advanced_item]#', $content, $matches);
    $location = $matches[1][0];
    wp_enqueue_script('gmap3_link');
    wp_enqueue_script('gmap3');
    return "<div class='map' data-styles='{$style}' id='map$google_maps_counter' style='height: {$height}px;' data-type='$map_type' data-zoom='$zoom' data-scroll='{$scroll_option}' data-markers='" . do_shortcode($content) . "'></div>";
}
function anps_google_maps_advanced_item( $atts,  $content ) {
    extract( shortcode_atts( array(
        'info'          => '',
        'pin'           => '',
        'marker_center' => '',
    ), $atts ) );

    $info = preg_replace('/[\n\r]+/', "", $info);

    if(isset($pin) && $pin!="") {
        $pin_icon = wp_get_attachment_image_src($pin, 'full');
        $pin_icon = $pin_icon[0];
    } else {
        $pin_icon = get_template_directory_uri()."/images/gmap/map-pin.png";
    }

    return '{ "address": "' . $content . '",  "center": "' . $marker_center . '", "data": "' . $info . '", "options": { "icon": "' . $pin_icon . '" } }|';
}
/* Section */
function anps_section_func($atts, $content) {
    return "<div class='container'>
                <div class='row'>
                    <div class='col-md-12'>".
                        do_shortcode($content)."
                    </div>
                </div>
            </div>";
}
/* VC single image */
function anps_vc_single_image($atts, $content) {
    extract( shortcode_atts( array(
        'image' => '',
        'border_color' => '',
        'img_link_target' => '',
        'img_size' => '',
        'el_class' => ''
    ), $atts ) );

    if($image) {
        $image_src = wp_get_attachment_image_src($image, 'full');
        $image_src = $image_src[0];
    }
    $data = "";
    $data .= "<img src='".$image_src."' />";
    return $data;
}
/* VC layer slider */
function anps_vc_layer_slider($atts, $content) {
    return do_shortcode("[layerslider id='".$atts['id']."']");
}
/* VC rev slider */
function anps_vc_rev_slider($atts, $content) {
    return do_shortcode("[rev_slider id='".$atts['alias']."']");
}
/* VC Tabs */
function vc_anps_tabs_func ($atts, $content = null) {
    if(!isset($atts['type'])) {
        $atts['type'] = "";
    } else {
        $atts['type'] = $atts['type'];
    }
    $content2 = str_replace("vc_tab", "tab", $content);
    return do_shortcode("[tabs type='".$atts['type']."']".$content2."[/tabs]");
}
/* Logos */
function anps_logos_func( $atts,  $content ) {
    return "<ul class='logos'>".do_shortcode($content)."</ul>";
}
/* Single logo */
function anps_logo_func( $atts,  $content ) {
    extract( shortcode_atts( array(
        'url' => '',
        'alt' => '',
        'image_u' => '',
        'image_u_hover' => '',
        'img_hover' => '',
        'alt_hover' => ''
    ), $atts ) );
    if($image_u) {
        $content = wp_get_attachment_image_src($image_u, 'full');
        $content = $content[0];
    }

    if($image_u_hover) {
        $img_hover = wp_get_attachment_image_src($image_u_hover, 'full');
        $img_hover = $img_hover[0];
    }
    if($url) {
        return "<li><a href='".esc_url($url)."' target='_blank'><img src='".$content."' alt='".$alt."'><span class='hover'><img src='".$img_hover."' alt='".$alt_hover."'></span></a></li>";
    } else {
        return "<li><span><img src='".esc_url($content)."' alt='".$alt."'><span class='hover'><img src='".$img_hover."' alt='".$alt_hover."'></span></span></li>";
    }
}
/* List */
global $list_number;
$list_number = false;
function anps_list_func($atts, $content) {
    extract( shortcode_atts( array(
        'class' => ''
    ), $atts ) );

    global $list_number;

    if( $class == "number" ) {
        $list_number = true;
        $return = "<ol class='list'>".do_shortcode($content)."</ol>";
        $list_number = false;
        return $return;
    }
    return "<ul class='list ".$class."'>".do_shortcode($content)."</ul>";
}
/* List item */
function anps_list_item_func($atts, $content) {
    global $list_number;
    if($list_number) {
        return "<li><span>".$content."</span></li>";
    } else {
        return "<li>".$content."</li>";
    }
}
/* Social icons */
function anps_social_icons_func( $atts,  $content ) {
    return "<ul class='socialize'>".do_shortcode($content)."</ul>";
}
/* Single social icon */
function anps_social_icon_item_func( $atts,  $content ) {
    extract( shortcode_atts( array(
            'url' => '#',
            'icon' => '',
            'target' => '_blank'
        ), $atts ) );
        return "<li><a href='".esc_url($url)."' target='".$target."' class='fa fa-".$icon."'></a></li>";
}
/* Statement */
function anps_statement_func( $atts,  $content ) {
    extract( shortcode_atts( array(
            'parallax' => 'false',
            'parallax_overlay' => 'false',
            'image' => '',
            'color' => '',
            'container' => 'false',
            'slug' => '',
            'image_u' => ''
        ), $atts ) );
    if($image_u) {
        $image = wp_get_attachment_image_src($image_u, 'full');
        $image = $image[0];
    }
    $parallax_class = "";
    $parallax_attr = "";
    if($parallax=="true") {
        $parallax_class = " parallax parallax-window";
        $parallax_attr = " data-type='background' data-speed='5'";
    }
    $parallax_overlay_class = "";
    if($parallax_overlay=="true") {
        $parallax_overlay_class = " parallax-overlay";
    }
    $containe_class = "";
    $container_before = "";
    $container_after = "";
    $container_class='';
    if($container=="true") {
        $container_before = '<div class="container text-center">';
        $container_after = '</div>';
    }
    $style = '';
    if($image) {
        $style = "background-image: url('$image');";
    } elseif($color) {
        $style = "background-color: $color;";
    }
    return '<section'.$parallax_attr.' class="statement'.$parallax_class.$parallax_overlay_class.'" style="'.$style.'">'.$container_before.do_shortcode($content).$container_after.'</section>';
}
/* END statement */
/* Tabs shortcodes */
global $tabs_counter, $indiv_tab_counter;
$tabs_counter = 0;
$indiv_tab_counter = 0;
function anps_tabs_func( $atts,  $content ) {
    extract( shortcode_atts( array(
        'type' => ''
    ), $atts ) );
    wp_enqueue_script('tab');
    global $tabs_counter, $indiv_tab_counter, $tabs_single;
    $tabs_counter++;
    $sub_tabs_counter = 1;
    $indiv_tab_counter = 0;
    $tabs_single = 0;
    /* Everything inside [tab] shortcode */
    preg_match_all( '#\[tab(.*?)\]#', $content, $matches);
    if ( isset($matches[1]) ) { $tab_titles = $matches[1]; }
    $class = "";
    $class_before = "";
    $class_after = "";
    $class_content = "";
    if($type == 'vertical') {
        $class = ' vertical';
        $class_before = "<div class='col-2-5'>";
        $class_after = "</div>";
        $class_content = " col-9-5";
    }
    $tabs_menu = '';
    $tabs_menu .= $class_before;
    $tabs_menu .= '<ul class="nav nav-tabs'.$class.'" id="tab-' . $tabs_counter . '">';
    $i=0;
    foreach ( $tab_titles as $tab ) {
        preg_match_all( '/title="(.*?)\"/', $tab, $title_match);
        preg_match_all( '/icon="(.*?)\"/', $tab, $icon_match);
        if(isset($icon_match[1][0])) {
            $icon[$i] = " <i class='fa fa-".$icon_match[1][0]."'></i>";
        } else {
            $icon[$i] = "";
        }
        if( $sub_tabs_counter == 1 ) {
            $tabs_menu .= '<li class="active"><a data-toggle="tab" href="#tab' . $tabs_counter . '-' . $sub_tabs_counter . '">' . $title_match[1][0].$icon[$i] . '</a></li>';
        } else {
            $tabs_menu .= '<li><a data-toggle="tab" href="#tab' . $tabs_counter . '-' . $sub_tabs_counter . '">' . $title_match[1][0].$icon[$i] . '</a></li>';
        }
        $i++;
        $sub_tabs_counter++;
    }
    $tabs_menu .= '</ul>';
    $tabs_menu .= $class_after;
    return $tabs_menu . '<div class="tab-content'.$class_content.'">' . do_shortcode($content) . '</div>';
}
/* Tab */
function anps_tab_func( $atts,  $content ) {
    extract( shortcode_atts( array(
        "title" => "",
        "icon" => ""
    ), $atts ) );
    global $tabs_counter, $tabs_single;
    $active = "";
    if( $tabs_single == 0 ) {
        $active = " active";
    }
    //$content = str_replace('&nbsp;', '<p class="blank-line clearfix"><br /></p>', $content);
    $tabs_single++;
    return '<div id="tab' . $tabs_counter . '-' . $tabs_single . '" class="tab-pane' . $active . '">' . do_shortcode( $content ) . '</div>';
}
$accordion_counter = 0;
$accordion_opened = false;
function anps_accordion_func( $atts,  $content ) {
    extract( shortcode_atts( array(
        "opened" => "false",
        'style' => ''
    ), $atts ) );
    wp_enqueue_script('collapse');
    global $accordion_counter, $accordion_opened;
    $accordion_counter++;
    if($opened=="true") {
        $accordion_opened = true;
    }
    $style_class="";
    if($style=="style-2") {
        $style_class = " style-2 collapsed";
    }
    return '<div class="panel-group'.$style_class.'" id="accordion' . $accordion_counter . '">' .  do_shortcode($content) . '</div>';
}
$accordion_item_counter = 0;
function anps_accordion_item_func( $atts,  $content ) {
    extract( shortcode_atts( array(
            'title' => ''
    ), $atts ) );
    $opened_class = "";
    global $accordion_item_counter, $accordion_opened;
    if( $accordion_opened ) {
        $opened_class = " in";
        $closed_class = "";
        $accordion_opened = false;
    } else {
        $closed_class = " class='collapsed'";
    }
    $accordion_item_counter++;
    return '<div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" '.$closed_class.' href="#collapse' . $accordion_item_counter . '">' . $title . '</a>
                    </h4>
                </div>
                <div id="collapse' . $accordion_item_counter . '" class="panel-collapse collapse'.$opened_class.'">
                    <div class="panel-body">' .  do_shortcode($content) . '</div>
                </div>
            </div>';
}
/* Contact info */
function anps_contact_info_func( $atts,  $content ) {
    return "<ul class='contact-info'>".do_shortcode($content)."</ul>";
}
/* Contact info item */
function anps_contact_info_item_func( $atts,  $content ) {
    extract( shortcode_atts( array(
        'icon' => ''
    ), $atts ) );
    return "<li><i class='fa fa-".$icon."'></i>".$content."</li>";
}
/* Awards */
function anps_awards_func( $atts,  $content ) {
    $data = '';
    $data .= "<div class='awards owl-carousel'>";
        $data .= do_shortcode($content);
    $data .= '</div>';
    $data .= "<div class='awards-nav'>";
        $data .= '<button class="owlprev award-prev">' . anps_svg('arrow2-l') . '</button>';
        $data .= '<button class="owlnext award-next">' . anps_svg('arrow2-r') . '</button>';
    $data .= '</div>';
    return $data;
}
/* Awards item */
function anps_awards_item_func( $atts,  $content ) {
    extract( shortcode_atts( array(
        'image_u' => '',
        'title' => ''
    ), $atts ) );
    $image = '';
    if($image_u != '') {
        $image = wp_get_attachment_image($image_u, 'full');
    }
    $data = '';
    $data .= '<div class="award">';
        $data .= $image;
        $data .= '<div class="award__title">' . $title . '</div>';
        $data .= '<div class="award__desc">' . $content . '</div>';
    $data .= '</div>';
    return $data;
}
/* Faq */
$faq_counter = 0;
function anps_faq_func($atts, $content) {
    wp_enqueue_script('collapse');
    global $faq_counter;
    $faq_counter++;
    return "<div class='panel-group faq' id='accordion".$faq_counter."'>".do_shortcode($content)."</div>";
}
/* Faq item */
$faq_item_counter = 0;
function anps_faq_item_func($atts, $content) {
    extract( shortcode_atts( array(
        'title' => '',
        'answer_title' => ''
    ), $atts ) );
    global $faq_counter;
    global $faq_item_counter;
    $faq_item_counter++;
    $faq_data = "<div class='panel'>";
    $faq_data .= "<div class='panel-heading'>";
    $faq_data .= "<h4 class='panel-title'>";
    $faq_data .= "<a class='collapsed' data-toggle='collapse' data-parent='#accordion".$faq_counter."' href='#collapse".$faq_item_counter."'>".$title."</a>";
    $faq_data .= "</h4>";
    $faq_data .= "</div>";
    $faq_data .= "<div id='collapse".$faq_item_counter."' class='panel-collapse collapse'>";
    $faq_data .= "<div class='panel-body'>";
    $faq_data .= "<h4>".$answer_title."</h4>";
    $faq_data .= "<p>".$content."</p>";
    $faq_data .= "</div>";
    $faq_data .= "</div>";
    $faq_data .= "</div>";
    return $faq_data;
}
/* Pricing table */
function anps_pricing_table_func( $atts,  $content ) {
    extract( shortcode_atts( array(
            'title' => '',
            'currency' => '&euro;',
            'price' => '0',
            'period' => '',
            'button_text' => '',
            'button_url' => '',
            'featured' => ""
        ), $atts ) );

        if( $button_text != '' ) {
        	$button_text = '<li><a class="btn btn-md" href="' . esc_url($button_url) . '">' . $button_text . '</a></li>';
        }
        $exposed_class = "";
        if($featured) {
            $exposed_class = " exposed";
        }
        $pricing_data = "<div class='pricing-table$exposed_class'>";
        $pricing_data .= "<header>";
        $pricing_data .= "<h2>".$title."</h2>";
        $pricing_data .= "<span class='currency'>".$currency."</span><span class='price'>".$price."</span>";
        if($period) {
            $pricing_data .= "<div class='date'>".$period."</div>";
        }
        $pricing_data .= "</header>";
        $pricing_data .= "<ul>".do_shortcode($content).$button_text."</ul>";
        $pricing_data .= "</div>";
        return $pricing_data;
}
/* END Pricing table */
/* Pricing item */
function anps_pricing_table_item_func( $atts,  $content ) {
    extract( shortcode_atts( array(), $atts ) );
    return '<li>'.$content ."</li>";
}
/* Testimonials */
global $testimonial_counter;
$testimonial_counter = 0;
function anps_testimonials($atts,  $content) {
        extract( shortcode_atts( array(
            'style' => ''
        ), $atts ) );
        $testimonials_number = substr_count($content, "[testimonial");
        $class = "testimonials";
        $data_return = "";
        $style_class = "";
        $randomid = substr( md5(rand()), 0, 7);

        if($style=="white") {
            $class="testimonials white";
        }
        if($testimonials_number>"1") {
            $class = "carousel-inner";
            $data_return .= "<div id='".$randomid."' class='carousel testimonials slide' data-ride='carousel'>";
        }
        global $testimonial_counter;
        $testimonial_counter = 0;
        $data_return .= '<div class="'.$class.'">'.do_shortcode($content).'</div>';
        if($testimonials_number>"1") {
            $data_return .= '<a class="left carousel-control" href="#'.$randomid.'" data-slide="prev">';
            $data_return .= '<span class="fa fa-chevron-left"></span>';
            $data_return .= "</a>";
            $data_return .= '<a class="right carousel-control" href="#'.$randomid.'" data-slide="next">';
            $data_return .= '<span class="fa fa-chevron-right"></span>';
            $data_return .= '</a>';
            $data_return .= "</div>";
        }
        return $data_return;
}
/* Testimonial item */
$testimonial_counter = 0;
function anps_testimonial($atts,  $content) {
        extract( shortcode_atts( array(
            'image' => '',
            'image_u' => "",
            "user_name" => "",
            "user_url" => ""
        ), $atts ) );
        global $testimonial_counter;
        $testimonial_counter++;
        $class = "";
        if($testimonial_counter=="1") {
            $class = " active";
        }
        //var_dump($testimonial_counter);
        if($image_u) {
            $image = wp_get_attachment_image_src($image_u, 'full');
            $image = $image[0];
        }
        $data = "";
        $data .= "<blockquote class='item".$class."'>";
        $data .= "<header>";
        if($image) {
            $data .= "<img src='".$image."' >";
        }
        $data .= "</header>";
        $data .= "<p>".$content."</p>";
        $data .= "<cite>";
        $data .= $user_name;
        if($user_url) {
            $data .= " / ";
            $data .= "<a href='".esc_url($user_url)."' target='_blank'>".$user_url."</a>";
        }
        $data .= "</cite>";
        $data .= "</blockquote>";
        return $data;
}
/* Table */
function anps_table_func( $atts,  $content ) {
    return "<div class='scroll-x'><table class='table'>".do_shortcode($content)."</table></div>";
}
/* thead */
function anps_table_thead_func( $atts,  $content ) {
    return "<thead>".do_shortcode($content)."</thead>";
}
/* tbody */
function anps_table_tbody_func( $atts,  $content ) {
    return "<tbody>".do_shortcode($content)."</tbody>";
}
/* tfoot */
function anps_table_tfoot_func( $atts,  $content ) {
    return "<tfoot>".do_shortcode($content)."</tfoot>";
}
/* data row */
function anps_table_row_func( $atts,  $content ) {
    return "<tr>".do_shortcode($content)."</tr>";
}
/* data column */
function anps_table_td_func( $atts,  $content ) {
    return "<td>".do_shortcode($content)."</td>";
}
/* data head column */
function anps_table_th_func( $atts,  $content ) {
    return "<th>".do_shortcode($content)."</th>";
}
/* Heading */
function anps_heading_func( $atts,  $content ) {
    extract( shortcode_atts( array(
        'size'          => '1',
        'heading_size'  => 'md',
        'heading_class' => 'heading',
        'style'         => 'classic',
        'h_class'       => "",
        'h_id'          => "",
        'text_color'    => '',
        'text_size'     => ''
    ), $atts ) );

    $id = '';
    if($h_id) {
        $id = " id='".$h_id."'";
    }

    $class = 'title';

    $title_style = anps_style_attr(array(
        'color'     => $text_color,
        'font-size' => $text_size . 'px',
    ));

    switch($heading_class) {
        case "content_heading" : $class .= ' title--content-heading'; break;
        case "heading" : $class .= ' title--middle'; break;
        case "style-3" : $class .= ' title--left'; break;
    }

    $class .= ' title--style-' . $style;
    $class .= ' title--' . $heading_size;

    return '<h' . $size . ' class="' . $class . '" ' . $id . $title_style . '><span>' . $content . '</span></h'.$size.'>';
}
/* Icon modern */
function anps_icon_modern_func($atts,  $content) {
    extract( shortcode_atts( array(
        'icon_type' => 'fontawesome',
        'icon' => '',
        'icon_openiconic' => '',
        'icon_typicons' => '',
        'icon_entypo' => '',
        'icon_linecons' => '',
        'icon_monosocial' => '',
        'icon_anps_icons' => '',
        'custom_image' => '',
        'title' => '',
        'link' => '',
        'target' => '_self',
        'icon_style' => 'white',
        'icon_color' => '',
        'icon_border_color' => '',
        'icon_bg_color' => '',
        'title_color' => '',
        'text_color' => '',
    ), $atts ) );
    /* Colors */
    $icon_css_style = anps_style_attr(array('color' => $icon_color, 'background-color' => $icon_bg_color, 'border-color' => $icon_border_color));
    $border_css_style = anps_style_attr(array('border-color' => $icon_border_color));
    $stroke_css_style = anps_style_attr(array('stroke' => $icon_border_color));
    $fill_css_style = '';
    if($icon_style != 'white') {
        $fill_css_style = anps_style_attr(array('fill' => $icon_border_color));
    }
    $title_css_style = anps_style_color($title_color);
    $text_css_style = anps_style_color($text_color);

    $data = '';
    $icon_media = '';
    $icon_class = $icon;
    vc_icon_element_fonts_enqueue($icon_type);
    if ($icon_type !== 'fontawesome' && $icon_type !== 'anps_icons') {
        $icon_type_name = 'icon_' . $icon_type;

        $icon_class = $$icon_type_name;
    }
    if ($custom_image !== '') {
        $icon_media = '<div class="icon-modern__image">'.wp_get_attachment_image($custom_image, 'full').'</div>';
    } else if ($icon_anps_icons !== '') {
        $icon_media = '<div class="icon-modern__svg">'.anps_svg(str_replace('anps-icon-', '', $icon_anps_icons)).'</div>';
    } else {
        $icon_media = '<i class="icon-modern__icon ' . $icon_class . '"></i>';
    }
    /* Check if link exists */
    if($link != '') {
        $data .= "<a class='icon-modern icon-modern--$icon_style' href='$link' target='$target'$border_css_style>";
    } else {
        $data .= "<div class='icon-modern icon-modern--$icon_style'$border_css_style>";
    }
    /* END Check if link exists */
        $data .= "<div class='icon-modern__media'$icon_css_style>";
            $data .= $icon_media;
            /* Display only on white style */
            if($icon_style == 'white') {
                $data .= '<svg' . $stroke_css_style . ' class="icon-modern__border" width="66" height="66" stroke-dasharray="194" viewPort="0 0 33 33" version="1.1" xmlns="http://www.w3.org/2000/svg">';
                    $data .= '<circle r="31" cx="33" cy="33"></circle>';
                $data .= '</svg>';
            }
        $data .= '</div>';
        if($title != '') {
            $data .= "<div class='icon-modern__title'$title_css_style>$title</div>";
        }
        if($content != '') {
            $data .= "<div class='icon-modern__desc'$text_css_style>$content</div>";
        }
    /* Check if link exists */
    if($link != '') {
            $data .= '<div' . $fill_css_style . ' class="icon-modern__arrow">'.anps_svg('arrow2-r').'</div>';
        $data .= '</a>';
    } else {
        $data .= '</div>';
    }
    /* END Check if link exists */
    return $data;
}
/* Empty space */
function anps_empty_space_func($atts, $content) {
    extract( shortcode_atts( array(
        'mobile' => '0',
        'tablet' => '0',
        'desktop' => '0',
        'large_desktop' => '0'
    ), $atts ) );
    return "<div class='empty' data-xs='$mobile' data-sm='$tablet' data-md='$desktop' data-lg='$large_desktop' style='height: $large_desktop;'></div>";
}
/* Image with lightbox*/
function anps_image_lightbox($atts, $content) {
    extract( shortcode_atts( array(
        'image_u' => '',
        'images_size' => 'full',
        'icon_color' => 'dark',
    ), $atts ) );
    wp_enqueue_script('prettyphoto');
    wp_enqueue_style('prettyphoto');
    if($image_u != '') {
        $image_full = wp_get_attachment_image_src($image_u, 'full');
        $image = wp_get_attachment_image($image_u, $images_size);
    }
    $data = '';
    $data .= "<div class='image-lightbox image-lightbox--$icon_color'>";
    $data .= "<a data-rel='prettyPhoto' class='images-lightbox__link prettyphoto' href='$image_full[0]'>";
    $data .= $image;
    $data .= '</a>';
    $data .= '</div>';
    return $data;
}
/* Image with lightbox*/

function anps_text_image_switch_func($atts, $content) {
    extract( shortcode_atts( array(
        'style' => 'white',
    ), $atts ) );

    $data = '';

    global $anps_text_image_counter, $anps_text_images_length;
    $anps_text_image_counter = 0;

    $anps_text_images_length = substr_count($content, '[anps_text_image_switch_item');

    $data .= '<div class="img-txt img-txt--' . $style . '">';
        $data .= '<div class="img-txt__content">';
        $data .= do_shortcode($content);
        $data .= '</div>';

        $data .= '<div class="img-txt__images"></div>';
    $data .= '</div>';

    return $data;
}

function anps_text_image_switch_item_func($atts, $content) {
    extract( shortcode_atts( array(
        'title' => '',
        'subtitle' => '',
        'image' => '',
        'link_url' => '',
        'link_text' => '',
    ), $atts ) );

    global $anps_text_image_counter, $anps_text_images_length;

    $item_class = 'img-txt__item';
    $image_class = 'img-txt__image';

    if ($anps_text_image_counter === 0) {
        $item_class .= ' img-txt__item--active';
        $image_class .= ' img-txt__image--active';
    }

    $data = '';

    $data .= '<div class="img-txt__item-wrap">';
        $data .= '<div class="' . $item_class . '">';
            $data .= '<div class="' . $image_class . '">' . wp_get_attachment_image($image, 'full') . '</div>';
            $data .= '<div class="img-txt__title">' . $title . '</div>';
            $data .= '<div class="img-txt__subtitle">' . $subtitle . '</div>';
            $data .= '<div class="img-txt__text">' . $content . '</div>';
            if ($link_url !== '' && $link_text !== '') {
                $data .= '<div class="img-txt__btns">';
                    $data .= '<a class="btn btn-md modern-2 img-txt__link" href="' . $link_url . '">' . $link_text . '</a>';
                    
                    if ($anps_text_images_length > 1) {
                        $data .= '<div class="img-txt__nav">';
                            $data .= '<button class="img-txt__btn img-txt__btn--prev">' . anps_svg('arrow2-l') . '</button>';
                            $data .= '<button class="img-txt__btn img-txt__btn--next">' . anps_svg('arrow2-r') . '</button>';
                        $data .= '</div>';
                    }
                $data .= '</div>';
            }
        $data .= '</div>';
    $data .= '</div>';

    $anps_text_image_counter += 1;

    return $data;
}

function anps_featured_modern_func($atts, $content) {
    extract( shortcode_atts( array(
        'title' => '',
        'image_u' => '',
        'link' => '',
        'style' => '',
    ), $atts ) );

    $data = '';

    $tag = 'div';
    $attr = '';

    if ($link !== '') {
        $tag = 'a';
        $attr = ' href="' . $link . '"';
    }

    $data .= '<div class="featured-m featured-m--' . $style . '">';
        $data .= '<' . $tag . $attr . ' class="featured-m__image">' . wp_get_attachment_image($image_u, 'full') . '</' . $tag . '>';
        $data .= '<' . $tag . $attr . ' class="featured-m__title">' . $title . '</' . $tag . '>';
        $data .= '<div class="featured-m__text">';
            $data .= $content;
            if ($link !== '') {
                $data .= '<a class="featured-m__link" href="' . $link . '">' . anps_svg('arrow2-r') . '</a>';
            }
        $data .= '</div>';
    $data .= '</div>';
    return $data;
}
