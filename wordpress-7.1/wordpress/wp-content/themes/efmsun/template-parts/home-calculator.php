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
			<button type="button" id="modeGoal" aria-pressed="true">Мне нужен результат</button>
			<button type="button" id="modeSum" aria-pressed="false">У меня есть сумма</button>
		</div>
		<div class="impact-top">
			<div class="impact-inputs">
				<div id="sumFields" hidden>
					<label for="calcAmount">Моё пожертвование, ₽</label>
					<input type="text" id="calcAmount" inputmode="decimal" value="100 000" aria-describedby="amountError">
					<div class="amount-options" aria-label="Примеры сумм">
						<button type="button" id="amount10" data-amount="10000">10 тыс.</button>
						<button type="button" id="amount50" data-amount="50000">50 тыс.</button>
						<button type="button" id="amount100" data-amount="100000">100 тыс.</button>
					</div>
				</div>
				<div id="goalFields">
					<label for="goalType">Какую помощь я хочу финансировать ежегодно</label>
					<select id="goalType">
						<option value="veterans">Выплата преподавателю-ветерану</option>
						<option value="grant">Год выплат молодому преподавателю</option>
						<option value="equipment">Учебный комплект оборудования</option>
						<option value="scholarship">Годовая стипендия курсанту или студенту</option>
					</select>
					<label for="goalCount" class="count-label">Количество за год</label>
					<input type="number" id="goalCount" value="1" min="1" max="100000" step="1">
					<p class="impact-hint" id="goalCost">Одна условная выплата — 10 000 ₽. Годовая цель — 150 000 ₽.</p>
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
				<h3 id="impactHeading">Какую долю помощи может покрыть доход</h3>
				<span class="example-label">Сценарии расчёта</span>
			</div>
			<p class="impact-alternatives" id="impactAlternatives">В карточках — доля стоимости условной помощи, которую может покрыть расчётный доход. Результаты по карточкам не суммируются; суммы для программ могут быть меньше.</p>
			<div class="impact-cards">
				<article class="impact-card" id="cardVeterans">
					<span class="impact-index">01</span>
					<h4>Поддержка одного преподавателя-ветерана</h4>
					<p class="impact-cost">Одна условная выплата — 10 000 ₽</p>
					<p class="impact-value" id="veteransValue">1,8 %</p>
					<p class="impact-unit" id="veteransUnit">годовой цели поддержки</p>
					<div class="impact-progress" role="progressbar" id="veteransProgress" aria-label="Доля годовой цели поддержки" aria-valuemin="0" aria-valuemax="100" aria-valuenow="1.8"><span id="veteransBar" style="width:1.8%"></span></div>
					<p class="impact-goal">Годовая цель — 150 000 ₽</p>
					<p class="impact-remainder" id="veteransRemainder"></p>
				</article>
				<article class="impact-card" id="cardGrant">
					<span class="impact-index">02</span>
					<h4>Поддержка молодого преподавателя</h4>
					<p class="impact-cost">50 000 ₽ в месяц после удержания налогов · 900 000 ₽ в год на одного человека.</p>
					<p class="impact-value" id="grantValue">0,3 %</p>
					<p class="impact-unit" id="grantUnit">годовой поддержки молодого преподавателя</p>
					<div class="impact-progress" role="progressbar" id="grantProgress" aria-label="Доля годовой поддержки молодого преподавателя" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0.3"><span id="grantBar" style="width:0.3%"></span></div>
					<p class="impact-goal">Годовая цель — 900 000 ₽</p>
					<p class="impact-remainder" id="grantRemainder"></p>
				</article>
				<article class="impact-card" id="cardEquipment">
					<span class="impact-index">03</span>
					<h4>Обновление оборудования и учебной инфраструктуры</h4>
					<p class="impact-cost">Один условный комплект — 50 000 ₽</p>
					<p class="impact-value" id="equipmentValue">0,034 %</p>
					<p class="impact-unit" id="equipmentUnit">годовой цели обновления инфраструктуры</p>
					<div class="impact-progress" role="progressbar" id="equipmentProgress" aria-label="Доля годовой цели обновления" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0.034"><span id="equipmentBar" style="width:0.034%"></span></div>
					<p class="impact-goal">Годовая цель — 8 000 000 ₽</p>
					<p class="impact-remainder" id="equipmentRemainder"></p>
				</article>
				<article class="impact-card" id="cardScholarship">
					<span class="impact-index">04</span>
					<h4>Стипендия курсантам и студентам, обучающимся на отлично</h4>
					<p class="impact-cost">Одна условная годовая стипендия — 60 000 ₽</p>
					<p class="impact-value" id="scholarshipValue">16,6 %</p>
					<p class="impact-unit" id="scholarshipUnit">стоимости годовой стипендии</p>
					<div class="impact-progress" role="progressbar" id="scholarshipProgress" aria-label="Доля стоимости годовой стипендии" aria-valuemin="0" aria-valuemax="100" aria-valuenow="16.7"><span id="scholarshipBar" style="width:16.7%"></span></div>
					<p class="impact-goal">Годовая цель — 60 000 ₽</p>
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
			<p>Для молодого преподавателя ориентир фонда — 50 000 ₽ в месяц после удержания налогов, 900 000 ₽ в год на одного человека. В карточках указаны условная выплата/комплект и годовая цель, по которой считается доля покрытия: ветераны — 150 000 ₽, молодой преподаватель — 900 000 ₽, оборудование — 8 000 000 ₽, стипендия — 60 000 ₽.</p>
			<label for="calcRate">Доходность для примера, % годовых</label>
			<div class="impact-rate-row">
				<input type="text" id="calcRate" inputmode="decimal" value="27">
				<span>% в год</span>
			</div>
			<p>Вы можете изменить процент для собственного сценария. Суммы в карточках — альтернативные варианты использования рассчитанного дохода, они не складываются.</p>
		</details>
	</div>
</details>
