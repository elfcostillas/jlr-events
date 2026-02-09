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
        return Inertia::render('Attendance/MainPage',[]);
    }

    public function list(Request $request)
    {
        $result  = $this->service->list($request->id);

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
