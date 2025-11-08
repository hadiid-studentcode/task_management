<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/hello-world', function (Request $request) {
    return response()->json(['message' => 'Hello World!']);
});


Route::controller(AuthController::class)->middleware('guest:sanctum')->group(function () {

    Route::get('/login', 'login')->name('login');
    Route::post('/register', 'register');
    Route::post('/login', 'authenticate');
});


Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::resource('/projects', ProjectsController::class);
    Route::resource('/tasks', TasksController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});
