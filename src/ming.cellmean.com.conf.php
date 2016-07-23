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
define('DB_NAME', 'ming');

/** MySQL database username */
define('DB_USER', 'dev');

/** MySQL database password */
define('DB_PASSWORD', 'dev');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '_V0r4c@?!*g&9y?X]b5qBRP-31nl+|?{J1|1K<*{zB7X:VsfH|HV?vK]0U^- q3L');
define('SECURE_AUTH_KEY',  'T}`V3{ i5uZQ{ IS7VH@y`:CtKYcKyI+Sqj>EcsfDvCjGDK1&nPiZ%*ADcedLjo=');
define('LOGGED_IN_KEY',    'yU]VJUX84YAQJ~UJ.DOfH7+.i7dHb+?NNm@F 63gwc[pkmTD99L,UGg(;Qn@ge]%');
define('NONCE_KEY',        '#Ra:^BS615p~>:ndfwcry47y /E _9|2*Sh{GLY1pW%HM0`R^T9ozuSl,Ou(Qp{y');
define('AUTH_SALT',        'T1;0gMD4o[K.U5xm.pXfdALxL6fgjD<gOfX*1LdzgLt+v {E@beeg9$Yt(-7~0B!');
define('SECURE_AUTH_SALT', 'nJ*-$wj?W#]3|f!ks6i[zI.EP#gZmU-7xL(T8StTiN-!TE5F.s[4%BR:>|!Lkk$x');
define('LOGGED_IN_SALT',   '(B(b/Y:LIWxL7bwWa5XJV`Pp0ly_kLF3~ZpLc:NBWY}(GPavxep=R9Oyj[/1X_ks');
define('NONCE_SALT',       '>tl)M9n(?:9:>(]/+P.{I-SR3~<}j0ujNE?e%Pbc0riu[J}d(a3q;6vom4B^r8FS');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ming_';

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
