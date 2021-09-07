<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlowEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flow_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flow_id')->nullable()->constrained('flows')->onDelete('cascade');

            $table->string('flow_entriable_type');
            $table->string('flow_entriable_id');
            $table->integer('time')->nullable();
            $table->integer('sequence')->default(0);
            $table->date('run_from')->nullable();
            $table->date('run_to')->nullable();
            $table->string('dates')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('flow_entries');
    }
}
