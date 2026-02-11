<?php

namespace App\Builder;

use App\Repositories\AttendanceRepository;
use App\Repositories\EmployeeRepository;

class EventAttendanceBuilder
{

    protected $locations;
    protected $event_id;
    
    public function __construct(protected EmployeeRepository $emp_repo,protected AttendanceRepository $att_repo)
    {
        
    }

    public function setEvent($event_id)
    {
        $this->event_id = $event_id;
        return $this;
    }

    public function getLocations()
    {
        $this->locations = $this->emp_repo->getActiveLocation();
        return $this;
    }

    public function getDivisions()
    {
        foreach($this->locations as $location)
        {
            $divisions = $this->emp_repo->getDivisions($location);

            foreach($divisions as $division)
            {
                $departments = $this->emp_repo->getDepartments($location,$division);

                foreach($departments as $department)
                {
                    $employee = $this->att_repo->attendance($this->event_id,$location,$division,$department);

                    $department->employees = $employee;
                }

                $division->departments = $departments;
            }

            $location->divisions = $divisions;
        }

        return $this;
    }

    public function get()
    {
        return $this->locations;
    }
}


/*
  +"event_id": 3
  +"biometric_id": 4
  +"employee_name": "Abanto, Rolando P"
  +"div_code": "RMC"
  +"dept_name": "Operations"
  +"job_title_name": "Transit Mixer Driver"
  +"att_status": null
  +"att_status_code": null
}*/
