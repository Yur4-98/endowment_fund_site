(function () {
'use strict';
function ready(fn){ if(document.readyState!=='loading') fn(); else document.addEventListener('DOMContentLoaded', fn); }
ready(function () {
if (!document.getElementById('heroShip') && !document.getElementById('programTrack')) return;
const $=id=>document.getElementById(id);
const reduced=window.matchMedia('(prefers-reduced-motion: reduce)');
const shipImage=$('heroShip');
const shipAnimation=(window.efmsunHome&&efmsunHome.shipWebp)||'';
const shipPoster=(window.efmsunHome&&efmsunHome.shipPoster)||'';
let replayCount=0, shipStatusTimer=0;
function staticShip(){shipImage.src=shipPoster;shipImage.style.visibility='visible';$('replayShip').disabled=true;$('shipStatus').textContent='Рисунок парусника';}
function drawShip(){
 if(reduced.matches||$('staticMode').checked){staticShip();return;}
 $('replayShip').disabled=false;
 shipImage.style.visibility='hidden';
 shipImage.src=shipAnimation+'?replay='+(++replayCount);
 $('shipStatus').textContent='Парусник рисуется';
 clearTimeout(shipStatusTimer);shipStatusTimer=setTimeout(()=>$('shipStatus').textContent='Рисунок парусника завершён',8300);
}
if(shipImage){
shipImage.addEventListener('load',()=>{if(shipImage.src.includes('ship-transparent'))shipImage.style.visibility='visible';});
shipImage.addEventListener('error',()=>{if(!shipImage.src.includes('ship-poster'))staticShip();});
if($('replayShip'))$('replayShip').addEventListener('click',drawShip);
}
if($('menuButton')) $('menuButton').addEventListener('click',()=>{const open=$('menuButton').getAttribute('aria-expanded')!=='true';$('menuButton').setAttribute('aria-expanded',String(open));$('menuButton').setAttribute('aria-label',open?'Закрыть меню':'Открыть меню');$('mobileNav').classList.toggle('open',open);});
if($('mobileNav')) $('mobileNav').addEventListener('click',()=>{$('mobileNav').classList.remove('open');$('menuButton').setAttribute('aria-expanded','false');$('menuButton').setAttribute('aria-label','Открыть меню');});
const descriptions=[
 'Вы перечисляете пожертвование фонду. Деньги предназначены для пополнения целевого капитала и долгосрочной поддержки университета.',
 'Пожертвования объединяются в целевом капитале. Основная сумма сохраняется как источник поддержки на будущие годы.',
 'Фонд передаёт капитал в доверительное управление профессиональной управляющей компании. Она инвестирует средства в рамках установленных правил.',
 'По итогам управления формируется инвестиционный доход. Его часть после предусмотренных расходов фонд направляет на утверждённые программы поддержки университета.',
 'После распределения дохода основная сумма остаётся в целевом капитале и продолжает управляться в следующем периоде. Новый доход может снова поддержать программы.'
];
let elapsed=0,running=false,frame=0,lastTime=0,manualStep=0,activeStage=-1;
let syncMotion=function(){};
if($('mainRoute')&&$('returnRoute')&&$('playRoute')&&$('staticMode')){
const mainLength=$('mainRoute').getTotalLength(),returnLength=$('returnRoute').getTotalLength();
function showStage(stage,cycle=false){document.querySelectorAll('[data-stage]').forEach(e=>{const active=Number(e.dataset.stage)===stage;e.classList.toggle('active',active);if(e.tagName==='BUTTON')e.setAttribute('aria-pressed',String(active));});if(activeStage!==stage||cycle){$('stageExplanation').textContent=descriptions[cycle?4:stage];activeStage=stage;}$('programBranch').classList.toggle('lit',stage===3||cycle);}
function mobileBoatPosition(stage,fraction=0){const items=document.querySelectorAll('.mobile-step');if(!items.length||!$('mobileBoat'))return;const start=items[stage].offsetTop,end=items[Math.min(stage+1,3)].offsetTop;$('mobileBoat').style.transform='translateY('+(start+(end-start)*fraction-4)+'px)';}
function placeAtStage(stage){$('routeBoat').setAttribute('transform','translate('+(120+stage*260-19)+' 69)');mobileBoatPosition(stage);}
function noMotion(){return reduced.matches||$('staticMode').checked;}
function stopRoute(){running=false;cancelAnimationFrame(frame);}
function updateRoute(){let point,stage;if(elapsed<7){const fraction=elapsed/7;point=$('mainRoute').getPointAtLength(mainLength*fraction);stage=Math.min(3,Math.floor(fraction*3+.12));showStage(stage);mobileBoatPosition(Math.min(2,Math.floor(fraction*3)),fraction>=1?0:(fraction*3)%1);}else if(elapsed<9){point=$('mainRoute').getPointAtLength(mainLength);showStage(3);mobileBoatPosition(3);}else{const fraction=Math.min(1,(elapsed-9)/2);point=$('returnRoute').getPointAtLength(returnLength*fraction);showStage(2,true);const items=document.querySelectorAll('.mobile-step');$('mobileBoat').style.transform='translateY('+(items[3].offsetTop+(items[2].offsetTop-items[3].offsetTop)*fraction-4)+'px)';}$('routeBoat').setAttribute('transform','translate('+(point.x-19)+' '+(point.y-36)+')');}
function tick(time){if(!running)return;elapsed+=Math.max(0,(time-lastTime)/1000);lastTime=time;updateRoute();if(elapsed>=11){stopRoute();elapsed=11;$('playRoute').textContent='Повторить маршрут';return;}frame=requestAnimationFrame(tick);}
function playRoute(){if(noMotion()){stopRoute();manualStep=(manualStep+1)%5;const stage=manualStep===4?2:manualStep;showStage(stage,manualStep===4);placeAtStage(stage);$('playRoute').textContent=manualStep===4?'Начать сначала ↻':'Следующий этап';return;}if(running){stopRoute();$('playRoute').textContent='Продолжить маршрут';return;}if(elapsed>=11){elapsed=0;activeStage=-1;}running=true;lastTime=performance.now();$('playRoute').textContent='Пауза ‖';frame=requestAnimationFrame(tick);}
$('playRoute').addEventListener('click',playRoute);
syncMotion=function(){stopRoute();elapsed=0;manualStep=0;activeStage=-1;showStage(0);placeAtStage(0);$('playRoute').textContent=noMotion()?'Следующий этап':'Посмотреть маршрут';if(noMotion()){if(shipImage)staticShip();}else if(shipImage&&shipImage.src.includes('ship-poster'))drawShip();};
$('staticMode').checked=reduced.matches;$('staticMode').addEventListener('change',syncMotion);reduced.addEventListener('change',syncMotion);
document.querySelectorAll('[data-stage]').forEach(e=>e.addEventListener('click',()=>{stopRoute();const stage=Number(e.dataset.stage);elapsed=0;manualStep=stage;showStage(stage);placeAtStage(stage);$('playRoute').textContent=noMotion()?'Следующий этап':'Посмотреть маршрут';}));
window.addEventListener('resize',()=>{if(!running)mobileBoatPosition(Math.max(0,activeStage));});
document.addEventListener('visibilitychange',()=>{if(document.hidden&&running){stopRoute();$('playRoute').textContent='Продолжить маршрут';}});
}
/* IMPACT MODEL START */
const IMPACT_ITEMS={
  veterans:{cost:10000,part:'стоимости одной выплаты помощи',one:'выплата помощи',few:'выплаты помощи',many:'выплат помощи',hint:'Условная стоимость одной выплаты — 10 000 ₽.'},
  grant:{cost:600000,part:'годовых выплат на руки',one:'год поддержки',few:'года поддержки',many:'лет поддержки',hint:'50 000 ₽ в месяц на руки × 12 = 600 000 ₽ за год. Налоги и взносы оплачиваются дополнительно и в расчёт не включены.'},
  equipment:{cost:50000,part:'стоимости одного учебного комплекта',one:'учебный комплект',few:'учебных комплекта',many:'учебных комплектов',hint:'Условная стоимость одного учебного комплекта — 50 000 ₽.'},
  scholarship:{cost:60000,part:'стоимости годовой стипендии',one:'годовая стипендия',few:'годовые стипендии',many:'годовых стипендий',hint:'Условная стоимость годовой стипендии — 60 000 ₽.'}
};
function impactFromDonation(donation,rate){
  const budget=Math.round(donation*rate)/100,items={};
  for(const [key,item] of Object.entries(IMPACT_ITEMS)){
    const ratio=budget/item.cost;
    const whole=Math.floor(ratio+1e-10);
    items[key]={ratio,whole,progress:Math.min(100,ratio*100),remainder:Math.max(0,budget-whole*item.cost)};
  }
  return {donation,budget,items};
}
function donationForImpact(key,count,rate){
  if(!IMPACT_ITEMS[key]||rate<=0)return null;
  const budget=IMPACT_ITEMS[key].cost*count;
  const donation=Math.ceil(budget/(rate/100));
  return impactFromDonation(donation,rate);
}
/* IMPACT MODEL END */
let mode='sum';
const numberFormat=new Intl.NumberFormat('ru-RU',{maximumFractionDigits:0});
const money=n=>new Intl.NumberFormat('ru-RU',{maximumFractionDigits:2}).format(n)+' ₽';
function parseImpactNumber(id){const raw=$(id).value.trim().replace(/[\s\u00a0\u202f]/g,'').replace(',','.');return /^\d+(?:\.\d+)?$/.test(raw)?Number(raw):NaN;}
function pluralImpact(n,item){const a=n%10,b=n%100;return a===1&&b!==11?item.one:a>=2&&a<=4&&(b<12||b>14)?item.few:item.many;}
function failImpact(message){$('amountError').textContent=message;$('calcResult').textContent='—';$('resultPeriod').textContent='Проверьте сумму или параметры примера.';$('impactResults').hidden=true;$('calcAmount').setAttribute('aria-invalid','true');}
function showImpactCard(key,result){const item=IMPACT_ITEMS[key],effect=result.items[key];
  if(effect.whole>=1){$(key+'Value').textContent=numberFormat.format(effect.whole);$(key+'Unit').textContent=pluralImpact(effect.whole,item);$(key+'Remainder').textContent=key==='grant'?'Покрыта сумма выплат на руки; налоги и взносы сверх неё.':effect.remainder>=.01?'Остаток годового дохода: '+money(effect.remainder):'Полная стоимость выбранной помощи.';}
  else{const percent=effect.ratio*100;$(key+'Value').textContent=percent>0&&percent<.1?'< 0,1 %':new Intl.NumberFormat('ru-RU',{maximumFractionDigits:1}).format(Math.floor(percent*10)/10)+' %';$(key+'Unit').textContent=item.part;$(key+'Remainder').textContent=percent===0?'По этому сценарию дохода на помощь нет.':'Часть стоимости можно покрыть доходом.';}
  $(key+'Bar').style.width=effect.progress+'%';$(key+'Progress').setAttribute('aria-valuenow',String(Math.round(effect.progress*10)/10));
}
function calculate(){const rate=parseImpactNumber('calcRate'),key=$('goalType').value,count=parseImpactNumber('goalCount'),donation=parseImpactNumber('calcAmount');
  $('goalCost').textContent=IMPACT_ITEMS[key]?.hint??'';
  if(!Number.isFinite(rate)||rate<0||rate>100){failImpact('Укажите доходность для примера от 0 до 100 %.');return;}
  let result;
  if(mode==='sum'){if(!Number.isFinite(donation)||donation<.01||donation>1e12){failImpact('Введите сумму пожертвования от 0,01 до 1 трлн ₽.');return;}result=impactFromDonation(donation,rate);}
  else{if(!Number.isInteger(count)||count<1||count>100000){failImpact('Укажите целое количество от 1 до 100 000.');return;}if(rate===0){failImpact('При нулевой ставке помощь из дохода рассчитать нельзя.');return;}result=donationForImpact(key,count,rate);if(!result||result.donation>1e12){failImpact('Для выбранной цели требуется слишком большая сумма. Измените параметры примера.');return;}}
  $('amountError').textContent='';$('calcAmount').setAttribute('aria-invalid','false');$('impactResults').hidden=false;
  $('resultTitle').textContent=mode==='sum'?'Расчётный доход за год до расходов':key==='grant'?'Ориентир капитала без налогов и взносов':'Ориентир суммы целевого капитала';
  $('calcResult').textContent=money(mode==='sum'?result.budget:result.donation);
  $('resultPeriod').textContent=mode==='sum'?'от пожертвования '+money(result.donation)+' при доходности '+rate.toLocaleString('ru-RU')+' % за год':'чтобы направлять '+money(IMPACT_ITEMS[key].cost*count)+' в год на выбранную помощь при доходности '+rate.toLocaleString('ru-RU')+' % за год'+(key==='grant'?' (без налогов и взносов)':'');
  $('impactHeading').textContent=mode==='sum'?'Этого дохода может хватить на':'Выбранный результат помощи за год';
  $('impactAlternatives').textContent=mode==='sum'?'Каждая карточка — отдельный пример на основе дохода до расходов. Суммы, доступные программам, могут быть меньше. Результаты не суммируются.':'Показан один выбранный сценарий. Расчёт иллюстративный; доходность в будущем может отличаться.';
  document.querySelector('.impact-cards').classList.toggle('single-goal',mode==='goal');
  $('impactNavigation').hidden=mode==='goal';
  if(mode==='goal')document.querySelector('.impact-cards').scrollLeft=0;
  for(const itemKey of Object.keys(IMPACT_ITEMS)){$('card'+itemKey[0].toUpperCase()+itemKey.slice(1)).hidden=mode==='goal'&&itemKey!==key;showImpactCard(itemKey,result);}
}
function setMode(next){mode=next;$('modeSum').setAttribute('aria-pressed',String(mode==='sum'));$('modeGoal').setAttribute('aria-pressed',String(mode==='goal'));$('sumFields').hidden=mode!=='sum';$('goalFields').hidden=mode!=='goal';calculate();}
if($('calcAmount')&&$('modeSum')&&$('modeGoal')&&$('calcRate')){
$('modeSum').addEventListener('click',()=>setMode('sum'));$('modeGoal').addEventListener('click',()=>setMode('goal'));
for(const id of ['calcAmount','calcRate','goalCount'])$(id).addEventListener('input',calculate);
$('goalType').addEventListener('change',calculate);
for(const id of ['amount100','amount500','amount1000'])$(id).addEventListener('click',()=>{$('calcAmount').value=numberFormat.format(Number($(id).dataset.amount));calculate();});
$('calcAmount').addEventListener('blur',()=>{const n=parseImpactNumber('calcAmount');if(n>=.01&&Number.isFinite(n))$('calcAmount').value=new Intl.NumberFormat('ru-RU',{maximumFractionDigits:2}).format(n);});
}

const track=$('programTrack'),arrow=$('nextProgram'),thumb=$('programThumb');
if(track&&arrow&&thumb){
function updatePrograms(){
 const max=track.scrollWidth-track.clientWidth;
 const fraction=max>1?Math.min(1,track.scrollLeft/max):0;
 const shown=track.clientWidth/track.scrollWidth;
 thumb.style.width=(shown*100)+'%';
 thumb.style.transform='translateX('+(shown?fraction*(1-shown)/shown*100:0)+'%)';
 const atEnd=fraction>.99;arrow.classList.toggle('at-end',atEnd);
 arrow.setAttribute('aria-label',atEnd?'Вернуться к первому направлению':'Показать следующее направление');
}
arrow.addEventListener('click',()=>{
 const end=track.scrollWidth-track.clientWidth;
 const next=track.scrollLeft>=end-3?0:Math.min(end,track.scrollLeft+track.querySelector('.program').getBoundingClientRect().width);
 track.scrollTo({left:next,behavior:reduced.matches?'instant':'smooth'});
});
track.addEventListener('scroll',updatePrograms,{passive:true});window.addEventListener('resize',updatePrograms);
updatePrograms();
}

const impactTrack=document.querySelector('.impact-cards'),impactArrow=$('nextImpact'),impactThumb=$('impactThumb');
if(impactTrack&&impactArrow&&impactThumb){
function updateImpactNav(){
 const max=impactTrack.scrollWidth-impactTrack.clientWidth;
 const fraction=max>1?Math.min(1,impactTrack.scrollLeft/max):0;
 const shown=impactTrack.clientWidth/impactTrack.scrollWidth;
 impactThumb.style.width=(shown*100)+'%';
 impactThumb.style.transform='translateX('+(shown?fraction*(1-shown)/shown*100:0)+'%)';
 const atEnd=fraction>.99;
 impactArrow.classList.toggle('at-end',atEnd);
 impactArrow.setAttribute('aria-label',atEnd?'Вернуться к первому направлению':'Показать следующее направление');
}
impactArrow.addEventListener('click',()=>{
 const end=impactTrack.scrollWidth-impactTrack.clientWidth;
 const card=impactTrack.querySelector('.impact-card');
 const gap=parseFloat(getComputedStyle(impactTrack).gap)||0;
 const next=impactTrack.scrollLeft>=end-3?0:Math.min(end,impactTrack.scrollLeft+card.getBoundingClientRect().width+gap);
 impactTrack.scrollTo({left:next,behavior:reduced.matches?'instant':'smooth'});
});
impactTrack.addEventListener('scroll',updateImpactNav,{passive:true});
window.addEventListener('resize',updateImpactNav);
updateImpactNav();
}

if($('staticMode')&&$('mainRoute'))syncMotion();
if($('calcAmount'))calculate();
if(shipImage&&shipAnimation)drawShip();
});
})();
