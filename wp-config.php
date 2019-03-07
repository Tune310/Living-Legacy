<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'livinglegacy');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '$Napha8888');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('WP_HOME','http://livinglegacy.dev');
define('WP_SITEURL','http://livinglegacy.dev');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '!YmuZPiL3,(8OJ(@vAErNIA*NDx (yT.syhV@>Bf.T/Vd_EwN/Z+W-;|;2u^$Wwk');
define('SECURE_AUTH_KEY',  'n.6&~Cn,7rO7!Q<zZ-Q{L&T=~FYX4Z8LcHL@%3Gp.o]1HIM71XDt/a(RHiQvL*dj');
define('LOGGED_IN_KEY',    'hvvYL);Y jZcRHPf[x-qc1|^O?q+H`nNRwMI%/2+*oI-Ij.%B;IAjO9#}>)<cyS>');
define('NONCE_KEY',        'EH^-@}Z<2fSO :&zX+sd,=/+@>D]!O~YcQS>W[LN|ens/{&4psP;Gq{cJ5PbNth<');
define('AUTH_SALT',        'HUE yh#|+t;4V`&uNBX/`k 9vFB5Ti%Om?b6<q9I=iB*4mkY)nmfH=Z>kjDaWD[4');
define('SECURE_AUTH_SALT', '~$-mY#obS9ElUJ!=I{k)*{r6!YR<YKvb$!dEh])mru(ppS!sDQ~p(MX&Xir0*N8b');
define('LOGGED_IN_SALT',   'w/:m+{PtQ1*G{d`OTY;a0*EY+@jy07v8IfXo1+*fZvUuvesNqK-|PlrCS;K>LC.#');
define('NONCE_SALT',       '[G 1`ltKbG $||_Ydw%O,[K:G_XPVP,DvOv6]txCw%KRwcrcP<GKX*?gP,NU2vhC');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
