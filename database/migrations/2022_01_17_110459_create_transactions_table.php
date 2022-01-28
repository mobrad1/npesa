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
            $table->string('channel'); //web,usd,mobile,pos
            $table->enum('transaction_type',['internal','external']);
            $table->string("transactional_from_type")->nullable(); //Business or Customer
            $table->string("transactional_to_type")->nullable();// Business or Customer
            $table->string("transactional_from_id")->nullable();
            $table->string("transactional_to_id")->nullable();
            $table->string("transaction_from_group")->default("AGOGA"); // GTB OR ZENITH
            $table->string("transaction_to_group")->default("AGOGA"); // AGOGA
            $table->string("transaction_to_account_number")->nullable();
            $table->string("transaction_from_account_number")->nullable();
            $table->string("transaction_category");
            $table->bigInteger("transaction_cost");
            $table->string("reference");
            $table->bigInteger("amount");
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
