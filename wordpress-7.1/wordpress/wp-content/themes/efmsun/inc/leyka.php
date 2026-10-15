<?php
/**
 * Связка темы с Leyka: одна кампания на общий целевой капитал.
 *
 * @package efmsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function efmsun_leyka_active() {
	return defined( 'LEYKA_VERSION' );
}

function efmsun_leyka_campaign_id() {
	return (int) get_option( 'efmsun_leyka_campaign_id' );
}

function efmsun_maybe_setup_leyka() {
	if ( ! efmsun_leyka_active() ) {
		return;
	}
	if ( get_option( 'efmsun_leyka_configured' ) === '2' ) {
		return;
	}
	efmsun_setup_leyka();
}
add_action( 'wp_loaded', 'efmsun_maybe_setup_leyka', 20 );

function efmsun_setup_leyka() {
	if ( ! efmsun_leyka_active() || ! class_exists( 'Leyka_Campaign_Management' ) ) {
		return;
	}

	delete_option( 'leyka_init_wizard_redirect' );

	update_option( 'leyka_receiver_legal_type', 'legal' );
	update_option( 'leyka_receiver_country', 'ru' );
	update_option( 'leyka_org_full_name', get_theme_mod( 'efmsun_legal_name', 'Фонд целевого капитала МГУ имени адмирала Г.И. Невельского' ) );
	update_option( 'leyka_org_short_name', 'Эндаумент-фонд МГУ им. адм. Г.И. Невельского' );
	update_option( 'leyka_org_face_fio_ip', get_theme_mod( 'efmsun_director', '' ) );
	update_option( 'leyka_org_face_position', get_theme_mod( 'efmsun_dir_role', 'Директор' ) );
	update_option( 'leyka_org_address', get_theme_mod( 'efmsun_address', 'Владивосток, ул. Верхнепортовая, 50а' ) );
	update_option( 'leyka_org_state_reg_number', get_theme_mod( 'efmsun_ogrn', '' ) );
	update_option( 'leyka_org_inn', get_theme_mod( 'efmsun_inn', '' ) );
	update_option( 'leyka_org_kpp', get_theme_mod( 'efmsun_kpp', '' ) );
	update_option( 'leyka_org_bank_name', get_theme_mod( 'efmsun_bank', 'ПАО Сбербанк' ) );
	update_option( 'leyka_org_bank_account', get_theme_mod( 'efmsun_rs', '' ) );
	update_option( 'leyka_org_bank_corr_account', get_theme_mod( 'efmsun_ks', '' ) );
	update_option( 'leyka_org_bank_bic', get_theme_mod( 'efmsun_bik', '' ) );

	$offer = get_page_by_path( 'oferta' );
	$pd    = get_page_by_path( 'politika-pd' );
	if ( $offer ) {
		update_option( 'leyka_terms_of_service_page', $offer->ID );
	}
	if ( $pd ) {
		update_option( 'leyka_pd_terms_page', $pd->ID );
	}

	update_option( 'leyka_agree_to_terms_needed', 1 );
	update_option( 'leyka_agree_to_pd_terms_needed', 1 );
	update_option( 'leyka_agree_to_terms_link_action', 'page' );
	update_option( 'leyka_agree_to_pd_terms_link_action', 'page' );
	update_option( 'leyka_donation_form_template', 'star' );
	update_option( 'leyka_donation_sum_field_type', 'mixed' );
	update_option( 'leyka_donations_history_under_forms', 0 );
	update_option( 'leyka_donor_accounts_available', 0 );
	update_option( 'leyka_load_scripts_if_need', 1 );
	update_option( 'leyka_sber_test_mode', 1 );

	$pms = array( 'quittance-bank_order' );
	if ( get_option( 'leyka_sber_api_login' ) && get_option( 'leyka_sber_api_password' ) ) {
		array_unshift( $pms, 'sber-card' );
	}
	update_option( 'leyka_pm_available', $pms );
	update_option( 'leyka_pm_order', 'pm_order[]=' . implode( '&pm_order[]=', $pms ) );

	$campaign_id = efmsun_leyka_ensure_campaign();
	if ( $campaign_id ) {
		update_option( 'efmsun_leyka_campaign_id', $campaign_id );
		$page = get_page_by_path( 'sdelat-vklad' );
		if ( $page ) {
			wp_update_post( array(
				'ID'           => $page->ID,
				'post_content' => '[leyka_campaign_form id="' . (int) $campaign_id . '"]',
			) );
		}
	}

	if ( get_option( 'efmsun_leyka_rewrites' ) !== '1' ) {
		flush_rewrite_rules( false );
		update_option( 'efmsun_leyka_rewrites', '1' );
	}

	update_option( 'efmsun_leyka_configured', '2' );
}

function efmsun_leyka_ensure_campaign() {
	$existing_id = efmsun_leyka_campaign_id();
	if ( $existing_id && get_post( $existing_id ) ) {
		return $existing_id;
	}

	$found = get_posts( array(
		'post_type'      => Leyka_Campaign_Management::$post_type,
		'name'           => 'celevoj-kapital',
		'post_status'    => 'any',
		'posts_per_page' => 1,
		'fields'         => 'ids',
	) );
	if ( $found ) {
		return (int) $found[0];
	}

	$campaign_id = wp_insert_post( array(
		'post_type'    => Leyka_Campaign_Management::$post_type,
		'post_status'  => 'publish',
		'post_title'   => 'Пополнение целевого капитала',
		'post_name'    => 'celevoj-kapital',
		'post_content' => 'Пожертвование идёт в общий целевой капитал фонда, не на отдельный проект. Доход от капитала поддерживает образование, науку и людей МГУ имени адмирала Г.И. Невельского.',
		'post_excerpt' => 'Вклад в общий целевой капитал университета.',
	) );

	if ( ! $campaign_id || is_wp_error( $campaign_id ) ) {
		return 0;
	}

	update_post_meta( $campaign_id, 'campaign_type', 'persistent' );
	update_post_meta( $campaign_id, 'campaign_template', 'star' );
	update_post_meta( $campaign_id, 'campaign_target', 0 );
	update_post_meta( $campaign_id, 'is_finished', 0 );

	return (int) $campaign_id;
}

function efmsun_leyka_form_is_on_page( $shown ) {
	if ( is_page( 'sdelat-vklad' ) ) {
		return true;
	}
	return $shown;
}
add_filter( 'leyka_form_is_screening', 'efmsun_leyka_form_is_on_page' );
add_filter( 'leyka_modern_template_displayed', 'efmsun_leyka_form_is_on_page' );
