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

    public function store(Request $request)
    {
        $data = $request->validate([
            'recruiter_name' => 'required|string|max:255',
            'referral_code' => 'required|string|unique:referrals,referral_code|max:255',
            'commission_type' => 'required|in:fixed,percentage',
        ]);
        
        $commissionValue = $request->commission_type === 'fixed' 
            ? $request->input('commission_value_fixed') 
            : $request->input('commission_value_percentage');

        $data['commission_value'] = $commissionValue;
        $data['status'] = 'active'; // Default active
        $data['participant'] = 0;
        $data['active_participant'] = 0;
        $data['total_commission'] = 0;

        Referral::create($data);

        $this->logActivity('Referral', 'CREATE', "Created referral code: {$data['referral_code']}");

        return redirect()->route('referral.index')->with('success', 'Kode referral berhasil dibuat.');
    }

    public function update(Request $request, Referral $referral)
    {
        $data = $request->validate([
            'recruiter_name' => 'required|string|max:255',
            'referral_code' => 'required|string|max:255|unique:referrals,referral_code,' . $referral->id,
            'commission_type' => 'required|in:fixed,percentage',
        ]);
        
        $commissionValue = $request->commission_type === 'fixed' 
            ? $request->input('commission_value_fixed') 
            : $request->input('commission_value_percentage');

        $data['commission_value'] = $commissionValue;

        $referral->update($data);

        $this->logActivity('Referral', 'UPDATE', "Updated referral code: {$referral->referral_code}");

        return redirect()->route('referral.index')->with('success', 'Kode referral berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Referral $referral)
    {
        $referral->update([
            'status' => $referral->status === 'active' ? 'inactive' : 'active'
        ]);
        
        $this->logActivity('Referral', 'UPDATE', "Toggled referral status: {$referral->referral_code}");

        return redirect()->route('referral.index')->with('success', 'Status referral berhasil diubah.');
    }

    public function destroy(Referral $referral)
    {
        $code = $referral->referral_code;
        $referral->delete();
        
        $this->logActivity('Referral', 'DELETE', "Deleted referral: {$code}");

        return redirect()->route('referral.index')->with('success', 'Referral berhasil dihapus.');
    }
}
