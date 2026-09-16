<?php
/**
 * Тема EF MSUN.
 *
 * @package efmsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EFMSUN_VERSION', '0.1.3' );
define( 'EFMSUN_DIR', get_template_directory() );
define( 'EFMSUN_URI', get_template_directory_uri() );

require_once EFMSUN_DIR . '/inc/setup.php';
require_once EFMSUN_DIR . '/inc/cpt.php';
require_once EFMSUN_DIR . '/inc/customizer.php';
require_once EFMSUN_DIR . '/inc/seed.php';
