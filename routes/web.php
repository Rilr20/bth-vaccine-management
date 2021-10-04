<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\VaccineController;
use App\Models\patient;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     $url = "https://covid.ourworldindata.org/data/owid-covid-data.json";
//     $json = file_get_contents($url);
//     // echo $json;
//     $obj = json_decode($json);
//     dd($obj->SWE);
//     return view('frontpage', ["title"=>"Frontpage"]);
// });

Route::get("/", "App\Http\Controllers\IndexController@index");

// Route::get('/login', function () {
//     return view('login.login', ["title" => "Login"]);
// });
// Route::get('/staff', function () {
//     return view('staff.index', ["title"=>"staff page"]);
// });

Route::get("/patient", 'App\Http\Controllers\PatientController@search');
Route::resource('/patient', PatientController::class);
Route::resource("/vaccine", VaccineController::class);
Route::get("/staff/list", 'App\Http\Controllers\StaffController@showall');
Route::get("/staff/admin", 'App\Http\Controllers\StaffController@showalladmin');
Route::resource("/staff", StaffController::class);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login/checklogin', [LoginController::class, 'checklogin']);
Route::get('login/logout', [LoginController::class, 'logout']);
