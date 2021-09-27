<?php

use App\Models\patient;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('personnumber', 12)->unique();
            $table->string('fullname');
            $table->string('phonenumber', 15)->nullable();
            $table->date('birthdate');
            $table->string('gender');
            $table->text('journal')->nullable();
            $table->timestamps();
        });
        $patient = new patient();
        $patient->personnumber = '9906071234';
        $patient->fullname = 'Jonas Jonasson';
        $patient->phonenumber = "+467543442526";
        $patient->birthdate = date('1999-06-24');
        $patient->gender = "Male";
        $patient->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
