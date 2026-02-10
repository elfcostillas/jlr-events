<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attendance\CreateAttendanceRequest;
use App\Http\Requests\Attendance\DestroyAttendanceRequest;
use App\Http\Requests\Attendance\UpdateAttendanceRequest;
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

    public function create(CreateAttendanceRequest $request)
    {
        $validated =  $request->validated();

        $result = $this->service->create($validated);

         if(is_array($result)){
            return response()->json([
                'message' => 'Request failed',
                'errors' => $result
            ]);
        }

        return response()->json([
            'message' => 'Participation recorded successfully',
            'data' => $validated,
        ],200);
    }

    public function update(UpdateAttendanceRequest $request)
    {
        $validated =  $request->validated();

        $result = $this->service->update($validated);

         if(is_array($result)){
            return response()->json([
                'message' => 'Request failed',
                'errors' => $result
            ]);
        }

        return response()->json([
            'message' => 'Attendance updated successfully',
            'data' => $validated,
        ],200);
    }

    public function destroy(DestroyAttendanceRequest $request)
    {
        $validated =  $request->validated();

        $result = $this->service->destroy($validated);

         if(is_array($result)){
            return response()->json([
                'message' => 'Request failed',
                'errors' => $result
            ]);
        }

        return response()->json([
            'message' => 'Participation withdrawn successfully',
            'data' => $validated,
        ],200);
    }
}
