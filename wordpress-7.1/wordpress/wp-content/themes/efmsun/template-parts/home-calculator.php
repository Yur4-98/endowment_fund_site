<?php
/**
 * Калькулятор вклада (модель доходности 27% за 2025).
 *
 * @package efmsun
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$help_url     = efmsun_help_url();
$contacts_url = efmsun_page_url( 'kontakty' );
?>
<details class="calc" id="calculator">
	<summary>
		<span>На что хватит моего пожертвования?</span>
		<span class="plus" aria-hidden="true">+</span>
	</summary>
	<div class="calc-inner impact-calc">
		<p class="impact-intro">Посмотрите, какую помощь может дать доход от вашего пожертвования. Или выберите результат и узнайте, какая сумма целевого капитала для него нужна.</p>
		<div class="mode-row" role="group" aria-label="Режим расчёта">
			<button type="button" id="modeSum" aria-pressed="true">У меня есть сумма</button>
			<button type="button" id="modeGoal" aria-pressed="false">Мне нужен результат</button>
		</div>
		<div class="impact-top">
			<div class="impact-inputs">
				<div id="sumFields">
					<label for="calcAmount">Моё пожертвование, ₽</label>
					<input type="text" id="calcAmount" inputmode="decimal" value="100 000" aria-describedby="amountError">
					<div class="amount-options" aria-label="Примеры сумм">
						<button type="button" id="amount100" data-amount="100000">100 тыс.</button>
						<button type="button" id="amount500" data-amount="500000">500 тыс.</button>
						<button type="button" id="amount1000" data-amount="1000000">1 млн</button>
					</div>
				</div>
				<div id="goalFields" hidden>
					<label for="goalType">Какую помощь я хочу финансировать ежегодно</label>
					<select id="goalType">
						<option value="veterans">Выплата преподавателю-ветерану</option>
						<option value="grant">Год выплат молодому преподавателю (без налогов и взносов)</option>
						<option value="equipment">Учебный комплект оборудования</option>
						<option value="scholarship">Годовая стипендия курсанту или студенту</option>
					</select>
					<label for="goalCount" class="count-label">Количество за год</label>
					<input type="number" id="goalCount" value="1" min="1" max="100000" step="1">
					<p class="impact-hint" id="goalCost">Условная стоимость одной выплаты — 10 000 ₽.</p>
				</div>
				<div class="error" id="amountError" role="status"></div>
			</div>
			<div class="impact-summary" aria-live="polite">
				<p class="eyebrow" id="resultTitle">Расчётный доход за год до расходов</p>
				<div class="result-num" id="calcResult">27 000 ₽</div>
				<p class="result-period" id="resultPeriod">от пожертвования 100 000 ₽ при доходности 27 % за год — как в 2025 году</p>
				<p class="impact-model-note">27 % — фактическая доходность фонда за 2025 год, по данным фонда. Расчёт показывает возможный доход при повторении этого показателя, без учёта расходов и распределения дохода. Будущая доходность и сумма, доступная программам, могут отличаться.</p>
			</div>
		</div>
		<div id="impactResults" class="impact-results" aria-live="polite">
			<div class="impact-result-heading">
				<h3 id="impactHeading">Этого дохода может хватить на</h3>
				<span class="example-label">Сценарии расчёта</span>
			</div>
			<p class="impact-alternatives" id="impactAlternatives">Каждая карточка — отдельный пример на основе дохода до расходов. Суммы, доступные программам, могут быть меньше. Результаты не суммируются.</p>
			<div class="impact-cards">
				<article class="impact-card" id="cardVeterans">
					<span class="impact-index">01</span>
					<h4>Поддержка преподавателей-ветеранов</h4>
					<p class="impact-value" id="veteransValue">1</p>
					<p class="impact-unit" id="veteransUnit">выплата помощи</p>
					<div class="impact-progress" role="progressbar" id="veteransProgress" aria-label="Доля стоимости одной выплаты" aria-valuemin="0" aria-valuemax="100" aria-valuenow="100"><span id="veteransBar" style="width:100%"></span></div>
					<p class="impact-cost">Одна условная выплата — 10 000 ₽</p>
					<p class="impact-remainder" id="veteransRemainder"></p>
				</article>
				<article class="impact-card" id="cardGrant">
					<span class="impact-index">02</span>
					<h4>Поддержка молодого преподавателя</h4>
					<p class="impact-value" id="grantValue">4,5 %</p>
					<p class="impact-unit" id="grantUnit">годовых выплат на руки</p>
					<div class="impact-progress" role="progressbar" id="grantProgress" aria-label="Доля годовых выплат на руки" aria-valuemin="0" aria-valuemax="100" aria-valuenow="4.5"><span id="grantBar" style="width:4.5%"></span></div>
					<p class="impact-cost">50 000 ₽ в месяц на руки · 600 000 ₽ в год. Налоги и взносы сверх этой суммы.</p>
					<p class="impact-remainder" id="grantRemainder"></p>
				</article>
				<article class="impact-card" id="cardEquipment">
					<span class="impact-index">03</span>
					<h4>Обновление оборудования и учебной инфраструктуры</h4>
					<p class="impact-value" id="equipmentValue">20 %</p>
					<p class="impact-unit" id="equipmentUnit">стоимости одного учебного комплекта</p>
					<div class="impact-progress" role="progressbar" id="equipmentProgress" aria-label="Доля стоимости одного комплекта" aria-valuemin="0" aria-valuemax="100" aria-valuenow="20"><span id="equipmentBar" style="width:20%"></span></div>
					<p class="impact-cost">Один условный комплект — 50 000 ₽</p>
					<p class="impact-remainder" id="equipmentRemainder"></p>
				</article>
				<article class="impact-card" id="cardScholarship">
					<span class="impact-index">04</span>
					<h4>Стипендия курсантам и студентам, обучающимся на отлично</h4>
					<p class="impact-value" id="scholarshipValue">16,6 %</p>
					<p class="impact-unit" id="scholarshipUnit">стоимости годовой стипендии</p>
					<div class="impact-progress" role="progressbar" id="scholarshipProgress" aria-label="Доля стоимости годовой стипендии" aria-valuemin="0" aria-valuemax="100" aria-valuenow="16.7"><span id="scholarshipBar" style="width:16.7%"></span></div>
					<p class="impact-cost">Одна условная годовая стипендия — 60 000 ₽</p>
					<p class="impact-remainder" id="scholarshipRemainder"></p>
				</article>
			</div>
			<div class="impact-navigation" id="impactNavigation">
				<div class="impact-rail" aria-hidden="true"><span id="impactThumb"></span></div>
				<button class="impact-arrow" id="nextImpact" type="button" aria-label="Показать следующее направление"><span aria-hidden="true">⟶</span></button>
			</div>
			<div class="impact-actions">
				<a class="btn" href="<?php echo esc_url( $help_url ); ?>">Поддержать фонд</a>
				<a class="textlink" href="<?php echo esc_url( $contacts_url ); ?>">Обсудить помощь с фондом</a>
			</div>
		</div>
		<details class="impact-assumptions">
			<summary>Как устроен пример расчёта</summary>
			<p>По данным фонда, фактическая доходность целевого капитала за 2025 год составила 27 %. Калькулятор применяет этот исторический показатель к указанной сумме только для иллюстрации. Это не прогноз и не гарантия доходности или выплат: расходы, порядок распределения дохода и будущие результаты могут изменить сумму, доступную программам.</p>
			<p>Для молодого преподавателя фонд выплачивает 50 000 ₽ в месяц на руки — 600 000 ₽ за год. Налоги и взносы оплачиваются дополнительно, их размер здесь не задан. Поэтому показанная сумма капитала для этого сценария — нижняя граница без налогов и взносов. Выплата ветерану (10 000 ₽), учебный комплект (50 000 ₽) и годовая стипендия (60 000 ₽) остаются условными примерами.</p>
			<label for="calcRate">Доходность для примера, % годовых</label>
			<div class="impact-rate-row">
				<input type="text" id="calcRate" inputmode="decimal" value="27">
				<span>% в год</span>
			</div>
			<p>Вы можете изменить процент для собственного сценария. Суммы в карточках — альтернативные варианты использования рассчитанного дохода, они не складываются.</p>
		</details>
	</div>
</details>
