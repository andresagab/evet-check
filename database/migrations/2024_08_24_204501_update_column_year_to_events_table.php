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
        Schema::table('events', function (Blueprint $table) {
            $table->year('year')->nullable()->change();
        });

        # remove unique index
        Schema::table('events', function (Blueprint $table) {
            $table->dropUnique(['year']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // rollback changes
            $table->year('year')->unique()->change();
        });
    }
};
