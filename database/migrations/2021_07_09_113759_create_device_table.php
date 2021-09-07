<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device', function (Blueprint $table) {
            $table->id();
            $table->string('device_code')->nullable();
            // $table->text('description')->nullable();
            $table->integer('client_id')->nullable();
            $table->boolean('enabled')->nullable();
            $table->string('timestamp_registered')->nullable();
            $table->string("eMail_of_admin")->nullable();
            $table->text("configuration")->nullable();
            $table->text("description")->nullable();
            $table->string("device_up_time")->nullable();
            $table->string("device_down_time")->nullable();
            $table->string("device_heartbeat_minutes")->nullable();
            $table->string("timestamp_last_accessed")->nullable();
            $table->string("ip_address_of_last_access")->nullable();
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
        Schema::dropIfExists('device');
    }
}
