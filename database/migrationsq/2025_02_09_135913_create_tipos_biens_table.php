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
        Schema::create('tipos_biens', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();            
            $table->foreignId('encargado_id')->constrained('personals')->onDelete('cascade');
            $table->foreignId('suplente_id')->nullable()->constrained('personals')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_biens');
    }
};
