<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Http\Controllers\Controller;
use App\Models\Market\CartItem;
use App\Models\Market\Copan;
use App\Models\Market\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function payment()
    {
        $user = auth()->user();
        $cartItems = CartItem::query()->where('user_id', $user->id)->get();
        $order = Order::where('user_id', Auth::user()->id)->where('order_status', 0)->first();

        return view('customer.sales-process.payment', compact('cartItems', 'order'));
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
                    return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است.']]);
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
                return redirect()->back()->with(['copan' => 'کد تخفیف با موفقیت اعمال شد.']);
            } else {
                return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است.']]);
            }
        } else {
            return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است.']]);
        }
    }

    public function paymentSubmit(Request $request)
    {
        $request->validate([
            'payment_type' => 'required'
        ]);

        $order = Order::where('user_id', Auth::user()->id)->where('order_status', 0)->first();
        $cartItems = CartItem::query()->where('user_id', Auth::user()->id)->get();

        switch ($request->payment_type) {
            case '1':
                dd('online');
                break;
            case '2':
                dd('offline');
                break;
            case '3':
                dd('cash');
                break;
                default;
                return redirect()->back();
        }
    }
}
