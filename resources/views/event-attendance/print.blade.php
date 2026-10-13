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
    <table style="width:100%;">
        <tr>
            <td>{{ $event->event_name }}</td> <td style="text-align: right;"> {{ Carbon\Carbon::parse($event->event_date)->format('m/d/Y') }} </td>
        </tr>
        <tr>
            <td>{{ $event->event_location }}</td>
        </tr>
    </table>
    <br>
    @foreach($data as $location)
        <table border=1 style="width:100%;border=1;border-collapse:collapse;">
            <tr>
                <td class="pad" colspan=5 style="background-color:yellow"> {{ $location->location_name }} </td>
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

    <br>
    
    <table>
        <tr>
            <td> Employee Count :</td>
            <td>{{ $total['attendees']}} / {{ $total['employees']}}</td>
        </tr>
    </table>
    <table  border=0 style="width:100%">
        <tr>
            <td colspan="5"> Absent(s) :</td>
        </tr>
        @foreach($total['absent'] as $absent)
        <tr>
            <td style="padding: 0 4px;">{{ $loop->iteration }}.</td>
            <td > {{ $absent->employee_name }} </td>
            <td style="padding: 0 8px;" > {{ $absent->div_code }} </td>
            <td > {{ $absent->dept_name }} </td>
            <td > {{ $absent->job_title_name }} </td>     
        </tr>
        @endforeach
    </table>
</body>
</html>