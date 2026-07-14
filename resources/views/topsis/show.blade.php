@extends('layouts.admin', ['title' => 'Hasil Perhitungan TOPSIS'])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('topsis.history') }}">Riwayat</a></li>
    <li class="breadcrumb-item active" aria-current="page">Hasil Perhitungan</li>
@endsection

@section('actions')
    <a href="{{ route('topsis.history') }}" class="btn btn-outline-secondary">
        <i class="fas fa-list me-2"></i> Kembali ke Riwayat
    </a>
    <button onclick="window.print()" class="btn btn-outline-primary ms-2 d-none d-md-inline">
        <i class="fas fa-print me-2"></i> Cetak Hasil
    </a>
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm table-borderless">
                    <tr>
                        <th width="150">ID Perhitungan</th>
                        <td>#TOPSIS-{{ str_pad($run->id, 5, '0', STR_PAD_LEFT) }}</td>
                    </tr>
                    <tr>
                        <th>Periode Data</th>
                        <td>{{ $run->periode_mulai }} s/d {{ $run->periode_selesai }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat Oleh</th>
                        <td>{{ $run->creator->name }} pada {{ $run->created_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6 border-start">
                <p class="small text-muted mb-1">Catatan:</p>
                <p>{{ $run->catatan ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Alternatif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $run->details->count() }} Gardu</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-bolt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow border-left-success h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Kriteria</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $run->normalizedDetails->groupBy('kriteria_id')->count() }} Kriteria</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-list-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow border-left-info h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Data Penilaian</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $run->normalizedDetails->count() }} Data</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-database fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<ul class="nav nav-pills mb-4" id="topsisTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="ranking-tab" data-bs-toggle="pill" data-bs-target="#ranking" type="button">1. Ranking Prioritas</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="matrix-tab" data-bs-toggle="pill" data-bs-target="#matrix" type="button">2. Matriks Keputusan (X)</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="normalization-tab" data-bs-toggle="pill" data-bs-target="#normalization" type="button">3. Normalisasi & Terbobot (R & Y)</button>
    </li>
</ul>

<div class="tab-content" id="topsisTabContent">
    <!-- Tab 1: Ranking -->
    <div class="tab-pane fade show active" id="ranking" role="tabpanel">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="80">Ranking</th>
                                <th>Gardu</th>
                                <th>UP3 / ULP</th>
                                <th>Jarak Ideal (D+, D-)</th>
                                <th>Preferensi (V)</th>
                                <th width="100">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($run->details as $detail)
                            <tr class="{{ $detail->ranking <= 3 ? 'table-warning' : '' }}">
                                <td class="text-center fw-bold">
                                    @if($detail->ranking == 1) <i class="fas fa-crown text-warning"></i> @endif
                                    {{ $detail->ranking }}
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $detail->gardu->no_gardu }}</div>
                                    <small class="text-muted">{{ $detail->gardu->id_gardu }}</small>
                                </td>
                                <td>
                                    <div>{{ $detail->gardu->up3 }}</div>
                                    <small>{{ $detail->gardu->ulp }}</small>
                                </td>
                                <td>
                                    <div><small>D+: {{ number_format($detail->d_plus, 4) }}</small></div>
                                    <div><small>D-: {{ number_format($detail->d_min, 4) }}</small></div>
                                </td>
                                <td class="fw-bold text-pln-blue">{{ number_format($detail->nilai_preferensi, 4) }}</td>
                                <td>
                                    @if($detail->ranking <= 5)
                                        <span class="badge bg-danger">Prioritas Utama</span>
                                    @else
                                        <span class="badge bg-secondary">Prioritas Rendah</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab 2: Decision Matrix -->
    <div class="tab-pane fade" id="matrix" role="tabpanel">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light text-center small">
                            <tr>
                                <th rowspan="2">Alternatif</th>
                                <th colspan="{{ $run->normalizedDetails->groupBy('kriteria_id')->count() }}">Kriteria</th>
                            </tr>
                            <tr>
                                @foreach($run->normalizedDetails->groupBy('kriteria_id') as $kId => $group)
                                <th>{{ $group[0]->kriteria->kode }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="small">
                            @foreach($run->details as $detail)
                            <tr>
                                <td class="fw-bold">{{ $detail->gardu->no_gardu }}</td>
                                @foreach($run->normalizedDetails->where('gardu_id', $detail->gardu_id) as $norm)
                                <td class="text-center">{{ number_format($norm->nilai_x, 2) }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab 3: Normalization -->
    <div class="tab-pane fade" id="normalization" role="tabpanel">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light text-center small">
                            <tr>
                                <th>Alternatif</th>
                                @foreach($run->normalizedDetails->groupBy('kriteria_id') as $kId => $group)
                                <th>{{ $group[0]->kriteria->kode }}<br><small class="text-muted">(W={{ number_format($run->normalizedDetails->where('kriteria_id', $kId)->first()->weight ?? ($run->normalizedDetails->where('kriteria_id', $kId)->first()->kontribusi / max($run->normalizedDetails->where('kriteria_id', $kId)->first()->nilai_r, 0.0001)), 2) }})</small></th>
                                @endforeach
                                <th>D+ / D- / V</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @foreach($run->details as $detail)
                            <tr>
                                <td class="fw-bold">{{ $detail->gardu->no_gardu }}</td>
                                @foreach($run->normalizedDetails->where('gardu_id', $detail->gardu_id) as $norm)
                                <td class="text-center bg-light">
                                    <div class="font-monospace" title="Nilai Normalisasi (R)">R: {{ number_format($norm->nilai_r, 4) }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;" title="Nilai Terbobot (Y)">Y: {{ number_format($norm->kontribusi, 4) }}</div>
                                </td>
                                @endforeach
                                <td class="text-center table-info">
                                    <div class="small">D+: {{ number_format($detail->d_plus, 4) }}</div>
                                    <div class="small">D-: {{ number_format($detail->d_min, 4) }}</div>
                                    <div class="fw-bold mt-1">V: {{ number_format($detail->nilai_preferensi, 4) }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
