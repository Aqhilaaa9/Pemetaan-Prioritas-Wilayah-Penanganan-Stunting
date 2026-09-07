<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_stunting', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->foreignId('kabupaten_id')
                  ->constrained('kabupaten')
                  ->onDelete('cascade');

            $table->foreignId('puskesmas_id')
                  ->constrained('puskesmas')
                  ->onDelete('cascade');

            // Data stunting
            $table->integer('jumlah_balita');
            $table->integer('jumlah_stunting');
            $table->integer('jumlah_bblr');
            $table->decimal('persentase_asi', 5, 2);
            $table->decimal('persentase_pelayanan', 5, 2);

            $table->year('tahun');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_stunting');
    }
};
