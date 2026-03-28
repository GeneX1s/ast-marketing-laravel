# AST Marketing Dashboard (Laravel 11 Edition)

Welcome to the **AST PAY Marketing Dashboard** rebuilt on Laravel 11. This project completely replaces the unstable Next.js/Prisma/Auth.js stack with Laravel's robust, natively integrated architecture.

## Why Laravel?
The previous Next.js version suffered from persistent session invalidations and `400 Bad Request` proxy loops in production. By moving to Laravel, we utilize native, rock-solid server-side sessions, a unified MVC structure, and Eloquent ORM.

## Tech Stack
- **Framework**: Laravel 11 (PHP 8.2+)
- **Database**: MySQL (currently running SQLite temporarily on local)
- **Styling**: Tailwind CSS via Vite
- **Interactivity**: Alpine.js (replacing complex React states)
- **Icons**: SVG partials (Lucide equivalents)

## Getting Started

1. **Environment Setup**
   ```bash
   cp .env.example .env
   # Ensure your DB connection is set correctly in .env
   ```

2. **Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Database & Seeding**
   ```bash
   # Generates tables and adds initial dummy data & admin accounts
   php artisan migrate:fresh --seed
   ```

4. **Running Locally**
   ```bash
   # Terminal 1: Vite asset compiler
   npm run dev

   # Terminal 2: Laravel server
   php artisan serve
   ```

## Key Architectural Differences from Next.js Version
1. **Authentication**: Handled via `LoginController` and `Auth` facade instead of JWT/Auth.js.
2. **RBAC (Role Based Access Control)**: Enforced via `CheckPermission` middleware instead of React `layout.tsx` checks.
3. **Database**: Eloquent Models (`app/Models`) replace Prisma schema. Relationships are purely object-oriented native Eloquent relations.
4. **Activity Logs**: Instead of `lib/actions.ts`, logging is handled automatically by the `LogsActivity` Trait applied to controllers.

## Agent Workflows
This repository uses strict Agent Workflows located in `.agent/workflows`. AI assistants or new developers must adhere to these processes (e.g., `/init`, `/action`, `/ui`, `/fix`).
