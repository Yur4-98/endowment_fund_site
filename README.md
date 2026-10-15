# Сайт эндаумент-фонда (EF MSUN)

Локальный WordPress: ядро в `wordpress-7.1/wordpress`, тема **EF MSUN**, запуск через Docker.

Сайт: http://localhost:8080  
Админка: http://localhost:8080/wp-admin  
phpMyAdmin: http://localhost:8081

База данных и `wp-config.php` в git не входят. После клонирования WordPress устанавливается заново.

## Что нужно

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- Git

Папка проекта на Windows может содержать кириллицу. Из‑за этого Docker Compose нужно запускать с именем проекта `efmsun`.

## Запуск

```powershell
git clone https://github.com/Yur4-98/endowment_fund_site.git
cd endowment_fund_site
```

Запустите Docker Desktop и дождитесь зелёного статуса.

```powershell
$env:COMPOSE_PROJECT_NAME = "efmsun"
docker compose up -d
```

Откройте http://localhost:8080

### Первый раз: установка WordPress

Появится мастер установки.

1. Язык — русский.
2. Название сайта — например `Фонд целевого капитала МГУ им. Невельского`.
3. Придумайте логин и пароль администратора (для учёбы можно `admin` / `admin`).
4. После входа: **Внешний вид → Темы → EF MSUN → Активировать**.

При активации тема создаёт страницы-заглушки, меню, проекты и новости.

### ЧПУ (адреса вида `/o-fonde/`)

Файл `.htaccess` в git не хранится. Если внутренние страницы отдают 404, создайте в корне WordPress файл `wordpress-7.1/wordpress/.htaccess`:

```apache
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
```

В админке: **Настройки → Постоянные ссылки → Название записи → Сохранить**.

## Остановка и повторный старт

```powershell
$env:COMPOSE_PROJECT_NAME = "efmsun"
docker compose stop
docker compose up -d
```

Полностью удалить контейнеры (база сохранится в томе Docker):

```powershell
$env:COMPOSE_PROJECT_NAME = "efmsun"
docker compose down
```

Стереть и базу:

```powershell
$env:COMPOSE_PROJECT_NAME = "efmsun"
docker compose down -v
```

После `down -v` мастер установки WordPress нужно пройти снова.

## Что править в Cursor

Тема сайта:

`wordpress-7.1/wordpress/wp-content/themes/efmsun`

Ядро WordPress (`wp-admin`, `wp-includes`) не меняйте.

## Пожертвования (Leyka)

Плагин стоит в `wordpress-7.1/wordpress/wp-content/plugins/Leyka`. С wordpress.org его сняли (проверка), поэтому ставится с GitHub:

```powershell
$env:COMPOSE_PROJECT_NAME = "efmsun"
docker compose -p efmsun run --rm wpcli wp plugin install "https://github.com/Teplitsa/Leyka/archive/refs/heads/master.zip" --activate --allow-root
```

Тема сама создаёт кампанию «Пополнение целевого капитала» и включает банковскую квитанцию. Карта Сбера появится в форме, когда в админке заполните **Лейка → Настройки → Сбербанк Эквайринг**: логин API, пароль API, тестовый режим.

Callback для банка: `https://efmsun.ru/leyka/service/sber/process`  
Ежемесячные списания: cron раз в сутки на `https://efmsun.ru/leyka/service/do_recurring/`

Ключи Сбера в git не храните.

## Если сайт не открывается

- Docker Desktop запущен.
- Порты `8080` и `8081` не заняты другим приложением.
- Команда запускается из корня репозитория, где лежит `docker-compose.yml`.
- Используется `$env:COMPOSE_PROJECT_NAME = "efmsun"`.
