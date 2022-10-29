<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Http\Controllers\Controller;
use App\Models\Market\Copan;
use App\Models\Market\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function payment()
    {
        return view('customer.sales-process.payment');
    }

    public function copanDiscount(Request $request)
    {
        $request->validate([
            'copan' => 'required'
        ]);
        $copan = Copan::where([['code' => $request->code], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()]])->first();

        if ($copan != null) {
            if ($copan->user_id != null) //code takhfif khososi
            {
                $copan = Copan::where([['code' => $request->code], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()], ['user_id', auth()->user()->id]])->first();

                if ($copan == null) {
                    return redirect()->back();
                }
            }

            $order = Order::where('user_id', Auth::user()->id)->where('order_status', 0)->where('copan_id', null)->first();

            if ($order) {
                if ($copan->amount_type == 0) {
                    $copanDiscountAmount = $order->order_final_amount * ($copan->amount / 100);
                    if ($copanDiscountAmount > $copan->discount_ceiling) {
                        $copanDiscountAmount = $copan->discount_ceiling;
                    }
                } else {
                    $copanDiscountAmount = $copan->amount;
                }

                $order->order_final_amount = $order->order_final_amount - $copanDiscountAmount;

                $finalDiscount = $order->order_total_products_discount_amount + $copanDiscountAmount;

                $order->update(
                    [
                        'copan_id' => $copan->id,
                        'order_copan_discount_amount' => $copanDiscountAmount,
                        'order_total_products_discount_amount' => $finalDiscount
                    ]
                );
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }
}
