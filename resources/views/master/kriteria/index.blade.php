@extends('layouts.admin', ['title' => 'Master Kriteria TOPSIS'])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Kriteria TOPSIS</li>
@endsection

@section('actions')
    <a href="{{ route('kriteria.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Tambah Kriteria
    </a>
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th width="80">Kode</th>
                        <th>Kriteria</th>
                        <th width="100">Tipe</th>
                        <th width="100">Satuan</th>
                        <th width="100">Bobot</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kriterias as $index => $kriteria)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge bg-secondary font-monospace">{{ $kriteria->kode }}</span></td>
                        <td>
                            <div class="fw-bold">{{ $kriteria->nama }}</div>
                            <small class="text-muted">{{ $kriteria->deskripsi ?? '-' }}</small>
                        </td>
                        <td>
                            @if($kriteria->tipe == 'benefit')
                                <span class="badge bg-success">Benefit</span>
                            @else
                                <span class="badge bg-danger">Cost</span>
                            @endif
                        </td>
                        <td>{{ $kriteria->satuan ?? '-' }}</td>
                        <td class="fw-bold">{{ number_format($kriteria->currentBobot->bobot ?? 0, 2) }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('kriteria.edit', $kriteria->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('kriteria.destroy', $kriteria->id) }}" method="POST" onsubmit="return confirm('Hapus kriteria ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger ms-1">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                            Belum ada data kriteria.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($kriterias->count() > 0)
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td colspan="5" class="text-end">Total Bobot</td>
                        <td>{{ number_format($kriterias->sum(fn($k) => $k->currentBobot->bobot ?? 0), 2) }}</td>
                        <td>
                            @if(abs($kriterias->sum(fn($k) => $k->currentBobot->bobot ?? 0) - 1.0) > 0.0001)
                                <span class="text-danger small"><i class="fas fa-triangle-exclamation"></i> Wajib 1.00</span>
                            @else
                                <span class="text-success small"><i class="fas fa-check-circle"></i> Valid</span>
                            @endif
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
