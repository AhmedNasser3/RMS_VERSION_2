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
        Schema::create('coins', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم العملة
            $table->string('full_name'); // الاسم الكامل للعملة
            $table->string('symbol'); // رمز العملة
            $table->decimal('price', 10, 2)->nullable(); // السعر من الـ API
            $table->decimal('manual_price', 10, 2)->nullable(); // السعر اليدوي
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coins');
    }
};
