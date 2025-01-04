<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('currency_id');
            $table->string('from_currency');
            $table->string('to_currency');
            $table->decimal('amount_from', 15, 2);
            $table->decimal('amount_to', 15, 2);
            $table->decimal('conversion_rate', 15, 6);
            $table->timestamp('transaction_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};