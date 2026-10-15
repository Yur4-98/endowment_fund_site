<?php
/**
 * Template Name: FAQ
 *
 * @package efmsun
 */

get_header();

$query = new WP_Query( array(
	'post_type'      => 'efmsun_faq',
	'posts_per_page' => 50,
	'post_status'    => 'publish',
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
) );

$groups = array();
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		$cat = get_post_meta( get_the_ID(), 'efmsun_faq_category', true ) ?: 'Общее';
		$groups[ $cat ][] = array(
			'title'   => get_the_title(),
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
		<p class="page-lead">Что такое фонд, куда идут средства, как получить вычет и как сделать вклад. Не нашли ответ — напишите нам.</p>
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
		<p class="after-cards">
			<a class="btn btn-primary" href="<?php echo esc_url( efmsun_help_url() ); ?>">Поддержать фонд</a>
		</p>
	</div>
</section>

<section class="section">
	<div class="container" style="max-width:640px">
		<?php efmsun_feedback_form( array( 'title' => 'Не нашли ответ?', 'topic' => 'FAQ' ) ); ?>
	</div>
</section>

<?php
get_footer();
