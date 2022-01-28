<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionCommissonSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_commisson_settings', function (Blueprint $table) {
//            -id
//            -percentage
//            -amount
//            -transaction_type(internal or external)
//            -created_at
//            -updated_at

            $table->id();
            $table->bigInteger("percentage");
            $table->bigInteger("amount");
            $table->enum("transaction_type",["internal","external"]);
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
        Schema::dropIfExists('transaction_commisson_settings');
    }
}
