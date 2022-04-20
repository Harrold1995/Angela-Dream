<?php
global $counter_blog, $blog_columns, $anps_blog_style, $anps_blog_type;
/* get blog categories */
$post_categories = wp_get_post_categories(get_the_ID());
/* get the content */
if(get_option("rss_use_excerpt") == "0"){
    global $more;
    $more = 0;
    $content_text = get_the_content('');
    $content_text = apply_filters('the_content', $content_text);
} else {
    global $more;
    $more = 0;
    $content_text = get_the_excerpt();
}

$columns = $blog_columns;

if($columns==" col-md-3") {
    $image_class = "anps-blog-masonry-3-columns";
    $blog_col_num = 4;
} elseif($columns==" col-md-4") {
    $image_class = "anps-blog-masonry-3-columns";
    $blog_col_num = 3;
}
$sticky_class = "";
if(is_sticky(get_the_ID())) {
    $sticky_class = " post-sticky";
}

$post_class = implode(get_post_class('post post-style-' . $anps_blog_style . ' style-3' . $sticky_class), ' ');

$columns .= ' col-sm-6';

if ($anps_blog_type === 'masonry') {
    $post_class .= $columns;
}

$post_data = '';

if(anps_header_media(get_the_ID(), "anps-blog-grid")!="") {
    if ($anps_blog_type !== 'masonry') {
        $post_data .= "<div class='".$columns."'>";
    }
    $post_data .= "<article id='post-" . get_the_ID() . "' class='$post_class'>";
	$post_data .= "<header class='post__header'>";
    if(is_sticky(get_the_ID()) && strlen(anps_header_media(get_the_ID())) > 0 ) {
    $post_data .= "<div class='absolute stickymark'><div class='triangle-topleft hovercolor'></div><i class='nav_background_color fa fa-thumb-tack'></i></div>";
    }
	$post_data .= "<a class='post-hover' href='".get_permalink()."'>".anps_header_media(get_the_ID(), $image_class);
    if(get_option('anps_post_meta_date') != '1' && $anps_blog_style !== 'classic' && has_post_thumbnail()) {
       $post_data .= "<span class='post-date'>".get_the_date('M d')."</span>";
    }
    $post_data .= "</a>";


    if (is_sticky(get_the_ID()) && strlen(anps_header_media(get_the_ID(), $image_class)) < 1 ) {
    $post_data .= "<a href='".get_permalink()."' title='".get_the_title()."'><h2 class='post__title'><i class='fa fa-thumb-tack hovercolor'></i>&nbsp;".get_the_title()."</h2></a>";
     }
    else {
        $post_data .= "<a href='".get_permalink()."' title='".get_the_title()."'><h2 class='post__title'>".get_the_title()."</h2></a>";
    }
    if( get_option('anps_post_meta_date') != '1'  && $anps_blog_style === 'classic' ) {
	   $post_data .= "<span class='post-meta-date'>".get_the_date()."</span>";
	}
    if( get_option('anps_post_meta_comments') != '1' ) {
        if( get_option('anps_post_meta_date') != '1' && $anps_blog_style === 'classic' ) {
            $post_data .= " <span class='post-meta-divider'>/</span> ";
        }
        $post_data .= "<span class='post-meta-comments'>".get_comments_number()." ".esc_html__("comments", 'hairdresser')."</span>";
    }
    $post_data .= "</header>";
    $post_data .= "<div class='post-content'>";
    $post_data .= $content_text;
    if ($anps_blog_style !== 'classic') {
        $post_data .= '<a class="post-link" href="'.get_permalink().'">'.anps_svg('arrow2-r').'</a>';
    }
    $post_data .= "</div>";
    $post_data .= "</article>";
    if ($anps_blog_type !== 'masonry') {
        $post_data .= "</div>";
    }
} else {
    if ($anps_blog_type !== 'masonry') {
        $post_data = "<div class='".$columns."'>";
    }
    $post_data .= "<article id='post-" . get_the_ID() . "' class='$post_class'>";
	$post_data .= "<header>";
    if(is_sticky(get_the_ID()) && strlen(anps_header_media(get_the_ID())) > 0 ) {
    $post_data .= "<div class='absolute stickymark'><div class='triangle-topleft hovercolor'></div><i class='nav_background_color fa fa-thumb-tack'></i></div>";
    }
	if (is_sticky(get_the_ID()) && strlen(anps_header_media(get_the_ID(), $image_class)) < 1 ) {
    $post_data .= "<a href='".get_permalink()."' title='".get_the_title()."'><h2 class='post__title'><i class='fa fa-thumb-tack hovercolor'></i>&nbsp;".get_the_title()."</h2></a>";
     }
    else {
        $post_data .= "<a href='".get_permalink()."' title='".get_the_title()."'><h2 class='post__title'>".get_the_title()."</h2></a>";
    }
    if( get_option('anps_post_meta_date') != '1' ($anps_blog_style === 'classic' || !has_post_thumbnail())) {
       $post_data .= "<span class='post-meta-date'>".get_the_date()."</span>";
    }
    if( get_option('anps_post_meta_comments') != '1' ) {
        if( get_option('anps_post_meta_date') != '1'  && $anps_blog_style === 'classic' ) {
            $post_data .= " <span class='post-meta-divider'>/</span> ";
        }
        $post_data .= "<span class='post-meta-comments'>".get_comments_number()." ".esc_html__("comments", 'hairdresser')."</span>";
    }
    $post_data .= "</header>";
    $post_data .= "<div class='post-content'>";
    $post_data .= $content_text;
    if ($anps_blog_style !== 'classic') {
        $post_data .= '<a class="post-link" href="'.get_permalink().'">'.anps_svg('arrow2-r').'</a>';
    }
    $post_data .= "</div>";
    if ($anps_blog_type !== 'masonry') {
        $post_data .= "</div>";
    }
}
if($counter_blog%$blog_col_num==0) {
    $post_data .= "<div class='clearfix'></div>";
}
echo $post_data;
