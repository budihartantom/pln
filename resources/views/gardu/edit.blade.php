@extends('layouts.admin', ['title' => 'Edit Data Gardu'])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('gardu.index') }}">Data Gardu</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
<form action="{{ route('gardu.update', $gardu->id) }}" method="POST">
    @csrf
    @method('PUT')
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
                            <input type="text" name="id_gardu" class="form-control @error('id_gardu') is-invalid @enderror" value="{{ old('id_gardu', $gardu->id_gardu) }}" required>
                            @error('id_gardu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No Gardu <span class="text-danger">*</span></label>
                            <input type="text" name="no_gardu" class="form-control @error('no_gardu') is-invalid @enderror" value="{{ old('no_gardu', $gardu->no_gardu) }}" required>
                            @error('no_gardu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Penyulang <span class="text-danger">*</span></label>
                            <input type="text" name="penyulang" class="form-control @error('penyulang') is-invalid @enderror" value="{{ old('penyulang', $gardu->penyulang) }}" required>
                            @error('penyulang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konstruksi <span class="text-danger">*</span></label>
                            <select name="kode_konstruksi" class="form-select @error('kode_konstruksi') is-invalid @enderror" required>
                                <option value="Gardu Portal" {{ old('kode_konstruksi', $gardu->kode_konstruksi) == 'Gardu Portal' ? 'selected' : '' }}>Gardu Portal</option>
                                <option value="Gardu Cantol" {{ old('kode_konstruksi', $gardu->kode_konstruksi) == 'Gardu Cantol' ? 'selected' : '' }}>Gardu Cantol</option>
                                <option value="Gardu Beton" {{ old('kode_konstruksi', $gardu->kode_konstruksi) == 'Gardu Beton' ? 'selected' : '' }}>Gardu Beton</option>
                            </select>
                            @error('kode_konstruksi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat', $gardu->alamat) }}">
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
                            <input type="number" name="tahun_pembuatan" class="form-control @error('tahun_pembuatan') is-invalid @enderror" value="{{ old('tahun_pembuatan', $gardu->tahun_pembuatan) }}" required>
                            @error('tahun_pembuatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Merk</label>
                            <input type="text" name="merk" class="form-control @error('merk') is-invalid @enderror" value="{{ old('merk', $gardu->merk) }}">
                            @error('merk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kapasitas (kVA) <span class="text-danger">*</span></label>
                            <input type="number" name="kapasitas_trafo_kva" class="form-control @error('kapasitas_trafo_kva') is-invalid @enderror" value="{{ old('kapasitas_trafo_kva', $gardu->kapasitas_trafo_kva) }}" required>
                            @error('kapasitas_trafo_kva') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No Seri</label>
                            <input type="text" name="no_seri" class="form-control @error('no_seri') is-invalid @enderror" value="{{ old('no_seri', $gardu->no_seri) }}">
                            @error('no_seri') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Pemilik <span class="text-danger">*</span></label>
                            <input type="text" name="status_pemilik" class="form-control @error('status_pemilik') is-invalid @enderror" value="{{ old('status_pemilik', $gardu->status_pemilik) }}" required>
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
                        <label class="form-label">UP3</label>
                        <input type="text" class="form-control" value="TANJUNG KARANG" readonly>
                        <input type="hidden" name="id_up3" value="17171">
                        <input type="hidden" name="up3" value="TANJUNG KARANG">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ID ULP <span class="text-danger">*</span></label>
                        <input type="text" name="id_ulp" class="form-control @error('id_ulp') is-invalid @enderror" value="{{ old('id_ulp', $gardu->id_ulp) }}" required>
                        @error('id_ulp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ULP <span class="text-danger">*</span></label>
                        <input type="text" name="ulp" class="form-control @error('ulp') is-invalid @enderror" value="{{ old('ulp', $gardu->ulp) }}" required>
                        @error('ulp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i> Perbarui Data
                </button>
                <a href="{{ route('gardu.index') }}" class="btn btn-light border">Batal</a>
            </div>
        </div>
    </div>
</form>
@endsection
