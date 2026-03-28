<?php

namespace App\Http\Controllers;

use App\Models\Kampanye;
use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class KampanyeController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $kampanyes = Kampanye::with('pic')->latest()->get();
        $users = User::where('status', true)->get();
        return view('kampanye.index', compact('kampanyes', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'channel' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'pic_id' => 'required|exists:users,id',
            'schedule' => 'required|date',
            'content_url' => 'nullable|string|max:500',
            'notes' => 'nullable|string',
        ]);

        $data['status'] = 'Terjadwal';
        Kampanye::create($data);

        $this->logActivity('Kampanye', 'CREATE', "Created new campaign: {$data['name']}");

        return redirect()->route('kampanye.index')->with('success', 'Kampanye berhasil dibuat.');
    }

    public function update(Request $request, Kampanye $kampanye)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'channel' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'pic_id' => 'required|exists:users,id',
            'schedule' => 'required|date',
            'content_url' => 'nullable|string|max:500',
            'notes' => 'nullable|string',
            'status' => 'nullable|string|max:255',
        ]);

        $kampanye->update($data);

        $this->logActivity('Kampanye', 'UPDATE', "Updated campaign ID: {$kampanye->id} ({$data['name']})");

        return redirect()->route('kampanye.index')->with('success', 'Kampanye berhasil diperbarui.');
    }

    public function destroy(Kampanye $kampanye)
    {
        $name = $kampanye->name;
        $kampanye->delete();

        $this->logActivity('Kampanye', 'DELETE', "Deleted campaign: {$name}");

        return redirect()->route('kampanye.index')->with('success', 'Kampanye berhasil dihapus.');
    }
}
