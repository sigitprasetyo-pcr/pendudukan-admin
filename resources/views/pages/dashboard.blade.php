@extends('layouts.admin.app')
@section('title', 'Dashboard')

@push('styles')
  {{-- Geser konten ke kanan agar tidak tertutup sidebar (atur lebar sesuai template-mu) --}}
  {{-- <style>
    :root { --sidebar-w: 260px; }        /* ubah jika lebar sidebar berbeda */
    @media (min-width: 992px) {          /* lg ke atas */
      .dash-wrap { margin-left: var(--sidebar-w); }
    }
    @media (min-width: 576px) and (max-width: 991.98px) {
      .dash-wrap { margin-left: 72px; }  /* saat sidebar collapse */
    }

    .stat-card .icon {
      width: 40px; height: 40px; display: inline-flex;
      align-items: center; justify-content: center;
      border-radius: 12px; background: #eff3f9; margin-right: .5rem;
      font-size: 18px;
    }
    .stat-card .value { font-weight: 700; font-size: 1.25rem; }
  </style> --}}

  {{-- Font Awesome untuk icon (kalau layout-mu sudah include, bagian ini aman diabaikan) --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush

@section('content')
<div class="dash-wrap container-fluid py-3"><!-- wrapper yang digeser -->

  {{-- FILTER --}}
  <div class="card mb-3">
    <div class="card-header py-2"><strong>Filter Data</strong></div>
    <div class="card-body">
      <form method="GET" action="{{ request()->url() }}" class="row g-2">
        <div class="col-6 col-md-3">
          <label class="form-label mb-1">RT</label>
          <input type="number" name="rt" class="form-control" placeholder="01" value="{{ $filters['rt'] }}">
        </div>
        <div class="col-6 col-md-3">
          <label class="form-label mb-1">RW</label>
          <input type="number" name="rw" class="form-control" placeholder="05" value="{{ $filters['rw'] }}">
        </div>
        <div class="col-12 col-md-4 d-flex align-items-end gap-2">
          <button class="btn btn-primary" type="submit"><i class="fa-solid fa-filter me-1"></i> Terapkan</button>
          <a href="{{ request()->url() }}" class="btn btn-outline-secondary"><i class="fa-solid fa-rotate-left me-1"></i> Reset</a>
        </div>
      </form>
    </div>
  </div>

  {{-- RINGKASAN --}}
  <div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
      <div class="card h-100 stat-card">
        <div class="card-body d-flex align-items-center">
          <span class="icon"><i class="fa-solid fa-id-card"></i></span>
          <div>
            <div class="text-muted small">Total KK</div>
            <div class="value">{{ $totalKK }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card h-100 stat-card">
        <div class="card-body d-flex align-items-center">
          <span class="icon"><i class="fa-solid fa-sitemap"></i></span>
          <div>
            <div class="text-muted small">Total RT</div>
            <div class="value">{{ $totalRT }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card h-100 stat-card">
        <div class="card-body d-flex align-items-center">
          <span class="icon"><i class="fa-solid fa-network-wired"></i></span>
          <div>
            <div class="text-muted small">Total RW</div>
            <div class="value">{{ $totalRW }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card h-100 stat-card">
        <div class="card-body d-flex align-items-center">
          <span class="icon"><i class="fa-solid fa-users"></i></span>
          <div>
            <div class="text-muted small">Total Warga</div>
            <div class="value">{{ $totalWarga }}</div>
            <div class="small text-muted">User: {{ $totalUser }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- LIST RINGKASAN --}}
  <div class="row g-3 mb-3">
    <div class="col-12 col-lg-6">
      <div class="card h-100">
        <div class="card-header py-2"><strong><i class="fa-solid fa-layer-group me-1"></i> Jumlah KK per RW</strong></div>
        <div class="card-body p-0">
          @if($byRw->isEmpty())
            <div class="text-center text-muted py-3">Tidak ada data RW.</div>
          @else
            <ul class="list-group list-group-flush">
              @foreach($byRw as $row)
                <li class="list-group-item d-flex justify-content-between">
                  <span>RW {{ $row->rw }}</span>
                  <span class="fw-semibold">{{ $row->total }}</span>
                </li>
              @endforeach
            </ul>
          @endif
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-6">
      <div class="card h-100">
        <div class="card-header py-2"><strong><i class="fa-solid fa-list-ol me-1"></i> Jumlah KK per RT</strong></div>
        <div class="card-body p-0">
          @if($byRt->isEmpty())
            <div class="text-center text-muted py-3">Tidak ada data RT.</div>
          @else
            <ul class="list-group list-group-flush">
              @foreach($byRt as $row)
                <li class="list-group-item d-flex justify-content-between">
                  <span>RT {{ $row->rt }}</span>
                  <span class="fw-semibold">{{ $row->total }}</span>
                </li>
              @endforeach
            </ul>
          @endif
        </div>
      </div>
    </div>
  </div>

  {{-- TABEL KK TERBARU --}}
  <div class="card">
    <div class="card-header py-2 d-flex justify-content-between">
      <strong><i class="fa-solid fa-clock-rotate-left me-1"></i> KK Terbaru</strong>
      <small class="text-muted">10 terakhir</small>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>No. KK</th>
              <th>Alamat</th>
              <th>RT</th>
              <th>RW</th>
              <th>Dibuat</th>
            </tr>
          </thead>
          <tbody>
            @forelse($kkTerbaru as $i => $kk)
              <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $kk->kk_nomor }}</td>
                <td class="text-truncate" style="max-width:420px;">{{ $kk->alamat }}</td>
                <td>{{ $kk->rt }}</td>
                <td>{{ $kk->rw }}</td>
                <td>{{ \Carbon\Carbon::parse($kk->created_at)->format('d M Y H:i') }}</td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center text-muted py-3">Tidak ada data.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div> {{-- penutup card KK Terbaru --}}



</div>
@endsection
