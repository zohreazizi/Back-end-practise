<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Pishran\Zarinpal\Zarinpal;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay()
    {
        $zarinpal = \zarinpal()
            ->amount(100)
            ->request()
            ->callbackUrl('http://127.0.0.1:7000/api/payment-gateway')
            ->description('توضیحات تراکنش')
            ->send();

        if (!$zarinpal->success()) {
            return response()->json($zarinpal->error()->message());
        }

        $authority = $zarinpal->authority();

        return $zarinpal->redirect();
    }

    public function verify(Request $request)
    {
        $authority = \request()->query('Authority');
        $amount = Payment::query()->where('authority', $authority)
            ->value('amount');
        if (!$amount) {
            return null;
        }

        $response = \zarinpal()
            ->amount($amount)
            ->verification()
            ->authority($authority)
            ->send();
        if (!$response->success()) {
            return response()->json($response->error()->message());
        }

        return response()->json($response->referenceId());
    }
}
