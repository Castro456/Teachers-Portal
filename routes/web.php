<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PortalController::class, 'portal_home']);
Route::get('/portal', [PortalController::class, 'portal_home'])->name('portal');

Route::group(['middleware' => 'guest'], function () {
  Route::get('/login', [AuthController::class, 'login'])->name('login');
  Route::post('/login/auth', [AuthController::class, 'authenticate']);
  
  Route::get('/register', [AuthController::class, 'register'])->name('register');
  Route::post('/register', [AuthController::class, 'store']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
