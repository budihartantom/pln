@extends('layouts.admin')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Laporan</li>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 border-start border-success border-4">
            <div class="card-body py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-1 fw-bold text-gray-800"><i class="fas fa-file-alt me-2 text-success"></i> Laporan Riwayat Pemeliharaan</h5>
                        <p class="mb-0 text-muted small">Cetak dan filter riwayat hasil perhitungan metode TOPSIS.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">Filter Laporan</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('topsis.laporan.index') }}" method="GET" class="row align-items-end">
            <div class="col-md-4 mb-3">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="end_date" class="form-label">Tanggal Selesai</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-4 mb-3">
                <button type="submit" class="btn btn-success me-2">
                    <i class="fas fa-search me-1"></i> Filter
                </button>
                <a href="{{ route('topsis.laporan.index') }}" class="btn btn-light">
                    <i class="fas fa-sync me-1"></i> Reset
                </a>
                <button type="button" onclick="window.print()" class="btn btn-outline-secondary float-end">
                    <i class="fas fa-print me-1"></i> Cetak
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="bg-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="15%">ID Proses</th>
                        <th>Tanggal Hitung</th>
                        <th>Periode Data</th>
                        <th>Catatan</th>
                        <th>Operator</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($runs as $index => $run)
                    <tr>
                        <td class="text-center">{{ $runs->firstItem() + $index }}</td>
                        <td><span class="badge bg-secondary">#TOPSIS-{{ $run->id }}</span></td>
                        <td>{{ $run->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($run->periode_mulai)->format('M Y') }} - 
                            {{ \Carbon\Carbon::parse($run->periode_selesai)->format('M Y') }}
                        </td>
                        <td><small class="text-muted">{{ Str::limit($run->catatan, 50) ?: '-' }}</small></td>
                        <td>{{ $run->creator->name }}</td>
                        <td class="text-center">
                            <a href="{{ route('topsis.show', $run->id) }}" class="btn btn-sm btn-info text-white" target="_blank" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="fas fa-folder-open fs-2 mb-3 d-block"></i>
                            Tidak ada data laporan ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-end mt-3">
            {{ $runs->withQueryString()->links() }}
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    @media print {
        #sidebar, .navbar, .breadcrumb, form, .btn, footer {
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
        .card-header {
            background-color: transparent !important;
            border-bottom: 2px solid #000 !important;
        }
    }
</style>
@endpush
