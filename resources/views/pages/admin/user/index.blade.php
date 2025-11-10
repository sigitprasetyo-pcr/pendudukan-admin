@extends('layouts.admin.app')
@section('title', 'Users')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .table thead th {
            white-space: nowrap;
        }

        .action-gap>* {
            margin-right: .35rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid px-3 px-lg-4"> {{-- cukup padding saja --}}

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><i class="fa fa-users me-2"></i> Data Users</h5>
            <a href="{{ route('user.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-1"></i> User Baru
            </a>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th style="width:200px">Dibuat</th>
                            <th style="width:170px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataUser as $u)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $u->name }}</strong></td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->created_at?->format('d M Y H:i') }}</td>
                                <td class="action-gap">
                                    <a href="{{ route('user.edit', $u->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fa fa-pen"></i> Edit
                                    </a>
                                    <form action="{{ route('user.destroy', $u->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin hapus user {{ $u->name }}?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fa fa-circle-info me-1"></i> Belum ada data user.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
