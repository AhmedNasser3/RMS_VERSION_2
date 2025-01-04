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
        Schema::create('internal_debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('amount');
            $table->string('recipient');
            $table->string('reason');
            $table->string('currency')->default('USD');  // إضافة حقل العملة
            $table->decimal('manual_exchange_rate', 8, 2)->nullable();  // إضافة حقل سعر الصرف اليدوي
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internal_debts');
    }
};