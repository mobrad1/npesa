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
            $table->string('account_tier')->default("savings");
            $table->string('gender')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('signature')->nullable();
            $table->boolean('push_notification_settings')->nullable();
            $table->boolean('sms_notification_settings')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('state')->nullable();
            $table->string('area')->nullable();
            $table->string('city')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number')->unique();
            $table->timestamp('phone_number_verified_at')->nullable();
            $table->string('pin');
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
