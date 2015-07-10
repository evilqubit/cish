<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', '');

/** MySQL database username */
define('DB_USER', '');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'C77taY6Lk~YsB+2^-izGoxZF)E3-AJT&b}`0v?7G|%(3M}w{~#Zv]_%kJ^Zw`WG@');
define('SECURE_AUTH_KEY',  'zuG]O(HtB~o5IeIW?|p~`<<G@aBxIqEO~>3@kMyRR!?h_mQ9Al~ngq?CeXkD=$L5');
define('LOGGED_IN_KEY',    '-|kyR|JZ8do pRu#nW{h@)jFB=@(Uw!d:N 9p!|-.+MI5$pa6.Ld)N7(7+<K?M1(');
define('NONCE_KEY',        'xk`_}+bs9X9G6-[|.%/?WhV-Hn8sAmbTsW}T{IQy+(~-|Xkdg(k&fYl6Z.-Vr`bU');
define('AUTH_SALT',        'TjyNsG$M7W/8@NHFmDO`Z@U1.l{y8(2^.tU(y)9rbyq)&8M-Q9KxL^(Tdd<GSG^<');
define('SECURE_AUTH_SALT', '__Jhg,:nkN|IYid?*5x^X-Vi^zN+|FXUVd&z|CMH+eUGLD_Qg[y,=aO6S r|Q]~l');
define('LOGGED_IN_SALT',   '8F`]7IA_HW^W^0A s9:2UE5B]&-=[-Ku*&-)MN}Rib96w~/k*f5+g }Hf+ZB#OtT');
define('NONCE_SALT',       ']zdf^B$p|)Y#(1r) fz/7n~7.)AXX]8W-q*+Tyj 6.*{9m^XVRQ~wN,ssVF)3,V[');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');