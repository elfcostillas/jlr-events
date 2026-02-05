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
}
