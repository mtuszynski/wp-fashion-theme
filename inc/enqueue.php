<?php

function theme_scripts() {
	global $template;

	$name = WP_DEBUG ? '%s' : '%s';

	if ( file_exists( get_template_directory() . '/public/js/' . basename( $template[0], '.twig' ) . '.js' ) ) {
		$jsfile = '/public/js/' . sprintf( $name, basename( $template[0], '.twig' ) ) . '.js';
		$js     = get_template_directory_uri() . $jsfile;
	} else {
		$jsfile = '/public/js/' . sprintf( $name, 'main' ) . '.js';
		$js     = get_template_directory_uri() . $jsfile;
	}

	$jstime = filemtime( get_template_directory() . $jsfile );
	wp_enqueue_script( 'main-script', $js, array(), $jstime, true );

	//wp_enqueue_script('jq-script', get_template_directory_uri() . '/js/' . sprintf($name, 'script') . '.js', array('jquery'), false, true);

	if ( file_exists( get_template_directory() . '/public/css/' . basename( $template[0], '.twig' ) . '.css' ) ) {
		$cssfile = '/public/css/' . sprintf( $name, basename( $template[0], '.twig' ) ) . '.css';
		$css     = get_template_directory_uri() . $cssfile;
	} else {
		$cssfile = '/public/css/' . sprintf( $name, 'main' ) . '.css';
		$css     = get_template_directory_uri() . $cssfile;
	}

	$csstime = filemtime( get_template_directory() . $cssfile );
	wp_enqueue_style( 'main-style', $css, false, $csstime );
}

function backend_scripts() {
	$jstime = filemtime( get_template_directory() . '/public/css/backend.css' );
	wp_enqueue_style( 'main-style', get_template_directory_uri() . '/public/css/backend.css', false, $jstime );

	$csstime = filemtime( get_template_directory() . '/public/js/backend.js' );
	wp_enqueue_script( 'main-script', get_template_directory_uri() . '/public/js/backend.js', array(), $csstime, true );
}

add_action( 'wp_enqueue_scripts', 'theme_scripts' );

add_action( 'admin_enqueue_scripts', 'backend_scripts' );

add_action( 'wp_head', function () {
	/* CSRF Token */
	echo '<meta name="csrf-token" content="' . wp_create_nonce( 'wp_rest' ) . '"/>', PHP_EOL;

	/* Fonts */
	$base_dir = trailingslashit( get_template_directory() );
	$dir      = '/src/fonts/';
	$fonts    = glob( $base_dir . $dir . '*.*' );
	foreach ( $fonts as $font ) {
		$url = get_theme_file_uri( $dir . basename( $font ) );
		echo '<link rel="preload" as="font" type="font/' . pathinfo( $url )['extension'] . '" href="' . esc_url( $url ) . '" crossorigin>', PHP_EOL;
	}
} );

add_action( 'admin_head', function () {
	echo '<meta name="csrf-token" content="' . wp_create_nonce( 'wp_rest' ) . '"/>', PHP_EOL;

	/* Theme Global Object */
	echo '<script type="text/javascript">' . PHP_EOL;
	echo 'var theme=' . json_encode( apply_filters( 'theme_global_object', [] ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . PHP_EOL;
	echo '</script>' . PHP_EOL;
} );

add_action( 'wp_footer', function () {
	wp_deregister_script( 'wp-embed' );

	/* Theme Global Object */
	echo '<script type="text/javascript">' . PHP_EOL;
	echo 'var theme=' . json_encode( apply_filters( 'theme_global_object', [] ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . PHP_EOL;
	echo '</script>' . PHP_EOL;
} );

add_action( 'admin_footer', function () {
	/* Theme Global Object */
	echo '<script type="text/javascript">' . PHP_EOL;
	echo 'var theme=' . json_encode( apply_filters( 'admin_global_object', [] ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . PHP_EOL;
	echo '</script>' . PHP_EOL;
} );

