# Known Errors & Troubleshooting

This document tracks known issues specific to the **Laravel 11** version of the AST Marketing Dashboard. (The old Next.js 400 Bad Request / Redirect Loop proxy errors are fully resolved by this migration).

## Active Issues
- *None currently recorded for the Laravel build.*

## Common Troubleshooting

### 1. View Cache / Route Cache Issues
If you make changes to routes or Blade views and they don't reflect:
```bash
php artisan optimize:clear
```

### 2. Vite Asset Missing Error
If the page loads with a Vite manifest error:
```bash
npm run build
# OR run the dev server:
npm run dev
```

### 3. Database Connection Refused
If running `php artisan migrate` yields `SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it`:
- Make sure WAMP / XAMPP / MySQL service is actually running.
- Alternatively, temporarily switch to SQLite by setting `DB_CONNECTION=sqlite` and commenting out host/port in `.env`, then create the `database/database.sqlite` file.
