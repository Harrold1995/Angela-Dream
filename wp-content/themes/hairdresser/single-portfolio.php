<?php 
get_header();

$meta = get_post_meta(get_the_ID());
$num_of_sidebars = 0;
global $row_inner;
$row_inner = true;

/* Left Sidebar */

$left_sidebar = anps_get_option('', '', 'post_sidebar_left');

if( isset($meta['sbg_selected_sidebar']) && $meta['sbg_selected_sidebar'][0] != "0" ) {
    if( $meta['sbg_selected_sidebar'][0] == "-1" ) {
        $left_sidebar = false;
    } else {
        $left_sidebar = $meta['sbg_selected_sidebar'][0];
    }
}

if ( $left_sidebar ) {
    $num_of_sidebars++;
}

/* Right Sidebar */

$right_sidebar = anps_get_option('', '', 'post_sidebar_right');

if (isset($meta['sbg_selected_sidebar_replacement']) && $meta['sbg_selected_sidebar_replacement'][0] != "0") {
    if( $meta['sbg_selected_sidebar_replacement'][0] == "-1" ) {
        $right_sidebar = false;
    } else {
        $right_sidebar = $meta['sbg_selected_sidebar_replacement'][0];
    }
}

if( $right_sidebar ) {
    $num_of_sidebars++;
}

?>

<section class="container portfolio-single">
    <div class="row">
        <?php if ($left_sidebar != "0" && $left_sidebar != "-1" && $left_sidebar): ?>
            <aside class="sidebar sidebar--<?php echo get_option('anps_sidebar_style', 'classic'); ?> col-md-<?php if($num_of_sidebars == 1) { echo "3"; } else if($num_of_sidebars == 2) { echo "3"; } ?>">
                <ul>
                    <?php dynamic_sidebar($left_sidebar); wp_reset_query(); ?>
                </ul>
            </aside>
        <?php endif; ?>

        <?php while(have_posts()) : the_post();  ?>
            <div class="col-md-<?php echo 12-esc_attr($num_of_sidebars)*3; ?>">
                <div class="row">
                    <?php get_template_part( 'templates/portfolio', anps_get_option('', 'style-1', "portfolio_single")); ?>
                </div>    
            </div>
        <?php endwhile; ?>

        <?php if ($right_sidebar != "0" && $right_sidebar != "-1" && $right_sidebar): ?>
            <aside class="sidebar sidebar--<?php echo get_option('anps_sidebar_style', 'classic'); ?> col-md-<?php if($num_of_sidebars == 1) { echo "3"; } else if($num_of_sidebars == 2) { echo "3"; } ?>">
                <ul>
                    <?php dynamic_sidebar($right_sidebar); ?>
                </ul>
            </aside>
        <?php endif; ?>
    </div>
</section>

<?php
anps_portfolio_footer();

get_footer();