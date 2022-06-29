<?php

namespace App\Http\Controllers\Api\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use App\Models\Company;

use Carbon\Carbon;
use App\Helpers\Utilities;



class MpesaController extends Controller
{
    /**
     * Get authentication token token
    */
    public function getAccessToken(){

        $url = env('MPESA_ENV','production') == 'sandbox'
            ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
            : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $curl = curl_init($url);
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=utf8'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_USERPWD => env('MPESA_CONSUMER_KEY','u0SvYAGJ2jGpGe48C61GWlQFGBiolODG') . ':' . env('MPESA_CONSUMER_SECRET','D6m3ggUqJ1jxuILw')
            )
        );
        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        return $response->access_token;
    }

    

    /**
     * Make http request
     */
    public function makeHttp($url, $body)
    {
        $url = env('MPESA_ENV','production') == 'sandbox'
            ? 'https://sandbox.safaricom.co.ke/mpesa/' . $url
            : 'https://api.safaricom.co.ke/mpesa/'. $url;

        


        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Authorization:Bearer ' . $this->getAccessToken()),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($body)
            )
        );
        $curl_response = curl_exec($curl);
        curl_close($curl);
        return $curl_response;
    }

    /**
     * Send STK push for payment
     */
    public function sendSTKPush(Request $request, User $user)
    {
        if(is_null($user)) return false;

        
        $timestamp = date('YmdHis');
        $password = base64_encode( env('MPESA_BUSINESS_SHORTCODE','4033851') . env('MPESA_PASS_KEY','10c2380250c13177fb5b370df9baf1c292050b01d0e2a38a97b6923cfc172de5') . $timestamp );
        $base_url = env('MPESA_CALLBACK_URL') ? env('MPESA_CALLBACK_URL') : env('APP_URL','https://lincolnfinch.com');
        $callback_url = $base_url .'/v1/stkpush/callback'; // attach company id to callback url for identification
        $amount = app()->environment('production') ? $request->amount : 1;
        
        $curl_post_data = [
            'BusinessShortCode' => env('MPESA_BUSINESS_SHORTCODE','4033851'),
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => Utilities::cleanPhoneNumber($request->phone),
            'PartyB' => env('MPESA_BUSINESS_SHORTCODE','4033851'),
            'PhoneNumber' => Utilities::cleanPhoneNumber($request->phone),
            'CallBackURL' => $callback_url,
            'AccountReference' => ucwords($user->company->company_name),
            'TransactionDesc' => 'Subscription payment', 
        ];        
        
        $url = '/stkpush/v1/processrequest';   
        
        $response = json_decode( $this->makeHttp($url, $curl_post_data) );

        if( isset($response->errorCode)) return $response;
       $data = [
            'checkout_request_id' => $response->CheckoutRequestID,
            'merchant_request_id' => $response->MerchantRequestID,
            'company_id' => $user->company_id,
            'user_id' => $user->id,
            'transaction_type' => 'subscription payment',
            'payment_method' => 'mpesa',
            'phone_number' => $request->phone,
            'transaction_amount' => $request->amount,
            'transaction_reciept_number' => null,
       ];

       $payment = Payment::create($data);

        return $response;

    }

    /**
     * Detect mpesa payment
     */
    public function detectMpesaPayment(Request $request, $checkout_id){
      

        $transaction = Payment::where('checkout_request_id', $checkout_id)->first();

        if(is_null($transaction)){
            return response()->json([
                'success' => false,
                'message' => 'No record found',
                'data'=> false
            ], 404);
        }

        Company::where('company_id',$transaction->company_id)->update(['registration_status'=>0]); //remove this asap

        if (! $transaction->transaction_reciept_number) {
            return response()->json([
                'success' => false,
                'message' => 'Payment reciept not found',
                'data' => false
            ], 404);
        }
        else{
            $transaction->update([
                'record_reconciled' => true,
                'record_reconciled_at'=> now(),
            ]);  
            return response()->json([
                'success' => true,
                'message' => 'Success, Mpesa payment reciept reconciled',
                'data' =>  $transaction
            ], 200);
        }
    }




    // /**
    //  * Reverse mpesa transaction
    //  */
    // public function reverseMpesaTransaction(Request $request, User $user)
    // {
    //     $body = array(
    //         'Initiator' => env('MPESA_B2C_INITIATOR'),
    //         'SecurityCredential' => env('MPESA_B2C_PASSWORD'),
    //         'CommandID' => 'TransactionReversal',
    //         'TransactionID' => $request->transactionid,
    //         'Amount' => $request->amount,
    //         'ReceiverParty' => env('MPESA_SHORTCODE'),
    //         'RecieverIdentifierType' => '11',
    //         'ResultURL' => env('MPESA_TEST_URL') . '/api/reversal/result_url',
    //         'QueueTimeOutURL' => env('MPESA_TEST_URL') . '/api/reversal/timeout_url',
    //         'Remarks' => 'ReversalRequest',
    //         'Occasion' => 'ErroneousPayment'
    //     );

    //     $url =  'reversal/v1/request';
    //     $response = $this->makeHttp($url, $body);

    //     return $response;
    // }
    


    
}
