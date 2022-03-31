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
define('DB_NAME', 'peepal');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'F}@GXCRZ+m :7wIIQ|S1C&)}d_iBy74HyL9!O0)ci2=<h#3<1E>UF$9?Q&$<P5`2');
define('SECURE_AUTH_KEY',  '}Xf-$+aV2e#Iqf;B>sbbi+DYu/qg%:{z*BXe<iJnuPYe,fMU:NqDv!|vp}@N@sL%');
define('LOGGED_IN_KEY',    'g2)oqgm^u7G/^P$g_({<+-+=5@}<p;+s]fR&hLXtP6D-Xr}3M!,-}GTML,0R)aU^');
define('NONCE_KEY',        'gzmGY; i=~!;L>q,c n@&kCjo/fhr,CG%SANm%0Vmy8qD!yb^oU5HETaqUGJ*r*w');
define('AUTH_SALT',        '`ohPK0tX.Yj9{=4{m}&#C1z#~8K&!W=fX}E lw6l@|~B*>)~{PMQw/L_x%&#WM7A');
define('SECURE_AUTH_SALT', 'R^W^nT$<cEytLCOT(.3cYu)+C?-EJk>E7CC[aqq8 dAZb1sd,Ul#ZD-hf8Xn7U7L');
define('LOGGED_IN_SALT',   'V(fxuce%#rBrLTGP6-Q4N=5F>Yh1W1,G]Z|U)NrKR`^3g(zrk}OtMzezAgCl!uqs');
define('NONCE_SALT',       'c$JHUM5<eZ27mi:&XG|n^Q_vfTEv[. (lc]j[~<Z{T620X#ug%iG[s6WcYgO7:){');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ed_';

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
