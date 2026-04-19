# ICODE Laravel Foundation

Reusable Laravel starter for fast production projects with modern auth, localization, and a responsive UI foundation.

## Core Stack

- Laravel 12
- Laravel Breeze + Livewire/Volt
- Laravel Fortify
- Tailwind CSS
- Spatie Laravel Permission
- Multi-language support (`en`, `ku`, `ar`)

## Built-In Features

- Auth pages ready:
  - Login
  - Register
  - Forgot Password
  - Reset Password
  - Confirm Password
  - Verify Email
- Login by email, username, or phone
- Profile module with:
  - Profile information update
  - Password update
  - Two-factor authentication
  - Browser sessions management
- Localized navigation and auth UI
- Config-driven sidebar/topbar navigation with submenu support
- Permission-aware menu visibility (`permission`, `any_permissions`, `role`)
- Centralized branding/support links/colors through `.env`
- Mobile and tablet-friendly responsive layouts

## Branding and Environment Controls

Set these in `.env`:

```env
BRAND_NAME="${APP_NAME}"
BRAND_TAGLINE="Reusable auth-first Laravel base"
BRAND_LOGO_PATH="images/logo.svg"

BRAND_LOCALES="en,ku,ar"
BRAND_NAV_LAYOUT="topbar"   # topbar | sidebar
BRAND_SIDEBAR_DENSITY="normal" # normal | compact

BRAND_COLOR_PRIMARY="#0f766e"
BRAND_COLOR_SECONDARY="#0ea5e9"
BRAND_COLOR_ACCENT="#f97316"
BRAND_COLOR_SURFACE="#f8fafc"
BRAND_COLOR_SURFACE_DARK="#0f172a"
BRAND_COLOR_TEXT="#0f172a"

SUPPORT_COMPANY="I-CODE Group"
SUPPORT_WEBSITE="https://icodegroup.net/"
SUPPORT_EMAIL="info@icodegroup.net"
SUPPORT_FACEBOOK="https://facebook.com/icodegroup"
SUPPORT_WHATSAPP="https://wa.me/9647700941717"
SUPPORT_TELEGRAM="https://t.me/icodegroup"
```

## Quick Start

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install
npm run build
php artisan storage:link
php artisan optimize:clear
php artisan serve
```

## Reuse This As Base For New Projects

1. Copy/fork this repository.
2. Update `.env` app/branding/support values.
3. Set your locales in `BRAND_LOCALES`:
   - One language: `en`
   - Two languages: `en,ar`
   - Three languages: `en,ku,ar`
4. Adjust menu/submenu structure in `config/navigation.php`.
5. Add or update translations in:
   - `lang/en/*`
   - `lang/ku/*`
   - `lang/ar/*`
6. Configure mail in `.env` for verification/reset links.
7. Add permissions and roles for your domain.

Detailed launch checklist: `docs/PROJECT_BASE_CHECKLIST.md`.

## Navigation and Sidebar

- Navigation config file: `config/navigation.php`
- Each item supports:
  - `label` (translation key)
  - `icon`
  - `route` or `url`
  - `children` (submenu)
  - `permission`, `any_permissions`, `role` (visibility)

If you use Spatie Permission, menu rendering automatically honors user roles/permissions.

## Seeders

- `DatabaseSeeder`
- `RoleAndPermissionSeeder`
- `UserSeeder`

Run:

```bash
php artisan db:seed
```

## Useful Commands

```bash
php artisan optimize:clear
php artisan test
npm run dev
```

## Notes

- Keep `APP_URL` correct to avoid auth/redirect issues.
- For production, configure queue, cache, and mail drivers properly.
- If language switcher should be hidden, set a single locale in `BRAND_LOCALES`.

## Credits

Built and supported by [I-CODE Group](https://icodegroup.net/).
