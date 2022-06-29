<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use App\Helpers\GeneratePDF;

class TestGeneratePDFContoller extends Controller
{
    // THIS CONTROLER SHOULD BE DELETED AFTER USE
    
    /**
     * Generate test submiteduser data PDF
     */
    public function generateUserDatPDF(Request $request)
    {
        $user = $request->user();
        $pdf = GeneratePDF::generateUserSubmitedDataPDF($user->id);
        
        return $pdf->stream('details.pdf');
    }

    /**
     * Generate test payslip data PDF
     */
    public function generatePayslipPDF(Request $request)
    {
        $user = $request->user();
        $pdf = GeneratePDF::generatePayslipPDF($user->id);
        
        return $pdf->stream('payslip.pdf');
    }

    
}
