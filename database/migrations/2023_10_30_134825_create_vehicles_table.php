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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name',75);
            $table->set('model',['Crossover','Sedan','Sport','Coupe']);
            $table->set('fuel',['Gasolina','Diésel','Hibrido','Eléctrico']);
            $table->integer('price');
            $table->string('motor',60);
            $table->date('production_year');
            $table->text('picture')->nullable();
            $table->foreignId('concessionaire_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
