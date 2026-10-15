<?php
/**
 * Типы записей и таксономии по ТЗ.
 *
 * @package efmsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function efmsun_register_cpt() {
	register_post_type( 'efmsun_project', array(
		'labels'       => array(
			'name'          => 'Проекты',
			'singular_name' => 'Проект',
			'add_new_item'  => 'Добавить проект',
		),
		'public'       => true,
		'has_archive'  => true,
		'rewrite'      => array( 'slug' => 'proekt' ),
		'menu_icon'    => 'dashicons-portfolio',
		'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'show_in_rest' => true,
	) );

	register_post_type( 'efmsun_report', array(
		'labels'       => array(
			'name'          => 'Отчёты',
			'singular_name' => 'Отчёт',
			'add_new_item'  => 'Добавить отчёт',
		),
		'public'       => true,
		'has_archive'  => false,
		'rewrite'      => array( 'slug' => 'otchet' ),
		'menu_icon'    => 'dashicons-analytics',
		'supports'     => array( 'title', 'editor', 'excerpt', 'custom-fields' ),
		'show_in_rest' => true,
	) );

	register_post_type( 'efmsun_document', array(
		'labels'       => array(
			'name'          => 'Официальные документы',
			'singular_name' => 'Документ',
			'add_new_item'  => 'Добавить документ',
		),
		'public'       => true,
		'has_archive'  => false,
		'rewrite'      => array( 'slug' => 'dokument' ),
		'menu_icon'    => 'dashicons-media-document',
		'supports'     => array( 'title', 'editor', 'excerpt', 'custom-fields' ),
		'show_in_rest' => true,
	) );

	register_post_type( 'efmsun_faq', array(
		'labels'       => array(
			'name'          => 'FAQ',
			'singular_name' => 'Вопрос',
			'add_new_item'  => 'Добавить вопрос',
		),
		'public'       => true,
		'has_archive'  => false,
		'rewrite'      => array( 'slug' => 'vopros' ),
		'menu_icon'    => 'dashicons-editor-help',
		'supports'     => array( 'title', 'editor', 'page-attributes' ),
		'show_in_rest' => true,
	) );

	register_post_type( 'efmsun_lead', array(
		'labels'              => array(
			'name'          => 'Обращения',
			'singular_name' => 'Обращение',
		),
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_icon'           => 'dashicons-email-alt',
		'capability_type'     => 'post',
		'supports'            => array( 'title', 'editor', 'custom-fields' ),
		'exclude_from_search' => true,
	) );

	register_post_meta( 'efmsun_report', 'efmsun_file_url', array( 'show_in_rest' => true, 'single' => true, 'type' => 'string' ) );
	register_post_meta( 'efmsun_report', 'efmsun_year', array( 'show_in_rest' => true, 'single' => true, 'type' => 'string' ) );
	register_post_meta( 'efmsun_report', 'efmsun_doc_type', array( 'show_in_rest' => true, 'single' => true, 'type' => 'string' ) );
	register_post_meta( 'efmsun_document', 'efmsun_file_url', array( 'show_in_rest' => true, 'single' => true, 'type' => 'string' ) );
	register_post_meta( 'efmsun_document', 'efmsun_doc_type', array( 'show_in_rest' => true, 'single' => true, 'type' => 'string' ) );
	register_post_meta( 'efmsun_faq', 'efmsun_faq_category', array( 'show_in_rest' => true, 'single' => true, 'type' => 'string' ) );
	register_post_meta( 'efmsun_faq', 'efmsun_show_on_donate', array( 'show_in_rest' => true, 'single' => true, 'type' => 'boolean' ) );
}
add_action( 'init', 'efmsun_register_cpt' );

function efmsun_add_meta_boxes() {
	$screens = array( 'efmsun_report', 'efmsun_document' );
	foreach ( $screens as $screen ) {
		add_meta_box( 'efmsun_file', 'Файл и тип', 'efmsun_file_meta_box', $screen, 'side' );
	}
	add_meta_box( 'efmsun_faq_meta', 'Категория FAQ', 'efmsun_faq_meta_box', 'efmsun_faq', 'side' );
	foreach ( array( 'page', 'post', 'efmsun_project', 'efmsun_document', 'efmsun_report', 'efmsun_faq' ) as $screen ) {
		add_meta_box( 'efmsun_seo', 'SEO', 'efmsun_seo_meta_box', $screen, 'normal' );
	}
}
add_action( 'add_meta_boxes', 'efmsun_add_meta_boxes' );

function efmsun_file_meta_box( $post ) {
	wp_nonce_field( 'efmsun_meta', 'efmsun_meta_nonce' );
	$url  = get_post_meta( $post->ID, 'efmsun_file_url', true );
	$type = get_post_meta( $post->ID, 'efmsun_doc_type', true );
	$year = get_post_meta( $post->ID, 'efmsun_year', true );
	echo '<p><label>URL файла<br><input type="url" name="efmsun_file_url" value="' . esc_attr( $url ) . '" class="widefat"></label></p>';
	echo '<p><label>Тип<br><input type="text" name="efmsun_doc_type" value="' . esc_attr( $type ) . '" class="widefat" placeholder="Годовой отчёт / Устав"></label></p>';
	if ( 'efmsun_report' === $post->post_type ) {
		echo '<p><label>Год<br><input type="text" name="efmsun_year" value="' . esc_attr( $year ) . '" class="widefat"></label></p>';
	}
}

function efmsun_faq_meta_box( $post ) {
	wp_nonce_field( 'efmsun_meta', 'efmsun_meta_nonce' );
	$cat  = get_post_meta( $post->ID, 'efmsun_faq_category', true );
	$show = get_post_meta( $post->ID, 'efmsun_show_on_donate', true );
	echo '<p><label>Категория<br><input type="text" name="efmsun_faq_category" value="' . esc_attr( $cat ) . '" class="widefat"></label></p>';
	echo '<p><label><input type="checkbox" name="efmsun_show_on_donate" value="1"' . checked( $show, '1', false ) . '> Показывать на странице «Как помочь»</label></p>';
}

function efmsun_seo_meta_box( $post ) {
	wp_nonce_field( 'efmsun_meta', 'efmsun_meta_nonce' );
	$title = get_post_meta( $post->ID, 'efmsun_meta_title', true );
	$desc  = get_post_meta( $post->ID, 'efmsun_meta_description', true );
	echo '<p><label>Meta title<br><input type="text" name="efmsun_meta_title" value="' . esc_attr( $title ) . '" class="widefat"></label></p>';
	echo '<p><label>Meta description<br><textarea name="efmsun_meta_description" class="widefat" rows="3">' . esc_textarea( $desc ) . '</textarea></label></p>';
}

function efmsun_save_meta( $post_id ) {
	if ( ! isset( $_POST['efmsun_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['efmsun_meta_nonce'] ) ), 'efmsun_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	$fields = array( 'efmsun_file_url', 'efmsun_doc_type', 'efmsun_year', 'efmsun_faq_category', 'efmsun_meta_title', 'efmsun_meta_description' );
	foreach ( $fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}
	update_post_meta( $post_id, 'efmsun_show_on_donate', empty( $_POST['efmsun_show_on_donate'] ) ? '' : '1' );
}
add_action( 'save_post', 'efmsun_save_meta' );
