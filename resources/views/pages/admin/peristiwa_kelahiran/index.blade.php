@extends('layouts.admin.app')
@section('title','Peristiwa Kelahiran')

@section('content')
<div class="container-fluid py-3">

    <div class="d-flex justify-content-between mb-3">
        <h4>Data Kelahiran</h4>
        <a href="{{ route('pages.admin.peristiwa_kelahiran.create') }}" class="btn btn-primary">+ Tambah</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Bayi</th>
                    <th>Tgl Lahir</th>
                    <th>No Akta</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelahiran as $i => $k)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $k->bayi->nama }}</td>
                    <td>{{ $k->tgl_lahir }}</td>
                    <td>{{ $k->no_akta }}</td>
                    <td>
                        <a href="{{ route('pages.admin.peristiwa_kelahiran.edit', $k->kelahiran_id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('pages.admin.peristiwa_kelahiran.destroy',$k->kelahiran_id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus data?')" class="btn btn-danger btn-sm">Hapus</button>
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
