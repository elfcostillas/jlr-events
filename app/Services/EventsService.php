<?php

namespace App\Services;

use App\Builder\EventAttendanceBuilder;
use App\Repositories\EmployeeRepository;
use App\Repositories\EventsRepository;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;

class EventsService extends Service
{
    protected $table = 'events';

    public function __construct(protected EventsRepository $events_repo,protected EmployeeRepository $emp_repo)
    {

    }

    public function list()
    {
        return $this->events_repo->getALL();
    }

    public function updateStatus()
    {
        DB::table('events')
            ->update([
                'event_status' => DB::raw("
                    CASE
                        WHEN event_date = CURDATE() THEN 'Ongoing'
                        WHEN event_date < CURDATE() THEN 'Concluded'
                        WHEN event_date > CURDATE() THEN 'Upcoming'
                    END
                ")
            ]);
    }

    public function buildAttendance($event_id)
    {
        $builder = app(EventAttendanceBuilder::class);   

        $attendance = $builder
                    ->setEvent($event_id)
                    ->getLocations()
                    ->getDivisions()
                    ->get();

        return $attendance;
    }

    public function buildAttendanceSG($event_id)
    {
        $builder = app(EventAttendanceBuilder::class);   

        $attendance = $builder
                    ->setEvent($event_id)
                    ->getLocations()
                    ->getDivisionsSG()
                    ->get();

        return $attendance;
    }

    public function getTotals($events_id)
    {
        return $this->emp_repo->getTotal($events_id);
    }

    public function getTotalsSG($events_id)
    {
        return $this->emp_repo->getTotalSG($events_id);
    }


    public function getEvent($event_id)
    {
        return $this->events_repo->getEvent($event_id);
    }


}
