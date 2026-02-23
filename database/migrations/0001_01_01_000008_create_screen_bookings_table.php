<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('screen_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('screen_id')->constrained('screens')->cascadeOnDelete();
            $table->foreignId('media_id')->constrained('media_files')->cascadeOnDelete();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('plays_per_day')->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            $table->string('status', 30)->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('screen_bookings');
    }
};
