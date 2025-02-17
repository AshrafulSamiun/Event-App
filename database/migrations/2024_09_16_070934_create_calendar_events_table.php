<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('system_no',100)->nullable($value = true);
            $table->Integer('system_prefix')->default(0); 
            $table->Integer('current_year')->nullable($value = true);
            $table->date('event_date')->nullable($value = true);
            $table->time('start_time');
            $table->time('end_time');
            $table->tinyInteger('priority_level')->default(0);
            $table->string('subject',500)->nullable($value = true);
            $table->tinyInteger('recurring_cycle')->nullable($value = true);
            $table->tinyInteger('repeat_every')->nullable($value = true);
            $table->date('start_date')->nullable($value = true);
            $table->tinyInteger('repeat_no_date_id')->nullable($value = true);
            $table->text('required_action')->nullable($value = true);
            $table->text('message')->nullable($value = true);
            $table->string('comments',500)->nullable($value = true);        
            $table->boolean('never_end')->nullable($value = true);
            $table->boolean('repeat_end_after')->nullable($value = true);
            $table->boolean('occerance_number')->nullable($value = true);
            $table->tinyInteger('end_on')->nullable($value = true);
            $table->date('end_date')->nullable($value = true);
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
        Schema::dropIfExists('calendar_events');
    }
}
