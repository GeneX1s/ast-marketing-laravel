<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Permission Groups
        Schema::create('permission_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->nullable();
            $table->timestamps();
        });

        // Permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->nullable();
            $table->string('page')->nullable();
            $table->string('action')->nullable();
            $table->timestamps();
        });

        // Pivot: permission_group <-> permission (many-to-many)
        Schema::create('permission_group_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permission_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
            $table->unique(['permission_group_id', 'permission_id'], 'pgp_unique');
        });

        // Roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->nullable();
            $table->integer('level')->default(0);
            $table->foreignId('permission_group_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        // Users (replaces Laravel default)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('role_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('has_2fa')->default(false);
            $table->boolean('status')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

        // Password reset tokens (Laravel default)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Sessions (for server-side session storage)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permission_group_permission');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('permission_groups');
    }
};
