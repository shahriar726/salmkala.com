<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Profile\UpdateProfileRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('customer.profile.profile');
    }

    public function update(UpdateProfileRequest $request)
    {
        $inputs = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => $request->password,
        ];
        $inputs['password'] = Hash::make($inputs['password']);
        $user = auth()->user();
        $user->update($inputs);
        return redirect()->route('customer.profile.profile')->with('alert-section-success', 'حساب کاربری با موفقیت ویرایش شد');
    }
}
