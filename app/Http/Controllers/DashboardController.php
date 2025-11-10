<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warga;
use App\Models\KeluargaKk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Kalau butuh proteksi login:
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Filter opsional by RT/RW via query string ?rt=&rw=
        $rt = $request->query('rt');
        $rw = $request->query('rw');

        $kkQuery = KeluargaKk::query()
            ->when($rt, fn ($q) => $q->where('rt', $rt))
            ->when($rw, fn ($q) => $q->where('rw', $rw));

        // Ringkasan
        $totalKK    = (clone $kkQuery)->count();
        $totalRT    = (clone $kkQuery)->distinct('rt')->count('rt');
        $totalRW    = (clone $kkQuery)->distinct('rw')->count('rw');
        $totalWarga = Warga::count();
        $totalUser  = User::count();

        // KK terbaru
        $kkTerbaru = (clone $kkQuery)
            ->orderByDesc('kk_id')
            ->limit(10)
            ->get(['kk_id','kk_nomor','alamat','rt','rw','created_at']);

        // Distribusi untuk tabel/chart
        $byRw = (clone $kkQuery)
            ->selectRaw('rw, COUNT(*) as total')
            ->groupBy('rw')
            ->orderBy('rw')
            ->get();

        $byRt = (clone $kkQuery)
            ->selectRaw('rt, COUNT(*) as total')
            ->groupBy('rt')
            ->orderBy('rt')
            ->get();

        // Data siap untuk chart (opsional)
        $chartRw = [
            'labels' => $byRw->pluck('rw')->map(fn ($v) => 'RW '.$v),
            'data'   => $byRw->pluck('total'),
        ];
        $chartRt = [
            'labels' => $byRt->pluck('rt')->map(fn ($v) => 'RT '.$v),
            'data'   => $byRt->pluck('total'),
        ];

        return view('pages.dashboard', [
            'filters'   => ['rt' => $rt, 'rw' => $rw],
            'totalKK'   => $totalKK,
            'totalRT'   => $totalRT,
            'totalRW'   => $totalRW,
            'totalWarga'=> $totalWarga,
            'totalUser' => $totalUser,
            'kkTerbaru' => $kkTerbaru,
            'byRw'      => $byRw,
            'byRt'      => $byRt,
            'chartRw'   => $chartRw,
            'chartRt'   => $chartRt,
        ]);
    }
}
