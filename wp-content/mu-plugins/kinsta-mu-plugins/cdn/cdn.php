<?php
/**
 * Initialize CDN Feature
 *
 * @package KinstaMUPlugins
 * @subpackage CDN
 * @since 2.0.0
 */

namespace Kinsta;

if ( ! defined( 'ABSPATH' ) ) { // If this file is called directly.
	die( 'No script kiddies please!' );
}

/* Defines */
define( 'KINSTA_CDN_ENABLER_MIN_WP', '3.8' );
define( 'KINSTA_SERVERNAME_CDN_DOMAIN', 'KINSTA_CDN_DOMAIN' );
define( 'KINSTA_SERVERNAME_CDN_OTHERDOMAIN', 'KINSTA_CDN_OTHERDOMAINS' );

/* Requires */
require_once 'class-cdn-enabler.php';
require_once 'class-cdn-rewriter.php';

/* Start CDN related stuff */
$cdn_enabler = new CDN_Enabler();
add_action( 'init', array( $cdn_enabler, 'run' ), 99 );
