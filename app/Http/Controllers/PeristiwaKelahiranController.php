<?php

namespace App\Http\Controllers;

use App\Models\PeristiwaKelahiran;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PeristiwaKelahiranController extends Controller
{
    /**
     * Tampilkan semua peristiwa kelahiran
     */
    public function index()
    {
        $kelahiran = PeristiwaKelahiran::with(['bayi', 'ayah', 'ibu'])->latest()->paginate(10);
        return view('pages.admin.peristiwa_kelahiran.index', compact('kelahiran'));
    }

    /**
     * Form tambah kelahiran
     */
    public function create()
    {
        $warga = Warga::all();
        return view('pages.admin.peristiwa_kelahiran.create', compact('warga'));
    }

    /**
     * Simpan data kelahiran
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id'       => 'required|exists:warga,warga_id',
            'tgl_lahir'      => 'required|date',
            'tempat_lahir'   => 'required|string|max:100',
            'ayah_warga_id'  => 'required|exists:warga,warga_id',
            'ibu_warga_id'   => 'required|exists:warga,warga_id',
            'no_akta'        => 'required|string|max:50|unique:peristiwa_kelahiran,no_akta',
            'bukti_kelahiran'=> 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('bukti_kelahiran')) {
            $validated['bukti_kelahiran'] = $request->file('bukti_kelahiran')
                ->store('peristiwa_kelahiran', 'public');
        }

        PeristiwaKelahiran::create($validated);

        return redirect()->route('pages.admin.peristiwa_kelahiran.index')
            ->with('success', 'Peristiwa kelahiran berhasil ditambahkan!');
    }

    /**
     * Detail kelahiran
     */
    public function show($id)
    {
        $kelahiran = PeristiwaKelahiran::with(['bayi', 'ayah', 'ibu'])->findOrFail($id);
        return view('pages.admin.peristiwa_kelahiran.show', compact('kelahiran'));
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $kelahiran = PeristiwaKelahiran::findOrFail($id);
        $warga = Warga::all();

        return view('pages.admin.peristiwa_kelahiran.edit', compact('kelahiran', 'warga'));
    }

    /**
     * Update data kelahiran
     */
    public function update(Request $request, $id)
    {
        $kelahiran = PeristiwaKelahiran::findOrFail($id);

        $validated = $request->validate([
            'warga_id'       => 'required|exists:warga,warga_id',
            'tgl_lahir'      => 'required|date',
            'tempat_lahir'   => 'required|string|max:100',
            'ayah_warga_id'  => 'required|exists:warga,warga_id',
            'ibu_warga_id'   => 'required|exists:warga,warga_id',
            'no_akta'        => 'required|string|max:50|unique:peristiwa_kelahiran,no_akta,' . $id . ',kelahiran_id',
            'bukti_kelahiran'=> 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('bukti_kelahiran')) {
            if ($kelahiran->bukti_kelahiran) {
                Storage::disk('public')->delete($kelahiran->bukti_kelahiran);
            }

            $validated['bukti_kelahiran'] = $request->file('bukti_kelahiran')
                ->store('peristiwa_kelahiran', 'public');
        }

        $kelahiran->update($validated);

        return redirect()->route('pages.admin.peristiwa_kelahiran.index')
            ->with('success', 'Data kelahiran berhasil diperbarui!');
    }

    /**
     * Hapus kelahiran
     */
    public function destroy($id)
    {
        $kelahiran = PeristiwaKelahiran::findOrFail($id);

        if ($kelahiran->bukti_kelahiran) {
            Storage::disk('public')->delete($kelahiran->bukti_kelahiran);
        }

        $kelahiran->delete();

        return redirect()->route('pages.admin.peristiwa_kelahiran.index')
            ->with('success', 'Peristiwa kelahiran berhasil dihapus!');
    }
}
