# Интеграция с Telegram

Пошаговая настройка уведомлений о лидах через Telegram-бота (пакет `westacks/telebot`).

## 1. Создание бота в BotFather

В чате [BotFather](https://t.me/BotFather):

1. Создайте бота и сохраните username и API-токен.
2. Назначьте команды **start** и **stop**.
3. Выполните `/setprivacy` и выберите **DISABLED**, чтобы бот получал сообщения из групп.

## 2. Подключение бота к CRM

### 2.1. Подготовка приложения

```bash
composer install
composer update
```

Опубликуйте конфиг telebot:

```bash
php artisan vendor:publish --provider="WeStacks\TeleBot\Laravel\Providers\TeleBotServiceProvider" --tag=config
```

Добавьте переменные в `.env`:

```env
TELEGRAM_ENABLED=true
TELEGRAM_API_URL=
TELEGRAM_BOT_NAME=
TELEGRAM_BOT_TOKEN=
TELEGRAM_NGROK_WEBHOOK_URL=
```

В `config/telebot.php` укажите настройки бота:

```php
'bots' => [
    'bot' => [
        'token' => env('TELEGRAM_BOT_TOKEN'),
        'name' => env('TELEGRAM_BOT_NAME', null),
        'api_url' => env('TELEGRAM_API_URL', 'https://api.telegram.org/bot{TOKEN}/{METHOD}'),
        'exceptions' => true,
        'async' => false,
        'webhook' => [
            'url' => env('TELEGRAM_NGROK_WEBHOOK_URL', env('APP_URL')) . '/api/v2/integrations/telegram/webhook',
        ],
        'poll' => [],
        'handlers' => [],
    ],
],
```

### 2.2. Вебхук

**Локальная разработка (ngrok):**

```bash
ngrok http 8000
```

Скопируйте HTTPS-URL из `Forwarding` в `TELEGRAM_NGROK_WEBHOOK_URL`. При каждом перезапуске ngrok URL меняется — обновите `.env` и заново назначьте вебхук.

**Продакшен:** оставьте `TELEGRAM_NGROK_WEBHOOK_URL` пустым, иначе вебхук уйдёт на ngrok.

Назначение вебхука:

```bash
php artisan telebot:webhook --setup
php artisan telebot:webhook --info
```

## 3. Привязка чата к проекту

### 3.1. В CRM

1. Откройте настройки синхронизации проекта → вкладка **Telegram**.
2. Создайте чат и сохраните код приглашения.

### 3.2. Группа / канал

1. Создайте группу в Telegram, добавьте участников и бота.
2. Отправьте: `@имя_бота код_приглашения`.
3. Дождитесь подтверждения от бота.

### 3.3. Личный чат

Отправьте боту только код приглашения (без упоминания). Бот подтвердит подключение.

## 4. Шаблоны сообщений

Для каждого чата задаётся свой шаблон. Плейсхолдеры начинаются с `$`:

```text
У вас новый лид!
Имя: $full_name
Телефон: $phone
Город: $city
Цена сделки: $cost
```

| Плейсхолдер      | Описание                                      |
|------------------|-----------------------------------------------|
| `name`           | Имя                                           |
| `patronymic`     | Отчество                                      |
| `surname`        | Фамилия                                       |
| `full_name`      | ФИО                                           |
| `cost`           | Цена сделки                                   |
| `city`           | Город                                         |
| `region`         | Регион (автоопределение)                      |
| `manual_region`  | Регион, указанный менеджером                  |
| `email`          | Email                                         |
| `host`           | Посадочная страница                           |

## 5. Включение и отключение уведомлений

**Группа / канал:**

```text
/start@Имя_бота
/stop@Имя_бота
```

**Личный чат:**

```text
/start
/stop
```
