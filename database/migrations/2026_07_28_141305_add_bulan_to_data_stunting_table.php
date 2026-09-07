<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_stunting', function (Blueprint $table) {

            $table->tinyInteger('bulan')->after('persentase_pelayanan');

        });
    }

    public function down(): void
    {
        Schema::table('data_stunting', function (Blueprint $table) {

            $table->dropColumn('bulan');

        });
    }
};