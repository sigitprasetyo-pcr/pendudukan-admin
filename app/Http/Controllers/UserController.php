<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
// Ditambahkan untuk logging yang lebih baik

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['dataUser'] = User::latest()->get();
        return view('pages.admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        try {
            User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('user.index')->with('success', '✅ User berhasil ditambahkan!');
        } catch (\Exception $e) {
            // [PERBAIKAN]: Logging error yang lebih baik
            Log::error('Gagal membuat user baru: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', '❌ Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|min:3',
            // Pengecualian ID saat update
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);

        try {
            $data = [
                'name'  => $request->name,
                'email' => $request->email,
            ];

            // Jika password diisi, update password
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);
            // [PERBAIKAN]: Menambahkan pesan sukses yang lengkap
            return redirect()->route('user.index')->with('success', '✅ User berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error("Gagal memperbarui user ID {$id}: " . $e->getMessage());
            return redirect()->back()->withInput()->with('error', '❌ Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            User::findOrFail($id)->delete();
            return redirect()->route('user.index')->with('success', '✅ User berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error("Gagal menghapus user ID {$id}: " . $e->getMessage());
            return redirect()->route('user.index')->with('error', '❌ Gagal menghapus user: ' . $e->getMessage());
        }
    }

    // [PERBAIKAN]: Fungsi login dihapus karena sudah ada di LoginController
}
