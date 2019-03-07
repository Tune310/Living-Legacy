<?php
/**
 * Plugin Name: Kinsta Must-use Plugins
 * Plugin URI: https://kinsta.com/kinsta-tools/kinsta-mu-plugins.zip
 * Description: Handles the purge of the server level caching.
 * Version: 2.1.1
 * Author: Kinsta Team
 * Author URI: https://kinsta.com/about-us/
 * Text Domain: kinsta-mu-plugins
 * Domain Path: /kinsta-mu-plugins/shared/translations
 *
 * @package KinstaMUPlugins
 */

if ( ! defined( 'ABSPATH' ) ) { // If this file is called directly.
	die( 'No script kiddies please!' );
}

define( 'KINSTAMU_VERSION', '2.1.1' );
if ( ! defined( 'KINSTAMU_WHITELABEL' ) ) {
	define( 'KINSTAMU_WHITELABEL', false );
}

require_once 'kinsta-mu-plugins/shared/class-shared.php';
require_once 'kinsta-mu-plugins/compat/compat.php';
require_once 'kinsta-mu-plugins/cache/cache.php';
require_once 'kinsta-mu-plugins/cdn/cdn.php';
