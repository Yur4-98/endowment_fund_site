<?php
/**
 * Роли по ТЗ. Полный ACL WordPress не копирует 1:1 — это рабочие роли для редакции.
 *
 * @package efmsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function efmsun_register_roles() {
	if ( get_option( 'efmsun_roles_version' ) === '1' ) {
		return;
	}

	add_role( 'efmsun_lawyer', 'Юрист', array(
		'read'                  => true,
		'edit_pages'            => true,
		'edit_published_pages'  => true,
		'publish_pages'         => true,
		'upload_files'          => true,
		'edit_posts'            => true,
		'edit_published_posts'  => true,
	) );

	add_role( 'efmsun_finance', 'Финансовый редактор', array(
		'read'                 => true,
		'edit_posts'           => true,
		'upload_files'         => true,
		'edit_pages'           => true,
		'customize'            => true,
	) );

	add_role( 'efmsun_forms', 'Модератор форм', array(
		'read'       => true,
		'edit_posts' => true,
	) );

	update_option( 'efmsun_roles_version', '1' );
}
add_action( 'init', 'efmsun_register_roles' );
