# Suggested Commands for Development

This memory lists the most useful commands for building and developing this Laravel + Vue + Vite + Tailwind CSS project on Windows.

## Development Servers

You can run both backend and frontend servers together using the Composer command:
```bash
composer run dev
```
Alternatively, you can run them individually:
* **Laravel Backend:** `php artisan serve`
* **Vite Frontend Dev:** `npm run dev`
* **Queue Listener:** `php artisan queue:listen --tries=1 --timeout=0`

## Setup and Installation

To set up the project from scratch (installs dependencies, copies `.env`, generates key, runs migrations, builds assets):
```bash
composer run setup
```

## Testing & Quality

* **Run Tests:** `composer run test` (or `php artisan test`)
* **Code Formatting (Pint):** `vendor/bin/pint`

## Cache Operations

* **Clear View Cache:** `php artisan view:clear`
* **Clear Configurations and Routes (for dev):** `php artisan config:clear`
* **Optimize (for production):** `php artisan optimize`
