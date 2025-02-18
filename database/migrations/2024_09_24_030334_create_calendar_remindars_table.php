<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarRemindarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_remindars', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('reminder_no')->nullable($value = true);
            $table->tinyInteger('reminder_period')->nullable($value = true);
            $table->Integer('mst_id')->default(0);
            $table->time('time');
            $table->date('reminder_date')->nullable($value = true);
            $table->string('email',150)->nullable($value = true);
            $table->boolean('mail_sent')->default(0);
            $table->string('description',1500)->nullable($value = true);           
            $table->integer('inserted_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->tinyInteger('status_active')->default(1);
            $table->tinyInteger('is_deleted')->default(0);
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
        Schema::dropIfExists('calendar_remindars');
    }
}
