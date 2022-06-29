<?php 
namespace App\Helpers;

use App\Models\User;
use App\Models\Payment;
use PDF;

class GeneratePDF 
{
    /**
     * Generate submited user data PDF file
     */
    static function generateUserSubmitedDataPDF($user_id)
    {
        $user = User::with(['meta', 'company', 'education', 'benefits'])->where('id', $user_id)->first();

        $data['user']= $user;           

        $pdf = PDF::loadView('pdfs/submited_user_data_pdf', $data);  
          
        return  $pdf;
    }

    /**
     * Generate submited user data PDF file
     */
    static function generatePayslipPDF($user_id)
    {
        $data['user'] = User::with(['meta', 'company', 'benefits', 'deductions'])->where('id', $user_id)->first();

        $pdf = PDF::loadView('pdfs/payslip_pdf', $data);  

        return  $pdf;
    }

    /**
     * Generate employees/people data PDF file
     * @param array
     */
    static function generateEmployeesDataPDF($selected_users)
    {
        // fetch all selected employees user records        
        $data['users'] = User::with(['meta', 'company', 'department'])
                        ->whereIn('id', $selected_users)
                        ->get(); 

        $pdf =  PDF::loadView('pdfs/employees_data_pdf', $data);  

        return  $pdf;
    }

    /**
     * Generate subscription payment reciept
     * @param array
     */
    static function subscriptionPaymentRecieptPDF($payment)
    {
        $data['payment'] = $payment;

        // get user        
        $data['user'] = User::findOrFail($payment->user_id);

        $pdf =  PDF::loadView('pdfs/subscription_payment_reciept_pdf', $data);  

        return  $pdf;
    }

}