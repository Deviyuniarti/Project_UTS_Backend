<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Membuat endpoint students dan menambahkan  autentikasai sanctum
Route::middleware('auth:sanctum')->group(function () {

    //Route untuk menampilkan semua data pegawai
    Route::get("/employees", [PegawaiController::class, "index"]);

    //  //Route untuk menambahkan data pegawai
    Route::post('/employees', [PegawaiController::class, 'store']);

    //Route untuk mengupdate data pegawai
    Route::put("/employees/{id}", [PegawaiController::class, "update"]);

    //Route untuk menghapus data pegawai
    Route::delete("/employees/{id}", [PegawaiController::class, "destroy"]);

    //Route untuk mendapatkan detail pegawai
    Route::get("employees/{id}", [PegawaiController::class, "show"]);

    //Route untuk mencari data pegawai
    Route::get("/employees/search/{id}", [PegawaiController::class, "search"]);

    
});

    //Membuat Route untuk Register dan Login
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

