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
        Schema::create('time_slots', function (Blueprint $table) {
            $table->uuid(column: 'id')->primary()->default(value: DB::raw('gen_random_uuid()'));
            $table->uuid('location_id');
            $table->date('slot_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedTinyInteger('capacity')->default(1);
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('car_wash_locations')->onDelete('cascade');

            $table->unique(['location_id', 'slot_date', 'start_time']);
            $table->index(['location_id', 'slot_date', 'is_available']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_slots');
    }
};
