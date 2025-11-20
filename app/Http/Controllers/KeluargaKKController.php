<?php
namespace App\Http\Controllers;

use App\Models\KeluargaKK;
use Illuminate\Http\Request;

class KeluargaKKController extends Controller
{
    /**
     * Tampilkan semua data KK
     */
    public function index(Request $request)
    {
        $filterableColumns = ['rt', 'rw'];
        $searchableColumns = ['kk_nomor', 'alamat'];

        $kk = KeluargaKK::filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->paginate(10)
            ->onEachSide(2)
            ->withQueryString();

        return view('pages.admin.keluarga_kk.index', compact('kk'));
    }

    /**
     * Tampilkan form tambah KK
     */
    public function create()
    {
        return view('pages.admin.keluarga_kk.create');
    }

    /**
     * Simpan data KK baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kk_nomor'                 => 'required|string|max:50|unique:keluarga_kk,kk_nomor',
            'kepala_keluarga_warga_id' => 'nullable|integer',
            'alamat'                   => 'nullable|string|max:255',
            'rt'                       => 'nullable|string|max:5',
            'rw'                       => 'nullable|string|max:5',
        ]);

        KeluargaKK::create($validated);

        return redirect()->route('pages.admin.keluarga_kk.index')
            ->with('success', 'Data KK berhasil ditambahkan!');
    }

    /**
     * Detail KK
     */
    public function show($id)
    {
        $kk = KeluargaKK::findOrFail($id);
        return view('pages.admin.keluarga_kk.show', compact('kk')); // Mengarahkan ke view show
    }

    /**
     * Tampilkan form edit KK
     */
    public function edit($id)
    {
        $kk = KeluargaKK::findOrFail($id);
        return view('pages.admin.keluarga_kk.edit', compact('kk'));
    }

    /**
     * Update data KK
     */
    public function update(Request $request, $id)
    {
        $kk = KeluargaKK::findOrFail($id);

        $validated = $request->validate([
            'kk_nomor'                 => 'required|string|max:50|unique:keluarga_kk,kk_nomor,' . $id . ',kk_id',
            'kepala_keluarga_warga_id' => 'nullable|integer',
            'alamat'                   => 'nullable|string|max:255',
            'rt'                       => 'nullable|string|max:5',
            'rw'                       => 'nullable|string|max:5',
        ]);

        $kk->update($validated);

        return redirect()->route('pages.admin.keluarga_kk.index')
            ->with('success', 'Data KK berhasil diperbarui!');
    }

    /**
     * Hapus data KK
     */
    public function destroy($id)
    {
        $kk = KeluargaKK::findOrFail($id);
        $kk->delete();

        return redirect()->route('pages.admin.keluarga_kk.index')
            ->with('success', 'Data KK berhasil dihapus!');
    }
}
