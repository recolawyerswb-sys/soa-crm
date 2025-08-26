<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerApiController extends Controller
{
    public function index()
    {
        // Eager load relations, adjust as needed
        $customers = dd(Customer::with(['profile.user.wallet.movements'])->get());
        return response()->json($customers);
    }
}
