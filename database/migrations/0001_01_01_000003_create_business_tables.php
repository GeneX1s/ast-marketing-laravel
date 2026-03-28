<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Activities (Audit Log)
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('user')->nullable();
            $table->string('module')->nullable();
            $table->string('action')->nullable();
            $table->text('description')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('result')->nullable();
            $table->timestamps();
        });

        // Businesses
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('pic_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        // Kampanyes (Campaigns)
        Schema::create('kampanyes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pic_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name')->nullable();
            $table->string('channel')->nullable();
            $table->string('type')->nullable();
            $table->dateTime('schedule');
            $table->string('status')->nullable();
            $table->string('content_url')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Prospeks (Prospects)
        Schema::create('prospeks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pic_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('timeline_id')->nullable();
            $table->unsignedBigInteger('business_id')->nullable();
            $table->string('name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('business_name')->nullable();
            $table->text('address')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('schedule');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Prospek Timelines
        Schema::create('prospek_timelines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prospek_id')->nullable();
            $table->foreignId('pic_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('message')->nullable();
            $table->dateTime('schedule');
            $table->timestamps();
        });

        // Referrals
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->string('recruiter_name')->nullable();
            $table->string('referral_code')->nullable();
            $table->string('commission_value')->nullable();
            $table->string('commission_type')->nullable();
            $table->integer('participant')->nullable();
            $table->integer('active_participant')->nullable();
            $table->string('total_commission')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        // Pengajuans (Applications)
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pic_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('business_id')->nullable()->constrained('businesses')->nullOnDelete();
            $table->string('nik')->nullable();
            $table->string('name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        // Sales
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses')->cascadeOnDelete();
            $table->double('amount');
            $table->text('description')->nullable();
            $table->string('status')->default('Completed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
        Schema::dropIfExists('pengajuans');
        Schema::dropIfExists('referrals');
        Schema::dropIfExists('prospek_timelines');
        Schema::dropIfExists('prospeks');
        Schema::dropIfExists('kampanyes');
        Schema::dropIfExists('businesses');
        Schema::dropIfExists('activities');
    }
};
