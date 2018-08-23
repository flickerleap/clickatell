<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClickatellLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (config('services.clickatell.log') == true) {
            Schema::create(config('services.clickatell.log_table'), function (Blueprint $table) {
                $table->increments('id');
                $table->string('to', 12);
                $table->text('content');
                $table->string('code', 10);
                $table->text('status');
                $table->string('message_id', 32);
                $table->timestamp('delivered_to_gateway')->nullable();
                $table->timestamp('received_by_recipient')->nullable();
                $table->timestamp('created_at')->useCurrent();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('services.clickatell.log_table'));
    }
}
