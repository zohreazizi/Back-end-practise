<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reserve;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;


class PurchaseController extends Controller
{
    /**
     * @throws Exception
     */
    public function purchase(Reserve $reserve)
    {
        $invoice = new Invoice();
        $invoice->amount($reserve->price);
        $user = auth('api')->user()->id;
        $transaction = $user->transactions()->create([
            'reserve_id' => $reserve->id,
            'paid' => $invoice->getAmount(),
        ]);

        $payment = \Shetabit\Payment\Facade\Payment::callbackUrl(route('purchase.result', [$reserve->id]));
        $payment->purchase($invoice, function ($driver, $transactionId) use ($transaction) {
            $transaction->transaction_id = $transactionId;
            $transaction->save();
        })->pay()->toJson();
    }

    public function verify(Request $request)
    {
        $transaction = Transaction::query()->where('transaction_id', $request->Authority)->first();
        if ($request->Status == 'NOK') {
            $transaction->status = Transaction::STATUS_FAILED;
            $transaction->save();
            return response()->json('عملیات پرداخت با خطا مواجه شد');
        }
        $receipt = \Shetabit\Payment\Facade\Payment::amount($transaction->paid)
            ->transactionId($transaction->transaction_id)
            ->verify();
        return response()->json($receipt);
    }
}
