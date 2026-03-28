---
description: A systematic approach to troubleshooting, fixing, and verifying bugs in Laravel.
---

### Systematic Bug Fixing Workflow (Laravel Edition)

1. **Log Analysis**: Check `storage/logs/laravel.log` or the local terminal output for exact PHP/Laravel stack traces.
2. **Consult Knowledge Base**: Check `KNOWN_ERRORS.md` in the root directory to see if this error has occurred before.
3. **Environment Check**: Verify `.env` cache using `php artisan config:clear` or `php artisan cache:clear` if environmental variables act strangely.
4. **Reproduction**: Try to reproduce the error and describe the steps.
5. **Isolate**: Determine if the issue is View (Blade), Controller logic, or Database/Eloquent related.
6. **Fix & Verify**: 
   - Implement the fix.
   - Run a manual test to verify the fix in the browser.
   - **Audit**: Run the `/init` workflow to ensure the fix didn't break permissions or logging.
7. **Document**: If this is a new recurring issue, add it to `KNOWN_ERRORS.md`.
