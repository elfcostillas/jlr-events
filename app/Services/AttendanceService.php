<?php

namespace App\Services;

use App\Repositories\AttendanceRepository;
use App\Repositories\EmployeeRepository;

class AttendanceService
{
    public function __construct(protected EmployeeRepository $emp_repo,protected AttendanceRepository $att_repo)
    {
        
    }

    public function list($event_id)
    {
        return $this->att_repo->list($event_id);
    }
}
