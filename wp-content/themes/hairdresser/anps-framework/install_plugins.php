<?php
require_once  get_template_directory() . '/anps-framework/class-tgm-plugin-activation.php';
add_action('tgmpa_register', 'anps_register_required_plugins');
function anps_register_required_plugins() {
    $plugins = array(
        array(
            'name' => 'Slider Revolution',
            'slug' => 'revslider',
            'source' => 'http://astudio.si/preview/plugins/revslider.zip',
            'external_url' => 'https://revolution.themepunch.com/',
        ),
        array(
            'name' => 'Contact form 7',
            'slug' => 'contact-form-7',
        ),
        array(
            'name' => 'Anps Theme plugin',
            'slug' => 'anps_theme_plugin',
            'source' => 'http://astudio.si/preview/plugins/hairdresser/anps_theme_plugin.zip',
            'required' => true,
        ),
        array(
            'name' => 'WPBakery Page Builder',
            'slug' => 'js_composer',
            'source' => 'http://astudio.si/preview/plugins/js_composer.zip',
            'required' => true,
            'external_url' => 'https://wpbakery.com/',
        ),
        array(
            'name' => 'WooCommerce',
            'slug' => 'woocommerce',
        ),
        array(
            'name' => 'Instagram Feed',
            'slug' => 'instagram-feed',
        ),
        array(
            'name' => 'Easy Appointments',
            'slug' => 'easy-appointments',
        ),
        array(
            'name' => 'Newsletter',
            'slug' => 'newsletter',
        ),
        array(
            'name' => 'Envato Market',
            'slug' => 'envato-market',
            'source' => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip', 
            'external_url' => 'https://envato.com/market-plugin/',
        ),
    );
    $config = array(
        'domain' => "hairdresser",
        'default_path' => '',
        'parent_slug' => 'themes.php',
        'menu' => 'install-required-plugins',
        'has_notices' => true,
        'is_automatic' => true,
        'message' => '',
        'strings' => array(
            'nag_type' => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
        )
    );
    tgmpa($plugins, $config);
}
