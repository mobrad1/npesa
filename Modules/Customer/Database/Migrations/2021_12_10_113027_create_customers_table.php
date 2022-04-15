<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->bigInteger('balance')->default(0);
            $table->string('account_tier_id')->default(1);
            $table->string('gender')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('signature')->nullable();
            $table->boolean('settings_push_notification')->default(true);
            $table->boolean('settings_notification')->default(true);
            $table->boolean('settings_email_notifications')->default(true);
            $table->boolean('settings_general')->default(true);
            $table->string('marital_status')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string("latitude")->nullable();
            $table->string("longitude")->nullable();
            $table->string('state')->nullable();
            $table->string('area')->nullable();
            $table->string('city')->nullable();
            $table->string("address")->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->unique();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('pin');
            $table->enum('channel',['ussd','mobile','web','pos']);
            $table->rememberToken();
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
        Schema::dropIfExists('customers');
    }
}
