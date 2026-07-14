@extends('layouts.admin')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Kelola User</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah User</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Form Tambah User</h6>
                <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role / Level Akses <span class="text-danger">*</span></label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Full Access)</option>
                            <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager (Lihat Laporan & Ranking)</option>
                            <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operator (Input Data & Hitung TOPSIS)</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">
                    <h6 class="font-weight-bold mb-3">Pengaturan Password</h6>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        <div class="form-text">Minimal 8 karakter.</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="reset" class="btn btn-secondary me-2">Reset</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">Informasi Role</h6>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item px-0">
                        <strong><span class="badge bg-danger mb-1">Admin</span></strong><br>
                        Memiliki hak akses penuh. Dapat mengelola master data (kriteria, gardu, user), mengelola pengukuran, melakukan perhitungan TOPSIS, dan melihat semua laporan.
                    </li>
                    <li class="list-group-item px-0">
                        <strong><span class="badge bg-success mb-1">Operator</span></strong><br>
                        Bertugas dalam operasional lapangan. Dapat mengelola data gardu, menginput hasil pengukuran, dan melakukan perhitungan TOPSIS. Tidak dapat mengakses kelola user atau kriteria.
                    </li>
                    <li class="list-group-item px-0">
                        <strong><span class="badge bg-info mb-1">Manager</span></strong><br>
                        Hanya memiliki hak akses untuk melihat hasil perhitungan TOPSIS, mengecek ranking prioritas pemeliharaan, dan mencetak laporan historis.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
