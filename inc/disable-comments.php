<?php
/**
 * WordPress functions
 *
 * @package theme
 */

/**
 * Remove comment for posts
 */
function remove_comment_admin_page() {
	global $pagenow;

	if ( 'edit-comments.php' === $pagenow ) {
		wp_safe_redirect( admin_url() );
		exit;
	}
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );

	foreach ( get_post_types() as $post_type ) {
		if ( post_type_supports( $post_type, 'comments' ) ) {
			remove_post_type_support( $post_type, 'comments' );
			remove_post_type_support( $post_type, 'trackbacks' );
		}
	}
}

add_action( 'admin_init', 'remove_comment_admin_page' );

/**
 * Close comments on the front-end
 */
add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open', '__return_false', 20, 2 );

/**
 * Hide existing comments
 */
add_filter( 'comments_array', '__return_empty_array', 10, 2 );

/**
 * Remove edit comments on admin
 */
function remove_admin() {
	remove_menu_page( 'edit-comments.php' );
}

add_action( 'admin_menu', 'remove_admin' );

/**
 * Remove edit comments on admin bar
 */
function remove_admin_show() {
	if ( is_admin_bar_showing() ) {
		remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
	}
}

add_action( 'init', 'remove_admin_show' );
