<!DOCTYPE html>
<html>

<head>
    <title>Payment reciept</title>
</head>
<style>
    main {
        width: 100%;
        text-align: center;
    }

    .table {

        width: 100%;
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
        padding:5px;
    }

    td,
    th {
        padding: 5px;
    }

    p {
        padding: 5px 0
    }

    .header table,
    .header tr,
    .header td {
        border: 1px solid rgba(241, 241, 241, 0.205);
        border-collapse: collapse;
    }
    .row{
        width:100%;
        padding:10px;
        height:auto;
        display: table;
        text-align:left;
    }
    .left-div{
        width:49.5%;
        height:auto;
        text-align:left;
    }
    .right-div{
        width:49.5%;
        text-align:left;
        height:auto;
        display: table-cell;
    }
</style>

<body>
    <main>
        <section>
           <div class="row">
               <span class="left-div" > 
                 <h1 style="text-align:center; margin-right:6rem;">Payment reciept</h1>  
               </span>
               <span class="right-div" style="text-align:center;">
                    <img src="{{ public_path('images/logo.png') }}" style="height:120px;">
               </span>
           </div>
            
            <section>

                <div class="row">
                    <span class="left-div" >
                       <b>Client Name: </b>  {{ucwords($user->company->company_name)}} <br>
                        <b> Phone: </b> @foreach ($user->company->meta as $meta)                      
                                    @if ($meta->key == 'company_phone')
                                        {{ $meta->value}}
                                    @endif                    
                                @endforeach <br>
                       <b>  Address: </b>   @foreach ($user->company->meta as $meta)
                                        @if ($meta->key == 'company_address')
                                        {{ $meta->value}}
                                        @endif
                                    @endforeach <br>      
                        <b> Payment Method: </b> {{ucfirst($payment->payment_method)}}  <br>
                        <b> Reciept no: </b> {{$payment->transaction_reciept_number}} <br>
                        <b> Payment date: </b> {{$payment->transaction_date}} <br>
                    </span>
                    <span class="right-div">
                       <b> {{env('APP_NAME')}} HRMS</b>   <br>
                       <b>  Tel: </b>  <br>
                       <b> Email: </b> info@bamboo.com <br>
                       <b> Address: </b> Tom mboya street, Nairobi, Kenya
                       
                    </span>
                </div>
                <br>

                <table " style="width:100%;">
                
                    <thead style="width:100%;">
                        <th>#</th>
                        <th>Particulars</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>                       
                      @php
                           $count =0;
                       @endphp
                        <tr>
                            <td>
                                {{$count + 1}}
                            </td>
                            <td>
                                {{ucfirst($payment->transaction_type)}}
                            </td>
                            
                            <td>
                                1
                            </td>
                            <td>
                               KSH {{$payment->transaction_amount}}
                            </td>                            
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:right;"> <strong>Total  </strong> </td>
                            
                            <td> <strong> KSH {{$payment->transaction_amount}} </strong> </td>
                         </tr>
                    </tbody>
                </table>
                <small>Paid by: {{ucfirst($user->first_name)}} {{ucfirst($user->last_name)}} - {{$payment->phone_number}}</small> <br>
                <small>Printed: Date: {{ date("Y-m-d ")}}</small>
            </section>

            
    </main>

</body>

</html>