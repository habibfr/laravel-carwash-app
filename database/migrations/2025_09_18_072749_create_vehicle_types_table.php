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
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->uuid(column: 'id')->primary()->default(value: DB::raw('gen_random_uuid()'));
            $table->string('name'); // sedan, suv, truck, van, motorcycle
            $table->text('description')->nullable();
            $table->decimal('price_multiplier', 3, 2)->default(1.00);
            $table->timestamps();

            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_types');
    }
};
