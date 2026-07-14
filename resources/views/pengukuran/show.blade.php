@extends('layouts.admin', ['title' => 'Detail Pengukuran'])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('pengukuran.index') }}">Pengukuran</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-white">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Gardu</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr><th width="120">No Gardu</th><td>: {{ $pengukuran->gardu->no_gardu }}</td></tr>
                    <tr><th>ID Gardu</th><td>: {{ $pengukuran->gardu->id_gardu }}</td></tr>
                    <tr><th>Penyulang</th><td>: {{ $pengukuran->gardu->penyulang }}</td></tr>
                    <tr><th>ULP</th><td>: {{ $pengukuran->gardu->ulp }}</td></tr>
                    <tr><th>Tahun Buat</th><td>: {{ $pengukuran->gardu->tahun_pembuatan }}</td></tr>
                </table>
                <hr>
                <div class="small text-muted">
                    Input By: {{ $pengukuran->creator->name ?? '-' }}<br>
                    Note: {{ $pengukuran->user_input ?: '-' }}
                </div>
            </div>
        </div>

        <div class="card shadow mb-4 text-white {{ $pengukuran->beban_trafo_persen > 80 ? 'bg-danger' : 'bg-success' }}">
            <div class="card-body text-center">
                <h6 class="text-uppercase small opacity-75">Beban Trafo</h6>
                <div class="display-4 fw-bold">{{ number_format($pengukuran->beban_trafo_persen, 1) }}%</div>
                <p class="mb-0">{{ $pengukuran->beban_trafo_kva }} kVA / {{ $pengukuran->gardu->kapasitas_trafo_kva }} kVA</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-white">
                <h6 class="m-0 font-weight-bold text-primary">Parameter Monitoring TOPSIS</h6>
            </div>
            <div class="card-body">
                <div class="row text-center py-2">
                    <div class="col-4 border-end">
                        <small class="text-muted d-block text-uppercase fw-bold mb-1">Unbalance</small>
                        <span class="h4 fw-bold text-dark">{{ $pengukuran->unbalance_persen }}%</span>
                    </div>
                    <div class="col-4 border-end">
                        <small class="text-muted d-block text-uppercase fw-bold mb-1">Tegangan F-N</small>
                        <span class="h4 fw-bold text-dark">{{ $pengukuran->tegangan_fn_rata2 }} V</span>
                    </div>
                    <div class="col-4">
                        <small class="text-muted d-block text-uppercase fw-bold mb-1">Cos Phi</small>
                        <span class="h4 fw-bold text-dark">{{ number_format($pengukuran->cosphi_rata2, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-white">
                <h6 class="m-0 font-weight-bold text-primary">Timeline Pengukuran</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-0">
                    <div class="icon-circle bg-light me-3">
                        <i class="fas fa-calendar text-primary"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Waktu Inspeksi</div>
                        <div class="fw-bold">{{ Carbon\Carbon::parse($pengukuran->tanggal_pengukuran)->translatedFormat('l, d F Y') }}</div>
                        <div class="small">Jam: {{ $pengukuran->jam_pengukuran }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mb-5">
    <a href="{{ route('pengukuran.index') }}" class="btn btn-light border">Kembali</a>
    @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
    <form action="{{ route('pengukuran.destroy', $pengukuran->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus Data</button>
    </form>
    @endif
</div>
@endsection
