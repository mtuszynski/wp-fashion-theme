<?php
// phpcs:ignoreFile
/**
 * WordPress theme supports
 *
 * @package theme
 */

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'widgets' );
	add_post_type_support( 'page', [
			'excerpt'
	] );
	add_post_type_support( 'post', [
			'revisions'
	] );
	add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
	] );
	add_theme_support( 'post-formats', [
			'aside',
			'image',
			'video',
			'quote',
			'link',
	] );
} );

add_action( 'init', function () {

	register_nav_menu( 'nav_main', __( 'Menu: main' ) );
	register_nav_menu( 'nav_footer', __( 'Menu: footer menu 1' ) );
    register_nav_menu( 'nav_footer_2', __( 'Menu: footer menu 2' ) );
    register_nav_menu( 'nav_language', __( 'Menu: language' ) );

	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', function ( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	} );
} );

//
//add_action(
//		'init',
//		function () {
//			if ( empty( $_GET['post'] )
//			) {
//				return;
//			}
//			$post = sanitize_text_field( wp_unslash( $_GET['post'] ) );
//
//			if ( isset( $post ) ) {
//				$template   = get_post_meta( $post, '_wp_page_template', true );
//				$front_page = get_option( 'page_on_front' );
//				if ( ( 'default' === $template ) && ( $front_page !== $post ) ) {
//					return;
//				} else {
//					remove_post_type_support( 'page', 'editor' );
//				}
//			}
//		}
//);


add_theme_support( 'custom-logo', array() );
/**
 * Remove WordPress version.
 */
function remove_wordpress_version(): string {
	return '';
}

add_filter( 'the_generator', 'remove_wordpress_version' );

/**
 * Pick out the version number from scripts and styles
 *
 * @param string $src Link.
 */
function remove_version_from_style_js( string $src ) {
	if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) ) {
		$src = remove_query_arg( 'ver', $src );
	}

	return $src;
}
add_filter( 'style_loader_src', 'remove_version_from_style_js' );
add_filter( 'script_loader_src', 'remove_version_from_style_js' );

/**
 * Redirect attachment pages to file (no solution for removing permalinks)
 */
function redirect_attachment_pages_to_file() {
	if ( is_attachment() ) {
		$id  = get_the_ID();
		$url = wp_get_attachment_url( $id );
		if ( $url ) {
			wp_safe_redirect( $url, 301 );
		}
	}
}

add_action( 'template_redirect', 'redirect_attachment_pages_to_file' );


/**
 * Integrating Advanced Custom Fields:
 */
add_filter( 'acf/settings/save_json', function () {
	return get_stylesheet_directory() . '/acf-json';
} );
add_filter( 'acf/settings/load_json', function ( $paths ) {
	unset( $paths[0] );
	$paths[] = get_template_directory() . '/acf-json';
	$paths[] = get_stylesheet_directory() . '/acf-json';

	return $paths;
} );

/**
 * Timber context options
 */
add_filter( 'timber_context', 'speed_timber_context' );

function speed_timber_context( $context ) {
	$context['options'] = get_fields( 'option' );

	return $context;
}

/**
 * CF7 change input to button
 */
remove_action( 'wpcf7_init', 'wpcf7_add_form_tag_submit' );
add_action( 'wpcf7_init', 'new_wpcf7_add_shortcode_submit_button', 20 );

function new_wpcf7_add_shortcode_submit_button() {
	wpcf7_add_form_tag( 'submit', 'new_wpcf7_submit_button_shortcode_handler' );
}

function new_wpcf7_submit_button_shortcode_handler( $tag ) {
	$tag = new WPCF7_FormTag( $tag );
	$class = wpcf7_form_controls_class( $tag->type );
	$atts = array();

	$atts['class']    = $tag->get_class_option( $class );
	$atts['id']       = $tag->get_id_option();
	$atts['tabindex'] = $tag->get_option( 'tabindex', 'int', true );

	$value = isset( $tag->values[0] ) ? $tag->values[0] : '';
	if ( empty( $value ) ) {
		$value = __( 'Wyślij wiadomość', 'hortus' );
	}

	$atts['type'] = 'submit';
	$atts = wpcf7_format_atts( $atts );
	$html = sprintf( '<button %1$s>%2$s</button>', $atts, $value );

	return $html;
}

add_action('acf/init', 'my_acf_op_init');
function my_acf_op_init() {

    // Check function exists.
    if( function_exists('acf_add_options_page') ) {

        // Register options page.
        $option_page = acf_add_options_page(array(
            'page_title'    => __('Theme General Settings'),
            'menu_title'    => __('Theme Settings'),
            'menu_slug'     => 'theme-general-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));
    }
}
function custom_classic_editor_color($init)
{

	$custom_colours = '
	"000000", "Black",
      "993300", "Burnt orange",
      "333300", "Dark olive",
      "003300", "Dark green",
      "003366", "Dark azure",
      "000080", "Navy Blue",
      "333399", "Indigo",
      "333333", "Very dark gray",
      "800000", "Maroon",
      "FF6600", "Orange",
      "808000", "Olive",
      "008000", "Green",
      "008080", "Teal",
      "0000FF", "Blue",
      "666699", "Grayish blue",
      "808080", "Gray",
      "FF0000", "Red",
      "FF9900", "Amber",
      "99CC00", "Yellow green",
      "339966", "Sea green",
      "33CCCC", "Turquoise",
      "3366FF", "Royal blue",
      "800080", "Purple",
      "999999", "Medium gray",
      "FF00FF", "Magenta",
      "FFCC00", "Gold",
      "FFFF00", "Yellow",
      "00FF00", "Lime",
      "00FFFF", "Aqua",
      "00CCFF", "Sky blue",
      "993366", "Red violet",
      "FFFFFF", "White",
      "FF99CC", "Pink",
      "FFCC99", "Peach",
      "FFFF99", "Light yellow",
      "CCFFCC", "Pale green",
      "CCFFFF", "Pale cyan",
      "99CCFF", "Light sky blue",
      "CC99FF", "Plum",
      "CFEFEC", "Theme color",
    ';

	// build colour grid default+custom colors
	$init['textcolor_map'] = '[' . $custom_colours . ']';

	// change the number of rows in the grid if the number of colors changes
	// 8 swatches per row
	$init['textcolor_rows'] = 6;

	return $init;
}
add_filter('tiny_mce_before_init', 'custom_classic_editor_color');