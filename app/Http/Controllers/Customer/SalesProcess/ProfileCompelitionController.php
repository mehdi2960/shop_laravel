<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Http\Controllers\Controller;
use App\Models\Market\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileCompelitionController extends Controller
{
    public function profileCompletion()
    {
        $user=Auth::user();
        $cartItems=CartItem::query()->where('user_id',$user->id)->get();
        return view('customer.sales-process.profile-completion',compact('user','cartItems'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name'=>'sometimes|required',
            'last_name'=>'sometimes|required',
            'mobile'=>'sometimes|required|min:10|max:13|unique:users,mobile',
            'national_code'=>'required',
            'email'=>'nullable|unique:users,email',
        ]);

        $user=Auth::user();
        $inputs=$request->all();
        $user->update($inputs);

    }
}
