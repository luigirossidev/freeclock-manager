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
        Schema::create('daily_quotes', function (Blueprint $table) {
            $table->id();
            // day field, date format
            $table->date('day');
            // id of the quote
            $table->foreignId('quote_id')->constrained('quotes');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_quotes');
    }
};
