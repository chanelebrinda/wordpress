<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'Plugin' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'l9Kv5bxjD?SR?`1~~9mfsi4:gI:9]`dzk~2nS^.?[998!VuYn%^HJGn9;Y{e3K<o' );
define( 'SECURE_AUTH_KEY',  '6>bW.^diPS*1-6,!<;?DkE3JbkEar0f)[8o!#{=OX%?QqQ5Bp51n[9R%sI1?C~p_' );
define( 'LOGGED_IN_KEY',    'M<Q u]fUymI|goRB/ljY+b<fw)) bunD,C<R&R5s#542|<M5/y]dWr*7B#*+ygO)' );
define( 'NONCE_KEY',        'dnQMQz&aLxGDL^|`&Rk&DXb?g)#5[w>T3+K!x&G&w69p^@26{o/+Z(_jd|k)Vw|z' );
define( 'AUTH_SALT',        'CE%cJg$%{EVl*ueZ+lU3640]`2U}lXQ,>:iqMo9mK$oT|[g>%=nTruoEH[qNX6Q1' );
define( 'SECURE_AUTH_SALT', 'Tr6chd!i@6t:n3Ps^`HKe;[#rc(D~p)q:l;<hxb$11@,2rnHq6j`jKua[%9BNb1@' );
define( 'LOGGED_IN_SALT',   '}wES`[bG=)`^Jhl*>y<-Y7!`Y8d66}$LvO|kP${_(N[>oYc=$*370W%hAJ+Y<xm1' );
define( 'NONCE_SALT',       '6`>,@ab lzKO-!breRX3Q]+~yD:AkjcB:Iu;=l=WAYF]2# ;4b*rD<>`(LKl28y.' );

/**#@-*/

/**
 * WordPress database table prefix.
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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
