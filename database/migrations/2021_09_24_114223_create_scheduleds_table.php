<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduledsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheduleds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient');//->references('id')->on('patients');//foreign key
            $table->unsignedBigInteger('staff');//->references('id')->on('users');//foreign key
            $table->unsignedBigInteger('vaccine_id');//->references('id')->on('vaccines');//foreign key
            $table->dateTime('booked');
            // $table->timestamps();

            $table->foreign('staff')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('vaccine_id')->references('id')->on('vaccines')->onDelete('cascade');
            $table->foreign('patient')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scheduleds');
    }
}
