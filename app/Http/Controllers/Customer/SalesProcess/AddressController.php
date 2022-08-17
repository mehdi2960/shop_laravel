<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Http\Controllers\Controller;
use App\Models\Market\CartItem;
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

        if (empty(CartItem::where('user_id', $user->id)->count())) {
            return redirect()->route('customer.sales-process.cart');
        }

        return view('customer.sales-process.address-and-delivery', compact('cartItems','provinces'));

    }
}
