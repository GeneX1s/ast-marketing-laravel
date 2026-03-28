<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Sale;
use App\Models\Prospek;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class LaporanSalesController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $sales = Sale::with('business')->latest()->get();
        $prospeks = Prospek::with('pic')->latest()->get();
        $businesses = Business::all();
        return view('laporan-sales.index', compact('sales', 'prospeks', 'businesses'));
    }

    public function storeSale(Request $request)
    {
        $data = $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Sale::create($data);

        $this->logActivity('Laporan Sales', 'CREATE', "Created new sale record for Business ID: {$data['business_id']} - Rp {$data['amount']}");

        return redirect()->route('laporan-sales.index')->with('success', 'Data penjualan berhasil ditambahkan.');
    }
}
