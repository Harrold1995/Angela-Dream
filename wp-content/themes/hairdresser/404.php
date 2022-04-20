<?php get_header(); ?>
<section class="container">
<?php
	if(isset($anps_page_data['error_page']) && $anps_page_data['error_page'] != '0') {
		query_posts('post_type=page&p=' . $anps_page_data['error_page']);
                
        while(have_posts()) { the_post();
            the_content();
        }
        
        wp_reset_query();
	} else {
		?>
			<h1 style="text-align: center;"><?php esc_html_e('It seems that something went wrong!', 'hairdresser'); ?></h1>
			<h6 style="text-align: center;"><?php esc_html_e('This page does not exist.', 'hairdresser'); ?></h6>
		<?php
	}
?>
</section>
<?php get_footer(); ?>