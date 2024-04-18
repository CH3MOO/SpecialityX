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
        Schema::create('budget_tracings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('budget_id');
            $table->unsignedBigInteger('employee_id');
            //$table->unsignedBigInteger('task_id');
            $table->date('fecha');
            $table->integer('desde');
            $table->integer('hasta');
            $table->boolean('asistencia');
            $table->float('jornal');
            //$table->double('total');
            //$table->integer('corte');
            $table->boolean('pago');
            $table->mediumText('otros')->nullable();


            $table->timestamps();
            //$table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budget_tracings');
    }
};
