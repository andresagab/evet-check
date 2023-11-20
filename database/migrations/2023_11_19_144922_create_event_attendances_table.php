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
        Schema::create('event_attendances', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('event_id')->nullable(false);
            $table->unsignedBigInteger('person_id')->nullable(false);
            $table->unsignedBigInteger('institution_id')->nullable(false);
            $table->string('other_institution', 250)->nullable(true)->default(null);
            $table->char('participation_modality', 2)->nullable(false);
            $table->char('type', 2)->nullable(false);
            $table->char('stay_type', 1)->nullable(false)->default('P');

            $table->timestamps();

            # foreign keys
            $table->foreign('event_id')->references('id')->on('events')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('person_id')->references('id')->on('people')->restrictOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        # drop foreign key
        Schema::table('event_attendances', function (Blueprint $table) {
            # drop
            $table->dropForeign('event_attendances_event_id_foreign');
            $table->dropForeign('event_attendances_person_id_foreign');
        });
        # drop schema
        Schema::dropIfExists('event_attendances');
    }
};
