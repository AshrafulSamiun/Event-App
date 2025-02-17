<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('user_type');
            $table->string('name');
            $table->integer('project_id');
            $table->integer('company_id')->nullable($value = true);
            $table->integer('account_holder_id');
            $table->tinyInteger('project_type');
            $table->tinyInteger('authenticated_by_admin');
            $table->string('pin');
            $table->tinyInteger('status_active')->default(1)->index();
            $table->tinyInteger('is_deleted')->default(0);
            $table->string('email')->unique();
            $table->string('password');
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
