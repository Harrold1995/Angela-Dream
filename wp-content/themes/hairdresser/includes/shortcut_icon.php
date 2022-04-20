<?php 
	global $anps_media_data;
?>
<?php if( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ): ?>
	<?php if (isset($anps_media_data['favicon']) && $anps_media_data['favicon'] != "") : ?>
	    <link rel="shortcut icon" href="<?php echo esc_url($anps_media_data['favicon']); ?>" type="image/x-icon" />
	<?php endif; ?>
<?php endif; ?>