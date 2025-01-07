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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('category_id');
            $table->string('user_id');
            $table->string('name');
            $table->string('currency');
            $table->float('amount', 12, 2);
            $table->string('bank_amount')->nullable();
            $table->string('recipient_currency')->nullable();
            $table->float('recipient_amount', 12, 2)->nullable();
            $table->string('bank_recipient_amount', 12, 2)->nullable();
            $table->string('MRU')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};