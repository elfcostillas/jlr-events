<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        @page { margin: 60px 75px 30px 75px; border:1px solid green }

        body { 
            font-family: Helvetica, sans-serif; 
            font-size : 12px;
        }

        .pad {
            font-size: 9pt;
            padding: 3px;
        }

        .pad-8 {
            font-size: 9pt;
            padding: 3px 3px 3px 8px;
        }

        .w120 {
            width: 120px
        }

        .w140 {
            width: 200px
        }

        .w80 {
            width: 80px
        }

        .w40 {
            width: 40px
        }

    </style>
</head>
<body>
    @foreach($data as $location)
        <table border=1 style="width:100%;border=1;border-collapse:collapse;">
            <tr>
                <td class="pad" colspan=5> {{ $location->location_name }} </td>
            </tr>
            @foreach($location->divisions as $division)
            <tr>
                <td class="pad" colspan=5> {{ $division->div_code }} </td>
            </tr>
                @foreach($division->departments as $department)
                    <tr>
                        <td class="pad"  colspan=5> {{ $department->dept_code }} </td>
                    </tr>
                    @foreach($department->employees as $employee)
                        <tr>
                            <td class="pad w40"> {{ $loop->iteration }} </td>
                            <td class="pad" > {{ $employee->employee_name }} </td>
                            <td class="pad w120" > {{ $department->dept_code }} </td>
                            <td class="pad w140" > {{ $employee->job_title_name }} </td>
                            <td class="pad-8 w80" > {{ $employee->att_status_code }} </td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
        </table>
    @endforeach
</body>
</html>