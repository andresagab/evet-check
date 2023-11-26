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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('event_id')->nullable(false);
            $table->string('author_name', 500)->nullable(false);
            $table->string('name', 500)->nullable(false);
            $table->integer('slots')->nullable(false);
            $table->char('type', 2)->nullable(false);
            $table->char('modality', 1)->nullable(false)->default('P');
            $table->char('status', 1)->nullable(false)->default('A');
            $table->boolean('hide')->nullable(false)->default(0);
            $table->dateTime('date')->nullable(false);

            # foreign keys
            $table->foreign('event_id')->references('id')->on('events')->restrictOnDelete()->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        # drop foreign key
        Schema::table('activities', function (Blueprint $table) {
            # drop
            $table->dropForeign('activities_event_id_foreign');
        });
        # drop schema
        Schema::dropIfExists('activities');

    }
};
