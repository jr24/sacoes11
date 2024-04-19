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
            $table->unsignedBigInteger('idAdminReceptionist');
            $table->unsignedBigInteger('idCustomer');
            $table->unsignedBigInteger('idTailor');
            $table->timestamps();

            $table->foreign('idAdminReceptionist')->references('id')->on('users');
            $table->foreign('idCustomer')->references('id')->on('users');
            $table->foreign('idTailor')->references('id')->on('users');
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
