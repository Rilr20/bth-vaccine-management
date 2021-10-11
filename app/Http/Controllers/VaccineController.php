<?php

namespace App\Http\Controllers;

use App\Models\patient;
use App\Models\person_vaccine;
use App\Models\vaccine;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VaccineController extends Controller
{
    private $title = "Vaccine";

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $vaccine = new vaccine();
        $vaccine = vaccine::all();
        return view('vaccine.index', ["title"=>$this->title, "vaccines"=>$vaccine]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $vaccines = vaccine::all();
        // dd($vaccines);
        $this->title = $this->title . " | Create";
        return view('vaccine.create', ["title" => $this->title, "vaccines"=>$vaccines]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo "nu ska vi vaccinera!!!";
        if ($request->input('create_vaccine') != null) {
            # code...
            $vaccine = new vaccine();
            $vaccine->vaccine_name = $request->input('vaccine_name');
            $vaccine->vaccine_type = $request->input('vaccine_type');
            $vaccine->save();
            $vaccine = vaccine::all();
            return view('vaccine.index', ["title" => $this->title, "vaccines" => $vaccine]);
        } else {

            $vaccines = vaccine::all();
            //
            // dd($request->input());
            // $patient = new patient();
            // $test = patient::all('id');
            // dd($test);
            $patient_id = patient::select('id')->where('personnumber', $request->input('personnumber'))->first();
            // dd($patient_id->id);
            if ($patient_id == null) { //check if patients doesnt exists
                if($request->input('gender') != null 
                    && $request->input('name') !== null
                    && $request->input('birthdate') !== null) {
                        // echo "create new patient then give vaccine";
                        //works :D
                        $patient_id = $this->createPatient($request);
                    // dd($patient_id);
                        if ($request->input('vaccine_id') != null) {
                            $this->giveVaccine($request, $patient_id);
                        } else {
                            return view('vaccine.create', ["title" => $this->title, "vaccines" => $vaccines, "error"=>"No Vaccine Selected"]);
                        }
                    } else {
                    // echo "redirect and say error patient info not filled in";
                    //works :D
                    $vaccines = vaccine::all();
                    return view('vaccine.create', ["title" => $this->title, "error"=>"Patient doesn't exist, check person number or create patient","vaccines" => $vaccines]);
                }
            } else { //patient exist give vaccine
                // echo "give vaccine";
                //works :D
                // dd($patient_id->id);
                // $patient_id = patient::Select('id')->Where('personnumber', $request->input('personnumber')->get());
                $patient_id = patient::select('id')->where('personnumber', $request->input('personnumber'))->first();
                // dd($patient_id->id);
                if ($request->input('vaccine_id') != null) {
                    $this->createJournal($request, $patient_id);
                    $this->giveVaccine($request, $patient_id);
                } else {
                    return view('vaccine.create', ["title" => $this->title, "vaccines" => $vaccines, "error"=>"No Vaccine Selected"]);
                }
                
            }
            $this->title = $this->title . " | Create";
            return view('vaccine.create', ["title" => $this->title, "vaccines" => $vaccines, "error"=>"Patient Vaccinated"]);
        }
    }

    private function createJournal($patient, $patient_id) {
        $oldjournal = patient::select('journal')->where('id', $patient_id->id)->first();
        if ($patient->input('journal') != null)  {
            if ($oldjournal == null) {
                $newpatient = patient::where('id', $patient_id->id)->
                update([
                    'journal' => $patient->input('journal')
                ]);
            } else {
                $newpatient = patient::where('id', $patient_id->id)->
                update([
                    'journal' => $oldjournal->journal . " " . $patient->input('journal')
                ]);
            }
        }
    }

    private function createPatient($patient) {

        $number = $patient->input('phonenumber') !== null ? $patient->input('phonenumber') : null; 
        // echo "sak";
        $created = patient::make([
            'personnumber'=>$patient->personnumber,
            'fullname'=>$patient->name,
            'phonenumber'=> $number,
            'birthdate'=>$patient->birthdate,
            'gender'=>$patient->gender,
            'journal' => $patient->journal,
        ])->save();
        // $stuff = patient::select('id')->where('personnumber', $patient->personnumber);
        // dd($stuff);
        $patient_id = patient::select('id')->where('personnumber', $patient->personnumber)->first();
        return $patient_id; //id av patient
    }
    private function giveVaccine($data, $patient_id) {
        // dd(Carbon::today());
        // dd($data->input());
        // dd($patient_id);
        $today = Carbon::today();
        // dd($data->input('vaccine_id'));
        // dd($today);
        // dd();
        // echo $patient_id->id,
        $patient_vaccine = person_vaccine::make([
            'patient_id'=>$patient_id->id,
            'staff'=>$data->input('staff'),
            'vaccine_id'=>$data->input('vaccine_id'),
            'date_taken'=>Carbon::now(),
            'expiration_date'=>$today->addDays(30)
        ])->save();
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
