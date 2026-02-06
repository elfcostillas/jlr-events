<?php

namespace App\Services;

use App\Repositories\EventsRepository;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;

class EventsService extends Service
{
    protected $table = 'events';

    public function __construct(protected EventsRepository $events_repo)
    {

    }

    public function list()
    {
        return $this->events_repo->getALL();
    }


}
