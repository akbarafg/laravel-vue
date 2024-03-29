<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('admin/dashboard', function() {
//     return view('dashboard');
// });





Route::get('/api/users', [UserController::class, 'index']);

Route::post('/api/users', [UserController::class,'store']);

Route::put('/api/users/{user}', [UserController::class, 'update']);


Route::get('{view}', ApplicationController::class)->where('view','(.*)');