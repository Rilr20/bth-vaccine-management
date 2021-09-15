<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        return view('staff.index', ["title"=>$this->title]);
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
            return view('staff.update', ["title"=>$this->title, "staff"=> $staffs]);
        } else {
            // echo "not your id / you're not admin";
           return redirect("staff/" . $user_id);
        }
        // dd($user);
        // dd($id);
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
        $staff->update([
            'deleted_at'=> Carbon::now()
        ]);
        return redirect("/staff");
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
        $staffs = User::select("id", "fullname", "email", "is_admin", "deleted_at")->where('deleted_at', null)->get();
        return view('staff.staff', ["title"=> $this->title, "staffs"=>$staffs]);
    }
    public function showalladmin()
    {
        $this->title = $this->title . " | Admin";
        $staffs = User::select("id", "fullname", "email", "is_admin", "deleted_at")->get();
        return view('staff.staff', ["title" => $this->title, "staffs" => $staffs]);
    }
}
