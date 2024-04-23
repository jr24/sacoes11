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
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->primary();
            $table->dateTime('startDate');
            $table->dateTime('endDate');
            $table->string('description');
            $table->string('priority');
            $table->unsignedBigInteger('idAdminRecepcionista');
            $table->unsignedBigInteger('idCliente');
            $table->unsignedBigInteger('idSastre');
            $table->timestamps();

            $table->foreign('idAdminRecepcionista')->references('id')->on('users');
            $table->foreign('idCliente')->references('id')->on('users');
            $table->foreign('idSastre')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
