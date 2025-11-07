<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Hello World',
        'version' => '1.0.0',
        'status' => 'success',
    ]);
});
