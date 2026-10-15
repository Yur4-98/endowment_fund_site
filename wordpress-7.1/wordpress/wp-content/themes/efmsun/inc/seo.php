<?php
/**
 * SEO, schema.org, robots.
 *
 * @package efmsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function efmsun_document_title( $title ) {
	if ( is_singular() ) {
		$custom = get_post_meta( get_the_ID(), 'efmsun_meta_title', true );
		if ( $custom ) {
			$title['title'] = $custom;
		}
	}
	return $title;
}
add_filter( 'document_title_parts', 'efmsun_document_title' );

function efmsun_seo_head() {
	$desc  = '';
	$title = wp_get_document_title();
	$image = '';
	if ( is_singular() ) {
		$desc = get_post_meta( get_the_ID(), 'efmsun_meta_description', true );
		if ( ! $desc ) {
			$desc = get_the_excerpt();
		}
		if ( has_post_thumbnail() ) {
			$image = get_the_post_thumbnail_url( get_the_ID(), 'large' );
		}
	} elseif ( is_front_page() ) {
		$desc = get_theme_mod( 'efmsun_hero_text', '' );
	}
	if ( $desc ) {
		$clean = esc_attr( wp_strip_all_tags( $desc ) );
		echo '<meta name="description" content="' . $clean . '">' . "\n";
		echo '<meta property="og:description" content="' . $clean . '">' . "\n";
	}
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:type" content="' . ( is_singular( 'post' ) ? 'article' : 'website' ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( ( is_singular() ? get_permalink() : home_url( '/' ) ) ) . '">' . "\n";
	if ( $image ) {
		echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
	}
	if ( is_search() || is_404() ) {
		echo '<meta name="robots" content="noindex,follow">' . "\n";
	}

	$name    = get_theme_mod( 'efmsun_legal_name', get_bloginfo( 'name' ) );
	$url     = home_url( '/' );
	$schema  = array(
		'@context' => 'https://schema.org',
		'@type'    => 'NGO',
		'name'     => $name,
		'url'      => $url,
		'email'    => get_theme_mod( 'efmsun_email', 'info@efmsun.ru' ),
		'address'  => get_theme_mod( 'efmsun_address', '' ),
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
	echo '<script type="application/ld+json">' . wp_json_encode( array(
		'@context'        => 'https://schema.org',
		'@type'           => 'WebSite',
		'name'            => $name,
		'url'             => $url,
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => home_url( '/?s={search_term_string}' ),
			'query-input' => 'required name=search_term_string',
		),
	), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";

	if ( is_page( 'faq' ) ) {
		$faq = get_posts( array( 'post_type' => 'efmsun_faq', 'numberposts' => 20 ) );
		if ( $faq ) {
			$items = array();
			foreach ( $faq as $item ) {
				$items[] = array(
					'@type'          => 'Question',
					'name'           => $item->post_title,
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => wp_strip_all_tags( $item->post_content ),
					),
				);
			}
			echo '<script type="application/ld+json">' . wp_json_encode( array(
				'@context'   => 'https://schema.org',
				'@type'      => 'FAQPage',
				'mainEntity' => $items,
			), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
		}
	}
}
add_action( 'wp_head', 'efmsun_seo_head' );
