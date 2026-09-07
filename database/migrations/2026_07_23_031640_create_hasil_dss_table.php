<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_dss', function (Blueprint $table) {
            $table->id();

            $table->foreignId('data_stunting_id')
                  ->constrained('data_stunting')
                  ->onDelete('cascade');

            $table->decimal('nilai_dss', 8, 4);

            $table->integer('ranking');

            $table->enum('prioritas', [
                'Tinggi',
                'Sedang',
                'Rendah'
            ]);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_dss');
    }
};
