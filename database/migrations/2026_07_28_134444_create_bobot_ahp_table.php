<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('bobot_ahp', function(Blueprint $table){

            $table->id();
        
            $table->string('kode');
        
            $table->string('kriteria');
        
            $table->decimal('bobot',8,4);
        
            $table->enum('tipe',['benefit','cost']);
        
            $table->timestamps();
        
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bobot_ahp');
    }
};
