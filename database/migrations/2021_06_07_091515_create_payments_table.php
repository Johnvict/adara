<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('beneficiary_id');
            $table->foreign('beneficiary_id')
                ->references('id')
                ->on('beneficiaries')
                ->cascade('delete');

            $table->string('date_paid');
            $table->string('date');
            $table->string('status');
            $table->string('invoice_no');
            $table->string('receipt_no');
            $table->string('defaulted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
