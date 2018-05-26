<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvitesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token')->index();//->default(Uuid::uuid4());
            $table->string('name');
            $table->string('email');
            $table->integer('organization_id')->default(0);
            $table->timestamp('expiration')->default(Carbon::now()->addDays(3));
            $table->boolean('accepted')->default(0);
            $table->string('accepted_at')->nullable();
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
        Schema::drop('invites');
    }
}
