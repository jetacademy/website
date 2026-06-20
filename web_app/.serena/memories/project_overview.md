# Project Overview

## Purpose
Jetschool is a digital operating system for foundations and schools. It coordinates academic, financial, and operational tasks in a single ecosystem.

## Tech Stack
* **Backend:** Laravel 12.x (PHP 8.4)
* **Frontend:** Vue 3, Vue Router, Vue i18n, Axios
* **Build System:** Vite 7.x
* **CSS Framework:** Tailwind CSS 4.x
* **Permissions:** Spatie Laravel Permission
* **Routing/Bridging:** Custom SPA template loading Vue in `resources/views/home.blade.php`.

## Structure
* **Laravel Views:** `resources/views/` (Main entrypoint: `home.blade.php`)
* **Vue App Entrypoint:** `resources/js/app.js` (rendered in `<div id="app"></div>`)
* **Vue Views:** `resources/js/views/`
* **Models:** `app/Models/` (e.g., `Lead`, `Post`)
* **Controllers:** `app/Http/Controllers/`
