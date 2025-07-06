<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id('driver_id');
            $table->string('driver_name', 100);
            $table->string('driver_email', 100)->unique();
            $table->string('driver_password');
            $table->string('driver_no_ktp', 50)->nullable();
            $table->string('driver_no_kk', 50)->nullable();
            $table->string('driver_photo_ktp')->nullable();
            $table->string('driver_photo_kk')->nullable();
            $table->string('driver_photo_profile')->nullable();
            $table->text('driver_address')->nullable();
            $table->string('driver_birthplace', 100)->nullable();
            $table->date('driver_birthdate')->nullable();
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
