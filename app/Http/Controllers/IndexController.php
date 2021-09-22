<?php

namespace App\Http\Controllers;
use Session;
class IndexController extends Controller
{
    public $vaccinations;
    // public function __construct()
    // {
    //     $url = "https://raw.githubusercontent.com/owid/covid-19-data/master/public/data/vaccinations/vaccinations.json";
    //     $json = file_get_contents($url);
    //     // echo $json;
    //     $obj = json_decode($json);
    //     $this->vaccinations = end($obj[200]->data);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Session::get("vaccinations") == null) 
        {
            // echo "wow den är inte tom vad fan";
            // dd(Session::get("vaccinations"));
            $url = "https://raw.githubusercontent.com/owid/covid-19-data/master/public/data/vaccinations/vaccinations.json";
            $json = file_get_contents($url);
            // echo $json;
            $obj = json_decode($json);
            $this->vaccinations = end($obj[200]->data);
            Session::put("vaccinations", end($obj[200]->data));
        } else {
            $this->vaccinations = Session::get("vaccinations");
        }
        
        return view('frontpage', ["title" => "Frontpage", "vaccinations"=>$this->vaccinations]);
    }
}
