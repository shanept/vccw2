/**
 * {{ ansible_managed }}
 */

define( 'JETPACK_DEV_DEBUG', {{ vccw.wp_debug }} );
define( 'WP_DEBUG', {{ vccw.wp_debug }} );
define( 'WP_DEBUG_LOG', {{ vccw.wp_debug_log }} );
define( 'WP_DEBUG_DISPLAY', {{ vccw.wp_debug_display }} );
define( 'FORCE_SSL_ADMIN', {{ vccw.force_ssl_admin }} );
define( 'SAVEQUERIES', {{ vccw.savequeries }} );

{{ vccw.extra_wp_config }}
