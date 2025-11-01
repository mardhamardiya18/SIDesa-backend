<?php

namespace App\Http\Controllers;

use App\Models\EventParticipant;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id;
        $transaction = EventParticipant::where('id', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        switch ($transactionStatus) {
            case 'capture':
                if ($request->payment_type === 'credit_card') {
                    if ($request->fraud_status === 'challenge') {
                        $transaction->update(['payment_status' => 'pending']);
                    } else {
                        $transaction->update(['payment_status' => 'paid']);
                    }
                }
                break;
            case 'settlement':
                $transaction->update(['payment_status' => 'paid']);
                break;
            case 'pending':
                $transaction->update(['payment_status' => 'pending']);
                break;
            case 'deny':
                $transaction->update(['payment_status' => 'failed']);
                break;
            case 'expire':
                $transaction->update(['payment_status' => 'failed']);
                break;
            case 'cancel':
                $transaction->update(['payment_status' => 'failed']);
                break;
            default:
                $transaction->update(['payment_status' => 'failed']);
                break;
        }

        return response()->json(['message' => 'Transaction status updated'], 200);
    }
}
