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
#define('WP_MEMORY_LIMIT', '64MB');

define('WP_HOME', 'http://'.$_SERVER['HTTP_HOST']);
define('WP_SITEURL', 'http://'.$_SERVER['HTTP_HOST']);


define('DB_NAME', 'qdm10829495_db');

/** MySQL database username */
define('DB_USER', 'qdm10829495');

/** MySQL database password */
define('DB_PASSWORD', '7340985cxmm');

/** MySQL hostname */
define('DB_HOST', 'qdm10829495.my3w.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '._{UdGMsE3?|+Hk#fRY#;{?$h9[N+5h3.OknegJmeLMA0$;|+/O<?cI7K;dBw#FM');
define('SECURE_AUTH_KEY',  '?f6vKZ&z-7R1SUr55??.ev%IOv!jf9,]go.4t;+e~OrPxljux.Eq*%qn9.ZHlCwL');
define('LOGGED_IN_KEY',    'O1k/Br~!U.^R@FQrCmVk%TkANI=8:#MjsK(;Aeguf0KuH7]FkgQM6K;wpBzbvAFt');
define('NONCE_KEY',        'i]fIq5:|}:gOh4J9&sX4K2pjF}PU{PM5&H,1#`D;;+~)tXyCrO&Uf)i{pWIc3#EE');
define('AUTH_SALT',        'Wp0ynf1|+7~q18IDxoM03iioa$.)kwIh>;8]D+-V$2p2D{Uz=:n|zSY-s?}@Pu/u');
define('SECURE_AUTH_SALT', '*hK)4Gl_-Q5 b5y@C=X46`t&^<cuytCr,+X;X?-R-yq-3-1n xK}X{P3[>VN0e:>');
define('LOGGED_IN_SALT',   'vPpB}H/}^KR[h~@kzA]5755251z)8}$v36U0FM_.e9*PD<oTK<g0zC8!-2cGhA>t');
define('NONCE_SALT',       'kmuq$P3/KHp#TqF]9IlE<A9&HuKXd4P*yG,a&fK7mX?)j%hd(!nK91]B:TZ@N~Q;');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'lilian_';

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