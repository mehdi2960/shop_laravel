<?php

namespace App\Http\Services\Payment;

use App\Models\Market\OnlinePayment;
use Request;
use Zarinpal\Zarinpal;
use Zarinpal\Clients\GuzzleClient;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Client\RequestException;

class PaymentService
{

    public function paymentCallback()
    {
        $amount = 0;
        $result = $this->zarinpalVerify($amount);
        if ($result['success']) {
            return 'ok';
        }
    }

    public function zarinpal()
    {
        $amount = 0;
        $merchentID = Config::get('payment.zarinpal_api_key');
        $sandbox = false;
        $zarinpalGate = false;
        $client = new GuzzleClient($sandbox);
        $zarinpalGatePSP = '';
        $lang = 'fa';
        $zarinpal = new Zarinpal($merchentID, $client, $lang, $sandbox, $zarinpalGate, $zarinpalGatePSP);
        $payment = [
            'callback_url' => route('payment-call-back'),
            'amount' => $amount,
            'description' => 'the order',
        ];
        try {
            $response = $zarinpal->request($payment);
            $onlinePayment = OnlinePayment::first();
            $code = $response['data']['code'];
            $message = $zarinpal->getCodeMessage($code);
            if ($code === 100) {
                $onlinePayment->update(['bank_first_response' => ($response)]);
                $authority = $response['data']['authority'];
                return $zarinpal->redirect($authority);
            }

        } catch (RequestException $exception) {

            return false;

        }
    }

    public function zarinpalVerify($amount)
    {
        $authority = $_GET['Authority'];
        $data = ['merchent_id' => Config::get('payment.zarinpal_api_key'), 'authority' => $authority, 'amount' => (int)$amount];
        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'Zarinpal Rest Api v4');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            'Content-Length:' . strlen($jsonData)
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $onlinePayment = OnlinePayment::first();
        $onlinePayment->update(['bank_second_response' => $result]);
        if (count($result['errors']) === 0) {
            if ($result['data']['code'] == 100) {
                return ['success' => true];
            } else {
                return ['success' => false];
            }
        } else {
            return ['success' => false];
        }

    }

    

}


