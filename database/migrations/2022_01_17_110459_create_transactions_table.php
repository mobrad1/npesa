<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('channel')->comment('web,ussd,mobiie');
            $table->enum('transaction_type',['internal','external']);
            $table->string('transactional_from_type')->comment('Business, customer,agent')->nullable();
            $table->string('transactional_to_type')->comment('Business,customer')->nullable();
            $table->bigInteger('transactional_from_id');
            $table->bigInteger('transactional_to_id')->nullable();
            $table->string('transaction_from_group')->default('AGOGA');
            $table->string('transaction_to_group')->default('AGOGA');
            $table->string('transaction_from_user_number')->nullable();
            $table->string('transaction_to_user_number')->nullable();
            $table->string('transaction_account_number')->nullable();
            $table->bigInteger('transaction_category_id');
            $table->string('transaction_reference_internal')->nullable();
            $table->string('transaction_reference_external')->nullable();
            $table->double('transaction_amount')->default(0);
            $table->double('transaction_amount_credit')->default(0);
            $table->double('transaction_amount_debit')->default(0);
            $table->double('transaction_cost')->default(0);
            $table->double('transaction_cost_credit')->default(0);
            $table->double('transaction_cost_debit')->default(0);
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->enum('settlements_type',['manual','auto'])->comment('Manual,Auto');
            $table->enum("status",["Pending","Complete","Failed"]);
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
        Schema::dropIfExists('transactions');
    }
}
