<?php
namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use App\Models\KeluargaKK;
use App\Models\Warga;
use Illuminate\Http\Request;

class AnggotaKeluargaController extends Controller
{
    /**
     * Tampilkan data anggota keluarga
     */
    public function index(Request $request)
    {
        $filterableColumns = ['kk_id', 'warga_id', 'hubungan'];
        $searchableColumns = ['hubungan'];

        $anggota = AnggotaKeluarga::with(['kk', 'warga'])
            ->filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->paginate(10)
            ->onEachSide(2)
            ->withQueryString();

        return view('pages.admin.anggota_keluarga.index', compact('anggota'));
    }

    /**
     * Tampilkan form tambah anggota keluarga
     */
    public function create()
    {
        $kk    = KeluargaKK::all();
        $warga = Warga::all();
        return view('pages.admin.anggota_keluarga.create', compact('kk', 'warga'));
    }

    /**
     * Simpan anggota keluarga baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kk_id'    => 'required|exists:keluarga_kk,kk_id',
            'warga_id' => 'required|exists:warga,warga_id',
            'hubungan' => 'required|string|max:50',
        ]);

        AnggotaKeluarga::create($validated);

        return redirect()->route('pages.admin.anggota_keluarga.index')
            ->with('success', 'Anggota keluarga berhasil ditambahkan!');
    }

    /**
     * Detail anggota keluarga
     */
    public function show($id)
    {
        $anggota = AnggotaKeluarga::with(['kk', 'warga'])->findOrFail($id);
        return view('pages.admin.anggota_keluarga.show', compact('anggota'));
    }

    /**
     * Tampilkan form edit anggota keluarga
     */
    public function edit($id)
    {
        $anggota = AnggotaKeluarga::findOrFail($id);
        $kk      = KeluargaKK::all();
        $warga   = Warga::all();

        return view('pages.admin.anggota_keluarga.edit', compact('anggota', 'kk', 'warga'));
    }

    /**
     * Update data anggota keluarga
     */
    public function update(Request $request, $id)
    {
        $anggota = AnggotaKeluarga::findOrFail($id);

        $validated = $request->validate([
            'kk_id'    => 'required|exists:keluarga_kk,kk_id',
            'warga_id' => 'required|exists:warga,warga_id',
            'hubungan' => 'required|string|max:50',
        ]);

        $anggota->update($validated);

        return redirect()->route('pages.admin.anggota_keluarga.index')
            ->with('success', 'Data anggota keluarga berhasil diperbarui!');
    }

    /**
     * Hapus anggota keluarga
     */
    public function destroy($id)
    {
        $anggota = AnggotaKeluarga::findOrFail($id);
        $anggota->delete();

        return redirect()->route('pages.admin.anggota_keluarga.index')
            ->with('success', 'Data anggota keluarga berhasil dihapus!');
    }
}
