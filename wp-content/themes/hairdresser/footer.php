 <?php
 echo anps_footer_banner();
 
$coming_soon = anps_get_option('', '0', 'coming_soon');
if((!$coming_soon || $coming_soon=="0") || is_super_admin()) {
    get_sidebar( 'footer' );
}
?>
</div>

<?php if(get_option('anps_to_top_button', '') == '1'): ?>
    <?php anps_scroll_top(get_option('anps_to_top_button_style', '1'), true); ?>
<?php endif; ?>

<?php anps_social_bar(); ?>

<input type="hidden" id="theme-path" value="<?php echo get_template_directory_uri(); ?>" />
<?php wp_footer(); ?>

</body>
</html>
