<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->uuid(column: 'id')->primary()->default(value: DB::raw('gen_random_uuid()'));
            $table->uuid('category_id');
            $table->string('name');
            $table->text('description');
            $table->decimal('base_price', 8, 2);
            $table->unsignedInteger('estimated_duration_minutes');
            $table->json('requirements')->nullable(); // Store requirements like vehicle size, etc.
            $table->boolean('is_active')->default(true);
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('service_categories')->onDelete('cascade');

            $table->index(['category_id', 'is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
