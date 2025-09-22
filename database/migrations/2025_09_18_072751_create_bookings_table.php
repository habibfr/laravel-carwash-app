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
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid(column: 'id')->primary()->default(value: DB::raw('gen_random_uuid()'));
            $table->uuid('user_id');
            $table->uuid('location_id');
            $table->uuid('vehicle_id');
            $table->uuid('time_slot_id');
            $table->timestamp('scheduled_datetime');
            $table->enum('status', ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled', 'no_show'])->default('pending');
            $table->decimal('subtotal', 8, 2);
            $table->decimal('tax_amount', 8, 2)->default(0);
            $table->decimal('discount_amount', 8, 2)->default(0);
            $table->decimal('total_amount', 8, 2);
            $table->text('special_instructions')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->uuid('cancelled_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('car_wash_locations')->onDelete('cascade');
            $table->foreign('vehicle_id')->references('id')->on('customer_vehicles')->onDelete('cascade');
            $table->foreign('time_slot_id')->references('id')->on('time_slots')->onDelete('cascade');
            $table->foreign('cancelled_by')->references('id')->on('users')->onDelete('cascade');

            $table->index(['user_id', 'status']);
            $table->index(['location_id', 'scheduled_datetime']);
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
