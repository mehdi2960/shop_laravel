<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Models\Market\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders=auth()->user()->orders()->orderBy('id','desc')->get();
        return view('customer.profile.orders',compact('orders'));
    }
}
