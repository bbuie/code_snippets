<?php
/**

THIS FILE WAS COPIED FROM THE DOCKER FILES THE FIRST TIME DOCKER WAS RUN

 */

define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_HOST', getenv('DB_HOST'));

define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

define('AUTH_KEY',         'G9+q~J15@c-O#g]Z|{r4yPa){7m/ZXOIn8VQg1JD`G{oEK(oRltKr*$`@i7x+q;)');
define('SECURE_AUTH_KEY',  '!|h3g%~<BIjKoX,]J15)ZzugPh]YpVaNuP.*[|:*n7V{IaCmeSV&rA)sk]1+ VGe');
define('LOGGED_IN_KEY',    '@)NXR]tjy|p* pj|H|&dv-Q])^07NK7Q+4F?l&Y3@4cKG9i2XM6~q7:.gBA,B-ZB');
define('NONCE_KEY',        '6fP%xIYev?UYxnwt:_%_wjd|.3TLW~VXVglH^uM.|w9stD{myFyn84q|*Iy-{9Oa');
define('AUTH_SALT',        ':Iq3k|^rxFMAXHsbixw<W|(;KxW{`b1Z}K6p4 .PszAe>+>C976%xyE5t;UZ@- S');
define('SECURE_AUTH_SALT', 'Gg)Mr.vMS+k7SD8ij+$C Z(+|(,fqW_|b-?76:JT3Hi{/:v+8U<r^P(oe/y!$8r>');
define('LOGGED_IN_SALT',   'IOB1>t-jA?Cf3SV#Bq!6RJxAvQd.$-c6jQc4d7c%5Mr|zG I>vc(zs2:{q>.A=oX');
define('NONCE_SALT',       '{&F}Wa/ z.!*F;`OH>6F()^8o>~qX_o{jdEAXxT,,+Ex|kb)k~/oDO&#2m9tJVM2');

define('WP_SITEURL', 'http://192.168.99.100/');
define('WP_HOME', 'http://192.168.99.100/');
define('WP_DEFAULT_THEME', 'blankwp');
define('WP_POST_REVISIONS', false );
define('DISALLOW_FILE_EDIT',true);
define( 'JETPACK_DEV_DEBUG', true);

$table_prefix = 'wp_';
define('WP_DEBUG', true);

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

require_once(ABSPATH . 'wp-settings.php');