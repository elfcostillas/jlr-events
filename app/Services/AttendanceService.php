<?php

namespace App\Services;

use App\Repositories\AttendanceRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\EventsRepository;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    public function __construct(protected EmployeeRepository $emp_repo,protected AttendanceRepository $att_repo,protected EventsRepository $event_repo)
    {
      
    }

    public function getOngoingEvent()
    {
        return $this->event_repo->getOngoingEvent();
    }

    public function list($event_id)
    {
        return $this->att_repo->list($event_id);
    }

    public function create($data)
    {
        return DB::table('events_att')->insertOrIgnore($data);
    }

    public function update($data)
    {
        // return DB::table('events_att')->insert($data);
    }

    public function destroy($data)
    {
        return DB::table('events_att')
        ->where('event_id','=',$data['event_id'])
        ->where('biometric_id','=',$data['biometric_id'])
        ->delete();
    }
}
