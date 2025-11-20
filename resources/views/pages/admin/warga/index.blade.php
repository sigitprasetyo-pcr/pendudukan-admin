@extends('layouts.admin.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Data Warga</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('pages.admin.warga.create') }}" class="btn btn-primary mb-3">+ Tambah Warga</a>

    {{-- FILTER & SEARCH --}}
    <form method="GET" class="mb-3">
        <div class="row">

            <div class="col-md-2">
                <select name="jenis_kelamin" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <option value="Laki-Laki" {{ request('jenis_kelamin')=='Laki-Laki' ? 'selected':'' }}>Laki-Laki</option>
                    <option value="Perempuan" {{ request('jenis_kelamin')=='Perempuan' ? 'selected':'' }}>Perempuan</option>
                </select>
            </div>

            <div class="col-md-2">
                <select name="agama" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Agama</option>
                    @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $ag)
                        <option value="{{ $ag }}" {{ request('agama') == $ag ? 'selected':'' }}>
                            {{ $ag }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                           value="{{ request('search') }}" placeholder="Search">

                    <button type="submit" class="input-group-text">🔍</button>

                    @if(request('search'))
                        <a href="{{ request()->fullUrlWithQuery(['search'=>null]) }}"
                           class="btn btn-outline-secondary ms-2">Clear</a>
                    @endif
                </div>
            </div>

        </div>
    </form>

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
                    <td>{{ ($warga->currentPage() - 1) * $warga->perPage() + $loop->iteration }}</td>
                    <td>{{ $item->no_ktp }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jenis_kelamin }}</td>
                    <td>{{ $item->agama }}</td>
                    <td>{{ $item->pekerjaan }}</td>
                    <td>{{ $item->telp }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        <a href="{{ route('pages.admin.warga.show', $item->warga_id) }}"
                           class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('pages.admin.warga.edit', $item->warga_id) }}"
                           class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('pages.admin.warga.destroy', $item->warga_id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus data?')">
                            @csrf @method('DELETE')
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

    <div class="mt-3">
        {{ $warga->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
