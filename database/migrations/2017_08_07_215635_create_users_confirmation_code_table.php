<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersConfirmationCodeTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirmation_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->boolean('is_guest')->default(false);
            $table->string('code')->unique();
            $table->boolean('confirmed')->default(false);
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
        Schema::drop('confirmation_codes');
    }
}
