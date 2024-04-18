<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('budget_id');
            $table->date('fecha');
            $table->double('monto_pago');
            $table->text('observaciones');
            $table->timestamps();
            $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('cascade');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budget_payments');
    }
};
