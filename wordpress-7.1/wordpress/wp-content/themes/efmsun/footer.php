<?php
/**
 * Подвал, волна и плавающая кнопка.
 *
 * @package efmsun
 */
?>
	</main>

	<footer class="site-footer">
		<div class="container footer-grid">
			<div>
				<p class="footer-brand">Эндаумент-фонд</p>
				<p class="footer-note">Фонд целевого капитала МГУ имени адмирала Г.И. Невельского. Пожертвование пополняет целевой капитал. Доход от него поддерживает образование, науку и людей университета.</p>
				<p class="footer-socials">
					<a href="https://vk.ru/stfond_msun_vl" target="_blank" rel="noopener noreferrer">ВКонтакте</a>
					<a href="https://t.me/msunfund" target="_blank" rel="noopener noreferrer">Telegram</a>
					<span>MAX</span>
					<a href="https://ok.ru/profile/573431355090" target="_blank" rel="noopener noreferrer">ОК</a>
				</p>
			</div>
			<div>
				<p class="footer-label">Разделы</p>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'footer-menu',
					'fallback_cb'    => 'efmsun_fallback_menu',
					'depth'          => 1,
				) );
				?>
				<p class="footer-extra">
					<a href="<?php echo esc_url( efmsun_page_url( 'faq' ) ); ?>">FAQ</a>
					<a href="<?php echo esc_url( efmsun_page_url( 'dokumenty' ) ); ?>">Документы</a>
				</p>
			</div>
			<div>
				<p class="footer-label">Контакты</p>
				<p>
					<a href="mailto:<?php echo esc_attr( get_theme_mod( 'efmsun_email', 'info@efmsun.ru' ) ); ?>"><?php echo esc_html( get_theme_mod( 'efmsun_email', 'info@efmsun.ru' ) ); ?></a><br>
					<?php echo esc_html( get_theme_mod( 'efmsun_phone', '+7 (423) 000-00-00' ) ); ?><br>
					<?php echo esc_html( get_theme_mod( 'efmsun_address', 'Владивосток, ул. Верхнепортовая, 50а' ) ); ?>
				</p>
				<p class="footer-legal">
					<a href="<?php echo esc_url( efmsun_page_url( 'politika-pd' ) ); ?>">Политика ПД</a>
					<a href="<?php echo esc_url( efmsun_page_url( 'politika-pozhertvovaniy' ) ); ?>">Политика пожертвований</a>
					<a href="<?php echo esc_url( efmsun_page_url( 'oferta' ) ); ?>">Оферта</a>
				</p>
			</div>
		</div>
		<div class="container footer-copy">
			<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Эндаумент-фонд. Сайт в разработке, тексты-заглушки.</p>
		</div>
	</footer>
</div>

<?php get_template_part( 'template-parts/waves' ); ?>
<?php get_template_part( 'template-parts/donate-float' ); ?>
<?php wp_footer(); ?>
</body>
</html>
