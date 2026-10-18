<?php
/**
 * Тема EF MSUN.
 *
 * @package efmsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EFMSUN_VERSION', '0.3.0' );
define( 'EFMSUN_DIR', get_template_directory() );
define( 'EFMSUN_URI', get_template_directory_uri() );

require_once EFMSUN_DIR . '/inc/setup.php';
require_once EFMSUN_DIR . '/inc/cpt.php';
require_once EFMSUN_DIR . '/inc/customizer.php';
require_once EFMSUN_DIR . '/inc/roles.php';
require_once EFMSUN_DIR . '/inc/seo.php';
require_once EFMSUN_DIR . '/inc/forms.php';
require_once EFMSUN_DIR . '/inc/leyka.php';
require_once EFMSUN_DIR . '/inc/seed.php';
