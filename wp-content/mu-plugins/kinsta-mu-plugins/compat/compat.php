<?php
/**
 * Initialize platform and plugin compatibility with WordPress
 * and other entities such as plugins, themes, and WP-CLI).
 *
 * @package KinstaMUPlugins/Compat
 */

namespace Kinsta\Compat;

if ( ! defined( 'ABSPATH' ) ) { // If this file is called directly.
	die( 'No script kiddies please!' );
}

// Load required files.
require_once 'utilities.php';
require_once 'class-banned-plugins.php';
require_once 'class-kinsta-commands.php';
require_once 'class-security.php';

// Roll the "Banned Plugins" feature.
$banned_plugins = new Banned_Plugins();

// Roll the custom WP CLI commands.
$kinsta_commands = new Kinsta_Commands();
$kinsta_commands->set_banned_plugins( $banned_plugins );
$kinsta_commands->add_commands();

// Roll WordPress security utitlity.
$security = new Security();

add_action( 'init', [ $banned_plugins, 'run' ] );
add_action( 'init', [ $security, 'run' ] );
