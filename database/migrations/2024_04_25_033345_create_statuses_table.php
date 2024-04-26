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
        Schema::create('statuses', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('state');
            $table->datetime('startDate');
            $table->datetime('endDate');
            $table->string('observation');
            $table->unsignedBigInteger('idDetail');
            $table->unsignedBigInteger('idUser');
            $table->timestamps();

            $table->foreign('idDetail')->references('id')->on('details');
            $table->foreign('idUser')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
