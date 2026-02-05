<?php

namespace App\Http\Controllers;

use App\Http\Requests\Events\CreateEventRequest;
use App\Services\EventsService;
use Illuminate\Http\Request;

class EventsContoller extends Controller
{
    public function __construct(protected EventsService $service)
    {
        
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

        return response()->json([
            'message' => 'Event created successfully',
            'data' => $validated,
        ]);
    }

    public function view(Request $request)
    {

    }

    public function update(Request $request)
    {

    }

    public function destroy(Request $request)
    {

    }
}
