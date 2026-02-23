<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->timestamps();
        });

        Schema::create('media_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('original_name')->nullable();
            $table->unsignedInteger('duration_sec');
            $table->unsignedInteger('width_px');
            $table->unsignedInteger('height_px');
            $table->unsignedInteger('file_size_mb');
            $table->string('codec', 20)->default('H264');
            $table->unsignedSmallInteger('fps')->default(25);
            $table->foreignId('status_id')->constrained('media_statuses')->cascadeOnDelete();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_files');
        Schema::dropIfExists('media_statuses');
    }
};
