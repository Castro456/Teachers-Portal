<?php

use App\Http\Controllers\StudentController;
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

Route::group(['prefix' => 'student/'], function () {
    Route::post('create', [StudentController::class, 'save']);
    Route::get('/', [StudentController::class, 'get']); 
    Route::delete('delete', [StudentController::class, 'destroy']);
    Route::get('{id}/edit', [StudentController::class, 'edit']);
    Route::put('update/{id}', [StudentController::class, 'update']);
});

