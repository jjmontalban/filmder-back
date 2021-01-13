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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp-vue' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define('JWT_AUTH_SECRET_KEY', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL3dwLXZ1ZSIsImlhdCI6MTYwOTI1OTg1NiwibmJmIjoxNjA5MjU5ODU2LCJleHAiOjE2MDk4NjQ2NTYsImRhdGEiOnsidXNlciI6eyJpZCI6IjEifX19.ySUodigGco7gxWehU-fgr2r5ACAVT-Rgxu1KTUDZj8s');
define('JWT_AUTH_CORS_ENABLE', true);

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '/a;EST,XcR-+wW!EUO@92}3HAQxGpkJl=w<Y`MU.O*qyI2b?^gdHL46vAPeDK0T{' );
define( 'SECURE_AUTH_KEY',  'wP/s6i$5BRs6p{iW5@-S{4#w!h}rp@*[])v&{fT=]#p-H_)f;rkt%CWaCiZMA;Vw' );
define( 'LOGGED_IN_KEY',    'IsVRdna4`H1HVF_d?aa$!KVq#tnw<b=YrjI/)Q~{bdqXRX+:%t=UN=Wy1]41qhz ' );
define( 'NONCE_KEY',        'A&Ef=hvV:GSe6`w@7LHY]j8~];i1t{s>ilO{QU/%kw2-5H xG)e@5HTbHoCga(*X' );
define( 'AUTH_SALT',        '~bhqgL|^GRS;*HR3N=+d,Sz;Bi(w.o u|xS%DIG GeK HIxk7XuDxi-2>[6w(F!#' );
define( 'SECURE_AUTH_SALT', 'l0rw?<}-JS-qMLg4Ag`fo[WX=pFIn|>-trbD(Us<F%.B%HW)6D`aJYV1~O+B]@pQ' );
define( 'LOGGED_IN_SALT',   'RSTvI!B%:$[ujL_D0D`%Zzj$t_))[X_n^PK1_*ad;l<`gJZa&KdFz^,bnA9O 3W:' );
define( 'NONCE_SALT',       '~aa^5q_wtABp>E65 Zm2n.(^SRPd?f3%2V9^J&wXOkzB:,Olah#,-]G,~H2 /y2O' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
