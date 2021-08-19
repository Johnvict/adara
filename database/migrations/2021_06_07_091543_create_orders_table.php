<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('beneficiary_id');
            $table->foreign('beneficiary_id')
                ->references('id')
                ->on('beneficiaries')
                ->onDelete('cascade');

            $table->string('date');
            $table->float('total_amount', 8, 4);
            $table->string('repayment_duration');
            $table->string('repayment_start_date');
            $table->boolean('payment_completed')->default(false);
            $table->string('outstanding_amount');
            $table->enum('payment_plan', ['daily', 'weekly', 'monthly']);
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
        Schema::dropIfExists('orders');
    }
}
