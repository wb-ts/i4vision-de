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
            $table->string('email')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username');
            $table->text('description')->nullable();
            $table->string('phone')->unique();
            $table->boolean('gender')->default(0);

            $table->boolean('status')->default(0);
            $table->enum('type', ['super_admin', 'admin', 'user'])->nullable();
            $table->string('password');

            $table->timestamp('email_verified_at')->nullable();
            $table->foreignId('client_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('avatar')->default('avatars/default.png');
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
