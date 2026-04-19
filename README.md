<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## SmartExam Auth Base

This project is now prepared as a reusable auth-first base:

- Livewire + Breeze auth pages redesigned
- Email verification, reset password, and confirm password flow ready
- Localization ready (`en`, `ku`, `ar`) with runtime language switcher
- Brand/logo/support links centralized in env/config
- WireUI integrated

### Quick Customization

Edit `.env` values:

- `BRAND_NAME`, `BRAND_TAGLINE`, `BRAND_LOGO_PATH`
- `BRAND_LOCALES` (example: `en` or `en,ar`)
- `BRAND_NAV_LAYOUT` (`topbar` or `sidebar`)
- `BRAND_COLOR_*`
- `SUPPORT_WEBSITE`, `SUPPORT_FACEBOOK`, `SUPPORT_WHATSAPP`, `SUPPORT_TELEGRAM`

Then run:

```bash
php artisan optimize:clear
npm run build
```

### Reuse Checklist

When creating a new system from this base, do these steps:

1. Update `.env` app + brand values and support links.
2. Run migrations and seed required admin/users:
   - `php artisan migrate --seed`
3. Ensure storage symlink exists:
   - `php artisan storage:link`
4. Configure mail settings to make verification/reset links work.
5. Verify auth flow manually:
   - Register
   - Login (email / username / phone)
   - Email verification
   - Forgot/reset password
   - 2FA enable + recovery codes
6. Build frontend assets:
   - `npm install && npm run build`

### Navigation + Sidebar

This base supports two nav modes:

- `BRAND_NAV_LAYOUT="topbar"`
- `BRAND_NAV_LAYOUT="sidebar"`

Define your menu/submenu in:

- `config/navigation.php`

Each item supports:

- `label` translation key
- `icon` key
- `route` or `url`
- `children` for submenus
- `permission` / `any_permissions` / `role` visibility checks

If your project uses `spatie/laravel-permission`, menu visibility automatically follows user permissions/roles via `can()` / `hasRole()`.
