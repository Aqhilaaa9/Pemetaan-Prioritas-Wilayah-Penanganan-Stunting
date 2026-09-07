<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('puskesmas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kabupaten_id')
                  ->constrained('kabupaten')
                  ->onDelete('cascade');

            $table->string('nama_puskesmas');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('puskesmas');
    }
}; 
