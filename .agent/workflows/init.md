---
description: This workflow serves as the base for any new pages/processes and an audit guide for existing ones to ensure database consistency, permissions, and activity logging.
---

### Page/Process Initialization & Audit Workflow (Laravel Edition)

Whenever a new page is created or an existing page is being reviewed, follow these steps strictly:

#### 1. Database Schema Preparation
- Review the request or provided samples to identify necessary data structures.
- Create a new migration file: `php artisan make:migration create_table_name`.
- Create a corresponding Eloquent Model: `php artisan make:model ModelName`.
- Define relationships (`hasMany`, `belongsTo`) inside the Eloquent models.

#### 2. Data Seeding
- Update `database/seeders/DatabaseSeeder.php` to include initial data required for the new feature.
- Ensure the seed logic is idempotent (use `updateOrCreate` or check if data exists before inserting).

#### 3. System Administration Integration (Pengaturan Sistem)
All new features must be integrated into the system management module:

**A. Perizinan (Permissions)**
- Update `DatabaseSeeder.php` to register new permissions in the `permissions` table.
- Ensure the route is protected using the `CheckPermission` middleware in `routes/web.php`.

**B. Activity Log**
- Every new controller must use the `LogsActivity` trait.
- All mutating actions (Create, Update, Delete) must call `$this->logActivity('Module Name', 'ACTION', 'Description')`.
- Logged activities must be visible within the "Activity Log" tab of `pengaturan-sistem`.

#### 4. Implementation
- Proceed with Blade view creation and Controller logic implementation only after the database, model, and permission foundations are verified.
