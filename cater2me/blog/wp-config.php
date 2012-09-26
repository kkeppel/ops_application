<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'drupal');

/** MySQL database username */
define('DB_USER', 'cater2me');

/** MySQL database password */
define('DB_PASSWORD', 'dJ75abK2h');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/*** FTP login settings ***/
define('FTP_HOST', 'cater2.me:22');
define('FTP_USER', 'root');
define('FTP_PASS', '156:gandi');
define('FTP_SSL', false);


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '!t(Mj4t-+]-)@+6p)6kDzf |e+M~IG0WVs]Wp#)xR-m]VJi1T6w_7=y9$_jbE!9P');
define('SECURE_AUTH_KEY',  'kz.F.2Bss`Mt_c|x(5+F.(nK~g+Qm%F2&e-f8JR=%(ptdv}`|p|<nmly{;2dr-j|');
define('LOGGED_IN_KEY',    'f}4z[!|8y$IX4@mo-*8xk^N2i]jL`+aI5omnKV9>Y-Es&(D#JU0C,&=V-v.t8q.L');
define('NONCE_KEY',        'jNd2ivP}02nhgr~U/+1`]yV,Ou|b9g`F4wBc%hHf?EF[=?[s+o/sp8VM ZD_rL$~');
define('AUTH_SALT',        'TGloi9Spp[Aju:yY|1j1`cDi~G|Lm>.F5wR;_N+E1XtIFAVl2FS|!(o|R]y_^*R-');
define('SECURE_AUTH_SALT', 'MJHJX+#$kkH}Z+:<<=~CMK?#BC9L,|5.s=F{_woY3|{p>Is7}sS5b$A:/bhu8z!d');
define('LOGGED_IN_SALT',   'kH)tpsQp0RLE-eFO1;bIp=kC6)[L/D)XB?8na`#Yk&|4U-FzTkakK<=({g>~|[]{');
define('NONCE_SALT',       'ybP-d1R /=H|e8z$+DqBG,~p`UBfXp>)XRuq5G.wlB{5)Ik4tax-x?7cXu;18 A4');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
