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

define('WP_REDIS_HOST', 'wordpress.krhfze.0001.use1.cache.amazonaws.com');

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', 'wordpress');

/** MySQL hostname */
define('DB_HOST', 'wordpress.cftqt4jaczzg.us-east-1.rds.amazonaws.com');

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
define('AUTH_KEY',         '94u_7N<uYY<0Tfn[B7SuSz`:gfe`BI1fs` c{cJ3&rHAxb:93G=Yi;pv:WCa/Mox');
define('SECURE_AUTH_KEY',  'RE(,5UkUv2LwCe-b8>}/`l;dmbKu]xG(,Ttfnp`fes7%cnKZZ0MrdW,e!X?+gl.*');
define('LOGGED_IN_KEY',    'elyY!|Yl+s4e;Os{}4+iK-H(pk{Gx,O$]6W:kM05s!4&.OeZU(C+Y6 y[_B{ofDA');
define('NONCE_KEY',        'Zs^JFcv^JZ*-;5-_r5V/vb-ch)iuLhK6756RCuE^d%vI1s>Z;QtJ`1@{*X&{o~er');
define('AUTH_SALT',        'bz+Y*> #bpqf#ptEo_ik$n1?TQD^--,T_ck}|FjBTg9UA*+AozPl/HAty9 *VE`B');
define('SECURE_AUTH_SALT', 'ukU$L0iSPzGD~L)u 6u^u5]8(N$qcnIkuUR+ip]Ul=]VR.pN8qRH_k]V-)rNa94E');
define('LOGGED_IN_SALT',   '(1Me] W-,Fb$jIu+#7cbjMP9RgEe}-Vp;|[A. 3o~>@G^+TJAD}pg)E^XAz5NrKu');
define('NONCE_SALT',       'wDnqJTCh%Q(rp:?mU``-7-!i-yUA#O*Rje>YVO?}qTBq^GDfUEH&geRVC]TGO>qC');

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
