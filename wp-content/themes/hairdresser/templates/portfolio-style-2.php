<?php
$hide_img = get_post_meta($post->ID, $key ='anps_hide_portfolio_img', $single = true );
if($hide_img==0) {
    echo anps_header_media_portfolio_single(get_the_ID(), 'style-2');
}
?>
<div class="col-md-12">
    <?php the_content(); ?>
</div>
