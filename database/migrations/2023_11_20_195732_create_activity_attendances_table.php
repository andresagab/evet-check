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
        Schema::create('activity_attendances', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('activity_id')->nullable(false);
            $table->unsignedBigInteger('person_id')->nullable(false);
            $table->char('state', 2)->nullable(false)->default('SU');
            $table->dateTime('attendance_date')->nullable(true)->default(null);

            # foreign keys
            $table->foreign('activity_id')->references('id')->on('activities')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('person_id')->references('id')->on('people')->restrictOnDelete()->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        # drop foreign key
        Schema::table('activity_attendances', function (Blueprint $table) {
            # drop
            $table->dropForeign('activity_attendances_activity_id_foreign');
            $table->dropForeign('activity_attendances_person_id_foreign');
        });
        # drop schema
        Schema::dropIfExists('activity_attendances');

    }
};
