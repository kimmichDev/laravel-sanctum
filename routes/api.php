<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post("/student/register", [StudentController::class, "register"]);
Route::post("/student/login", [StudentController::class, "login"]);
Route::middleware("auth:sanctum")->group(function () {
    Route::get("student/profile", [StudentController::class, "profile"]);
    Route::get("student/logout", [StudentController::class, "logout"]);

    Route::post("project/create", [ProjectController::class, "store"]);
});
