<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Models\Market\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return view('admin.market.payment.index', compact('payments'));
    }

    public function offline()
    {
        return view('admin.market.payment.index');
    }

    public function online()
    {
        return view('admin.market.payment.index');
    }

    public function attendance()
    {
        return view('admin.market.payment.index');
    }

    public function confirm()
    {
        return view('admin.market.payment.index');
    }
}
