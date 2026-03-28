---
description: A comprehensive guide for testing and verifying new features or bug fixes.
---

### Testing Workflow (Laravel Edition)

Before deploying or submitting any PR, run through this verification checklist:

#### 1. Unit & Feature Testing
Laravel comes with PHPUnit and Pest natively.
- Run tests: `php artisan test`
- If you created a new Feature, create a test file: `php artisan make:test FeatureNameTest`
- Ensure HTTP status codes (`200 OK`, `403 Forbidden` for RBAC) are asserted.

#### 2. Manual UI Verification
- Start the server: `php artisan serve`
- View changes in the browser.
- Open DevTools (F12) and check the Console for Javascript/Alpine.js errors.
- Check the Network tab to ensure no 404s for Vite assets (`app.css`, `app.js`).

#### 3. RBAC (Role-Based Access Control) Audit
- Login as `admin@asitatech.com` -> Verify access to all pages including "Pengaturan Sistem".
- Login as `staff@asitatech.com` -> Verify access is restricted based on the permissions assigned in "Pengaturan Sistem".
- Attempt to forcibly navigate to restricted URLs (e.g., `/pengaturan-sistem` as a Staff) and expect a `403 Forbidden` abort page.

#### 4. Activity Log Audit
- Perform a data mutation (Create Kampanye, Delete User, etc.).
- Login as Admin.
- Navigate to "Pengaturan Sistem" -> "Activity Log".
- Verify the action, timestamp, and user email were recorded accurately.
