@extends('layouts.admin', ['title' => 'Data Gardu'])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Data Gardu</li>
@endsection

@section('actions')
    <a href="{{ route('gardu.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Tambah Gardu
    </a>
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white">
        <form action="{{ route('gardu.index') }}" method="GET" class="row g-2">
            <div class="col-md-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Cari No/ID/Alamat..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select name="ulp" class="form-select form-select-sm">
                    <option value="">Semua ULP</option>
                    @foreach($ulps as $ulp)
                    <option value="{{ $ulp }}" {{ request('ulp') == $ulp ? 'selected' : '' }}>{{ $ulp }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="penyulang" class="form-select form-select-sm">
                    <option value="">Semua Penyulang</option>
                    @foreach($penyulangs as $p)
                    <option value="{{ $p }}" {{ request('penyulang') == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    @foreach($statusList as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary flex-grow-1">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                @if(request()->anyFilled(['search', 'ulp', 'penyulang', 'status']))
                <a href="{{ route('gardu.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-undo me-1"></i> Reset
                </a>
                @endif
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="50" class="ps-3">No</th>
                        <th>Identitas Gardu</th>
                        <th>ULP & Penyulang</th>
                        <th>Detail Trafo</th>
                        <th>Konstruksi</th>
                        <th width="150" class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gardus as $index => $gardu)
                    <tr>
                        <td class="ps-3">{{ $gardus->firstItem() + $index }}</td>
                        <td>
                            <div class="fw-bold text-pln-blue">{{ $gardu->no_gardu }}</div>
                            <div class="small font-monospace text-muted">{{ $gardu->id_gardu }}</div>
                            @if($gardu->alamat)
                            <div class="small text-truncate" style="max-width: 200px;" title="{{ $gardu->alamat }}">
                                <i class="fas fa-location-dot me-1 text-danger"></i> {{ $gardu->alamat }}
                            </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-medium">{{ $gardu->ulp ?? '-' }}</div>
                            <div class="small badge bg-secondary-subtle text-secondary border">{{ $gardu->penyulang ?? '-' }}</div>
                        </td>
                        <td>
                            <div class="small"><b>Merk:</b> {{ $gardu->merk ?: '-' }}</div>
                            <div class="small"><b>Kapasitas:</b> {{ $gardu->kapasitas_trafo_kva ?: 0 }} kVA</div>
                            <div class="small"><b>Tahun:</b> {{ $gardu->tahun_pembuatan ?: '-' }}</div>
                        </td>
                        <td>
                            <span class="badge bg-info-subtle text-info border border-info-subtle">{{ $gardu->kode_konstruksi ?: '-' }}</span>
                            <div class="small text-muted mt-1">{{ $gardu->status_pemilik }}</div>
                        </td>
                        <td class="text-center pe-3">
                            <div class="btn-group">
                                <a href="{{ route('gardu.show', $gardu->id) }}" class="btn btn-xs btn-outline-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('gardu.edit', $gardu->id) }}" class="btn btn-xs btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('gardu.destroy', $gardu->id) }}" method="POST" onsubmit="return confirm('Hapus data gardu ini?')">
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
                            <i class="fas fa-bolt fa-3x mb-3 d-block opacity-25"></i>
                            Data tidak ditemukan. Cobalah kata kunci lain.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($gardus->hasPages())
    <div class="card-footer bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="small text-muted">
                Menampilkan {{ $gardus->firstItem() }} sampai {{ $gardus->lastItem() }} dari {{ $gardus->total() }} data
            </div>
            <div class="pagination-sm">
                {{ $gardus->links() }}
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
    .pagination {
        margin-bottom: 0;
    }
    .page-link {
        font-size: 0.8rem;
        padding: 0.3rem 0.6rem;
    }
</style>
@endsection
