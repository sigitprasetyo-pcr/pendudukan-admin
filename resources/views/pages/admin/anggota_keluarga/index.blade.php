@extends('layouts.admin.app')
@section('title','Anggota Keluarga')

@section('content')
<div class="container-fluid py-3">

    <div class="d-flex justify-content-between mb-3">
        <h4>Data Anggota Keluarga</h4>
        <a href="{{ route('pages.admin.anggota_keluarga.create') }}" class="btn btn-primary">+ Tambah Anggota</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No KK</th>
                    <th>Nama Warga</th>
                    <th>Hubungan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($anggota as $i => $a)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $a->kk->kk_nomor }}</td>
                    <td>{{ $a->warga->nama }}</td>
                    <td>{{ $a->hubungan }}</td>
                    <td>
                        <a href="{{ route('pages.admin.anggota_keluarga.edit', $a->anggota_id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('pages.admin.anggota_keluarga.destroy',$a->anggota_id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus data?')" class="btn btn-danger btn-sm">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
