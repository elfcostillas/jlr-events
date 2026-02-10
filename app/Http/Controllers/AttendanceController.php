<?php

namespace App\Http\Controllers;

use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttendanceController extends Controller
{

    public function __construct(protected AttendanceService $service)
    {
        
    }

    public function index()
    {
        $ongoing = $this->service->getOngoingEvent();
        return Inertia::render('Attendance/MainPage',['events'=> $ongoing]);
    }

    public function list(Request $request)
    {
        $ongoing = $this->service->getOngoingEvent();
       
        $result  = $this->service->list($ongoing->id);

        return response()->json([
            'data' => $result,
            'count' => $result->count()
        ]);
    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
