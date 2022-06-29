

<!DOCTYPE html>
<html>

<head>
    <title>Employees data </title>
</head>
<style>
    main {
        width: 100%;
        text-align: center;
    }

    table {
        margin: auto;

    }

    thead {
        background-color: rgba(128, 128, 128, 0.288);
        padding: 3px 5px;
    }

    table,
    th,
    td {
        border: 1px solid rgba(0, 0, 0, 0.329);
        border-collapse: collapse;
    }

    td,
    th {
        padding: 5px;
    }

    p {
        padding: 5px 0
    }
</style>

<body>
    <main>
        <section>
            <h1>{{ ucfirst($users[0]->company->company_name) }}</h1>
            <h3>Employee data</h3>
            Date: {{ date("Y-m-d ")}}
            <section>

                <table class="header" style="width:100%;">
                    <thead style="width:100%;">
                        <th>#</th>
                        <th>Full name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Id no</th>
                        <th>Staff no</th>
                        <th>Department</th>
                    </thead>
                    <tbody>
                        @php
                            $count=0;
                        @endphp
                        @foreach ($users as $user)
                        {{$count ++}}
                           <tr>
                               <td>{{$count}}</td>
                               <td>{{ucwords($user->first_name .' '. $user->middle_name .' '. $user->last_name)   }}</td>
                               <td>{{$user->email}}</td>
                               <td>{{$user->phone}}</td>
                               <td>
                                   @foreach ($user->meta as $meta)
                                        @if ($meta->key == 'national_id_no')
                                            {{$meta->value}}                                
                                            
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($user->meta as $meta)
                                        @if ($meta->key == 'staff_id')
                                            {{$meta->value}}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $user->department ? $user->department->name : ''}}</td>
                            </tr> 
                        @endforeach
                    </tbody>
                </table>
                Printed time: {{ date(" h:i:sa")}}
               
    </main>

</body>

</html>