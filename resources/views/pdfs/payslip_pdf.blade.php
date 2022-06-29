<!DOCTYPE html>
<html>

<head>
    <title>Payslip</title>
</head>
<style>
    main {
        width: 100%;
        text-align: center;
    }

    table {
        width:100%;
        padding: 0;
        margin: 0;
    }

    thead {
        background-color: rgba(128, 128, 128, 0.288);
        padding: 3px 5px;
    }

    table, th, td {
        border: 1px solid rgba(0, 0, 0, 0.329);
        border-collapse: collapse;
        font-size: 6pt;
        font-weight: 400;
    }

    td,
    th {
        padding: 5px;
    }

    p {
        padding: 5px 0
    }
    .header table, .header tr, .header td{
        border: 1px solid rgba(241, 241, 241, 0.205);
        border-collapse: collapse;
    }
    h6{
        padding: 0;
        margin: 0;
        text-align: center;
        font-size: 6pt;
        font-weight: 400;
    }
     .inner-table {
         min-height:100px;
        
    }
     .inner-table tr td{
         border-collapse:collapse;
         border: none;
         border-right: 1px solid rgba(0, 0, 0, 0.233);
    }
     .inner-table table, .inner-table2 tr td {
         border-collapse:collapse;
         border: none;    
             
    }
    .messages{        
        border: 1px solid #000;
    }

    
</style>

<body>
    <main>
        @php
            $total_payments=0;
            $total_deductions=0;
        @endphp

        <div class="table-responsive">
            <h3>Payslip</h3>
            <table class="table" style="width:100%;">
                <thead>
                    <td> 
                        <h6>ASSIGNMENT NUMBER</h6>
                    </td>
                    <td colspan="2"> 
                        <h6>EMPOYEE NAME</h6>
                        {{ ucfirst($user->first_name .' '. $user->middle_name .' '. $user->last_name)}}
                    </td>
                    <td colspan="2"> 
                        <h6>LOCATION</h6>
                    </td>
                </thead>
                <thead>
                    <td> 
                        <h6>DEPARTMENT</h6>
                        {{ ucwords($user->department->name)}}
                    </td>
                    <td colspan="2"> 
                        <h6>JOB TITLE</h6>
                    </td>
                    <td colspan="2"> 
                        <h6>PAYSCALE DESCRIPTION</h6>
                    </td>
                </thead>
                <thead>
                    <td rowspan="2" style="text-align:center; margin:0; padding:0">                      
                        <img src="{{ public_path('images/logo.png') }}" style="height:50px; padding:2px">
                    </td>

                    <td >                         
                        <h6>SAL/WAGE</h6>
                        @foreach ($user->benefits as $item)
                            @if ($item->name == 'basic pay')
                                {{$item->amount}}
                            @endif                        
                        @endforeach
                    <td>
                        <h6>INC.DATE</h6>
                        {{ date_format($user->created_at, 'F Y')}}
                    </td>
                  
                    <td > 
                        <h6>STARNDARD HRS.</h6>
                        40
                    </td>
                    <td > 
                        <h6>PT SAL/WAGE</h6>
                    </td>                   
                </thead>

                <thead> 
                    <td >                         
                        <h6>TAX OFFICE NAME</h6>
                    <td>
                       <h6>TAX OFFICE REF</h6>
                    </td>
                  
                    <td > 
                        <h6>TAX CODE</h6>
                        @foreach ($user->meta as $meta)
                            @if ($meta->key == 'kra_pin_no')
                                {{$meta->value}}
                            @endif
                        @endforeach
                    </td>
                    <td > 
                        <h6>NI NUMBER</h6>
                        @foreach ($user->meta as $meta)
                            @if ($meta->key == 'kra_pin_no')
                                {{$meta->value}}
                            @endif
                        @endforeach
                    </td>                   
                </thead>

                <tr>
                    <td colspan="2" style="padding:0; padding-top:5px; margin:0;"> 
                        <h6> PAYMENTS AND ALLOWANCES </h6>
                        <table  class="inner-table" >
                            <thead>
                                <th> <h6> DESCRIPTION </h6></th>
                                <th> <h6> WKD/EARNED</h6></th>
                                <th> <h6> PAID/DUE</h6></th>
                                <th> <h6> RATE</h6></th>
                                <th> <h6> AMOUNT</h6></th>
                            </thead>
                           @foreach ($user->benefits as $item)
                          {{ $total_payments += $item->amount}}
                            <tr>
                                <td> {{ ucwords(str_replace('_', ' ' , $item->name)) }}       </td>
                                <td> {{ $item->amount }} </td>
                                <td> {{ $item->amount }} </td>
                                <td> - </td>
                                <td> {{ $item->amount }} </td>
                            </tr>
                            @endforeach            
                            <tr>
                                {{-- placeholder row --}}
                                <td style="height:200px"> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                            </tr>
                        </table>
                     </td>
                    <td colspan="3" style="padding:0; padding-top:5px; margin:0;">
                         <h6>DEDUCTIONS (R INDICATES REFUND) </h6> 
                         <table  class="inner-table" >
                            <thead>
                                <th>
                                    <h6> DESCRIPTION </h6>
                                </th>
                                <th>
                                    <h6> AMOUNT</h6>
                                </th>
                                <th>
                                    <h6> BALANCE C/F</h6>
                                </th>                                
                            </thead>
                            @foreach ($user->deductions as $item)
                            {{ $total_deductions += $item->amount }}
                                <tr>
                                    <td> {{ ucwords(str_replace('_', ' ' , $item->name)) }} </td>                                    
                                    <td> {{$item->amount}}      </td>
                                    <td> - </td>
                                </tr>
                            @endforeach 
                            <tr >
                                {{-- placeholder row  --}}
                                <td style="height:200px"> </td>
                                <td>  </td>
                                <td>  </td>
                            </tr>                            
                            
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="5" style="padding:0; padding-top:5px; margin:0;">
                        <table  class="inner-table">
                            <thead>
                                <th > <h6>Year To Date Balances (This Employment Only)</h6> </th>
                                <th> <h6>This Period Summary</h6> </th>
                            </thead>
                            <tr>
                                <td>
                                    <table  class="inner-table">
                                        <tr>
                                            <td>
                                                <table class="inner-table2" >
                                                    <tr>
                                                        <td>GROSS PAY</td>
                                                        <td> {{$total_payments}} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>NI LETTER</td>
                                                        <td>A</td>
                                                    </tr>
                                                    <tr>
                                                        <td>PENSIONABLE PAY</td>
                                                        <td>
                                                            @foreach ($user->benefits as $item)
                                                                @if ($item->name == 'basic pay')
                                                                    {{$item->amount}}
                                                                @endif
                                                            @endforeach
                                                            
                                                         </td>
                                                    </tr>
                                                    <tr>
                                                        <td>SD REF NO</td>
                                                        <td> - </td>
                                                    </tr>
                                                </table>
                                            </td>

                                            <td>
                                                <table class="inner-table2" >
                                                    <tr>
                                                        <td>TAXABLE PAY</td>
                                                        <td> {{$total_payments}} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>TAX PAID</td>
                                                        <td>
                                                            @foreach ($user->deductions as $item)
                                                                @if ($item->name == 'paye')
                                                                {{$item->amount}}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>PREVIOUS TAXABLE PAY</td>
                                                        <td>  - </td>
                                                    </tr>
                                                    <tr>
                                                        <td>PREVIOUS TAX PAID</td>
                                                        <td>  - </td>
                                                    </tr>
                                                    <tr>
                                                        <td>PENSION CONTS</td>
                                                        <td>  
                                                            @foreach ($user->deductions as $item)
                                                                @if ($item->name == 'nssf')
                                                                {{$item->amount}}
                                                                @endif
                                                            @endforeach
                                                         </td>
                                                    </tr>
                                                    <tr>
                                                        <td>EMPLOYEE NO.</td>
                                                        <td>  
                                                            @foreach ($user->meta as $meta)
                                                                @if ($meta->key == 'staff_id')
                                                                    {{$meta->value}}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                                <td>
                                    <table class="inner-table">
                                        <tr>
                                            <td>
                                                <table class="inner-table2">
                                                    <tr>
                                                        <td>PENSIONABLE PAY</td>
                                                        <td>
                                                            @foreach ($user->benefits as $item)
                                                                @if ($item->name == 'basic pay')
                                                                    {{$item->amount}}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>TAX PERIOD</td>
                                                        <td> {{ date('Y')}} </td>
                                                    </tr>
                                                    <tr>
                                                        <td> FREQUENCY</td>
                                                        <td>Monthly</td>
                                                    </tr>
                                                    <tr>
                                                        <td>PERIOD END DATE</td>
                                                        <td> {{ date("d F Y ")}} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>PAY DATE</td>
                                                        <td>Monthly</td>
                                                    </tr>
                                                    <tr>
                                                        <td>PAY METHOD</td>
                                                        <td> 
                                                            @foreach ($user->meta as $meta)
                                                                @if ($meta->key == 'preffered_mode')
                                                                 {{ ucfirst($meta->value) .' | ' }}
                                                                @endif
                                                                @if ($meta->key == 'bank_name')
                                                                    {{ ucwords($meta->value)}}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                            <td>
                                                <table class="inner-table2">
                                                    <tr>
                                                        <td>TAXABLE PAY</td>
                                                        <td> {{$total_payments}} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>NON-TAXABLE PAY</td>
                                                        <td> - </td>
                                                    </tr>
                                                    <tr>
                                                        <td>TOTAL PAYMENTS</td>
                                                        <td> {{$total_payments}} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>TOTAL DEDUCTIONS</td>
                                                        <td> {{$total_deductions}} </td>
                                                    </tr>
                                                    <tr style=" border:1px solid rgba(0, 0, 0, 0.521); font-weight:600;">
                                                        <td style="height:20px; padding:5px"> <b> NET PAY </b> </td>
                                                        <td> <b>  {{$total_payments - $total_deductions}} </b> </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>                                
                            </tr>
                        </table> 
                    </td>                   
                </tr>                
            </table>

            <br>

            <div class="messages">
                <h5 style="padding: 10px; margin-top:0; border-bottom: 1px solid #000">MESSAGES FROM EMPLOYER</h5>
                <div style="padding:5px; min-height:50px; font-size:8pt">
                   <small>
                       Messages from the employer will apprear here
                       </small>
                </div>  
            </div>
        </div>










    </main>
            
</body>
    
</html>