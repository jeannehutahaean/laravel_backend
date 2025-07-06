<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id(); // Primary key: id (unsigned big int auto-increment)
            
            // Foreign keys
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('vehicle_id');

            // Detail kolom
            $table->dateTime('start_time');
            $table->dateTime('estimated_arrival');
            $table->dateTime('actual_arrival')->nullable();
            $table->string('goods_type', 100);
            $table->enum('status', ['ongoing', 'completed', 'delayed'])->default('ongoing');

            $table->timestamps(); // created_at & updated_at

            // Foreign key constraint
            $table->foreign('driver_id')->references('driver_id')->on('drivers')->onDelete('cascade');
            // (Jika kamu sudah punya tabel `vehicles`, tambahkan FK di sini juga:)
            // $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
