<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class EmployeeRepository
{
    public function getAll()
    {
        return DB::table('employees')
                ->get();
    }

    public function getActiveLocation()
    {
        return DB::table('employees')
                ->where('exit_status',1)
                ->leftJoin('locations','employees.location_id','=','locations.id')
                ->where('job_title_id','!=',130)
                ->select('location_id','location_name')
                ->distinct()
                ->orderBy('locations.id','ASC')
                ->get();
    }

    public function getDivisions($location)
    {
        return DB::table('employees')
                ->where('exit_status',1)
                ->leftJoin('divisions','employees.division_id','=','divisions.id')
                ->where('job_title_id','!=',130)
                ->where('employees.location_id','=',$location->location_id)
                ->select('division_id','divisions.div_code')
                ->distinct()
                ->get();
    }

    public function getDepartments($location,$division)
    {
        return DB::table('employees')
                ->where('exit_status',1)
                ->leftJoin('departments','employees.dept_id','=','departments.id')
                ->where('job_title_id','!=',130)
                ->where('employees.location_id','=',$location->location_id)
                ->where('employees.division_id','=',$division->division_id)
                ->select('departments.id','departments.dept_code')
                ->distinct()
                ->get();
    }
}


/*
select employees.biometric_id,CONCAT(TRIM(lastname),', ',TRIM(firstname),' ',SUBSTR(TRIM(IFNULL(middlename,'')),1,1)) as employee_name,divisions.div_code,departments.dept_name,job_title_name 
from employees 
left join divisions on employees.division_id = divisions.id
left join departments on employees.dept_id = departments.id
left join job_titles on employees.job_title_id = job_titles.id
where employees.exit_status = 1
AND employees.job_title_id != 130
order by div_code,dept_name,lastname,firstname;
*/