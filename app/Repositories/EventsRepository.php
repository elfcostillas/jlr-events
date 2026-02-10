<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class EventsRepository
{
    public function getALL()
    {
        return DB::table('events')
            ->orderBy('event_date','ASC')
            ->get();
    }

    public function getOngoingEvent()
    {
        return DB::table('events')->where('event_status','Ongoing')->first();
    }
}
