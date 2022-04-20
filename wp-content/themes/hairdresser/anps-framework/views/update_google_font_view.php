<?php 
include_once(get_template_directory() . '/anps-framework/classes/Style.php');

if (isset($_GET['save_font'])) {
    $style->update_gfonts();
}
?>
<form action="themes.php?page=theme_options&sub_page=theme_style_google_font&save_font" method="post">
    <div class="content-inner">
        <h3><?php esc_html_e("Update google fonts", 'hairdresser'); ?></h3>    
        <p>As we do not update google fonts automatically, you can update the google fonts with clicking the below button.</p>
        <center><input type="submit" class="dummy martop" value="<?php esc_html_e("Update google fonts", 'hairdresser'); ?>" /></center>
    </div>
</form>