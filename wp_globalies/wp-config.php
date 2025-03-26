<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/Applications/XAMPP/xamppfiles/htdocs/globalies_master/wp_globalies/wp-content/plugins/wp-super-cache/' );
define( 'DB_NAME', 'wp_globalies' );

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
define( 'AUTH_KEY',         'I6b(c4A%<-6.hiA4~Tj(nLX?w*#8{wr4q<*Xq1x4dyKol<rV,X|n=FtXFk$3z_fy' );
define( 'SECURE_AUTH_KEY',  'F0Xj+RQmP[}qbjq8PL1==,dTYa*hA4]5z/q1J?ao?3 D}sRl~[F*u$-|<$:T(bAY' );
define( 'LOGGED_IN_KEY',    'lcF.*ix1QH E`P0=9B@w`jp`@F-BxeTfblB^P1Jo.gQFh32%f tL4z!W;z{VX5SW' );
define( 'NONCE_KEY',        '$M/yN9,9-O~ ~<Y;L[ANckM^Pn<k/[Wt&z85/=/z*Ddyin|~uxgPIq4)epJIp?t.' );
define( 'AUTH_SALT',        'U+j,MPQbn3wsp~s.XKdGfp{zA-vjGV 4L4>%#[8G/#qQ72#]7~nuHYy5SjZ;S8X*' );
define( 'SECURE_AUTH_SALT', '{&naGz?=}40WVo2WoI0^NVbt_4Q`cpP-P(e`~&`3Q$<Rt%2/6hu#HJc*-aGZjI,f' );
define( 'LOGGED_IN_SALT',   '.uJ@~`<>6<}}V&tVvnc_kj9)s!q%O-ifS(Hyfx&83-EMfad/!/|$%_re*A&XrYXh' );
define( 'NONCE_SALT',       'mF+,qD:]oZ08/NLESai3l6l[g vk.D_V0C5JE]jS@r-wF;zmvnm{msFd%yZ~PP}M' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

/** XAMPP ProFTPD settings */
define("FS_METHOD","direct");
define("FTP_HOST", "localhost");
define("FTP_USER", "daemon");
define("FTP_PASS", "xampp");


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
