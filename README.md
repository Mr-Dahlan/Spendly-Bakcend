<div align="center">
<img src="public/icon.png"/>
</div>
<p align="center">
  <h1 align="center">
  <strong>Spendly Backend</strong>
  <br></h1>
  <div align="center">
  <i>V1.0.1</i><br>
  Personal finance management REST API built with Laravel
  </div>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/version-v1.1.1-blue" alt="Version">
  <img src="https://img.shields.io/badge/laravel-13.x-red" alt="Laravel Version">
  <img src="https://img.shields.io/badge/php-%5E8.2-777BB4" alt="PHP Version">
  <img src="https://img.shields.io/badge/license-MIT-green" alt="License">
</p>

---

## About Spendly

Spendly is a personal finance management web application that helps users track transactions, manage budgets, and monitor spending across custom categories. This repository contains the backend API, built with **Laravel** and consumed by a separate **React + TypeScript** frontend.

### Tech Stack

- **Framework**: Laravel 13
- **Auth**: Laravel Sanctum (SPA token-based authentication) + Google OAuth
- **Mailtrap**: Email auth for forgot-password
- **Database**: MySQL / MariaDB
- **Caching**: Redis (soon)
- **Frontend**: React + TypeScript, Zustand, TanStack Query (separate repo)

## Key Features

- 🔐 Authentication via Sanctum with Google OAuth support and role-based access (admin/user)
- 💰 Transaction management with category-based organization
- 📊 Budget tracking with configurable periods (weekly/monthly/yearly)
- 💱 Real-time currency conversion using cached exchange rate data (soon)
- 🛡️ Admin tools for user and account management
- ⚡ Performance-optimized with Redis caching and query throttling (soon)

## Changelog

### v1.0.1 — Performance Patch

- Throttled `personal_access_tokens.last_used_at` updates via `Sanctum::authenticateAccessTokensUsing()` to avoid redundant `UPDATE` queries on every authenticated request (now limited to once per 5-minute window per token)
- Verified and confirmed CORS preflight (`OPTIONS`) caching by tuning `max_age` in `config/cors.php`, reducing repeated preflight round-trips from the frontend
- General query diagnostics via Laravel Telescope to identify and resolve N+1 and redundant query patterns

## Getting Started

### Requirements

- PHP ^8.2
- Composer
- MySQL/MariaDB
- Redis

### Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

### Development Tools

This project uses [Laravel Telescope](https://laravel.com/docs/telescope) for local request, query, and cache diagnostics. Access it at `/telescope` in your local environment.

## Security Vulnerabilities

If you discover a security vulnerability within this project, please reach out directly to the maintainer rather than opening a public issue.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
