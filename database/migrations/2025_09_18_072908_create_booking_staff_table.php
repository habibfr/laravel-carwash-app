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
        Schema::create('booking_staff', function (Blueprint $table) {
            $table->uuid(column: 'id')->primary()->default(value: DB::raw('gen_random_uuid()'));
            $table->uuid('booking_id');
            $table->uuid('staff_id');
            $table->enum('role', ['primary', 'assistant'])->default('primary');
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');

            $table->unique(['booking_id', 'staff_id']);
            $table->index(['booking_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_staff');
    }
};
