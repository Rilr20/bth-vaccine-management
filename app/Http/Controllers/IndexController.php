<?php

// namespace App\Http\Controllers;
// use Session;
// class IndexController extends Controller
// {
//     public $vaccinations;
//     public function __construct()
//     {
//         if (Session::get("vaccinations") == null) {
//             // echo "wow den är inte tom vad fan";
//             // dd(Session::get("vaccinations"));
//             $url = "https://raw.githubusercontent.com/owid/covid-19-data/master/public/data/vaccinations/vaccinations.json";
//             $json = file_get_contents($url);
//             // echo $json;
//             $obj = json_decode($json);
//             $this->vaccinations = end($obj[200]->data);
//             Session::put("vaccinations", end($obj[200]->data));
//         } else {
//             $this->vaccinations = Session::get("vaccinations");
//         }
//     }

//     /**
//      * Display a listing of the resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function index()
//     {
//         return view('frontpage', ["title" => "Frontpage", "vaccinations"=>$this->vaccinations]);
//     }
// }

namespace App\Http\Controllers;

use Carbon\Carbon;
use Session;
class IndexController extends Controller
{
    public $vaccinations;
    // public function __construct()
    // {
    //     // if (Session::get("vaccinations") == null) {
    //         // echo "wow den är inte tom vad fan";
    //         // dd(Session::get("vaccinations"));
        
    //         // Session::put("vaccinations", end($obj[200]->data));
    //     // } else {
    //     //     $this->vaccinations = Session::get("vaccinations");
    //     // }
    // }
    public function checkfile() {
        // $file = fopen('./json/this.json', "r");
        $filename = './json/this.json';

        if (file_exists($filename)) {
            $date = date("d", filemtime($filename));
            if ($date != Carbon::now()->format("d")) {
                $this->createFile();
                $this->readfile();
            } else {
                $this->readFile();
            }
        } else {
            $this->createFile();
            $this->readfile();
        }
        // $this->readfile();
    }
    public function readFile() {
        // $text = readfile("./json/this.json");
        // echo json_decode($text);
        $file = './json/this.json';
        $data = file_get_contents($file);
        $obj = json_decode($data);
        // $file = fopen('./json/this.json', "r");
        // $content = fread($file, 8192);
        // // dd($file);
        // echo $content;
        // // $file = file_get_contents('./json/this.json');
        // // dd($file);
        $this->vaccinations = $obj;
    }
    public function createFile()
    {
        $url = "https://raw.githubusercontent.com/owid/covid-19-data/master/public/data/vaccinations/vaccinations.json";
        $json = file_get_contents($url);
        // echo $json;
        $obj = json_decode($json);
        $this->vaccinations = end($obj[200]->data);
        $file = fopen('./json/this.json', "w");
        // dd(json_encode(end($obj[200]->data)));
        fwrite($file, json_encode(end($obj[200]->data)));
        fclose($file);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkfile();
        return view('frontpage', ["title" => "Frontpage", "vaccinations"=>$this->vaccinations]);
    }
}
