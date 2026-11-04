<?php
/**
 * Подвал сайта.
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
					<span class="footer-social-inactive" aria-disabled="true" title="Скоро">MAX</span>
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
					<?php
					$footer_email = get_theme_mod( 'efmsun_email', 'info@efmsun.ru' );
					$footer_phone = get_theme_mod( 'efmsun_phone', '+7 (984) 211-45-72' );
					if ( in_array( $footer_email, array( 'konotop@msun.ru', '' ), true ) ) {
						$footer_email = 'info@efmsun.ru';
					}
					if ( in_array( $footer_phone, array( '+7 (423) 230-10-26', '' ), true ) ) {
						$footer_phone = '+7 (984) 211-45-72';
					}
					$footer_tel = preg_replace( '/\D+/', '', $footer_phone );
					?>
					<a href="mailto:<?php echo esc_attr( $footer_email ); ?>"><?php echo esc_html( $footer_email ); ?></a><br>
					<a href="tel:+<?php echo esc_attr( $footer_tel ); ?>"><?php echo esc_html( $footer_phone ); ?></a><br>
					<?php echo esc_html( get_theme_mod( 'efmsun_address', 'Владивосток, ул. Верхнепортовая, 50-а' ) ); ?>
				</p>
				<p class="footer-legal">
					<a href="<?php echo esc_url( efmsun_page_url( 'politika-pd' ) ); ?>">Политика ПД</a>
					<a href="<?php echo esc_url( efmsun_page_url( 'politika-pozhertvovaniy' ) ); ?>">Политика пожертвований</a>
					<a href="<?php echo esc_url( efmsun_page_url( 'oferta' ) ); ?>">Оферта</a>
				</p>
			</div>
		</div>
		<div class="container footer-copy">
			<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Фонд целевого капитала МГУ им. адм. Г.И. Невельского</p>
		</div>
	</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
