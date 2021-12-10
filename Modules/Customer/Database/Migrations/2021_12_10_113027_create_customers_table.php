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
            $table->string('email');
            $table->bigInteger('balance')->default(0);
            $table->string('account_tier');
            $table->string('status');
            $table->string('gender');
            $table->string('profile_picture');
            $table->string('signature');
            $table->boolean('push_notification_settings');
            $table->boolean('sms_notification_settings');
            $table->string('marital_status');
            $table->string('date_of_birth');
            $table->string('state');
            $table->string('area');
            $table->string('city');
            $table->dateTime('approved_at');
            $table->dateTime('last_login');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number')->unique();
            $table->timestamp('phone_number_verified_at');
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
