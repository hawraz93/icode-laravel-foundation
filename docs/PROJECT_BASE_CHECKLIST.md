# Project Base Checklist

Use this checklist when starting a new project from `icode-laravel-foundation`.

## 1) App Identity

- [ ] Set `APP_NAME`
- [ ] Set `APP_URL`
- [ ] Set timezone if needed (`config/app.php`)

## 2) Branding

- [ ] Set `BRAND_NAME`
- [ ] Set `BRAND_TAGLINE`
- [ ] Replace logo at `public/images/logo.svg` or update `BRAND_LOGO_PATH`
- [ ] Set brand colors in `.env`

## 3) Localization

- [ ] Set enabled locales in `BRAND_LOCALES`
- [ ] Confirm `APP_LOCALE` and `APP_FALLBACK_LOCALE`
- [ ] Update translation files in `lang/{locale}`

## 4) Auth and Security

- [ ] Configure mail driver and sender
- [ ] Test register/login/logout
- [ ] Test email verification
- [ ] Test forgot/reset password
- [ ] Test confirm password
- [ ] Test two-factor authentication
- [ ] Test browser sessions logout

## 5) Roles and Permissions

- [ ] Define permissions for your domain
- [ ] Define roles and assign permissions
- [ ] Add guards if project requires multi-guard setup
- [ ] Review `config/permission.php`

## 6) Navigation and Layout

- [ ] Select layout: `BRAND_NAV_LAYOUT=topbar|sidebar`
- [ ] Optional sidebar density: `BRAND_SIDEBAR_DENSITY=normal|compact`
- [ ] Update menu/submenu in `config/navigation.php`
- [ ] Confirm responsive behavior on mobile and tablet

## 7) Database and Data

- [ ] Configure DB connection
- [ ] Run migrations
- [ ] Run seeders
- [ ] Add project-specific seed data

## 8) Build and Performance

- [ ] `composer install --no-dev` (production)
- [ ] `npm ci && npm run build`
- [ ] `php artisan optimize`
- [ ] Configure cache/queue/session drivers

## 9) QA Before Go-Live

- [ ] Run automated tests (`php artisan test`)
- [ ] Manually test auth pages and redirects
- [ ] Validate locale switch behavior
- [ ] Validate role-based menu visibility
- [ ] Validate footer support links

## 10) Deploy

- [ ] Set production `.env`
- [ ] Run migrations on server
- [ ] Link storage (`php artisan storage:link`)
- [ ] Clear and rebuild caches
- [ ] Set queue workers and scheduler if needed
