@extends('layouts.admin', ['title' => 'Data Pengukurans'])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Pengukuran</li>
@endsection

@section('actions')
    <a href="{{ route('pengukuran.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Input Pengukuran
    </a>
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white">
        <form action="{{ route('pengukuran.index') }}" method="GET" class="row g-2">
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Cari No/ID Gardu/User..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-primary w-100">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
            </div>
            @if(request('search'))
            <div class="col-md-2">
                <a href="{{ route('pengukuran.index') }}" class="btn btn-sm btn-outline-secondary w-100">
                    <i class="fas fa-undo me-1"></i> Reset
                </a>
            </div>
            @endif
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3">Waktu Ukur</th>
                        <th>Gardu</th>
                        <th>Beban Trafo</th>
                        <th>Unbalance</th>
                        <th>Petugas / User</th>
                        <th width="150" class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengukurans as $pengukuran)
                    <tr>
                        <td class="ps-3">
                            <div class="fw-bold">{{ \Carbon\Carbon::parse($pengukuran->tanggal_pengukuran)->translatedFormat('d M Y') }}</div>
                            <small class="text-muted"><i class="far fa-clock me-1"></i> {{ $pengukuran->jam_pengukuran }}</small>
                        </td>
                        <td>
                            <div class="fw-bold text-pln-blue">{{ $pengukuran->gardu->no_gardu }}</div>
                            <div class="small text-muted font-monospace">{{ $pengukuran->gardu->id_gardu }}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center mb-1">
                                <div class="progress flex-grow-1" style="height: 6px;">
                                    <div class="progress-bar {{ $pengukuran->beban_trafo_dist_persen > 80 ? 'bg-danger' : ($pengukuran->beban_trafo_dist_persen > 60 ? 'bg-warning' : 'bg-success') }}" 
                                         role="progressbar" style="width: {{ $pengukuran->beban_trafo_dist_persen }}%"></div>
                                </div>
                                <span class="ms-2 small fw-bold">{{ $pengukuran->beban_trafo_dist_persen }}%</span>
                            </div>
                            <small class="text-muted">{{ $pengukuran->beban_trafo_kva }} kVA</small>
                        </td>
                        <td>
                            <span class="badge {{ $pengukuran->unbalance_persen > 25 ? 'bg-danger-subtle text-danger' : 'bg-light text-dark border' }}">
                                {{ $pengukuran->unbalance_persen }}%
                            </span>
                        </td>
                        <td>
                            <div class="small fw-medium">{{ $pengukuran->user_input ?: 'System' }}</div>
                        </td>
                        <td class="text-center pe-3">
                            <div class="btn-group">
                                <a href="{{ route('pengukuran.show', $pengukuran->id) }}" class="btn btn-xs btn-outline-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('pengukuran.destroy', $pengukuran->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-outline-danger ms-1" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted bg-light">
                            <i class="fas fa-gauge-high fa-3x mb-3 d-block opacity-25"></i>
                            Belum ada data pengukuran.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($pengukurans->hasPages())
    <div class="card-footer bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="small text-muted">
                Menampilkan {{ $pengukurans->firstItem() }} sampai {{ $pengukurans->lastItem() }} dari {{ $pengukurans->total() }} data
            </div>
            <div class="pagination-sm">
                {{ $pengukurans->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    .btn-xs {
        padding: 0.125rem 0.35rem;
        font-size: 0.75rem;
    }
    .page-link {
        font-size: 0.8rem;
        padding: 0.3rem 0.6rem;
    }
</style>
@endsection
