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
define('AUTH_KEY',         '%n*?M7@!il(_5Oo925^tvB4061H,yX:}-K|54pb8H6yiknF@eyh1Im_.S~i$  b9');
define('SECURE_AUTH_KEY',  '`tKOn |B3vcJ/kPK94GEd>&[U*9-%[l|6um<Fftz4h_`H:i}L u|ZqB)YcFLe_/.');
define('LOGGED_IN_KEY',    '-6l^e;(0KDG1i*uObL>/q,7S!%eXlhJW, it8$E8M:]+}T5D:esl|(WX)dOO$4fO');
define('NONCE_KEY',        'c@s<uCC[|b#@oo%@OH/Y&|_ZM<o+%*T;xQ1e-1sqb]=kAWa{9EH)>%8TeKa,~u1]');
define('AUTH_SALT',        '4P%]}!G[KZ>9ZOq=AZDV^rOUuDX7spFbi6O~jFkW#.5t_$UM?-__pSsyI[)R-pCE');
define('SECURE_AUTH_SALT', 'l<?Qu !t=B?t*vus|BT#GVO^r=>e&J,+9?r?Rfp %uFOFW~<0.-07;$1yT.1Zflg');
define('LOGGED_IN_SALT',   '<.!Ep&J|}kW yv;R2/D`|$38z4bV;RZ*qTJ&VyTz]Y 6][c+(:k~zvM!QD.e9$,m');
define('NONCE_SALT',       'l?2hYbe<XnEThMMzqf9KzSk6 9xfGwVv+eO,g35Q54P[Y6KlC<BjKGPy^s081,#%');

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
define('WP_DEBUG', true);
// Enable Debug logging to the /wp-content/debug.log file
define('WP_DEBUG_LOG', true);

// Disable display of errors and warnings 
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors',0);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
