<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;

class ProfileAddressController extends Controller
{
    public function index()
    {
        $provinces = Province::all();
        return view('customer.profile.my-addresses',compact('provinces'));
    }
}
