<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class AttendanceRepository
{
    public function list($event_id)
    {
        if(is_null($event_id) || $event_id == 0 || $event_id == ''){
            return null;
        }else{
            $att = DB::table('events_att')
                ->leftJoin('att_status','events_att.att_status','=','att_status.id')
                ->where('event_id','=',$event_id)
                ->select(DB::raw("biometric_id,att_status,event_id,att_status.att_status_code"));

            return DB::table('employees')
                ->leftJoin('divisions','employees.division_id','=','divisions.id')
                ->leftJoin('departments','employees.dept_id','=','departments.id')
                ->leftJoin('job_titles','employees.job_title_id','=','job_titles.id')
                ->leftJoinSub($att,'events_att','events_att.biometric_id','=','employees.biometric_id')
                ->where('employees.exit_status','=',1)
                ->where('employees.job_title_id','!=',130)
                ->select(DB::raw("$event_id as event_id,employees.biometric_id,CONCAT(TRIM(lastname),', ',TRIM(firstname),' ',SUBSTR(TRIM(IFNULL(middlename,'')),1,1)) as employee_name,divisions.div_code,departments.dept_name,job_title_name,events_att.att_status,events_att.att_status_code"))
                ->orderBy('div_code','ASC')
                ->orderBy('dept_name','ASC')
                ->orderBy('lastname','ASC')
                ->orderBy('firstname','ASC')
                ->get();
        }
    }

    public function attendance($event_id,$location,$division,$department)
    {
        if(is_null($event_id) || $event_id == 0 || $event_id == ''){
            return null;
        }else{
            $att = DB::table('events_att')
                ->leftJoin('att_status','events_att.att_status','=','att_status.id')
                ->where('event_id','=',$event_id)
                ->select(DB::raw("biometric_id,att_status,event_id,att_status.att_status_code"));

            return DB::table('employees')
                ->leftJoin('divisions','employees.division_id','=','divisions.id')
                ->leftJoin('departments','employees.dept_id','=','departments.id')
                ->leftJoin('job_titles','employees.job_title_id','=','job_titles.id')
                ->leftJoinSub($att,'events_att','events_att.biometric_id','=','employees.biometric_id')
                ->where('employees.exit_status','=',1)
                ->where('employees.job_title_id','!=',130)

                ->where('employees.division_id','=',$division->division_id)
                ->where('employees.dept_id','=',$department->id)
                ->where('employees.location_id','=',$location->location_id)

                ->select(DB::raw("$event_id as event_id,employees.biometric_id,CONCAT(TRIM(lastname),', ',TRIM(firstname),' ',SUBSTR(TRIM(IFNULL(middlename,'')),1,1)) as employee_name,divisions.div_code,departments.dept_name,job_title_name,events_att.att_status,events_att.att_status_code"))
                ->orderBy('div_code','ASC')
                ->orderBy('dept_name','ASC')
                ->orderBy('lastname','ASC')
                ->orderBy('firstname','ASC')
                ->get();
        }
    }
}