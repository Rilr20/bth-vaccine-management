<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController; 
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

Route::get('/', function () {
    return view('frontpage', ["title"=>"Frontpage"]);
});

// Route::get('/login', function () {
//     return view('login.login', ["title" => "Login"]);
// });
Route::get('/staff', function () {
    return view('staff.index', ["title"=>"staff page"]);
});


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login/checklogin', [LoginController::class, 'checklogin']);
Route::get('login/logout', [LoginController::class, 'logout']);