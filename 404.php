<?php
/**
 * WordPress 404 redirect to home
 *
 * @package theme
 */

header( 'HTTP/1.1 301 Moved Permanently' );
header( 'Location: ' . get_bloginfo( 'url' ) );
exit();
