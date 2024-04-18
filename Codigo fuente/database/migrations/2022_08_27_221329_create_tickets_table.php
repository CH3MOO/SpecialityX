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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->string('description');//message
            $table->text('answer')->default("Hola, tu solicitud ha sido atendida");//answer message to user
            $table->unsignedBigInteger('ticket_type_id');//1,2,3,4, sugerencia, queja, cambio de datos, retiro
            $table->integer('status');
            $table->boolean('approved')->nullable();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('identity_document_name')->nullable();
            $table->string('identity_document_number')->nullable();
            $table->string('wallet')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('name_old')->nullable();
            $table->string('last_name_old')->nullable();
            $table->string('country_old')->nullable();
            $table->string('state_old')->nullable();
            $table->string('_old')->nullable();
            $table->string('identity_document_name_old')->nullable();
            $table->string('identity_document_number_old')->nullable();
            $table->string('wallet_old')->nullable();
            $table->string('phone_number_old')->nullable();
            $table->string('email_old')->nullable();
            $table->timestamp('close_date')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ticket_type_id')->references('id')->on('ticket_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
