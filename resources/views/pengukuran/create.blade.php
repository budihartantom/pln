@extends('layouts.admin', ['title' => 'Input Pengukuran'])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('pengukuran.index') }}">Pengukuran</a></li>
    <li class="breadcrumb-item active" aria-current="page">Input</li>
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white">
        <h6 class="m-0 font-weight-bold text-primary">Form Pengukuran Baru</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('pengukuran.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Pilih Gardu <span class="text-danger">*</span></label>
                    <select name="gardu_id" class="form-select @error('gardu_id') is-invalid @enderror" required>
                        <option value="">Pilih...</option>
                        @foreach($gardus as $gardu)
                        <option value="{{ $gardu->id }}" {{ (old('gardu_id') ?? $selectedGarduId) == $gardu->id ? 'selected' : '' }}>
                            {{ $gardu->no_gardu }} - {{ $gardu->id_gardu }} ({{ $gardu->penyulang }})
                        </option>
                        @endforeach
                    </select>
                    @error('gardu_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_pengukuran" class="form-control @error('tanggal_pengukuran') is-invalid @enderror" value="{{ old('tanggal_pengukuran', date('Y-m-d')) }}" required>
                    @error('tanggal_pengukuran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jam <span class="text-danger">*</span></label>
                    <input type="time" name="jam_pengukuran" class="form-control @error('jam_pengukuran') is-invalid @enderror" value="{{ old('jam_pengukuran', date('H:i')) }}" required>
                    @error('jam_pengukuran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 mt-4">
                    <h5 class="border-bottom pb-2">Nilai Parameter Listrik</h5>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Beban Trafo (kVA) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="beban_trafo_kva" class="form-control @error('beban_trafo_kva') is-invalid @enderror" value="{{ old('beban_trafo_kva') }}" required>
                    @error('beban_trafo_kva') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Beban Trafo (%) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="beban_trafo_persen" class="form-control @error('beban_trafo_persen') is-invalid @enderror" value="{{ old('beban_trafo_persen') }}" required>
                        <span class="input-group-text">%</span>
                    </div>
                    @error('beban_trafo_persen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Unbalance (%) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="unbalance_persen" class="form-control @error('unbalance_persen') is-invalid @enderror" value="{{ old('unbalance_persen') }}" required>
                        <span class="input-group-text">%</span>
                    </div>
                    @error('unbalance_persen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tegangan F-N Rata-rata (V) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="tegangan_fn_rata2" class="form-control @error('tegangan_fn_rata2') is-invalid @enderror" value="{{ old('tegangan_fn_rata2') }}" required>
                        <span class="input-group-text">V</span>
                    </div>
                    @error('tegangan_fn_rata2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cosphi Rata-rata <span class="text-danger">*</span></label>
                    <input type="number" step="0.001" name="cosphi_rata2" class="form-control @error('cosphi_rata2') is-invalid @enderror" value="{{ old('cosphi_rata2') }}" required placeholder="Contoh: 0.95">
                    @error('cosphi_rata2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 mt-3">
                    <label class="form-label">Catatan / User Input</label>
                    <textarea name="user_input" class="form-control" rows="2" placeholder="Informasi tambahan pemeriksaan...">{{ old('user_input') }}</textarea>
                </div>

                <div class="col-12 mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i> Simpan Pengukuran
                    </button>
                    <a href="{{ route('pengukuran.index') }}" class="btn btn-light border">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
