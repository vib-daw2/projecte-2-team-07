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
        Schema::create('concessionaires', function (Blueprint $table) {
            $table->id();
            $table->string('name',75);
            $table->integer('phone_number');
            $table->string('email',40);
            $table->string('address',75);
            $table->string('coordinates',75)->default("2.1403913832109445, 41.33689605054748"); 
            $table->text('picture')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concessionaires');
    }
};
