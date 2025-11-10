@extends('layouts.admin.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Data Warga</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('pages.admin.warga.create') }}" class="btn btn-primary mb-3">+ Tambah Warga</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>No KTP</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Agama</th>
                <th>Pekerjaan</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($warga as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->no_ktp }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jenis_kelamin }}</td>
                    <td>{{ $item->agama }}</td>
                    <td>{{ $item->pekerjaan }}</td>
                    <td>{{ $item->telp }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        <a href="{{ route('pages.admin.warga.show', $item->warga_id) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('pages.admin.warga.edit', $item->warga_id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('pages.admin.warga.destroy', $item->warga_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Belum ada data warga</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $warga->links() }}
</div>
@endsection
