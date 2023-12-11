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

            # add certificate path
            $table->string('certificate_path')->nullable(true)->default(null);
            # add certificate_setup
            $table->json('certificate_setup')->nullable(true)->default(null);
            # add min percent to certificate
            $table->integer('min_percent')->nullable(false)->default(70);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            # drop created columns
            $table->dropColumn([
                'certificate_path',
                'certificate_setup',
                'min_percent',
            ]);
        });
    }
};
