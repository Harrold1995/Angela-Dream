<?php get_header();
echo '<section class="container" id="site-content"><div class="row"><div class="col-md-9">';
if( have_posts() ) :
    while (have_posts()) : the_post();
        get_template_part( 'content', get_post_format() );
    endwhile;
    the_posts_pagination( array(
                    'prev_text' => '<i class="fa fa-angle-left"></i> ' . esc_html__( 'Previous ', 'hairdresser' ),
                    'next_text' => esc_html__( 'Next', 'hairdresser' ) . ' <i class="fa fa-angle-right"></i>',
                )
            );
endif;
?>
<?php
echo "</div>"; ?>
<aside class="sidebar sidebar--<?php echo get_option('anps_sidebar_style', 'classic'); ?> col-md-3">
    <ul>
        <?php dynamic_sidebar("sidebar"); ?>
    </ul>
</aside>
</div>
</section>
<?php get_footer(); ?>
