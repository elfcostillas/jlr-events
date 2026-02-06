<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EventsContoller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

    Route::get('list','list');
    Route::get('view/{id}','view');

    Route::post('create','create');
    Route::post('update','update');
    Route::post('destroy','destroy');

    Route::get('employees',function(){
         return DB::table('employees')
                ->leftJoin('divisions','employees.division_id','=','divisions.id')
                ->leftJoin('departments','employees.dept_id','=','departments.id')
                ->leftJoin('job_titles','employees.job_title_id','=','job_titles.id')
                ->where('employees.exit_status','=',1)
                ->where('employees.job_title_id','!=',130)
                ->select(DB::raw("employees.biometric_id,CONCAT(TRIM(lastname),', ',TRIM(firstname),' ',SUBSTR(TRIM(IFNULL(middlename,'')),1,1)) as employee_name,divisions.div_code,departments.dept_name,job_title_name"))
                ->orderBy('div_code','ASC')
                ->orderBy('dept_name','ASC')
                ->orderBy('lastname','ASC')
                ->orderBy('firstname','ASC')
                ->get();
    });
}); 

Route::prefix('attendance')->controller(AttendanceController::class)->group(function(){
    Route::get('list/{id}','list');

    Route::post('create','create');
    Route::post('update','update');
    Route::post('destroy','destroy');
});