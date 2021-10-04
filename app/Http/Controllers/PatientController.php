<?php

namespace App\Http\Controllers;

use App\Models\patient;
use App\Models\person_vaccine;
use App\Models\vaccine;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private $title = "Patient";

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

        if ($request->input('search') != null)  {
            $patients = $this->search($request);
        } else {
            $patients = patient::all();
        }
        return view('patient.index', ["title"=>$this->title, "patients"=>$patients, "vaccinations"=> $vaccinations, "vaccines"=>$vaccines]);
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
