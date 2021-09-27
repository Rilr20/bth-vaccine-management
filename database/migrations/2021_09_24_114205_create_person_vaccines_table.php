<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonVaccinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_vaccines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');//->references('personnumber')->on('patients');//foreign key
            $table->unsignedBigInteger('staff');//->references('id')->on('users'); //foreign key
            $table->unsignedBigInteger('vaccine_id');//->references('id')->on('vaccines');//foreign key
            $table->dateTime('date_taken');
            $table->date('expiration_date');
            $table->timestamps();
            // $table->f oreignId('users_idj')->constrained();
            // $table->foreignId('staff')
            // $table->foreignId('patient')
            // $table->foreignId('vaccine')
            // $table->foreign('patient')->references('personnumber')->on('patients');

            $table->foreign('staff')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('vaccine_id')->references('id')->on('vaccines')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_vaccines');
    }
}
