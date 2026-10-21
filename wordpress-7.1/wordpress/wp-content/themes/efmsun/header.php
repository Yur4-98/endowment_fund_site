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
			<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Эндаумент-фонд — Фонд целевого капитала МГУ имени адмирала Г.И. Невельского — главная">
				<span class="brand-mark" aria-hidden="true">
					<svg viewBox="0 0 42 46" fill="none" stroke="currentColor" stroke-width="1.3">
						<path d="M5 35h33l-8 7H13L5 35ZM22 4v28M20 7L7 29h13V7ZM25 12l11 17H25V12M2 44c6-3 9 2 15 0s10 2 16 0 7 0 7 0"/>
					</svg>
				</span>
				<span class="brand-text">
					<span class="brand-name">Эндаумент-фонд</span>
					<span class="brand-sub">Фонд целевого капитала МГУ имени адмирала Г.И.&nbsp;Невельского</span>
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
				<div class="header-actions">
					<a class="btn btn-header" href="<?php echo esc_url( efmsun_help_url() ); ?>">Поддержать фонд</a>
				</div>
			</nav>
		</div>
	</header>

	<?php
	if ( ! is_page_template( 'page-about.php' ) ) {
		efmsun_breadcrumbs();
	}
	?>

	<main id="content" class="site-main">
