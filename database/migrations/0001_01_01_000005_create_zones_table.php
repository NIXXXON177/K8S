<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('floor', 20)->nullable();
            $table->string('section')->nullable();
            $table->decimal('area_sqm', 8, 2)->nullable();
            $table->decimal('price_per_day', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('zone_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zone_id')->constrained('zones')->cascadeOnDelete();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_price', 12, 2)->nullable();
            $table->string('status', 30)->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zone_bookings');
        Schema::dropIfExists('zones');
    }
};
