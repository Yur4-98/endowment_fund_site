<?php
/**
 * Шапка сайта.
 *
 * @package efmsun
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#content">К содержанию</a>

<div class="site">
	<header class="site-header">
		<div class="container header-inner">
			<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<span class="brand-mark" aria-hidden="true">EF</span>
				<?php endif; ?>
				<span class="brand-text">
					<span class="brand-name">Фонд целевого капитала</span>
					<span class="brand-sub">МГУ им. адм. Г.И. Невельского</span>
				</span>
			</a>

			<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav">
				<span class="nav-toggle-bar"></span>
				<span class="screen-reader-text">Меню</span>
			</button>

			<nav id="site-nav" class="site-nav" aria-label="Главное меню">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'menu',
					'fallback_cb'    => 'efmsun_fallback_menu',
				) );
				?>
				<form class="header-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label class="screen-reader-text" for="header-s">Поиск</label>
					<input id="header-s" type="search" name="s" placeholder="Поиск" value="<?php echo esc_attr( get_search_query() ); ?>">
					<button type="submit" class="header-search-btn">Найти</button>
				</form>
				<a class="btn btn-header" href="<?php echo esc_url( efmsun_help_url() ); ?>">Поддержать фонд</a>
			</nav>
		</div>
	</header>

	<?php efmsun_breadcrumbs(); ?>

	<main id="content" class="site-main">
