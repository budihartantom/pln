@extends('layouts.admin', ['title' => 'Tambah Data Gardu'])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('gardu.index') }}">Data Gardu</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
@endsection

@section('content')
<form action="{{ route('gardu.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Utama</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">ID Gardu <span class="text-danger">*</span></label>
                            <input type="text" name="id_gardu" class="form-control @error('id_gardu') is-invalid @enderror" value="{{ old('id_gardu') }}" required placeholder="Contoh: 17GD0110000008">
                            @error('id_gardu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No Gardu <span class="text-danger">*</span></label>
                            <input type="text" name="no_gardu" class="form-control @error('no_gardu') is-invalid @enderror" value="{{ old('no_gardu') }}" required placeholder="Contoh: KRGK0543">
                            @error('no_gardu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Penyulang <span class="text-danger">*</span></label>
                            <input type="text" name="penyulang" class="form-control @error('penyulang') is-invalid @enderror" value="{{ old('penyulang') }}" required>
                            @error('penyulang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konstruksi <span class="text-danger">*</span></label>
                            <select name="kode_konstruksi" class="form-select @error('kode_konstruksi') is-invalid @enderror" required>
                                <option value="">Pilih...</option>
                                <option value="Gardu Portal" {{ old('kode_konstruksi') == 'Gardu Portal' ? 'selected' : '' }}>Gardu Portal</option>
                                <option value="Gardu Cantol" {{ old('kode_konstruksi') == 'Gardu Cantol' ? 'selected' : '' }}>Gardu Cantol</option>
                                <option value="Gardu Beton" {{ old('kode_konstruksi') == 'Gardu Beton' ? 'selected' : '' }}>Gardu Beton</option>
                            </select>
                            @error('kode_konstruksi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') }}">
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Spesifikasi Teknis</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Tahun Pembuatan <span class="text-danger">*</span></label>
                            <input type="number" name="tahun_pembuatan" class="form-control @error('tahun_pembuatan') is-invalid @enderror" value="{{ old('tahun_pembuatan', date('Y')) }}" required>
                            @error('tahun_pembuatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Merk</label>
                            <input type="text" name="merk" class="form-control @error('merk') is-invalid @enderror" value="{{ old('merk') }}">
                            @error('merk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kapasitas (kVA) <span class="text-danger">*</span></label>
                            <input type="number" name="kapasitas_trafo_kva" class="form-control @error('kapasitas_trafo_kva') is-invalid @enderror" value="{{ old('kapasitas_trafo_kva') }}" required>
                            @error('kapasitas_trafo_kva') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No Seri</label>
                            <input type="text" name="no_seri" class="form-control @error('no_seri') is-invalid @enderror" value="{{ old('no_seri') }}">
                            @error('no_seri') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Pemilik <span class="text-danger">*</span></label>
                            <input type="text" name="status_pemilik" class="form-control @error('status_pemilik') is-invalid @enderror" value="{{ old('status_pemilik', '1 - PLN') }}" required>
                            @error('status_pemilik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Organisasi</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">UP3 <span class="text-danger">*</span></label>
                        <input type="hidden" name="id_up3" value="17171">
                        <input type="text" name="up3" class="form-control" value="TANJUNG KARANG" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ID ULP <span class="text-danger">*</span></label>
                        <input type="text" name="id_ulp" class="form-control @error('id_ulp') is-invalid @enderror" value="{{ old('id_ulp', '17100') }}" required>
                        @error('id_ulp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ULP <span class="text-danger">*</span></label>
                        <input type="text" name="ulp" class="form-control @error('ulp') is-invalid @enderror" value="{{ old('ulp', 'KARANG') }}" required>
                        @error('ulp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i> Simpan Data
                </button>
                <a href="{{ route('gardu.index') }}" class="btn btn-light border">Batal</a>
            </div>
        </div>
    </div>
</form>
@endsection
