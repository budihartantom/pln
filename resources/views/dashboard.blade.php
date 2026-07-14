@extends('layouts.admin', ['title' => 'Dashboard Overview'])

@section('content')
<div class="row g-4 mb-4">
    <!-- Stats Cards -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Gardu</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_gardu'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-bolt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pengukuran</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_pengukuran'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Perhitungan TOPSIS</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['last_topsis_run'] ? $stats['last_topsis_run']->created_at->format('d/m/Y') : '-' }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calculator fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Status Sistem</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Online</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Left Column: Alerts & Manual -->
    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-pln-blue">Peringatan Overload (>80%)</h6>
                <span class="badge bg-danger">{{ $overloaded->count() }} Gardu</span>
            </div>
            <div class="card-body">
                @forelse($overloaded as $item)
                <div class="d-flex align-items-center mb-3 p-2 border-start border-4 border-danger bg-light">
                    <div class="me-3">
                        <div class="icon-circle bg-danger text-white p-2 rounded-circle">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold">{{ $item->gardu->no_gardu }} - {{ $item->gardu->id_gardu }}</div>
                        <div class="small text-muted">Beban: {{ $item->beban_trafo_persen }}% ({{ $item->tanggal_pengukuran }})</div>
                    </div>
                    <a href="{{ route('pengukuran.show', $item->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-check-circle fa-3x mb-3 text-success opacity-25"></i>
                    <p>Tidak ada gardu yang overload saat ini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right Column: Recent Activity -->
    <div class="col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-white">
                <h6 class="m-0 font-weight-bold text-pln-blue">Riwayat Perhitungan TOPSIS</h6>
            </div>
            <div class="card-body">
                @forelse($stats['recent_runs'] as $run)
                <div class="mb-3 pb-3 border-bottom last-child-no-border">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-bold">#TOPSIS-{{ $run->id }}</div>
                            <small class="text-muted">{{ $run->created_at->diffForHumans() }}</small>
                        </div>
                        <a href="{{ route('topsis.show', $run->id) }}" class="btn btn-sm btn-link p-0">Lihat Hasil</a>
                    </div>
                    <div class="mt-1 small">
                        Oleh: {{ $run->creator->name }}
                    </div>
                </div>
                @empty
                <p class="text-center text-muted">Belum ada riwayat.</p>
                @endforelse
            </div>
        </div>

        <div class="card shadow bg-pln-blue text-white">
            <div class="card-body">
                <h5 class="fw-bold"><i class="fas fa-magic me-2"></i> Jalankan TOPSIS</h5>
                <p class="small">Mulai proses penentuan prioritas pemeliharaan berdasarkan data pengukuran terbaru.</p>
                <div class="d-grid">
                    <a href="{{ route('topsis.index') }}" class="btn btn-light fw-bold text-pln-blue">Mulai Perhitungan</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
