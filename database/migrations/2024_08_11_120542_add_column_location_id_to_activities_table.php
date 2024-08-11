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
        Schema::table('activities', function (Blueprint $table) {
            # add column
            $table->unsignedBigInteger('location_id')->nullable();
            # add foreign key
            $table->foreign('location_id')->references('id')->on('locations')->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        # drop foreign key
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
        });
        # drop column
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('location_id');
        });
    }
};
