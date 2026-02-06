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