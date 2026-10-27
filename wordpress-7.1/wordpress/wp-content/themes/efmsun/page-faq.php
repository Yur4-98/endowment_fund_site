<?php
/**
 * Template Name: FAQ
 * Вопросы из прототипа v5 + записи из админки.
 *
 * @package efmsun
 */

get_header();

$v5 = include EFMSUN_DIR . '/inc/faq-v5.php';
if ( ! is_array( $v5 ) ) {
	$v5 = array();
}

$groups = array();
foreach ( $v5 as $item ) {
	$cat  = $item['cat'] ?? 'Пожертвования';
	$body = str_replace(
		array(
			'href="#contacts/donation"',
			'href="#contacts/documents"',
			'href="#reports"',
		),
		array(
			'href="' . esc_url( efmsun_page_url( 'kontakty' ) ) . '"',
			'href="' . esc_url( efmsun_page_url( 'kontakty' ) ) . '"',
			'href="' . esc_url( efmsun_page_url( 'otchetnost' ) ) . '"',
		),
		$item['a']
	);
	$groups[ $cat ][] = array(
		'title'   => $item['q'],
		'content' => wpautop( wp_kses_post( $body ) ),
	);
}

$query = new WP_Query( array(
	'post_type'      => 'efmsun_faq',
	'posts_per_page' => 50,
	'post_status'    => 'publish',
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
) );

$v5_titles = array_map(
	static function ( $item ) {
		return $item['q'];
	},
	$v5
);

if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		$title = get_the_title();
		if ( in_array( $title, $v5_titles, true ) ) {
			continue;
		}
		$cat = get_post_meta( get_the_ID(), 'efmsun_faq_category', true ) ?: 'Общее';
		$groups[ $cat ][] = array(
			'title'   => $title,
			'content' => apply_filters( 'the_content', get_the_content() ),
		);
	}
	wp_reset_postdata();
}
?>

<section class="page-hero">
	<div class="container">
		<p class="eyebrow">FAQ</p>
		<h1>Вопросы о фонде и пожертвованиях</h1>
		<p class="page-lead">Что такое целевой капитал, куда идут средства и как сделать вклад. Не нашли ответ — напишите нам.</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<?php foreach ( $groups as $cat => $items ) : ?>
			<h2><?php echo esc_html( $cat ); ?></h2>
			<div class="faq-list">
				<?php foreach ( $items as $item ) : ?>
					<details class="faq-item">
						<summary><?php echo esc_html( $item['title'] ); ?></summary>
						<div><?php echo wp_kses_post( $item['content'] ); ?></div>
					</details>
				<?php endforeach; ?>
			</div>
		<?php endforeach; ?>
		<?php get_template_part( 'template-parts/section', 'support' ); ?>
	</div>
</section>

<section class="section">
	<div class="container" style="max-width:640px">
		<?php efmsun_feedback_form( array( 'title' => 'Не нашли ответ?', 'topic' => 'FAQ' ) ); ?>
	</div>
</section>

<?php
get_footer();
