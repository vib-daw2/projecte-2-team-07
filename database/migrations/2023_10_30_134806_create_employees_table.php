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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name',75);
            $table->integer('phone_number');
            $table->string('email',40);
            $table->string('address',75);
            $table->string('dni',10);
            $table->set('charge',['Director','Gerente','Asesor','Técnico','Operador','Ayudante']);
            $table->set('department',['Asistencia técnica','Ventas','Finanzas','Marketing','Recursos Humanos','Atención al Cliente']);
            $table->foreignId('concessionaire_id')->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
