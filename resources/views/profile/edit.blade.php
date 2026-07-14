@extends('layouts.admin')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Profile</li>
@endsection

@section('content')
<div class="row">
    <!-- Left Column: User Profile Card -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm border-0 rounded-4 profile-card text-center">
            <div class="card-body p-5">
                <div class="avatar-circle mx-auto mb-4 bg-primary bg-gradient shadow">
                    <span class="text-white fs-1 fw-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                </div>
                <h4 class="fw-bold mb-1 text-gray-800">{{ auth()->user()->name }}</h4>
                <p class="text-muted mb-3">{{ auth()->user()->email }}</p>
                
                @if(auth()->user()->role === 'admin')
                    <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="fas fa-shield-alt me-1"></i> Administrator</span>
                @elseif(auth()->user()->role === 'manager')
                    <span class="badge bg-info text-dark px-3 py-2 rounded-pill"><i class="fas fa-user-tie me-1"></i> Manager</span>
                @else
                    <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fas fa-user-cog me-1"></i> Operator</span>
                @endif
                
                <hr class="my-4">
                <div class="d-flex justify-content-center text-muted small">
                    <div>
                        <i class="far fa-calendar-alt me-1"></i> Bergabung sejak {{ auth()->user()->created_at->format('M Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Edit Forms -->
    <div class="col-lg-8">
        <!-- Profile Information Form -->
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold text-gray-800 mb-0"><i class="fas fa-user-edit text-primary me-2"></i> Informasi Profil</h5>
                <p class="text-muted small mt-1">Perbarui informasi profil dan alamat email akun Anda.</p>
            </div>
            <div class="card-body p-4">
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                            <input type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                            <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-2 text-warning small">
                                <i class="fas fa-exclamation-triangle me-1"></i> Email Anda belum diverifikasi.
                                <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline text-decoration-none">
                                    Kirim ulang email verifikasi.
                                </button>
                            </div>
                            @if (session('status') === 'verification-link-sent')
                                <div class="mt-2 text-success small fw-medium">
                                    <i class="fas fa-check-circle me-1"></i> Link verifikasi baru telah dikirim ke email Anda.
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>

                        @if (session('status') === 'profile-updated')
                            <span class="text-success ms-3 fw-medium fade-out">
                                <i class="fas fa-check-circle me-1"></i> Tersimpan.
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Update Password Form -->
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold text-gray-800 mb-0"><i class="fas fa-lock text-warning me-2"></i> Ubah Password</h5>
                <p class="text-muted small mt-1">Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.</p>
            </div>
            <div class="card-body p-4">
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label for="update_password_current_password" class="form-label fw-semibold">Password Saat Ini</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-key text-muted"></i></span>
                            <input type="password" class="form-control border-start-0 @if($errors->updatePassword->has('current_password')) is-invalid @endif" id="update_password_current_password" name="current_password" autocomplete="current-password">
                            @if($errors->updatePassword->has('current_password'))
                                <div class="invalid-feedback">{{ $errors->updatePassword->first('current_password') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="update_password_password" class="form-label fw-semibold">Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-shield-alt text-muted"></i></span>
                            <input type="password" class="form-control border-start-0 @if($errors->updatePassword->has('password')) is-invalid @endif" id="update_password_password" name="password" autocomplete="new-password">
                            @if($errors->updatePassword->has('password'))
                                <div class="invalid-feedback">{{ $errors->updatePassword->first('password') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="update_password_password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-check-double text-muted"></i></span>
                            <input type="password" class="form-control border-start-0 @if($errors->updatePassword->has('password_confirmation')) is-invalid @endif" id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password">
                            @if($errors->updatePassword->has('password_confirmation'))
                                <div class="invalid-feedback">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-warning rounded-pill px-4 shadow-sm text-dark fw-medium">
                            <i class="fas fa-key me-1"></i> Update Password
                        </button>

                        @if (session('status') === 'password-updated')
                            <span class="text-success ms-3 fw-medium fade-out">
                                <i class="fas fa-check-circle me-1"></i> Tersimpan.
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Account Form -->
        <div class="card shadow-sm border-0 rounded-4 border-start border-danger border-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold text-danger mb-0"><i class="fas fa-user-times me-2"></i> Hapus Akun</h5>
                <p class="text-muted small mt-1">Setelah akun dihapus, semua data akan hilang secara permanen.</p>
            </div>
            <div class="card-body p-4">
                <button type="button" class="btn btn-outline-danger rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
                    <i class="fas fa-trash-alt me-1"></i> Hapus Akun Saya
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-danger" id="confirmUserDeletionModalLabel">Apakah Anda yakin?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-gray-700">
                    <p>Setelah akun dihapus, semua sumber daya dan data akan dihapus secara permanen. Masukkan password Anda untuk mengonfirmasi.</p>
                    <div class="mt-3">
                        <label for="password_delete" class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @if($errors->userDeletion->has('password')) is-invalid @endif" id="password_delete" name="password" placeholder="Masukkan password Anda..." required>
                        @if($errors->userDeletion->has('password'))
                            <div class="invalid-feedback">{{ $errors->userDeletion->first('password') }}</div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4">Hapus Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Profile Specific Styles */
    .avatar-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
    }
    
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
    
    .input-group:focus-within .input-group-text {
        border-color: #0d6efd;
    }
    
    .fade-out {
        animation: fadeOut 3s forwards;
    }
    
    @keyframes fadeOut {
        0% { opacity: 1; }
        70% { opacity: 1; }
        100% { opacity: 0; display: none; }
    }
</style>
@endpush

@push('scripts')
<script>
    // Open modal automatically if there are validation errors in the deletion form
    @if($errors->userDeletion->isNotEmpty())
        var myModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
        myModal.show();
    @endif
</script>
@endpush
