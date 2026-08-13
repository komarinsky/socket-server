# Socket Server

A small Laravel 13 app demonstrating real-time updates over WebSockets with [Laravel Reverb](https://laravel.com/docs/reverb): an **Items** list whose `value` column updates live in every open browser tab whenever it changes, with no page refresh.

## How it works

- `GET /` (`ItemController::index`) renders `resources/views/items/index.blade.php` with all items.
- `PATCH /items/{item}` (`ItemController::update`) validates the new value via `UpdateItemValueRequest` and saves it.
- `ItemObserver` fires `App\Events\ItemValueUpdated` whenever an item's `value` changes.
- The event broadcasts on the public `items` channel (as `item.value.updated`) through Reverb.
- The frontend connects with `laravel-echo` + `pusher-js` (`resources/js/echo.js`) and updates the matching table cell in place when the event arrives.

## Stack

- PHP 8.4, Laravel 13, SQLite (`database/database.sqlite`)
- Broadcasting: Laravel Reverb (WebSocket server), Laravel Echo + Pusher JS protocol on the client
- Frontend build: Vite + Tailwind CSS v4 (no JS framework — plain `resources/js/app.js`)
- Testing: Pest v5 (PHPUnit 13 under the hood) — suites in `tests/Unit` and `tests/Feature`
- [Laravel Boost](https://laravel.com/docs/ai) is installed for AI-assisted development (MCP server + agent skills/rules)

## Getting started

```bash
composer install
npm install
cp .env.example .env   # then fill in REVERB_* / VITE_REVERB_* values
php artisan key:generate
php artisan migrate
```

Run everything (HTTP server, queue listener, log tailer, Vite):

```bash
composer run dev
```

Reverb's WebSocket server runs separately and isn't part of `composer run dev`:

```bash
php artisan reverb:start
```

> If the site is served by Laravel Herd, you don't need `php artisan serve` — Herd handles that for you.

## Testing

```bash
composer test
# or a single test
php artisan test --compact --filter=testName
```

## License

Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
