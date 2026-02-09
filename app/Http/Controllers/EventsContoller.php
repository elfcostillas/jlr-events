<?php

namespace App\Http\Controllers;

use App\Http\Requests\Events\CreateEventRequest;
use App\Http\Requests\Events\DeleteEventRequest;
use App\Http\Requests\Events\UpdateEventRequest;
use App\Services\EventsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventsContoller extends Controller
{
    public function __construct(protected EventsService $service)
    {
        
    }

    public function index()
    {
        return Inertia::render('Events/MainPage',[]);
    }

    public function list()
    {
        $result  = $this->service->list();

        return response()->json([
            'data' => $result,
            'count' => $result->count()
        ]);
    }

    public function create(CreateEventRequest $request)
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
            'message' => 'Event created successfully',
            'data' => $validated,
        ]);
    }

    public function view(Request $request)
    {

    }

    public function update(UpdateEventRequest $request)
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
            'message' => 'Event created successfully',
            'data' => $validated,
        ]);
    }

    public function destroy(DeleteEventRequest $request)
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
            'message' => 'Event deleted successfully',
            'data' => $validated,
        ]);
    }
}
