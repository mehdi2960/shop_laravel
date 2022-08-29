<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\SalesProces\ChooseAddressAndDeliveryRequest;
use App\Http\Requests\Customer\SalesProces\StoreAddressRequest;
use App\Http\Requests\Customer\SalesProces\UpdateAddressRequest;
use App\Models\Address;
use App\Models\Market\CartItem;
use App\Models\Market\CommonDiscount;
use App\Models\Market\Delivery;
use App\Models\Market\Order;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function addressAndDelivery()
    {
        //check profile
        $user = Auth::user();
        $provinces = Province::all();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $deliveryMethods = Delivery::where('status', 1)->get();

        if (empty(CartItem::where('user_id', $user->id)->count())) {
            return redirect()->route('customer.sales-process.cart');
        }

        return view('customer.sales-process.address-and-delivery', compact('cartItems', 'provinces', 'deliveryMethods'));

    }

    public function getCities(Province $province)
    {
        $cities = $province->cities;
        if ($cities != null) {
            return response()->json(['status' => true, 'cities' => $cities]);
        } else {
            return response()->json(['status' => false, 'cities' => null]);
        }
    }

    public function addAddress(StoreAddressRequest $request)
    {
        $inputs = $request->all();
        $inputs['user_id'] = auth()->user()->id;
        $inputs['postal_code'] = convertArabicToEnglish($request->postal_code);
        $inputs['postal_code'] = convertPersianToEnglish($inputs['postal_code']);
        $address = Address::create($inputs);
        return redirect()->back();
    }

    public function updateAddress(Address $address, UpdateAddressRequest $request)
    {
        $inputs = $request->all();
        $inputs['user_id'] = auth()->user()->id;
        $inputs['postal_code'] = convertArabicToEnglish($request->postal_code);
        $inputs['postal_code'] = convertPersianToEnglish($inputs['postal_code']);
        $address->update($inputs);
        return redirect()->back();
    }

    public function chooseAddressAndDelivery(ChooseAddressAndDeliveryRequest $request)
    {
        $user = auth()->user();
        $inputs = $request->all();

        //calc price
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $totalProductPrice = 0;
        $totalDiscount = 0;
        $totalFinalPrice = 0;
        $totalFinalDiscountPriceWithNumbers = 0;
        foreach ($cartItems as $cartItem)
        {
            $totalProductPrice += $cartItem->cartItemProductPrice();
            $totalDiscount += $cartItem->cartItemProductDiscount();
            $totalFinalPrice += $cartItem->cartItemFinalPrice();
            $totalFinalDiscountPriceWithNumbers += $cartItem->cartItemFinalDiscount();
        }

        //commonDiscount
        $commonDiscount = CommonDiscount::where([['status', 1], ['end_date', '>', now()], ['start_data', '<', now()]])->first();
        if($commonDiscount)
        {
            $commonPercentageDiscountAmount = $totalFinalPrice * ($commonDiscount->percentage / 100);
            if($commonPercentageDiscountAmount > $commonDiscount->discount_ceiling)
            {
                $commonPercentageDiscountAmount = $commonDiscount->discount_ceiling;
            }
            if($commonDiscount != null and $totalFinalPrice >= $commonDiscount->minimal_order_amount)
            {
                $finalPrice = $totalFinalPrice - $commonPercentageDiscountAmount;
            }
            else{
                $finalPrice = $totalFinalPrice;
            }
        }
        else{
            $commonPercentageDiscountAmount = null;
            $finalPrice = $totalFinalPrice;

        }


        $inputs['user_id'] = $user->id;
        $inputs['order_final_amount'] = $finalPrice;
        $inputs['order_discount_amount'] = $totalFinalDiscountPriceWithNumbers;
        $inputs['order_common_discount_amount'] = $commonPercentageDiscountAmount;
        $inputs['order_total_products_discount_amount'] = $inputs['order_discount_amount'] + $inputs['order_common_discount_amount'];
        $order = Order::updateOrCreate(
            ['user_id' => $user->id, 'order_status' => 0],
            $inputs
        );
        return redirect()->route('customer.sales-process.payment');
    }
}
