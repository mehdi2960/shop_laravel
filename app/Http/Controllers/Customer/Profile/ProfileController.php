<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Profile\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('customer.profile.profile');
    }

    public function update(ProfileUpdateRequest $request)
    {
        $inputs = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code
        ];

        $user = auth()->user();
        $user->update($inputs);
        return redirect()->route('customer.profile.profile')->with(['success' => 'حساب کاربری با موفقیت ویرایش شد.']);
    }
}
