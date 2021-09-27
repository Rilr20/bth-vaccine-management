<?php

use App\Models\vaccine;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccines', function (Blueprint $table) {
            $table->id();
            $table->string('vaccine_name', 50);
            $table->string('vaccine_type', 50);
            $table->timestamps();
        });
        $this->migrationCreate();
    }
    public function migrationCreate() {
        $vaccine_name = ["Moderna", 'AstraZeneca', 'Pfizer', 'MMR', 'Influenza vaccine', 'Gardasil'];
        $vaccine_type = ['Covid-19', 'Covid-19', 'Covid-19', 'Rubella, Measles, Mumps', 'Influenza', 'Human papillomavirus infection'];

        for ($i=0; $i < count($vaccine_name); $i++) { 
            $vaccine = new vaccine();
            $vaccine->vaccine_name = $vaccine_name[$i];
            $vaccine->vaccine_type = $vaccine_type[$i];
            $vaccine->save();
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccines');
    }
}
