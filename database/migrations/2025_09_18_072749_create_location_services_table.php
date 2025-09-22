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
        Schema::create('location_services', function (Blueprint $table) {
            $table->uuid(column: 'id')->primary()->default(value: DB::raw('gen_random_uuid()'));
            $table->uuid('location_id');
            $table->uuid('service_id');
            $table->decimal('price_override', 8, 2)->nullable();
            $table->unsignedInteger('duration_override_minutes')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('car_wash_locations')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

            $table->unique(['location_id', 'service_id']);
            $table->index(['location_id', 'is_available']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_services');
    }
};
