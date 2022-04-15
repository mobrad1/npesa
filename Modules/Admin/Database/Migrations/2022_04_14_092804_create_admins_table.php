<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string("first_name");
            $table->string("last_name");
            $table->string("email")->nullable();
            $table->string("phone");
            $table->string("pin");
            $table->string("gender")->nullable();
            $table->bigInteger("balance")->default(0);
            $table->string("profile_picture")->nullable();
            $table->string("signature")->nullable();
            $table->boolean("settings_push_notifications")->default(false);
            $table->boolean("settings_sms_notifications")->default(false);
            $table->boolean("settings_email_notifications")->default(false);
            $table->longText("settings_general")->nullable();
            $table->string("marital_status")->nullable();
            $table->date("date_of_birth")->nullable();
            $table->string("state")->nullable();
            $table->string("area")->nullable();
            $table->string("city")->nullable();
            $table->string("address")->nullable();
            $table->string("latitude")->nullable();
            $table->string("longitude")->nullable();
            $table->string("remember_token")->nullable();
            $table->dateTime("email_verified_at")->nullable();
            $table->dateTime("phone_number_verified_at")->nullable();
            $table->dateTime("last_login")->nullable();
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
        Schema::dropIfExists('admins');
    }
}
