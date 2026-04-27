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
        Schema::table('quotes_categories', function (Blueprint $table) {
            $table->string('locale', 5)->default('it')->after('name');
        });

        Schema::table('riddles_categories', function (Blueprint $table) {
            $table->string('locale', 5)->default('it')->after('name');
        });

        Schema::table('daily_quotes', function (Blueprint $table) {
            $table->string('locale', 5)->default('it')->after('quote_id');
            $table->unique(['day', 'locale']);
        });

        Schema::table('daily_riddles', function (Blueprint $table) {
            $table->string('locale', 5)->default('it')->after('riddle_id');
            $table->unique(['day', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_riddles', function (Blueprint $table) {
            $table->dropUnique(['day', 'locale']);
            $table->dropColumn('locale');
        });

        Schema::table('daily_quotes', function (Blueprint $table) {
            $table->dropUnique(['day', 'locale']);
            $table->dropColumn('locale');
        });

        Schema::table('riddles_categories', function (Blueprint $table) {
            $table->dropColumn('locale');
        });

        Schema::table('quotes_categories', function (Blueprint $table) {
            $table->dropColumn('locale');
        });
    }
};
