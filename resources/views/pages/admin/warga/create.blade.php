@extends('layouts.admin.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Data Warga</h1>

    <form action="{{ route('pages.admin.warga.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">No KTP</label>
            <input type="text" name="no_ktp" class="form-control" value="{{ old('no_ktp') }}" required>
            @error('no_ktp') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
            @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Agama</label>
            <input type="text" name="agama" class="form-control" value="{{ old('agama') }}" required>
            @error('agama') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Pekerjaan</label>
            <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan') }}">
            @error('pekerjaan') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Telepon</label>
            <input type="text" name="telp" class="form-control" value="{{ old('telp') }}">
            @error('telp') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pages.admin.warga.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
