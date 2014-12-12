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
define('DB_NAME', 'fugazi');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'W++Sy)eGa0/7|0k-EF=r_u,<N9(2O*w6r04*~O]=6&-p/Wy1)~^Nar{Gw&x4F+eX');
define('SECURE_AUTH_KEY',  'V:VTkBaX%Jh/sDBt|YG]6Nhh/]~]f,JJCCoc4]XSt=e-hyF)CK^vz-m[w!-nW|Al');
define('LOGGED_IN_KEY',    'k.e6;U)gixrC{+lY,yMj4dVp.(I!>I_GDDuOi?8rrcOJ_M?^O7+-SCSTd/@+9gK8');
define('NONCE_KEY',        'g?2;k:{0$_USwkv7i|_G$^pf0@@0@FSd3uaqKu2Z9HBWndPapCL:~gRxO{0O10qm');
define('AUTH_SALT',        'u:v$/Z xbtjV-40x0E5g2_QVr>H3)NyEBq8(+YU>Hrdm?^bc)Zn6S~2m,:o68^l9');
define('SECURE_AUTH_SALT', '3|gLqa(:08@49tEZlu+APv1,guGrK7k]NAMy5j>Xo8^%[bN@v*1(-<Y^U[d4/kr>');
define('LOGGED_IN_SALT',   'G+,&m)F|7!ODGln~mx{tE!|X#x:V*7WN?>-7SdG{JZM]pbxS5rA&h]eo)/}w,AEt');
define('NONCE_SALT',       '^3.n`HZ)m$xC)m9ECWI_d)n]C)hy$rr0Ae&7d3;>,d+_Zfs-OCfx2)b+{+E]fSsv');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_fugazi';

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
