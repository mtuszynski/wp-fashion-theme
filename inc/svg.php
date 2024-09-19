<?php
/**
 * The template for displaying svg
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package    WordPress
 * @subpackage theme
 * @since      1.0.0
 */

/**
 * Replace svg
 *
 * @param string $icon - icon name.
 * @param string $class - icon classes.
 */
function svg( $icon, $class = '' ) {
	$icon = file_get_contents( get_template_directory() . '/public/images/svg/' . $icon . '.svg' );
	$icon = str_replace( '<svg', "<svg class='icon " . $class . "'", $icon );

	echo esc_attr( $icon );
};
