<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gigs', function (Blueprint $table) {
            $table->id();
            $table->string('event_type');
            $table->string('street_address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('gigs');
    }
};
