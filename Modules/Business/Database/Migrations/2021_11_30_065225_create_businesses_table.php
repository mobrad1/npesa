<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            // Required information for business
            $table->string('business_name');
            $table->string('email')->nullable();
            $table->string('pin');
            $table->timestamp('email_verified_at')->nullable();
            // Secondary information for business user
            $table->boolean('is_completed_owner_profile')->default(false);
            $table->string('first_name')->nullable();
            $table->bigInteger('balance')->default(0);
            $table->string('last_name')->nullable();
            $table->string('business_number')->unique();
            $table->string('phone')->unique();
            $table->boolean('is_registered')->default(false);
            $table->integer('team_size')->default(1);
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
        Schema::dropIfExists('businesses');
    }
}
