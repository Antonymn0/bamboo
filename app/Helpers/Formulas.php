<?php 
namespace App\Helpers;

use App\Models\User;
use App\Notifications\ResetPassword;

class Formulas
{
    public static function getTotalCashPay($employeeID)
    {
        $user = User::find($employeeID);
        return $user->notify(new ResetPassword($user) );
    }

    public static function getTotalNonCashBenefits($employeeID)
    {

    }

    public static function getTotalOtherBenefits()
    {

    }

    public static function getGrossPay()
    {

    }

    public static function getTotalDefinedBenefits()
    {
        return 
        self::getMortageInterestRelief() + 
        self::getTotalDefinedContributions() + 
        self::getTotalDisabilityExemption();
    }

    public static function getMortageInterestRelief()
    {

    }

    public static function getTotalDefinedContributions()
    {

    }

    public static function getTotalDisabilityExemption()
    {

    }

    public static function getTaxablePay()
    {

    }

    public static function getPAYE()
    {

    }

    public static function getPersonalRelief()
    {

    }

    public static function getInsuarancePremiumRelief()
    {

    }

    public static function getNHIFRelief()
    {

    }

    public static function getTotalReliefs()
    {

    }

    public static function getTotalOtherDeDuctions()
    {

    } 

    public static function getNetPay()
    {
        
    }


    public static function lumpSumPayment($amount,$balance,$penalty=0) //employee pays a lumpsum to reduce their debt obligation
    {
        return $balance - $amount + $penalty;
    }


    public static function reducingBalance($fv=0,$pv,$frequency = 12, $rate,$nper,$type=0) // Reducing balance
    {
        return (-$fv - $pv * pow(1 + $rate, $nper)) /
            (1 + $rate * $type) /
            ((pow(1 + $rate, $nper) - 1) / $rate);
    }

    
    public static function reducingBalanceConstantPrinciple($balance,$principle,$nterest_pa,$period,$frequency = 12) // Reducing balance with constant / flat  principle
    {
        $principleRepayment = $principle / $period;
        $interestRepayment = ($nterest_pa / $frequency) * $balance;
        $installment = $principleRepayment + $interestRepayment;
        $newBalance  = $balance - $installment;
    }

    
    public static function flatRate($principle,$interest_pm,$period,$frequency = 1) //Flat rate
    {
        $principleRepayment = $principle / $period;
        $interestRepayment = ($interest_pm * $principle) * $frequency;
        $installment = $principleRepayment + $interestRepayment;
        $newBalance  = $balance - $installment;
    }

    public static function calculateFringeBenefitTax($loanAmt,$employeRate_pa,$marketRate_pa,$coporateTaxRate)
    {
        $employerInterest = $loanAmt * $employeRate_pa;
        $marketInnterest = $loanAmt * $marketRate_pa;

        $fringeBenefit = $marketInnterest - $employerInterest;

        return $fringeBenefit * $coporateTaxRate;
    }


    //gratuity 
    public static function calculateGratuity( $servicePeriod , $amountForEveryYearWorked )
    {
        $amount = $servicePeriod * $amountForEveryYearWorked;
        //it can be basic salary for every year worked etc

        //spread amount for the las 5 years
        $amount; //year

        //taxable amount
        // sum the gratuity to the taxable income 1st year
        //*  the revised  taxable income
        //*  apply the slab rates to get tax payable
        //* subtract paid the tax paid, reliefs from the taxable pay

        // sum the gratuity to the taxable income 2nd year
        //*  the revised  taxable income
        //*  apply the slab rates to get tax payable
        //* subtract paid the tax paid, reliefs from the taxable pay

        // sum the gratuity to the taxable income 3rd year
        //*  the revised  taxable income
        //*  apply the slab rates to get tax payable
        //* subtract paid the tax paid, reliefs from the taxable pay

        // sum the gratuity to the taxable income 4th year
        //*  the revised  taxable income
        //*  apply the slab rates to get tax payable
        //* subtract paid the tax paid, reliefs from the taxable pay

        // sum the gratuity to the taxable income 5th year
        //*  the revised  taxable income
        //*  apply the slab rates to get tax payable
        //* subtract paid the tax paid, reliefs from the taxable pay


        //return tax to be paid on the gratuity amount

    }

    //arrears
    public static function calculateArrears()
    {
        // loop every month since the effective date
        // calculate the benefits on the tax to paid and minus the what was already paid 
        // 
    }


    //lumpsum
    public static function calculateLumpsum()
    {
        //contract specified period compensation specified
        //* compensation amount is spread over the remaining preriod

        //contract specified period compensation unspecified
        //* compensation amount is spread over the remaining preriod

        //contract unspecified period compensation specified
        //* spread compensation amount based on annual pay

        //contract unspecified period compensation not specified
        //* spread the amount over 3 year

    }
    
}