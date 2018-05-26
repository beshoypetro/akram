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
            $table->integer('organization_id')->default(0);
            $table->integer('role_id');
            $table->uuid('uuid')->default(Uuid::uuid4());
            $table->string('user_name');
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('avatar_url')->nullable();
            $table->string('bio')->nullable();
            $table->string('job_title')->nullable();
            $table->boolean('is_admin')->default(0);
            $table->boolean('is_owner')->default(0);
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
