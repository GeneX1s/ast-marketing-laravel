<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $referrals = Referral::latest()->get();
        return view('referral.index', compact('referrals'));
    }
}
