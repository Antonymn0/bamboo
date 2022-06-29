<?php

namespace App\Http\Controllers\Api\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use App\Models\Company;
use App\Notifications\Payments\PaymentRecievedNotification;
use App\Notifications\Payments\AccountActivatedNotification;
use Illuminate\Support\Facades\Log;
class MpesaResponsesController extends Controller
{   

    public function handleSTKPush(Request $request, User $user )
    {
        Log::info('Mpesa STK Push request recieved');
        Log::info('Processing STK push...'); 

        if($request['Body']['stkCallback']['ResultCode'] !== 0){
            Log::info('Mpesa STK push result code (' . $request['Body']['stkCallback']['ResultCode'] .  ') Processing canceled');
            return [
                'ResultCode' => 0,
                'ResultDesc' => 'Rejected, Endpoint handles only successful requests (Resultscode-0)',
                'ThirdPartyTransID' => date('YmdHis')
            ];
        }

        //Process successful response

        $results = $request['Body']['stkCallback']['CallbackMetadata']['Item'];

        $data =[
            'mpesa_result_code'=> $request['Body']['stkCallback']['ResultCode'],
            'transaction_amount'=> $results[0]['Value'],
            'transaction_reciept_number'=> $results[1]['Value'],
            'transaction_date'=> $results[3]['Value'], 
        ];

        // get record
        $checkout_request_id = $request['Body']['stkCallback']['CheckoutRequestID'];
        $payment = Payment::where('checkout_request_id', $checkout_request_id );

        $payment->update($data);

        $company = Company::where('id', $payment->company_id)->first();
        $company->update(['registration_status' => 0 ]);

        $user = User::where('id', $payment->user_id)->first();
        
        $user->notify(new PaymentRecievedNotification($payment));        
        $user->notify(new AccountActivatedNotification($user));

        Log::info('Mpesa STK push response processed!');

        return [
            'ResultCode' => 0,
            'ResultDesc' => ' Service accepted',
            'ThirdPartyTransID' => date('YmdHis') //timestamp
        ];        
    }



    public function handleTransactionReversal(Request $request)
    {
        Log::info('transactionReversal  endpoint hit');
        Log::info($request->all());
        return [
            'ResultCode' => 0,
            'ResultDesc' => 'Accept Service',
            'ThirdPartyTransID' => date('YmdHis')
        ];
    }

   
}
