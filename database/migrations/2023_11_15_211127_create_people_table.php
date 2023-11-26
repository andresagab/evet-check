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
        Schema::create('people', function (Blueprint $table) {
            $table->id();

            $table->string('names', 100)->nullable(false);
            $table->string('surnames', 100)->nullable(false);
            $table->string('nuip', 255)->nullable(false);
            $table->char('sex', 1)->nullable(true);
            $table->string('cel', 50)->nullable(true);
            $table->string('phone', 50)->nullable(true);
            $table->string('email', 250)->nullable(true);
            #$table->char('type', 1)->nullable(true);
            $table->unsignedBigInteger('user_id')->nullable(true);

            # add foreign keys
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        # drop foreign key
        Schema::table('people', function (Blueprint $table) {
            # drop
            $table->dropForeign('people_user_id_foreign');
        });
        # drop schema
        Schema::dropIfExists('people');
    }
};
