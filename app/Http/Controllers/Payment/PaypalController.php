<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Payum\Core\GatewayInterface;
use Payum\Core\Model\PaymentInterface;
use Payum\Core\Payum;
use Payum\Core\Request\GetHumanStatus;
use Payum\Core\Security\TokenInterface;
use Payum\Core\Storage\StorageInterface;
use Recca0120\LaravelPayum\Service\Payum as PayumService;
use Payum\Paypal\ExpressCheckout\Nvp\Api;
use Payum\Core\Request\Sync;
use Payum\Paypal\ExpressCheckout\Nvp\Request\Api\CreateRecurringPaymentProfile;
// use Payum\Core\Request\Cancel;
use Payum\Paypal\ExpressCheckout\Nvp\Request\Api\ManageRecurringPaymentsProfileStatus;
// Payment Model -> View All Payments Status ETC...
use Recca0120\LaravelPayum\Model\Payment as EloquentPayment;
// Gateway Config Model -> View All Gateway By User
use Recca0120\LaravelPayum\Model\GatewayConfig as EloquentGateway;
// Token Model
// use Recca0120\LaravelPayum\Model\Token as EloquentToken;
// Or Create a dedicated model and extend the Following in that model...
// use Payum\Core\Model\GatewayConfigInterface;




class PaypalController extends Controller
{

  /**
   * [prepare Set Up The Checkout Page and Type of Payment]
   * @param  Payment $payment [description]
   * @return [type]           [description]
   */
  protected $user;
  public function prepare(PayumService $payumService)
  {
    // fetch here my gateway in db and stored it in $gatewayName
    // $paypal = EloquentGateway::first();
    // $paypal = $paypal->getGatewayName();
    $this->user = auth()->user();
    // dont hard code paypal_express_checkout as mode of payment
    // maybe use a url segment {gatewayName} where we accept $gatewayName in our method
      return $payumService->prepare('paypal_express_checkout', function (PaymentInterface $payment,$gatewayName, StorageInterface $storage, Payum $payum){
          $payment->setNumber(uniqid());
          $payment->setCurrencyCode('USD');// Needed For Payum to Work
          $payment->setTotalAmount(1000);
          $payment->setDescription('');
          $payment->setClientId($this->user->id); // Auth User ID
          $payment->setClientEmail($this->user->email); // Auth User Email
          $payment->setDetails([
            'BRANDNAME' => 'jarvisbotmessenger.com', // Provide name for cancel and return url
            'HDRIMG' => 'https://www.ukparkandfly.co.uk/images/tise/750x90.jpg',
            'SOLUTIONTYPE' => 'Mark', //Buyer must have a PayPal account to check out
            'LANDINGPAGE' => 'Login', // Billing(Credit Card) or Login Type Pages
            'CARTBORDERCOLOR' => '009688', // Border Color
            'PAYMENTREQUEST_0_INVNUM' => 'NEWORDER2', // This Should be the OrderID or the SubscriptionID or INVOICE ID
            'NOSHIPPING' => 1, // Enable no Shipping Fee for Digital Products
          ]);
      },'payment.done');
  }

  /**
   * [done This is Set For 1 Week Free Trial and Monthly Subscription Until Canceled]
   * @param  Payment  $payment    [description]
   * @param  Request  $request    [description]
   * @param  [type]   $payumToken [description]
   * @return function             [description]
   */
  public function done(PayumService $payumService, Request $request, $payumToken)
    {
      return $payumService->done($request, $payumToken, function (GetHumanStatus $status, PaymentInterface $payment, GatewayInterface $gateway, TokenInterface $token) {
        return response()->json([
                  'status' => $status->getValue(),
                  'client' => [
                      'id'    => $payment->getClientId(),
                      'email' => $payment->getClientEmail(),
                  ],
                  'number'        => $payment->getNumber(),
                  'description'   => $payment->getCurrencyCode(),
                  'total_amount'  => $payment->getTotalAmount(),
                  'currency_code' => $payment->getCurrencyCode(),
                  'details'       => $payment->getDetails(),
              ]);
      });
    }

    public function testPaymentModel()
    {
      $payments = EloquentPayment::all();
      return $payments;
    }

    public function testGateWayModel()
    {
      $gateways = EloquentGateway::all();
      return $gateways;
    }

}
