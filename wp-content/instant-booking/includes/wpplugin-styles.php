function wpdocs_styles_method() {
    wp_enqueue_style(
        'custom-um-style',
        plugin_dir_path(__FILE__) . 'includes/plugins/ultimate-member/ultimate-member.css'
    );
        $color = get_option('eri_um_account_menu_bg'); //E.g. #FF0000
        $custom_css = "
                .um-account-side li {
                        background: {$color} !important;
                }";
        wp_add_inline_style( 'custom-um-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_styles_method' );




add_action( 'init', 'getCssOptionsUM' );
function getCssOptionsUM(){
   // ACCOUNT PAGE: Menu Background Color
   if (get_option('eri_um_account_menu_bg') != '') {
       echo '<style>.um-account-side li { background: '.get_option('eri_um_account_menu_bg').' !important; }</style>';
   }
   // ACCOUNT PAGE: Menu Background Hover Color & Text Hover Color
   if (get_option('eri_um_account_menuh_bg') != '') {
       echo '<style>.um-account-side li:hover > a, .um-account-side li:hover > a .um-account-icontip {background: '.get_option('eri_um_account_menuh_bg').' !important; }</style>';
   }
   if (get_option('eri_um_account_menuh_txt') != '') {
       echo '<style>.um-account-side li:hover > a, .um-account-side li:hover > a .um-account-icontip { color: '.get_option('eri_um_account_menuh_txt').' !important; }</style>';
   }
}