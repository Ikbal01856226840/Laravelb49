<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('access_level')->comment('0=Super Admin, 1=Admin, 2=Shop');
            $table->integer('status')->comment('0=Inactive, 1=Active');
            $table->integer('allow_sub_accounts');
            $table->date('account_valid_till')->nullable();
            $table->integer('parent_id');
            $table->string('shop_name')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('receipt_note')->nullable();
            $table->float('service_charge');
            $table->string('referenced_by')->nullable();
            $table->date('registration_date')->nullable();
            $table->integer('reg_approval_status')->comment('0=Deny, 1=Approve, 2=Pending');
            $table->date('reg_approval_date')->nullable();
            $table->date('last_login_date')->nullable();
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
        Schema::dropIfExists('users');
    }
}
