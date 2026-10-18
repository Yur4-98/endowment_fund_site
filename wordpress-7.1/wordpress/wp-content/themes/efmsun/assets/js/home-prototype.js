(function () {
'use strict';
function ready(fn) {
  if (document.readyState !== 'loading') fn();
  else document.addEventListener('DOMContentLoaded', fn);
}
ready(function () {
if (!document.getElementById('heroShip')) return;
'use strict';
const $=id=>document.getElementById(id);
const reduced=window.matchMedia('(prefers-reduced-motion: reduce)');
let shipTimer=0;
function drawShip(){clearTimeout(shipTimer);$('heroShip').classList.remove('drawing');$('replayShip').disabled=false;if(reduced.matches||$('staticMode').checked){$('shipStatus').textContent='Готовый рисунок парусника';return;}void $('heroShip').getBoundingClientRect();$('heroShip').classList.add('drawing');$('replayShip').disabled=true;$('shipStatus').textContent='Парусник рисуется';shipTimer=setTimeout(()=>{$('heroShip').classList.remove('drawing');$('replayShip').disabled=false;$('shipStatus').textContent='Рисунок парусника завершён';},4600);}
$('replayShip').addEventListener('click',drawShip);
if($('menuButton')) $('menuButton').addEventListener('click',()=>{const open=$('menuButton').getAttribute('aria-expanded')!=='true';$('menuButton').setAttribute('aria-expanded',String(open));$('menuButton').setAttribute('aria-label',open?'Закрыть меню':'Открыть меню');$('mobileNav').classList.toggle('open',open);});
if($('mobileNav')) $('mobileNav').addEventListener('click',()=>{$('mobileNav').classList.remove('open');$('menuButton').setAttribute('aria-expanded','false');$('menuButton').setAttribute('aria-label','Открыть меню');});
const descriptions=['Вы делаете пожертвование в целевой капитал фонда.','Пожертвование пополняет целевой капитал.','Капитал находится в управлении.','Доход от управления помогает финансировать программы.','Управление продолжается в следующем периоде.'];
let elapsed=0,running=false,frame=0,lastTime=0,manualStep=0,activeStage=-1;
const mainLength=$('mainRoute').getTotalLength(),returnLength=$('returnRoute').getTotalLength();
function showStage(stage,cycle=false){document.querySelectorAll('[data-stage]').forEach(e=>{const active=Number(e.dataset.stage)===stage;e.classList.toggle('active',active);if(e.tagName==='BUTTON')e.setAttribute('aria-pressed',String(active));});if(activeStage!==stage||cycle){$('stageExplanation').textContent=descriptions[cycle?4:stage];activeStage=stage;}$('programBranch').classList.toggle('lit',stage===3||cycle);}
function mobileBoatPosition(stage,fraction=0){const items=document.querySelectorAll('.mobile-step');const start=items[stage].offsetTop,end=items[Math.min(stage+1,3)].offsetTop;$('mobileBoat').style.transform='translateY('+(start+(end-start)*fraction-4)+'px)';}
function placeAtStage(stage){$('routeBoat').setAttribute('transform','translate('+(120+stage*260-19)+' 69)');mobileBoatPosition(stage);}
function noMotion(){return reduced.matches||$('staticMode').checked;}
function stopRoute(){running=false;cancelAnimationFrame(frame);}
function updateRoute(){let point,stage;if(elapsed<7){const fraction=elapsed/7;point=$('mainRoute').getPointAtLength(mainLength*fraction);stage=Math.min(3,Math.floor(fraction*3+.12));showStage(stage);mobileBoatPosition(Math.min(2,Math.floor(fraction*3)),fraction>=1?0:(fraction*3)%1);}else if(elapsed<9){point=$('mainRoute').getPointAtLength(mainLength);showStage(3);mobileBoatPosition(3);}else{const fraction=Math.min(1,(elapsed-9)/2);point=$('returnRoute').getPointAtLength(returnLength*fraction);showStage(2,true);const items=document.querySelectorAll('.mobile-step');$('mobileBoat').style.transform='translateY('+(items[3].offsetTop+(items[2].offsetTop-items[3].offsetTop)*fraction-4)+'px)';}$('routeBoat').setAttribute('transform','translate('+(point.x-19)+' '+(point.y-36)+')');}
function tick(time){if(!running)return;elapsed+=Math.max(0,(time-lastTime)/1000);lastTime=time;updateRoute();if(elapsed>=11){stopRoute();elapsed=11;$('playRoute').textContent='Повторить маршрут ↻';return;}frame=requestAnimationFrame(tick);}
function playRoute(){if(noMotion()){stopRoute();manualStep=(manualStep+1)%5;const stage=manualStep===4?2:manualStep;showStage(stage,manualStep===4);placeAtStage(stage);$('playRoute').textContent=manualStep===4?'Начать сначала ↻':'Следующий этап →';return;}if(running){stopRoute();$('playRoute').textContent='Продолжить маршрут →';return;}if(elapsed>=11){elapsed=0;activeStage=-1;}running=true;lastTime=performance.now();$('playRoute').textContent='Пауза ‖';frame=requestAnimationFrame(tick);}
$('playRoute').addEventListener('click',playRoute);
function syncMotion(){stopRoute();elapsed=0;manualStep=0;activeStage=-1;showStage(0);placeAtStage(0);$('playRoute').textContent=noMotion()?'Следующий этап →':'Посмотреть маршрут →';if(noMotion()){clearTimeout(shipTimer);$('heroShip').classList.remove('drawing');$('replayShip').disabled=false;}}
$('staticMode').checked=reduced.matches;$('staticMode').addEventListener('change',syncMotion);reduced.addEventListener('change',syncMotion);
document.querySelectorAll('[data-stage]').forEach(e=>e.addEventListener('click',()=>{stopRoute();const stage=Number(e.dataset.stage);elapsed=0;manualStep=stage;showStage(stage);placeAtStage(stage);$('playRoute').textContent=noMotion()?'Следующий этап →':'Посмотреть маршрут →';}));
window.addEventListener('resize',()=>{if(!running)mobileBoatPosition(Math.max(0,activeStage));});
document.addEventListener('visibilitychange',()=>{if(document.hidden&&running){stopRoute();$('playRoute').textContent='Продолжить маршрут →';}});
/* IMPACT MODEL START */
const IMPACT_ITEMS={
  veterans:{cost:10000,part:'стоимости одной выплаты помощи',one:'выплата помощи',few:'выплаты помощи',many:'выплат помощи',hint:'Условная стоимость одной выплаты — 10 000 ₽.'},
  grant:{cost:100000,part:'стоимости одного гранта',one:'грант',few:'гранта',many:'грантов',hint:'Условная стоимость одного гранта — 100 000 ₽.'},
  equipment:{cost:50000,part:'стоимости одного учебного комплекта',one:'учебный комплект',few:'учебных комплекта',many:'учебных комплектов',hint:'Условная стоимость одного учебного комплекта — 50 000 ₽.'}
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
  const donation=Math.ceil(budget/(rate/100)*100)/100;
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
  if(effect.whole>=1){$(key+'Value').textContent=numberFormat.format(effect.whole);$(key+'Unit').textContent=pluralImpact(effect.whole,item);$(key+'Remainder').textContent=effect.remainder>=.01?'Остаток годового дохода: '+money(effect.remainder):'Полная стоимость выбранной помощи.';}
  else{const percent=effect.ratio*100;$(key+'Value').textContent=percent>0&&percent<.1?'< 0,1 %':new Intl.NumberFormat('ru-RU',{maximumFractionDigits:1}).format(Math.floor(percent*10)/10)+' %';$(key+'Unit').textContent=item.part;$(key+'Remainder').textContent=percent===0?'По этому сценарию дохода на помощь нет.':'Часть стоимости можно покрыть доходом.';}
  $(key+'Bar').style.width=effect.progress+'%';$(key+'Progress').setAttribute('aria-valuenow',String(Math.round(effect.progress*10)/10));
}
function calculate(){const rate=parseImpactNumber('calcRate'),key=$('goalType').value,count=parseImpactNumber('goalCount'),donation=parseImpactNumber('calcAmount');
  $('goalCost').textContent=IMPACT_ITEMS[key]?.hint??'';
  if(!Number.isFinite(rate)||rate<0||rate>20){failImpact('Укажите условную годовую ставку от 0 до 20 %.');return;}
  let result;
  if(mode==='sum'){if(!Number.isFinite(donation)||donation<.01||donation>1e12){failImpact('Введите сумму пожертвования от 0,01 до 1 трлн ₽.');return;}result=impactFromDonation(donation,rate);}
  else{if(!Number.isInteger(count)||count<1||count>100000){failImpact('Укажите целое количество от 1 до 100 000.');return;}if(rate===0){failImpact('При нулевой ставке помощь из дохода рассчитать нельзя.');return;}result=donationForImpact(key,count,rate);if(!result||result.donation>1e12){failImpact('Для выбранной цели требуется слишком большая сумма. Измените параметры примера.');return;}}
  $('amountError').textContent='';$('calcAmount').setAttribute('aria-invalid','false');$('impactResults').hidden=false;
  $('resultTitle').textContent=mode==='sum'?'Расчётный доход на помощь за год':'Пожертвование в целевой капитал';
  $('calcResult').textContent=money(mode==='sum'?result.budget:result.donation);
  $('resultPeriod').textContent=mode==='sum'?'от пожертвования '+money(result.donation)+' при условной ставке '+rate.toLocaleString('ru-RU')+' %':'чтобы направлять '+money(IMPACT_ITEMS[key].cost*count)+' в год на выбранную помощь при условной ставке '+rate.toLocaleString('ru-RU')+' %';
  $('impactHeading').textContent=mode==='sum'?'Этого дохода может хватить на':'Выбранный результат помощи за год';
  $('impactAlternatives').textContent=mode==='sum'?'Каждая карточка — отдельный вариант использования всего годового дохода. Результаты не суммируются.':'Показан один выбранный сценарий. Стоимость помощи и ставка расчёта условные.';
  document.querySelector('.impact-cards').classList.toggle('single-goal',mode==='goal');
  for(const itemKey of Object.keys(IMPACT_ITEMS)){$('card'+itemKey[0].toUpperCase()+itemKey.slice(1)).hidden=mode==='goal'&&itemKey!==key;showImpactCard(itemKey,result);}
}
function setMode(next){mode=next;$('modeSum').setAttribute('aria-pressed',String(mode==='sum'));$('modeGoal').setAttribute('aria-pressed',String(mode==='goal'));$('sumFields').hidden=mode!=='sum';$('goalFields').hidden=mode!=='goal';calculate();}
$('modeSum').addEventListener('click',()=>setMode('sum'));$('modeGoal').addEventListener('click',()=>setMode('goal'));$('recalculate').addEventListener('click',calculate);
for(const id of ['calcAmount','calcRate','goalCount'])$(id).addEventListener('input',calculate);
$('goalType').addEventListener('change',calculate);
for(const id of ['amount100','amount500','amount1000'])$(id).addEventListener('click',()=>{$('calcAmount').value=numberFormat.format(Number($(id).dataset.amount));calculate();});
$('calcAmount').addEventListener('blur',()=>{const n=parseImpactNumber('calcAmount');if(n>=.01&&Number.isFinite(n))$('calcAmount').value=new Intl.NumberFormat('ru-RU',{maximumFractionDigits:2}).format(n);});

syncMotion();calculate();drawShip();
});
})();
