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
        Schema::table('event_attendances', function (Blueprint $table) {

            # create column
            $table->boolean('approve_certificate_manually')->nullable(false)->default(0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_attendances', function (Blueprint $table) {
            # drop created column
            $table->dropColumn(['approve_certificate_manually']);
        });
    }
};
