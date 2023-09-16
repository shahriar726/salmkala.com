<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Models\IranProvince;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    public function index()
    {
        $provinces = IranProvince::all();
        return view('customer.profile.my-addresses', compact('provinces'));
    }
}
