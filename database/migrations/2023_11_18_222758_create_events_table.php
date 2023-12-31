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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('name', 250)->unique();
            $table->year('year')->unique();
            $table->string('banner_path')->nullable(true)->default(null);
            $table->string('poster_path')->nullable(true)->default(null);
            $table->string('virtual_card_path')->nullable(true)->default(null);
            $table->string('logo_path')->nullable(true)->default(null);
            $table->char('state', 2)->nullable(false)->default('O');
            $table->integer('symbolic_cost')->nullable(false)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
