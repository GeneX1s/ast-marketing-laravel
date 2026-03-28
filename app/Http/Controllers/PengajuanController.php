<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Business;
use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $pengajuans = Pengajuan::with(['pic', 'business'])->latest()->get();
        $businesses = Business::all();
        $users = User::where('status', true)->get();
        return view('pengajuan.index', compact('pengajuans', 'businesses', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nik' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'business_id' => 'nullable|exists:businesses,id',
            'pic_id' => 'nullable|exists:users,id',
        ]);

        $data['status'] = 'Pending';
        Pengajuan::create($data);

        $this->logActivity('Form Pengajuan', 'CREATE', "Created new application (Pengajuan) for: {$data['name']}");

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dibuat.');
    }

    public function updateStatus(Request $request, Pengajuan $pengajuan)
    {
        $data = $request->validate(['status' => 'required|string|max:255']);
        $pengajuan->update($data);

        $this->logActivity('Form Pengajuan', 'UPDATE', "Updated status for Pengajuan ID: {$pengajuan->id} to {$data['status']}");

        return redirect()->route('pengajuan.index')->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function destroy(Pengajuan $pengajuan)
    {
        $name = $pengajuan->name;
        $pengajuan->delete();

        $this->logActivity('Form Pengajuan', 'DELETE', "Deleted Pengajuan for: {$name}");

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dihapus.');
    }
}
