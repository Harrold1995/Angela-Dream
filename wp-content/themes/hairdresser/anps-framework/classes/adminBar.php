<?php 

class AnpsAdminBar {
  
  public function __construct() {
      add_action( 'admin_bar_menu', array( $this, "themeoptions_links" ), 100 );
  }

  function add_root_menu($name, $id, $href = FALSE) {
    global $wp_admin_bar;
    if ( !is_super_admin() || !is_admin_bar_showing() )
        return;

    $wp_admin_bar->add_menu( array(
        'id'   => $id,
        'meta' => array(),
        'title' => $name,
        'href' => esc_url($href) ) );
  }

  function add_sub_menu($name, $id ,$link, $root_menu, $meta = FALSE) {
      global $wp_admin_bar;
      if ( ! is_super_admin() || ! is_admin_bar_showing() )
          return;
    
      $wp_admin_bar->add_menu( array(
          'id' => $id,
          'parent' => $root_menu,
          'title' => $name,
          'href' => esc_url($link),
          'meta' => $meta
      ) );
  }

  function themeoptions_links() {
      $this->add_root_menu( "Theme options", "hairdresser",admin_url('themes.php?page=theme_options'));
      $this->add_sub_menu( "Theme style", 'anps_style', admin_url('themes.php?page=theme_options&sub_page=theme_style') , "hairdresser" );
      $this->add_sub_menu( "Update google fonts", 'anps_gfonts', admin_url('themes.php?page=theme_options&sub_page=theme_style_google_font') , "hairdresser" );
      $this->add_sub_menu( "Custom fonts", 'anps_cfonts', admin_url('themes.php?page=theme_options&sub_page=theme_style_custom_font') , "hairdresser" );
      $this->add_sub_menu( "Custom css", 'anps_css', admin_url('themes.php?page=theme_options&sub_page=theme_style_custom_css') , "hairdresser" );
      $this->add_sub_menu( "Page layout", 'anps_settings',admin_url('themes.php?page=theme_options&sub_page=options'), "hairdresser" );
      $this->add_sub_menu( "Page setup", 'anps_setup',admin_url('themes.php?page=theme_options&sub_page=options_page_setup'), "hairdresser" );
      $this->add_sub_menu( "Logos & media", 'anps_logos',admin_url('themes.php?page=theme_options&sub_page=options_media'), "hairdresser" );
      if(function_exists('anps_portfolio')) {
        $this->add_sub_menu( "Dummy content", 'anps_content',admin_url('themes.php?page=theme_options&sub_page=dummy_content'), "hairdresser" );
      }
      $this->add_sub_menu( "Theme upgrade", 'anps_upgrade',admin_url('themes.php?page=theme_options&sub_page=theme_upgrade'), "hairdresser" );
  }

}
add_action( "init", "anps_themeOptionsMenuInit" );
function anps_themeOptionsMenuInit() {
    $theme_adminBar = new AnpsAdminBar();
}