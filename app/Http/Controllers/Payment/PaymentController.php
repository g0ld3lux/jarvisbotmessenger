<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;

class PaymentController extends Controller
{
  public function index(Request $request)
  {
    // if no plan redirect  to somewhere else
    $plan = $request->get('plan');
    if(empty($plan)){
      return redirect()->route('plans.index');
    }
    $package = Package::findByPlan($plan);

    // Return a View to Choose Payment Method...
    // Choose Either Paypal Or Credit Card or Offline Payment....
    // Send an email to User For Offline Payment ... Where They Need to Settle Payment
    // Validate Credit Card , Pay , Then Activated Subscription
    // Send a Payment Via Paypal , Create Profile Recurring then , Activate Account
    return $package;


  }


}
