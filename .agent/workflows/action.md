---
description: Standardized procedure for creating or updating Controllers with Auth, Validation, and Logging.
---

### Controller Action Implementation Workflow (Laravel Edition)

Follow these steps for any new data-mutating controller action:

1. **Auth Check**: Route should be wrapped in `auth` middleware inside `routes/web.php`.
2. **Validation**: Use `$request->validate([...])` or FormRequests to validate input data before processing.
3. **Database Operation**: Execute the Eloquent Model query.
4. **Activity Logging**: 
   - Ensure the controller uses the `LogsActivity` trait (`use App\Traits\LogsActivity;`).
   - Call `$this->logActivity('Module', 'CREATE/UPDATE/DELETE', "Description of action");` after the database operation succeeds.
   - **Constraint**: Ensure this aligns with the `/init` workflow requirements.
5. **Redirect & Feedback**: Return a redirect with a flash message: `return redirect()->route('...')->with('success', 'Pesan sukses');`
6. **Error Handling**: Allow Laravel's built-in exception handler to catch DB errors, or use try-catch and return `back()->with('error', 'Pesan gagal');` for highly sensitive operations.
