<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Payum\Core\GatewayInterface;
use Payum\Core\Model\PaymentInterface;
use Payum\Core\Payum;
use Payum\Core\Request\GetHumanStatus;
use Payum\Core\Security\TokenInterface;
use Payum\Core\Storage\StorageInterface;
use Recca0120\LaravelPayum\Service\Payum as PayumService;

class OfflineController extends BaseController
{
  public function prepare(PayumService $payumService)
  {
      return $payumService->prepare('offline', function (PaymentInterface $payment, $gatewayName, StorageInterface $storage, Payum $payum) {
          // Payment Details Here That User Will Use ... offline
          // Can be Online Bank Transfer/Deposit , Mobile Transfer , Remittance
          $payment->setNumber(uniqid());
          $payment->setCurrencyCode('USD');
          $payment->setTotalAmount(1000);
          $payment->setDescription('Package Name');
          $payment->setClientId('UserID');
          $payment->setClientEmail('registered@useremail.com');
          $payment->setDetails([
              'Items' => [
                  [
                      'Name'     => 'User Registerd Name',
                      'Price'    => (int) '500',
                      'Currency' => 'PHP',
                      'Quantity' => (int) '1',
                      'URL'      => 'dedwed',
                  ],
              ],
          ]);
      },'payment.offline.done');
  }
  // User That Pays Offline Needs Manual Activation
  // You SHould Return a View Telling User to Settle Payment
  // Middleware Pending for User Who Have Pending Payments to Secured...
  public function done(PayumService $payumService, Request $request, $payumToken)
    {
        return $payumService->done($request, $payumToken, function (
            GetHumanStatus $status,
            PaymentInterface $payment,
            GatewayInterface $gateway,
            TokenInterface $token
        ) {
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


}
