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
        Schema::create('tipo_bien_caracteristicas', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('tipo_bien_id');
              $table->unsignedBigInteger('caracteristica_id');
              $table->foreign('tipo_bien_id')->references('id')->on('tipos_biens')->onDelete('cascade');
              $table->foreign('caracteristica_id')->references('id')->on('caracteristicas')->onDelete('cascade');              
              $table->boolean("requerido")->default(0);
              $table->softDeletes();
              $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_bien_caracteristicas');
    }
};
