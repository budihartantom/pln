@extends('layouts.admin', ['title' => 'Riwayat Perhitungan TOPSIS'])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Riwayat TOPSIS</li>
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Tanggal Hitung</th>
                        <th>Periode Data</th>
                        <th>Catatan</th>
                        <th>Oleh</th>
                        <th width="120" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($runs as $index => $run)
                    <tr>
                        <td>{{ $runs->firstItem() + $index }}</td>
                        <td class="fw-bold">{{ $run->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $run->periode_mulai }}</span>
                            <i class="fas fa-arrow-right mx-1 small text-muted"></i>
                            <span class="badge bg-light text-dark border">{{ $run->periode_selesai }}</span>
                        </td>
                        <td><small class="text-muted">{{ Str::limit($run->catatan, 50) ?: '-' }}</small></td>
                        <td>{{ $run->creator->name }}</td>
                        <td class="text-center">
                            <a href="{{ route('topsis.show', $run->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada riwayat perhitungan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $runs->links() }}
        </div>
    </div>
</div>
@endsection
