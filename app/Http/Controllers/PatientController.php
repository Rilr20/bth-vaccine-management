<?php

namespace App\Http\Controllers;

use App\Models\patient;
use App\Models\person_vaccine;
use App\Models\schedule;
use App\Models\vaccine;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private $title = "Patient";

    private function nextThreeDays()
    {
        $dateArray = [];
        $date = Carbon::now();
        for ($i=0; count($dateArray) < 12; $i++) { 
            $date->addDays(1);
            if ($date->format('l') != "Saturday" && $date->format('l') != "Sunday")
            {
                array_push($dateArray,$date->format('l'));
                array_push($dateArray, $date->toDateString() .  " 13:00:00");
                array_push($dateArray, $date->toDateString() .  " 15:00:00");
                array_push($dateArray, $date->toDateString() .  " 17:00:00");
                // $dateArray[$i] = Carbon::now()->addDays($i + 1);
            }
        }
        // dd($dateArray);
        $dateArray = $this->takenTimes($dateArray);
        return $dateArray;
    }

    private function takenTimes($dateArray) {
        $schedule = schedule::select('booked')->where([
            ['booked', ">=", Carbon::today()]
        ])->get();
        foreach ($schedule as $booked) {
            // echo $booked->booked . "booked times <br>";
            for ($i=0; $i < count($dateArray); $i++) { 
                // echo $booked->booked . " " . $dateArray[$i] . "<br>";
                if ($booked->booked == $dateArray[$i]) {
                    array_splice($dateArray, $i, 1);
                    // echo "time taken";
                }
                // echo $dateArray[$i];
                // echo "<br>";
            }
        }
        return $dateArray;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $vaccinations = person_vaccine::all();
        $vaccines = vaccine::all();

        $dateArray = $this->nextThreeDays();
        if ($request->input('search') != null)  {
            $patients = $this->search($request);
        } else {
            $patients = patient::all();
        }
        return view('patient.index', ["title"=>$this->title, "patients"=>$patients, "vaccinations"=> $vaccinations, "vaccines"=>$vaccines, "dates"=> $dateArray]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function search(Request $request) 
    {
        // dd("händer något");
        $findpatient = $request->input('search');
        // $vaccinations = person_vaccine::all();
        // $vaccines = vaccine::all();
        $patients = patient::where('personnumber', 'LIKE', "%$findpatient%")->orWhere('fullname', 'LIKE', "%$findpatient%")->get();
        return $patients;
        // redirect('/patient',["title" => $this->title, "patients" => $patients, "vaccinations" => $vaccinations, "vaccines" => $vaccines]);
        // return view('patient.index', ["title" => $this->title, "patients" => $patients, "vaccinations" => $vaccinations, "vaccines" => $vaccines]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // echo "detta är store";
        if($request->input('book') == 'book') {
            $time = $this->book($request);
            $dateArray = $this->nextThreeDays();
            $vaccines = vaccine::all();
            return view('patient.index', ["title" => $this->title, "vaccines" => $vaccines, "dates" => $dateArray, "book"=>$time]);
            // return view('patient.index', ["title" => $this->title, "book" => "Your booked time is $time"]);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function book(Request $request) 
    {
        if ($request->input('date') == null) {
            return "No Time selected";
        }
        // dd($request->input());
        // echo "tja detta är book";
        // dd($request->input());
        // scheduled::create([
        // ]);
        $id = $this->patientExist($request);
        // echo $id->id;
        if ($id != "Patient Credidentials Are wrong" && $id != "Fill out the patient creditentials") {
            if ($request->input('disease') != null) {
                schedule::make([
                    'patient'=> $id->id,//create staff it doesn't exist
                    'disease'=> $request->input('disease'),
                    'booked'=> $request->input('date')
                ])->save();
                return "The time you booked is: " . $request->input('date');
            } else {
                return "No vaccine selected";
            }
        } else {
            return $id;
        }
    }
    private function patientExist($request) {
        $patient_id = patient::select('id', 'fullname')->where('personnumber', $request->input('personnumber'))->first();
        if ($patient_id == null) {
            if ($request->input('name') != null
                && $request->input('birthdate') != null){
                // echo "patient doesn't exist";
                return $this->create_patient($request); //returns id
            } else {
                return "Fill out the patient creditentials";
            }
        } else {
            // echo "patient exists";
            //check if the rest of information is correct
            if ($patient_id->fullname !=$request->input('name')) {
                // echo "patient exist but wrong name";
                $dateArray = $this->nextThreeDays();
                $vaccines = vaccine::all();
                return "Patient Credidentials Are wrong";
            }
            return $patient_id;
        }
    }
    private function create_patient($patient)
    {
        $patient_id = 2;
        $patient_id = "creating patient";
        $number = $patient->input('phonenumber') !== null ? $patient->input('phonenumber') : null;
        $created = patient::make([
            'personnumber' => $patient->personnumber,
            'fullname' => $patient->name,
            'phonenumber' => $number,
            'birthdate' => $patient->birthdate,
            'gender' => $patient->gender,
        ])->save();
        $patient_id = patient::select('id')->where('personnumber', $patient->personnumber)->first();
        return $patient_id; //id av patient
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
