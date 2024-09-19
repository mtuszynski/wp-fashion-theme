<?php

/**
 * WordPress functions
 *
 * @package theme
 */


if ( ! class_exists( 'Timber' ) ) {

	add_action(
			'admin_notices',
			function() {
				echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
			}
	);
	return;
}

Timber::$dirname = array(
		'src/layouts',
		'src/templates',
		'src/views',
		'src/components',
);

$path_components = 'src/components/';
$path_templates  = 'src/templates/';
$path_sections   = 'src/sections/';
$path_views      = 'src/views/';
$path_posts      = 'inc/posts/';
$path_acf        = 'inc/acf/';

include_once 'inc/enqueue.php';

include_once 'inc/theme-support.php';

$site = include_once 'inc/class-site.php';

global $site;

$site->initSite();

include_once 'inc/twig-extends.php';

include_once 'inc/svg.php';

include_once 'inc/disable-comments.php';

include_once 'src/templates/templates.php';

include_once 'inc/blocks/blocks.php';

include_once 'inc/helpers.php';

include_once 'inc/functions/functions.php';





