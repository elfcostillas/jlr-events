<?php

namespace App\Services;

use App\Repositories\EventsRepository;

class EventsService
{
    public function __construct(protected EventsRepository $events_repo)
    {

    }

    public function list()
    {
        return $this->events_repo->getALL();
    }
}
