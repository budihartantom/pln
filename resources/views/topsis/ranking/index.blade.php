@extends('layouts.admin')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ranking Prioritas</li>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 border-start border-primary border-4">
            <div class="card-body py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-1 fw-bold text-gray-800"><i class="fas fa-ranking-star me-2 text-primary"></i> Ranking Prioritas Pemeliharaan</h5>
                        <p class="mb-0 text-muted small">Menampilkan hasil ranking terbaru dari perhitungan metode TOPSIS.</p>
                    </div>
                    @if($latestRun)
                    <div class="text-end d-none d-md-block">
                        <span class="badge bg-light text-dark border"><i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($latestRun->periode_mulai)->format('M Y') }} - {{ \Carbon\Carbon::parse($latestRun->periode_selesai)->format('M Y') }}</span>
                        <div class="small mt-1 text-muted">ID: #TOPSIS-{{ $latestRun->id }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($latestRun)
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Hasil Ranking TOPSIS Terkini</h6>
            <button onclick="window.print()" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-print me-1"></i> Cetak
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%" class="text-center">Rank</th>
                            <th width="15%">ID Gardu</th>
                            <th>Nama Gardu</th>
                            <th>Lokasi</th>
                            <th width="15%" class="text-center">Nilai Preferensi (V)</th>
                            <th width="15%" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestRun->details->sortByDesc('nilai_preferensi')->values() as $index => $detail)
                        <tr>
                            <td class="text-center font-weight-bold">
                                @if($index == 0)
                                    <span class="badge bg-danger rounded-circle p-2">{{ $index + 1 }}</span>
                                @elseif($index == 1)
                                    <span class="badge bg-warning text-dark rounded-circle p-2">{{ $index + 1 }}</span>
                                @elseif($index == 2)
                                    <span class="badge bg-info rounded-circle p-2">{{ $index + 1 }}</span>
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </td>
                            <td><span class="font-monospace">{{ $detail->gardu->id_gardu }}</span></td>
                            <td class="fw-bold">{{ $detail->gardu->no_gardu }}</td>
                            <td>{{ $detail->gardu->up3 }} / {{ $detail->gardu->ulp }}</td>
                            <td class="text-center">
                                <strong>{{ number_format($detail->nilai_preferensi, 4) }}</strong>
                            </td>
                            <td class="text-center">
                                @if($index < 3)
                                    <span class="badge bg-danger">Prioritas Tinggi</span>
                                @elseif($index < 10)
                                    <span class="badge bg-warning text-dark">Prioritas Sedang</span>
                                @else
                                    <span class="badge bg-success">Prioritas Rendah</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3 text-muted small">
                <i class="fas fa-info-circle me-1"></i> Gardu dengan nilai preferensi (V) tertinggi merupakan prioritas utama untuk dilakukan pemeliharaan.
            </div>
        </div>
    </div>
@else
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i> Belum ada data perhitungan TOPSIS. Silakan jalankan perhitungan terlebih dahulu.
        <br><br>
        <a href="{{ route('topsis.index') }}" class="btn btn-primary btn-sm">Jalankan TOPSIS</a>
    </div>
@endif

@endsection

@push('styles')
<style>
    @media print {
        #sidebar, .navbar, .breadcrumb, .btn-toolbar, .btn, footer {
            display: none !important;
        }
        #content {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>
@endpush
