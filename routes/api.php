<?php

use App\Http\Controllers\EventsContoller;
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


// Route::prefix('events')->middleware('access:memo/awol')->controller(AWOLMemoController::class)->group(function(){
Route::prefix('events')->controller(EventsContoller::class)->group(function(){

    // Route::get('/','index');
    Route::get('list','list');
    Route::get('view/{id}','view');

    Route::post('create','create');
    Route::post('update','update');
    Route::post('destroy','destroy');
}); 