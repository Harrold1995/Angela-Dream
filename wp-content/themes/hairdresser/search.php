<?php get_header(); ?>
<div class="container search-page">
    <?php if ( have_posts() ) : $num = wp_count_posts(); ?>
        <ol class="search-posts">
            <?php while ( have_posts() ) : the_post(); ?>
                <li>
                    <a href="<?php echo the_permalink(); ?>">
                        <h2><i class="fa fa-check-square-o"></i><?php the_title(); ?></h2>
                    </a>
                </li>
            <?php endwhile; ?>
        </ol>
        <?php  get_template_part('includes/pagination'); ?>
    <?php else : ?>
        <h2 class="no-results" style="color:#727272; font-size:27px; line-height:40px;"><?php esc_html_e('Sorry, no results found for:', 'hairdresser'); ?> <span><?php echo esc_attr($_GET['s']); ?></span><br/><?php esc_html_e('Try to refine your search query.', 'hairdresser'); ?></h2>
        <div class="row">
            <div class="text-center">
            <?php get_search_form() ?>
            </div>
            <script>
            jQuery( document ).ready(function() {
                jQuery('#searchform input#s').focus();
            });
            
            </script>
        </div>
    <?php endif; ?>
</div>
<?php get_footer(); ?>
