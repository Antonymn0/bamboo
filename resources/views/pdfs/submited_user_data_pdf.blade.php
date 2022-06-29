<!DOCTYPE html>
<html>

<head>
    <title>User data</title>
</head>
<style>
    h1,h3, h4{
        font-weight:'200';
        color:#333;
    }
    main{        
        width: 100%;
        text-align:center;
        font-weight:'200';
        color:#333;
    }  
    
   table {
    }
    thead{
        background-color: rgba(128, 128, 128, 0.288); 
        padding: 3px 5px;
    }
   table, th, td{
       border: 1px solid rgba(0, 0, 0, 0.329);
        border-collapse: collapse;
   }
   td, th{
        padding:5px;
        font-weight:'200';

    }
    p{
        padding: 5px 0 
    }
</style>
<body>
    <main>  
        <div>   
            <h1>{{ ucfirst($user->company->company_name) }}</h1>
            <h3>User registration details  subited by {{ucfirst($user->first_name)}} {{ucfirst($user->last_name)}}</h3>
            Date: {{ date("Y-m-d")}}

            <table class="table">
                <caption>
                    <h4>Personal details</h4>
                </caption>
                <thead>
                    <th>Field</th>
                    <th>Value</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Full name</td>
                        <td>{{ ucwords($user->first_name .' '. $user->middle_name .' '. $user->last_name) }}</td>
                        
                    </tr>   
                    <tr>
                        <td>Email</td>
                        <td>{{ $user->email }}</td>
                        
                    </tr>   
                    <tr>
                        <td>Phone</td>
                        <td>{{ $user->phone }}</td>
                        
                    </tr> 
                      @foreach ($user->meta as $meta)
                        @if(  $meta->key == 'id' ) @php continue; @endphp @endif
                        <tr>
                            <td>{{ucfirst(str_replace('_',' ', $meta->key))}}</td>
                            <td>{{$meta->value}}</td>
                            
                        </tr>
                    @endforeach                            
                   
                </tbody>
            </table> 

            
            <table class="table">
                <caption> <h4>Education details</h4> </caption>
                <thead>
                    <th>Institution Name</th>
                    <th >Joined</th>
                    <th >Completed</th>
                    <th >Qualification</th>
                    <th>Credit</th>
                </thead>
                <tbody>                   
                    @foreach ($user->education as $item)
                        <tr>
                            <td>{{ucfirst( $item->institution_name)}}</td>
                            <td> {{ $item->start_date }} </td>
                            <td> {{ $item->end_date }} </td>
                            <td> {{ $item->qualification }} </td>
                            <td>{{$item->grade}}</td>
                        </tr>
                    @endforeach                     

                </tbody>
            </table>

            <!--<table class="table">
                <caption> <h4>Company details</h4> </caption>
                <thead>
                    <th>Field</th>
                    <th colspan="2">Submited</th>
                    <th>Description</th>
                </thead>
                <tbody>
                    <tr>   
                        <td>Company name</td>
                        <td> {{ $user->company->company_name ? 'Yes' : ''}} </td>
                        <td> {{ $user->company->company_name ? '' : 'No'}} </td>
                        <td>{{ ucfirst($user->company->company_name) }}</td>
                    </tr>
                    @foreach ($user->company->meta as $meta)
                        <tr>
                            <td>{{ucfirst(str_replace('_',' ', $meta->key))}}</td>
                            <td> {{ $meta->key ? 'Yes' : ''}} </td>
                            <td> {{ $meta->key ? '' : 'No'}} </td>
                            <td>{{$meta->value}}</td>
                        </tr>
                    @endforeach                  

                </tbody>
            </table>-->
            <p>
                Your submited details as per our system.  <br> 
                Printed Time: {{ date("  h:i:sa")}}  <br>
                {{ENV('APP_NAME')}}
            </p>
            
        </div>
        
    </main>
        
</body>

</html>