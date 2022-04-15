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
            $table->string('business_number')->unique()->nullable();
            $table->bigInteger('parent_id')->comment('branch owner')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->string('code_name')->nullable();
            $table->bigInteger('balance')->default(0);
            $table->string('pin');
            $table->bigInteger('account_tier_id')->default(1);
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->unique();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_address')->nullable();
            $table->string('contact_person_email')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_completed_profile')->default(false);
            $table->boolean('settings_with_account_number')->default(false);
            $table->boolean('settings_accept_any_price')->default(false);
            $table->boolean('settings_push_notification')->default(false);
            $table->boolean('settings_sms_notifications')->default(false);
            $table->boolean('settings_email_notifications')->default(false);
            $table->boolean('settings_settlements_allowed')->default(false);
            $table->bigInteger('settings_settlements_interval')->default(0);
            $table->boolean('settings_agent_status')->default(false);
            $table->json('settings_general')->nullable();
            // Secondary information for business user
            $table->boolean('is_completed_owner_profile')->default(false);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('area')->nullable();
            $table->bigInteger('team_size')->default(1);
            $table->boolean('is_registered')->default(false);
            $table->boolean('approved')->default(false);
            $table->string('reg_type')->nullable()->comment('LTD, NGO, Business name,etc');
            $table->string('reg_number')->nullable();
            $table->string('developer_api_key')->nullable();
            $table->string('developer_public_key')->nullable();
            $table->string('developer_secret_key')->nullable();
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
