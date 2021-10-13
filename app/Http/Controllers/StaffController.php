<?php

namespace App\Http\Controllers;

use App\Models\patient;
use App\Models\person_vaccine;
use App\Models\schedule;
use App\Models\User;
use App\Models\vaccine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    private $title = "Staff";

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
        // $this->title = "staff";
        //check if logged in
        $history = $this->getHistory(Auth::User()->id);
        $schedule = $this->getSchedule();
        $vaccines = vaccine::select('id', 'vaccine_type', 'vaccine_name')->where([
            ['count', ">", '0']
        ])->get();

        return view('staff.index', ["title"=>$this->title, "history"=>$history, "schedule"=>$schedule, "vaccines" => $vaccines]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $this->title = $this->title . " | Create";
        return view('staff.create', ["title"=>$this->title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->input('is_admin') == null) {
            $is_admin = 0;
        } else {
            $is_admin = 1;
        }

        // $test = $request->validate([
        //     'fullname'=>'required',
        //     'email'=> 'required|email|unique:users',
        //     'password'=> 'required',
        // ]);
        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return view('staff.create', ["error"=>"Email is taken"]);
        }


        $email = $request->input('email');
        $user = User::make([
            'fullname' => $request->input('fullname'),
            'email' => strtolower($email),
            'password' => Hash::make($request->password),
            'is_admin' => $is_admin,
        ]);
        $user->save();
        return redirect("/staff");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$id
        $user_id = auth()->user()->id;
        $user_admin = auth()->user()->is_admin;
        
        if ($id == $user_id || $user_admin != 0) {
            // echo "your id / you're admin";
            $this->title = "| Update";
            $staffs = User::find($id);
            if ($staffs == null) {
                return view("staff.error");
            }
            $history = $this->getHistory($id);
            return view('staff.update', ["title"=>$this->title, "staff"=> $staffs, "history"=>$history]);
        } else {
            // echo "not your id / you're not admin";
           return redirect("staff/" . $user_id);
        }
        // dd($user);
        // dd($id);
    }

    private function getSchedule() {
        $schedule = schedule::select('id', 'patient', 'disease', 'booked', 'fullfilled')->where([
            ['fullfilled', '=', 0],
            ['booked', ">=", Carbon::today()]
            ])->orderby('booked', 'ASC')->limit(5)->get();
        // dd($schedule);
        foreach ($schedule as $scheduled) {
            $patient = patient::select('personnumber')->where('id', $scheduled->patient)->first();
            $scheduled->personnumber = $patient->personnumber;
        }
        return $schedule;
    }
    private function getHistory($id) {
        $patient_data = [];
        $vaccine_data = [];
        $person_vaccine = person_vaccine::select('patient_id', 'vaccine_id', 'created_at')->where('staff', $id)->orderBy('created_at', 'desc')->limit(10)->get();
        // $person_vaccine = person_vaccine::se();
        // dd($person_vaccine);
        // echo $person_vaccine;
        for ($i=0; $i < count($person_vaccine); $i++) { 
            # code...
            // foreach ($person_vaccine[$i] as $value) {
                # code...
                // array_push($patient_data, $this->getPatient($value->patient_id));
                // echo $value;
                // echo $person_vaccine[$i]->patient_id . " ";
                $patient_ids = $this->getPatient($person_vaccine[$i]->patient_id);
                // echo $patient_ids . " ";
                $vaccine_name = $this->getVaccine($person_vaccine[$i]->vaccine_id);
                array_push($patient_data, $patient_ids->personnumber);
                array_push($vaccine_data, $vaccine_name);
                
                // }
        }
        // dd($patient_data);
        // dd($vaccine_data);
        $fixed = $this->fixData($person_vaccine, $patient_data, $vaccine_data);
        // dd($patient);
        return $fixed;
    }
    private function fixData($person_vaccine, $patient_data, $vaccine_data) {
        $i = 0;
        $j = 0;
        // echo $patient_data[0];
        foreach ($person_vaccine as $value) {
        // for ($i=0; $i < count($person_vaccine); $i++) { 
                # code...
            // dd($person_vaccine);
            // echo $key . " " . $value;
            // echo $value->patient_id;
            // echo $value->vaccine_id;
            // dd($patient_data);
            // foreach($patient_data as $patient) {
            for ($j=0; $j <= $i; $j++) { 
                // echo $patient_data[$j];
                // echo "<br>";
                $value->patient_id = $patient_data[$j];
                $value->vaccine_id = $vaccine_data[$j];
                // if ($j == $i) {
                //     break;
                // }
            }
            // foreach ($vaccine_data as $vaccine) {
            //     $value->vaccine_id = $vaccine->vaccine_name;
            //     $k++;
            //     if ($k == $i) {
            //         break;
            //     }
            // }
            $i++;
        }
        // echo $person_vaccine;
        // }
        return $person_vaccine;
    }
    private function getPatient($id) {
        // echo " tja ";
        $patient = patient::select('personnumber')->where('id', $id)->first();
        // echo $patient;
        return $patient;
    }
    private function getVaccine($id) {
        $vaccine = vaccine::select('vaccine_name', 'vaccine_type')->where('id', $id)->first();
        // dd($vaccine->vaccine_name);
        $text = $vaccine->vaccine_name .  " / " . $vaccine->vaccine_type;
        return $text;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$id/edit
        // dd($id);
        // $this->title = $this->title . " | Update";
        // $user = User::find($id);
        $user_id = auth()->user()->id;
        $user_admin = auth()->user()->is_admin;
        if ($id == $user_id || $user_admin != 0) {
            // echo "your id / you're admin";
            $this->title = "| Edit";
            $staffs = User::find($id);
            if ($staffs == null) {
                return view("staff.error");
            }
            return view('staff.edit', ["title" => $this->title, "staff" => $staffs]);
        } else {
            // echo "not your id / you're not admin";
            return redirect("staff/" . $user_id . "/edit");
        }
        // return view('staff.staff')->with('user', $user);
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
        // dd($request->input());
        // echo "goikrealhgoiwa";
        if ($request->input('is_admin') == null) {
            $is_admin = 0;
        } else {
            $is_admin = 1;
        }
        $staff = User::where('id', $id)->
            update([
                'fullname' => $request->input("fullname"),
                'password' => Hash::make($request->password),
                'email' => $request->input("email"),
                'is_admin' => $is_admin,
                
        ]);
        return redirect("/staff");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $staff)
    {
        //
        // dd($id);
        // $staff = User::find($id);
        if($staff->deleted_at == null) {
            $staff->update([
                'deleted_at'=> Carbon::now()
            ]);
        } else {
            $staff->update([
                'deleted_at'=>null
            ]);
        }
        return redirect("/staff/admin");
        // dd($staff);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showall()
    {
        $this->title = $this->title . " | List";
        $staffs = User::select("id", "fullname", "email", "is_admin", "deleted_at")->where('deleted_at',)->get();
        return view('staff.staff', ["title"=> $this->title, "staffs"=>$staffs]);
    }
    public function showalladmin()
    {
        $this->title = $this->title . " | Admin";
        $staffs = User::select("id", "fullname", "email", "is_admin", "deleted_at")->get();
        return view('staff.staff', ["title" => $this->title, "staffs" => $staffs]);
    }
}
