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
                ->where('emp_level','<=',5)
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
                ->where('emp_level','<=',5)
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
                ->where('emp_level','<=',5)
                ->where('employees.location_id','=',$location->location_id)
                ->where('employees.division_id','=',$division->division_id)
                ->select('departments.id','departments.dept_code')
                ->distinct()
                ->get();
    }

    public function getTotal($event_id){
        /*
        SELECT COUNT(line_id) FROM events_att WHERE event_id = 1 AND att_status = 3;


        SELECT COUNT(*) FROM employees WHERE exit_status = 1 AND emp_level <= 5;
        */

        $attendee = DB::table('events_att')
                    ->join('employees','employees.biometric_id','=','events_att.biometric_id')
                    ->select(DB::raw("count(events_att.biometric_id) as attendee_count"))
                    ->where('job_title_id','!=',130)
                    ->where('att_status','=',3)
                    ->where('emp_level','<=',5)
                    ->where('event_id','=',$event_id)
                    // ->groupBy('events_att.biometric_id')
                    ->first();

        $employees = DB::table('employees')->where('exit_status','=',1)
                    ->select(DB::raw("count(id) as employee_count"))
                    ->where('job_title_id','!=',130)
                    ->where('emp_level','<=',5)
                    ->first();

        $attendee2 = DB::table('events_att')
                    ->join('employees','employees.biometric_id','=','events_att.biometric_id')
                    ->select('employees.biometric_id')
                    ->where('job_title_id','!=',130)
                    ->distinct()
                    ->where('att_status','=',3)
                    ->where('emp_level','<=',5)
                    ->where('event_id','=',$event_id);

        $absent = DB::table('employees')
                    // ->leftJoin('events_att','events_att.biometric_id','=','employees.biometric_id')
                    ->leftJoin('divisions','employees.division_id','=','divisions.id')
                    ->leftJoin('departments','employees.dept_id','=','departments.id')
                    ->leftJoin('job_titles','employees.job_title_id','=','job_titles.id')
                    ->select(DB::raw("employees.biometric_id,CONCAT(TRIM(lastname),', ',TRIM(firstname),' ',SUBSTR(TRIM(IFNULL(middlename,'')),1,1)) as employee_name,divisions.div_code,departments.dept_name,job_title_name"))
                    ->where('exit_status','=',1)
                    ->where('emp_level','<=',5)
                    ->where('job_title_id','!=',130)
                    ->whereNotIn('employees.biometric_id',$attendee2)
                    ->orderBy('lastname','ASC')
                    ->orderBy('firstname','ASC')
                    // ->where('events_att.event_id','=',$event_id)
                    ->get();
        
        return [
            'attendees' => $attendee->attendee_count,
            'employees' => $employees->employee_count,
            'absent' => $absent,
        ];
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