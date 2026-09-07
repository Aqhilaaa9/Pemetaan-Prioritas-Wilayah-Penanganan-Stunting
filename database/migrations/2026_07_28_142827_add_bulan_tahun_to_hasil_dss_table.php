<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hasil_dss', function (Blueprint $table) {

            $table->tinyInteger('bulan')->after('data_stunting_id');

            $table->year('tahun')->after('bulan');

        });
    }

    public function down(): void
    {
        Schema::table('hasil_dss', function (Blueprint $table) {

            $table->dropColumn(['bulan','tahun']);

        });
    }
};